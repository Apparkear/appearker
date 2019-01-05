<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>

<?php
$adminDetails = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));

$old_password = md5($_POST['old_pass']);
$new_password = md5($_POST['new_pass']);
echo $user_id = $_SESSION['user_id']; exit;
?>