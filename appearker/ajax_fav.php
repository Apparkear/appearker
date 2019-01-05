<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

$parking_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
$today = date("Y-m-d H:i:s");
if($user_id != ""){
$fields = array(
            'prop_id' => mysqli_real_escape_string($link, $parking_id),
            'user_id' => mysqli_real_escape_string($link, $user_id),
            'date' => mysqli_real_escape_string($link, $today)
        );

$fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
$chek_fav = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_favourite_property` WHERE `prop_id`=$parking_id AND `user_id`=$user_id"));
    //print_r($chek_fav);exit;
   if($chek_fav != ""){
       $query_parking = "DELETE FROM `estejmam_favourite_property` WHERE `prop_id`=$parking_id AND `user_id`=$user_id"; 
       $rest = mysqli_query($link, $query_parking);
        $data['ack'] =2;
    }else{
    $query_parking = "INSERT INTO `estejmam_favourite_property` (`" . implode('`,`', array_keys($fields)) . "`)"
                . " VALUES ('" . implode("','", array_values($fields)) . "')"; 

            $rest = mysqli_query($link, $query_parking);

            $last_id = mysqli_insert_id($link);


            $data['ack'] =1;

    }

}else{
    $data['ack'] =0;
}

echo json_encode($data); exit;

?>