<?php

use App\House;
use App\Reservation;
use App\Invoice;

if (!function_exists('getAveragePrice')) {

    /**
     * calculate average price
     *
     * @param string $checkin
     * @param string $checkout
     * @param House $house
     * @return integer
     */
    function getAveragePrice($checkin, $checkout, $guests, $house)
    {
#        $checkout += 1;
        $price = 0;
        $days = 0;
        $interval = DateInterval::createFromDateString('1 day');
        $period  = new DatePeriod(new DateTime("@$checkin"), $interval , new DateTime("@$checkout"));


        foreach ($period as $dt)
        {
            $days++;
            if($house->province == 'مازندران' || $house->province == 'خراسان رضوی')
            {
                if (in_shahrivar($dt->getTimestamp()) || in_special_days($dt, $house->province))
                {
                    $price += $house->max_price;
                }
                elseif (in_weekend($dt))
                    $price += $house->median_price;
                else
                    $price += $house->min_price;
            }
            else
                $price += $house->median_price;

            if($house->beds < $guests)
                $price += ($guests - $house->beds) * $house->extra_person;
        }


        $discount_factor = 1;

        if($days > $house->discount_days)
            $discount_factor = 1 - ($house->discount_rate / 100);

        return intval($price * $discount_factor / $days);
    }
}

if (!function_exists('getFactor')) {

    /**
     * prepare reserve factor
     *
     * @param string $checkin
     * @param string $checkout
     * @param House $house
     * @return integer
     */
    function getFactor($checkin, $checkout, $guests, $house)
    {
#        $checkout += 1;
        $price = 0;
        $days = 0;

        $interval = DateInterval::createFromDateString('1 day');
        $checkin_dt = new DateTime("@$checkin");
        //$checkin_dt->setTimezone(new DateTimeZone('Asia/Tehran'));
        $checkout_dt = new DateTime("@$checkout");
        //$checkout_dt->setTimezone(new DateTimeZone('Asia/Tehran'));

        $period  = new DatePeriod($checkin_dt, $interval, $checkout_dt);

        $max_days = 0;
        $max_days_total = 0;
        $median_days = 0;
        $median_days_total = 0;
        $min_days = 0;
        $min_days_total = 0;
        $extra_person = 0;
        $extra_person_total = 0;
        $discount = 0;
        $total_price = 0;
        $special_discount = 0;

        foreach ($period as $dt)
        {
            $days++;

            $day = $house->calendars->where('date', $dt->format('Y-m-d'))->first();
            if(!is_null($day))
            {
                $price += $day->price;
                $max_days++;
                $max_days_total += $day->price;
            }
            elseif (in_shahrivar($dt->getTimestamp()) || in_special_days($dt, $house->province))
            {
                $price += $house->max_price;
                $max_days++;
                $max_days_total += $house->max_price;
            }
            elseif (in_weekend($dt))
            {
                $price += $house->median_price;
                $median_days++;
                $median_days_total += $house->median_price;
            }
            else
            {
                $price += $house->min_price;
                $min_days++;
                $min_days_total += $house->min_price;
            }
        }

        if($house->accommodates < $guests)
        {
            $extra_person = $guests - $house->accommodates;
            $extra_person_total += $extra_person * $house->extra_person * $days;
            $price += $extra_person_total;
        }

        $discount_factor = 1;

        /*
        if($days > $house->discount_days)
        {
            $discount_factor = 1 - ($house->discount_rate / 100);
            $discount = intval($price * ($house->discount_rate / 100));
        }
        */

        #Dicounts
        if($days > $house->discount_days_level2 && $house->discount_days_level2 > 0)
            $discount = intval($price * ($house->discount_rate_level2 / 100));
        elseif($days > $house->discount_days_level1 && $house->discount_days_level1 > 0)
            $discount = intval($price * ($house->discount_rate_level1 / 100));

        if($checkout >= 1521072000 && $checkin <= 1523059200) #no discount in nowruz
            $discount = 0;

        /*
        $user = Auth::user();
        $reserve = Reservation::where('guest_user_id', '=', $user->id )->first();
        if($reserve)
        {
            $special_discount = 0;
        }
        */

        #{'max_days': , 'max_days_total': ,'median_days': ,'median_days_total':, 'min_days':, 'min_days_total', 'extra_person': , 'extra_person_total':, 'discount': , total_price: }
        return json_encode(array('max_days' => $max_days, 'max_days_total' => $max_days_total, 'median_days' => $median_days, 'median_days_total' => $median_days_total, 'min_days' => $min_days, 'min_days_total' => $min_days_total, 'extra_person' => $extra_person, 'extra_person_total' => $extra_person_total, 'discount' => $discount, 'total_price' => intval($price - $discount - $special_discount), 'special_discount' => $special_discount));
    }
}

if (!function_exists('getPrice')) {

    /**
     * calculate house price
     *
     * @param string $checkin
     * @param string $checkout
     * @param House $house
     * @return string
     */
    function getPrice($checkin, $checkout, $guests, $house)
    {
        $price = 0;
        $days = 0;
        $interval = DateInterval::createFromDateString('1 day');
        $checkin_dt = new DateTime("@$checkin");
        //$checkin_dt->setTimezone(new DateTimeZone('Asia/Tehran'));
        $checkout_dt = new DateTime("@$checkout");
        //$checkout_dt->setTimezone(new DateTimeZone('Asia/Tehran'));

        $period  = new DatePeriod($checkin_dt, $interval, $checkout_dt);

        foreach ($period as $dt)
        {
            $days++;
            $day = $house->calendars->where('date', $dt->format('Y-m-d'))->first();
            if(!is_null($day))
                $price += $day->price;
            elseif (in_shahrivar($dt->getTimestamp()) || in_special_days($dt, $house->province))
                $price += $house->max_price;
            elseif (in_weekend($dt))
                $price += $house->median_price;
            else
                $price += $house->min_price;
        }

        if($house->accommodates < $guests)
            $price += ($guests - $house->accommodates) * $house->extra_person * $days;

        $discount_factor = 1;

        #Dicounts
        $discount = 0;
        if($days > $house->discount_days_level2 && $house->discount_days_level2 > 0)
            $discount = $price * ($house->discount_rate_level2 / 100);
        elseif($days > $house->discount_days_level1 && $house->discount_days_level1 > 0)
            $discount = $price * ($house->discount_rate_level1 / 100);

        if($checkout >= 1521072000 && $checkin <= 1523059200) #no discount in nowruz
            $discount = 0;

        /*
        if($days > $house->discount_days)
            $discount_factor = 1 - ($house->discount_rate / 100);
        */
        $special_discount = 0;
        /*
        $user = Auth::user();
        $reserve = Reservation::where('guest_user_id', '=', $user->id )->first();
        if($reserve)
        {
            $special_discount = 0;
        }
        */
        return $price - $discount - $special_discount;
    }
}

if (!function_exists('in_weekend')) {
    /**
     * check weekend days
     *
     * @param DateTime $dt
     * @return boolean
     */
    function in_weekend($dt)
    {
        $dw = $dt->format("N");
        return (($dw > 2) && ($dw < 6)) || in_array($dt->format('Y-m-d'), array('2018-02-10','2018-02-11'));
    }
}

if (!function_exists('in_shahrivar')) {
    /**
     * check Shahrivar month
     *
     * @param DateTime $dt
     * @return boolean
     */
    function in_shahrivar($ts)
    {
        return false;
        $shahrivar_start = strtotime('2016-08-22');
        $shahrivar_end = strtotime('2016-09-22');
        //return ($ts >= $shahrivar_start) && ($ts <= $shahrivar_end);
    }
}

if (!function_exists('in_special_days')) {
    /**
     * check special days
     *
     * @param DateTime $dt
     * @param string $province
     * @return boolean
     */
    function in_special_days($dt, $province)
    {
        $special_days = getPeakDays($province);
        
        $ts = $dt->getTimestamp();

        return in_array($dt->format('Y-m-d'), $special_days);
    }
}

/*
if (!function_exists('isAvailable')) {

    **
     * check house availablity
     *
     * @param string $checkin
     * @param string $checkout
     * @param House $house
     * @return string
     *
    function isAvailable($checkin, $checkout, $house)
    {
        #$house = House::findOrFail($id);
        $reservations = $house->reservations()
            ->where([
                ['checkin', '<=' , $checkin],
                ['checkout','>=', $checkin],
            ])->orWhere(function ($query) use ($checkout) {
                $query->where('checkin', '<=', $checkout)
                      ->where('checkout', '>=', $checkout);
            })->orWhere(function ($query) use ($checkin, $checkout){
                $query->where('checkin', '>=',  $checkin)
                      ->where('checkout', '<=', $checkout);
            })->count();
        if($reservations > 0)
            return false;
        else
            return true;
    }
}
*/

if (!function_exists('getSpecialPrice')) {

    /**
     * get house price
     *
     * @param string $dt
     * @param House $house
     */
    function getSpecialPrice($dt, $house)
    {
        $day = $house->calendars->where('date', $dt->format('Y-m-d'))->first();
        if(!is_null($day))
            return $day->price;
        elseif(in_special_days($dt, $house->province))
            return $house->max_price;

        return 0;
    }
}

if (!function_exists('invoice')) {

    /**
     * prepare reservation invoice
     *
     * @param Reservation $reservation
     * @return Invoice $invoice
     */
    function invoice($reservation)
    {
        $price = 0;
        $days = 0;
        $interval = DateInterval::createFromDateString('1 day');

        $checkin_dt = new DateTime("@$reservation->checkin");
        //$checkin_dt->setTimezone(new DateTimeZone('Asia/Tehran'));
        $checkout_dt = new DateTime("@$reservation->checkout");
        //$checkout_dt->setTimezone(new DateTimeZone('Asia/Tehran'));

        $period  = new DatePeriod($checkin_dt, $interval, $checkout_dt);

        $median_days = 0;
        $median_days_total = 0;
        $min_days = 0;
        $min_days_total = 0;
        $special_days = 0;
        $special_days_total = 0;
        $extra_person = 0;
        $extra_person_total = 0;
        $discount_days = 0;
        //$total_price = 0;
        $discount_special = 0;
        $discount_coupan = 0;
        $price_days = array();

        $house = $reservation->house()->first();

        #Check calendar
        foreach ($period as $dt)
        {
            $days++;
            $sprice = getSpecialPrice($dt, $house);

            if ($sprice != 0)
            {
                $price += $sprice;
                $price_days[$days] = $sprice;
                $special_days++;
                $special_days_total += $sprice;
            }
            elseif (in_weekend($dt))
            {
                $price += $house->median_price;
                $price_days[$days] = $house->median_price;
                $median_days++;
                $median_days_total += $house->median_price;
            }
            else
            {
                $price += $house->min_price;
                $price_days[$days] = $house->min_price;
                $min_days++;
                $min_days_total += $house->min_price;
            }
        }

        #Extra person
        if($house->accommodates < $reservation->guests)
        {
            $extra_person = $reservation->guests - $house->accommodates;
            $extra_person_total += $extra_person * $house->extra_person * $days;
            $price += $extra_person_total;
        }

        #Dicounts
        $discount_days = 0;
        if($days > $house->discount_days_level2 && $house->discount_days_level2 > 0)
        {
            //$discount_factor = 1 - ($house->discount_rate_level2 / 100);
            $discount_days = intval($price * ($house->discount_rate_level2 / 100));
        }
        elseif($days > $house->discount_days_level1 && $house->discount_days_level1 > 0)
        {
            //$discount_factor = 1 - ($house->discount_rate / 100);
            $discount_days = intval($price * ($house->discount_rate_level1 / 100));
        }

        if($reservation->checkout >= 1521072000 && $reservation->checkin <= 1523059200) #no discount in nowruz
            $discount_days = 0;

        $invoice = new Invoice;
        $invoice->reservation_id = $reservation->id;
        $invoice->status = 0;
        $invoice->weekend_days  = $median_days;
        $invoice->weekend_days_price  = $median_days_total;
        $invoice->workweek_days = $min_days;
        $invoice->workweek_days_price = $min_days_total;
        $invoice->special_days = $special_days;
        $invoice->special_days_price = $special_days_total;
        $invoice->extra_person = $extra_person;
        $invoice->extra_person_price = $extra_person_total;
        $invoice->discount_days = $discount_days;
        $invoice->total_fee = $price - $discount_days - $discount_coupan - $discount_special;
//        $invoice->prepayment = $days > 1 ? $price_days[1] + $price_days[2] + 2 * $extra_person * $house->extra_person : $invoice->total_fee;
        $invoice->prepayment = $days > 1 ?  (2 / sizeof($price_days)) * $invoice->total_fee : $invoice->total_fee;
        $invoice->revenue = 0.1 * $invoice->total_fee;
        return $invoice;
    }
}

if (!function_exists('getPeakDays')) {

    /**
     * get peak days
     *
     * @return array
     */
    function getPeakDays($province = '', $city = '')
    {
        $peak_days = array('2018-05-02','2018-06-03','2018-06-04','2018-06-05','2018-06-06','2018-06-07','2018-06-15');

        if($province == 'تهران' || $province == 'البرز')
            $peak_days[] = '2018-03-13';

        return $peak_days;
    }
}