<?php
$checkin_jalali = gregorian_to_jalali (idate('Y', $reserve->checkin), idate('m', $reserve->checkin), idate('d', $reserve->checkin), $mod = '/');
$checkout_jalali = gregorian_to_jalali (idate('Y', $reserve->checkout), idate('m', $reserve->checkout), idate('d', $reserve->checkout), $mod = '/');

echo "شناسه رزرو: $reserve->id<br>";
echo "آدرس خونه: http://shab.ir/houses/show/$reserve->house_id<br>";
//echo "از تاریخ ".date('Y-m-d', $reserve->checkin)." تا تاریخ ".date('Y-m-d', $reserve->checkout)." برای تعداد $reserve->guests نفر<br>";
echo "از تاریخ ".$checkin_jalali." تا تاریخ ".$checkout_jalali." برای تعداد $reserve->guests نفر<br>";
echo "نام میهمان: ".$reserve->guest->name." ".$reserve->guest->family."<br>";
echo "شماره تماس میهمان: ".$reserve->guest->mobile."<br>";
echo "نام میزبان: ".$reserve->host->name." ".$reserve->host->family."<br>";
echo "شماره تماس میزبان: ".$reserve->host->mobile."<br>";
echo "لینک فاکتور: https://www.shab.ir/invoices/".$reserve->invoice->id."/show<br>";
echo "قیمت کل: ",($reserve->invoice->total_fee)*1000," تومان<br>";
