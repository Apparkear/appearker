<?php

//$url = trim("https://svcs.sandbox.paypal.com/AdaptiveAccounts/GetVerifiedStatus");  //set PayPal Endpoint to sandbox
$url = trim("https://svcs.paypal.com/AdaptiveAccounts/GetVerifiedStatus");         //set PayPal Endpoint to Live 

$API_UserName = "payments_api1.errandchampion.com";                                //PayPal Test API Credentials, Replace it with live if in live mode
$API_Password = "YNMSEMNDWVC2HSDD";
$API_Signature = "AiPC9BjkCyDFQXbSkoZcgqH3hpacAXt.TxUdTG0SA9.kVvPwuUExm5fG";
$API_AppID = "APP-0VC55786UV787374J";                                       //Default App ID for Sandbox, replace it with live id if in live mode   
$API_RequestFormat = "NV";
$API_ResponseFormat = "NV";

//Create request payload 
$bodyparams = array("requestEnvelope.errorLanguage" => "en_US",
    "emailAddress" => "nits.arpita@gmail.com",
    "firstName" => "Arpita",
    "lastName" => "Bose",
    "matchCriteria" => "NAME"
);

// convert payload array into url encoded query string
$body_data = http_build_query($bodyparams, "", chr(38));

try {
    //create request and add headers
    $params = array("http" => array(
            "method" => "POST",
            "content" => $body_data,
            "header" => "X-PAYPAL-SECURITY-USERID:     " . $API_UserName . "\r\n" .
            "X-PAYPAL-SECURITY-SIGNATURE:  " . $API_Signature . "\r\n" .
            "X-PAYPAL-SECURITY-PASSWORD:   " . $API_Password . "\r\n" .
            "X-PAYPAL-APPLICATION-ID:      " . $API_AppID . "\r\n" .
            "X-PAYPAL-REQUEST-DATA-FORMAT: " . $API_RequestFormat . "\r\n" .
            "X-PAYPAL-RESPONSE-DATA-FORMAT:" . $API_ResponseFormat . "\r\n"
    ));


    $ctx = stream_context_create($params);  //create stream context
    $fp = @fopen($url, "r", false, $ctx);   //open the stream and send request
    $response = stream_get_contents($fp);   //get response
    //check to see if stream is open
    if ($response === false) {
        throw new Exception("php error message = " . "$php_errormsg");
    }

    fclose($fp);    //close the stream
    //parse the ap key from the response

    $keyArray = explode("&", $response);

    foreach ($keyArray as $rVal) {
        list($qKey, $qVal) = explode("=", $rVal);
        $kArray[$qKey] = $qVal;
    }

//print the request to screen for testing purposes

    echo "<br><br>" . "Response:" . "<br>";

//print the response to screen for testing purposes
    If ($kArray["responseEnvelope.ack"] == "Success") {

        foreach ($kArray as $key => $value) {
            echo $key . ": " . $value . "<br/>";
        }
    } else {
        foreach ($kArray as $key => $value) {
            echo $key . ": " . $value . "<br/>";
        }
    }
} catch (Exception $e) {
    echo "Message: ||" . $e->getMessage() . "||";
}

echo "<br>";
?>