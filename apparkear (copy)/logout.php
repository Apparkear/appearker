<?php
	session_start();
	include 'administrator/includes/config.php';
	$id=$_SESSION['user_id'];
	if(session_destroy())
	{
		$query = mysqli_query($link, "UPDATE `estejmam_user` SET `is_loggedin`= 0 WHERE  `id` = '" .$id. "'");
            $location = 'http://104.131.83.218/team4/apparkear/';
	header("Location: $location");
	}
?>