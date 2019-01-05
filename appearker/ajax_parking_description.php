<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php

//print_r($_POST);exit;
//$_SESSION['new_parking'] = 16;
 
$user_id = $_SESSION['user_id'];
$parking_id = $_SESSION['new_parking']; 

$name = $_POST['name'];
$description = $_POST['description'];
$rules = $_POST['rules'];
$accessibility = $_POST['accessibility'];


$amenities_array = $_POST['amenities'];
$amenities =""; 
$count = 0; 
$total = count($amenities_array);

foreach($amenities_array as $key=>$val){
    if($total-1 == $count){
        $amenities .= $val;
    }else{
        $amenities .= $val.",";
    }
    $count = $count+1;
}

//echo $amenities;exit;

$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if($user_id != ''){
    $fields = array(
        'user_id' => mysqli_real_escape_string($link, $user_id),
        'name' => mysqli_real_escape_string($link, $name),
        'description' => mysqli_real_escape_string($link, $description),
        'accessibility' => mysqli_real_escape_string($link, $accessibility),
        'rules'=> mysqli_real_escape_string($link, $rules),
        'amenities'=> mysqli_real_escape_string($link, $amenities)
    );
    
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    if($parking_id != ""){
        $query_parking = "UPDATE `parking` SET " . implode(', ', $fieldsList)
        ." WHERE `id` = '" . mysqli_real_escape_string($link, $parking_id) . "'"; 
    }else{
//        $query_parking = "INSERT INTO `parking` (`" . implode('`,`', array_keys($fields)) . "`)"
//            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
        
        header("Location: rent_parking_step3.php"); 
        exit();
        
    }
    $rest = mysqli_query($link, $query_parking);

    if ($_FILES['parking_images']['name'][0] != "") {
        
        $image_delete = mysqli_query($link, "DELETE FROM `parking_images` WHERE `parking_id`={$parking_id}");
        for($i=0; $i<count($_FILES['parking_images']['name']); $i++){
           
            if($_FILES['parking_images']['type'][$i] == "image/png" || $_FILES['parking_images']['type'][$i] == "image/jpeg" || $_FILES['parking_images']['type'][$i] == "image/jpeg"){
                $target_path = "./upload/parking/";
                $userfile_name = $_FILES['parking_images']['name'][$i];
                $userfile_tmp = $_FILES['parking_images']['tmp_name'][$i];
                $img_name = time().$userfile_name; 
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);
                $image_add = mysqli_query($link, "INSERT INTO `parking_images`(`parking_id`,`image`) VALUES(".$parking_id.",'".$img_name."')");
            }
        }
       
    }
    
    $_SESSION['three']=3;
    header("Location: rent_parking_step4.php"); 
    exit();
    
   // print_r($rest); exit;
}else{
    
    
    header("Location: index.php"); 
    exit();

}


?>