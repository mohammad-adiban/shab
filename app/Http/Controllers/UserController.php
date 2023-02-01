<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Log;

use Hash;

use Intervention\Image\ImageManagerStatic as Image;

use File;
use SEO;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        SEO::setTitle('مشخصات من - سایت شب');
        return view('userpanel',['page' => 'profile', 'user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            //'mobile' => 'required|numeric|digits:11',
            'email' => 'email|max:255',
            'gender' => 'alpha|in:male,female',
            'birthdate' => 'numeric|digits_between:1,20',
            'address'   => 'string|max:255',
            'tel' => 'numeric|digits_between:10,11',
            'cardno' => 'numeric|digits:16',
        ]);

        $user->name      = $request->name;
        $user->family    = $request->family;
        //$user->email     = $request->email;
        //if(isset($request->mobile)) $user->mobile    = $request->mobile;
        if(isset($request->email)) $user->email    = $request->email;
        if(isset($request->gender)) $user->gender    = $request->gender;
        if(isset($request->tel)) $user->tel = $request->tel;
        if(isset($request->address)) $user->address = $request->address;
        if(isset($request->birthdate)) $user->birthdate = $request->birthdate;
        if(isset($request->cardno)) $user->cardno = $request->cardno;

        $user->save();
        return redirect()->route('profile')->with('status', '1000');
    }

     /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            #'oldPassword' => 'required',
            'oldPassword' => 'hash:' . $user->password,
            'newPassword' => 'required|different:oldPassword|min:6|confirmed', #newPassword_confirmation
        ]);

        $user->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();
/*
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();
        } else
            redirect()->back()->with('error-message', 'Your old password is wrong!');
*/
        return redirect()->route('security')->with('status', '1000');            
    }


    public function showDashboard()
    {
        $user = Auth::user();
        SEO::setTitle('پیشخوان - سایت شب');
        return view('userpanel',['page' => 'dashboard', 'user' => $user]);
    }

    public function showMyReservations()
    {
        $reservations = Auth::user()->reservations()->orderBy('id', 'desc')->paginate(1000);
        /*
        $reservations = Auth::user()->reservations()->with(array(
                'house'=>function($query){
                $query->select('id', 'title', 'province', 'city');
            }, 'invoice'=>function($query){
                $query->select('id', 'reservation_id', 'status', 'total_fee');
            }, 'guest'=>function($query){
                $query->select('id', 'name', 'family', 'picture');
            }))->orderBy('id', 'desc')->paginate(20);
        */
        SEO::setTitle('درخواست‌های رزرو من - سایت شب');
        return view('userpanel',['page' => 'myreservations', 'reservations' => $reservations]);
    }

    public function changePassword()
    {
        SEO::setTitle('تغییر کلمه عبور - سایت شب');
    	return view('userpanel', ['page' => 'account']);
    }

    public function showTrips()
    {
        #$trips = Auth::user()->trips()->where('verified', 1)->get();
        SEO::setTitle('سفرهای من - سایت شب');
        $trips = Auth::user()->trips()->whereNotNull('invoice_id')->orderBy('id', 'desc')->paginate(10);
        return view('userpanel', ['page' => 'trips', 'trips' => $trips]);
    }

    public function updatePicture(Request $request)
    {
        $user = Auth::user();

        if(isset($request->picture))
        {       
                File::delete($user->picture);
        		$image = $request->picture;
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
                return redirect()->route('dashboard')->with('status', '1000');
        }
    }
}
