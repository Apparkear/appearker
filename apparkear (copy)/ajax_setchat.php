<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');

?>
<?php
$page = $_POST['page'];
if($page == "messagelist"){
    $_SESSION["message_receiver_id"] = $_POST['message_receiver_id'];
    $data['Ack']=1;
    echo json_encode($data);
    exit;
}
if($page == "list"){
    $get_id = $_POST["chatUser"];
    
    $get_image_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$get_id}"));
    
    $image = './upload/user_image/'.$get_image_details->image;
    
    $data['image'] = $image;
    
    echo json_encode($data); 
    exit;
}


?>