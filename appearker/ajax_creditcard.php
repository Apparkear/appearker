<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
?>

<?php

function PPHttpPost($methodName_, $nvpStr_, $SANDBOX_Env = 'on', $API_UserName, $API_Password, $API_Signature) {

    if ($SANDBOX_Env == 'on') {
        $mode = 'test';
    }
    if ($mode == "test") {
        /*         * *******
         * use sandbox credentials
         */
        $SANDBOX_Env = "on";
    } else {
        /*         * ******
         * use live credentials
         */
        $SANDBOX_Env = "off";
        $API_UserName = urlencode($API_UserName);
        $API_Password = urlencode($API_Password);
        $API_Signature = urlencode($API_Signature);
    }
    // Set up your API credentials, PayPal end point, and API version.



    $API_Endpoint = "https://api-3t.paypal.com/nvp";

    if ($SANDBOX_Env == 'on') {
        $API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
    } else {
        $API_Endpoint = "https://api-3t.paypal.com/nvp";
    }
    $version = urlencode('51.0');

    // Set the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    // Turn off the server and peer verification (TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Set the API operation, version, and API signature in the request.
    $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

    // Set the request as a POST FIELD for curl.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

    // Get response from the server.
    $httpResponse = curl_exec($ch);

    if (!$httpResponse) {
        exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
    }

    // Extract the response details.
    $httpResponseAr = explode("&", $httpResponse);

    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $i => $value) {
        $tmpAr = explode("=", $value);
        if (sizeof($tmpAr) > 1) {
            $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
        }
    }

    if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
        exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    }

    return $httpParsedResponseAr;
}
?>



<?php

//$apiusername = 'nits.arpita_api1.gmail.com';
//$apipassword = '1383658129';
//$apisignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AKsVq2ka8e2MK-zCBP3Um9xHlsFO';

$apiusername = 'nits.bikash_api1.gmail.com';
$apipassword = '9ACW9MU9VJMC5G9W';
$apisignature = 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ay0SmsVqjrqO-tuzDg4JZ2r35yYN';



$cardno = $_REQUEST['card_number'];

//$exp = explode('/', $_REQUEST['exp_date']);

$exmonth = $_REQUEST['exp_date'];
$exyear = $_REQUEST['exp_month'];
$cvv = $_REQUEST['cvv'];


$price = $_SESSION['sendtotal'];
$creditCardNumber = $cardno;
$padDateMonth = $exmonth;
$expDateYear = $exyear;
$cvv2Number = $cvv;

$currencyCode = 'USD';
$paymentAction = 'Sale';
$methodToCall = 'doDirectPayment';
$nvpRecurring = '';

$nvpstr = "&PAYMENTACTION=" . $paymentAction . "&AMT=" . $price . "&ACCT=" . $creditCardNumber . "&EXPDATE=" . $padDateMonth . $expDateYear . "&CVV2=" . $cvv2Number . "&CURRENCYCODE=" . $currencyCode;

$API_UserName = $apiusername;
$API_Password = $apipassword;
$API_Signature = $apisignature;

$resArray = PPHttpPost($methodToCall, $nvpstr, 'on', $API_UserName, $API_Password, $API_Signature);

echo "<pre>";
print_r($resArray);
exit;


if ($resArray['ACK'] == 'Success') {

    $latid = $_SESSION['last_id'];
    $propertyId = $_SESSION['property_id'];

    $tranid = time();
    $sql = mysql_query("update `estejmam_booking` set `status`=1,`transaction_id`='" . $tranid . "' where `id`='" . $latid . "'");

    echo "1";
} else {
    echo "0";
}
?>