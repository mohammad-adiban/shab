<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Jobs\SendSMSNotification;

class AuthController extends Controller
{
    /**
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogin(Request $request)
    {
        $credentials = $request->only('mobile', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $id = User::where('mobile', $credentials['mobile'])->first()->id;
        return response()->json(compact('id','token'));
    }

    /**
     * @param \Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['status' => 'success', 'error' => '']);
    }

    public function getRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'mobile' => 'required|numeric|digits:11|unique:users',
            'email' => 'email|max:255',
            'password' => 'required|min:6|confirmed',
            'gender' => 'in:male,female',
            'birthdate' => 'integer',
            //'verify_code' => 'required|numeric|digits:5|verification:mobile',
        ]);

        $user = new User;
        $user->name = $request->input('name');
        $user->family = $request->input('family');
        $user->mobile = $request->input('mobile');
        $user->gender = $request->input('gender');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $id = $user->id;
        $token = JWTAuth::attempt($request->only('mobile', 'password'));
        
        $this->dispatch(new SendSMSNotification(getWelcomeSms() , array($request['mobile'])));

        return response()->json(compact('id', 'token'));
    }
}
