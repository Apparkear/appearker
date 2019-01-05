<?php
ob_start();
session_start();
include("administrator/includes/config.php");

//$ip = $_SERVER['REMOTE_ADDR'];

function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$ip = get_client_ip_env();
?>

<style>
    .month-table tr td.yellow-bg {
        background: #cbcbcb !important;
    }


    .month-table tr td.red-bg {
        background: #ed8585 !important;
    }

    .month-table tr td {
        text-align: center;
        background: #60d3b8 !important;
        border: 1px solid #fff !important;
        color: #fff;
    }

</style>


<?php
$firsthalfs = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun');
$secondhalfs = array('07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');

$totalmonths = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');

$montharray = array('0' => '01', '1' => '02', '2' => '03', '3' => '04', '4' => '05', '5' => '06', '6' => '07', '7' => '08', '8' => '09', '9' => '10', '10' => '11', '11' => '12');
?>


<?php
$propdetails = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where `slug` = '" . $_REQUEST['name'] . "'"));


$cityname = mysql_fetch_object(mysql_query("select * from `cities` where `id` = '" . $propdetails->city . "'"));
$starename = mysql_fetch_object(mysql_query("select * from `states` where `id` = '" . $cityname->state_id . "'"));
$country = mysql_fetch_object(mysql_query("select * from `countries` where `id` = '" . $starename->country_id . "'"));

$proptype = mysql_fetch_object(mysql_query("select * from `estejmam_property_type` where `id`='" . $propdetails->prop_type . "'"));

$code = $country->sortname;


$proplistcount = mysql_num_rows(mysql_query("select * from `estejmam_main_property` where city='" . $cityname->id . "'"));

$parent_count = mysql_num_rows(mysql_query("select * from `estejmam_main_property` where `parent_id`='" . $propdetails->id . "'"));


$wish = mysql_num_rows(mysql_query("SELECT * from `estejmam_wishlist` where  `prop_id`= '" . $propdetails->id . "' and `ip`='" . $ip . "'"));


if ($propdetails->type_of_contract == 1) {
    $type_of_contract = "Monthly";
}
if ($propdetails->type_of_contract == 2) {
    $type_of_contract = "Fortnightly";
}
if ($propdetails->type_of_contract == 3) {
    $type_of_contract = "Daily";
}


if ($propdetails->ninimum_stay == 30) {
    $ninimum_stay = "1 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 60) {
    $ninimum_stay = "2 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 90) {
    $ninimum_stay = "3 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 120) {
    $ninimum_stay = "4 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 150) {
    $ninimum_stay = "5 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 180) {
    $ninimum_stay = "6 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 210) {
    $ninimum_stay = "7 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 240) {
    $ninimum_stay = "8 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 270) {
    $ninimum_stay = "9 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 300) {
    $ninimum_stay = "10 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 330) {
    $ninimum_stay = "11 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 360) {
    $ninimum_stay = "12 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 390) {
    $ninimum_stay = "13 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 420) {
    $ninimum_stay = "14 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 450) {
    $ninimum_stay = "15 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 480) {
    $ninimum_stay = "16 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 510) {
    $ninimum_stay = "17 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 540) {
    $ninimum_stay = "18 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 570) {
    $ninimum_stay = "19 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 600) {
    $ninimum_stay = "20 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 630) {
    $ninimum_stay = "21 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 660) {
    $ninimum_stay = "22 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 690) {
    $ninimum_stay = "23 months (" . $propdetails->ninimum_stay . " days)";
}
if ($propdetails->ninimum_stay == 720) {
    $ninimum_stay = "24 months (" . $propdetails->ninimum_stay . " days)";
}



if ($propdetails->maximum_stay == 30) {
    $maximum_stay = "1 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 60) {
    $maximum_stay = "2 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 90) {
    $maximum_stay = "3 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 120) {
    $maximum_stay = "4 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 150) {
    $maximum_stay = "5 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 180) {
    $maximum_stay = "6 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 210) {
    $maximum_stay = "7 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 240) {
    $maximum_stay = "8 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 270) {
    $maximum_stay = "9 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 300) {
    $maximum_stay = "10 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 330) {
    $maximum_stay = "11 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 360) {
    $maximum_stay = "12 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 390) {
    $maximum_stay = "13 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 420) {
    $maximum_stay = "14 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 450) {
    $maximum_stay = "15 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 480) {
    $maximum_stay = "16 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 510) {
    $maximum_stay = "17 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 540) {
    $maximum_stay = "18 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 570) {
    $maximum_stay = "19 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 600) {
    $maximum_stay = "20 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 630) {
    $maximum_stay = "21 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 660) {
    $maximum_stay = "22 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 690) {
    $maximum_stay = "23 months (" . $propdetails->maximum_stay . " days)";
}
if ($propdetails->maximum_stay == 720) {
    $maximum_stay = "24 months (" . $propdetails->maximum_stay . " days)";
}

$date = date("Y-m-d");
$next_date = date('Y-m-d', strtotime($date . ' +' . $propdetails->maximum_stay . 'day'));




$prop_booking = mysql_fetch_array(mysql_query("select * from `estejmam_booking` where `prop_id`='" . $propdetails->id . "'"));
$owcount = mysql_num_rows(mysql_query("select * from `estejmam_booking` where `prop_id`='" . $propdetails->id . "'"));
$startdate = $prop_booking['start_date'];
$enddate = $prop_booking['end_date'];



$prop_booking_date = mysql_query("select * from `estejmam_booking` where `prop_id`='" . $propdetails->id . "'");
while ($alldate = mysql_fetch_array($prop_booking_date)) {
    $start_date_booking = explode('-', $alldate['start_date']);
    $sdt[] = $start_date_booking[1];
    $end_date_booking = explode('-', $alldate['end_date']);
    $edt[] = $end_date_booking[1];
}

$marge = array_merge($sdt, $edt);

function createDateRangeArray($strDateFrom, $strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

$val = createDateRangeArray($startdate, $enddate);
$val = implode('","', $val);

function GetDays($sStartDate, $sEndDate) {
    // Firstly, format the provided dates.  
    // This function works best with YYYY-MM-DD  
    // but other date formats will work thanks  
    // to strtotime().  
    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

    // Start the variable off with the start date  
    $aDays[] = $sStartDate;

    // Set a 'temp' variable, sCurrentDate, with  
    // the start date - before beginning the loop  
    $sCurrentDate = $sStartDate;

    // While the current date is less than the end date  
    while ($sCurrentDate < $sEndDate) {
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;
    }

    // Once the loop has finished, return the  
    // array of days.  
    return $aDays;
}

////////////////////////////////////////Start Current Year/////////////////////////////////////////////



$totaldate = array();
//echo "select * from `estejmam_booking` where `prop_id` = '" . $propdetails->id . "' and (YEAR(`start_date`)=YEAR(CURDATE()) or YEAR(`end_date`)=YEAR(CURDATE()))";
$blockd = mysql_query("select * from `estejmam_booking` where `prop_id` = '" . $propdetails->id . "' and (YEAR(`start_date`)=YEAR(CURDATE()) or YEAR(`end_date`)=YEAR(CURDATE()))");
while ($allbkdates = mysql_fetch_array($blockd)) {
    $start_date = $allbkdates['start_date'];
    $end_date = $allbkdates['end_date'];
    $array = GetDays($start_date, $end_date);
    array_push($totaldate, $array);
}


//echo "<pre>";
//print_r($totaldate);
//exit;


foreach ($totaldate as $totaldates) {
    foreach ($totaldates as $finaltotaldates) {

        //echo "<pre>";
        //echo $finaltotaldates;

        $exps = explode('-', $finaltotaldates);


        if ($exps[1] == '01') {
            $janarray[] = $exps[2];
        }

        if ($exps[1] == '02') {
            $febarray[] = $exps[2];
        }

        if ($exps[1] == '03') {
            $mararray[] = $exps[2];
        }

        if ($exps[1] == '04') {
            $aprarray[] = $exps[2];
        }

        if ($exps[1] == '05') {
            $mayarray[] = $exps[2];
        }

        if ($exps[1] == '06') {
            $junarray[] = $exps[2];
        }

        if ($exps[1] == '07') {
            $jularray[] = $exps[2];
        }

        if ($exps[1] == '08') {
            $augarray[] = $exps[2];
        }

        if ($exps[1] == '09') {
            $separray[] = $exps[2];
        }
        if ($exps[1] == '10') {
            $octarray[] = $exps[2];
        }
        if ($exps[1] == '11') {
            $novarray[] = $exps[2];
        }
        if ($exps[1] == '12') {
            $decarray[] = $exps[2];
        }
    }
}
//exit;
//echo "<pre>";
//print_r($separray);
//exit;


if ($janarray == '') {
    $janarray = 0;
} else {
    $mainjanarray = $janarray;
    $janarray = count($janarray);
}

if ($febarray == '') {
    $febarray = 0;
} else {
    $mainfebarray = $febarray;
    $febarray = count($febarray);
}

if ($mararray == '') {
    $mararray = 0;
} else {
    $mainmararray = $mararray;
    $mararray = count($mararray);
}

if ($aprarray == '') {
    $aprarray = 0;
} else {
    $mainaprarray = $aprarray;
    $aprarray = count($aprarray);
}

if ($mayarray == '') {
    $mayarray = 0;
} else {
    $mainmayarray = $mayarray;
    $mayarray = count($mayarray);
}

if ($junarray == '') {
    $junarray = 0;
} else {
    $mainjunarray = $junarray;
    $junarray = count($junarray);
}

if ($jularray == '') {
    $jularray = 0;
} else {
    $mainjularray = $jularray;
    $jularray = count($jularray);
}

if ($augarray == '') {
    $augarray = 0;
} else {
    $mainaugarray = $augarray;
    $augarray = count($augarray);
}

if ($separray == '') {
    $separray = 0;
} else {
    $mainseparray = $separray;
    $separray = count($separray);
}

if ($octarray == '') {
    $octarray = 0;
} else {
    $mainoctarray = $octarray;
    $octarray = count($octarray);
}

if ($novarray == '') {
    $novarray = 0;
} else {
    $mainnovarray = $novarray;
    $novarray = count($novarray);
}

if ($decarray == '') {
    $decarray = 0;
} else {
    $maindecarray = $decarray;
    $decarray = count($decarray);
}


//echo "<pre>";
//print_r($mainmayarray);
//exit;
////////////////////////////////////////////End Current Year///////////////////////////////////////////////
////////////////////////////////////////////Start Next Year/////////////////////////////////////////////////

$nextyear = date("Y") + 1;


$totaldatenextyear = array();
//echo "SELECT * FROM estejmam_booking WHERE `prop_id`='".$propdetails->id."' AND (YEAR(`start_date`) = YEAR(CURDATE()) + 1 OR YEAR(`end_date`) = YEAR(CURDATE()) + 1) ";
$blockd1 = mysql_query("SELECT * FROM estejmam_booking WHERE `prop_id`='" . $propdetails->id . "' AND (YEAR(`start_date`) = YEAR(CURDATE()) + 1 OR YEAR(`end_date`) = YEAR(CURDATE()) + 1)");
while ($allbkdates1 = mysql_fetch_array($blockd1)) {
    $start_date1 = $allbkdates1['start_date'];
    $end_date1 = $allbkdates1['end_date'];
    $array1 = GetDays($start_date1, $end_date1);
    array_push($totaldatenextyear, $array1);
}



foreach ($totaldatenextyear as $totaldatenextyears) {
    foreach ($totaldatenextyears as $finaltotaldatesnextyear) {

        //echo "<pre>";
        //echo $finaltotaldates;

        $expsnext = explode('-', $finaltotaldatesnextyear);


        if ($expsnext[1] == '01') {
            $janarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '02') {
            $febarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '03') {
            $mararraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '04') {
            $aprarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '05') {
            $mayarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '06') {
            $junarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '07') {
            $jularraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '08') {
            $augarraynext[] = $expsnext[2];
        }

        if ($expsnext[1] == '09') {
            $separraynext[] = $expsnext[2];
        }
        if ($expsnext[1] == '10') {
            $octarraynext[] = $expsnext[2];
        }
        if ($expsnext[1] == '11') {
            $novarraynext[] = $expsnext[2];
        }
        if ($expsnext[1] == '12') {
            $decarraynext[] = $expsnext[2];
        }
    }
}
//exit;
//echo "<pre>";
//print_r($separray);
//exit;


if ($janarraynext == '') {
    $janarraynext = 0;
} else {
    $mainjanarraynext = $janarraynext;
    $janarraynext = count($janarraynext);
}

if ($febarraynext == '') {
    $febarraynext = 0;
} else {
    $mainfebarraynext = $febarraynext;
    $febarraynext = count($febarraynext);
}

if ($mararraynext == '') {
    $mararraynext = 0;
} else {
    $mainmararraynext = $mararraynext;
    $mararraynext = count($mararraynext);
}

if ($aprarraynext == '') {
    $aprarraynext = 0;
} else {
    $mainaprarraynext = $aprarraynext;
    $aprarraynext = count($aprarraynext);
}

if ($mayarraynext == '') {
    $mayarraynext = 0;
} else {
    $mainmayarraynext = $mayarraynext;
    $mayarraynext = count($mayarraynext);
}

if ($junarraynext == '') {
    $junarraynext = 0;
} else {
    $mainjunarraynext = $junarraynext;
    $junarraynext = count($junarraynext);
}

if ($jularraynext == '') {
    $jularraynext = 0;
} else {
    $mainjularraynext = $jularraynext;
    $jularraynext = count($jularraynext);
}

if ($augarraynext == '') {
    $augarraynext = 0;
} else {
    $mainaugarraynext = $augarraynext;
    $augarraynext = count($augarraynext);
}

if ($separraynext == '') {
    $separraynext = 0;
} else {
    $mainseparraynext = $separraynext;
    $separraynext = count($separraynext);
}

if ($octarraynext == '') {
    $octarraynext = 0;
} else {
    $mainoctarraynext = $octarraynext;
    $octarraynext = count($octarraynext);
}

if ($novarraynext == '') {
    $novarraynext = 0;
} else {
    $mainnovarraynext = $novarraynext;
    $novarraynext = count($novarraynext);
}

if ($decarraynext == '') {
    $decarraynext = 0;
} else {
    $maindecarraynext = $decarraynext;
    $decarraynext = count($decarraynext);
}




////////////////////////////////////////////End Next Year///////////////////////////////////////////////
//$alltotalnewarray = array();
$alltotalnewarray = array_merge($totaldate, $totaldatenextyear);

//echo "<pre>";
//print_r($alltotalnewarray);
//exit;
?>


<?php
$val = "select DAYOFMONTH(`start_date`) AS DAY from `estejmam_booking` where MONTH(`start_date`) =MONTH(CURDATE()) and YEAR(`start_date`)=YEAR(CURDATE()) GROUP BY DAYOFMONTH(`start_date`)";

$val1 = "SELECT MONTH(`start_date`) MONTH, COUNT(*) COUNT FROM estejmam_booking WHERE YEAR(`start_date`)=YEAR(CURDATE()) GROUP BY MONTH(`start_date`)";

$val2 = "SELECT * FROM estejmam_booking WHERE `prop_id`='9' AND (YEAR(`start_date`) = YEAR(CURDATE()) + 1 OR YEAR(`end_date`) = YEAR(CURDATE()) + 1) ";
?>



<!DOCTYPE HTML>
<html>
    <head>
        <title>ROOMARATE</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Add custom CSS here -->
        <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">  
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/ionicons.css" rel="stylesheet">
        <link href="css/jquery.bxslider.css" rel="stylesheet">
    </head>
    <body>
        <div class="l-main-menu">
            <div class="search-menu">
                <nav class="menu menu-mobile-disabled">
                    <div class="menu_toggle"></div>
                    <div class="menu_items">
                        <div class="menu_items-main-top">
                            <ul>
                                <li><a class="" href="index.php"><img src="images/r_logo.png" alt="" style="width:38px;height:auto;display: block;margin:0 auto;"/></a></li>
                                <li><a class="" href="javascript:void(0);"><i class="fa fa-compass" aria-hidden="true" onclick="openExplore();"></i> <span>Explore</span></a></li>
                                <li><a class="" href="cms.php?name=how-it-works"><i class="fa fa-globe" aria-hidden="true"></i> <span>how it works</span></a></li>
                                <li><a class="" href="favorite.php"><i class="ion-ios-heart-outline"></i> <span>favorites</span></a></li>
                            </ul>
                        </div>
                        <div class="menu_items-secondary-bottom">
                            <ul>
                                <li><a class="" href="">English <i class="fa fa-angle-down"></i></a></li>
                                <li><a class="" href="http://104.131.83.218/team4/roomarate/blog/">Blog</a></li>
                                <li><a class="" href="cms.php?name=about-us">About us</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="l-main-section">
        	<div class="search-menu-icon_details_page">☰</div>
            <div class="l-property-body">
                <h1><?php echo $propdetails->name ?></h1>
                <div class="breadcrumb">
                    <i class="fa fa-map-marker loc-icon"></i>
                    <a href=""><?php echo $cityname->name; ?></a>
                    <a href=""><?php echo $proptype->name ?> in <?php echo $cityname->name; ?></a>
                    <a href="">Room <?php echo $propdetails->unique_prop_id ?></a>
                </div>
                <ul class="nav nav-tabs custom-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><i class="ion-android-camera"></i> Photos</a></li>


                    <?php
                    if ($propdetails->video != '') {
                        ?>
                        <li role="presentation"><a href="#video" aria-controls="video" role="tab" data-toggle="tab"><i class="ion-videocamera"></i> Video</a></li>
                    <?php } ?>


                    <?php
                    if ($propdetails->floor_plan != '' || $propdetails->street_view != 0) {
                        ?>  
                        <li role="presentation" onclick="javascript:initialize();"><a href="#plan" aria-controls="plan" role="tab" data-toggle="tab"><i class="ion-map"></i> Plan</a></li>
                    <?php } ?>


                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="photos">
                        <ul class="bxslider2">
                            <?php
                            $slider = mysql_query("select * from `estejmam_image` where `prop_id`='" . $propdetails->id . "'");
                            while ($allslider = mysql_fetch_object($slider)) {
                                ?>
                                <li style="background: url('upload/property/<?php echo $allslider->image ?>') no-repeat top center; background-size: cover;"></li>
                            <?php } ?>
                        </ul>
                    </div>


                    <?php
                    if ($propdetails->video != '') {
                        ?>
                        <div role="tabpanel" class="tab-pane fade" id="video">
                            <ul>
                                <video style="width:100%;height:300px;" controls>
                                    <source src="upload/prop_video/<?php echo $propdetails->video; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>  
                            </ul>
                        </div>
                    <?php } ?>



                    <div role="tabpanel" class="tab-pane fade" id="plan">

                        <?php
                        if ($propdetails->floor_plan != '') {
                            ?>
                            <ul>
                                <li style="background: url('upload/floor_plan/<?php echo $propdetails->floor_plan ?>') no-repeat top center; background-size: cover;list-style-type:none;"></li>
                            </ul>

                        <?php } else { ?>
                            <div id="pano"></div>
                        <?php } ?>

                    </div>




                </div>
                <section class="details-section">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="room-description">
                                <h3>Room description</h3>
                                <p><?php echo $propdetails->room_description ?></p>
                                <ul class="prod-listing">
                                    <li>
                                        <?php
                                        $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($propdetails->amenities) order by `id` DESC limit 12");
                                        while ($amenities = mysql_fetch_object($amm)) {
                                            ?>

                                            <div class="icon-holder"><span><img src="upload/amentiesimage/<?php echo $amenities->img ?>" alt=""></span> <?php echo $amenities->img ?></div>
                                        <?php } ?>

                                    </li>
                                </ul>
                                <p>Not included: <?php echo $propdetails->not_included ?></p>










                                <!--------------------------------------------Current Year------------------------------------------------------>




                                <p><strong><?php echo date('Y') ?></strong></p>

                                <div class="mainContent">



                                    <?php
                                    $jan = '01';
                                    if ($jan < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Jan</span></div>
                                        <?php
                                    } else {
                                        if ($jan == date('m')) {
                                            $datejan = date('d') - 1;
                                            $remaningjandate = 31 - $datejan;
                                            $jandatecal = (($datejan * 100) / 31);

                                            if ($janarray > 0) {
                                                $totalbookeddatejan = (($remaningjandate * $janarray) / 31);
                                                $totalemptydatejan = $remaningjandate - $totalbookeddatejan;
                                            } else {
                                                $totalbookeddatejan = '0';
                                                $totalemptydatejan = 100 - $jandatecal;
                                            }

                                            $unbookjancal = 100 - $bookedjancal;
                                            $jancolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $jancolor ?>" style="width: <?php echo $jandatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jan</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejan ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejan; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjancal = (($janarray * 100) / 31);
                                            if ($bookedjancal == 100) {
                                                ?>
                                                <div class="singlePart red">Jan</div>
                                                <?php
                                            } elseif ($janarray == 0) {
                                                ?>
                                                <div class="singlePart green">Jan</div>
                                                <?php
                                            } else {
                                                $elsejanclacu = (($janarray * 100) / 31);
                                                $elsejanclacuremain = 100 - $elsejanclacu;
                                                $freejandays = $mainjanarray[$janarray - 1];
                                                ?>


                                                <?php
                                                if ($freejandays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejanclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jan</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejanclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejandays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejanclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jan</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejanclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>										   




                                    <?php
                                    $feb = '02';
                                    if ($feb < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Feb</span></div>
                                        <?php
                                    } else {
                                        if ($feb == date('m')) {
                                            $datefeb = date('d') - 1;
                                            $remaningfebdate = 28 - $datefeb;
                                            $febdatecal = (($datefeb * 100) / 28);

                                            if ($febarray > 0) {
                                                $totalbookeddatefeb = (($remaningfebdate * $febarray) / 28);
                                                $totalemptydatefeb = $remaningfebdate - $totalbookeddatefeb;
                                            } else {
                                                $totalbookeddatefeb = '0';
                                                $totalemptydatefeb = 100 - $febdatecal;
                                            }

                                            $unbookfebcal = 100 - $bookedfebcal;
                                            $febcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $febcolor ?>" style="width: <?php echo $febdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Feb</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatefeb ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatefeb; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedfebcal = (($febarray * 100) / 28);
                                            if ($bookedfebcal == 100) {
                                                ?>
                                                <div class="singlePart red">Feb</div>
                                                <?php
                                            } elseif ($febarray == 0) {
                                                ?>
                                                <div class="singlePart green">Feb</div>
                                                <?php
                                            } else {
                                                $elsefebclacu = (($febarray * 100) / 28);
                                                $elsefebclacuremain = 100 - $elsefebclacu;
                                                $freefebdays = $mainfebarray[$febarray - 1];
                                                ?>


                                                <?php
                                                if ($freefebdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsefebclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Feb</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsefebclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freefebdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsefebclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Feb</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsefebclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>





                                    <?php
                                    $mar = '03';
                                    if ($mar < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Mar</span></div>
                                        <?php
                                    } else {
                                        if ($mar == date('m')) {
                                            $datemar = date('d') - 1;
                                            $remaningmardate = 31 - $datemar;
                                            $mardatecal = (($datemar * 100) / 31);

                                            if ($mararray > 0) {
                                                $totalbookeddatemar = (($remaningmardate * $mararray) / 31);
                                                $totalemptydatemar = $remaningmardate - $totalbookeddatemar;
                                            } else {
                                                $totalbookeddatemar = '0';
                                                $totalemptydatemar = 100 - $mardatecal;
                                            }

                                            $unbookmarcal = 100 - $bookedmarcal;
                                            $marcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $marcolor ?>" style="width: <?php echo $mardatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Mar</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatemar ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatemar; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedmarcal = (($mararray * 100) / 31);
                                            if ($bookedmarcal == 100) {
                                                ?>
                                                <div class="singlePart red">Mar</div>
                                                <?php
                                            } elseif ($mararray == 0) {
                                                ?>
                                                <div class="singlePart green">Mar</div>
                                                <?php
                                            } else {
                                                $elsemarclacu = (($mararray * 100) / 31);
                                                $elsemarclacuremain = 100 - $elsemarclacu;
                                                $freemardays = $mainmararray[$mararray - 1];
                                                ?>


                                                <?php
                                                if ($freemardays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsemarclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Mar</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsemarclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freemardays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsemarclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Mar</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsemarclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>







                                    <?php
                                    $apr = '04';
                                    if ($apr < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Apr</span></div>
                                        <?php
                                    } else {
                                        if ($apr == date('m')) {
                                            $dateapr = date('d');
                                            $remaningaprdate = 30 - $dateapr;
                                            $aprdatecal = (($dateapr * 100) / 30);

                                            //$totalbookeddateapr = (($remaningaprdate*$aprarray)/30);
                                            //$totalemptydateapr = $remaningaprdate - $totalbookeddateapr;


                                            if ($aprarray > 0) {
                                                $totalbookeddateapr = (($remaningaprdate * $aprarray) / 30);
                                                $totalemptydateapr = $remaningaprdate - $totalbookeddateapr;
                                            } else {
                                                $totalbookeddateapr = '0';
                                                $totalemptydateapr = 100 - $aprdatecal;
                                            }



                                            $unbookaprcal = 100 - $bookedaprcal;
                                            $aprcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $aprcolor ?>" style="width: <?php echo $aprdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Apr</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateapr; ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateapr; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedaprcal = (($aprarray * 100) / 30);
                                            if ($bookedaprcal == 100) {
                                                ?>
                                                <div class="singlePart red">Apr</div>
                                                <?php
                                            } elseif ($aprarray == 0) {
                                                ?>
                                                <div class="singlePart green">Apr</div>
                                                <?php
                                            } else {
                                                $elseaprclacu = (($aprarray * 100) / 30);
                                                $elseaprclacuremain = 100 - $elseaprclacu;
                                                $freeaprdays = $mainaprarray[$aprarray - 1];
                                                ?>


                                                <?php
                                                if ($freeaprdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseaprclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Apr</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseaprclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeaprdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseaprclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Apr</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseaprclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    $may = '05';
                                    if ($may < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">May</span></div>
                                        <?php
                                    } else {
                                        if ($may == date('m')) {
                                            $datemay = date('d');
                                            $remaningmaydate = 31 - $datemay;
                                            $maydatecal = (($datemay * 100) / 31);

                                            //$totalbookeddateapr = (($remaningaprdate*$aprarray)/30);
                                            //$totalemptydateapr = $remaningaprdate - $totalbookeddateapr;


                                            if ($mayarray > 0) {
                                                $totalbookeddatemay = (($remaningmaydate * $mayarray) / 31);
                                                $totalemptydatemay = $remaningmaydate - $totalbookeddatemay;
                                            } else {
                                                $totalbookeddatemay = '0';
                                                $totalemptydatemay = 100 - $maydatecal;
                                            }



                                            $unbookmaycal = 100 - $bookedmaycal;
                                            $maycolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $maycolor ?>" style="width: <?php echo $maydatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">May</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatemay; ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatemay; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedmaycal = (($mayarray * 100) / 31);
                                            if ($bookedmaycal == 100) {
                                                ?>
                                                <div class="singlePart red">May</div>
                                                <?php
                                            } elseif ($mayarray == 0) {
                                                ?>
                                                <div class="singlePart green">May</div>
                                                <?php
                                            } else {
                                                $elsemayclacu = (($mayarray * 100) / 31);
                                                $elsemayclacuremain = 100 - $elsemayclacu;
                                                $freemaydays = $mainmayarray[$mayarray - 1];
                                                ?>

                                                <?php
                                                if ($freemaydays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsemayclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">May</span>
                                                        </div>
                                                        <div  class="red"  style="width: <?php echo $elsemayclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($freemaydays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div  class="red"  style="width: <?php echo $elsemayclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">May</span>
                                                        </div>
                                                        <div class="green" style="width: <?php echo $elsemayclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    $jun = '06';
                                    if ($jun < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Jun</span></div>
                                        <?php
                                    } else {
                                        if ($jun == date('m')) {
                                            $datejun = date('d') - 1;
                                            $remaningjundate = 30 - $datejun;
                                            $jundatecal = (($datejun * 100) / 30);

                                            if ($junarray > 0) {
                                                $totalbookeddatejun = (($remaningjundate * $junarray) / 30);
                                                $totalemptydatejun = $remaningjundate - $totalbookeddatejun;
                                            } else {
                                                $totalbookeddatejun = '0';
                                                $totalemptydatejun = 100 - $jundatecal;
                                            }

                                            $unbookjuncal = 100 - $bookedjuncal;
                                            $juncolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $juncolor ?>" style="width: <?php echo $jundatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jun</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejun ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejun; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjuncal = (($junarray * 100) / 30);
                                            if ($bookedjuncal == 100) {
                                                ?>
                                                <div class="singlePart red">Jun</div>
                                                <?php
                                            } elseif ($junarray == 0) {
                                                ?>
                                                <div class="singlePart green">Jun</div>
                                                <?php
                                            } else {
                                                $elsejunclacu = (($junarray * 100) / 31);
                                                $elsejunclacuremain = 100 - $elsejunclacu;
                                                $freejundays = $mainjunarray[$junarray - 1];
                                                ?>


                                                <?php
                                                if ($freejundays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejunclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jun</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejunclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejundays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejunclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jun</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejunclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>





                                    <?php
                                    $jul = '07';
                                    if ($jul < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Jul</span></div>
                                        <?php
                                    } else {
                                        if ($jul == date('m')) {
                                            $datejul = date('d') - 1;
                                            $remaningjuldate = 31 - $datejul;
                                            $juldatecal = (($datejul * 100) / 31);

                                            if ($jularray > 0) {
                                                $totalbookeddatejul = (($remaningjuldate * $jularray) / 31);
                                                $totalemptydatejul = $remaningjuldate - $totalbookeddatejul;
                                            } else {
                                                $totalbookeddatejul = '0';
                                                $totalemptydatejul = 100 - $juldatecal;
                                            }

                                            $unbookjulcal = 100 - $bookedjulcal;
                                            $julcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $julcolor ?>" style="width: <?php echo $juldatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jul</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejul ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejul; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjulcal = (($jularray * 100) / 31);
                                            if ($bookedjulcal == 100) {
                                                ?>
                                                <div class="singlePart red">Jul</div>
                                                <?php
                                            } elseif ($jularray == 0) {
                                                ?>
                                                <div class="singlePart green">Jul</div>
                                                <?php
                                            } else {
                                                $elsejulclacu = (($jularray * 100) / 31);
                                                $elsejulclacuremain = 100 - $elsejulclacu;
                                                $freejuldays = $mainjularray[$jularray - 1];
                                                ?>


                                                <?php
                                                if ($freejuldays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejulclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jul</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejulclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejuldays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejulclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jul</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejulclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    $aug = '08';
                                    if ($aug < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Aug</span></div>
                                        <?php
                                    } else {
                                        if ($aug == date('m')) {
                                            $dateaug = date('d') - 1;
                                            $remaningaugdate = 31 - $dateaug;
                                            $augdatecal = (($dateaug * 100) / 31);

                                            if ($augarray > 0) {
                                                $totalbookeddateaug = (($remaningaugdate * $augarray) / 31);
                                                $totalemptydateaug = $remaningaugdate - $totalbookeddateaug;
                                            } else {
                                                $totalbookeddateaug = '0';
                                                $totalemptydateaug = 100 - $augdatecal;
                                            }

                                            $unbookaugcal = 100 - $bookedaugcal;
                                            $augcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $augcolor ?>" style="width: <?php echo $augdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Aug</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateaug ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateaug; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedaugcal = (($augarray * 100) / 31);
                                            if ($bookedaugcal == 100) {
                                                ?>
                                                <div class="singlePart red">Aug</div>
                                                <?php
                                            } elseif ($augarray == 0) {
                                                ?>
                                                <div class="singlePart green">Aug</div>
                                                <?php
                                            } else {
                                                $elseaugclacu = (($augarray * 100) / 31);
                                                $elseaugclacuremain = 100 - $elseaugclacu;
                                                $freeaugdays = $mainaugarray[$augarray - 1];
                                                ?>


                                                <?php
                                                if ($freeaugdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseaugclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Aug</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseaugclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeaugdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseaugclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">aug</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseaugclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>		




                                    <?php
                                    $sep = '09';
                                    if ($sep < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Sep</span></div>
                                        <?php
                                    } else {
                                        if ($sep == date('m')) {
                                            $datesep = date('d') - 1;
                                            $remaningsepdate = 31 - $datesep;
                                            $sepdatecal = (($datesep * 100) / 31);

                                            if ($separray > 0) {
                                                $totalbookeddatesep = (($remaningsepdate * $separray) / 31);
                                                $totalemptydatesep = $remaningsepdate - $totalbookeddatesep;
                                            } else {
                                                $totalbookeddatesep = '0';
                                                $totalemptydatesep = 100 - $sepdatecal;
                                            }

                                            $unbooksepcal = 100 - $bookedsepcal;
                                            $sepcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $sepcolor ?>" style="width: <?php echo $sepdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Sep</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatesep ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatesep; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedsepcal = (($separray * 100) / 31);
                                            if ($bookedsepcal == 100) {
                                                ?>
                                                <div class="singlePart red">Sep</div>
                                                <?php
                                            } elseif ($separray == 0) {
                                                ?>
                                                <div class="singlePart green">Sep</div>
                                                <?php
                                            } else {
                                                $elsesepclacu = (($separray * 100) / 31);
                                                $elsesepclacuremain = 100 - $elsesepclacu;
                                                $freesepdays = $mainseparray[$separray - 1];
                                                ?>


                                                <?php
                                                if ($freesepdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsesepclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Sep</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsesepclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freesepdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsesepclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Sep</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsesepclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>		




                                    <?php
                                    $oct = '10';
                                    if ($oct < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Oct</span></div>
                                        <?php
                                    } else {
                                        if ($oct == date('m')) {
                                            $dateoct = date('d') - 1;
                                            $remaningoctdate = 31 - $dateoct;
                                            $octdatecal = (($dateoct * 100) / 31);

                                            if ($octarray > 0) {
                                                $totalbookeddateoct = (($remaningoctdate * $octarray) / 31);
                                                $totalemptydateoct = $remaningoctdate - $totalbookeddateoct;
                                            } else {
                                                $totalbookeddateoct = '0';
                                                $totalemptydateoct = 100 - $octdatecal;
                                            }

                                            $unbookoctcal = 100 - $bookedoctcal;
                                            $octcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $octcolor ?>" style="width: <?php echo $octdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Oct</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateoct ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateoct; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedoctcal = (($octarray * 100) / 31);
                                            if ($bookedoctcal == 100) {
                                                ?>
                                                <div class="singlePart red">Oct</div>
                                                <?php
                                            } elseif ($octarray == 0) {
                                                ?>
                                                <div class="singlePart green">Oct</div>
                                                <?php
                                            } else {
                                                $elseoctclacu = (($octarray * 100) / 31);
                                                $elseoctclacuremain = 100 - $elseoctclacu;
                                                $freeoctdays = $mainoctarray[$octarray - 1];
                                                ?>


                                                <?php
                                                if ($freeoctdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseoctclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Oct</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseoctclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeoctdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseoctclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Oct</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseoctclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>


                                    <?php
                                    $nov = '11';
                                    if ($nov < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Nov</span></div>
                                        <?php
                                    } else {
                                        if ($nov == date('m')) {
                                            $datenov = date('d') - 1;
                                            $remaningnovdate = 30 - $datenov;
                                            $novdatecal = (($datenov * 100) / 30);

                                            if ($novarray > 0) {
                                                $totalbookeddatenov = (($remaningnovdate * $novarray) / 30);
                                                $totalemptydatenov = $remaningnovdate - $totalbookeddatenov;
                                            } else {
                                                $totalbookeddatenov = '0';
                                                $totalemptydatenov = 100 - $novdatecal;
                                            }

                                            $unbooknovcal = 100 - $bookednovcal;
                                            $novcolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $novcolor ?>" style="width: <?php echo $novdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Nov</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatenov ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatenov; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookednovcal = (($novarray * 100) / 30);
                                            if ($bookednovcal == 100) {
                                                ?>
                                                <div class="singlePart red">Nov</div>
                                                <?php
                                            } elseif ($novarray == 0) {
                                                ?>
                                                <div class="singlePart green">Nov</div>
                                                <?php
                                            } else {
                                                $elsenovclacu = (($novarray * 100) / 30);
                                                $elsenovclacuremain = 100 - $elsenovclacu;
                                                $freenovdays = $mainnovarray[$novarray - 1];
                                                ?>


                                                <?php
                                                if ($freenovdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsenovclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Nov</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsenovclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freenovdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsenovclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Nov</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsenovclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>

                                    <?php
                                    $dec = '12';
                                    if ($dec < date('m')) {
                                        ?>
                                        <div class="singlePart gray" style="height: 32px; display: block;">
                                            <span class="month__title month__title_grey">Dec</span></div>
                                        <?php
                                    } else {
                                        if ($dec == date('m')) {
                                            $datedec = date('d') - 1;
                                            $remaningdecdate = 31 - $datedec;
                                            $decdatecal = (($datedec * 100) / 31);

                                            if ($decarray > 0) {
                                                $totalbookeddatedec = (($remaningdecdate * $decarray) / 31);
                                                $totalemptydatedec = $remaningdecdate - $totalbookeddatedec;
                                            } else {
                                                $totalbookeddatedec = '0';
                                                $totalemptydatedec = 100 - $decdatecal;
                                            }

                                            $unbookdeccal = 100 - $bookeddeccal;
                                            $deccolor = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $deccolor ?>" style="width: <?php echo $decdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Dec</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatedec ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatedec; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookeddeccal = (($decarray * 100) / 31);
                                            if ($bookeddeccal == 100) {
                                                ?>
                                                <div class="singlePart red">Dec</div>
                                                <?php
                                            } elseif ($decarray == 0) {
                                                ?>
                                                <div class="singlePart green">Dec</div>
                                                <?php
                                            } else {
                                                $elsedecclacu = (($decarray * 100) / 31);
                                                $elsedecclacuremain = 100 - $elsedecclacu;
                                                $freedecdays = $maindecarray[$decarray - 1];
                                                ?>


                                                <?php
                                                if ($freedecdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsedecclacuremain; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Dec</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsedecclacu; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freedecdays <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsedecclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Dec</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsedecclacuremain; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>

                                    <div class="clearfix"></div>
                                </div>



                                <!--------------------------------------------Current Year------------------------------------------------------>










                                <!--------------------------------------------Next Year------------------------------------------------------>




                                <p><strong><?php echo $lastyear = date('Y') + 1 ?></strong></p>

                                <div class="mainContent">



                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $jannext = '01';
                                        if ($jannext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Jan</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($jannext == date('m')) {
                                            $datejannext = date('d') - 1;
                                            $remaningjandatenext = 31 - $datejannext;
                                            $jandatecalnext = (($datejannext * 100) / 31);

                                            if ($janarraynext > 0) {
                                                $totalbookeddatejannext = (($remaningjandatenext * $janarraynext) / 31);
                                                $totalemptydatejannext = $remaningjandatenext - $totalbookeddatejannext;
                                            } else {
                                                $totalbookeddatejannext = '0';
                                                $totalemptydatejannext = 100 - $jandatecalnext;
                                            }

                                            $unbookjancalnext = 100 - $bookedjancalnext;
                                            $jancolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $jancolornext ?>" style="width: <?php echo $jandatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jan</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejannext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejannext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjancalnext = (($janarraynext * 100) / 31);
                                            if ($bookedjancalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Jan</div>
                                                <?php
                                            } elseif ($janarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Jan</div>
                                                <?php
                                            } else {
                                                $elsejanclacunext = (($janarraynext * 100) / 31);
                                                $elsejanclacuremainnext = 100 - $elsejanclacunext;
                                                $freejandaysnext = $mainjanarraynext[$janarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freejandaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejanclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jan</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejanclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejandaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejanclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jan</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejanclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>										   




                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $febnext = '02';
                                        if ($febnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Feb</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($febnext == date('m')) {
                                            $datefebnext = date('d') - 1;
                                            $remaningfebdatenext = 28 - $datefebnext;
                                            $febdatecalnext = (($datefebnext * 100) / 28);

                                            if ($febarraynext > 0) {
                                                $totalbookeddatefebnext = (($remaningfebdatenext * $febarraynext) / 28);
                                                $totalemptydatefebnext = $remaningfebdatenext - $totalbookeddatefebnext;
                                            } else {
                                                $totalbookeddatefebnext = '0';
                                                $totalemptydatefebnext = 100 - $febdatecalnext;
                                            }

                                            $unbookfebcalnext = 100 - $bookedfebcalnext;
                                            $febcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $febcolornext ?>" style="width: <?php echo $febdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Feb</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatefebnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatefebnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedfebcalnext = (($febarraynext * 100) / 28);
                                            if ($bookedfebcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Feb</div>
                                                <?php
                                            } elseif ($febarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Feb</div>
                                                <?php
                                            } else {
                                                $elsefebclacunext = (($febarray * 100) / 28);
                                                $elsefebclacuremainnext = 100 - $elsefebclacunext;
                                                $freefebdaysnext = $mainfebarraynext[$febarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freefebdays >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsefebclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Feb</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsefebclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freefebdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsefebclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Feb</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsefebclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>





                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $marnext = '03';
                                        if ($marnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Mar</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($marnext == date('m')) {
                                            $datemarnext = date('d') - 1;
                                            $remaningmardatenext = 31 - $datemarnext;
                                            $mardatecalnext = (($datemarnext * 100) / 31);

                                            if ($mararraynext > 0) {
                                                $totalbookeddatemarnext = (($remaningmardatenext * $mararraynext) / 31);
                                                $totalemptydatemarnext = $remaningmardatenext - $totalbookeddatemarnext;
                                            } else {
                                                $totalbookeddatemarnext = '0';
                                                $totalemptydatemarnext = 100 - $mardatecalnext;
                                            }

                                            $unbookmarcalnext = 100 - $bookedmarcalnext;
                                            $marcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $marcolornext ?>" style="width: <?php echo $mardatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Mar</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatemarnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatemarnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedmarcalnext = (($mararraynext * 100) / 31);
                                            if ($bookedmarcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Mar</div>
                                                <?php
                                            } elseif ($mararraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Mar</div>
                                                <?php
                                            } else {
                                                $elsemarclacunext = (($mararray * 100) / 31);
                                                $elsemarclacuremainnext = 100 - $elsemarclacunext;
                                                $freemardaysnext = $mainmararraynext[$mararraynext - 1];
                                                ?>


                                                <?php
                                                if ($freemardaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsemarclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Mar</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsemarclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freemardaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsemarclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Mar</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsemarclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>


                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $aprnext = '04';
                                        if ($aprnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Apr</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($aprnext == date('m')) {
                                            $dateaprnext = date('d');
                                            $remaningaprdatenext = 30 - $dateaprnext;
                                            $aprdatecalnext = (($dateaprnext * 100) / 30);

                                            //$totalbookeddateapr = (($remaningaprdate*$aprarray)/30);
                                            //$totalemptydateapr = $remaningaprdate - $totalbookeddateapr;


                                            if ($aprarraynext > 0) {
                                                $totalbookeddateaprnext = (($remaningaprdatenext * $aprarraynext) / 30);
                                                $totalemptydateaprnext = $remaningaprdatenext - $totalbookeddateaprnext;
                                            } else {
                                                $totalbookeddateaprnext = '0';
                                                $totalemptydateaprnext = 100 - $aprdatecalnext;
                                            }



                                            $unbookaprcalnext = 100 - $bookedaprcalnext;
                                            $aprcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $aprcolornext ?>" style="width: <?php echo $aprdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Apr</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateaprnext; ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateaprnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedaprcalnext = (($aprarraynext * 100) / 30);
                                            if ($bookedaprcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Apr</div>
                                                <?php
                                            } elseif ($aprarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Apr</div>
                                                <?php
                                            } else {
                                                $elseaprclacunext = (($aprarraynext * 100) / 30);
                                                $elseaprclacuremainnext = 100 - $elseaprclacunext;
                                                $freeaprdaysnext = $mainaprarraynext[$aprarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freeaprdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseaprclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Apr</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseaprclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeaprdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseaprclacu; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Apr</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseaprclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $maynext = '05';
                                        if ($maynext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">May</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($maynext == date('m')) {
                                            $datemaynext = date('d');
                                            $remaningmaydatenext = 31 - $datemaynext;
                                            $maydatecalnext = (($datemaynext * 100) / 31);

                                            //$totalbookeddateapr = (($remaningaprdate*$aprarray)/30);
                                            //$totalemptydateapr = $remaningaprdate - $totalbookeddateapr;


                                            if ($mayarraynext > 0) {
                                                $totalbookeddatemaynext = (($remaningmaydatenext * $mayarraynext) / 31);
                                                $totalemptydatemaynext = $remaningmaydatenext - $totalbookeddatemaynext;
                                            } else {
                                                $totalbookeddatemaynext = '0';
                                                $totalemptydatemaynext = 100 - $maydatecalnext;
                                            }



                                            $unbookmaycalnext = 100 - $bookedmaycalnext;
                                            $maycolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $maycolornext ?>" style="width: <?php echo $maydatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">May</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatemaynext; ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatemaynext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedmaycalnext = (($mayarraynext * 100) / 31);
                                            if ($bookedmaycalnext == 100) {
                                                ?>
                                                <div class="singlePart red">May</div>
                                                <?php
                                            } elseif ($mayarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">May</div>
                                                <?php
                                            } else {
                                                $elsemayclacunext = (($mayarraynext * 100) / 31);
                                                $elsemayclacuremainnext = 100 - $elsemayclacunext;
                                                $freemaydaysnext = $mainmayarraynext[$mayarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freemaydaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsemayclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">May</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsemayclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freemaydaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsemayclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">May</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsemayclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $junnext = '06';
                                        if ($junnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Jun</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($junnext == date('m')) {
                                            $datejunnext = date('d') - 1;
                                            $remaningjundatenext = 30 - $datejunnext;
                                            $jundatecalnext = (($datejunnext * 100) / 30);

                                            if ($junarraynext > 0) {
                                                $totalbookeddatejunnext = (($remaningjundatenext * $junarraynext) / 30);
                                                $totalemptydatejunnext = $remaningjundatenext - $totalbookeddatejunnext;
                                            } else {
                                                $totalbookeddatejunnext = '0';
                                                $totalemptydatejunnext = 100 - $jundatecalnext;
                                            }

                                            $unbookjuncalnext = 100 - $bookedjuncalnext;
                                            $juncolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $juncolornext ?>" style="width: <?php echo $jundatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jun</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejunnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejunnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjuncalnext = (($junarraynext * 100) / 30);
                                            if ($bookedjuncalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Jun</div>
                                                <?php
                                            } elseif ($junarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Jun</div>
                                                <?php
                                            } else {
                                                $elsejunclacunext = (($junarraynext * 100) / 31);
                                                $elsejunclacuremainnext = 100 - $elsejunclacunext;
                                                $freejundaysnext = $mainjunarraynext[$junarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freejundaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejunclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jun</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejunclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejundaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejunclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jun</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejunclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>





                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $julnext = '07';
                                        if ($julnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Jul</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($julnext == date('m')) {
                                            $datejulnext = date('d') - 1;
                                            $remaningjuldatenext = 31 - $datejulnext;
                                            $juldatecalnext = (($datejulnext * 100) / 31);

                                            if ($jularraynext > 0) {
                                                $totalbookeddatejulnext = (($remaningjuldatenext * $jularraynext) / 31);
                                                $totalemptydatejulnext = $remaningjuldatenext - $totalbookeddatejulnext;
                                            } else {
                                                $totalbookeddatejulnext = '0';
                                                $totalemptydatejulnext = 100 - $juldatecalnext;
                                            }

                                            $unbookjulcalnext = 100 - $bookedjulcalnext;
                                            $julcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $julcolornext ?>" style="width: <?php echo $juldatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Jul</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatejulnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatejulnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedjulcalnext = (($jularraynext * 100) / 31);
                                            if ($bookedjulcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Jul</div>
                                                <?php
                                            } elseif ($jularraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Jul</div>
                                                <?php
                                            } else {
                                                $elsejulclacunext = (($jularraynext * 100) / 31);
                                                $elsejulclacuremainnext = 100 - $elsejulclacunext;
                                                $freejuldaysnext = $mainjularraynext[$jularraynext - 1];
                                                ?>


                                                <?php
                                                if ($freejuldaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsejulclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jul</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsejulclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freejuldaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsejulclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Jul</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsejulclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>




                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $augnext = '08';
                                        if ($augnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Aug</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($augnext == date('m')) {
                                            $dateaugnext = date('d') - 1;
                                            $remaningaugdatenext = 31 - $dateaugnext;
                                            $augdatecalnext = (($dateaugnext * 100) / 31);

                                            if ($augarraynext > 0) {
                                                $totalbookeddateaugnext = (($remaningaugdatenext * $augarraynext) / 31);
                                                $totalemptydateaugnext = $remaningaugdatenext - $totalbookeddateaugnext;
                                            } else {
                                                $totalbookeddateaugnext = '0';
                                                $totalemptydateaugnext = 100 - $augdatecalnext;
                                            }

                                            $unbookaugcalnext = 100 - $bookedaugcalnext;
                                            $augcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $augcolornext ?>" style="width: <?php echo $augdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Aug</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateaugnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateaugnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedaugcalnext = (($augarraynext * 100) / 31);
                                            if ($bookedaugcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Aug</div>
                                                <?php
                                            } elseif ($augarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Aug</div>
                                                <?php
                                            } else {
                                                $elseaugclacunext = (($augarraynext * 100) / 31);
                                                $elseaugclacuremainnext = 100 - $elseaugclacunext;
                                                $freeaugdaysnext = $mainaugarraynext[$augarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freeaugdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseaugclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Aug</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseaugclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeaugdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseaugclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Aug</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseaugclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>		




                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $sepnext = '09';
                                        if ($sepnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Sep</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($sepnext == date('m')) {
                                            $datesepnext = date('d') - 1;
                                            $remaningsepdatenext = 30 - $datesepnext;
                                            $sepdatecalnext = (($datesepnext * 100) / 30);

                                            if ($separraynext > 0) {
                                                $totalbookeddatesepnext = (($remaningsepdatenext * $separraynext) / 30);
                                                $totalemptydatesepnext = $remaningsepdatenext - $totalbookeddatesepnext;
                                            } else {
                                                $totalbookeddatesepnext = '0';
                                                $totalemptydatesepnext = 100 - $sepdatecalnext;
                                            }

                                            $unbooksepcalnext = 100 - $bookedsepcalnext;
                                            $sepcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $sepcolornext ?>" style="width: <?php echo $sepdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Sep</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatesepnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatesepnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedsepcalnext = (($separraynext * 100) / 31);
                                            if ($bookedsepcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Sep</div>
                                                <?php
                                            } elseif ($separraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Sep</div>
                                                <?php
                                            } else {
                                                $elsesepclacunext = (($separraynext * 100) / 30);
                                                $elsesepclacuremainnext = 100 - $elsesepclacunext;
                                                $freesepdaysnext = $mainseparraynext[$separraynext - 1];
                                                ?>


                                                <?php
                                                if ($freesepdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsesepclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Sep</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsesepclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freesepdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsesepclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Sep</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsesepclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>		



                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $octnext = '10';
                                        if ($octnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Oct</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($octnext == date('m')) {
                                            $dateoctnext = date('d') - 1;
                                            $remaningoctdatenext = 31 - $dateoct;
                                            $octdatecalnext = (($dateoctnext * 100) / 31);

                                            if ($octarraynext > 0) {
                                                $totalbookeddateoctnext = (($remaningoctdatenext * $octarraynext) / 31);
                                                $totalemptydateoctnext = $remaningoctdatenext - $totalbookeddateoctnext;
                                            } else {
                                                $totalbookeddateoctnext = '0';
                                                $totalemptydateoctnext = 100 - $octdatecalnext;
                                            }

                                            $unbookoctcalnext = 100 - $bookedoctcalnext;
                                            $octcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $octcolornext ?>" style="width: <?php echo $octdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Oct</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydateoctnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddateoctnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookedoctcalnext = (($octarraynext * 100) / 31);
                                            if ($bookedoctcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Oct</div>
                                                <?php
                                            } elseif ($octarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Oct</div>
                                                <?php
                                            } else {
                                                $elseoctclacunext = (($octarraynext * 100) / 31);
                                                $elseoctclacuremainnext = 100 - $elseoctclacunext;
                                                $freeoctdaysnext = $mainoctarraynext[$octarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freeoctdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elseoctclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Oct</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elseoctclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freeoctdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elseoctclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Oct</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elseoctclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>


                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $novnext = '11';
                                        if ($novnext < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Nov</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($novnext == date('m')) {
                                            $datenovnext = date('d') - 1;
                                            $remaningnovdatenext = 30 - $datenovnext;
                                            $novdatecalnext = (($datenovnext * 100) / 30);

                                            if ($novarraynext > 0) {
                                                $totalbookeddatenovnext = (($remaningnovdatenext * $novarraynext) / 30);
                                                $totalemptydatenovnext = $remaningnovdatenext - $totalbookeddatenovnext;
                                            } else {
                                                $totalbookeddatenovnext = '0';
                                                $totalemptydatenovnext = 100 - $novdatecalnext;
                                            }

                                            $unbooknovcalnext = 100 - $bookednovcalnext;
                                            $novcolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $novcolornext ?>" style="width: <?php echo $novdatecalnext; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Nov</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatenovnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatenovnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookednovcalnext = (($novarraynext * 100) / 30);
                                            if ($bookednovcalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Nov</div>
                                                <?php
                                            } elseif ($novarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Nov</div>
                                                <?php
                                            } else {
                                                $elsenovclacunext = (($novarraynext * 100) / 30);
                                                $elsenovclacuremainnext = 100 - $elsenovclacunext;
                                                $freenovdaysnext = $mainnovarraynext[$novarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freenovdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsenovclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Nov</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsenovclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freenovdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsenovclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Nov</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsenovclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($lastyear == date("Y")) {
                                        $decnext = '12';
                                        if ($dec < date('m')) {
                                            ?>
                                            <div class="singlePart gray" style="height: 32px; display: block;">
                                                <span class="month__title month__title_grey">Dec</span></div>
                                            <?php
                                        }
                                    } else {
                                        if ($decnext == date('m')) {
                                            $datedecnext = date('d') - 1;
                                            $remaningdecdatenext = 31 - $datedecnext;
                                            $decdatecalnext = (($datedecnext * 100) / 31);

                                            if ($decarraynext > 0) {
                                                $totalbookeddatedecnext = (($remaningdecdatenext * $decarraynext) / 31);
                                                $totalemptydatedecnext = $remaningdecdatenext - $totalbookeddatedecnext;
                                            } else {
                                                $totalbookeddatedecnext = '0';
                                                $totalemptydatedecnext = 100 - $decdatecalnext;
                                            }

                                            $unbookdeccalnext = 100 - $bookeddeccalnext;
                                            $deccolornext = "gray";

                                            //$remaningfebdate = (($remaningfebdate*$totalbookeddatefeb)/100);
                                            //$emptypercentfeb = $remaningfebdate - $remaningfebdate;
                                            ?>

                                            <div class="singlePart red">
                                                <div class="<?php echo $deccolornext ?>" style="width: <?php echo $decdatecal; ?>%; height: 32px; display: block;">
                                                    <span class="month__title">Dec</span>
                                                </div>
                                                <div class="green" style="width: <?php echo $totalemptydatedecnext ?>%; height: 32px; display: block;">
                                                </div>
                                                <div  class="red"  style="width: <?php echo $totalbookeddatedecnext; ?>%; height: 32px; display: block;">
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            $bookeddeccalnext = (($decarraynext * 100) / 31);
                                            if ($bookeddeccalnext == 100) {
                                                ?>
                                                <div class="singlePart red">Dec</div>
                                                <?php
                                            } elseif ($decarraynext == 0) {
                                                ?>
                                                <div class="singlePart green">Dec</div>
                                                <?php
                                            } else {
                                                $elsedecclacunext = (($decarraynext * 100) / 31);
                                                $elsedecclacuremainnext = 100 - $elsedecclacunext;
                                                $freedecdaysnext = $maindecarraynext[$decarraynext - 1];
                                                ?>


                                                <?php
                                                if ($freedecdaysnext >= 15) {
                                                    ?>
                                                    <div class="singlePart red">
                                                        <div class="green" style="width: <?php echo $elsedecclacuremainnext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Dec</span>
                                                        </div>

                                                        <div  class="red"  style="width: <?php echo $elsedecclacunext; ?>%; height: 32px; display: block;">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($freedecdaysnext <= 15) {
                                                    ?>
                                                    <div class="singlePart red">


                                                        <div  class="red"  style="width: <?php echo $elsedecclacunext; ?>%; height: 32px; display: block;">
                                                            <span class="month__title">Dec</span>
                                                        </div>

                                                        <div class="green" style="width: <?php echo $elsedecclacuremainnext; ?>%; height: 32px; display: block;">
                                                        </div>


                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <?php
                                            }
                                        }
                                        ?>

                                        <?php
                                    }
                                    ?>



                                    <div class="clearfix"></div>
                                </div>



                                <!--------------------------------------------Next Year------------------------------------------------------>







                                <ul class="minimum-stay">
                                    <li><span><img src="images/calender-1.png" alt=""></span> Minimum stay: <?php echo $ninimum_stay ?></li>
                                    <li><span><img src="images/calender-1.png" alt=""></span> Maximum stay: <?php echo $maximum_stay ?></li>
                                    <li><span><img src="images/calender-1.png" alt=""></span> Type of contract: <?php echo $type_of_contract ?> <a href="javascript:void(0);">Learn more</a></li>
                                    <li><span><img src="images/calender-1.png" alt=""></span> Available: Not Available</li>
                                </ul>
                                <div class="home-map">
                                    <div class="search-location">
                                        <div style="position: relative">
                                            <span><i class="fa fa-map-marker"></i></span>
                                            <input type="text" placeholder="Search for an address, neighbourhood...">
                                        </div>
                                    </div>
<!--                                    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe>-->

                                    <div id="map"></div>





                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form action="booking.php" method="POST" id="submit_review">
                                <div class="price-box">
                                    <div class="top-area">
                                        <span class="price">Price</span>
                                        <span class="month">$<?php echo $propdetails->price ?> per month</span>
                                    </div>
                                    <div class="booknow-card-body">
                                        <div class="form-datepicker_container">
                                            <input type="hidden" id="numofdays" name="numofdays" value="<?php echo ($propdetails->ninimum_stay) ?>">
                                            <input type="hidden" id="numofdays" name="maxstay" value="<?php echo ($propdetails->maximum_stay) ?>">
                                            <input type="hidden" id="propid" name="id" value="<?php echo ($propdetails->id) ?>">
                                            <input type="hidden" id="ip" name="ip" value="<?php echo $ip ?>">
                                            <input placeholder="Date in" class="form-datepicker_from" type="text" id="sdate" name="start_date" required>
                                            <input placeholder="Date out" class="form-datepicker_to" type="text" id="edate" name="end_date" required>
                                            <input type="hidden" id="type_of_contract" name="type_of_contract" value="<?php echo ($propdetails->type_of_contract) ?>">



                                        </div>
                                    </div>

                                    <div id="pricediv" style="display:none;">
                                        <div class="top-area">
                                            <span class="price">Price</span>
                                            <span class="month">$ <?php echo $propdetails->price ?></span>
                                        </div>

                                        <?php
                                        if ($propdetails->type_of_contract == 3) {
                                            ?>
                                            <div class="top-area">
                                                <span class="price">Booking fee</span>
                                                <span class="month" id="fees">$<?php echo $pp = $propdetails->fees * $propdetails->ninimum_stay ?></span>
                                            </div>


                                            <div class="top-area">
                                                <span class="price">Total</span>
                                                <span class="month" id="total">$<?php echo $tots = ($propdetails->price + $pp) ?></span>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="top-area">
                                                <span class="price">Booking fee</span>
                                                <span class="month" id="fees">$<?php echo $pp = $propdetails->fees ?></span>
                                            </div>

                                            <div class="top-area">
                                                <span class="price">Total</span>
                                                <span class="month" id="total">$<?php echo $tots = ($propdetails->price + $pp) ?></span>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>


                                    <input type="hidden" id="sendfees" name="sendfees" value="<?php echo $pp ?>">
                                    <input type="hidden" id="sendtotal" name="sendtotal" value="<?php echo $tots ?>">


                                    <div class="price-box-footer">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div id="showAlert" style="display:none;">
                                                    <span class="alert alert-warning" style="margin-bottom: 20px;display: block;">Booking not allowed</span>
                                                </div>
                                            </div>

                                            <div class="col-md-9 col-sm-9 col-xs-8">
                                                <button class="btn btn-primary btn-block" type="submit" name="submit" id="submit">Book Now !</button>
                                            </div>
                                            </form>
                                            <div class="col-md-3 col-sm-3 col-xs-4" id="showfavdiv">

                                                <?php
                                                if ($wish == 0) {
                                                    ?>
                                                    <a href="javascript:void(0);" id="fav_<?php echo $propdetails->id ?>" class="btn btn-default btn-block cc"><i class="ion-ios-heart-outline"></i></a>
                                                    <?php
                                                }
                                                ?>


                                                <?php
                                                if ($wish > 0) {
                                                    ?>
                                                    <a href="javascript:void(0);" id="unfav_<?php echo $propdetails->id ?>" class="btn btn-default btn-block ccd"><i class="ion-heart"></i></a>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="we-accept">
                                    <p>We accept: <span><img src="images/master-card.jpg" alt=""></span> <span><img src="images/visa.jpg" alt=""></span> <span><img src="images/paypal.jpg" alt=""></span></p>
                                </div>
                        </div>
                    </div>
                </section>

                <?php if ($parent_count > 0) { ?>


                    <section class="other-bedroom-section">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Other bedrooms in this apartment</h3>
                                <div class="properties-around-wrapper">
                                    <ul class="prod-listing">

                                        <?php
                                        $proplist = mysql_query("select * from `estejmam_main_property` where `parent_id`='" . $propdetails->id . "'");
                                        $propnum = mysql_num_rows($proplist);
                                        if ($propnum > 0) {
                                            while ($totalprop = mysql_fetch_object($proplist)) {

                                                $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $totalprop->id . "' LIMIT 1"));

                                                if ($image_details->image != '') {
                                                    $image = "upload/property/" . $image_details->image;
                                                } else {
                                                    $image = "upload/noImageFound.jpg";
                                                }
                                                ?>

                                                <li>
                                                    <a href="details.php?name=<?php echo $totalprop->slug; ?>" class="total-wrapper">
                                                        <div class="product-image">
                                                            <img src="<?php echo $image; ?>" alt="">
                                                            <div class="rent-price">
                                                                <b>$<?php echo $totalprop->price; ?></b>
                                                                <span>month</span>
                                                            </div>
                                                        </div>
                                                        <div class="product-info">
                                                            <h4><?php echo $totalprop->name; ?></h4>

                                                            <?php
                                                            $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($totalprop->amenities) order by `id` DESC limit 4");
                                                            while ($amenities = mysql_fetch_object($amm)) {
                                                                ?>
                                                                <div class="icon-holder"><span><img src="upload/amentiesimage/<?php echo $amenities->img ?>" alt=""></span><?php echo $amenities->name ?></div>
                                                            <?php } ?>

                                                            <div class="clearfix"></div>
                                                            <p class="available">Available: Jul 31st, 2017</p>
                                                        </div>
                                                    </a>
                                                </li>

                                                <?php
                                            }
                                        }
                                        ?>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                <?php } ?>


                <section class="other-bedroom-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>General info</h3>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="description-holdr">
                                        <h3>Description</h3>
                                        <p><?php echo $propdetails->description; ?></p>
                                    </div>
                                    <div class="description-holdr description-list">
                                        <h3>Details</h3>
                                        <ul>
                                            <?php echo $propdetails->details; ?>   
                                        </ul>
                                    </div>
                                    <div class="description-holdr description-list">
                                        <h3>Transportation</h3>
                                        <ul>
                                            <?php echo $propdetails->transpotation; ?>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="description-holdr">
                                        <h3>Bills included</h3>
                                        <div class="property-info-body">

                                            <?php
                                            $common = mysql_query("select * from `estejmam_bills_include` where `id` IN(" . $propdetails->bills_include_id . ") order by `id` DESC");
                                            while ($commanaminities = mysql_fetch_array($common)) {
                                                ?>

                                                <div class="room-feature">
                                                    <span><img src="upload/bills_image/<?php echo $commanaminities['image'] ?>" alt=""></span> <?php echo $commanaminities['name'] ?>
                                                </div>

                                            <?php } ?>


                                        </div>
                                    </div>
                                    <div class="description-holdr">
                                        <h3>Apartment features</h3>
                                        <div class="property-info-body">

                                            <?php
                                            $common1 = mysql_query("select * from `estejmam_apartment_feature` where `id` IN(" . $propdetails->apartment_feature_id . ") order by `id` DESC");
                                            while ($commanaminities1 = mysql_fetch_array($common1)) {
                                                ?>

                                                <div class="room-feature">
                                                    <span><img src="upload/apart_feature_iamge/<?php echo $commanaminities1['image'] ?>" alt=""></span> <?php echo $commanaminities1['name'] ?>
                                                </div>
                                            <?php } ?>



                                            <?php
                                            $common3 = mysql_query("select * from `sutable_for` where `id` IN(" . $propdetails->sutable_for . ") order by `id` DESC");
                                            while ($stbfor = mysql_fetch_array($common3)) {


                                                $name[] = $stbfor['name'];
                                            }

                                            $sutableforname = implode(',', array_unique($name));
                                            ?>


                                        </div>
                                    </div>
                                    <div class="description-holdr">
                                        <h3>More information</h3>
                                        <h4><b>Suitable for:</b> <?php echo $sutableforname; ?></h4>
                                    </div>
                                    <div class="description-holdr">
                                        <h3>Neighborhood information</h3>
                                        <p> <?php echo $propdetails->neighborhood_information; ?> </p>
                                    </div>

                                    <div class="description-holdr description-list">
                                        <h3>Landlord policies</h3>

                                        <p>  <?php echo $propdetails->landlord_policies; ?> </p>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="other-bedroom-section">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="like-holder">
                                <div class="like-icon"><i class="ion-ios-heart"></i></div>
                                <h3 class="text-center">What we liked the most</h3>
                                <ul>
                                    <?php echo $propdetails->what_we_liked_most; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="like-holder">
                                <div class="like-icon"><i class="ion-ios-bell"></i></div>
                                <h3 class="text-center">Things to keep in mind</h3>
                                <ul>
                                    <?php echo $propdetails->keep_in_mind; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="other-bedroom-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Properties around</h3>
                            <div class="properties-around-wrapper">
                                <ul class="prod-listing">



                                    <?php
                                    $proplist = mysql_query("select * from `estejmam_main_property` where `city`='" . $propdetails->city . "' and `id`!='" . $propdetails->id . "'");
                                    $propnum = mysql_num_rows($proplist);
                                    if ($propnum > 0) {
                                        while ($totalprop = mysql_fetch_object($proplist)) {

                                            $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $totalprop->id . "' LIMIT 1"));

                                            if ($image_details->image != '') {
                                                $image = "upload/property/" . $image_details->image;
                                            } else {
                                                $image = "upload/noImageFound.jpg";
                                            }
                                            ?>

                                            <li>
                                                <a href="details.php?name=<?php echo $totalprop->slug; ?>" class="total-wrapper">
                                                    <div class="product-image">
                                                        <img src="<?php echo $image; ?>" alt="">
                                                        <div class="rent-price">
                                                            <b>$<?php echo $totalprop->price; ?></b>
                                                            <span>month</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-info">
                                                        <h4><?php echo $totalprop->name; ?></h4>

                                                        <?php
                                                        $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($totalprop->amenities) order by `id` DESC limit 4");
                                                        while ($amenities = mysql_fetch_object($amm)) {
                                                            ?>
                                                            <div class="icon-holder"><span><img src="upload/amentiesimage/<?php echo $amenities->img ?>" alt=""></span><?php echo $amenities->name ?></div>
                                                        <?php } ?>

                                                        <div class="clearfix"></div>
                                                        <p class="available">Available: Jul 31st, 2017</p>
                                                    </div>
                                                </a>
                                            </li>

                                            <?php
                                        }
                                    }
                                    ?>



                                </ul>
                            </div>
                        </div>
                    </div>
                </section>



                <!--                <div class="availability-calendar__wrapper">
                                    <div class="availability-calendar__year__title">2017</div>
                                    <div class="availability-calendar__year">
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title availability-calendar__month__title--grey">Jan</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--grey" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Feb</span>
                                            </div><div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--grey" style="width: 82.1429%;">
                                                </div>
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 17.8571%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Mar</span>
                                            </div><div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Apr</span>
                                            </div><div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">May</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Jun</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Jul</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--red" style="width: 35.4839%;">
                                                </div>
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 64.5161%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Aug</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month"><div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Sep</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Oct</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Nov</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                
                
                                        <div class="availability-calendar__month">
                                            <div class="availability-calendar__month__title__container">
                                                <span class="availability-calendar__month__title">Dec</span>
                                            </div>
                                            <div class="availability-calendar__month__content">
                                                <div class="availability-calendar__interval availability-calendar__interval--green" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->



            </div>
        </div>





        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.bxslider.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



        <?php
        if ($propdetails->type_of_contract == 1) {
            ?>


            <script>
                            //minDate: (input.id == "edate" ? $("#sdate").datepicker("getDate") : new Date())


                            function customRange(input)
                            {
                                return {
                                    minDate: $('#edate').val()
                                };
                            }




                            function customRangeStart(input)
                            {
                                return {
                                    maxDate: (input.id == "sdate" ? $("#edate").datepicker("getDate") : null)
                                };
                            }

                            $(document).ready(function () {


                                var arrayd = '<?php echo json_encode($alltotalnewarray) ?>';
                                function available(date) {
                                    dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                                    if ($.inArray(dmy, arrayd) != -1) {
                                        return [true, "", "Available"];
                                    } else {
                                        return [false, "", "unAvailable"];
                                    }
                                }



                                $(function () {
                                    //$("#sdate,#edate").datepicker({dateFormat: 'yy-mm-dd'});
                                    var dateToday = new Date();
                                    var array = ["<?php echo $val ?>"];
                                    var dates = $("#sdate").datepicker({
                                        beforeShow: customRangeStart,
                                        defaultDate: "+1w",
                                        changeMonth: true,
                                        numberOfMonths: 1,
                                        minDate: dateToday,
                                        dateFormat: 'yy-mm-dd',
                                        onSelect: function (dateText, instance) {
                                            var nights = parseInt($('#numofdays').val());
                                            date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
                                            date.setDate(date.getDate() + nights);
                                            $("#edate").datepicker("setDate", date);
                                            $("#edate").trigger("click");
                                            $("#pricediv").show('slow');
                                            var alldata = $('#submit_review').serialize();
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_date.php",
                                                data: alldata,
                                                success: function (msg) {
                                                    // var data = $.parseJSON(msg);
                                                    if (msg.trim() == 000)
                                                    {
                                                        $("#submit").attr("disabled", false);
                                                        $("#showAlert").hide();
                                                        $("#pricediv").show("slow");
                                                    }

                                                    else
                                                    {
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }
                                                }
                                            });
                                        },
                                        beforeShowDay: function (date) {
                                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                            return [arrayd.indexOf(string) == -1];
                                        }

                                    });
                                    $("#edate").datepicker({
                                        beforeShow: customRange,
                                        dateFormat: "yy-mm-dd",
                                        changeYear: true,
                                        onSelect: function (selectedDate) {
                                            var alldata = $('#submit_review').serialize();
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_date.php",
                                                data: alldata,
                                                success: function (msg) {

                                                    if (msg.trim() == 000)
                                                    {
                                                        $("#submit").attr("disabled", false);
                                                        $("#showAlert").hide();
                                                        $("#pricediv").show("slow");
                                                    }

                                                    else
                                                    {
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_price.php",
                                                data: alldata,
                                                success: function (msg) {

                                                    var data = msg.split("@@");

                                                    //$("#pricediv").html(msg);
                                                    $("#fees").html('$' + data[0].trim());
                                                    $("#total").html('$' + data[1].trim());

                                                    $("#sendfees").attr('value', data[0].trim());
                                                    $("#sendtotal").attr('value', data[1].trim());
                                                }
                                            });
                                        },
                                        beforeShowDay: function (date) {
                                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                            return [arrayd.indexOf(string) == -1];
                                        }
                                    });
                                });
                            });</script>
        <?php } ?>





        <?php
        if ($propdetails->type_of_contract == '2' || $propdetails->type_of_contract == '3') {
            ?>


            <script>
                //minDate: (input.id == "edate" ? $("#sdate").datepicker("getDate") : new Date())


                function customRangeot(input)
                {
                    return {
                        minDate: (input.id == "edate" ? $("#sdate").datepicker("getDate") : new Date())
                    };
                }




                function customRangeStartot(input)
                {
                    return {
                        maxDate: (input.id == "sdate" ? $("#edate").datepicker("getDate") : null)
                    };
                }

                $(document).ready(function () {


                    var arrayd = '<?php echo json_encode($alltotalnewarray) ?>';
                    function available(date) {
                        dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                        if ($.inArray(dmy, arrayd) != -1) {
                            return [true, "", "Available"];
                        } else {
                            return [false, "", "unAvailable"];
                        }
                    }

                    $(function () {
                        //$("#sdate,#edate").datepicker({dateFormat: 'yy-mm-dd'});
                        var dateToday = new Date();
                        var dates = $("#sdate").datepicker({
                            //beforeShow: customRangeStartot,
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            minDate: dateToday,
                            dateFormat: 'yy-mm-dd',
                            onSelect: function (dateText, instance) {
                                var nights = parseInt($('#numofdays').val());
                                date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
                                date.setDate(date.getDate() + nights);
                                $("#edate").datepicker("setDate", date);
                                $("#edate").trigger("click");
                                $("#pricediv").show('slow');
                                var alldata = $('#submit_review').serialize();
                                $.ajax({
                                    type: "post",
                                    url: "ajax_check_date.php",
                                    data: alldata,
                                    success: function (msg) {
                                        // var data = $.parseJSON(msg);
                                        if (msg.trim() == 000)
                                        {
                                            $("#submit").attr("disabled", false);
                                            $("#showAlert").hide();
                                            $("#pricediv").show("slow");
                                        }

                                        else
                                        {
                                            $("#submit").attr("disabled", true);
                                            $("#showAlert").show();
                                            $("#pricediv").hide("slow");
                                        }
                                    }
                                });
                            },
                            beforeShowDay: function (date) {
                                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                return [arrayd.indexOf(string) == -1];
                            }


                        });
                        $("#edate").datepicker({
                            beforeShow: customRangeot,
                            dateFormat: "yy-mm-dd",
                            changeYear: true,
                            //minDate: dateToday,
                            onSelect: function (selectedDate) {
                                var alldata = $('#submit_review').serialize();
                                $.ajax({
                                    type: "post",
                                    url: "ajax_check_date.php",
                                    data: alldata,
                                    success: function (msgg) {
                                        // var data = $.parseJSON(msg);

                                        if (msgg.trim() == 000)
                                        {
                                            $("#submit").attr("disabled", false);
                                            $("#showAlert").hide();
                                            $("#pricediv").show("slow");
                                        }

                                        else
                                        {
                                            $("#submit").attr("disabled", true);
                                            $("#showAlert").show();
                                            $("#pricediv").hide("slow");
                                        }


                                        //                                        if (msgg.trim() == 001)
                                        //                                        {
                                        //                                            alert(msgg);
                                        //                                            $("#submit").attr("disabled", true);
                                        //                                            $("#showAlert").show();
                                        //                                            $("#pricediv").hide("slow");
                                        //                                        }
                                        //                                        if (msgg.trim() == 100)
                                        //                                        {
                                        //                                            alert(msgg);
                                        //                                            $("#submit").attr("disabled", true);
                                        //                                            $("#showAlert").show();
                                        //                                            $("#pricediv").hide("slow");
                                        //                                        }
                                        //                                        if (msgg.trim() == 010)
                                        //                                        {
                                        //                                            alert(msgg);
                                        //                                            $("#submit").attr("disabled", true);
                                        //                                            $("#showAlert").show();
                                        //                                            $("#pricediv").hide("slow");
                                        //                                        }

                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: "ajax_check_price.php",
                                    data: alldata,
                                    success: function (msg) {

                                        //var data = msg.split('@@');
                                        //$("#pricediv").html(data[0]);

                                        var data = msg.split("@@");

                                        //$("#pricediv").html(msg);
                                        $("#fees").html('$' + data[0].trim());
                                        $("#total").html('$' + data[1].trim());

                                        $("#sendfees").attr('value', data[0].trim());
                                        $("#sendtotal").attr('value', data[1].trim());


                                    }
                                });
                            },
                            beforeShowDay: function (date) {
                                var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                return [arrayd.indexOf(string) == -1];
                            }

                        });
                    });
                });</script>
        <?php } ?>




        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4JL5abSEMXv85L04gYe9cMS8wfbJBlwo&callback=initialize">
        </script>





        <script>

            function initialize() {
                var fenway = {lat: <?php echo $propdetails->lat ?>, lng: <?php echo $propdetails->lng ?>};
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: fenway,
                    zoom: 14
                });
                var marker = new google.maps.Marker({
                    position: fenway,
                    map: map,
                    title: ''
                });
                var panorama = new google.maps.StreetViewPanorama(
                        document.getElementById('pano'), {
                    position: fenway,
                    pov: {
                        heading: 34,
                        pitch: 10
                    }
                });
                map.setStreetView(panorama);
            }
        </script>





        <script>
            $('.bxslider2').bxSlider({
                pager: false,
            });
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 100) {
                    $('.navbar-fixed-top').css('background', 'rgba(0,0,0,.8)');
                }
                else {
                    $('.navbar-fixed-top').css('background', 'none');
                }
            });</script>
        <script>
            $(document).ready(function () {
                $('#more-filter').click(function () {
                    $('.extra-filter').slideToggle('slow');
                });
                $('#ex1').slider({
                    formatter: function (value) {
                        return 'Current value: ' + value;
                    }
                });
            });
        </script>


        <script>
            function openExplore()
            {
                window.history.back();
            }
        </script>





<!--        <script src ="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4JL5abSEMXv85L04gYe9cMS8wfbJBlwo&sensor=false"></script>-->



        <script>

            $(".cc").on('click', function () {


                var propid = $("#propid").val();
                var ip = $("#ip").val();

                $.ajax({
                    type: "post",
                    url: "ajax_want.php",
                    data: {propid: propid, ip: ip},
                    success: function (msg) {
                        if (msg == 1)
                        {
                            $("#showfavdiv").html('<a href="javascript:void(0);" class="btn btn-default btn-block ccd"><i class="ion-heart"></i></a>');
                        }

                    }

                });

            });



            $(".ccd").on('click', function () {

                var propid = $("#propid").val();
                var ip = $("#ip").val();

                $.ajax({
                    type: "post",
                    url: "ajax_want.php",
                    data: {propid: propid, ip: ip},
                    success: function (msg) {
                        if (msg == 0)
                        {
                            $("#showfavdiv").html('<a href="javascript:void(0);"  class="btn btn-default btn-block cc"><i class="ion-ios-heart-outline"></i></a>');
                        }

                    }

                });

            });

			$('.search-menu-icon_details_page').click(function(){
				$('.l-main-menu').slideToggle();
			});     

        </script>






        <style>
            #map {
                float: left;
                height: 100%;
                width: 66%;
            }

            #pano {
                float: left;
                height: 400px;
                width: 100%;
            }


            #ui-datepicker-div {
                border-radius: 0;
                display: block;
                margin-top: 4px;
                padding: 10px;
                position: fixed;
                width: 310px;
                z-index: 10;
            }
            #ui-datepicker-div {
                z-index: 9 !important;
            }

            .ui-datepicker-title {
                font-weight: normal !important;
                color: #808080;
            }

            .ui-datepicker .ui-datepicker-title {
                margin: 0 2.3em;
                line-height: 1.8em;
                text-align: center;
            }



            .mainContent{ width:100%;}
            .singlePart{ width:16%; float: left; margin-right: 1px; height: 32px; border: 0px solid #000; margin-bottom: 10px; text-align: center; font-size: 14px; text-transform: uppercase; line-height: 32px; position: relative;}
            .gray{
                background-color:#cbcbcb; display: block; color: #666 !important; float:  left;
            }
            .red{
                background-color:#ed8585; display: block; color: #fff;float:  left;
            }
            .green{
                background-color:#60d3b8; display: block; color: #fff;float:  left;
            }


            .month__title {
                color: #ffffff;
                font-size: 14px;
                left: 50%;
                position: absolute;
                text-transform: uppercase;
                top: 15px;
                transform: translate(-50%, -50%);
            }
            .month__title_grey{
                color: #999999 !important;
            }
			.search-menu-icon_details_page{color: #a5a5a5;
			cursor: pointer;
			display: none;
			font-size: 24px;
			position: absolute;
			right: 20px;
			top: 10px;
			z-index: 999;}


        </style>

    </body>
</html>