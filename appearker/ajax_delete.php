<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
$data = array();

$user_id = $_SESSION['user_id'];
$parking_id = $_POST['parking_id'];
if($parking_id != "" && $user_id != ""){
    $update_query = "UPDATE `parking` SET `status`=0 WHERE `user_id`=$user_id AND `id`=$parking_id";
    mysqli_query($link,$update_query);
    $data['ack']= 1;
}else{
    $data['ack']= 0;
}

echo json_encode($data);exit;





?>