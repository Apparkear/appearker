
<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>

<?php
$adminDetails = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));

$agent_id = '';
$agent_name = '';

$data['ack'] = '';
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$user_email = $_POST['email_address'];
$pass = $_POST['pass'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$type = $_POST['type'];


$status = '0';
$date = date("Y-m-d");

$result = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `email` = '" . $user_email . "'"));

if ($result) {

    $data['ack'] = 2;
    
} else {
   
    $sql = "INSERT INTO `estejmam_user`(`fname`,`lname`,`email`,`password`,`gender`,`phone`,`type`,`status`,`add_date`) VALUES('" . $fname . "','" . $lname . "','" . $user_email . "','" . md5($pass) . "','" . $gender . "','" . $phone . "','" . $type . "','" . $status . "','" . $date . "')";
 
    mysqli_query($link,$sql);
    $last_id = mysqli_insert_id($link);
 
    if ($last_id) {
        $data['ack'] = 1;

        $get_user = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `email` = '" . $user_email . "'"));
      
        $_SESSION['login_username'] = $get_user->fname . ' ' . $get_user->lname;
       
        $_SESSION['user_id'] = $get_user->id;
        $_SESSION['user_type'] = $get_user->type;;
        
        $result_query = mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
        $adminDetails = mysqli_fetch_object($result_query);
        $toemailAdmin = $adminDetails->email;
        $phonenoAdmin = $adminDetails->phone_no;
      
        $mailheaderAdmin = 'A new user signup on apparkear.';
        $login_urlAdmin = SITE_URL . "administrator/index.php";

        $toemailLandlord = $user_email;
        $mailheaderLandlord = 'Thank You for signup on apparkear.';
       
        $login_urlLandlord = SITE_URL;
        landlorduserMailFunction($toemailLandlord, $fname.' '.$lname, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails);
     } else {
        $data['ack'] = 0;
    }
}

unset($_SESSION["msg"]);
if($data['ack'] ==1){
    header("Location: ".SITE_URL);
    die();
}else if($data['ack'] ==2){
    $_SESSION['msg'] = "Email address already registered";
    header("Location: ".SITE_URL);
    die();
}else{
    header("Location: ".SITE_URL);
    die();
}


function landlorduserMailFunction($toemailLandlord, $name, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails) {
    
    $adminEmail = $adminDetails->email;
    $logo = SITE_URL . "./upload/site_logo/".$site_settings->sitelogo;
    $detail4 = "Welcome to Apparkear Please login";

    $Subject = "Welcome Apparkear";


    $TemplateMessage = $detail4; 
    

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
    $mail->AddAddress($user_email);
    if($mail->Send()){
        $data['ack'] = 1;
    }else{
        $data['ack'] = 0;
    }

}

exit;
?>