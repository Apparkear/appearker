<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
require_once "./PHPMailer/class.phpmailer.php";
require('Twilio.php');
?>
<?php
//print_r($_POST); exit;
//print_r($_REQUEST);exit;
$data =array();
if ($_REQUEST) {
    if (empty($_REQUEST['lat'])) {
        if(!empty($_REQUEST['location'])) {
            $address = $_REQUEST['location']; // Google HQ
            $url = "http://maps.google.com/maps/api/geocode/json?address=" . urlencode($address). "&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseJson = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($responseJson);
        }
    }else {
        $lat = $_REQUEST['lat'];
    }

    if (empty($_REQUEST['lon'])) {

    } else {
        $lng = $_REQUEST['lon'];
    }

    if ($lng != '' && $lat != '') {
        //echo "1 moi";
        $searchQuery = "SELECT *, (3959 * acos(cos(radians('" . $lat . "')) * cos(radians(lat)) * cos( radians(lon) - radians('" . $lng . "')) + sin(radians('" . $lat . "')) * sin(radians(lat)))) AS distance FROM `parking` LEFT JOIN `parking_images` on `parking`.`id` = `parking_images`.`parking_id` " . $where . " GROUP BY `parking`.`id` having distance < 100 ORDER BY distance ASC  LIMIT 0,10";
    } else {
        $searchQuery = "select * from `parking` " . $where . " order by `id` DESC limit 0,10";

    }
    $resultAll = mysqli_query($link, $searchQuery);
}else {
    $searchQuery = "select * from `parking` order by `id` DESC limit 0,10";
    $resultAll = mysqli_query($link, $searchQuery);
}
$html='';
if(!empty($resultAll)){
    while($row_parking = mysqli_fetch_object($resultAll)){
        $parking_id =  $row_parking->id;
        $parking_name = $row_parking->name;
        $parking_address = $row_parking->address;
        $parking_currency = $row_parking->currency;
        $parking_price = $row_parking->price;
        $parking_priceratetype = $row_parking->price_rate_type;
        $parking_distance = $row_parking->distance;
        
        $get_image = mysqli_fetch_object(mysqli_query("SELECT * FROM `parking_images` WHERE `parking_id`=$parking_id"));
        
        if ($row_parking->parking_image == '') {
            $img_parking = './upload/parking.jpg';
        } else {
            $img_parking = './upload/parking/' . $row_parking->parking_image;
        }
        $html .='<div class="row explore-sec border-bottom p-3 m-3">
                    <div class="col-md-3">
                        <img src="'.$img_parking.'">
                    </div>
                    <div class="col-md-7">
                        <h3>'.$parking_name.'</h3>
                        <h5>'.$parking_address.'</h5>
                        <h5>KM: '.number_format((float)$parking_distance, 2, '.', '').'</h5>
                        <p>25 reviews</p>
                        <a href="#" class="btn btn-primary">Car Park</a>
                    </div>
                    <div class="col-md-2 d-flex justify-content-between" style="flex-direction: column">
                        <div class="">
                            <a href="#"><i class="ion-checkmark-circled"></i></a>
                            <a href="#"><i class="ion-ios-heart-outline"></i></a>
                        </div>
                        <h5 class="mt-4 text-baseline">';
                        if($parking_currency == "usd"){ 
                        $html .='$';
                        }
                        $html .= $parking_price; 
                        if($parking_priceratetype == "per month"){
                        $html .='Month';
                        }
                        $html .='</h5>
                    </div>
                </div>';

    }
    
    $data['ack'] =1;
    $data['res'] = $html;
}else{
    $data['ack'] =0;
    $data['res'] = $html;
}
    



echo json_encode($data); exit;

?>