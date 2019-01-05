<?php
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');

$redirect_to = 'jobs.php';

$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$file = $_FILES['cv'];

//recipient
$to='soumenporel@natitsolved.com';

//sender
$from = $email;
$fromName = $fname.' '.$lname;

$subject = "Job Application"; 

$htmlContent = "Name: {$fromName}<br />";
$htmlContent .= "Email: {$email}<br />";
$htmlContent .= "Phone: {$phone}<br />";
$htmlContent .= "City: {$city}<br />";

$htmlContent = '<table width="100%" border="1">
    <tbody>
        <tr>
            <td>Name</td>
            <td>'.$fromName.'</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>'.$email.'</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>'.$phone.'</td>
        </tr>
        <tr>
            <td>City</td>
            <td>'.$city.'</td>
        </tr>
    </tbody>
</table>';


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
$mail->From = $from;
$mail->FromName = "Apparkear";
$mail->Sender = $from; // indicates ReturnPath header
$mail->AddReplyTo($from, "Apparkear"); // indicates ReplyTo headers
$mail->Subject = $subject;
$mail->Body = $htmlContent;
$mail->addAttachment($_FILES['cv']['tmp_name'],$_FILES['cv']['name']);
$mail->AddAddress($to);
if($mail->Send()){
    session_start(); // Start the session
$_SESSION['msg'] = '<div class="alert alert-success text-center"><strong>Your application form has been submitted successfully. We will get back you shortly.</strong></div>';
}


    



header("Location: ".SITE_URL.$redirect_to);
exit();