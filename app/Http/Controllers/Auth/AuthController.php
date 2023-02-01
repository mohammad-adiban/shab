<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerificationCode;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use Log;
use Session;
use Redirect;
use Auth;
use JWTAuth;
use Carbon\Carbon;

use App\Jobs\SendSMSNotification;
use App\Jobs\SendActivationCode;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $username = 'mobile';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'        => 'required|max:255',
            'family'      => 'required|max:255',
            'mobile'      => 'required|numeric|digits:11|unique:users',
            'email'       => 'email|max:255',
            'password'    => 'required|min:6|confirmed',
            'verify_code' => 'required|verification:mobile',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->dispatch(new SendSMSNotification(getWelcomeSms() , array($data['mobile'])));

        $this->redirectTo = ($url = Session::get('url.intended')) ? $url : '/';
        Session::forget('url.intended');

        return User::create([
            'name' => $data['name'],
            'family' => $data['family'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'failed', 'errors' => $validator->errors()->toArray()], 400);
            }
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'intended_url' => $this->redirectPath(), 'error' => '']);
        }

        return redirect($this->redirectPath());
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'intended_url' => Session::get('url.intended', url('/')), 'error' => '']);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'failed', 'error' => 'invalid_credentials'], 401);
        }

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    public function sendCode(Request $request)
    {
        $this->validate($request, [
            'mobile'  => 'required|numeric|digits:11',
        ]);

        if(User::where('mobile', $request['mobile'])->exists())
            return response()->json(['status' => 'failed', 'error' => 'این شماره قبلا ثبت نام کرده است.']);

        $expiration = Carbon::now()->subMinutes(5); #Verification code expires after 5 minutes

        $existing_code = VerificationCode::where('mobile',$request['mobile'])->where('created_at', '>=', $expiration->toDateTimeString())->first();

        if(!empty($existing_code))
            $verification_code = $existing_code->code;
        else
        {
            $verification_code = random_str(5, '0123456789');
            $vcode = new VerificationCode;
            $vcode->code = $verification_code;
            $vcode->mobile = $request['mobile'];
            $vcode->save();
        }

        $this->dispatch(new SendActivationCode($verification_code , $request['mobile']));
        //$this->dispatch(new SendSMSNotification('کد فعال سازی شما در شب: '.$verification_code , array($request['mobile'])));

        #TODO: check sending sms successfully
        return response()->json(['status' => 'success']);
    }
    
    public function verifyCode(Request $request)
    {
        $this->validate($request, [
            'mobile'  => 'required|digits:11',
            'code'  => 'required|digits:5',
        ]);

        $expiration_time = 5; #Verification code expires after expiration_time minutes
        $max_tries = 3; #Maximum number of invalid verification code 

        #validate the code (time and value and count)
        $expiration = Carbon::now()->subMinutes($expiration_time); #Verification code expires after 5 minutes
        $vcode = VerificationCode::where('mobile',$request['mobile'])->where('created_at', '>=', $expiration->toDateTimeString())->first();

        if(empty($vcode))
        {
            return response()->json(['status' => 'failed']);
        }

        if($vcode->code != $request['code'])
        {
            $vcode->increment('tries');
            return response()->json(['status' => 'failed']);
        }

        if($vcode->tries > $max_tries)
        {
            $vcode->delete();
            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'success']);
    }
}
