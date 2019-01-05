<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');

$data = array();
$user_id = $_SESSION["user_id"];
if($_POST['action'] == "confmail"){
    
    $otp = rand(1000,999999);
    
    $result_query = mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
    $adminDetails = mysqli_fetch_object($result_query);
    $adminEmail = $adminDetails->email;
    $Subject = "Confirmation OTP";
    $TemplateMessage = "Your apparkear security code is " . $otp;
    
    $mail1 = new PHPMailer;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->Username = 'mail@natitsolved.com';
    $mail->Password = 'Natit#2019';
    
    
    $mail->IsHTML(true);
    $mail->From = $adminEmail;
    $mail->FromName = "Apparkear";
    $mail->Sender = $adminEmail; // indicates ReturnPath header
    $mail->AddReplyTo($adminEmail, "Apparkear"); // indicates ReplyTo headers
    //$mail->AddCC('cc@site.com.com', 'CC: to site.com');
    $mail->Subject = $Subject;
    $mail->Body = $TemplateMessage;
    $mail->AddAddress($_POST['phone']);
    if($mail->Send()){
        if($_SESSION['parking_contact'] != ""){
            $query = mysqli_query($link, "UPDATE `parking_contact` SET `mail_verified`= ".$otp." WHERE  `id` = '" . $_SESSION['parking_contact'] . "'");
        }else{
            $query = mysqli_query($link, "INSERT INTO `parking_contact`(`mail_verified`) VALUES('".$otp."')");
            $_SESSION['parking_contact'] = mysqli_insert_id($link);
        }
        if($query== 1){
            $data['ack'] = 1;
            
        }else{
            $data['ack']= 0; 
           
        }
    }else{
        $data['ack'] = 0;
    }

    
}else{
    
    $from_phoneno = "+17027665877";
    $account_sid = 'AC39b48e107213f6fad45670ba6c6dfe23';
    $auth_token = '2ac5efa85d61603abc63e879835b5fad';
    
//    $from_phoneno = "+918967467990";
//    $account_sid = 'ACdcc8ac98578931bc3098602c76cac36f';
//    $auth_token = 'd9c02eaf6b679ffa57ad7a4e047d6711';
        
    $client = new Services_Twilio($account_sid, $auth_token);
    $otp = rand(1000,999999);
        $body = 'Your apparkear security code is ' . $otp;
        $msg = $client->account->messages->create(array(
            'To' => $_POST['phone'],
            'From' => $from_phoneno,
            'Body' => $body,
        ));
        //echo "INSERT INTO `parking_contact`(`mobile_verifyed`) VALUES('".$otp."')";exit;
    if($_SESSION['parking_contact'] != ""){
        $query = mysqli_query($link, "UPDATE `parking_contact` SET `phone_verified`= ".$otp." WHERE  `id` = '" . $_SESSION['parking_contact'] . "'");
    }else{
        $query = mysqli_query($link, "INSERT INTO `parking_contact`(`phone_verified`) VALUES('".$otp."')");
        $_SESSION['parking_contact'] = mysqli_insert_id($link);
    }   
      
    if($query== 1){
        $data['ack'] = 1;
    }else{
        $data['ack']= 0; 
    }

       
       
}


echo json_encode($data['ack']); exit;


?>