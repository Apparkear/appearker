<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

$user_id = $_SESSION['user_id']; 

$gte_conf_type = $_POST['otp_type'];
$gte_conf_otp = $_POST['otp_value'];
$phone_num = $_POST['phone_number'];
//echo $phone_num."Moi"; exit;
if($user_id != ''){
    $query_contact=mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`=".$user_id));

    if($gte_conf_type == "phone"){
        $fields = array(
            'user_id' => mysqli_real_escape_string($link, $user_id),
            'message_otp' => mysqli_real_escape_string($link, $gte_conf_otp),
            'confirm_date' => mysqli_real_escape_string($link, date("Y-m-d"))
        );
    }else{
        $fields = array(
            'user_id' => mysqli_real_escape_string($link, $user_id),
            'mail_otp' => mysqli_real_escape_string($link, $gte_conf_otp),
            'confirm_date' => mysqli_real_escape_string($link, date("Y-m-d"))
        );
    }
    
    if(!empty($query_contact)){
        if($gte_conf_type == "phone"){
            $otp = $query_contact->mobile_verify_number;
            $field = 'mobile_verifyed';
        }else{
            $otp = $query_contact->email_verifyed;
            $field = 'is_email';
        }
    }else{
        $otp = 0;
    }
    
    if($otp == $gte_conf_otp){
    
        $field_update = mysqli_query($link, "UPDATE `estejmam_user` SET $field= ".$otp." WHERE  `id` = '" . $user_id . "'");
        
        $fieldsList = array();
        foreach ($fields as $field => $value) {
            $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
        }
        $query_parking = "INSERT INTO `confirmation` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
        
        $rest = mysqli_query($link, $query_parking);
        if($rest == 1){
            $data['ack']=1;
        }else{
            $data['ack']=0;
        }
    }else{
        $data['ack']=0;
    }
    echo json_encode($data['ack']); exit;
}else{
    header("Location: index.php"); 
    exit();

}

?>