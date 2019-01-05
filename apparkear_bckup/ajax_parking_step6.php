<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

//print_r($_POST); exit;

$parking_id = $_SESSION['new_parking'];
$user_id = $_SESSION['user_id'];
$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    $update_parking = "UPDATE `parking` SET `status`= 1 WHERE `id` = " . mysqli_real_escape_string($link, $parking_id) ;  
        
        $rest = mysqli_query($link, $update_parking);
        
    header("Location: rent_parking_step8.php");
}