<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
//print_r($_POST); exit;
$country = $_POST['country_list'];
$user_id = $_SESSION['user_id'];
$parking_id = $_SESSION['new_parking'];
//$parking_id = $_SESSION['new_parking'];

$car_type = $_POST['car_type'];
$state = $_POST['states_list'];
$city = $_POST['city_list'];

$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    if($_SESSION['parking_contact']){
        $fields = array(
            'country' => mysqli_real_escape_string($link, $country),
            'state' => mysqli_real_escape_string($link, $state),
            'city' => mysqli_real_escape_string($link, $city),
            'car_type'=> mysqli_real_escape_string($link, $car_type),
            'contact'=>mysqli_real_escape_string($link, $_SESSION['parking_contact'])
        );
    }else{
        $fields = array(
            'country' => mysqli_real_escape_string($link, $country),
            'state' => mysqli_real_escape_string($link, $state),
            'city' => mysqli_real_escape_string($link, $city),
            'car_type'=> mysqli_real_escape_string($link, $car_type)
        );
    }
    
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    if($parking_id != ""){
        $query_parking = "UPDATE `parking` SET " . implode(', ', $fieldsList) ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
        $rest = mysqli_query($link, $query_parking);
        
    }else{
        $query_parking = "INSERT INTO `parking` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
       
        $rest = mysqli_query($link, $query_parking);
        
        $last_id = mysqli_insert_id($link);
        $_SESSION['new_parking'] =$last_id;
//        header("Location: rent_parking_step2.php"); 
//        exit();
        
    }
    
    $_SESSION['two']=2;
    header("Location: rent_parking_step3.php"); 
    exit();
    
   // print_r($rest); exit;
}else{
    
    
    header("Location: index.php"); 
    exit();

}


//print_r($_POST); exit;


?>