<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
include("class.phpmailer.php");
include 'Twilio.php';
?>


<?php
$user_id = $_SESSION['user_id'];
if(isset($_REQUEST)) {
   // echo "1moi"; exit;
 //print_r($_POST); exit;  
   //print_r($_FILES);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name']; 
    $address = $_POST['address'];
    $password = $_POST['user_pass'];
    $country = $_POST['country_list'];
    $state = $_POST['states_list'];
    $city = $_POST['city_list'];
   
    $phone = $_POST['phone'];
    $work = $_POST['work'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $client_code = $_POST['client_code'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon']; 
    $company = $_POST['comapny']; 
    
    $result = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id` = '" . $user_id . "'"));
    if ($phone != $result->phone){
        $mobile_verifyed='';
        $mobile_update = mysqli_query($link, "UPDATE `estejmam_user` SET `mobile_verifyed`=NULL WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'");
    }

    $fields = array(
        'fname' => mysqli_real_escape_string($link, $first_name),
        'lname' => mysqli_real_escape_string($link, $last_name),
        'address' => mysqli_real_escape_string($link, $address),
        'password' => md5(mysqli_real_escape_string($link, $password)),
        'country' => mysqli_real_escape_string($link, $country),
        'state' => mysqli_real_escape_string($link, $state),
        'city' => mysqli_real_escape_string($link, $city),
        'phone' => mysqli_real_escape_string($link, $phone),
        'work' => mysqli_real_escape_string($link, $work),
        'dob' => mysqli_real_escape_string($link, $dob),
        'gender' => mysqli_real_escape_string($link, $gender),
        'client_code' => mysqli_real_escape_string($link, $client_code),
        'lat' => mysqli_real_escape_string($link, $lat),
        'lon' => mysqli_real_escape_string($link, $lon),
        'company' => mysqli_real_escape_string($link, $company),
        
    );
//print_r($fields); exit;
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
    $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'";

    mysqli_query($link, $editQuery);

    
   
  
   if ($_FILES['image']['tmp_name'] != '') {
        $target_path = "./upload/user_image/";
        $userfile_name = $_FILES['image']['name']; 
        $userfile_tmp = $_FILES['image']['tmp_name'];
        $img_name = $userfile_name;
        $img = $target_path . $img_name;
        move_uploaded_file($userfile_tmp, $img);

        $image = mysqli_query($link, "UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'");
    }
   
    header("Location: renter_edit_profile.php");

}
?>