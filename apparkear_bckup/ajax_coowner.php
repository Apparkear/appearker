<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

//print_r($_POST); exit;

$id = $_SESSION['new_parking'];
$parking_id = $_SESSION['new_parking']; 
$user_id = $_SESSION['user_id'];

$first_name = $_POST['fname'];
$last_name = $_POST['lname'];
$email = $_POST['email'];
$co_ownerid = $_POST['co_ownerid'];

$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($email != ''){
    $fields = array(
        'fname' => mysqli_real_escape_string($link, $first_name),
        'lname' => mysqli_real_escape_string($link, $last_name),
        'email' => mysqli_real_escape_string($link, $email),
        'added_date'=> mysqli_real_escape_string($link, date('Y-m-d'))
    );
    
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
//    echo "INSERT INTO `coowner` (`" . implode('`,`', array_keys($fields)) . "`)"
//            . " VALUES ('" . implode("','", array_values($fields)) . "')";exit;
    if($co_ownerid){
        $updateQuery = "UPDATE `coowner` SET ". implode(', ', $fieldsList) ." WHERE  `id`=".mysqli_real_escape_string($link,$co_ownerid);
        mysqli_query($link, $addQuery);
    }else{
        $addQuery = "INSERT INTO `coowner` (`" . implode('`,`', array_keys($fields)) . "`)"
                . " VALUES ('" . implode("','", array_values($fields)) . "')"; 

        mysqli_query($link, $addQuery);
        $last_id = mysqli_insert_id($link);
       // $_SESSION['co_owner'] = $last_id;

        $update_parking = "UPDATE `parking` SET `co_ownerid` = " . $last_id
            . ", `status`= 1 WHERE `id` = " . mysqli_real_escape_string($link, $parking_id) ;  
        
        $rest = mysqli_query($link, $update_parking);
    }
    //echo $rest;exit; 
    $result_query = mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
    $adminDetails = mysqli_fetch_object($result_query);
    $toemailAdmin = $adminDetails->email;
    $phonenoAdmin = $adminDetails->phone_no;

    $mailheaderAdmin = 'A new user signup on apparkear.';
    $login_urlAdmin = SITE_URL . "administrator/index.php";

    $toemailLandlord = $email;
    $full_name = $user_details->fname.' '.$user_details->lname;
    $mailheaderLandlord = 'You have added in apparkear as a co-owner by '.$full_name;
    $user_email = $email;
    $login_urlLandlord = SITE_URL;
   $val_mail =  landlorduserMailFunction($toemailLandlord, $fname.' '.$lname, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails,$mailheaderLandlord);

   $data['ack'] = $val_mail;
   
    }else{
     $data['ack'] = 0;
}  
if($data['ack'] ==1){
    unset($_SESSION['new_parking']);
    unset($_SESSION['parking_contact']);

    $_SESSION['seven']=7;
    header("Location: rent_parking_step8.php");
}else{
    header("Location: rent_parking_step7.php");
    die();
}


function landlorduserMailFunction($toemailLandlord, $name, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails,$mailheaderLandlord) {
    
    $adminEmail = $adminDetails->email; 
    $logo = SITE_URL . "./upload/site_logo/".$site_settings->sitelogo;
    $detail4 = "Welcome to Apparkear Please login";

    $Subject = "Welcome Apparkear";
    //echo $user_email;exit;

  $TemplateMessage = $mailheaderLandlord; 
    

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
    return $data['ack'];
    //echo $data['ack'];exit;
}

exit;    


    
?>