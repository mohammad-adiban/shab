<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\House;
use App\User;
use App\Photo;
use File;

use Illuminate\Support\Facades\DB;

use JWTAuth;

use Intervention\Image\ImageManagerStatic as Image;
use App\Message;
use App\Reservation;
use App\Jobs\SendEmailNotification;
use App\Jobs\SendPushNotification;
use App\Jobs\SendAdminTelegramNotification;
use App\Jobs\SendSMSNotification;

class UserController extends Controller
{
    public function getProfile($id)
    {
    	$user = JWTAuth::parseToken()->authenticate();
        if(User::findOrFail($id)->id == $user->id)
            return $user;
        else
            return $user->makeHidden(['mobile', 'email', 'credit']);
    }

    public function getTrips(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->validate($request, [
            'status' => 'integer',
        ]);            
        $trips = $user->trips();

        if($request->status)
            $trips = $trips->where('status', $request['status']);

        $trips = $trips->with(array(
                    'house'=>function($query){
                    $query->select('id', 'title', 'province', 'city');
                }, 'invoice'=>function($query){
                    $query->select('id', 'reservation_id', 'status', 'total_fee');
                }, 'host'=>function($query){
                    $query->select('id', 'name', 'family', 'picture');
                }))->orderBy('id', 'desc')->paginate(1000);

        return $trips;
    }
    
    public function getHouses()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $houses = $user->houses()->where('temp', 0)->orderBy('id', 'desc')->paginate(1000);
        return $houses;
    }

    public function updatePicture(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        $this->validate($request, [
            'image' => 'required|image',
            ]);

        File::delete($user->picture);
		$image = $request->image;
        $sha1 = sha1($image->getClientOriginalName()); //for avoiding conflicts
        $image_name = "user-".$user->id."-".date('Y-m-d-h-i-s')."-".$sha1.'.'.$image->guessExtension();
        $relative_path = 'img/users/' . $image_name;
        $user->picture = $relative_path;
        $path = public_path($relative_path);
        //Resize image
        Image::make($image->getRealPath())->resize(400,600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($path);
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->validate($request, [
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            //'mobile' => 'required|numeric|digits:11',
            'email' => 'required|email|max:255',
            'gender' => 'alpha|in:male,female',
            'birthdate' => 'numeric|digits_between:1,20',
            'address'   => 'string|max:255',
            'tel' => 'numeric|digits_between:10,11',
            'cardno' => 'numeric|digits:16',
        ]);

        $user->name      = $request->name;
        $user->family    = $request->family;
        if(isset($request->email))     $user->email     = $request->email;
        //$user->mobile    = $request->mobile;
        if(isset($request->gender))    $user->gender    = $request->gender;
        if(isset($request->tel))       $user->tel       = $request->tel;
        if(isset($request->address))   $user->address   = $request->address;
        if(isset($request->birthdate)) $user->birthdate = $request->birthdate;
        if(isset($request->cardno))    $user->cardno    = $request->cardno;

        $user->save();
        return response()->json(['status' => 'success']);
    }

     /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request, [
            #'oldPassword' => 'required',
            'oldPassword' => 'hash:' . $user->password,
            'newPassword' => 'required|different:oldPassword|min:6|confirmed', #newPassword_confirmation
        ]);

        $user->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();

        return response()->json(['status' => 'success']);
    }

    public function showMyReservations()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $reservations = $user->reservations()->with(array(
                'house'=>function($query){
                $query->select('id', 'title', 'province', 'city');
            }, 'invoice'=>function($query){
                $query->select('id', 'reservation_id', 'status', 'total_fee');
            }, 'guest'=>function($query){
                $query->select('id', 'name', 'family', 'picture');
            }))->orderBy('id', 'desc')->paginate(1000);

        return $reservations;
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:0',
            'text'        => 'required|string|max:2047',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);
        /*
        if ($reservation->guest->id != $user->id && $reservation->host->id != $user->id)
            return response()->json(['status' => 'failed','error' => 'Unauthorized'], 403);
        */
        $user = JWTAuth::parseToken()->authenticate();

        $message = new Message;
        $message->from_user_id = $user->id;
        $message->reservation_id = $reservation->id;
        $message->text = $request['text'];
        $message->save();

        $user->id == $reservation->host_user_id ? $notificant = $reservation->guest : $notificant = $reservation->host;
        $this->dispatch(new SendPushNotification('پیام جدید',  $notificant->name.': '.$request->text, ['message' => 1, 'reservation_id' => $reservation->id, 'text' => $notificant->name.': '.$request->text], $notificant->push_token));
        
        $this->dispatch(new SendAdminTelegramNotification('emails.sms', ['message' => $message, 'reserve' => $reservation], 'ارسال پیام #chat'));
/*
        if($user->id == $reservation->guest_user_id)
            $this->dispatch(new SendSMSNotification("پیام جدیدی در سایت شب دارید\n".($reservation->guest->name).":\n$request->text\nلینک پاسخ:\nshab.ir/reservations/$reservation->id/show", array($reservation->host->mobile) ) );
*/
        
        //$this->dispatch(new SendAdminTelegramNotification('emails.sms', ['text' => $message->text, 'messageid' => $message->id, 'from' => $user->mobile, 'to' => $notificant->mobile], 'ارسال پیام #sms'));

        return response()->json(['status' => 'success']);
    }

    public function getMessages(Request $request)
    {
        $this->validate($request, [
            'reservation' => 'required|integer|min:0',
        ]);
        $reservation = Reservation::findOrFail($request['reservation']);
        $this->authorize('send-message', $reservation);

        $user = JWTAuth::parseToken()->authenticate();
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
        $user = JWTAuth::parseToken()->authenticate();

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

    public function sendFeedback(Request $request)
    {
        $this->validate($request, [
            'feedback' => 'required|string|max:2048',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $this->dispatch(new SendEmailNotification('emails.feedback', ['feedback' => $request->feedback, 'user' => $user], 'بازخورد از اپلیکیشن', ['info@shab.ir','security@shab.ir']));
        return response()->json(['status' => 'success', 'error' => '']);
    }

    public function registerToPushNotification(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|size:152',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $user->push_token = $request->token;
        $user->save();

        return response()->json(['status' => 'success', 'error' => '']);
    }
}
