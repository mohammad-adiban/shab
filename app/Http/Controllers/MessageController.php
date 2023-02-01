<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Message;
use App\Reservation;
use App\Jobs\SendPushNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendSMSNotification;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:0',
            'text'        => 'required|string|max:2047',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);
        $user = Auth::user();

        $message = new Message;
        $message->from_user_id = $user->id;
        $message->reservation_id = $reservation->id;
        $message->text = $request['text'];
        $message->save();

        $user->id == $reservation->host_user_id ? $notificant = $reservation->guest : $notificant = $reservation->host;
        $this->dispatch(new SendPushNotification('پیام جدید',  $notificant->name.': '.$request->text, [], $notificant->push_token));
/*
        if($user->id == $reservation->guest_user_id)
            $this->dispatch(new SendSMSNotification("پیام جدیدی در سایت شب دارید\n".($reservation->guest->name).":\n$request->text\nلینک پاسخ:\nshab.ir/reservations/$reservation->id/show", array($reservation->host->mobile) ) );
*/
        #Admin Notif
        //$this->dispatch(new SendAdminTelegramNotification('emails.sms', ['text' => $message->text, 'messageid' => $message->id, 'from' => $user->mobile, 'to' => $notificant->mobile], 'ارسال پیام #sms'));
        $this->dispatch(new SendAdminTelegramNotification('emails.sms', ['message' => $message, 'reserve' => $reservation], 'ارسال پیام #chat'));

        return response()->json(['status' => 'success']);
    }

    public function getMessages(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:0',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);

        $user = Auth::user();
        $messages = Message::where('reservation_id', $reservation->id)->orderBy('id', 'desc')->paginate(30);
        return $messages;
    }

    public function markAsSeen(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:0',
            'messages' => 'required',
        ]);

        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);
        $user = Auth::user();

        $messages = $request->messages;
        if (!is_array($messages)) {
            $messages = explode(',', $messages);
            if (sizeof($messages) > 30) { #Check array size for security reasons
                return response()->json([
                    'status' => 'failed',
                    'error'  => 'Number of messages is too high!'], 400);
            }
        }

        foreach ($messages as $msg_id){
            $message = Message::findOrFail($msg_id);
            if($user->id != $message->from_user_id){
                $message->seen = true;
                $message->save();                
            }
        }
        return response()->json(['status' => 'success']);
    }
}
