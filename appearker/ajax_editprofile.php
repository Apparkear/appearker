<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');

$adminDetails = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));

$data = array();
$user_id = $_SESSION["user_id"];
if($_POST['action'] == "confmail"){
    $otp = rand(1000,999999);
    $adminEmail = $adminDetails->email;
    $get_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`=$user_id"));
    $user_mail = $get_details->email;
    $Subject = "Confirmation OTP";
    $TemplateMessage = "Your apparkear security code is ".$otp;
    
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
    $mail->Sender = $user_mail; // indicates ReturnPath header
    $mail->AddReplyTo($user_mail, "Apparkear"); // indicates ReplyTo headers
    //$mail->AddCC('cc@site.com.com', 'CC: to site.com');
    $mail->Subject = $Subject;
    $mail->Body = $TemplateMessage;
    $mail->AddAddress($user_mail);
    if($mail->Send()){
        $query = mysqli_query($link, "UPDATE `estejmam_user` SET `email_verifyed`= ".$otp." WHERE  `id` = '" . $user_id . "'");
        //echo $query; exit;
        if($query== 1){
            $data['ack'] = 1;
            //$data['msg'] = "successfully confirmed";
        }else{
            $data['ack']= 0; 
           // $data['msg'] = "Already confirmed";
        }
    }else{
        $data['ack'] = 0;
    }
    
    
}else{
    
   $from_phoneno = "+17027665877";
    
    $account_sid = 'AC39b48e107213f6fad45670ba6c6dfe23';
        $auth_token = '2ac5efa85d61603abc63e879835b5fad';
        // $account_sid = 'ACdcc8ac98578931bc3098602c76cac36f';
        // $auth_token = 'd9c02eaf6b679ffa57ad7a4e047d6711';
//echo $_POST['phone'];exit;
        $client = new Services_Twilio($account_sid, $auth_token);
        $otp = rand(1000,999999);
        $body = 'Your apparkear security code is'.$otp;
        $msg = $client->account->messages->create(array(
            //'To' => $get_details['Kid']['parent1_number'],
            'To' => $_POST['phone'],
            // 'From' => "+16473602969",
            // 'From' => "+918967467990",
            'From' => $from_phoneno,
            'Body' => $body,
        ));
        
        $query = mysqli_query($link, "UPDATE `estejmam_user` SET `mobile_verify_number`= ".$otp.",`phone`='".$_POST['phone']."' WHERE  `id` = '" . $user_id . "'");
        // if($_SESSION['parking_contact'] != ""){
        //     $query = mysqli_query($link, "UPDATE `estejmam_user` SET `phone_verified`= ".$otp." WHERE  `id` = '" . $_SESSION['parking_contact'] . "'");
        // }else{
        //     $query = mysqli_query($link, "INSERT INTO `estejmam_user`(`phone_verified`) VALUES('".$otp."')");
        //     $_SESSION['parking_contact'] = mysqli_insert_id($link);
        // }

    if($query== 1){
        $data['ack'] = 1;
        //$data['msg'] = "successfully confirmed";
    }else{
        $data['ack']= 0; 
       // $data['msg'] = "Already confirmed";
    }

       
       
}


echo json_encode($data['ack']); exit;


?>