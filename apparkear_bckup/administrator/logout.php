<?php 
session_start();
unset($_SESSION["username"]);
unset($_SESSION["admin_id"]);
unset($_SESSION["myy"]);
unset($_SESSION["admin_type"]);

//session_destroy();
header("location:index.php");
?>