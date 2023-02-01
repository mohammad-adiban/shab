<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;

use Hash;

use Carbon\Carbon;
use App\VerificationCode;

use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('hash', function($attribute, $value, $parameters, $validator) {
            return Hash::check($value, $parameters[0]);
        });

        Validator::extend('verification', function($attribute, $value, $parameters, $validator) {
            $expiration_time = 5; #Verification code expires after expiration_time minutes
            $max_tries = 3; #Maximum number of invalid verification code 
            $expiration = Carbon::now()->subMinutes($expiration_time);
            $vcode = VerificationCode::where('mobile', array_get($validator->getData(), $parameters[0]))->where('created_at', '>=', $expiration->toDateTimeString())->first();

            if(empty($vcode))
                return false;

            if($vcode->code != $value)
            {
                $vcode->increment('tries');
                return false;
            }

            if($vcode->tries > $max_tries)
            {
                $vcode->delete();
                return false;
            }

            $vcode->delete();

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
