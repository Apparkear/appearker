
<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";

$distance = 50;

$newdate = date('Y-m-d');
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

            if ($response->status == 'OK') {
                $lat = $response->results[0]->geometry->location->lat;
                $lng = $response->results[0]->geometry->location->lng;
                echo $lat.'latlong...............'.$lng; exit;
            } else {
                echo $response->status;
                var_dump($response);
                // exit;
            }
        }

    } else {
        $lat = $_REQUEST['lat'];
    }

    if (empty($_REQUEST['lon'])) {

    } else {
        $lng = $_REQUEST['lon'];
    }
    // if(!empty($_REQUEST['month']) && !empty($_REQUEST['size']) && !empty($_REQUEST['location']) && !empty($_REQUEST['maxprice'])){
    //     $where = 'WHERE ';
    // }
    if(!empty($_REQUEST['month'])){
        $where = 'WHERE ';
    }elseif (!empty($_REQUEST['size'])) {
        $where = 'WHERE ';
    }elseif (!empty($_REQUEST['maxprice'])) {
        $where = 'WHERE ';
    }elseif (!empty($_REQUEST['geographical_zone'])) {
        $where = 'WHERE ';
    }elseif (!empty($_REQUEST['sdate']) && !empty($_REQUEST['edate'])) {
        $where = 'WHERE ';
    }


    if(!empty($_REQUEST['maxprice'])) {
        $minprice = $_REQUEST['minprice'];
        $maxprice = $_REQUEST['maxprice'];
        $where .= " `parking`.`price` BETWEEN '".$minprice. "' AND '".$maxprice."'  " ;
    }

    if (!empty($_REQUEST['sdate']) && !empty($_REQUEST['edate'])) {
        $startDate = $_REQUEST['sdate'];
        $endDate = $_REQUEST['edate'];
        $where .= " AND  `parking`.`available_start` <= '".$startDate. "' AND `parking`.`avaliable_end` >= '".$endDate."'" ;
    }

    if(!empty($_REQUEST['geographical_zone'])) {
        $where .= " AND `parking`.`geographical_zone` = '". $_REQUEST['geographical_zone']."'";
    }

    if(!empty($_REQUEST['month'])) {
        $duration = 30 * $_REQUEST['month'];
        $startDate = $_REQUEST['date'];
        $newdate = strtotime($duration .' day', strtotime($startDate));
        $endDate = date('Y-m-d', $newdate);
        $where .= " AND  `parking`.`available_start` <= '".$startDate. "' AND `parking`.`avaliable_end` >= '".$endDate."'" ;
    }

    if (!empty($_REQUEST['size'])) {
        $where .= " AND `parking`.`car_type` = '". $_REQUEST['size']."'";
    }

    if ($lng != '' && $lat != '') {
        //echo "1 moi";
        $searchQuery = "SELECT *, (3959 * acos(cos(radians('" . $lat . "')) * cos(radians(lat)) * cos( radians(lon) - radians('" . $lng . "')) + sin(radians('" . $lat . "')) * sin(radians(lat)))) AS distance FROM `parking` " . $where . " having distance < 100 ORDER BY distance ASC  LIMIT 0,20";
    } else {
        $searchQuery = "SELECT *  FROM `parking` ". $where ." ORDER BY `parking`.`id` DESC limit 0,20";

    }
    // print_r($_REQUEST);
    // echo $searchQuery;exit;
    $resultAll = mysqli_query($link, $searchQuery);
} else {
    $searchQuery = "SELECT * FROM `parking` ORDER BY `parking`.`id` DESC limit 0,20";
            
    $resultAll = mysqli_query($link, $searchQuery);
}
//while($row_parking = mysqli_fetch_object($resultAll)){
//    print_r($row_parking);
//}
//exit;
//echo $latitude."--".$longitude;exit;

?>
<?php //print_r($_REQUEST) ?>
<link rel="stylesheet" href="css/asRange.css">
<section class="container-fluid">
    <div class="message-body">
        <div class="row gray-bg">
            <div class="col-lg-6 pl-0 pr-0">
                <form action="search_list.php" id="searchConsole" method="get">
                <div class="search-res-top ">
                    <div class="search-res-area">
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <input type="text" class="form-control" placeholder="Search" name="location" aria-label="Search" id="autocomplete2"  autocomplete="off" value="<?php echo $_REQUEST['location']?>">
                                <input type="hidden" name="lat" id="lat" value="<?php echo $_REQUEST['lat'] ?>"/>
                                <input type="hidden" name="lon" id="lon" value="<?php echo $_REQUEST['lon'] ?>"/>
                            </div>

                            <div class="form-group col-lg-3">
                                <input type="text" name="date" class="form-control hasdatepicker" placeholder="Date" id="datetimesearch"  value="<?php echo $_REQUEST['date']; ?>">
                                <!-- <select class="form-control" name="type" id="type">
                                    <option value="">Initial Date</option>
                                    <option value="6">All</option>
                                </select> -->
                            </div>

                            <div class="form-group col-lg-3">
                                <select class="form-control" name="month" id="month">
                                    <option value="">Month</option>
                                    <option value="1" <?php if($_REQUEST['month']==1){ echo "selected"; } ?>>1 Month</option>
                                    <option value="2" <?php if($_REQUEST['month']==2){ echo "selected"; } ?>>2 Months</option>
                                    <option value="3" <?php if($_REQUEST['month']==3){ echo "selected"; } ?>>3 Months</option>
                                    <option value="4" <?php if($_REQUEST['month']==4){ echo "selected"; } ?>>4 Months</option>
                                    <option value="5" <?php if($_REQUEST['month']==5){ echo "selected"; } ?>>5 Months</option>
                                    <option value="6" <?php if($_REQUEST['month']==6){ echo "selected"; } ?>>6 Months</option>
                                    <option value="7" <?php if($_REQUEST['month']==7){ echo "selected"; } ?>>7 Months</option>
                                    <option value="8" <?php if($_REQUEST['month']==8){ echo "selected"; } ?>>8 Months</option>
                                    <option value="9" <?php if($_REQUEST['month']==9){ echo "selected"; } ?>>9 Months</option>
                                    <option value="10" <?php if($_REQUEST['month']==10){ echo "selected"; } ?>>10 Months</option>
                                    <option value="11" <?php if($_REQUEST['month']==11){ echo "selected"; } ?>>11 Months</option>
                                    <option value="12" <?php if($_REQUEST['month']==12){ echo "selected"; } ?>>12 Months</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <select class="form-control" name="size" id="size">
                                    <option value="">Size</option>
                                    <option value="s" <?php if($_REQUEST['size']=='s'){ echo "selected"; } ?>>S</option>
                                    <option value="m" <?php if($_REQUEST['size']=='m'){ echo "selected"; } ?>>M</option>
                                    <option value="x" <?php if($_REQUEST['size']=='x'){ echo "selected"; } ?>>X</option>
                                    <option value="xl" <?php if($_REQUEST['size']=='xl'){ echo "selected"; } ?>>XL</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="minprice" id="minprice" value="0">
                        <input type="hidden" class="form-control" name="maxprice" id="maxprice" value="1000">
                        <div class="form-row collapse" id="addreviews">

                            <div class="form-group col-lg-12 my-5 ml-3">

                                <div class="example">
                                    <div id="mobile" class="range-example-single"></div>
                                </div>

                            </div>

                            <div class="form-group col-lg-4">
                                <input type="text" placeholder="Start date" class="form-control hasdatepicker" name="sdate" id="sdate" value="<?php echo $_REQUEST['sdate']; ?>">

                            </div>

                            <div class="form-group col-lg-4">
                                <input type="text" placeholder="End date" class="form-control hasdatepicker" name="edate" id="edate" value="<?php echo $_REQUEST['edate']; ?>">

                            </div>
                            <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="geographical_zone" id="geographical_zone">
                                    <option value="">Geographical zone</option>
                                    <?php foreach ($tzlist as $key => $value) { ?>
                                    <option value="<?php echo $value; ?>" <?php if($_REQUEST['geographical_zone']==$value){ echo "selected"; } ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                    
                                </select>
                                <!-- <input type="text" placeholder="Geographical zone" class="form-control" name="geographical_zone" id="geographical_zone"> -->
                            </div>
                            <div class="rating-container">
                                <div class="rank-container">
                                    <div class="rank-half"></div>
                                    <div class="rank-half"></div>
                                </div>
                                <div class="rank-container">
                                    <div class="rank-half"></div>
                                    <div class="rank-half"></div>
                                </div>
                                <div class="rank-container">
                                    <div class="rank-half"></div>
                                    <div class="rank-half"></div>
                                </div>
                                <div class="rank-container">
                                    <div class="rank-half"></div>
                                    <div class="rank-half"></div>
                                </div>
                                <div class="rank-container">
                                    <div class="rank-half"></div>
                                    <div class="rank-half"></div>
                                </div>
                            </div>
                            <div class="foo pt-1"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 search-btn-area">
                            <input type="submit" value="Search" class="btn btn-primary">
                            <button type="button" class="btn btn-outline-primary py-2" data-toggle="collapse" data-target="#addreviews">Advance Search</button>
                        </div>
                    </div>
                </div>
                </form>


                <div class="result-area pt-3">
                    <p class="d-flex justify-content-between">
                        <span><?php echo mysqli_num_rows($resultAll); ?> Results</span>
                        <span class="reset-gray"> <a href="#searchConsole" class="reset" id="resetbtn" type="reset">Reset</a> Search completed. Found <?php echo mysqli_num_rows($resultAll); ?> matching records.</span>
                    </p>
                    <div class="similar-parking mt-4 mb-5">
                        <div class="row ">
                            <?php
                            //if($resultAll){
                            $marker_arr = array();
                            $center_lat = 0;
                            $center_lng = 0;
                            while ($row_parking = mysqli_fetch_object($resultAll)) {

                                $encoded_id = base64_encode($row_parking->id);

                                $resultprice = "$ " . $row_parking->price;

                                $center_lat += $row_parking->lat;
                                $center_lng += $row_parking->lon;

                                $marker_arr[] = array(
                                    'name' => $row_parking->name,
                                    'address' => $row_parking->address,
                                    'lat' => $row_parking->lat,
                                    'lng' => $row_parking->lon,
                                    'parking_id' => $row_parking->id,
                                    'price' => $resultprice
                                );

                                $propLatLng[] = array('lat' => (float) $row_parking->lat, 'lng' => (float) $row_parking->lon);

                            ?>
                            <div class="col-md-6 search-fld">
                                <a href="<?php echo SITE_URL; ?>details_page.php?data=<?php echo $encoded_id; ?>">
                                    <?php
                                    $get_parking_image = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking_images` WHERE `parking_id`={$row_parking->id}"));
                                    if ($get_parking_image->image == '') {
                                        $img_parking = './upload/parking.jpg';
                                    } else {
                                        $img_parking = './upload/parking/' . $get_parking_image->image;
                                    }
                                    ?>
                                    <img class="img-fluid my-2" src="<?php echo $img_parking; ?>">
                                </a>
                                <p class="more-park d-flex justify-content-between">
                                    <span><?php echo $row_parking->address; ?></span>

                                    <span>
                                        <i class="fas fa-check verified" data-toggle="tooltip" data-placement="top" title="Verified Owner"></i>
                                        <!-- <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"> -->
                                    </span>
                                </p>
                                <a href="<?php echo SITE_URL; ?>details_page.php?data=<?php echo $encoded_id; ?>">
                                <h4>
                                    <?php echo $row_parking->name; ?>
                                </h4>
                                </a>
                                <h5>
                                    <b>
                                        <?php if ($row_parking->currency == 'usd') {?>$
                                        <?php }?>
                                        <?php echo $row_parking->price; ?></b> /
                                    <?php echo $row_parking->price_rate_type; ?>
                                </h5>
                                <p class="rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    (4.5)</p>
                            </div>
                            <?php
                            }
                            $countProp = count($marker_arr);
                            $marker_arr = json_encode($marker_arr);
                            $propLatLng = json_encode($propLatLng);

                            //}
                            ?>
                            <!-- <div class="col-md-6">
                                <img class="img-fluid my-2" src="images/popular-img2.png">
                                <p class="more-park d-flex justify-content-between">
                                    <span>More than 800 parking</span>

                                    <span>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                    </span>
                                </p>
                                <h4>Parking place name</h4>
                                <h5>
                                    <b>$ 4.5</b> /per hour</h5>
                                <p class="rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    (4.5)</p>
                            </div>
                            <div class="col-md-6">
                                <img class="img-fluid my-2" src="images/popular-img3.png">
                                <p class="more-park d-flex justify-content-between">
                                    <span>More than 800 parking</span>

                                    <span>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                    </span>
                                </p>
                                <h4>Parking place name</h4>
                                <h5>
                                    <b>$ 4.5</b> /per hour</h5>
                                <p class="rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    (4.5)</p>
                            </div>
                            <div class="col-md-6">
                                <img class="img-fluid my-2" src="images/popular-img4.png">
                                <p class="more-park d-flex justify-content-between">
                                    <span>More than 800 parking</span>

                                    <span>
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                    </span>
                                </p>
                                <h4>Parking place name</h4>
                                <h5>
                                    <b>$ 4.5</b> /per hour</h5>
                                <p class="rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>

                                    (4.5)</p>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pl-0 pr-0 search-map">
                <!--<img class="img-fluid" src="images/map.png" alt="">-->
                <div id="map-canvas" style="max-width:100%;height:100%;">
                    <?php if ($countProp == 0) { echo 'No property matches with your criteria'; } ?>
                </div>
            </div>
        </div>
    </div>

</section>

<?php
include "include/footer.php";
?>
<style>
    .labels {
        background-color: #3e25e3 !important;
        color: #ffffff;
    }
    .map-canvas img{
        width: 46px;
        height: 57px;
    }
</style>
<script src="js/jquery-asRange.js"></script>
<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<!-- <script type="text/javascript" src="js/markerwithlabel.js"></script> -->
<script type="text/javascript">
    function initialize() {
        initMap();
        initAutocomplete();
    }

    function initMap() {
        // The location of Uluru
        var LatLong = {lat: <?php echo $center_lat/ mysqli_num_rows($resultAll); ?>, lng: <?php echo $center_lng/ mysqli_num_rows($resultAll); ?>};
        // The map, centered at Uluru
        var map = new google.maps.Map(
        document.getElementById('map-canvas'), {zoom: 12, center: LatLong});
        // The marker, positioned at Uluru
        // var marker = new google.maps.Marker({
        //     position: LatLong,
        //     map: map
        // });
        setMarkers(map);
    }
    var beaches = [
        
    ];

    var customMarkers = JSON.parse(<?php echo json_encode($marker_arr); ?>);
    console.log(customMarkers);

    function setMarkers(map) {
        var image = {
            url: 'http://104.131.83.218/team4/apparkear/images/search-icon.png',
            size: new google.maps.Size(32, 40),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(32, 40)
        };
        var shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: 'poly'
        };
        for (var i = 0; i < customMarkers.length; i++) {
            var customMarker = customMarkers[i];
            console.log(customMarker);
            let modLat = parseFloat(customMarker.lat);
            let modLng = parseFloat(customMarker.lng);

            var marker = new google.maps.Marker({
                position: {lat: modLat, lng: modLng},
                map: map,
                icon: image,
                // shape: shape,
                title: customMarker.name,

                // zIndex: beach[3]

            });
        }
    }

    var placeSearch, autocomplete2;
    var componentForm = {
    };

    function initAutocomplete() {
        autocomplete2 = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete2.addListener('place_changed', fillInAddress);
    }
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete2.getPlace();

        $('input[name="lat"]').val(place.geometry.location.lat());
        $('input[name="lon"]').val(place.geometry.location.lng());

    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initialize&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY " async defer type="text/javascript"></script>
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY&callback=initMap"></script> -->

<script>
$("#datetimesearch" ).datepicker({
    dateFormat: "yy-mm-d"
});
$("#sdate" ).datepicker({
    dateFormat: "yy-mm-d"
});
$("#edate" ).datepicker({
    dateFormat: "yy-mm-d"
});

$('.rank-half').hover(function() {
    var thisIndex = $(this).index(),
        parent = $(this).parent(),
        parentIndex = parent.index(),
        ranks = $('.rank-container');
    for (var i = 0; i < ranks.length; i++) {
        if(i < parentIndex) {
        	$(ranks[i]).removeClass('half').addClass('full');
        } else {
            $(ranks[i]).removeClass('half').removeClass('full');
        }
    }
    if(thisIndex == 0) {
		parent.addClass('half');
    } else {
        parent.addClass('full');
    }
});

$('.rank-half').click(function() {
    var thisIndex = $(this).index(),
        parent = $(this).parent(),
        parentIndex = parent.index(),
        rating = parentIndex;
    rating += thisIndex ? 1 : 0.5;
    $('.foo').text(rating);
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".range-example-single").asRange({
            step: 30,
            range: true,
            limit: true,
            min: 0,
            max: 1000,
            format: function(value) {
              return '$' + value;
            },
            onChange: function(value) {
                $("#minprice").val(value[0]);
                $("#maxprice").val(value[1]);
            }
        });
        
        <?php if($_REQUEST['maxprice'] != ''){ ?>
        var price='<?php echo $_REQUEST['maxprice']; ?>';
        $(".range-example-single").asRange('set', [0, price]);
        <?php } ?>

        $('#resetbtn').click(function(){
            $('#searchConsole')[0].reset();
            window.location.href='<?php echo SITE_URL; ?>search_list.php?location=&lat=&lon=';
        });
    });
</script>

</body>

</html>
