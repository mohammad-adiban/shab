<?php

if (!function_exists('getHostReservationSms')) {

    /**
     * get sms text
     * @param \App\Reservation $reservation
     * @return string
     */
    function getHostReservationSms($reservation)
    {
        $duration = intval(($reservation->checkout - $reservation->checkin) / 86400);
        $checkin_jalali = substr(gregorian_to_jalali (idate('Y', $reservation->checkin), idate('m', $reservation->checkin), idate('d', $reservation->checkin), $mod = '/'), 2);
		$total_fee_host = $reservation->invoice->total_fee * 1000 * 0.9; #considering 10% commision

        return $reservation->host->name." ".$reservation->host->family." عزیز\r\nاقامتگاه کد $reservation->house_id شما برای روز $checkin_jalali به مدت $duration شب برای $reservation->guests نفر به جمع مبلغ خالص $total_fee_host تومان درخواست رزرو دارد.\r\nدر صورت موافقت عدد '1'\r\nپر بودن اقامتگاه عدد '2'\r\nنامطلوب بودن شرایط درخواست عدد '3'\r\n را به همین شماره ارسال كنید. این پیامک به منزله رزرو قطعی نمی‌باشد. \r\nشماره رزرو:$reservation->id\r\nلینک آگهی:\r\nhttps://www.shab.ir/houses/show/$reservation->house_id";
    }
}

if (!function_exists('getGuestReservationSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getGuestReservationSms($reservation)
    {
        $user = $reservation->guest;
        return "$user->name $user->family عزیز\r\nدرخواست رزرو شما با موفقیت در سایت شب ثبت گردید. وضعیت رزرو شما حداکثر تا 3 ساعت کاری آینده از طریق پیامک به اطلاع شما خواهد رسید.\r\nراهنمای نحوه رزرو:\r\nhttps://www.shab.ir/help/guest\r\nکانال تلگرام: t.me/shab_ir\r\nپیگیری رزرو: t.me/shab_reservation";
    }
}

if (!function_exists('getWelcomeSms')) {

    /**
     * get sms text
     *
     * @return string
     */
    function getWelcomeSms()
    {
        return "به سایت شب خوش آمدید.\r\nراهنمای نحوه رزرو: https://www.shab.ir/help/guest \r\nکانال تلگرام: t.me/shab_ir \r\nhttps://www.shab.ir";

    }
}

if (!function_exists('getGuestAcceptReservationSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getGuestAcceptReservationSms($reservation)
    {
        $guest = $reservation->guest;
        $checkin_jalali = substr(gregorian_to_jalali (idate('Y', $reservation->checkin), idate('m', $reservation->checkin), idate('d', $reservation->checkin), $mod = '/'), 2);
        $duration = intval(($reservation->checkout - $reservation->checkin) / 86400);
        $total_fee = $reservation->invoice->total_fee * 1000;
        $prepayment = $reservation->invoice->prepayment * 1000;

        return "$guest->name $guest->family عزیز\r\nدرخواست رزرو شما، اقامتگاه کد $reservation->house_id برای تاریخ $checkin_jalali بمدت $duration شب برای $reservation->guests نفر به قیمت $total_fee تومان توسط مالک تایید شده است. جهت پرداخت ودیعه به مبلغ $prepayment تومان و دریافت رسید سفر شامل آدرس و تلفن هماهنگ کننده تحویل کلید از طریق لینک زیر اقدام فرمایید:\r\nhttps://www.shab.ir/invoices/$reservation->invoice_id/show\r\nدر صورت وجود هرگونه سوال از طریق لینک تلگرام زیر با ما مطرح بفرمایید:\r\nt.me/shab_reservation\r\n";
    }
}

if (!function_exists('getHostAcceptReservationSms')) {

    /**
     * get sms text
     *
     * @return string
     */
    function getHostAcceptReservationSms()
    {
        return "پیام شما دریافت شد. در صورت پرداخت ودیعه و تأیید نهایی توسط میهمان، به شما اطلاع داده خواهد شد. لطفا ۳ ساعت آینده را در انتظار پرداخت میهمان بمانید. کانال اطلاع رسانی میزبان:\r\nt.me/shab_host\r\nتلفن پشتیبانی میزبان: ۰۲۱۲۲۳۹۸۲۰۳\r\nhttps://www.shab.ir";
    }
}

if (!function_exists('getGuestReviewSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getGuestReviewSms($reservation)
    {
        $guest = $reservation->guest;
        return "$guest->name $guest->family عزیز\r\nامیدواریم از سفر خود لذت برده باشید. شما می توانید از طریق لینک زیر نظر خود را راجع به اقامتگاه و میزبان به ثبت رسانده و در قرعه کشی ماهانه «شب» شرکت کنید:\r\nhttps://www.shab.ir/reservations/$reservation->id/reviews/new\r\nبا تشکر از اعتماد شما\r\nسایت شب";
    }
}

if (!function_exists('getGuestUnavailableSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getGuestUnavailableSms($reservation)
    {
        $guest = $reservation->guest;
        $house = $reservation->house;

        return "$guest->name $guest->family عزیز\r\nاقامتگاه انتخابی $house->city کد $house->id در تاریخ سفر شما ‍پر شده و متأسفانه قابل رزرو نیست.\r\nشما میتوانید با مراجعه مجدد به لیست اقامتگاه های $house->city اقامتگاه دیگری را انتخاب کنید.\r\nبا تشکر\r\nلینک اقامتگاه های $house->city:\r\nhttps://www.shab.ir/search/city/$house->city\r\nتلگرام پشتیبانی:\r\nt.me/shab_reservation";
    }
}

if (!function_exists('getHostRejectReservationSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getHostRejectReservationSms($reservation)
    {
        $host = $reservation->host;
        return "$host->name $host->family عزیز\r\nبا تشکر؛ درخواست رزرو کد $reservation->id کنسل شد، چنانچه به دلیل عدم تطابق قیمت رد درخواست کرده اید، هم اکنون جهت اصلاح قیمت به سایت یا اپلیکیشن شب مراجعه فرمایید.\r\n‌اقامتگاه های شما: https://www.shab.ir/houses\r\nلینک اپلیکیشن: https://www.shab.ir/hosts";
    }
}

if (!function_exists('getHostPaidInvoiceSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getHostPaidInvoiceSms($reservation)
    {
        $host = $reservation->host;
        $checkin_jalali = substr(gregorian_to_jalali (idate('Y', $reservation->checkin), idate('m', $reservation->checkin), idate('d', $reservation->checkin), $mod = '/'), 2);
        $duration = intval(($reservation->checkout - $reservation->checkin) / 86400);
        $residual = $reservation->invoice->total_fee * 1000 - $reservation->invoice->prepayment * 1000;
        if(is_null($host->account))
            $sheba_text = "شماره شبای حساب خود را به همین شماره پیامک نمایید.";
        else
            $sheba_text = "با ارسال 'y' دریافت این پیام را تأیید فرمایید.";

        return "$host->name $host->family عزیز\r\nمیهمانی که درخواست رزرو اقامتگاه شما برای $reservation->guests نفر در تاریخ $checkin_jalali بمدت $duration شب را داشت مبلغ ودیعه را واریز کرد. همچنین مبلغ $residual تومان در محل توسط میهمان به شما پرداخت خواهد شد. خواهشمند است $sheba_text مبلغ ودیعه تا ۲۴ ساعت آینده برای شما واریز خواهد شد. آدرس رسید شما: \r\nhttps://www.shab.ir/invoices/".$reservation->invoice_id."/show";
    }
}

if (!function_exists('getGuestPaidInvoiceSms')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getGuestPaidInvoiceSms($reservation)
    {
        return "فاکتور رزرو شما با موفقیت پرداخت شد. آدرس رسید شما:\r\nhttps://www.shab.ir/invoices/$reservation->invoice_id/show\r\nبا تشکر از اعتمادتان، سفر خوبی برایتان آرزومندیم.\r\nشب را به دوستان خود معرفی کنید.\r\nپشتیبانی: ۰۲۱۲۲۳۹۸۲۰۲";
    }
}

if (!function_exists('getHostUnavailableSms')) {

    /**
     * get sms text
     *
     * @return string
     */
    function getHostUnavailableSms()
    {
        return "با تشکر\r\nتقویم اقامتگاه شما در این تاریخ پر شد.\r\nhttps://www.shab.ir";
    }
}

if (!function_exists('getHostCancelReservationSms')) {

    /**
     * get sms text
     *
     * @return string
     */
    function getHostCancelReservationSms($reservation)
    {
        $host = $reservation->host;
        $checkin_jalali = substr(gregorian_to_jalali (idate('Y', $reservation->checkin), idate('m', $reservation->checkin), idate('d', $reservation->checkin), $mod = '/'), 2);
        $duration = intval(($reservation->checkout - $reservation->checkin) / 86400);

        return "$host->name $host->family عزیز\r\nدرخواست رزرو اقامتگاه کد $reservation->house_id شما برای تاریخ $checkin_jalali بمدت $duration شب توسط میهمان لغو شد. تقویم اقامتگاه شما خالی نگه داشته می‌شود\r\nhttps://www.shab.ir";
    }
}

if (!function_exists('getHostNewHouseSms')) {

    /**
     * get sms text
     *
     * @param \App\House $house
     * @return string
     */
    function getHostNewHouseSms($house)
    {
        $user = $house->user;
        return "$user->name $user->family عزیز\r\nاقامتگاه شما با موفقیت در سایت شب ثبت شد.\r\nکد آگهی: $house->id\r\nحتما در کانال اطلاع رسانی میزبانان عضو شده تا در جریان روند کاری و مقررات فعالیت قرار بگیرید.\r\nکانال اطلاع رسانی میزبانان: t.me/shab_host\r\nتلفن پشتیبانی میزبان: ۰۲۱۲۲۳۹۸۲۰۳";
    }
}

if (!function_exists('getNewMessageSMS')) {

    /**
     * get sms text
     *
     * @param \App\Reservation $reservation
     * @return string
     */
    function getNewMessageSMS($reservation)
    {
        return "پیام جدیدی برای رزرو شماره $reservation->id در سایت شب دارید\nلینک پاسخ:\nhttps://www.shab.ir/reservations/$reservation->id/show";
    }
}
