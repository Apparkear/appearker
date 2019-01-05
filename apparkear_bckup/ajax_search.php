<?php
ob_start();
session_start();
include 'administrator/includes/config.php';
//include 'functions/functions.php';
define('PAGE_PER_NO', 4);


// Start Currency convertion//

$getSymbolNRate = curencyrateAndSymbol();

$convertionRate = $getSymbolNRate['rate'];
$symbol = $getSymbolNRate['symbol'];
$countryCode = $getSymbolNRate['country'];

// End Currency convertion //



$address = $_REQUEST['place']; // Google HQ
$prepAddr = str_replace(' ', '+', $address);
$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
$output = json_decode($geocode);
// var_dump($output);
$latitude = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;


if ($_REQUEST['place'] != '') {
    $lat = $latitude;
    $lng = $longitude;
} else {
    $lat = $_REQUEST['lat'];
    $lng = $_REQUEST['lng'];
}

function distance($lat1, $lng1, $lat2, $lng2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "M") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

if (isset($_POST['pageId']) && !empty($_POST['pageId'])) {
    $id = $_POST['pageId'];
} else {
    $id = '0';
}
$pageLimit = PAGE_PER_NO * $id;


//$unit = 'K';
//$distance = distance($ipplat, $ipplng, $lat, $lng, $unit);
$distance = 50;
?>

<div  id="myList">

    <?php
    $start_date = $_REQUEST['check_in'];
    $end_date = $_REQUEST['check_out'];
    $bathrooms = $_REQUEST['bathrooms'];
    $noofbeds = $_REQUEST['noofbeds'];
    $minimumstay = $_REQUEST['minimumstay'];
    
    $livingroom = '';
    if(isset($_REQUEST['livingroom'])){
        $livingroom = $_REQUEST['livingroom'];
    }

    $bedrooms = $_REQUEST['bedrooms'];
    // $bathrooms = $_REQUEST['bathrooms'];
    $beds = $_REQUEST['beds'];
    $guest = $_REQUEST['guest'];
    $bedtype = $_REQUEST['bedtype'];

    $only_for = implode(',', $_REQUEST['only_for']);
    $suitable_for = $_REQUEST['suitable_for'];
    $features = $_REQUEST['features'];
    $bills = $_REQUEST['bills'];

    $max_price = intval($_REQUEST['max_price']);
    if ($max_price < 5000) {
        $max_price = intval($_REQUEST['max_price']);
    } else {
        $max_price = 500000;
    }
    $max_price=round($max_price/$convertionRate);
    $min_price = intval($_REQUEST['min_price']);
    $min_price=round($min_price/$convertionRate);

    $room_type = $_REQUEST['room_type'];

    $proptype = $_REQUEST['proptype'];
    $ameniteis = $_REQUEST['ameniteis'];
    $language = $_REQUEST['language'];

    $instant = $_REQUEST['instant'];
    $cancellation_policy = $_REQUEST['cancellation_policy'];


    $allroomtype = implode("','", $room_type);

    $allproptype = implode("','", $proptype);

    $allameniteis = implode(',', $ameniteis);




    $alllanguage = mysql_query("select * from `estejmam_language` where 1");
    while ($fetchlanguages = mysql_fetch_array($alllanguage)) {
        $alllanh[] = $fetchlanguages['language_name'];
    }



    $chechbooking = mysql_query("select * from `estejmam_booking` where `start_date`>='" . $start_date . "' and `end_date`<='" . $end_date . "' and `status`=1");
    while ($fetch = mysql_fetch_array($chechbooking)) {
        $prop_id[] = $fetch['prop_id'];
    }

    $final_id = implode(',', array_unique($prop_id));

    if ($final_id == '') {
        $final_id = "'" . "'";
    } else {
        $final_id = $final_id;
    }




    $allaminities = mysql_query("select * from `estejmam_amenities` where 1");
    while ($fetchaminities = mysql_fetch_array($allaminities)) {
        $allamini[] = $fetchaminities['name'];
    }

    if ($lat != '' && $lng != '') {
        $sql = "SELECT *,lat,lng,( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians(lat) ) * cos( radians(lng) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin(radians(lat)) ) ) AS distance FROM `estejmam_main_property` where CURDATE() not between startblockdate and endblockdate HAVING distance < " . $distance . "";
    } else {
        $sql = "select * from `estejmam_main_property` where CURDATE() not between startblockdate and endblockdate";
    }

    if ($_REQUEST['location_id'] != '') {
        $sql.= " and `city` = '" . $_REQUEST['location_id'] . "'";
    }

    if ($start_date != '' && $end_date != '') {

        $curdate = strtotime($start_date);
        $mydate = strtotime($end_date);

        $datediff = $mydate - $curdate;
        $days = floor($datediff / (60 * 60 * 24));
        if($curdate < $mydate)
        {
            $sql.= " AND ( (`ninimum_stay` < ".$days.") OR (`ninimum_stay` = ".$days.") ) AND ( (`maximum_stay` > ".$days.") OR (`maximum_stay` = ".$days.") ) ";
        } 

        $sql.= " AND `id` NOT IN($final_id)";
    }


    //$sql = "select * from `estejmam_main_property` where city='" . $_REQUEST['location_id'] . "'";

    if ($max_price != '' && $min_price != '') {
        $sql.= " AND `price` between '" . $min_price . "' and '" . $max_price . "'";
    }

    

    if ($proptype != '') {
        $sql.= " AND `prop_type` IN('$allproptype')";
    }


    if ($bedrooms != '') {
        if ($bedrooms == 0) {
            $sql.= " AND `bedrooms` >= '4'";
        } else {
            $sql.= " AND `bedrooms` = '" . $bedrooms . "'";
        }
    }

    if ($bathrooms != '') {
        if ($bathrooms == 0) {
            $sql.= " AND `bathrooms` >= '4'";
        } else {
            $sql.= " AND `bathrooms` = '" . $bathrooms . "'";
        }
    }

    if ($livingroom != '') {
            
            $sql.= " AND `with_living_room` = '" . $livingroom . "'";
    
    }

    if ($noofbeds != '') {
            
            $sql.= " AND `beds` = '" . $noofbeds . "'";
    
    }

    if ($minimumstay != '') {
            
            $sql.= " AND `ninimum_stay` = '" . $minimumstay . "'";
    
    }


    if ($bedtype != '') {
        $sql.= " AND `bed_type` = '" . $bedtype . "'";
    }


    if ($only_for != '') {
        $sql.= " AND `gender_type` = '".$only_for."'";
    }



    if (count($suitable_for) > 0) {
        $sql.= " AND (";
        foreach ($suitable_for as $key1 => $amini1) {

            if ($key1 == (count($suitable_for) - 1)) {
                $sql.= " (FIND_IN_SET ('$amini1',sutable_for)) ";
            } else {
                $sql.= " (FIND_IN_SET ('$amini1',sutable_for)) AND ";
            }
        }
        $sql.= " )";
    }



    if (count($features) > 0) {
        $sql.= " AND (";
        foreach ($features as $key2 => $amini2) {

            if ($key2 == (count($features) - 1)) {
                $sql.= " (FIND_IN_SET ('$amini2',apartment_feature_id)) ";
            } else {
                $sql.= " (FIND_IN_SET ('$amini2',apartment_feature_id)) AND ";
            }
        }
        $sql.= " )";
    }



    if (count($bills) > 0) {
        $sql.= " AND (";
        foreach ($bills as $key3 => $amini3) {

            if ($key3 == (count($bills) - 1)) {
                $sql.= " (FIND_IN_SET ('$amini3',bills_include_id)) ";
            } else {
                $sql.= " (FIND_IN_SET ('$amini3',bills_include_id)) AND ";
            }
        }
        $sql.= " )";
    }



    // $sql.=" And `status`='1' order by `distance` ASC";
    $sql.=" And `status`='1'";
    // $sql.=" And `status`='1' order by `id` DESC limit ".$pageLimit.",".PAGE_PER_NO;
    // echo $sql;
    // echo $sql; exit;
    // echo "$sql";
    $property_list = mysql_query($sql);
    $num = mysql_num_rows($property_list);
    if ($num > 0) {
        while ($row = mysql_fetch_object($property_list)) {

            // $tubeIMG = SITE_URL .'images/tube.png';
            // $railIMG = SITE_URL .'images/lover.png';

            // $rateJson = file_get_contents('http://transportapi.com/v3/uk/tube/stations/near.json?lon='.$row->lng.'&lat='.$row->lat.'&app_id=73cef60f&app_key=c7944e87254dd188f418d19f7de976b6');
            // $data1 = json_decode($rateJson);

            // $rateJson2 = file_get_contents('http://transportapi.com/v3/uk/train/stations/near.json?lon='.$row->lng.'&lat='.$row->lat.'&app_id=73cef60f&app_key=c7944e87254dd188f418d19f7de976b6');
            // $data2 = json_decode($rateJson2);

                $html = '<ul class="area-transport">';
                for ($i=0;$i<1;$i++) { 
                    $tubeDetails = $data1->stations[$i];
                    $lineArray = $tubeDetails->lines;
                    if(in_array('dlr',$lineArray)){
                        $tubeIMG = SITE_URL .'images/dlr.png';
                    }else{
                        $tubeIMG = SITE_URL .'images/tube.png';
                    }
                    $distanceTube = $tubeDetails->distance/1583;
                    $html .="<li><b><img src='".$tubeIMG."'></b><p>".$tubeDetails->name."<span> ( ".number_format($distanceTube,1)." miles )</span></p></li>";
                }

                for ($j=0;$j<1;$j++) { 
                    $tubeDetails = $data2->stations[$j];
                    $distanceTube = $tubeDetails->distance/1583;
                    $tubeDetails2 = $data2->stations[$j];
                    $distanceTube2 = $tubeDetails2->distance/1583;
                    $html .="<li><b><img src='".$railIMG."'></b><p>".$tubeDetails->name."<span> ( ".number_format($distanceTube2,1)." miles )</span></p></li>";
                }
                $html.='</ul>';

            $property_type = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_property_type` WHERE `id`='$row->prop_type'"));
            $user_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` WHERE `id` = '$row->user_id'"));
            $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id` = '$row->id' LIMIT 1"));
            $image = $image_details->image;

            if ($user_details->image != '') {
                $author_iamge = "upload/userimages/" . $user_details->image;
            } else {
                $author_iamge = "upload/no.png";
            }
            $country = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_countries` WHERE `id`='$row->country'"));

            $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='$row->id' LIMIT 3"));
            //$image = $image_details->image;

            if ($image_details->image != '') {
                $image = "upload/property/" . $image_details->image;
            } else {
                $image = "upload/noImageFound.jpg";
            }

                $myHTML = '';
              
              $myHTML.="<div class='marker search-list-box' id='map_".$row->id."'  onmouseleave='removeBounce(".$row->id.")'  onmouseover='toggleBounce(".$row->id.")' ><div id='carousel-example-generic-".$row->id."' class='carousel slide mapcls' data-ride='carousel'>
                         <ol class='carousel-indicators'><li data-target='#carousel-example-generic-".$row->id."' data-slide-to='0' class='active'></li>
                         <li data-target='#carousel-example-generic-".$row->id."' data-slide-to='1'></li><li data-target='#carousel-example-generic-".$row->id."' data-slide-to='2'></li>
                         </ol><!-- Wrapper for slides --><div class='sendToDetails carousel-inner' data-check-in='".$start_date."' data-check-out='".$end_date."' data-slug='".$row->slug."' style='cursor: pointer;'  role='listbox'>";
                                               
                                            $sCount = 1; 
                                                $image = mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $row->id . "' LIMIT 5");
                                                while ($image_details = mysql_fetch_object($image)) {
                                                    $picture = "upload/property/" . $image_details->image;
                                                                  
                                            $myHTML .="<div class='item "; if($sCount == 1){ $myHTML .="active"; } 
                                            $myHTML .="'><img src='".$picture."' alt=''/><div class='rent-price-b'> <b>";
                                            
                                            if($countryCode!='GB'){
                                                $myHTML .= $symbol.' '.round($row->price*$convertionRate,0);
                                            } else{
                                                $myHTML .= $symbol.' '.$row->price;
                                            }       

                                            $myHTML .="</b>
                                                        <span>/".$row->durationtime."</span></div><div class='favorite-icon'>
                                                    </div></div>";
                                            $sCount++; }
                                            $myHTML .="<div class='category-slide-text-area'><h4> ".$row->name." </h4>";
                                                   
                                                        $ammi = mysql_query("select * from `estejmam_amenities` where `id` IN($row->amenities) order by `id` DESC limit 4");
                                                        while ($amenit = mysql_fetch_object($ammi)) {
                                                                // print_r($amenit->name); echo '<br>';
                                                               $amiImage = 'upload/amentiesimage/'.$amenit->img;
                                                               $myHTML .="<div class='icon-holder'><span><img src=".$amiImage." alt=''></span>".$amenit->name."</div>";
                                                        }
                                            
                                            $tubeSQL = "SELECT * FROM `estejmam_tubemap` WHERE `prop_id` = '".$row->id."' LIMIT 2 "; 
                                            $exeSQL = mysql_query($tubeSQL);
                                            $noofTube = mysql_num_rows($exeSQL);
                                            
                                            if($noofTube!=0){
                                            
                                            
                                            $myHTML .='<ul class="area-transport">';
                                                while ($tubeData = mysql_fetch_array($exeSQL)) { 
                                                    ?>
    <?php if(isset($tubeData['logo']) && $tubeData['logo']=='overground'){ $imgatube="<img src='images/lover.png' />";  }else if(isset($tubeData['logo']) && $tubeData['logo']=='underground'){ $imgatube="<img src='images/tube.png' />"; }else if(isset($tubeData['logo']) && $tubeData['logo']=='dlh'){ $imgatube="<img src='images/dlr.png' />";  }else if(isset($tubeData['logo']) && $tubeData['logo']=='rail'){ $imgatube="<img src='images/rail.png' />"; }

                                                    $myHTML .='<li><b>'.$imgatube.'</b><p>'.$tubeData['station_name'].'<span> ( '.$tubeData['distance'].' Distance )</span></p></li>';
                                                } 
                                            $myHTML .='</ul>';
                                            }            
                                                    
                                            $myHTML .="</div></div><!-- Controls --><a class='left carousel-control' href='#carousel-example-generic-".$row->id."' role='button' data-slide='prev'>
                                            <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span><span class='sr-only'>Previous</span></a>
                                          <a class='right carousel-control' href='#carousel-example-generic-".$row->id."' role='button' data-slide='next'>
                                            <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span><span class='sr-only'>Next</span>
                                          </a></div></div>";    

                 echo $myHTML;
                
            // $azawer = '';
            // $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($row->amenities) order by `id` DESC limit 4");
            // while ($amenities = mysql_fetch_object($amm)) {

            //     $amimage = "upload/amentiesimage/" . $amenities->img;

            //     $azawer.= "<div class='icon-holder'><span><img src=$amimage alt=''></span>$amenities->name</div>";
            // }
            ?>



            <?php
            // echo $mainlist = "<li id='map_$row->id' class='mapcls' onclick=\"location.href = 'details.php?name=$row->slug'\" style=\"cursor: pointer;\">" .
            // "<div class='product-image'>" .
            // "<img src= $image alt=''/>" .
            // "<div class='rent-price'>" .
            // "<b>$ $row->price </b>" .
            // "<span>month</span>" .
            // "</div>" .
            // "</div>" .
            // "<div class='product-info'>" .
            // "<h4>$row->name </h4>" .
            // $azawer .
            // "</div>" .
            // "</li>";
            ?>
            <?php
        }
    } else {
         if($days< 30)
                                        {
                                            $msg='Minimum 1 month booking';
                                        }
                                        else if($days< 60)
                                        {
                                            $msg='Maximum 2 months booking';
                                        }
                                        else if($days< 90)
                                        {
                                            $msg='Maximum 3 months booking';
                                        }
                                        else if($days > 90)
                                        {
                                            $msg='Maximum 3 months booking';
                                        }
                                        else
                                        {
                                            $msg='No Property Found';
                                        }
        echo $msg;
    }
    ?>
    
</div><script>
    $(document).ready(function () {

        size_li = $("#myList li").size();
        x = 4;
        $('#myList li:lt(' + x + ')').show();
        $('#loadMore').click(function () {
            x = (x + 4 <= size_li) ? x + 4 : size_li;
            $('#myList li:lt(' + x + ')').show();
        });
        $('#showLess').click(function () {
            x = (x - 4 < 1) ? 4 : x - 4;
            $('#myList li').not(':lt(' + x + ')').hide();
        });


    });
</script>!!!***
<?php
$marker = array();
mysql_data_seek($property_list, 0);
while ($result = mysql_fetch_object($property_list)) {
    $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id` = '$result->id' LIMIT 1"));
    $image = $image_details->image;



    $image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='$result->id' LIMIT 3"));
    $image = $image_details->image;


    $user_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` WHERE `id` = '$result->user_id'"));

    if ($user_details->image != '') {
        $author_iamge = $user_details->image;
    } else {
        $author_iamge = "upload/no.png";
    }
    $property_type = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_property_type` WHERE `id`='$result->prop_type'"));


    $marker[] = array('lat' => $result->lat,
        'lng' => $result->lng,
        'name' => $result->name . ' in ' . $countryname,
        'image' => $image,
        'id' => $result->id,
        'price' => ($countryCode!='GB') ? $symbol.' '.round($result->price*$convertionRate) : $symbol.' '.$result->price
    );
}
echo json_encode($marker);


//echo $all_data = $mainlist . '_' . $send_marker;
?>
!!!***
<?php echo $num ?>