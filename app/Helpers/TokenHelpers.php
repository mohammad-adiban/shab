<?php

namespace App\Helpers;

use App\User;
use App\Discount;
use Carbon\Carbon;
use Auth;
use JWTAuth;
use DB;
class TokenHelpers
{
    public function regsiterPushTokens($user_id,$token)
    {
       $push_token= DB::table('push_tokens')->insertGetId(

           ['user_id' => $user_id , 'push_tokens' => $token]
       );
       if($push_token){
          return response()->json(['status' => 'success', 'error' => '']);

       }
       else{
           return response()->json(['status' => '', 'error' => 'success']);
       }

    }
    public function DeleteAllPushTokens($user_id){
        if(DB::table('push_tokens')->where('user_id', '=', $user_id)->delete()){
            return response()->json([
               'status'=>'success'
            ]);
        }
        else{
            return response()->json([
                'status'=>'error'
            ]);
        }
    }

}