
<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

$month = $_POST['month'];
$parking_id = $_POST['parking_id'];
$start_date = $_POST['start_date'];

$start = date('Y-m-d',strtotime($start_date));
$end = "";

switch ($month) {
    case 1:
        $end = date('Y-m-d',strtotime("+1 months", strtotime($start_date)));
        break;
    case 2:
        $end = date('Y-m-d',strtotime("+2 months", strtotime($start_date)));
        break;
    case 3:
        $end = date('Y-m-d',strtotime("+3 months", strtotime($start_date)));
        break;
    case 4:
        $end = date('Y-m-d',strtotime("+4 months", strtotime($start_date)));
        break;
    case 5:
        $end = date('Y-m-d',strtotime("+5 months", strtotime($start_date)));
        break;
    case 6:
        $end = date('Y-m-d',strtotime("+6 months", strtotime($start_date)));
        break;
    case 7:
        $end = date('Y-m-d',strtotime("+7 months", strtotime($start_date)));
        break;
    case 8:
        $end = date('Y-m-d',strtotime("+8 months", strtotime($start_date)));
        break;
    case 9:
        $end = date('Y-m-d',strtotime("+9 months", strtotime($start_date)));
        break;
    case 10:
        $end = date('Y-m-d',strtotime("+10 months", strtotime($start_date)));
        break;
    case 11:
        $end = date('Y-m-d',strtotime("+11 months", strtotime($start_date)));
        break;
   
    default:
        $end = date('Y-m-d',strtotime("+12 months", strtotime($start_date)));
} 


$check_discount = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`=$parking_id"));
$month_no_for_discount = $check_discount->discount_month;
$discount_value = 0;
if($month_no_for_discount == $month){
    $discount_value = $check_discount->discount;
}

$_SESSION['start_date']= $start_date;
$_SESSION['end_date'] = $end;
$_SESSION['booking_month'] = $month;





echo $end.'||'.$discount_value;
exit;

?>