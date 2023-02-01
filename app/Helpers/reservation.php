<?php
if (!function_exists('expireReservations')) {
    /**
     *  Expite active reservations which have overlap time
     * 
     * @return void
     */
	function expireReservations($reservation)
    {
        $reservations = \App\Reservation::where('house_id', $reservation->house_id)->where('id', '!=', $reservation->id)->where('status', 1)->where('checkin', '<=', $reservation->checkout)->where('checkout', '>=', $reservation->checkin)->get();

        foreach ($reservations as $reserve) {
                    $reserve->invoice->status = 2;
                    $reserve->invoice->save();
                    //$reserve->status = 3;
                    //$reserve->save();
                }        
    }
}