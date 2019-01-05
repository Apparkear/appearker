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


$notice_time = $_POST['notice_time'];
$notice_time_type = $_POST['notice_time_type'];
$preparation_time = $_POST['preparation_time'];
$preparation_time_type = $_POST['preparation_time_type'];
$booking_window = $_POST['booking_window'];

$rental_max = $_POST['rental_max'];
$rental_min = $_POST['rental_min'];


$is_id = isset($_POST['is_id']) && $_POST['is_id']  ? "1" : "0";
$is_workcertificate = isset($_POST['is_workcertificate']) && $_POST['is_workcertificate']  ? "1" : "0";
$is_utility = isset($_POST['is_utility']) && $_POST['is_utility']  ? "1" : "0";


$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    if($parking_id){
        $fields = array(
            'notice_time' => mysqli_real_escape_string($link, $notice_time),
            'notice_time_type' => mysqli_real_escape_string($link, $notice_time_type),
            'preparation_time' => mysqli_real_escape_string($link, $preparation_time),
            'preparation_time_type'=> mysqli_real_escape_string($link, $preparation_time_type),
            'booking_window' => mysqli_real_escape_string($link, $booking_window),
            'rental_max' => mysqli_real_escape_string($link, $rental_max),
            'rental_min' => mysqli_real_escape_string($link, $rental_min),
            'is_id'=> mysqli_real_escape_string($link, $is_id),
            'is_workcertificate' => mysqli_real_escape_string($link, $is_workcertificate),
            'is_utility' => mysqli_real_escape_string($link, $is_utility)
            
        );
        $fieldsList = array();
        foreach ($fields as $field => $value) {
            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
        }
        
       $query_parking = "UPDATE `parking` SET " . implode(', ', $fieldsList) ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
       $rest = mysqli_query($link, $query_parking);
        
        $_SESSION['five']=5;
        header("Location: rent_parking_step6.php"); 
        exit();
        
    }else{
        header("Location: rent_parking_step5.php"); 
        exit(); 
    }
}else{
    header("Location: index.php"); 
    exit();
}


?>