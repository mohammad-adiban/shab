<?php
//require_once('lib/nusoap.php');
use App\Calendar;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

if (!function_exists('random_str')) {
    /**
     * Generate a random string, using a cryptographically secure 
     * pseudorandom number generator (random_int)
     * 
     * @return string
     */
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }
}

if (!function_exists('sendTelegramMessage')) {
    /**
     * send telegram message with proxy option
     *
     * @return void
     */
    function sendTelegramMessage($chat_id, $text)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,'https://api.telegram.org/bot413370151:AAGor5W3TcN1FVvQWBmEmaH-vB8gCVWIHaM/sendMessage');
        curl_setopt($curl_handle, CURLOPT_PROXY, '127.0.0.1:8080');
        curl_setopt($curl_handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, 'chat_id='.$chat_id.'&text='.$text.'&disable_web_page_preview=0');
        curl_exec  ($curl_handle);
        curl_close ($curl_handle);
    }
}

if (!function_exists('sendTelegramNotification')) {
    /**
     * send telegram notification by bot
     *
     * @return void
     */    
    function sendTelegramNotification($template, $object, $subject)
    {
        preg_match_all("/(#\w+)/", $subject, $hashtags);
        
        if(in_array('#reserve', $hashtags[0]) || in_array('#paid', $hashtags[0]))
        {
            $reservation = $object['reserve'];
            $invoice     = $reservation->invoice;
            $host        = $reservation->host;
            $guest      = $reservation->guest;
            $title       = preg_replace('/(#\w+)/', '', $subject);
            $checkin_jalali = gregorian_to_jalali (idate('Y', $reservation->checkin), idate('m', $reservation->checkin), idate('d', $reservation->checkin), $mod = '/');
            $checkout_jalali = gregorian_to_jalali (idate('Y', $reservation->checkout), idate('m', $reservation->checkout), idate('d', $reservation->checkout), $mod = '/');
            
            sendTelegramMessage(in_array('#reserve', $hashtags[0]) ? env('TELEGRAM_RESERVATION_GID') : env('TELEGRAM_PAID_GID'), "$title\nشناسه رزرو: $reservation->id\nآدرس خونه: https://shab.ir/houses/show/$reservation->house_id\nاز تاریخ $checkin_jalali تا تاریخ $checkout_jalali برای تعداد $reservation->guests نفر\nنام میهمان: $guest->name $guest->family\nشماره تماس میهمان: $guest->mobile\nنام میزبان: $host->name $host->family\nشماره تماس میزبان: $host->mobile\nلینک فاکتور: https://www.shab.ir/invoices/$invoice->id/show\nقیمت کل: ".($invoice->total_fee*1000)." تومان\nپیش پرداخت: ".($invoice->prepayment*1000)." تومان\n");
            /*
            Telegram::sendMessage([
                'chat_id' => in_array('#reserve', $hashtags[0]) ? env('TELEGRAM_RESERVATION_GID') : env('TELEGRAM_PAID_GID'),
                'text' => "$title\nشناسه رزرو: $reservation->id\nآدرس خونه: https://shab.ir/houses/show/$reservation->house_id\nاز تاریخ $checkin_jalali تا تاریخ $checkout_jalali برای تعداد $reservation->guests نفر\nنام میهمان: $guest->name $guest->family\nشماره تماس میهمان: $guest->mobile\nنام میزبان: $host->name $host->family\nشماره تماس میزبان: $host->mobile\nلینک فاکتور: https://www.shab.ir/invoices/$invoice->id/show\nقیمت کل: ".($invoice->total_fee*1000)." تومان\n",
                'disable_web_page_preview' => 0
            ]);
            */
        }
        
        if(in_array('#sms', $hashtags[0]))
        {
            $title     = preg_replace('/(#\w+)/', '', $subject);
            sendTelegramMessage(env('TELEGRAM_RESERVATION_GID'), "$title\nشناسه پیام: ".$object['messageid']."\nاز: ".$object['from']."\nبه: ".$object['to']."\nمتن پیام: ".$object['text']."\n");
            /*
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_RESERVATION_GID'),
                'text' => "$title\nشناسه پیام: ".$object['messageid']."\nاز: ".$object['from']."\nبه: ".$object['to']."\nمتن پیام: ".$object['text']."\n",
                'disable_web_page_preview' => 0
            ]);
            */
        }

        if(in_array('#chat', $hashtags[0]))
        {
            $title       = preg_replace('/(#\w+)/', '', $subject);
            $object['message']->from_user_id == $object['reserve']->host_user_id ? $dialog = 'از: '.$object['reserve']->host->name.' '.$object['reserve']->host->family." (میزبان)\nبه: ".$object['reserve']->guest->name.' '.$object['reserve']->guest->family.' (میهمان)' : $dialog = 'از: '.$object['reserve']->guest->name.' '.$object['reserve']->guest->family." (میهمان)\nبه: ".$object['reserve']->host->name.' '.$object['reserve']->host->family.' (میزبان)';
            
            sendTelegramMessage(env('TELEGRAM_CHAT_GID'), "$title\nشناسه رزرو: ".$object['reserve']->id."#\n$dialog\nمتن پیام: ".$object['message']->text."\n");
            /*
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHAT_GID'),
                'text' => "$title\nشناسه رزرو: ".$object['reserve']->id."#\n$dialog\nمتن پیام: ".$object['message']->text."\n",
                'disable_web_page_preview' => 0
            ]);
            */  
        }

        if(in_array('#edit', $hashtags[0]))
        {
            $title       = preg_replace('/(#\w+)/', '', $subject);
            $user        = $object['house']->user;
            $house       = $object['house'];

            sendTelegramMessage(env('TELEGRAM_EDIT_GID'), "$title\nآدرس خونه: https://shab.ir/houses/show/$house->id\nنام مالک: $user->name $user->family\nموبایل: $user->mobile\nکد مالک: $user->id\n");
            /*
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_EDIT_GID'),
                'text' => "$title\nآدرس خونه: https://shab.ir/houses/show/$house->id\nنام مالک: $user->name $user->family\nموبایل: $user->mobile\nکد مالک: $user->id\n",
                'disable_web_page_preview' => 0
            ]);
            */
        }

        if(in_array('#career', $hashtags[0]))
        {
            $title       = preg_replace('/(#\w+)/', '', $subject);
            sendTelegramMessage(env('TELEGRAM_RESERVATION_GID'), "$title\nنام و نام خانوادگی: ".$object['name']."\nموبایل: ".$object['mobile']."\nایمیل: ".$object['email']."\nنوع همکاری: ".$object['career_type']."\nتوضیحات: ".$object['details']."\n");
            /*
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_RESERVATION_GID'),
                'text' => "$title\nنام و نام خانوادگی: ".$object['name']."\nموبایل: ".$object['mobile']."\nایمیل: ".$object['email']."\nنوع همکاری: ".$object['career_type']."\nتوضیحات: ".$object['details']."\n",
                'disable_web_page_preview' => 0
            ]);
            */
        }

        if(in_array('#review', $hashtags[0]))
        {
            $title       = preg_replace('/(#\w+)/', '', $subject);
            $reservation = $object['review']->reservation;

            sendTelegramMessage(env('TELEGRAM_RESERVATION_GID'), "$title\nشناسه رزرو: ".$reservation->id."#\nنظر: ".$object['review']->description."\n");
        }
        
    }
}

if (!function_exists('sendToTelegram')) {
    /**
     * send telegram notification via ifttt
     *
     * @return void
     */    
    function sendToTelegram($template, $object, $subject)
    {
        Log::info('tes6');
        // Setup your gmail mailer
        $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com', 587);
        $transport->setEncryption('tls');
        $transport->setUsername('shabdotir@gmail.com');
        $transport->setPassword('Shab@247');

        $gmail = new Swift_Mailer($transport);

        Mail::setSwiftMailer($gmail);
        Mail::send($template, $object, function ($message) use ($subject) {
            $message->subject($subject);
            $message->from('shabdotir@gmail.com', 'Shab.ir');
            $message->to(['trigger@applet.ifttt.com']);
        });
    }
}

if (!function_exists('getPicture')) {

    /**
     * get user profile picture
     *
     * @return string
     */
    function getPicture()
    {
        $user = Auth::user();

        if(empty($user->picture) || !file_exists($user->picture))
        {
        	$type = pathinfo('img/user-default.png', PATHINFO_EXTENSION);
        	$base64 = base64_encode(file_get_contents('img/user-default.png'));
        }
        else
        {
        	$type = pathinfo($user->picture, PATHINFO_EXTENSION);
        	$base64 = base64_encode(file_get_contents($user->picture));
        }
        return $type . ';base64,' .$base64;
    }
}

if (!function_exists('gregorian_to_jalali')) {

    /**
     * convert gregorian date to jalali
     *
     * @return string
     */

    function gregorian_to_jalali ($gy, $gm, $gd, $mod = '')
    {
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $jy = ($gy <= 1600) ? 0 : 979;
        $gy -= ($gy <= 1600) ? 621 : 1600;
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int) ($days / 12053)); 
        $days %= 12053;
        $jy += 4 * ((int) ($days / 1461));
        $days %= 1461;
        $jy += (int) (($days - 1) / 365);
        if($days > 365)$days = ($days - 1) % 365;
        $jm = ($days < 186) ? 1 + (int) ($days / 31) : 7 + (int) (($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return ($mod == '') ? array($jy, $jm, $jd) : $jy.$mod.$jm.$mod.$jd;
    }
}

if (!function_exists('setUnavailable')) {

    /**
     * fulling the house calendar
     *
     * @return string
     */
    function setUnavailable($reservation)
    {
        $house = $reservation->house;
        
        $interval = DateInterval::createFromDateString('1 day');

        $checkin_dt = new DateTime("@$reservation->checkin");
        //$checkin_dt->setTimezone(new DateTimeZone('Asia/Tehran'));
        $checkout_dt = new DateTime("@$reservation->checkout");
        //$checkout_dt->setTimezone(new DateTimeZone('Asia/Tehran'));

        $period  = new DatePeriod($checkin_dt, $interval, $checkout_dt);

        foreach ($period as $dt)
        {
            $cal = Calendar::where('house_id', $house->id)->where('date', $dt->format("Y-m-d"))->first();
            if(is_null($cal))
            {
                $calendar = new Calendar;
                $calendar->house_id = $house->id;
                $calendar->date = $dt->format("Y-m-d");
                $calendar->price = in_weekend($dt) ? $house->median_price : $house->min_price;
                $calendar->unavailable = 1;
                $calendar->save();
            }
            else
            {
                $cal->unavailable = 1;
                $cal->save();
            }
        }
    }
}

if (!function_exists('isAvailable')) {

    /**
     * check the calendar availablity
     *
     * @return string
     */
    function isAvailable($house, $checkin, $checkout)
    {
        #not including the checkout day
        $calendars = $house->calendars()->whereDate('date', '>=' ,date("Y-m-d",$checkin))->whereDate('date', '<', date("Y-m-d",$checkout))->where(function ($query) {
                $query->where('disabled', 1)
                      ->orWhere('unavailable', 1);
            })->count();

        if($calendars > 0)
            return false;
        else
            return true;
    }
}

if (!function_exists('setServiceDeskStatus')) {

    /**
     * change reservations status in service desk
     *
     * @return string
     */
    function setServiceDeskStatus($reservation, $status)
    {
        switch ($status) {
            case 'STATUS_ACCEPT':
                $status_id = 991;
                break;
            case 'STATUS_REJECT':
                $status_id = 971;
                break;
            case 'STATUS_NEW_PRICE':
                $status_id = 1051;
                break;
            case 'STATUS_PAID':
                $status_id = 1151;
                break;
            case 'STATUS_CANCEL_GUEST':
                $status_id = 1231;
                break;
            default:
                return;
        }
        $payload = json_encode( array( "transition"=> array("id" => $status_id) ) );
        $issue_id = is_null($reservation->issue_id) ? 'RES-'.$reservation->id - 3116 : $reservation->issue_id;
        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL,'http://jira.shab.ir/rest/api/2/issue/'.$issue_id.'/transitions');
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl_handle, CURLOPT_USERPWD, "admin:shab@247");
        //curl_setopt($curl_handle, CURLOPT_USERPWD, env('SERVICE_DESK_USER').':'.env('SERVICE_DESK_PASS'));
        curl_exec  ($curl_handle);
        curl_close ($curl_handle);
    }
}

if (!function_exists('addServiceDeskIssue')) {

    /**
     * change reservations status in service desk
     *
     * @return string
     */
    function addServiceDeskIssue($reserve)
    {
        $checkin_jalali = gregorian_to_jalali (idate('Y', $reserve->checkin), idate('m', $reserve->checkin), idate('d', $reserve->checkin), $mod = '/');
        $checkout_jalali = gregorian_to_jalali (idate('Y', $reserve->checkout), idate('m', $reserve->checkout), idate('d', $reserve->checkout), $mod = '/');

        $description = "شناسه رزرو: $reserve->id\nآدرس خونه: http://shab.ir/houses/show/$reserve->house_id\nاز تاریخ $checkin_jalali تا تاریخ $checkout_jalali برای تعداد $reserve->guests نفر\nنام میهمان: ".$reserve->guest->name." ".$reserve->guest->family."\nشماره تماس میهمان($reserve->guest_user_id): ".$reserve->guest->mobile."\nنام میزبان: ".$reserve->host->name." ".$reserve->host->family."\nشماره تماس میزبان: ".$reserve->host->mobile."\nلینک فاکتور: https://www.shab.ir/invoices/".$reserve->invoice->id."/show\nقیمت کل: ".(($reserve->invoice->total_fee)*1000)." تومان\n";
        $payload = json_encode( array( "serviceDeskId" => "1" ,"requestTypeId" => "8", "requestFieldValues" => array("summary" => "Reservation #".$reserve->id, "description" => $description, "customfield_10200" => gmdate('Y-m-d', $reserve->checkin), "customfield_10201" => gmdate('Y-m-d', $reserve->checkout), "customfield_10208" => "$reserve->id", "customfield_10209" => "http://shab.ir/houses/show/$reserve->house_id", "customfield_10211" => "$reserve->guests", "customfield_10204" => $reserve->guest->name." ".$reserve->guest->family, "customfield_10202" => $reserve->host->name." ".$reserve->host->family, "customfield_10205" => $reserve->guest->mobile, "customfield_10203" => $reserve->host->mobile, "customfield_10210" =>  "https://www.shab.ir/invoices/".$reserve->invoice->id."/show", "customfield_10206" =>  (string) (($reserve->invoice->total_fee)*1000), "customfield_10207" => (string) (($reserve->invoice->prepayment)*1000) ) ) );
        //$payload = json_encode( array( "fields"=> array("project" => array("key" => "RES"), "summary" => "Reservation #".$reserve->id, "description" => $description, "issuetype" => array("name" => "Service Request"), "customfield_10200" => gmdate('Y-m-d', $reserve->checkin), "customfield_10201" => gmdate('Y-m-d', $reserve->checkout), "customfield_10208" => "$reserve->id", "customfield_10209" => "http://shab.ir/houses/show/$reserve->house_id", "customfield_10211" => $reserve->guests, "customfield_10202" => $reserve->guest->name." ".$reserve->guest->family, "customfield_10204" => $reserve->host->name." ".$reserve->host->family, "customfield_10205" => $reserve->guest->mobile, "customfield_10203" => $reserve->host->mobile, "customfield_10210" =>  "https://www.shab.ir/invoices/".$reserve->invoice->id."/show", "customfield_10206" =>  (string) (($reserve->invoice->total_fee)*1000), "customfield_10207" => (string) (($reserve->invoice->prepayment)*1000) ) ) );
        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL,'http://jira.shab.ir/rest/servicedeskapi/request');
        //curl_setopt($curl_handle, CURLOPT_URL,'http://jira.shab.ir/rest/api/2/issue');
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_COOKIEJAR, '/tmp/jira-cookie');
        curl_setopt($curl_handle, CURLOPT_COOKIEFILE, '/tmp/jira-cookie');
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_USERPWD, "admin:shab@247");
        //curl_setopt($curl_handle, CURLOPT_USERPWD, env('SERVICE_DESK_USER').':'.env('SERVICE_DESK_PASS'));
        $result = curl_exec($curl_handle);
        curl_close ($curl_handle);

        //$reserve->issue_id = json_decode($result)->issueId;
        
        try{
            $reserve->issue_id = json_decode($result)->issueId;
        }
        catch(Exception $e){
            Log::info('Jira add issue exception:');
            Log::info($result);
        }

        $reserve->save();
        return $result;
    }
}

if (!function_exists('isBookable')) {
    /**
     * check house is bookable
     *
     * @param \App\House $house
     * @return query
     */
    function isBookable($house)
    {
        if($house->disabled || $house->temp || $house->non_bookable)
            return false;
        else
            return true;
    }
}