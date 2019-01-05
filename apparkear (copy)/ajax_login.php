<?php
session_start();
include 'administrator/includes/config.php';

$data = array();

$un = stripslashes(trim($_REQUEST['email_add']));
$pass = $_REQUEST['pass'];
$remember = $_REQUEST['remember'];

$sql = "SELECT * FROM `estejmam_user` WHERE `email`='$un' and `password` = md5('$pass')";
$rs = mysqli_query($link,$sql) or die(mysql_error());

if ($row = mysqli_fetch_object($rs)) {
    $_SESSION['login_username'] = $row->fname;
    //$_SESSION['landlord_id'] = $row->id;
    $_SESSION['user_id'] = $row->id;
    $_SESSION['user_type'] = $row->type;
    
    if($remember=='1' || $remember=='on')
    {
    $hour = time() + 3600 * 24 * 30;
    setcookie('email', $un, $hour);
    setcookie('password', $pass, $hour);
    }
    $query = mysqli_query($link, "UPDATE `estejmam_user` SET `is_loggedin`= 1 WHERE  `id` = '" .$row->id. "'");
    $data['ack'] = 1;
    $data['type'] = $row->type;
    $data['msg'] = 'Success';
} else {
    $data['ack'] = 0;
    $data['type'] = 2;
    $data['msg'] = 'Please chcek username or password';
}
echo json_encode($data);
exit;