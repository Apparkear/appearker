<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php 
//print_r($_POST);exit;
$booking_id = $_POST["booking_id"];
$booking = base64_encode($booking_id);
    $fields = array(
        'card_holder' => mysqli_real_escape_string($link, $_POST['holder_name']),
        'card_number' => mysqli_real_escape_string($link, $_POST['card_number']),
        'exp_month' => mysqli_real_escape_string($link, $_POST['exp_month']),
        'exp_year' => mysqli_real_escape_string($link, $_POST['exp_year']),
        'cvv' => mysqli_real_escape_string($link, $_POST['cvv']),
        'payment_type' => mysqli_real_escape_string($link, 'stripe')
    );
    
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
    $updateQuery = "UPDATE `estejmam_booking` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $booking_id) . "'"; 
    
    $is_update =  mysqli_query($link, $updateQuery); 
    //echo $is_update;exit;
    if($is_update == 1){
        
        $stripe_api_sk_key = "sk_test_5K401tpKS27cCLjkYe3LTXCv";
	$stripe_api_pk_key = "pk_test_avhCsvHAaou7xWu7SxVCzptC";
				
        $url = 'https://api.stripe.com/v1/tokens';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $stripe_api_sk_key));
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[number]=4242424242424242 &card[exp_month]=12&card[exp_year]=2019&card[cvc]=123');
	//curl_setopt($ch, CURLOPT_POSTFIELDS, 'card[number]='.$cardnumber.' &card[exp_month]='.$exp_month.'&card[exp_year]='.$exp_year.'&card[cvc]='.$cvv);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data_all = curl_exec($ch);
	$arr=json_decode($data_all);
       // print_r($arr);exit;
        
        if(!isset($arr->error)){
            $tokenID=$arr->id;
                if(isset($tokenID))
                {
                    $total_amount_stripe = round($_POST['price']); 
                    $currency ='usd';
                    $url = 'https://api.stripe.com/v1/charges';
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $stripe_api_sk_key));
                   // curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=' .$total_amount_stripe. '&currency='.$currency.'&source='.$tokenID.'&description= Payment for Purchase');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=' .$total_amount_stripe. '&currency='.$currency.'&source='.$tokenID.'&description= Payment for Purchase');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data_all = curl_exec($ch);

                    //print_r($data_all); echo "<pre>";exit;
                    curl_close($ch);
                    $charge_data = json_decode($data_all);
                    //print_r($charge_data);exit;
                        if($charge_data->paid==1)
                        {
                            $fields1 = array(
                                'transaction_id' => mysqli_real_escape_string($link, $charge_data->balance_transaction),
                                'status' => mysqli_real_escape_string($link, 1)
                                
                            );
                            
                            $fieldsList1 = array();
                            foreach ($fields1 as $field1 => $value1) {
                                $fieldsList1[] = '`' . $field1 . '`' . '=' . "'" . $value1 . "'";
                            }

                            
                            $updateQuery = "UPDATE `estejmam_booking` SET " . implode(', ', $fieldsList1)
                                . " WHERE `id` = '" . mysqli_real_escape_string($link, $booking_id) . "'";

                            $is_update_booking =  mysqli_query($link, $updateQuery);
                            //echo $is_update_booking;exit;

                            
                            header("Location: booking_success.php?gnikoob=$booking");
                        }else{

                            header("Location: booking_faliure.php?gnikoob=$booking");
                        }
                }
        }else{
            header("Location: booking_faliure.php?gnikoob=$booking");
        }
        
    }
    else{
        $encoded_bookig_id = base64_encode($booking_id);
        header("Location: booking_step_two.php?gnikrap=$encoded_bookig_id");
    }

?>