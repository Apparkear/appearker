<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

//print_r($_POST);exit;
$user_id = $_SESSION['user_id'];
$parking_id = $_SESSION['new_parking']; 


$street = $_POST['street'];
$intersection = $_POST['intersection'];
$number = $_POST['number'];
$building_name = $_POST['building_name'];
$parkinglot_number = $_POST['parkinglot_number'];
$parkinglot_number = $_POST['geographical_zone'];
$address = $_POST['address'];
$lat= $_POST['lat'];
$lon= $_POST['lon'];
$currency = $_POST['currency'];
$price = $_POST['price'];
$maximum_price = $_POST['maximum_price'];
$discount_month = $_POST['discount_month'];
$discount = $_POST['discount'];
$extrakey = $_POST['extrakey'];
$access_card = $_POST['access_card'];

$is_dynamic = isset($_POST['is_dynamic']) && $_POST['is_dynamic']  ? "1" : "0";
$remote_control = $_POST['remote_control'];


$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    if($parking_id){
        $fields = array(
            'street' => mysqli_real_escape_string($link, $street),
            'intersection' => mysqli_real_escape_string($link, $intersection),
            'number' => mysqli_real_escape_string($link, $number),
            'building_name'=> mysqli_real_escape_string($link, $building_name),
            'geographical_zone'=> mysqli_real_escape_string($link, $geographical_zone),
            'parkinglot_number' => mysqli_real_escape_string($link, $parkinglot_number),
            'currency' => mysqli_real_escape_string($link, $currency),
            'price' => mysqli_real_escape_string($link, $price),
            'maximum_price'=> mysqli_real_escape_string($link, $maximum_price),
            'discount_month' => mysqli_real_escape_string($link, $discount_month),
            'discount' => mysqli_real_escape_string($link, $discount),
            'extrakey'=> mysqli_real_escape_string($link, $extrakey),
            'access_card'=> mysqli_real_escape_string($link, $access_card),
            'remote_control'=> mysqli_real_escape_string($link, $remote_control),
            'is_dynamic'=> mysqli_real_escape_string($link, $is_dynamic),
            'address'=> mysqli_real_escape_string($link, $address),
            'lat'=> mysqli_real_escape_string($link, $lat),
            'lon'=> mysqli_real_escape_string($link, $lon)
        );
        $fieldsList = array();
        foreach ($fields as $field => $value) {
            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
        }
        
       $query_parking = "UPDATE `parking` SET " . implode(', ', $fieldsList) ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
       $rest = mysqli_query($link, $query_parking);
        
        $_SESSION['four']=4;
        header("Location: rent_parking_step5.php"); 
        exit();
        
    }else{
        header("Location: rent_parking_step4.php"); 
        exit(); 
    }
}else{
    header("Location: index.php"); 
    exit();
}


?>