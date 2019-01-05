<?php
ob_start();
session_start();
include 'administrator/includes/config.php';

$make = $_POST['make'];
//echo "SELECT * FROM `makes` WHERE `name`='".$make."'";exit;
$get_make_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `makes` WHERE `name`='".$make."'"));

$make_id = $get_make_details->id; 

$get_model = mysqli_query($link,"SELECT * FROM `carmodels` WHERE `makes_id` = {$make_id}");
$html = "<option>Model</option>";
while($row_model = mysqli_fetch_object($get_model)){
   
   $html .= '<option value="'.$row_model->name.'"';
   if ($make_id == $row_model->id) { 
       $html .= 'selected';
   }
   $html .='>'.$row_model->name.'</option>';
   
    
}

 
 $data= $html;
 
 echo $data; exit;


?>
