<?php

define('SITE_URL', 'http://13.233.43.252/team4/apparkear/');
define('IMAGE_PATH', '/var/www/html/team4/apparkear/upload/user_image');

function getConnection() {

    $dbhost = "localhost";

    $dbuser = "root";

    $dbpass = "Host@123456";

    $dbname = "apparkear";

    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

?>