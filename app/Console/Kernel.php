<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\VerificationCode;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $expiration = Carbon::now()->subMinutes(10);
            VerificationCode::where('created_at', '<=', $expiration->toDateTimeString())->delete();
        })->dailyAt('04:00');

        $schedule->call(function () {
            $reservations = \App\Reservation::where('status', '3')->where('checkout', \Carbon\Carbon::today('UTC')->timestamp)->get(); #alternative: yesterday
            foreach ($reservations as $reservation) {
                sendSMS(getGuestReviewSms($reservation), array($reservation->guest->mobile));
            }
        })->dailyAt('16:00');

        $schedule->call(function () {
            $messages = \App\Message::where('seen', '0')->where('created_at', '>', \Carbon\Carbon::now()->subMinutes(10))->groupBy('reservation_id')->get();
            foreach ($messages as $message) {
                $reservation = $message->reservation;
                $message->from_user_id == $reservation->host_user_id ? $notificant = $reservation->guest : $notificant = $reservation->host;
                sendSMS(getNewMessageSMS($reservation), array($notificant->mobile) );
            }
        })->everyTenMinutes();

        $schedule->call(function () {
            $houses = \App\House::bookable()->get();
            foreach ($houses as $house) {
                $stats   = \App\HouseStatistics::firstOrNew(['house_id' => $house->id]);
                $reviews = \App\Review::where('confirmed', 1)->whereIn('reservation_id', $house->reservations()->pluck('id'));

                if($reviews->count() > 0)
                {
	                $stats->cleanliness   = $reviews->avg('cleanliness')  ;
	                $stats->value         = $reviews->avg('value')        ;
	                $stats->accuracy      = $reviews->avg('accuracy')     ;
	                $stats->accessibility = $reviews->avg('accessibility');
	                $stats->neighborhood  = $reviews->avg('neighborhood') ;
                    $stats->host          = $reviews->avg('host')         ;
	                $stats->rank          = ($stats->cleanliness + $stats->value + $stats->accuracy + $stats->accessibility + $stats->neighborhood + $stats->host) / 6;
                }
                else
                {
                	$stats->cleanliness   = 0;
	                $stats->value         = 0;
	                $stats->accuracy      = 0;
	                $stats->accessibility = 0;
	                $stats->neighborhood  = 0;
	                $stats->host          = 0;
                    $stats->rank          = 0;
                }
                
                $stats->reviews       = $reviews->count();

                $stats->requests      = $house->reservations->count();
                $stats->reservations  = $house->reservations->where('status', 3)->count();
                $stats->bookmarks     = \App\Bookmark::where('house_id', $house->id)->count();
                $stats->photos        = $house->photos->count();
                
                $stats->save();
            }
        })->dailyAt('03:30');

    }
}
