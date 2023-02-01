<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\House;
use App\User;

use JWTAuth;

use App\Reservation;
use App\Invoice;
use App\Payment;
use Zarinpal\Laravel\Facade\Zarinpal;

use Log;

use App\Jobs\SendEmailNotification;
use App\Jobs\SendSMSNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendPushNotification;
use App\Jobs\SetServiceDeskStatus;

class ReservationController extends Controller
{
    public function showReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('send-message', $reservation);
        if($reservation->invoice && $reservation->invoice->status == 1)
            //return Reservation::with('house', 'host', 'guest')->where('id', $id)->first();
            return Reservation::with(array(
                'house'=>function($query){
                $query->select('id', 'title', 'province', 'city', 'address', 'latitude', 'longitude');
            }, 'host'=>function($query){
                $query->select('id', 'name', 'family', 'mobile', 'email', 'picture');
            }, 'guest'=>function($query){
                $query->select('id', 'name', 'family', 'mobile', 'email', 'picture');
            }))->where('id', $id)->first();
        else
            //return Reservation::with('house')->where('id', $id)->first();
            return Reservation::with(array(
                'house'=>function($query){
                $query->select('id', 'title', 'province', 'city');
            }, 'host'=>function($query){
                $query->select('id', 'name', 'family', 'picture');
            }, 'guest'=>function($query){
                $query->select('id', 'name', 'family', 'picture');
            }))->where('id', $id)->first();
    }

    public function showChargeCredit($trackid)
    {
        $payment = Payment::where('tracking', $trackid)->firstOrFail();
        return view('charge_credit', ['payment' => $payment]);
    }

    public function reserve(Request $request, $id)
    {
        $this->validate($request, [
            //'checkin'  => 'required|date|after:yesterday',
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            //'checkout' => 'required|date|after:checkin',
            'guests'   => 'required|integer',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $house = House::findOrFail($id);

        #TODO:check not reserve my own houses

        #check temp, disabled
        if(!isBookable($house))
            return response()->json([
                'status' => 'failed',
                'error'  => 'Disabled house'
            ]);

        #Check duplicate reserve request
        if($user->trips()->where('house_id', $house->id)->where('checkin',$request['checkin'])->where('checkout', $request['checkout'])->where('guests', $request['accomodates'])->where('status', 0)->whereDate('created_at', '=', date('Y-m-d'))->count() > 0)
           return response()->json([
                'status' => 'failed',
                'error'  => 'Duplicate reserve request'
            ]);

        if($user->trips()->where('status', 0)->whereDay('created_at', '=', date('d'))->count() > 5)
            return response()->json([
                'status' => 'failed',
                'error'  => 'Your maximum requests per day exceeeds the limit!'
            ]);

        #check calendar: disabled, unavailable
        if(!isAvailable($house, $request['checkin'], $request['checkout']))
           return response()->json([
                'status' => 'failed',
                'error'  => 'Unavailable days'
            ]);

        if($request->guests > $house->max_accommodates)
            return response()->json([
                'status' => 'failed',
                'error'  => 'The accommodates of this house is not enough'
            ]);

        $duration = intval(($request->checkout - $request->checkin) / 86400);
        if($duration < $house->rule_minimum_days)
            return response()->json([
                'status' => 'failed',
                'error'  => 'Your reserve duration is less than minimum reserve days'
            ]);

        $reservation = new Reservation;
        $reservation->checkin       = $request->checkin;
        $reservation->checkout      = $request->checkout;
        $reservation->guests        = $request->guests;
        $reservation->guest_user_id = $user->id;
        $reservation->host_user_id  = $house->user->id;
        $reservation->house_id      = $house->id;
        $reservation->save();

        $invoice = invoice($reservation);
        $invoice->save();

        $reservation->invoice_id = $invoice->id;
        $reservation->save();

        #SMS to guest
        $this->dispatch(new SendSMSNotification(getGuestReservationSms($reservation), array($reservation->guest->mobile)));

        #SMS to host
        $this->dispatch(new SendSMSNotification(getHostReservationSms($reservation), array($reservation->host->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو از اپلیکیشن #reserve'));

        #Email to admins
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو از اپلیکیشن', ['info@shab.ir','security@shab.ir']));

        #Push notification to host
        $push_token = $reservation->host->push_token;
        if(!is_null($push_token))
            $this->dispatch(new SendPushNotification('درخواست رزرو', 'یک درخواست رزرو برای شما آمده است.', ['reserve' => 1], $push_token));

        #Send to the service desk
        //$this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'Reservation #'.$reservation->id, ['jira@shab.ir']));
        $this->dispatch(new \App\Jobs\AddServiceDeskIssue($reservation) );


        return response()->json(['status' => 'success']);
    }

    public function acceptReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('response-reservation', $reservation);

        #check reservation status
        if($reservation->status != 0)
            return response()->json([
            'status' => 'failed',
            'error'  => 'Invalid reservation.'],
            400);

        #set reservation status
        $reservation->status = 1;
        $reservation->save();

        #Push notifications to guest
        $this->dispatch(new SendPushNotification('تأیید رزرو',  'رزرو شما از سمت میزبان مورد تأیید قرار گرفته است.', ['trip' => 1], $reservation->guest->push_token));
        
        #SMS to guest
        $guest = $reservation->guest;
        $this->dispatch(new SendSMSNotification(getGuestAcceptReservationSms($reservation), array($guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'تایید درخواست رزرو توسط مالک از اپلیکیشن #reserve'));

        $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_ACCEPT') );

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    public function rejectReservationByHost($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('response-reservation', $reservation);

        #check reservation status
        if($reservation->status != 0)
            return response()->json([
            'status' => 'failed',
            'error'  => 'Invalid reservation.'],
            400);

        #set reservation status
        $reservation->status = 2;
        $reservation->save();

        #TODO: send notifications
        $this->dispatch(new SendPushNotification('رد رزرو',  'میزبان درخوست رزرو شما را رد کرده است.', ['trip' => 1], $reservation->guest->push_token));

        #SMS to guest
        $guest = $reservation->guest;
        $this->dispatch(new SendSMSNotification(getGuestUnavailableSms($reservation), array($guest->mobile)));

        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'رد درخواست رزرو توسط مالک از اپلیکیشن #reserve'));

        $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_REJECT') );

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    public function showReservePreview(Request $request, $id)
    {
        $this->validate($request, [
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            'guests'   => 'required|integer',
        ]);
        $house = House::findOrFail($id);

        return getFactor($request->checkin, $request->checkout, $request->guests, $house);
    }

    public function showProformaInvoice(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:1',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);
        $invoice = invoice($reservation);
        return $invoice->toJson();
    }

    public function showInvoice(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:1',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);
        return $reservation->invoice->toJson();
    }

    public function payInvoice($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $invoice = Invoice::findOrFail($id);
        $this->authorize('pay-invoice', $invoice);
        
        if($user->credit < $invoice->total_fee)
            return response()->json([
                'status' => 'failed',
                'error'  => 'Not enough credit'
            ],400);

        $user->credit -= $invoice->total_fee;
        $user->save();
        
        #change verified state to 1 and save ref-id
        $invoice->status = 1;
        $invoice->save();

        $reservation = $invoice->reservation;
        $reservation->status = 3; #verified state
        $reservation->save();

        #send sms for host
        $this->dispatch(new SendSMSNotification(getHostPaidInvoiceSms($reservation), array($reservation->host->mobile)));

        #send sms for guest
        $this->dispatch(new SendSMSNotification(getGuestPaidInvoiceSms($reservation), array($reservation->guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'پرداخت رزرو از اپلیکیشن'));

        #notification email for admin
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'پرداخت رزرو از اپلیکیشن', ['info@shab.ir','security@shab.ir']));

        #TODO: notification email for host
        #TODO: notification email for guest

        $this->dispatch(new SendPushNotification('قطعی شدن رزرو',  'رزرو شما با موفقیت قطعی شد.', ['trip' => 1], $reservation->guest->push_token));

        $this->dispatch(new SendPushNotification('قطعی شدن رزرو',  'میهمان رزرو خود را قطعی کرده است.', ['reserve' => 1], $reservation->host->push_token));

        #Set Service Desk Status
        $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_PAID') );

        #change the house calandar to full
        setUnavailable($invoice->reservation);
        return response()->json([
                    'status' => 'success',
                    'error'  => ''
                ],200);
    }

    public function chargeCredit(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [
            'credit' => 'required|integer|min:1|max:100000',
        ]);

        $trackid = random_str(20, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $result = Zarinpal::request("http://www.shab.ir/api/v1/payments/$trackid/verify/app", $request['credit']*1000, "افزایش اعتبار برای $user->name $user->family عزیز");

        if(is_null($result['Authority']))
            return response()->json([
                'status' => 'failed',
                'error'  => 'Connecting to payment server failed'
            ],400);

        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->amount = $request['credit'];
        $payment->tracking = $trackid;
        $payment->payment_gw = 2;
        $payment->url = 'https://www.zarinpal.com/pg/StartPay/'.$result['Authority'];
        $payment->save();

        return response()->json([
                'status' => 'success',
                'url'  => "http://www.shab.ir/api/v1/payments/$trackid/show"
            ],200);
    }

    public function verifyPayment(Request $request, $trackid)
    {
        $payment = Payment::where('tracking', $trackid)->firstOrFail();

        if($request['Status'] == 'OK')
        {
            if($payment->verified == 1)
                return view('verify_credit', ['payment' => $payment, 'status' => 'success']);

            $result = Zarinpal::verify('OK', $payment->amount*1000, $request['Authority']);
            
            if($result['Status'] == 'success')
            {
                #change verified state to 1 and save ref-id
                $payment->verified = 1;
                $payment->transaction = $result['RefID'];
                $payment->save();

                $user = User::findOrFail($payment->user_id);
                $user->credit += $payment->amount;
                $user->save();
            
                return view('verify_credit', ['payment' => $payment, 'status' => 'success']);
            }
            else
                return view('verify_credit', ['payment' => $payment, 'status' => 'failed', 'error' => 'Transaction not verified']);
        }
        else{
            //$payment->delete();
            return view('verify_credit', ['payment' => $payment, 'status' => 'failed', 'error' => 'Transaction canceled by user']);
        }
    }

}
