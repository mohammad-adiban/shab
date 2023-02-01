<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Log;
use UrlShortener;

use App\Jobs\SendSMSNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    protected $redirectTo = '/dashboard';
    
    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param \Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkSMS(Request $request)
    {
        $this->validate($request, [
            'mobile'  => 'required|digits:11|exists:users,mobile,mobile,NOT_NULL',
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        $password_broker = app(PasswordBroker::class);
        $token = $password_broker->createToken($user);

        try {
            $short_link = UrlShortener::shorten(url('password/reset/sms/'.$token.'?mobile='.$request['mobile']));
        }
        catch (\Exception $e) {
            Log::info($e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                'status' => 'failed',
                'error'  => 'ارسال لینک بازیابی کلمه عبور با مشکل مواجه شد. لطفا چند دقیقه دیگر تلاش کنید.'
                ],500);
            }
            return redirect()->back()->with('status', 'ارسال لینک بازیابی کلمه عبور با مشکل مواجه شد. لطفا چند دقیقه دیگر تلاش کنید.');    
        }

        $this->dispatch(new SendSMSNotification('لینک تغییر پسورد شما در سایت شب: '.$short_link."\r\nدر صورتی که شما چنین درخواستی نداشته اید،این پیام را نادیده بگیرید." , array($user->mobile)));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
            'status' => 'success',
            'error'  => ''
            ],200);
        }
        
        return redirect()->back()->with('status', 'لینک تغییر کلمه عبور با موفقیت برای شما پیامک شد.');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestFormMobile()
    {
        return view('auth.passwords.mobile');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetFormMobile(Request $request, $token = null)
    {
        if (is_null($token)) {
            return redirect('/');
        }

        $mobile = $request->input('mobile');

        return view('auth.passwords.reset_sms')->with(compact('token', 'mobile'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetMobile(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'mobile' => 'required|digits:11',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials =  $request->only(
            'mobile', 'password', 'password_confirmation', 'token'
        );

        $broker = property_exists($this, 'broker') ? $this->broker : null;

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();

            Auth::guard($this->getGuard())->login($user);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return $this->getResetSuccessResponse($response);
            default:
                return redirect()->back()
                    ->withInput($request->only('mobile'))
                    ->withErrors(['mobile' => trans($response)]);
        }
    }
}
