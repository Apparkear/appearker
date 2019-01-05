<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

//print_r($_POST);exit;
//$_SESSION['new_parking'] = 16;
 
$user_id = $_SESSION['user_id'];
//$parking_id = $_SESSION['new_parking']; 


$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$mobile = $_POST['mobile'];
$validation_number = $_POST['validation_number'];
$alternate_phone = $_POST['alternate_phone'];
$terms_n_cond_agree = isset($_POST['terms_n_cond_agree']) && $_POST['terms_n_cond_agree']  ? "1" : "0";
$newsletter_agree = isset($_POST['newsletter_agree']) && $_POST['newsletter_agree']  ? "1" : "0";


if($user_id != ''){
    if($_SESSION['parking_contact'] != ""){
       // echo "if";exit;
        $fields = array(
            'first_name' => mysqli_real_escape_string($link, $first_name),
            'last_name' => mysqli_real_escape_string($link, $last_name),
            'email' => mysqli_real_escape_string($link, $email),
            'phone' => mysqli_real_escape_string($link, $phone),
            'mobile' => mysqli_real_escape_string($link, $mobile),
            'validation_number'=> mysqli_real_escape_string($link, $validation_number),
            'alternate_phone'=> mysqli_real_escape_string($link, $alternate_phone),
            'terms_n_cond_agree'=> mysqli_real_escape_string($link, $terms_n_cond_agree),
            'newsletter_agree'=> mysqli_real_escape_string($link, $newsletter_agree),
            'contact'=>mysqli_real_escape_string($link, $_SESSION['parking_contact'])
        );
    }else{
       // echo "else";exit;
        $fields = array(
            'first_name' => mysqli_real_escape_string($link, $first_name),
            'last_name' => mysqli_real_escape_string($link, $last_name),
            'email' => mysqli_real_escape_string($link, $email),
            'phone' => mysqli_real_escape_string($link, $phone),
            'mobile' => mysqli_real_escape_string($link, $mobile),
            'validation_number'=> mysqli_real_escape_string($link, $validation_number),
            'alternate_phone'=> mysqli_real_escape_string($link, $alternate_phone),
            'terms_n_cond_agree'=> mysqli_real_escape_string($link, $terms_n_cond_agree),
            'newsletter_agree'=> mysqli_real_escape_string($link, $newsletter_agree)
        );
    }
   // print_r($fields);exit;
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    if($_SESSION['parking_contact'] != ""){
        //echo "if";exit;
       $query_parking = "UPDATE `parking_contact` SET " . implode(', ', $fieldsList)
        ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
        $rest = mysqli_query($link, $query_parking);
        
        
    }else{
        //echo "else";
        $query_parking = "INSERT INTO `parking_contact` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
        
        $rest = mysqli_query($link, $query_parking);
        $_SESSION['parking_contact'] =mysqli_insert_id($link);
    }
    
    
    $_SESSION['one']=1;
    header("Location: rent_parking_step2.php"); 
    exit();
    
   // print_r($rest); exit;
}else{
    
    
    header("Location: index.php"); 
    exit();

}


?>

