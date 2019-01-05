<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
$_SESSION['add_session'] =1;
$_SESSION['list_session'] =1;

header("Location: rent_parking_step1.php");

?>