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



$available_start = $_POST['available_start'];
$available_end = $_POST['available_end']; 

if(isset($_POST['is_strict'])){
    $is_strict = $_POST['is_strict'];
}else{
    $is_strict = 0;
}
//$is_moderate = isset($_POST['is_moderate']) && $_POST['is_moderate']  ? "1" : "0";
//$is_flexible = isset($_POST['is_flexible']) && $_POST['is_flexible']  ? "1" : "0";
$is_google_sync = isset($_POST['is_google_sync']) && $_POST['is_google_sync']  ? "1" : "0";


$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    if($parking_id){
        $fields = array(
            'available_start' => mysqli_real_escape_string($link, $available_start),
            'avaliable_end' => mysqli_real_escape_string($link, $available_end),
            'is_strict' => mysqli_real_escape_string($link, $is_strict),
            'is_moderate'=> mysqli_real_escape_string($link, $is_moderate),
            'is_flexible' => mysqli_real_escape_string($link, $is_flexible),
            'is_google_sync' => mysqli_real_escape_string($link, $is_google_sync)
            
        );
        $fieldsList = array();
        foreach ($fields as $field => $value) {
            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
        }
        
       $query_parking = "UPDATE `parking` SET " . implode(', ', $fieldsList) ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
       $rest = mysqli_query($link, $query_parking);
        
        $_SESSION['six']=6;
        header("Location: rent_parking_step7.php"); 
        exit();
        
    }else{
        header("Location: rent_parking_step6.php"); 
        exit(); 
    }
}else{
    header("Location: index.php"); 
    exit();
}


?>