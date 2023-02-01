<?php
use Illuminate\Support\Facades\Log;

if (!function_exists('bpPayRequest')) {

    /**
     * Mellat Behpardakht request payment
     *
     * @return string
     */
    function bpPayRequest($orderId, $amount, $additionalData, $callBackUrl)
    {
        try {
            $client = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',array('exceptions' => true,));
        } catch ( SoapFault $e ) {
            return 'error';
        }

        //$client = new soapclient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
        $parameters = array(
            'terminalId' => '2790616',
            'userName' => 'shab258',
            'userPassword' => '19987324',
            'orderId' => $orderId,
            'amount' => $amount,
            'localDate' => date('Ymd'),
            'localTime' => date('His'),
            'additionalData' => $additionalData,
            'callBackUrl' => $callBackUrl,
            'payerId' => 0);
        $result = $client->bpPayRequest($parameters, $namespace);

        $resultStr  = $result->return;

        $res = explode (',',$resultStr);
        $ResCode = $res[0];
        
        if ($ResCode == "0") {
            // Update table, Save RefId
            return $res[1];
        }
        elseif($ResCode == "41") {
            return bpPayRequest(random_str(mt_rand(6,18), $keyspace = '0123456789'), $amount, $additionalData, $callBackUrl);
        }
        else {
            return 'error';
            // log error in app
            // Update table, log the error
            // Show proper message to user
        }

    }
}

if (!function_exists('bpVerifyRequest')) {

    /**
     * Mellat Behpardakht verify payment
     *
     * @return string
     */
    function bpVerifyRequest($orderId, $verifySaleReferenceId)
    {
        try {
            $client = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',array('exceptions' => true,));
        } catch ( SoapFault $e ) {
            return 'error';
        }

        //$client = new soapclient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
		$parameters = array(
			'terminalId' => '2790616',
            'userName' => 'shab258',
            'userPassword' => '19987324',
			'orderId' => $orderId,
			'saleOrderId' => $orderId,
			'saleReferenceId' => $verifySaleReferenceId);

		$result = $client->bpVerifyRequest($parameters, $namespace);

		$resultStr = $result->return;

        if ($resultStr == "0") {
			// Update Table, Save Verify Status
            return bpSettleRequest($orderId, $verifySaleReferenceId);
        } 
        else {
            return 'error';
        }
    }
}

if (!function_exists('bpSettleRequest')) {

    /**
     * Mellat Behpardakht settle payment
     *
     * @return string
     */
    function bpSettleRequest($orderId, $settleSaleReferenceId)
    {
        try {
            $client = new \SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',array('exceptions' => true,));
        } catch ( SoapFault $e ) {
            return 'error';
        }

        //$client = new soapclient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $namespace='http://interfaces.core.sw.bps.com/';
		$parameters = array(
			'terminalId' => '2790616',
            'userName' => 'shab258',
            'userPassword' => '19987324',
			'orderId' => $orderId,
			'saleOrderId' => $orderId,
			'saleReferenceId' => $settleSaleReferenceId);

		$result = $client->bpSettleRequest($parameters, $namespace);

		$resultStr = $result->return;

        if ($resultStr == "0") {
			// Update Table, Save Verify Status 
            return 'success';
        } 
        else {
            return 'error';
        }
    }
}