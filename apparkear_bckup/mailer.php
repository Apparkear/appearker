<?php
session_start();
//include("administrator/includes/config.php");
include("class.phpmailer.php");




function adminMail($email,$property_name,$property_address,$move_in,$move_out,$text){

$email;
$Subject = "Roomarate - Booking  has been accepted";

$detail4 = "";

$detail4 .= $text;
$detail4 .= "<p><span>Property Name: ".$property_name." </span></p>";
$detail4 .= "<p><span>Property Address: ".$property_address." </span></p>";
$detail4 .= "<p><span>Move In: ".$move_in." </span></p>";
$detail4 .= "<p><span>Move Out: ".$move_out." </span></p>";



$TemplateMessage = $detail4;
$mail1 = new PHPMailer;
$mail1->FromName = "The Roomarate Team";
$mail1->From = "info@roomarate.com";
$mail1->Subject = $Subject;



$mail1->Body = stripslashes($TemplateMessage);
$mail1->AltBody = stripslashes($TemplateMessage);
$mail1->IsHTML(true);
$mail1->AddAddress($email, "roomarate.com"); //info@salaryleak.com
$mail1->Send();

}



function landloardMail($email,$lfname,$tname,$temail,$tphone,$tnation,$tgender,$tdob,$Subject){

$emailTemplate = mysql_fetch_array(mysql_query("SELECT * FROM estejmam_email_templt WHERE `id`=7 "));

$detail4 = str_replace(
            array(
                '[LANDLORD]',
                '[TENANTFULLNAME]',
                '[TENANTEMAIL]',
                '[TENANTCONTACTNUMBER]',
                '[NATIONALITY]',
                '[GENDER]',
                '[Dateofbirth]'
                ),
            array(
                $lfname,
                $tname,
                $temail,
                $tphone,
                $tnation,
                $tgender,
                $tdob
                ),
            $emailTemplate['description']
        );


$TemplateMessage = $detail4;
$mail1 = new PHPMailer;
$mail1->FromName = "The Roomarate Team";
$mail1->From = "info@roomarate.com";
$mail1->Subject = $emailTemplate['subject'];



$mail1->Body = stripslashes($TemplateMessage);
$mail1->AltBody = stripslashes($TemplateMessage);
$mail1->IsHTML(true);
$mail1->AddAddress($email, "roomarate.com"); //info@salaryleak.com
$mail1->Send();
	
}



function customerMail($email,$tname,$property_id,$booking_id,$move_in,$move_out,$lname,$lphone,$lemail,$Subject){

	
$emailTemplate = mysql_fetch_array(mysql_query("SELECT * FROM estejmam_email_templt WHERE `id`=8"));

$detail4 = str_replace(
            array(
                '[TENANT]',
                '[PROPERTYID]',
                '[BOOKINGID]',
                '[MOVEIN]',
                '[MOVEOUT]',
                '[PROPERTYADDRESS]',
                '[LANDLORD]',
                '[NUMBER]',
                '[EMAIL]'
                ),
            array(
                $tname,
                $property_id,
                $booking_id,
                $move_in,
                $move_out,
                $lname,
                $lphone,
                $lemail
                ),
            $emailTemplate['description']
        );




$TemplateMessage = $detail4;
$mail1 = new PHPMailer;
$mail1->FromName = "The Roomarate Team";
$mail1->From = "info@roomarate.com";
$mail1->Subject = $Subject;



$mail1->Body = stripslashes($TemplateMessage);
$mail1->AltBody = stripslashes($TemplateMessage);
$mail1->IsHTML(true);
$mail1->AddAddress($email, "roomarate.com"); //info@salaryleak.com
$mail1->Send();
	
}

?>