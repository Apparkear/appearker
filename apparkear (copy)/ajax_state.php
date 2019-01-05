<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
//echo $_POST['country_id'];exit;

if(!empty($_POST['country_id'])) {
	$query =mysqli_query($link,"SELECT * FROM states WHERE country_id = '" . $_POST["country_id"] . "'");

	$html = '<option value="">Select State</option>';

     while($subcat1 = mysqli_fetch_array($query)){

	$html .='<option value="'.$subcat1['id'].'">'.$subcat1['name'].'</option>';

  //print_r($subcat1);
	}
        
}
if(!empty($_POST['state_id'])) {
	$query =mysqli_query($link,"SELECT * FROM cities WHERE state_id = '" . $_POST["state_id"] . "'");

	$html = '<option value="">Select City</option>';

     while($subcat = mysqli_fetch_array($query)){

	$html .= '<option value="'.$subcat['id'].'">'.$subcat['name'].'</option>';

  //print_r($subcat);
	}
}


echo $html;exit;
?>