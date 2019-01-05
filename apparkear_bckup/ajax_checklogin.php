<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
 ?>
<?php
$id = $_POST['id'];

$data=array();
$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$id}")); 
$login = $get_user_details->is_loggedin;
if($login==1){
	$data['res']=1;
}else{
	$data['res']=0;
}

echo json_encode($data);
exit;
?>