<?php
require_once('Kavenegar/KavenegarApi.php');

if (!function_exists('sendSMS')) {

    /**
     * send sms
     *
     * @return string
     */
    function sendSMS($message, $recipients)
    {
    	$apiKey="4834755331776A34522F345A6E613462713351674E773D3D";
        $api = new KavenegarApi($apiKey);
        $sendor = "10007892";

        try{
            $result = $api->Send($recipients, $sendor, $message);
        }
        catch(ApiException $e){
            Log::error($e->errorMessage());
        }
        catch(HttpException $e){
            Log::error($e->errorMessage());
        }

    	/* Iran SMS
	    $curl = curl_init();

        curl_setopt_array($curl, array(
	        CURLOPT_URL => "http://api.smsapp.ir/v2/sms/send/bulk2",
	        CURLOPT_CUSTOMREQUEST => "POST",
	        CURLOPT_POSTFIELDS => "message=".$message."&receptor=".implode(',', $recipients).",&sender=50001212121713",
	        CURLOPT_HTTPHEADER => array("apikey: RbtpOZPWDXbU0E7NY9YUimhLvnk2IrdTnd4qZ91dZv0", ),
	        CURLOPT_RETURNTRANSFER => 1,
        ));

        $res = curl_exec($curl);
        $err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
        } else {
			return $res;
		}
		*/
    }


		//try{
		//	$client = new \SoapClient("http://parsasms.com/webservice/v2.asmx?WSDL");

			/*
			$client = new \SoapClient('http://sms-webservice.ir/v1/v1.asmx?WSDL');

			$parameters['Username'] = "09124490751";
			$parameters['PassWord'] = "shabeziba";
			$parameters['SenderNumber'] = "50002030223";
			$parameters['RecipientNumbers'] = $recipients;
			$parameters['MessageBodie'] = $message;
			$parameters['Type'] = 1;
			$parameters['AllowedDelay'] = 0;
			*/

		//	$parameters = array(
		//		'username' 	=> 'shab.ir',
		//		'password' 	=> 'sh2115621',
		//		'senderNumbers' => array('20008580'),
		//		'recipientNumbers'=> $recipients,
		//		'messageBodies' => array($message)
		//	);
		   
			/*
			$res = $client->GeCredit($parameters);
			
			if ($res->GeCreditResult < 100)
			{
				Mail::send('emails.welcome', ['content' => 'به شب خوش آمدید.'], function ($message) {
				    $message->from('automated@shab.ir', 'Shab.ir');

				    $message->to('niksefat@shabr.ir');
				});

				#notification email
				//echo 'Low credit.';

			}
			*/

			
			//return $client->SendMessage($parameters);
		//	return $client->SendSMS($parameters);

			/*
			foreach ($res->SendMessageResult as $r)
				echo $r;
			*/
		//} 
		//catch (SoapFault $ex) 
		//{
		//	return $ex->faultstring;
		//}
    //}
}

if (!function_exists('sendActivationCode')) {

    /**
     * send sms activation code
     *
     * @return string
     */
    function sendActivationCode($token, $receptor)
    {
    	$apiKey="4834755331776A34522F345A6E613462713351674E773D3D";
        $api = new KavenegarApi($apiKey);
        $template = "verify";

        try{
            $result = $api->VerifyLookup($receptor,$token,$template);
        }
        catch(ApiException $e){
            Log::error($e->errorMessage());
        }
        catch(HttpException $e){
            Log::error($e->errorMessage());
        }   
    }
}
