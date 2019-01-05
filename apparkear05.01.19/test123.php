
<?php

// 	$latitude = "22.572645";
//   $longitude = "88.363892";
// $geolocation = $latitude.','.$longitude;
// $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false';
// $file_contents = file_get_contents($request);
// $json_decode = json_decode($file_contents);
// if(isset($json_decode->results[0])) {
//     $response = array();
//     foreach($json_decode->results[0]->address_components as $addressComponet) {
//         if(in_array('political', $addressComponet->types)) {
//                 $response[] = $addressComponet->long_name;
//         }
//     }
//
//     if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
//     if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; }
//     if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
//     if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
//     if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }
//
//     if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
//         echo "<br/>Address:: ".$first;
//         echo "<br/>City:: ".$second;
//         echo "<br/>State:: ".$fourth;
//         echo "<br/>Country:: ".$fifth;
//     }
//     else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
//         echo "<br/>Address:: ".$first;
//         echo "<br/>City:: ".$second;
//         echo "<br/>State:: ".$third;
//         echo "<br/>Country:: ".$fourth;
//     }
//     else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
//         echo "<br/>City:: ".$first;
//         echo "<br/>State:: ".$second;
//         echo "<br/>Country:: ".$third;
//     }
//     else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
//         echo "<br/>State:: ".$first;
//         echo "<br/>Country:: ".$second;
//     }
//     else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
//         echo "<br/>Country:: ".$first;
//     }
//   }

	$latitude = "22.572645";
  $longitude = "88.363892";

$geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false');
$output = json_decode($geocodeFromLatLong);

print_r($output);
$status = $output->status;
echo $address = ($status=="OK")?$output->results[1]->formatted_address:'';
?>
