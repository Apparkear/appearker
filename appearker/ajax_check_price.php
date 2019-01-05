<?php

ob_start();
session_start();
include 'administrator/includes/config.php';

$getSymbolNRate = curencyrateAndSymbol();

$convertionRate = $getSymbolNRate['rate'];
$symbol = $getSymbolNRate['symbol'];
$countryCode = $getSymbolNRate['country'];

?>


<?php

$numofdays = $_REQUEST['numofdays'];
$maxstay = $_REQUEST['maxstay'];
$id = $_REQUEST['id'];
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$type_of_contract = $_REQUEST['type_of_contract'];


$sql = mysql_query("select * from `estejmam_main_property` where `id`='" . $id . "'");
$obj = mysql_fetch_object($sql);



if ($type_of_contract == 1) {

    $tot = $obj->price + $obj->fees;

//    echo $val = "<div class='top-area'>
//                                            <span class='price'>Price</span>
//                                            <span class='month'>$ $obj->price</span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Booking fee</span>
//                                            <span class='month'>$ $obj->fees </span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Total</span>
//                                            <span class='month'>$ $tot </span>
//                                        </div>";

    // echo $obj->fees* . "@@" . $tot;
    if($countryCode!='GB') {
        echo $obj->fees*$convertionRate . "@@" . $tot*$convertionRate;
    } else {
        echo $obj->fees . "@@" . $tot;
    }
}





if ($type_of_contract == 3) {

    $min_stay = $obj->ninimum_stay;
    $next_date = date('Y-m-d', strtotime($start_date . ' +' . $min_stay . 'day'));

    if ($end_date > $next_date) {
        $date3 = date_create($end_date);
        $date4 = date_create($next_date);
        $diff1 = date_diff($date3, $date4);
        $val1 = $diff1->format("%R%a");
    } else {
        $date3 = date_create($next_date);
        $date4 = date_create($end_date);
        $diff1 = date_diff($date3, $date4);
        $val1 = $diff1->format("%R%a");
    }

    $output1 = ltrim($val1, '-');


    $fees = $obj->fees * $obj->ninimum_stay;
    $fee = $fees + ($output1 * $obj->fees);

    $tot = $obj->price + $fee;


//    echo "<div class='top-area'>
//                                            <span class='price'>Price</span>
//                                            <span class='month'>$ $obj->price</span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Booking fee</span>
//                                            <span class='month'>$ $fee </span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Total</span>
//                                            <span class='month'>$ $tot </span>
//                                        </div>";


    // echo $fee . "@@" . $tot;
    if($countryCode!='GB') {
        echo $fee*$convertionRate . "@@" . $tot*$convertionRate;
    } else {
        echo $fee . "@@" . $tot;
    }
}


if ($type_of_contract == 2) {


    $date4 = date_create($end_date);
    $date5 = date_create($next_date);
    $diff1 = date_diff($date4, $date5);
    $val3 = $diff1->format("%R%a");

    $output2 = ltrim($val3, '-');

    $expval = end(explode('-', $end_date));

    if ($expval == 16 || $expval == 1) {


        $fee = $_REQUEST['sendfees'] + $obj->fees;
        $tot = $obj->price + $fee;
    } else {
        $fee = $_REQUEST['sendfees'];
        $tot = $obj->price + $fee;
    }


//    $tot = $obj->price + $obj->fees;
    //$fee = $obj->fees;
    // $tot = $obj->price + $fee;
//    echo "<div class='top-area'>
//                                            <span class='price'>Price</span>
//                                            <span class='month'>$ $obj->price</span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Booking fee</span>
//                                            <span class='month'>$ $fee </span>
//                                        </div>
//
//                                        <div class='top-area'>
//                                            <span class='price'>Total</span>
//                                            <span class='month'>$ $tot </span>
//                                        </div>";


    // echo $fee . "@@" . $tot;
    if($countryCode!='GB') {
        echo $fee*$convertionRate . "@@" . $tot*$convertionRate;
    } else {
        echo $fee . "@@" . $tot;
    }
}
?>






