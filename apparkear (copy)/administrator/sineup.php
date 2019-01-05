<?php
ob_start();
session_start();
include("administrator/includes/config.php");
/*$name=$_REQUEST['name'];
$password=$_REQUEST['password'];
$phone=$_REQUEST['phone'];*/
$sql="INSERT INTO `estejmam_user`(`fname`, `lname`, `email`,`phone`) VALUES ('satyajit','jana','nits.satyajit@gmail.com','7777777777')";
echo $sql;
//mysql_query($sql) 
echo "update successfull";
echo "hii";
?>