<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
include("class.phpmailer.php");
include 'Twilio.php';
?>


<?php
$action = $_GET['action'];

switch ($action) {
    case ($action=='forgetpaswd'):
        forgetpaswrd();
        break;
    case ($action=='contactus'):
        contactUs();
        break;
    case ($action=='signup'):
        signUp();
        break;
    default:
        echo "hi, have a nice day";
}


function forgetpaswrd()
{
	$data['ack']='';
	$pass = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',9)),0,9);
	$code = md5($pass);

	$email = $_POST['eml'];
	
	$result = mysql_query("SELECT * FROM `estejmam_user` WHERE `email` = '$email'");
	//print_r(mysql_num_rows($result)); exit;
	if(mysql_num_rows($result) >0){
		
		$sql = mysql_query("UPDATE estejmam_user SET password = '$code' WHERE email = '$email'");
		
		
		if($sql){
			
			$to = $email;
			$subject = "New password";

			$message = 'Dear user,'.' '.$pass.' '.'this is your new login password';

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <webmaster@example.com>' . "\r\n";
			
			mail($to,$subject,$message,$headers);

			$data['ack']=1;
		}else{
			$data['ack']=0;
		}
	}else{
		$data['ack']=2;
	}
	echo $data['ack']; exit;
}

function contactUs()
{ 	
	
	
	$city = $_POST['city'];
	$name = $_POST['user_name'];
	$email = $_POST['user_email'];
	$subject = $_POST['user_subject'];
	$enqueryFor = $_POST['enqueryFor'];
	$msg = $_POST['user_message'];
	$user_phone= $_POST['user_phone'];
	//print_r($info);exit;

	$result = mysql_query("SELECT * FROM `estejmam_tbladmin` WHERE `id` = '1'");
	$data = mysql_fetch_array($result);

	$emailTemplate = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_email_templt` WHERE `id` = '14'"));

	

	$email_admin = $data['email'];
	$subject = "Enquery Details";

	$message = str_replace(
			    	array(
			    		'[ENQURYFOR]',
			    		'[NAME]',
			    		'[EMAIL]',
			    		'[SUBJECT]',
			    		'[MESSAGE]',
					 '[PHONE]'
			    		),
			    	array(
			    		$enqueryFor,
			    		$name,
			    		$email,
			    		$subject,
			    		$msg,
					$user_phone
			    		),
			    	$emailTemplate['description']
		    	);

	
	// $headers = "MIME-Version: 1.0" . "\r\n";
	// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	// More headers
	// $headers .= 'From: <contactus@roomarate.com>' . "\r\n";

	$TemplateMessage = $message;
	$mail1 = new PHPMailer;
	$mail1->FromName =$name;
	$mail1->From = $email_admin;
	$mail1->Subject = $subject;



	$mail1->Body = stripslashes($TemplateMessage);
	$mail1->AltBody = stripslashes($TemplateMessage);
	$mail1->IsHTML(true);
	$mail1->AddAddress('roomarate@gmail.com', "roomarate.com"); //info@salaryleak.com
	
	if($mail1->Send()){

		try {

	    		//----------- SMS TO USER START -------------//
	    
			        $account_sid = 'AC740f0d30d09056acd3d2f6430d8e8dd0';
		        	$auth_token = 'e71f23dc67ddcf9fa5ffcee7a8deccef';
			        $client = new Services_Twilio($account_sid, $auth_token);

			        // print_r($client->account->messages);
			        // $name = $_SESSION['name'];
			        // $phone = $all_details->telephone;
			        $sender['user_first_name'] = "Roomarate";
			        // echo '<pre>'; print_r($client); echo '</pre>'; exit;

			        $client->account->messages->create(array(
			            'To' =>'+442038564546',
			            'From' => "+15807012787",
			            'Body' =>str_replace('&nbsp;',' ',strip_tags($message))
			        ));
			        
				//----------- SMS TO USER END -------------//
	        	
	        } catch (Exception $e) {
	        	$data['msg'] = $e->getMessage(); 
	        }

		echo 1;
		exit;
	}else{
		echo 2;
		exit;
	}
}

function signUp(){

	$data['ack']='';
	$name = $_POST['user_name'];
	$city = $_POST['user_city'];
	$phone = $_POST['user_phone'];
	$type = '0';
	$status = '0';
	$result = mysql_query("SELECT 1 FROM estejmam_user WHERE `phone` = '$phone'");
	//echo $result; exit;
	if($result && mysql_num_rows($result) >0){
		$data['ack']=2;
		}else{
			if($name!='' && $city!='' && $phone!=''){
				$sql = "INSERT INTO `estejmam_user`(fname,city,phone,type,status) VALUES('".$name."','".$city."','".$phone."','".$type."','".$status."')";
				$result = mysql_query($sql);
				if($result){
					$data['ack']=1;
				}else{
					$data['ack']=0;
				}
			}else{
				$data['ack']=3;
			}
		}
	echo $data['ack']; exit;
}
?>