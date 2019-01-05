<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php //echo 1;exit;
//print_r($_POST);exit;
if(!empty($_POST['country_id'])) {
	$query =mysqli_query($link,"SELECT * FROM states WHERE country_id = '" . $_POST["country_id"] . "'");
?>
	<option value="">Select State</option>
<?php
     while($subcat1 = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $subcat1['id']; ?>"><?php echo $subcat1['name']; ?></option>
<?php
  //print_r($subcat1);
	}
}

if(!empty($_POST['state_id'])) {
	$query =mysqli_query($link,"SELECT * FROM cities WHERE state_id = '" . $_POST["state_id"] . "'");
?>
	<option value="">Select City</option>
<?php
     while($subcat = mysqli_fetch_array($query)){
?>
	<option value="<?php echo $subcat['id']; ?>"><?php echo $subcat['name']; ?></option>
<?php
  //print_r($subcat);
	}
}
?>