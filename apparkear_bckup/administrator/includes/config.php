<?php
session_start();

error_reporting(1);
ini_set('display_errors', 1);

define("ROOT_DIR", dirname(__FILE__) . "/../..");
//define("ROOMARATE", true);
define('SITE_URL', 'http://13.233.43.252/team4/apparkear/');
define('BASE_URL', 'http://13.233.43.252/team4/apparkear/administrator/');

//include ROOT_DIR . '/class/mysql.class.php';
// include 'db.conf.php';
$link = mysqli_connect("localhost", "root", "Host@123456","apparkear") or die("Error in Connection. Check Server Configuration.");

//mysql_select_db("apparkear", $link) or die("Database not Found. Please Create the Database.");

$site_settings = mysqli_fetch_array(mysqli_query($link,"SELECT * FROM `estejmam_sitesettings` WHERE id='1'"));
//print_r($site_settings);exit;
//if ($_SESSION['lang'] == 'Arabic') {

//    include('lang/ar.php');

//} else {

//    include('lang/en.php');

//}

/* $site_settings = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_sitesettings` WHERE id='1'"));

$ip = $_SERVER['REMOTE_ADDR'];

if (isset($_SESSION['lat'])) {

if ($_SESSION['lat'] == '') {

$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

$loc = explode(',', $details->loc);

$_SESSION['lat'] = $loc[0];

$_SESSION['long'] = $loc[1];

}

} else {

$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

$loc = explode(',', $details->loc);

$_SESSION['lat'] = $loc[0];

$_SESSION['long'] = $loc[1];

} */

/* function distance($lat1, $lng1, $lat2, $lng2, $unit) {

$theta = $lon1 - $lon2;

$dist = sin(deg2rad($lat1))*sin(deg2rad($lat2)) +  cos(deg2rad($lat1))*cos(deg2rad($lat2)) * cos(deg2rad($theta));

$dist = acos($dist);

$dist = rad2deg($dist);

$miles = $dist*60*1.1515;

$unit = strtoupper($unit);

if ($unit == "K") {

return ($miles * 1.609344);

} else if ($unit == "N") {

return ($miles * 0.8684);

} else {

return $miles;

}

} */

// COOKIE

function NewImageName($name)
{
    $name = strtolower($name);
    $name = strip_tags($name);
    $name = str_replace(" ", "_", $name);
    return $name;
}
function UrlGen($param)
{
    $replace = array(" ", "'", '"', "`", "/", ',', '!', '(', ')');
    $replaceTo = array("-", "", '', "", "");
    $param = strip_tags($param);
    $param = strtolower($param);
    $param = str_replace($replace, $replaceTo, $param);
    return $param;
}

function clean_url($url)
{

    if ($url == '') {
        return;
    }

    $url = str_replace("http://", "", strtolower($url));

    $url = str_replace("https://", "", $url);

    if (substr($url, 0, 4) == 'www.') {
        $url = substr($url, 4);
    }

    $url = explode('/', $url);

    $url = reset($url);

    $url = explode(':', $url);

    $url = reset($url);

    return $url;

}

$domain_cookie = explode(".", clean_url($_SERVER['HTTP_HOST']));

$domain_cookie_count = count($domain_cookie);

$domain_allow_count = -2;

if ($domain_cookie_count > 2) {

    if (in_array($domain_cookie[$domain_cookie_count - 2], array('com', 'net', 'org'))) {
        $domain_allow_count = -3;
    }

    if ($domain_cookie[$domain_cookie_count - 1] == 'ua') {
        $domain_allow_count = -3;
    }

    $domain_cookie = array_slice($domain_cookie, $domain_allow_count);

}

$domain_cookie = "." . implode(".", $domain_cookie);

define('DOMAIN', $domain_cookie);

function set_cookie($name, $value, $expires)
{

    if ($expires) {

        $expires = time() + ($expires * 86400);

    } else {

        $expires = false;

    }

    if (PHP_VERSION < 5.2) {

        setcookie($name, $value, $expires, "/", DOMAIN . "; HttpOnly");

    } else {

        setcookie($name, $value, $expires, "/", DOMAIN, null, true);

    }

}

// COOKIE

function is_logged_in()
{

    return isset($_SESSION['user_id']);

}

function curencyrateAndSymbol()
{

    $data = array();
    $data = array(

        'rate' => '1',

        'symbol' => '£',

        'country' => 'GB',

        'currencyCode' => 'GBP',

    );

    return $data;
    $currency_allow = array('GBP', 'EUR', 'USD', 'JPY', 'AUD', 'CHF', 'CAD', 'HKD', 'BRL', 'AED');

    if (isset($_SESSION['curr']) and !in_array($_SESSION['curr'], $currency_allow)) {

        $_SESSION['curr'] = "GBP";

    }

    if (isset($_SESSION['curr']) && $_SESSION['curr'] != '') {

        if ($_SESSION['curr'] == 'GBP') {

            $data = array(

                'rate' => '1',

                'symbol' => '£',

                'country' => 'GB',

                'currencyCode' => 'GBP',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'EUR') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'EUR';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => '‎€',

                'country' => '',

                'currencyCode' => 'EUR',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'USD') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'USD';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => '$',

                'country' => 'USA',

                'currencyCode' => 'USD',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'JPY') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'JPY';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => '¥',

                'country' => 'JPN',

                'currencyCode' => 'JPY',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'AUD') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'AUD';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => 'A$',

                'country' => 'AUS',

                'currencyCode' => 'AUD',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'CHF') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'CHF';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => '₣',

                'country' => 'CHE',

                'currencyCode' => 'CHF',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'CAD') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'CAD';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => 'C$',

                'country' => 'CAN',

                'currencyCode' => 'CAD',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'HKD') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'HKD';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => 'HK$',

                'country' => 'HKG',

                'currencyCode' => 'HKD',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'BRL') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'BRL';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => 'R$',

                'country' => 'BRA',

                'currencyCode' => 'BRL',

            );

            return $data;

        }

        if ($_SESSION['curr'] == 'AED') {

            $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

            $data1 = json_decode($rateJson);

            $currencyCode = 'AED';

            $convertionRate = $data1->rates->$currencyCode;

            $data = array(

                'rate' => $convertionRate,

                'symbol' => 'د.إ',

                'country' => 'ARE',

                'currencyCode' => 'AED',

            );

            return $data;

        }

    } else {

        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        $query = unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

        $asdl = file_get_contents('currency.json');

        $object = json_decode($asdl);

        $rateJson = file_get_contents('http://api.fixer.io/latest?base=GBP');

        $data1 = json_decode($rateJson);

        $countryCode = $query["countryCode"];

        $currencyCode = $object->$query["countryCode"];

        $convertionRate = $data1->rates->$currencyCode;

        if (!in_array($currencyCode, $currency_allow)) {

            $currencyCode = "GBP";

            $convertionRate = '1';

            $symbol = '£';

            $countryCode = 'GB';

        } else {

            $symbolJson = file_get_contents('https://restcountries.eu/rest/v2/alpha/' . $query["countryCode"]);

            $symbolDecoded = json_decode($symbolJson);

            $symbolAray = $symbolDecoded->currencies;

            $symbol = $symbolAray[0]->symbol;

        }

        $currency = '';

        return $data = array(

            'rate' => $convertionRate,

            'symbol' => $symbol,

            'country' => $countryCode,

            'currencyCode' => $currencyCode,

        );

    }

}
