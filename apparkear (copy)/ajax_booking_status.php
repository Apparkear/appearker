<?php
session_start();
include("administrator/includes/config.php");
//require_once "braintree/lib/Braintree.php";
//include('brain_config.php');
//require("mailer.php");
include("class.phpmailer.php");
require('Twilio.php');
define('STRIPE_PRIVATE_KEY', 'sk_test_Dj8pIsLW4QDDORtJ8tkWMiRy');
define('STRIPE_PUBLIC_KEY', 'pk_test_5UeadqIGmHDSLkY0V4NMYFX3');
$action = $_REQUEST['action'];
require('Stripe.php');
switch ($action) {
    case ($action=='acceptBooking'):
        acceptBooking();
        break;
    case ($action=='cancelBooking'):
        cancelBooking();
        break;
    case ($action=='disputeBooking'):
        disputeBooking();
        break;
    default:
        echo "hi, have a nice day";
}

function acceptBooking(){
    $data = array();
    $id = $_REQUEST['bookingID'];
    $sql = "select * from estejmam_booking where `id`=".$id;
    $query = mysqli_query($link, $sql);
    $bookingDetails = mysqli_fetch_array($query);
    $data['id']=$id;
     //echo json_encode($data);
    //die();


    if($bookingDetails){
        if($bookingDetails['status']==1){
            $data['ack'] = 0;
            $data['res'] = " Booking is already Accepted ";
        }else{

            $bkngid = $bookingDetails['id'];

            $startdate = $bookingDetails['start_date'];
            $enddate = $bookingDetails['end_date'];
            $propId = $bookingDetails['prop_id'];
          $sql1 = "select * from estejmam_booking where `prop_id`=".$propId." AND `status`=1 AND ( (`start_date` BETWEEN '".$startdate."' AND '".$enddate."') OR (`end_date` BETWEEN '".$startdate."' AND '".$enddate."') OR ( `start_date` <= '".$startdate."' AND `end_date` >= '".$enddate."'  ) ) ";

            $query1 = mysqli_query($link, $sql1);
            $bookedDetails = mysqli_fetch_array($query1);
            if(empty($bookedDetails)){
                if($bookingDetails['payment_type']=='stripe')
                {
                try {

                    $amount=($bookingDetails['total_price'])*100;
                    $token=$bookingDetails['transaction_id'];
                    $email=$bookingDetails['email'];
			// Include the Stripe library:
			// Assumes you've installed the Stripe PHP library using Composer!
			//require_once('vendor/autoload.php');

			// set your secret key: remember to change this to your live secret key in production
			// see your keys here https://manage.stripe.com/account
			//\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);
      $url = 'https://api.stripe.com/v1/charges';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' .STRIPE_PRIVATE_KEY));
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=' . $amount . '&currency=eur&source='.$token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data_all = curl_exec($ch);
            curl_close($ch);
            $charge= json_decode($data_all);
			// Check that it was paid:
			if ($charge->paid == 1) {
                $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 1,`refurd_id`='".$charge->id."' where `id`='" . $bkngid . "'");

                $data['ack'] = 1;
                $data['res'] = " Booking is Successfully accepted ";

                $sqlBooking = "SELECT * from `estejmam_booking` WHERE `id`='".$id."' AND `status` = '1' ";
                $noofBooking = mysqli_num_rows(mysqli_query($link, $sqlBooking));

                //----------  Agent Onner Commition Start -----------//
                if(isset($bookingDetails['ref_code']) && $bookingDetails['ref_code']!='')
                {
                    $ref_code = $bookingDetails['ref_code'];
                    $propDetails = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id` = '".$propId."'"));
                    $userSQL = mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id` = '".$bookingDetails['uploder_user_id']."'");
                    $userDetails = mysqli_fetch_array($userSQL);
                    $agentDSQl = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `client_code` = '".$bookingDetails['ref_code']."'"));

                    if(isset($bookingDetails['ref_code']) &&$bookingDetails['ref_code']!=''){

                        $commitionAmmount = 50;
                        $typeDrirect = 1;
                        $derectComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `client_commition`, `status`) VALUES ('".$agentDSQl['id']."','".$propId."','".$bookingDetails['id']."','".$commitionAmmount."','0')";
                        mysqli_query($link, $derectComition);

                        if(isset($agentDSQl['agent_id']) && $agentDSQl['agent_id']==0 && $agentDSQl['type'] == 2)
                        {

                        }
                        else
                        {
                            $commitionAmmount = 15;
                            $typeDrirect = 2;
                            $derectComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `agent_commition`, `status`) VALUES ('".$agentDSQl['agent_id']."','".$propId."','".$bookingDetails['id']."','".$commitionAmmount."','0')";
                            mysqli_query($link, $derectComition);
                        }
                    }

                    if(isset($userDetails['agent_id']) && $userDetails['agent_id']!=''){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentReferedComition = "UPDATE `estejmam_agent_commition` SET `reffered_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentReferedComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `reffered_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentReferedComition);
                    }

                    /*if(isset($userDetails['agent_id']) && $userDetails['agent_id']!='' && $userDetails['type'] == 2){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentComition = "UPDATE `estejmam_agent_commition` SET `reffered_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `reffered_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentComition);
                    } */
                }else{
                    $propDetails = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id` = '".$propId."'"));
                    $userSQL = mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id` = '".$bookingDetails['uploder_user_id']."'");
                    $userDetails = mysqli_fetch_array($userSQL);

                    if(isset($userDetails['agent_id']) && $userDetails['agent_id']!=''){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentReferedComition = "UPDATE `estejmam_agent_commition` SET `reffered_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentReferedComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `reffered_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentReferedComition);
                    }

                    if(isset($userDetails['agent_id']) && $userDetails['agent_id']!='' && $userDetails['type'] == 2){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentComition = "UPDATE `estejmam_agent_commition` SET `agent_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `agent_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentComition);
                    }
                }
                //----------  Agent Onner Commition End -----------//

        echo json_encode($data);
        acceptedMail();


    die();
                        } else{ 	     $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();    }

		} catch (\Stripe\Error\Card $e) {
		     $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();
		} catch (\Stripe\Error\ApiConnection $e) {
		     $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();
		} catch (\Stripe\Error\InvalidRequest $e) {
		     $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();
		} catch (\Stripe\Error\Api $e) {
		     $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();
		} catch (\Stripe\Error\Base $e) {
		    $data['ack'] = 0;
        $data['res'] = " Error!! ";
         echo json_encode($data);
    die();
		}
                }
                else
                {
                           $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 1 where `id`='" . $bkngid . "'");
                $data['ack'] = 1;
                $data['res'] = " Booking is Successfully accepted ";
                $sqlBooking = "SELECT * from `estejmam_booking` WHERE `id`='".$id."' AND `status` = '1' ";
                $noofBooking = mysqli_num_rows(mysqli_query($link, $sqlBooking));

                //----------  Agent Onner Commition Start -----------//
                    $ref_code = $bookingDetails['ref_code'];
                    $propDetails = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id` = '".$propId."'"));
                    $userSQL = mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id` = '".$bookingDetails['uploder_user_id']."'");
                    $userDetails = mysqli_fetch_array($userSQL);
                    $agentDSQl = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `client_code` = '".$bookingDetails['ref_code']."'"));

                    if($bookingDetails['ref_code']!=''){

                        $commitionAmmount = 50;
                        $typeDrirect = 1;
                        $derectComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `client_commition`, `status`) VALUES ('".$agentDSQl['id']."','".$propId."','".$bookingDetails['id']."','".$commitionAmmount."','0')";
                        mysqli_query($link, $derectComition);
                        if(isset($agentDSQl['agent_id']) && $agentDSQl['agent_id']==0 && $agentDSQl['type'] == 2)
                        {

                        }
                        else
                        {
                             $commitionAmmount = 15;
                        $typeDrirect = 2;
                        $derectComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `agent_commition`, `status`) VALUES ('".$agentDSQl['id']."','".$propId."','".$bookingDetails['id']."','".$commitionAmmount."','0')";
                        mysqli_query($link, $derectComition);
                        }
                    }

                    if($userDetails['agent_id']!=''){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentReferedComition = "UPDATE `estejmam_agent_commition` SET `client_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentReferedComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `client_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentReferedComition);
                    }

                    if($userDetails['agent_id']!='' && $userDetails['type'] == 2){
                        $typeAgent = 2;
                        $ammount = 15;

                        $findQuery = "SELECT * FROM `estejmam_agent_commition` WHERE `agent_id` = '". $userDetails['agent_id'] ."' AND `booking_id` = '". $bookingDetails['id'] ."'";
                        $noofCommition = mysqli_num_rows(mysqli_query($link, $findQuery));
                        if($noofCommition>0){
                            $agentComition = "UPDATE `estejmam_agent_commition` SET `agent_commition`='".$ammount."' WHERE `agent_id` = '".$userDetails['agent_id']."' AND `booking_id` = '".$bookingDetails['id']."'";
                        }else{
                            $agentComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `agent_commition`, `status`) VALUES ('".$userDetails['agent_id']."','".$propId."','".$bookingDetails['id']."','".$ammount."','0')";
                        }

                        mysqli_query($link, $agentComition);
                    }

                //----------  Agent Onner Commition End -----------//

               acceptedMail();

                }

                // acceptedSMS($landloardPhone,$clintPhone,$adminPhone);

            }else {
                $data['ack'] = 0;
                $data['res'] = " Sorry, This Date Range is Booked ";
            }
        }
    }else {
        $data['ack'] = 0;
        $data['res'] = " Error!! ";
    }

    echo json_encode($data);
    die();
}


function cancelBooking(){
    $data = array();
    $id = $_POST['bookingID'];
    $sql = "select * from estejmam_booking where `id`=".$id;
    $query = mysqli_query($link, $sql);
    $bookingDetails = mysqli_fetch_array($query);
    $bkngid = $_POST['bookingID'];

    if($bookingDetails['status']==2){

        $data['ack'] = 0;
        $data['res'] = " Booking is Already Canceled ";

    }else {


        if($bookingDetails['payment_type']=='PP'){

           $refundData = paypalRefund($bookingDetails['transaction_id']);

               if($refundData['ACK']=='Success'){
                    $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 2 where `id`='" . $bkngid . "'");
                    $data['ack'] = 1;
                    $data['res'] = " Booking is Successfully Canceled ";

                    //----------  Agent Onner Commition Delete Start -----------//

                       $bookingID = $bookingDetails['transaction_id'];
                       $deleteSql = "DELETE FROM `estejmam_agent_commition` WHERE `booking_id` = '".$bookingID."'";
                       mysqli_query($link, $deleteSql);

                    //----------  Agent Onner Commition Delete End -----------//

               }else {
                    $data['ack'] = 0;
                    $data['res'] = "PayPal Refund is Not Done Successfully ";
               }
        }

        if($bookingDetails['payment_type']=='BT'){
            $status = braintreeRefund($bookingDetails['transaction_id']);

            if($status==1){
                    $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 2 where `id`='" . $bkngid . "'");
                    $data['ack'] = 1;
                    $data['res'] = " Booking is Successfully Canceled ";

                    //----------  Agent Onner Commition Delete Start -----------//

                       $bookingID = $bookingDetails['transaction_id'];
                       $deleteSql = "DELETE FROM `estejmam_agent_commition` WHERE `booking_id` = '".$bookingID."'";
                       mysqli_query($link, $deleteSql);

                    //----------  Agent Onner Commition Delete End -----------//

                    canceledMail();
                    // canceledSMS($landloardPhone,$clintPhone,$adminPhone);

            }else {
                $data['ack'] = 0;
                $data['res'] = "Braintree Refund is Not Done Successfully ";
            }

        }
          if($bookingDetails['payment_type']=='stripe'){
            $status = stripeRefund($bookingDetails['refurd_id']);

            if($status->status=='succeeded'){
                    $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 2,`refunded_id`='".$status->id."' where `id`='" . $bkngid . "'");
                    $data['ack'] = 1;
                    $data['res'] = " Booking is Successfully Canceled ";

                    //----------  Agent Onner Commition Delete Start -----------//

                       $bookingID = $bookingDetails['transaction_id'];
                       $deleteSql = "DELETE FROM `estejmam_agent_commition` WHERE `booking_id` = '".$bookingID."'";
                       mysqli_query($link, $deleteSql);

                    //----------  Agent Onner Commition Delete End -----------//

                    canceledMail();
                    // canceledSMS($landloardPhone,$clintPhone,$adminPhone);

            }else {
                $data['ack'] = 0;
                $data['res'] = "Stripe Refund is Not Done Successfully ";
            }

        }
    }

    echo json_encode($data); exit;
}


function disputeBooking(){
    $data = array();
    $id = $_POST['bookingID'];
    $sql = "select * from estejmam_booking where `id`=".$id;
    $query = mysqli_query($link, $sql);
    $bookingDetails = mysqli_fetch_array($query);
    $bkngid = $_POST['bookingID'];

    if($bookingDetails['status']==3){

        $data['ack'] = 0;
        $data['res'] = " Booking is Already Under Dispute ";

        //----------  Agent Onner Commition Delete Start -----------//

           $bookingID = $bookingDetails['transaction_id'];
           $deleteSql = "DELETE FROM `estejmam_agent_commition` WHERE `booking_id` = '".$bookingID."'";
           mysqli_query($link, $deleteSql);

        //----------  Agent Onner Commition Delete End -----------//

    }else {

        $sql2 = mysqli_query($link, "update `estejmam_booking` set `status`= 3 where `id`='" . $bkngid . "'");
        $data['ack'] = 1;
        $data['res'] = " Booking is Successfully Put Under Dispute ";

        disputeMail();
        // disputedSMS($landloardPhone,$clintPhone,$adminPhone);

    }

    echo json_encode($data); exit;
}


// ------------- PayPal Refund Function Start -------------//

// Function to convert NTP string to an array
function NVPToArray($NVPString) {
    $proArray = array();
    while (strlen($NVPString)) {
        // name
        $keypos = strpos($NVPString, '=');
        $keyval = substr($NVPString, 0, $keypos);
        // value
        $valuepos = strpos($NVPString, '&') ? strpos($NVPString, '&') : strlen($NVPString);
        $valval = substr($NVPString, $keypos + 1, $valuepos - $keypos - 1);
        // decoding the respose
        $proArray[$keyval] = urldecode($valval);
        $NVPString = substr($NVPString, $valuepos + 1, strlen($NVPString));
    }
    return $proArray;
}



function paypalRefund($tnx_id){

    $adminSetting = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_tbladmin` where `id`='1'"));

    $data = array(
        'USER'=>$adminSetting['paypal_user'],
        'PWD'=>$adminSetting['paypal_password'],
        'SIGNATURE'=>$adminSetting['paypal_signeture'],
        'METHOD'=>'RefundTransaction',
        'VERSION'=>'94',
        'TRANSACTIONID'=>$tnx_id,
        'REFUNDTYPE'=>'Full'
    );

    $query = http_build_query($data);

    $tuCurl = curl_init();
    curl_setopt($tuCurl, CURLOPT_VERBOSE, 1);
    curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($tuCurl, CURLOPT_TIMEOUT, 30);
    curl_setopt($tuCurl, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
    curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($tuCurl, CURLOPT_POST, 1);
    curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $query);

    $tuData = curl_exec($tuCurl);
    curl_close($tuCurl);

    $result_array = NVPToArray($tuData);

    return $result_array;
}

// ------------- PayPal Refund Function End -------------//




// ------------- Braintree Refund Function start ---------//

function braintreeRefund($tnx_id){

    $id =$tnx_id;
    $sqlRefund = "select * from estejmam_booking where `transaction_id`=".$tnx_id;
    $queryRefund = mysqli_query($link, $sqlRefund);
    $bookRefund = mysqli_fetch_array($queryRefund);

    $transaction = Braintree_Transaction::refund($bookRefund['transaction_id'],$bookRefund['total_price']);

    if($transaction->success){
        $refundStatus = 1;
    }else {
        $refundStatus = 0;
    }

    return $refundStatus;
}
 function stripeRefund($tnx_id)
 {
     $id =$tnx_id;
    $sqlRefund = "select * from estejmam_booking where `refurd_id`=".$tnx_id;
    $queryRefund = mysqli_query($link, $sqlRefund);
    $bookRefund = mysqli_fetch_array($queryRefund);
       $url = 'https://api.stripe.com/v1/refunds';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' .STRIPE_PRIVATE_KEY));
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'charge=' .$tnx_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data_all = curl_exec($ch);
            curl_close($ch);
            $charge= json_decode($data_all);
            return $charge;


 }
// ------------- Braintree Refund Function End   ---------//


// ------------- Accepted Mail function Start ------------//

function acceptedMail(){

    $adminSetting   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_tbladmin` where `id`='1'"));
    $all_details    = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_booking` where `id`='" . $_POST['bookingID'] . "'"));
    $prop_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_main_property` where `id`='" . $all_details->prop_id . "'"));
    $user_details   = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $prop_details->user_id . "'"));

    $Subject        = "Roomarate - Booking  has been Accepted";
    $admin_text     = "<p><span> A Booking is Accepted </span></p><p><span> Here is the details </span></p>";
    $landloard_text = "<p><span> One of Yor Property Booking is Accepted By Admin </span></p><p><span> Here is the details </span></p>";
    $customer_text  = "<p><span> One of Yor Booking is Accepted By Admin </span></p><p><span> Here is the details </span></p>";

    adminMail1($adminSetting->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$admin_text,$Subject,$_POST['bookingID']);

    $userNameMail = '';
    $userEmail = '';
    $userPhone = '';

    if(!empty($user_details)){
        $userEmail = $user_details['email'];
        $userPhone = $user_details['phone'];
        $userNameMail = $user_details['fname'].' '.$user_details['lname'];
    }

    landloardMail($userEmail,$userNameMail,$all_details->firstname,$all_details->email,$all_details->telephone,$all_details->nationality,$all_details->gender,$all_details->dob,$Subject);

    $emailTemplate1 = mysqli_query($link, "SELECT * FROM estejmam_team LEFT JOIN estejmam_user ON estejmam_team.agent_id = estejmam_user.id WHERE `template_id`=7 ");
    while($lTeam = mysqli_fetch_array($emailTemplate1))
    {
       if(!empty($lTeam)){
            landloardMail($lTeam['email'],$userNameMail,$all_details->firstname,$all_details->email,$all_details->telephone,$all_details->nationality,$all_details->gender,$all_details->dob,$Subject);
       }
    }

    $propAddress = $prop_details->street_addr;
    customerMail($all_details->email,$all_details->firstname,$prop_details->id,$all_details->id,$all_details->start_date,$all_details->end_date,$propAddress,$userNameMail,$userPhone,$userEmail,$Subject);

    $emailTemplate2 = mysqli_query($link, "SELECT * FROM estejmam_team LEFT JOIN estejmam_user ON estejmam_team.agent_id = estejmam_user.id WHERE `template_id`=8 ");
    while($tTeam = mysqli_fetch_array($emailTemplate2))
    {
        if(!empty($tTeam)){
            customerMail($tTeam['email'],$all_details->firstname,$prop_details->id,$all_details->id,$all_details->start_date,$all_details->end_date,$propAddress,$userNameMail,$userPhone,$userEmail,$Subject);
        }
    }
    // ---------------- SMS Notification Start ---------------//
        $userNameSms = $userNameMail;

        $emailTemplateL = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id`=7 "));
        $lsms = str_replace(
            array(
                '[LANDLORD]',
                '[LANDLORDEMAIL]'
                ),
            array(
                $userNameSms,
                $userEmail
                ),
            strip_tags($emailTemplateL['sms'])
        );

        $emailTemplateT = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id`=8 "));

        $tsms = str_replace(
            array(
                '[TENANT]'
                ),
            array(
                $all_details->firstname
                ),
            strip_tags($emailTemplateT['sms'])
        );

        $numberLists = array(
            $adminSetting->phone_no => 'A Booking is Accepted.Here is the details.Property Name :'. $prop_details->name.',Property Address :'.$prop_details->street_addr,
            $all_details->telephone => $tsms,
            $userPhone => $lsms

        );

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

                    foreach ($numberLists as $key => $value) {
                        $client->account->messages->create(array(
                            'To' => $key,
                            'From' => "+15807012787",
                            'Body' => str_replace('&nbsp;',' ',$value)
                        ));
                    }

                //----------- SMS TO USER END -------------//
            } catch (Exception $e) {
                $data['msg'] = $e->getMessage();
            }

    // ---------------- SMS Notification End -----------------//



}

function canceledMail(){

    $adminSetting   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_tbladmin` where `id`='1'"));
    $all_details    = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_booking` where `id`='" . $_POST['bookingID'] . "'"));
    $prop_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_main_property` where `id`='" . $all_details->prop_id . "'"));
    $user_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $prop_details->user_id . "'"));

    $Subject        = "Roomarate - Booking  has been Canceled";
    $admin_text     = "<p><span> A Booking is Canceled </span></p><p><span> Here is the details </span></p>";
    $landloard_text = "<p><span> One of Yor Property Booking is Canceled By Admin </span></p><p><span> Here is the details </span></p>";
    $customer_text  = "<p><span> One of Yor Booking is Canceled By Admin, You will get your Refund as soon as possible </span></p><p><span> Here is the details </span></p>";

    // ---------------- SMS Notification Start ---------------//

        $numberLists = array(
            $adminSetting->phone_no => 'A Booking is Canceled.Here is the details.Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr,
            $user_details->phone => 'One of Yor Property Booking is Canceled By Admin.Here is the details,Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr,
            $all_details->phone => 'One of Yor Booking is Canceled By Admin, You will get your Refund as soon as possible.Here is the details,Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr
        );


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

                    foreach ($numberLists as $key => $value) {
                        $client->account->messages->create(array(
                            'To' => $key,
                            'From' => "+15807012787",
                            'Body' => $value
                        ));
                    }

                //----------- SMS TO USER END -------------//

            } catch (Exception $e) {
                $data['msg'] = $e->getMessage();
            }

    // ---------------- SMS Notification End -----------------//

    adminMail($adminSetting->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$admin_text,$Subject);
    landloardMail($user_details->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$landloard_text,$Subject);
    customerMail($all_details->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$admin_text,$Subject);

}

function disputeMail(){

    $adminSetting   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_tbladmin` where `id`='1'"));
    $all_details    = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_booking` where `id`='" . $_POST['bookingID'] . "'"));
    $prop_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_main_property` where `id`='" . $all_details->prop_id . "'"));
    $user_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $prop_details->user_id . "'"));

    $Subject        = "Roomarate - Booking  has been put Under Dispute";
    $admin_text     = "<p><span> A Booking is Put Under dispute </span></p><p><span> Here is the details </span></p>";
    $landloard_text = "<p><span> One of Yor Property Booking is Put Under Dispute By Admin </span></p><p><span> Here is the details </span></p>";
    $customer_text  = "<p><span> One of Yor Booking is Put Under Dispute By Admin </span></p><p><span> Here is the details </span></p>";

    // ---------------- SMS Notification Start ---------------//

        $numberLists = array(
            $adminSetting->phone_no => 'A Booking is Put Under dispute.Here is the details.Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr,
            $user_details->phone => 'One of Yor Property Booking is Put Under Dispute By Admin.Here is the details,Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr,
            $all_details->phone => 'One of Yor Booking is Put Under Dispute By Admin, You will get your Refund as soon as possible.Here is the details,Property Name : '.$prop_details->name.',Property Address : '.$prop_details->street_addr
        );

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

                    foreach ($numberLists as $key => $value) {
                        $client->account->messages->create(array(
                            'To' => $key,
                            'From' => "+15807012787",
                            'Body' => $value
                        ));
                    }

                //----------- SMS TO USER END -------------//

            } catch (Exception $e) {
                $data['msg'] = $e->getMessage();
            }

    // ---------------- SMS Notification End -----------------//

    adminMail($adminSetting->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$admin_text,$Subject);
    landloardMail($user_details->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$landloard_text,$Subject);
    customerMail($all_details->email,$prop_details->name,$prop_details->street_addr,$all_details->start_date,$all_details->end_date,$admin_text,$Subject);

}
// ------------- Accepted Mail function End ------------//

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

function adminMail1($email,$property_name,$property_address,$move_in,$move_out,$text,$bookingid){

$email;
$Subject = "Roomarate - Booking  has been accepted";

$detail4 = "";

$detail4 .= $text;
$detail4 .= "<p><span>Property Name: ".$property_name." </span></p>";
$detail4 .= "<p><span>Property Address: ".$property_address." </span></p>";
$detail4 .= "<p><span>Move In: ".$move_in." </span></p>";
$detail4 .= "<p><span>Move Out: ".$move_out." </span></p>";
$detail4 .= "<p><span>Booking Id: ".$bookingid." </span></p>";


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

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id`=7 "));

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



function customerMail($email,$tname,$property_id,$booking_id,$move_in,$move_out,$propAddress,$lname,$lphone,$lemail,$Subject){

	 $prop_details   = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_main_property` where `id`='" .$property_id. "'"));
$emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id`=8"));

$detail4 = str_replace(
            array(
                '[TENANT]',
                '[PROPERTYID]',
                '[BOOKINGID]',
                '[MOVEIN]',
                '[MOVEOUT]',
                '[PROPERTYADDRESS]',
                '[LANDLORDPOLICIES]',
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
                $propAddress,
                $prop_details->landlord_policies,
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






