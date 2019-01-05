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

$name = $_POST['name'];
$description = $_POST['description'];
$rules = $_POST['rules'];
$accessibility = $_POST['accessibility'];


$amenities_array = $_POST['amenities'];
$amenities =""; 
$count = 0; 
$total = count($amenities_array);

foreach($amenities_array as $key=>$val){
    if($total-1 == $count){
        $amenities .= $val;
    }else{
        $amenities .= $val.",";
    }
    $count = $count+1;
}

echo $amenities;exit;

?>