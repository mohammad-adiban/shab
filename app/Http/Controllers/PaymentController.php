<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Payment;
use App\User;

use Zarinpal\Laravel\Facade\Zarinpal;
use Log;
use SEO;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle('شب | امور مالی ');
        $user = Auth::user();
        return view('userpanel.payments', ['payments' => $user->payments->where('verified',1)]);
    }

    public function showChargeCredit($trackid)
    {
        $payment = Payment::where('tracking', $trackid)->firstOrFail();
        return view('charge_credit', ['payment' => $payment]);
    }

    public function chargeCredit(Request $request)
    {
        $this->validate($request, [
            'credit' => 'required|integer|min:1|max:100000',
            'invoice' => 'required|integer',
            'pgw' => 'required|integer',
        ]);

        $user = Auth::user();

        $invoice = \App\Invoice::findOrFail($request->invoice);
        $this->authorize('pay-invoice', $invoice);
        
        if($invoice->status == 1) #Already paid
            return redirect()->back()->withErrors(['status' => 'این فاکتور قبلا پرداخت شده است.']);

        if($invoice->status == 2) #Expired
            return redirect()->back()->withErrors(['status' => 'این فاکتور منقضی شده است.']);

/*
        if($user->credit < $invoice->total_fee) #change total_fee to prepayment if needed
            return redirect()->back()->withErrors(['status' => 'متأسفانه اعتبار شما کافی نیست.']);
*/

        #Preventing duplicate request with same orderId in Beh Pardakht GW
        /*$old_payment = Payment::where('invoice_id', $request->invoice)->where('payment_gw', 1)->where('payment_gw', $request->pgw)->where('user_id', $user->id)->first();
        if(!is_null($old_payment))
            return response()->json([
                'status' => 'success',
                'url'  =>$old_payment->url
            ],200);
        */

        $trackid = random_str(20, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        switch ($request->pgw) {
            case 1:
                #Beh Pardakht Mellat
                $result = bpPayRequest($request->invoice, ($request->credit)*10000, '', "https://www.shab.ir/api/v1/payments/$trackid/verify?pgw=1&invoice=$request->invoice");
                break;
            case 2:
                #Zarinpal
                $result = Zarinpal::request("http://www.shab.ir/api/v1/payments/$trackid/verify?pgw=2&invoice=$request->invoice", $request['credit']*1000, "افزایش اعتبار برای $user->name $user->family عزیز");
                break;
            default:
                return response()->json([
                    'status' => 'failed',
                    'error'  => 'Unknown GW'
                    ],400);
        }

        if(($request->pgw == 1 && $result == 'error') || ($request->pgw == 2 && is_null($result['Authority']))) 
            return response()->json([
                'status' => 'failed',
                'error'  => 'Connecting to payment server failed'
            ],400);
        
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->amount = $request['credit'];
        $payment->tracking = $trackid;
        switch ($request->pgw) {
            case 1:
                #Beh Pardakht Mellat
                $payment->url = $result;
                $payment->payment_gw = 1;
                break;
            case 2:
                #Zarinpal
                $payment->url = $result['Authority'];
                $payment->payment_gw = 2;
                break;
            default:
                return response()->json([
                    'status' => 'failed',
                    'error'  => 'Payment verification error!'
                    ],400);
        }

        if($request['invoice'] != -1)
            $payment->invoice_id = $request['invoice'];

        $payment->save();

        return response()->json([
                'status' => 'success',
                'url'  => $result
            ],200);
    }

    public function verifyChargePayment(Request $request, $trackid)
    {
        $this->validate($request, [
            'invoice' => 'required|integer',
            'pgw' => 'required|integer',
        ]);

        $payment = Payment::where('tracking', $trackid)->firstOrFail();
        if($payment->verified == 1)
            return view('verify_credit', ['payment' => $payment, 'status' => 'success']);

        if(($request->pgw == 1 && $request['ResCode'] == '0') || ($request->pgw == 2 && $request['Status'] == 'OK')) 
        {
            switch ($request->pgw) {
                case 1:
                    #Beh Pardakht Mellat
                    if($request['ResCode'] == '0')
                        $result = bpVerifyRequest($request->SaleOrderId, $request->SaleReferenceId);    
                    break;
                case 2:
                    #Zarinpal
                    if($request['Status'] == 'OK')
                        $result = Zarinpal::verify('OK', $payment->amount*1000, $request['Authority']);
                    break;
                default:
                    return response()->json([
                        'status' => 'failed',
                        'error'  => 'Unknown GW'
                        ],400);
                    break;
            }    
            
            if(($request->pgw == 1 && $result == 'success') || ($request->pgw == 2 && $result['Status'] == 'success')) 
            {
                #change verified state to 1 and save ref-id
                $payment->verified = 1;
                $payment->transaction = $request['SaleReferenceId'];
                $payment->order_id = $request['SaleOrderId'];
                $payment->save();

                $user = User::findOrFail($payment->user_id);
                $user->credit += $payment->amount;
                $user->save();

                if($request['invoice'] != -1){
                    $invoice = \App\Invoice::findOrFail($request->invoice);
                    if($user->credit < $invoice->prepayment)
                        return view('invoice', ['invoice' => $invoice, 'status' => 'failed', 'error' => 'Low Credit']);

                    $this->payInvoice($invoice);
                    return redirect("/invoices/$request->invoice/show");
                }
                    
                //return view('verify_credit', ['payment' => $payment, 'status' => 'success']);
            }
            else
                return view('verify_credit', ['payment' => $payment, 'status' => 'failed', 'error' => 'Transaction not verified']);
        }
        else{
            //$payment->delete();
            return view('verify_credit', ['payment' => $payment, 'status' => 'failed', 'error' => 'Transaction canceled by user']);
        }
    }

    function payInvoice($invoice)
    {
        $user = Auth::user();//User::findOrFail(1);

//      $user->credit -= $invoice->total_fee;
        $user->credit -= $invoice->prepayment;
        $user->save();

        #TODO: increase host credit
        
        #change verified state to 1 and save ref-id
        $invoice->status = 1;
        $invoice->save();

        $reservation = $invoice->reservation;
        $reservation->status = 3; #verified state
        $reservation->save();
        
        #send sms for host
        $this->dispatch(new \App\Jobs\SendSMSNotification(getHostPaidInvoiceSms($reservation), array($invoice->reservation->host->mobile)));
        $this->dispatch(new \App\Jobs\SendPushNotification('قطعی شدن رزرو',  'میهمان رزرو خود را قطعی کرده است.', [], $reservation->host->push_token));

        #send sms for guest
        $this->dispatch(new \App\Jobs\SendSMSNotification(getGuestPaidInvoiceSms($reservation), array($invoice->reservation->guest->mobile)));

        #Telegram notification
        $this->dispatch(new \App\Jobs\SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], '#paid پرداخت رزرو شماره '.$reservation->id));

        #notification email for admin
        $this->dispatch(new \App\Jobs\SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'پرداخت رزرو شماره '.$reservation->id, ['info@shab.ir','security@shab.ir']));

        #TODO: notification email for host
        #TODO: notification email for guest

        #Set Service Desk Status
        $this->dispatch(new \App\Jobs\SetServiceDeskStatus($reservation, 'STATUS_PAID') );
        
        #change the house calandar to full
        setUnavailable($reservation);
        
        #Expire other conflicting reservations
        expireReservations($reservation);        
    }

}
