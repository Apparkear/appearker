<?php

ob_start();
session_start();
include 'administrator/includes/config.php';

?>
<?php

$user_id = $_SESSION['user_id'];

if($user_id == ""){
    header("Location:index.php");
}

$rating = $_POST['rating'];
$given_to_whom = $_POST['given_to_whom'];
$given_by = $_POST['given_by'];
$parking_id = $_POST['parking_id'];
$comments = $_POST['comments'];

$fields = array(
            'rating' => mysqli_real_escape_string($link, $rating),
            'user_id' => mysqli_real_escape_string($link, $given_to_whom),
            'given_by' => mysqli_real_escape_string($link, $given_by),
            'parking_id' => mysqli_real_escape_string($link, $parking_id),
            'comments' => mysqli_real_escape_string($link, $comments)
        );
$fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

$query_parking = "INSERT INTO `user_ratings` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
        
$rest = mysqli_query($link, $query_parking);
//echo mysqli_insert_id($link);exit;

header("Location: booking_history.php"); 
    exit();


?>