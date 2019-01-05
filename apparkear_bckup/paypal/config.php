<?php
include 'administrator/includes/config.php';
//start session in all pages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} //PHP >= 5.4.0
//if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above
// sandbox or live
define('PPL_MODE', 'nosandbox');

if (PPL_MODE == 'sandbox') {

    define('PPL_API_USER', 'nits.arpita_api1.gmail.com');
    define('PPL_API_PASSWORD', '1383658129');
    define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AKsVq2ka8e2MK-zCBP3Um9xHlsFO');
} else {

    define('PPL_API_USER', 'roomarate_api1.gmail.com');
    define('PPL_API_PASSWORD', 'R3H2PHYF2PPYTVUS');
    // define('PPL_API_SIGNATURE', 'fsfsggggwegewgwegewgwe8');
    define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AU-jguoVKZAIAVn.SlI6UQsyRBL8');
}

define('PPL_LANG', 'EN');

define('PPL_LOGO_IMG', SITE_URL.'images/SCE-BLACK.jpg');

define('PPL_RETURN_URL', SITE_URL . 'process.php');
define('PPL_CANCEL_URL', SITE_URL . 'failure.php');

define('PPL_CURRENCY_CODE', 'GBP');
