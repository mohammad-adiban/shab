<?php

namespace App\Helpers;

use App\House;
use App\Invoice;
use App\Reservation;
use App\User;
use App\Discount;
use Carbon\Carbon;
use Auth;

class DiscountHelper
{
    public  function code_validation($code,$factor_id){

        $user = Auth::user();
        $discount=Discount::where('code',$code)->first();
        $invoice=Invoice::where('id',$factor_id)->first();
        $reservation=Reservation::where('id',$invoice->reservation_id)->first();
        $house=House::where('id',$reservation->house_id)->first();
        if(strcasecmp($code,'')==0){
           return $resp=0;
        }
         if(is_null($discount)){
             return $resp=1;
        }

        else{
        	if($this->checkDateValidity($discount->start_date,$discount->end_date,Carbon::now())){
                return $resp=2;
            }
            if($discount->user_id && $this->checkUser($user->id,$discount->user_id)){
                return $resp=3;
            }
            if($discount->house_id && $this->checkHouse($reservation->house_id,$discount->house_id)){
                return $resp=4;
            }
            if($discount->city && $this->checkZone($house->city,$discount->city)){
                return $resp=5;
            }
            if($discount->minimum_price && $this->checkMinimumDiscount($invoice->total_fee,$discount->minimum_price)){
                return $resp=6;
            }
            if($discount->counter=='0'){
                return $resp=7;
            }
            return $resp='1000';

        }
    }
    public function subtract_price($code,$factor_id){
        $discount=Discount::where('code',$code)->first();
        $invoice=Invoice::where('id',$factor_id)->first();
        if($discount->maximum_discount){
            $totalprice = ($invoice->total_fee) * ($discount->percent / 100);
            if($totalprice > $discount->maximum_discount){
                $fee=$invoice->total_fee-$discount->maximum_discount_price;

                return [$fee,$discount->maximum_discount_price];
            }
            else{
                $fee=$invoice->total_fee-$totalprice;

                return [$fee,$totalprice];
            }
        }
        else{
            $totalprice = ($invoice->total_fee) * ($discount->percent / 100);
            $fee=$invoice->total_fee-$totalprice;
            return [$fee,$totalprice];
        }
    }
    private function checkDateValidity($start,$end,$date){
    	if($date>$end || $date<$start){
    	    return true;
        }
        else{
    	    return false;
        }
    }
    private function checkUser($user_id,$discount_user_id){
        return ($user_id==$discount_user_id) ? false : true;
    }
    private function checkHouse($house_id,$discount_house_id){
        return ($house_id==$discount_house_id) ? false :true;
    }
    private function checkZone($city,$discount_house_city){
        return (strcasecmp($city,$discount_house_city)==0) ? false :true;
    }
    private function checkMinimumDiscount($total,$minimum_discount_price){
        return ($total>=$minimum_discount_price) ? false :true;
    }
    private function checkCount($count){
        return($count==0)? true :false;
    }


}