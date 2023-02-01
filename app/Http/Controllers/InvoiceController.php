<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Invoice;
use App\House;

use App\Jobs\SendSMSNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendEmailNotification;
use App\Jobs\SendPushNotification;
use SEO;

class InvoiceController extends Controller
{
	public function showInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->authorize('send-message', $invoice->reservation);
        SEO::setTitle('شب | فاکتور شماره '.$id);
    	return view('invoice', ['invoice' => $invoice]);
    }

    public function payInvoice($id)
    {
        $user = Auth::user();//User::findOrFail(1);

        $invoice = Invoice::findOrFail($id);
        $this->authorize('pay-invoice', $invoice);
        
        if($invoice->status == 1) #Already paid
            return redirect()->back()->withErrors(['status' => 'این فاکتور قبلا پرداخت شده است.']);

        if($invoice->status == 2) #Expired
            return redirect()->back()->withErrors(['status' => 'این فاکتور منقضی شده است.']);

/*
        if($user->credit < $invoice->total_fee) #change total_fee to prepayment if needed
            return redirect()->back()->withErrors(['status' => 'متأسفانه اعتبار شما کافی نیست.']);
*/

        if($user->credit < $invoice->prepayment)
            return redirect()->back()->withErrors(['status' => 'متأسفانه اعتبار شما کافی نیست.']);

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
        $this->dispatch(new SendSMSNotification(getHostPaidInvoiceSms($reservation), array($invoice->reservation->host->mobile)));
        $this->dispatch(new SendPushNotification('قطعی شدن رزرو',  'میهمان رزرو خود را قطعی کرده است.', [], $reservation->host->push_token));

        #send sms for guest
        $this->dispatch(new SendSMSNotification(getGuestPaidInvoiceSms($reservation), array($invoice->reservation->guest->mobile)));

        #Telegram notification
        $this->dispatch(new SendAdminTelegramNotification('emails.reserve', ['reserve' => $reservation], '#paid پرداخت رزرو شماره '.$reservation->id));

        #notification email for admin
        $this->dispatch(new SendEmailNotification('emails.reserve', ['reserve' => $reservation], 'پرداخت رزرو شماره '.$reservation->id, ['info@shab.ir','security@shab.ir']));

        #TODO: notification email for host
        #TODO: notification email for guest

        #Set Service Desk Status
        $this->dispatch(new \App\Jobs\SetServiceDeskStatus($reservation, 'STATUS_PAID') );
        
        #change the house calandar to full
        setUnavailable($reservation);
        
        #Expire other conflicting reservations
        expireReservations($reservation);
        
        return view('invoice', ['invoice' => $invoice]);
    }

    /**
     * Show payment page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPayment(Request $request, $id)
    {
        $this->validate($request, [
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            #'guests'   => 'required|integer',
            'accomodates'   => 'required|integer',
        ]);

        $house = House::findOrFail($id);
        SEO::setTitle('شب | پیش فاکتور رزرو اقامتگاه کد '.$id);
        return view('payment', ['house' => $house]);
    }

    /**
     * Get total price
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalPrice(Request $request, $id)
    {
        $this->validate($request, [
            'checkin'  => 'required|integer',
            'checkout' => 'required|integer',
            'guests'   => 'required|integer',
        ]);
        $house = House::findOrFail($id);
        return getPrice($request->checkin, $request->checkout, $request->guests, $house);
    }
}
