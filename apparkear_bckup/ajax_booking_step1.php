<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
//print_r($_FILES['id_proof']); exit;
$id = $_POST['parking_id'];

$parking_spaces = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$id}"));

$user_id = $_SESSION['user_id'];
$order_id = round(uniqid(rand(), true)); 
   //echo $_POST['dob_month']." ".$_POST['dob_day'];exit;
   $dob = $_POST['dob_year'].'-'.$_POST['dob_month'].'-'.$_POST['dob_day']; 
   $rental_time = isset($_POST['rental_time']) ? $_POST['rental_time'] : '';
   $requirement = isset($_POST['requirement']) ? $_POST['requirement'] : '';
   $make = isset($_POST['make']) ? $_POST['make'] : '';
   $model = isset($_POST['model']) ? $_POST['model'] : '';
   $about_you = isset($_POST['about_you']) ? $_POST['about_you'] : '';
   $promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';
   $color = isset($_POST['color']) ? $_POST['color'] : '';
   $year = isset($_POST['year']) ? $_POST['year'] : '';
   $is_subscribe = isset($_POST['is_subscribe']) && $_POST['is_subscribe']  ? "1" : "0";
   
  
    $fields = array(
        'prop_id' => mysqli_real_escape_string($link, $id),
        'order_id' => mysqli_real_escape_string($link, $order_id),
        'user_id' => mysqli_real_escape_string($link, $user_id),
        'uploder_user_id' => mysqli_real_escape_string($link, $parking_spaces->user_id),
        'firstname' => mysqli_real_escape_string($link, $_POST['first_name']),
        'lastname' => mysqli_real_escape_string($link, $_POST['last_name']),
        'start_date' => mysqli_real_escape_string($link, $_POST['start_date']),
        'end_date' => mysqli_real_escape_string($link, $_POST['end_date']),
        'price' => mysqli_real_escape_string($link, $_POST['price']),
        'service_charge' => mysqli_real_escape_string($link, $_POST['service_charge']),
        'email' => mysqli_real_escape_string($link, $_POST['email']),
        'telephone' => mysqli_real_escape_string($link, $_POST['telephone']),
        'gender' => mysqli_real_escape_string($link, $_POST['last_name']),
        'dob' => mysqli_real_escape_string($link, $dob),
        'payment_date' => mysqli_real_escape_string($link, date('Y-m-d')),
        'rental_time' => mysqli_real_escape_string($link, $rental_time),
        'requirement' => mysqli_real_escape_string($link, $requirement),
        'make' => mysqli_real_escape_string($link, $make),
        'model' => mysqli_real_escape_string($link, $model),
        'year' => mysqli_real_escape_string($link, $year),
        'color' => mysqli_real_escape_string($link, $color),
        'about_you' => mysqli_real_escape_string($link, $about_you),
        'promocode' => mysqli_real_escape_string($link, $promo_code),
        'is_subscribe' => mysqli_real_escape_string($link, $is_subscribe)
        
        
        
        
    );
    
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
  $addQuery = "INSERT INTO `estejmam_booking` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
    
//    $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
//        . " WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'";

    mysqli_query($link, $addQuery);
   $last_id = mysqli_insert_id($link);
   
   $updateQuery = "UPDATE `estejmam_user` SET `about_me`='$about_you' WHERE `id`=$user_id";
   mysqli_query($link, $updateQuery);
   
   if ($_FILES['id_proof']['tmp_name'] != '') {
            $target_path = "../upload/proof/";
            $userfile_name = $_FILES['id_proof']['name'];
            $userfile_tmp = $_FILES['id_proof']['tmp_name'];
            $img_name = $userfile_name;
            $img = $target_path . $img_name;
            move_uploaded_file($userfile_tmp, $img);

            $image_id_proof = mysqli_query($link, "UPDATE `estejmam_booking` SET `id_proof`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $last_id) . "'");
        }
   if ($_FILES['work_certificate']['tmp_name'] != '') {
            $target_path = "../upload/proof/";
            $userfile_name = $_FILES['work_certificate']['name'];
            $userfile_tmp = $_FILES['work_certificate']['tmp_name'];
            $img_name = $userfile_name;
            $img = $target_path . $img_name;
            move_uploaded_file($userfile_tmp, $img);

            $image_work_certificate = mysqli_query($link, "UPDATE `estejmam_booking` SET `work_certificate`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $last_id) . "'");
        }
   if ($_FILES['bill_image']['tmp_name'] != '') {
            $target_path = "../upload/proof/";
            $userfile_name = $_FILES['bill_image']['name'];
            $userfile_tmp = $_FILES['bill_image']['tmp_name'];
            $img_name = $userfile_name;
            $img = $target_path . $img_name;
            move_uploaded_file($userfile_tmp, $img);

            $image_utilitybill = mysqli_query($link, "UPDATE `estejmam_booking` SET `utility_bill`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $last_id) . "'");
        }
        
    
   
   $_SESSION['booking_park_step1']=$_POST['url'];
   echo $bookig_id = base64_encode($last_id); 
   header("Location: booking_step_two.php?gnikrap=$bookig_id");
    




?>