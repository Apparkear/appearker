<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
?>


<?php

$address = $_REQUEST['place']; // Google HQ
$prepAddr = str_replace(' ', '+', $address);
$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
$output = json_decode($geocode);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;

echo $latitude . '@@' . $longitude;
?>