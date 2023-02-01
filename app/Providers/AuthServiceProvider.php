<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('edit', function ($user, $house) {
            return $user->id == $house->user_id;
        });

        $gate->define('send-message', function ($user, $reservation) {
            return $user->id == $reservation->guest_user_id || $user->id == $reservation->host_user_id;
        });

        $gate->define('response-reservation', function ($user, $reservation) {
            return $user->id == $reservation->host_user_id;
        });

        $gate->define('pay-invoice', function ($user, $invoice) {
            return $user->id == $invoice->reservation->guest_user_id;
        });

        $gate->define('guest-reservation', function ($user, $reservation) {
            return $user->id == $reservation->guest_user_id;
        });
    }
}
