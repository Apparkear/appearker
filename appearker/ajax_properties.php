<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
$parking_id = base64_decode($_REQUEST["di"]); 

$get_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$parking_id}"));

$contact = $get_details->contact;
$_SESSION['add_session'] =2;
$_SESSION['new_parking'] =$parking_id;
$_SESSION['parking_contact'] =$contact;

header("Location: rent_parking_step1.php");

?>