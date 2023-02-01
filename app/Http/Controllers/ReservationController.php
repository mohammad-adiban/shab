<?php

namespace App\Http\Controllers;

use App\Jobs\SetServiceDeskStatus;
use Illuminate\Http\Request;

use App\Jobs\SendPushNotification;
use App\Jobs\SendSMSNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendEmailNotification;

use App\Reservation;
use App\House;

use Auth;
use Log;
use SEO;

class ReservationController extends Controller
{
    public function showReservation($id)
    {
    	$reservation = Reservation::findOrFail($id);
        $this->authorize('send-message', $reservation);
        SEO::setTitle('شب | جزئیات رزرو شماره '.$id);

    	return view('reservation', ['reservation' => $reservation]);
    }

    public function acceptReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $this->authorize('response-reservation', $reservation);

        #check reservation status
        if($reservation->status != 0)
            response()->json([
            'status' => 'failed',
            'error'  => 'Invalid reservation.'],
            400);

        #set reservation status
        $reservation->status = 1;
        $reservation->save();

        #Set Service Desk Status
        $this->dispatch(new \App\Jobs\SetServiceDeskStatus($reservation, 'STATUS_ACCEPT') );

        #Push to guest
        $this->dispatch(new SendPushNotification('تأیید رزرو',  'رزرو شما از سمت میزبان مورد تأیید قرار گرفته است.', ['trip' => 1], $reservation->guest->push_token));

        #SMS to guest
        $guest = $reservation->guest;
        $this->dispatch(new SendSMSNotification(getGuestAcceptReservationSms($reservation), array($guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'تایید درخواست رزرو توسط مالک #reserve'));

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    public function rejectReservation($id)
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

        setUnavailable($reservation);

        #Set Service Desk Status
        $this->dispatch(new SetServiceDeskStatus($reservation, 'STATUS_REJECT') );

        #Guest notifications
        $this->dispatch(new SendPushNotification('رد رزرو',  'میزبان درخوست رزرو شما را رد کرده است.', ['trip' => 1], $reservation->guest->push_token));

        #SMS to guest
        $this->dispatch(new SendSMSNotification(getGuestUnavailableSms($reservation), array($reservation->guest->mobile)));

        #Email to Admin
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'رد درخواست رزرو توسط مالک #reserve'));

        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    public function cancelReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if($user->id == $reservation->guest->id)
            $result = $this->cancelReservationByGuest($reservation);
        else
            $result = $this->cancelReservationByHost($reservation);

        if($result != 0)
            return response()->json([
            'status' => 'failed',
            'error'  => 'Operation failed!'],
            400);
        
        return response()->json([
            'status' => 'success',
            'error'  => ''
        ],200);
    }

    function cancelReservationByHost($reservation)
    {
        $this->authorize('response-reservation', $reservation);

        #set reservation status
        //$reservation->status = 6;
        //$reservation->save();

        if($reservation->invoice->status == 1)
        {
            #TODO: return credit
            #TODO: change invoice state

            #Admin Telegram notif
            $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'درخواست لغو رزرو پرداخت شده از طرف میزبان #reserve'));
        }
        else
        {
            #Admin Telegram notif
            $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'درخواست لغو رزرو از طرف میزبان #reserve'));
        }

        #Guest Push notif
        //$this->dispatch(new SendPushNotification('لغو درخوسات رزرو',  'میزبان شما درخوست رزرو شما را لغو کرده است.', ['trip' => 1], $reservation->guest->push_token));

        #Guest SMS notif
        //$guest = $reservation->guest;
        //$this->dispatch(new SendSMSNotification("$guest->name $guest->family عزیز، درخواست رزرو شما از سمت میزبان لغو شده است.", array($guest->mobile)));

        return 0;
    }

    function cancelReservationByGuest($reservation)
    {
        $this->authorize('guest-reservation', $reservation);
        #set reservation status
        $reservation->status = 5;
        $reservation->save();

        if($reservation->invoice->status == 1)
        {
            #TODO: return credit
            #TODO: change invoice state

            #Admin Telegram notif
            $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'درخواست لغو رزرو پرداخت شده از طرف میهمان #reserve'));
        }
        else
        {
            #Admin Telegram notif
            $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'لغو رزرو از طرف میهمان #reserve'));
        }

        #Host Push notif
        $this->dispatch(new SendPushNotification('لغو درخوسات رزرو',  'میهمان شما درخوست رزرو خود را لغو کرده است.', ['reserve' => 1], $reservation->host->push_token));

        #Host SMS notif
        $this->dispatch(new SendSMSNotification(getHostCancelReservationSms($reservation), array($reservation->host->mobile)));

        #Set Service Desk Status
        $this->dispatch(new \App\Jobs\SetServiceDeskStatus($reservation, 'STATUS_GUEST_CANCEL') );

        return 0;
    }

    public function reserveByTel(Request $request, $id)
    {
        $this->validate($request, [
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            #'guests'   => 'required|integer',
            'accomodates'   => 'required|integer',
        ]);

        $user = Auth::user();
        $house = House::findOrFail($id);

        #TODO:check not reserve my own house

        #check calendar, disabled, unavailable
        if(!isBookable($house))
            return redirect()->back()->with('status', 'امکان رزرو این خانه وجود ندارد.');

        if(!isAvailable($house, $request['checkin'], $request['checkout']))
            return redirect()->back()->with('status', 'امکان رزرو در بازه زمانی درخواستی وجود ندارد.');

        if($request->accomodates > $house->max_accommodates)
            return redirect()->back()->with('status', 'تعداد میهمانان بیش از ظرفیت خانه است.');

        if($user->trips()->where('status', 0)->whereDate('created_at', '=', date('Y-m-d'))->count() > 5)
            return redirect()->back()->with('status', 'حداکثر درخواست رزرو روزانه شما به سر رسیده است.');
        
        #Check duplicate reserve request
        if($user->trips()->where('house_id', $house->id)->where('checkin',$request['checkin'])->where('checkout', $request['checkout'])->where('guests', $request['accomodates'])->where('status', 0)->whereDate('created_at', '=', date('Y-m-d'))->count() > 0)
            return redirect()->back()->with('status', 'درخواست رزرو شما قبلا در سامانه ثبت شده است.');

        $duration = intval(($request->checkout - $request->checkin) / 86400);
        if($duration < $house->rule_minimum_days)
            return redirect()->back()->with('status', 'تعداد روز رزرو شما کمتر از حداقل روز رزرو است.');

        $reservation = new Reservation;
        $reservation->checkin       = $request->checkin;
        $reservation->checkout      = $request->checkout;
        #$reservation->guests        = $request->accommodates;
        $reservation->guests        = $request->accomodates;
        $reservation->verified      = 0;

        $reservation->guest_user_id = $user->id;
        $reservation->host_user_id  = $house->user->id;
        $reservation->house_id      = $house->id;
        $reservation->save();

        $invoice = invoice($reservation);
        $invoice->save();

        $reservation->invoice_id = $invoice->id;
        $reservation->save();

        #SMS to host
        $this->dispatch(new SendSMSNotification(getHostReservationSms($reservation), array($reservation->host->mobile)));

        #SMS to guest
        $this->dispatch(new SendSMSNotification(getGuestReservationSms($reservation), array($reservation->guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو #reserve'));

        #Email to admins
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'ثبت درخواست رزرو', ['info@shab.ir','security@shab.ir']));

        #Push notification to host
        $push_token = $reservation->host->push_token;
        if(!is_null($push_token))
            $this->dispatch(new SendPushNotification('درخواست رزرو', 'یک درخواست رزرو برای شما آمده است.', ['reserve' => 1], $push_token));

        #Send to the service desk
        //$this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'Reservation #'.$reservation->id, ['jira@shab.ir']));
        $this->dispatch(new \App\Jobs\AddServiceDeskIssue($reservation) );

	    return redirect()->route('trips')->with('status', 'OK');
    }

    public function reserve(Request $request, $id)
    {
        $this->validate($request, [
            'checkout' => 'required|integer',
            #'guests'   => 'required|integer',
            'accomodates'   => 'required|integer',
        ]);

        $user = Auth::user();
        $house = House::findOrFail($id);
        
        #check calendar: disabled, unavailable
        if(!isAvailable($house, $request['checkin'], $request['checkout']))
            return redirect()->back()->with('status', 'Not available for this date');

        if($request->accomodates > $house->max_accommodates)
            return redirect()->back()->with('status', 'The accommodates of this house is not enough');

        #get authority id from payment server
        $fee = intval(getPrice($request->checkin, $request->checkout, $request->accomodates, $house) / 5) * 1000;
        #$fee = 100;

        $result = Zarinpal::request("http://www.shab.ir/payment/zarinpal/verify", $fee, $house->title);

        if(is_null($result['Authority']))
            return redirect()->back()->with('status', 'Connecting to payment server failed');

        $reservation = new Reservation;
        $reservation->checkin       = $request->checkin;
        $reservation->checkout      = $request->checkout;
        #$reservation->guests        = $request->accommodates;
        $reservation->guests        = $request->accomodates;
        $reservation->authority     = $result['Authority'];
        $reservation->fee           = $fee;
        $reservation->verified      = 0;

        $reservation->guest_user_id = $user->id;
        $reservation->host_user_id  = $house->user->id;
        $reservation->house_id      = $house->id;

        $reservation->save();

        #Telegram notification
        //sendToTelegram('emails.reserve', ['reserve' => $reservation], 'ورود به مرحله پرداخت');
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], 'ورود به مرحله پرداخت'));


        #Email to admins
        /*
        Mail::send('emails.reserve', ['reserve' => $reservation], function ($message) {
            $message->subject('ورود به مرحله پرداخت');
            $message->from('automated@shab.ir', 'Shab.ir');
            #$message->to(['info@shab.ir','security@shab.ir']);
            $message->to(['security@shab.ir']);
        });
        */
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'ورود به مرحله پرداخت', ['info@shab.ir','security@shab.ir']));

        #$user->reservations()->save($reservation);
        #$user->trips()->save($reservation);
        #$house->houses()->save($reservation);

        return redirect('https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
    }
}
