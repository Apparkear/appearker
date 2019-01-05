<?php
session_start();
include 'administrator/includes/config.php';

$data = array();
$user_id = $_SESSION["user_id"];
$user_type = $_REQUEST['user_type'];

$query = mysqli_query($link, "UPDATE `estejmam_user` SET `type`= '".$user_type."' WHERE  `id` = '" . $user_id . "'");
$_SESSION['user_type'] = $user_type;
$data['ack'] = 1;

echo json_encode($data);
exit;