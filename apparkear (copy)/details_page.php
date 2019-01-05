<?php
ob_start();
session_start();

require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";

$id = base64_decode($_REQUEST['data']);
//echo $id; exit;
$user_id = $_SESSION['user_id'];
$parking_spaces = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`={$id}"));
$amenities_query = mysqli_query($link, "SELECT * FROM amenities WHERE id IN ($parking_spaces->amenities)");
$parking_rules_query = mysqli_query($link, "SELECT * FROM parking_rules WHERE parking_id='{$id}'");
$ratings_cat_query = mysqli_query($link, "SELECT * FROM ratings_category");

$get_parking_image = mysqli_query($link,"SELECT * FROM `parking_images` WHERE `parking_id`={$id}");

$car_type = $parking_spaces->car_type;
$country = $parking_spaces->country;
$state = $parking_spaces->state;
$city = $parking_spaces->city;

$price = $parking_spaces->price;
//if max price is not empty
if($parking_spaces->is_dynamic==1){
    $mainprice = $parking_spaces->maximum_price;
}else{
   $mainprice = $parking_spaces->price;
}

$site_setting = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `estejmam_sitesettings` WHERE `id`=1"));
$cleaning_fee_percentage = $site_setting->cleaning_fee;
$service_fee_percentage = $site_setting->service_fee;

$cleaning_fee = ($mainprice * $cleaning_fee_percentage)/100;
$service_fee = ($mainprice * $service_fee_percentage)/100;

$get_country = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `countries` WHERE `id`=$country"));
$get_state = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `states` WHERE `id`=$state"));
$get_city = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `cities` WHERE `id`=$city"));


if(!empty($user_id)){
$fav_check = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_favourite_property` WHERE `prop_id`=$id AND `user_id`=$user_id"));
}else{
    $fav_check= array();
}
if($car_type != ""){
    $condition="`parking`.`car_type`='".$car_type."' AND `parking`.`id` != $parking_spaces->id";
}else{
    $condition="`parking`.`id` != $parking_spaces->id";

}
//echo "SELECT `parking`.*,`parking_images`.`image` as `parking_image` FROM `parking` LEFT JOIN `parking_images` on `parking_images`.`parking_id` =`parking`.`id` WHERE $condition ORDER BY `parking`.`id` DESC limit 4";exit;
$similar_parking = mysqli_query($link, "SELECT `parking`.*,`parking_images`.`image` as `parking_image` FROM `parking` LEFT JOIN `parking_images` on `parking_images`.`parking_id` =`parking`.`id` WHERE $condition ORDER BY `parking`.`id` DESC limit 4");
//while($similar_row = mysqli_fetch_object($similar_parking)){
//    print_r($similar_row);
//}
?>

<section class="message-body">
    <div class="container">
        <div class="detail-banner-area">
            <h3>
                <?php echo $parking_spaces->name; ?>, Madrid
            </h3>
            <?php
//            echo '<pre>';
//            print_r($parking_spaces);
//            echo '</pre>';
            ?>
            <ul class="list-group">
                <li class="list-group-item"> <a href="javascript:void(0)"><i class="ion-ios-location"></i> <?php echo $get_country->name; ?></a> </li>
                <li class="list-group-item"> <i class="ion-ios-arrow-right"></i></li>
                <li class="list-group-item"> <a href="javascript:void(0)"><?php echo $get_state->name; ?></a> </li>
                <li class="list-group-item"> <i class="ion-ios-arrow-right"></i> </li>
                <li class="list-group-item"> <a href="javascript:void(0)"><?php echo $get_city->name; ?></a> </li>
            </ul>

            <div class="detail-bnr">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $rowcount=mysqli_num_rows($get_parking_image);
                         if($rowcount > 0){ $image_count = 0; while($image_row = mysqli_fetch_object($get_parking_image)){ ?>
                        <div class="carousel-item <?php if($image_count == 0){ ?> active <?php } ?>">
                            <img class="img-fluid d-block w-100" src="upload/parking/<?php echo $image_row->image; ?>" alt="First slide">
                        </div>
                        <?php $image_count++; } }else{ ?>
                        <div class="carousel-item active">
                            <img class="img-fluid d-block w-100" src="upload/parking/15361216261490175707_RblFrV_shutterstock_426709153-470.jpg" alt="First slide">
                        </div>
                        <?php } ?>
                        <!-- <div class="carousel-item">
                            <img class="img-fluid d-block w-100" src="images/detail-ban.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid d-block w-100" src="images/detail-ban.jpg" alt="Third slide">
                        </div> -->
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="detail-body-lt">
                    <h3>Parking area description</h3>
<?php //print_r($parking_spaces); ?>
                    <?php echo $parking_spaces->description; ?>

                    <ul class="list-group pack-list">
                        <li class="list-group-item"> <img src="images/description-icon.png" alt=""> Description</li>
                        <li class="list-group-item"> <img src="images/day-icon.png" alt=""> Days</li>
                        <li class="list-group-item"> <img src="images/hours-icon.png" alt=""> Hours availability</li>
                    </ul>
                    <div class="mini-contract">
                        <h5>Minimum months of contract:</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            dolore magna aliqua.Lorem ipsum dolor sit amet consectetur adipiscing elit.</p>
                    </div>
                    <div class="amenities-area">
                        <h5>Amenities</h5>
                        <div class="amenities-top d-flex align-items-center">
                            <ul class="list-group flex-row flex-wrap">
                                <?php
                                while ($amenity = mysqli_fetch_object($amenities_query)) {
                                    echo '<li class="list-group-item d-flex align-items-center"><div class="icon-pic">
                                            <img src="upload/amenities/'.$amenity->image.'" alt="" />
                                        </div> '.$amenity->name.'</li>';
                                }
                                ?>
                                <!-- <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic">
                                        <img src="images/elevator-icon.png" alt="" />
                                    </div> Elevator
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/kitchen-icon.png" alt=""></div> Kitchen
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/free-parking.png" alt=""></div> Free Parking
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/heating-icon.png" alt=""></div> Heating
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/wifi.png" alt=""></div> Wifi
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/driver-icon.png" alt=""></div> Driver
                                </li> -->
                            </ul>

                            <!--<ul class="list-group ml-5">
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/kitchen-icon.png" alt=""></div> Kitchen
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/heating-icon.png" alt=""></div> Heating
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="icon-pic"> <img src="images/driver-icon.png" alt=""></div> Driver
                                </li>
                            </ul>-->
                        </div>
                        <div class="amenities-btm mt-5">
                            <ul class="list-group">
                                <li class="list-group-item  d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/calender-icon.png" alt=""></div> Minimum stay:
                                    1 month (30 days)
                                </li>
                                <li class="list-group-item  d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/calender-icon.png" alt=""></div>No maximum stay
                                </li>
                                <li class="list-group-item  d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/calender-icon.png" alt=""></div>Type of contract:
                                    monthly <a href="learn_more.php"><span class="learn-more pl-1">
                                            Learn more</span></a> </li>
                                <li class="list-group-item  d-flex align-items-center">
                                    <div class="icon-pic"><img src="images/calender-icon.png" alt=""></div>Available: July
                                    1, 2017
                                </li>
                                <li class="list-group-item">Ref. 104419</li>
                            </ul>
                        </div>

                        <div class="parking-rule mt-5">
                            <h5>Parking Rules</h5>
                            <ul class="list-group">
                                <?php
                                //while ($parking_rule = mysqli_fetch_object($parking_rules_query)) {
                                ?>
                                <li class="list-group-item">
                                    <i class="ion-ios-arrow-right"></i> <?php echo $parking_spaces->rules; ?></li>
                                </li>
                                <?php
                                //}
                                ?>
                                <!-- <li class="list-group-item"> <i class="ion-ios-arrow-right"></i> Distracted by the readable
                                    content of a page when.</li>
                                <li class="list-group-item"> <i class="ion-ios-arrow-right"></i> Looking at its layout, the
                                    point of using jorem.</li>
                                <li class="list-group-item"> <i class="ion-ios-arrow-right"></i> Kpsum is that it has a more-or-less
                                    normal.
                                </li>
                                <li class="list-group-item"> <i class="ion-ios-arrow-right"></i> Tistribution of letters,
                                    as opposed to usin.</li> -->
                            </ul>
                            <a class="btn btn-primary mt-3" data-toggle="modal" data-target=".bd-example-modal-lg" href="all_rules.php">Read All Rules <i class="ion-ios-arrow-right"></i></a>
                        </div>

                        <div class="parking-rule mt-5">
                            <h5>Cancellation policy</h5>
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text It has roots in a piece
                                of classical Latin literature from 45 BC</p>
                            <a class="btn btn-primary mt-1"  data-toggle="modal" data-target=".bd-example-modal-lg-2" href="cancel_policy.php" >Get Details <i class="ion-ios-arrow-right"></i>
                            </a>
                        </div>
                        
                        <div class="parking-rule map-img mt-5">
                            <!-- <img class="img-fluid" src="images/detail-map.png" alt=""> -->
                            <!--<input type="text" name="search_location" class="map-input" value="<?php //echo $parking_spaces->address; ?>" id="autocomplete" placeholder="Search for an address, neighbourhood..">-->
                            <input type="text" name="search_location" class="map-input" value="<?php echo $parking_spaces->address; ?>" id="autocomplete1" placeholder="Search for an address, neighbourhood..">
                            <div class="map-fix" id="map_div">
                                
                            </div>

<!--                            <div class="map_append">
                                <?php //if($parking_spaces->lat == "" && $parking_spaces->lon == ""){ ?>
                            <iframe class="map_iframe" src="https://developers.google.com/maps/documentation/javascript/examples/full/places-searchbox?q=-33.8688, 151.2195&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY" class="" width="100%" height="500" frameborder="0" style="border:1px solid #d5d5d5; border-radius: 4px;" allowfullscreen></iframe>
                                <?php  //}else{ ?>
                                <iframe class="map_iframe" src="https://developers.google.com/maps/documentation/javascript/examples/full/places-searchbox?q=<?php echo $parking_spaces->lat; ?>, <?php echo $parking_spaces->lon; ?>&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY" class="" width="100%" height="500" frameborder="0" style="border:1px solid #d5d5d5; border-radius: 4px;" allowfullscreen></iframe>
                                <?php //} ?>
                            </div>-->
                            <p>Important Information: Exact location information is provided after a booking is confirmed.</p>
                        </div>
                        <div class="amenities-area mt-5">
                            <h5 class="mb-3">Accessibility</h5>
                            <div class="row accessibility">
                                <div class="col-6 col-sm-4">
                                    <p><?php echo $parking_rule->accessibility; ?></p>
                                    <a class="btn btn-primary mt-1" data-toggle="modal" data-target=".bd-example-modal-lg-3" href="accessibility.php" >View All
                                        <i class="ion-ios-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply</p>
                                </div>
                            </div>

                        </div>
                        <div class="amenities-area mt-5">
                            <h5 class="mb-3">Add reviews and ratings</h5>
                            <div class="row justify-content-between align-items-center mb-3">
                                <div class="col-lg-5">
                                    <div class="add-rev-rate-lt">
                                        <p>182 Reviews <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i></p>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group add-rev-rate-rt">
                                        <img src="images/srch-icon.png" alt="">
                                        <input type="email" class="form-control" placeholder="Search Reviews">

                                    </div>
                                </div>
                            </div>
                            <hr>
                            </hr>
                            <div class="row justify-content-between align-items-center mt-3">
                                <div class="col-lg-12">
                                    <div class="add-rev-rate-lt">
                                        <ul class="list-group justify-content-between flex-wrap flex-row w-100">
                                            <?php
                                            while ($ratingSingle = mysqli_fetch_object($ratings_cat_query)) {
                                            ?>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt"><?php echo $ratingSingle->name; ?></span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                            <!-- <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Location</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Communication</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Check in</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Cleanliness</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Value</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                                <!--<div class="col-lg-5">
                                    <div class="add-rev-rate-rt">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Location</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Check in</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="spn-txt">Value</span>
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </li>

                                        </ul>

                                    </div>


                                </div>-->
                            </div>
                        </div>
                        <div class="add-rev-media">
                            <div class="media d-flex align-items-center pl-0 pb-1 ">
                                <div class="pic mr-3">
                                    <img class="" src="images/lady-pic.png" alt="Generic placeholder image">
                                </div>

                                <div class="media-body">
                                    <h6>Rina Dasgupta</h6>
                                    <p>March 2017</p>
                                </div>

                                <div class="rt-icons">
                                    <img src="images/fb-like.png" alt="">
                                    <img src="images/heart.png" alt="">
                                </div>

                            </div>
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text It has roots in a piece
                                of classical Latin literature from 45 BC Ipsum is not simply random text It has roots in
                                a piece of classical Latin literature from.</p>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="detail-body-rt">
                    <div class="detail-body-rt-price d-flex justify-content-between">
                        <span> <h5 class="price">Price</h5> </span>
                        <?php

                        ?>
                        <span> <h5><?php echo strtoupper($parking_spaces->currency) . ' ' . $mainprice . ' ' . $parking_spaces->price_rate_type; ?></h5> </span>
                    </div>
                    <ul class="list-group justify-content-between align-items-center">
                        <li class="list-group-item initial-date">
                            <div class="form-group">
                                <label>Initial Dates</label>
                                <input class="form-control validate_date" placeholder="2018-06-01" id='datetimepicker1' value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </li>
                        <li class="list-group-item pl-1 pr-1 pt-4"><img src="images/dark-arw.png" alt=""></li>
                        <li class="list-group-item initial-date">
                            <div class="form-group">
                                <label>No. of Months</label>
                                <select class="form-control validate_month" id="select_month" style="font-size: 13px;">
                                    <option value="0">Select Months</option>
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="4">4 Months</option>
                                    <option value="5">5 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="7">7 Months</option>
                                    <option value="8">8 Months</option>
                                    <option value="9">9 Months</option>
                                    <option value="10">10 Months</option>
                                    <option value="11">11 Months</option>
                                    <option value="12">12 Months</option>

                                </select>
                            </div>
                        </li>

                    </ul>
                    <ul class="list-group justify-content-between align-items-center">
                        <li class="list-group-item initial-date pt-0">
                            <div class="form-group">
                                <label>End Dates</label>
                                <input class="form-control" placeholder="2018-06-01" id='datetimepicker11' readonly editable="false;" value="<?php echo date('Y-m-d'); ?>" >
                                <span>
                                    <img src="images/end-arw.png" alt="">
                                    <b>END</b>
                                </span>
                            </div>
                        </li>
                    </ul>

                    <ul class="list-group justify-content-between align-items-center unstyled centered">
                        <li class="list-group-item disclaimer">
                            <div class="form-group">
                                <h5>Disclaimer:</h5>
                                <div class="car-size">
                                    <?php if($car_type == 's'){ 
                                        $cursor='s';
                                    }else if($car_type == 'm'){
                                        $cursor='m';
                                    }else if($car_type == 'l'){
                                        $cursor='l';
                                    }else if($car_type == 'exl'){
                                        $cursor='exl';
                                    }
                                    
                                    ?>
                                    <label class="container" <?php if($cursor!='s'){ ?>style="cursor: default;"<?php } ?>>
                                        <input type="radio" <?php if($car_type == 's'){ ?>checked="checked"<?php } ?> name="radio" disabled="disabled">
                                    <span class="checkmark <?php if($cursor=='s'){ ?> active-text<?php } ?>" readonly>S</span>
                                    </label>
                                    <label class="container" <?php if($cursor!='m'){ ?>style="cursor: default;"<?php } ?>>
                                        <input type="radio" name="radio" <?php if($car_type == 'm'){ ?>checked="checked"<?php } ?> disabled="disabled">
                                    <span class="checkmark <?php if($cursor=='m'){ ?> active-text<?php } ?>">M</span>
                                    </label>
                                    <label class="container" <?php if($cursor!='l'){ ?>style="cursor: default;"<?php } ?>>
                                    <input type="radio" name="radio" <?php if($car_type == 'l'){ ?>checked="checked"<?php } ?> disabled="disabled">
                                    <span class="checkmark <?php if($cursor=='l'){ ?> active-text<?php } ?>">L</span>
                                    </label>
                                    <label class="container" <?php if($cursor!='exl'){ ?>style="cursor: default;"<?php } ?>>
                                    <input type="radio" name="radio" <?php if($car_type == 'exl'){ ?>checked="checked"<?php } ?> disabled="disabled">
                                    <span class="checkmark <?php if($cursor=='exl'){ ?> active-text<?php } ?>">XL</span>
                                    </label>
                                </div>

                                <div class="form-check mt-4 pl-0">
                                    <input type="checkbox" name="checkme" class="checkme" id="exampleCheck1" value="1">
                                    <label class="" for="exampleCheck1">Check me out</label>
                                </div>

                            </div>
                        </li>
                    </ul>
                    <?php 
                    
                    $total_price = $mainprice + $cleaning_fee + $service_fee; /*$percentage = ($parking_spaces->discount/100)*$total_price; $actual_price = $total_price-$percentage;*/ $actual_price = $total_price; $_SESSION['actual_price']= $actual_price; ?>
                    <ul class="list-group amount-part">
                        <li class="list-group-item justify-content-between d-flex discount_range" style="display:none !important">
                            <span><?php echo $parking_spaces->discount; ?>% monthly price discount</span>
                            <span>- $<?php echo $percentage; ?></span> </li>
                        <li class="list-group-item justify-content-between d-flex">
                            <span>Cleaning fee</span>
                            <span>$<?php echo $cleaning_fee; ?></span>
                        </li>
                        <li class="list-group-item justify-content-between d-flex">
                            <span>Service fee</span>
                            <span>$<?php echo $service_fee; ?></span>
                        </li>
                        <li class="list-group-item justify-content-between d-flex">
                            <span> <b>Total</b> </span>
                            <?php if(isset($_SESSION['actual_price']) && isset($_SESSION['booking_month'])){
                                $actual_price = $_SESSION['actual_price']*$_SESSION['booking_month'];
                            } ?>
                            <span id="actual_price" data="<?php echo $parking_spaces->price; ?>" rel="<?php echo $actual_price; ?>"> <b>$<?php echo $actual_price; ?></b> </span>
                        </li>

                    </ul>

                    <div class="give_status" style="color:#4519ea;"></div>
                    <?php if($_SESSION['user_type'] == 1){ ?>
                    <div class="row mt-3">
                        <?php if($_SESSION['user_id'] != ""){ ?>
                        <div class="col-sm-9 pr-0">
                            <a class="btn btn-primary btn-block validate_link disabled" href="booking_parking.php?parking=<?php echo $_REQUEST['data']; ?>">Book Now!</a>
                        </div>
                        <?php }else{ ?>
                        <div class="col-sm-9 pr-0">
                            <a class="btn btn-primary btn-block validate_link" data-toggle="modal" data-target="#exampleModalLong" href="#">Book Now!</a>
                        </div>
                        <?php } ?>
                        <div class="col-sm-3 ">
                            <?php if($_SESSION['user_id'] != ""){ ?>
                            <?php if(!empty($fav_check)){ ?>
                            <button type="button" class="btn change_fav add_fav" rel="<?php echo $parking_spaces->id; ?>" style=""> <i class="ion-heart"></i> </button>
                            <?php }else{ ?>
                                <button type="button" class="btn btn-primary add_fav" rel="<?php echo $parking_spaces->id; ?>"> <i class="ion-heart"></i> </button>
                            <?php } ?>
                            <?php }else{ ?>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong"> <i class="ion-heart"></i> </a>
                            <?php  } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="pay-card-area mt-3">
                    <ul class="list-group justify-content-center">
                        <li class="list-group-item ">We accept</li>
                        <li class="list-group-item"><img src="images/visa.png" alt=""></li>
                        <li class="list-group-item"><img src="images/master-card.png" alt=""></li>
                        <li class="list-group-item"><img src="images/discover-card.png" alt=""></li>
                        <li class="list-group-item"><img src="images/american-card.png" alt=""></li>
                    </ul>
                </div>

                <div class="report-area mt-3 text-center">
                    <a href="#"><img src="images/report-flag.png" alt="">Report this Listing</a>
                </div>




            </div>
        </div>
    </div>
</section>
<section class="container">
    <div class="similar-parking mt-4 mb-5">
        <h3>Similar Parking Places you may like</h3>
        <div class="row">
            <?php while($row_similar = mysqli_fetch_object($similar_parking)){
                if ($row_similar->parking_image == '') {
                    $img_parking = './upload/parking.jpg';
                } else {
                    $img_parking = './upload/parking/' . $row_similar->parking_image;
                }
                $encoded_id = base64_encode($row_similar->id);
                ?>
            <div class="col-md-3" style="height: 450px;">
                <a href="<?php echo SITE_URL; ?>details_page.php?data=<?php echo $encoded_id; ?>">
                <img class="img-fluid my-2" src="<?php echo $img_parking; ?>" style="height: 60%;">
                <p><?php echo $row_similar->address; ?></p>
                <h4><?php echo $row_similar->name; ?></h4>
                <h5>
                    <b><?php if($row_similar->currency == 'usd'){ ?>$ <?php } ?> <?php echo $row_similar->price; ?></b> /<?php echo $row_similar->price_rate_type; ?></h5>
                <p class="rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    (4.5)</p>
                </a>
            </div>
            <?php } ?>
<!--            <div class="col-md-3">
                <img class="img-fluid my-2" src="images/popular-img2.png">
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
            <div class="col-md-3">
                <img class="img-fluid my-2" src="images/popular-img3.png">
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
            <div class="col-md-3">
                <img class="img-fluid my-2" src="images/popular-img4.png">
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

</section>
<!-- modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="container">
            <div class="">
                <div class="p-2">
                    <h4 class="text-center alert alert-primary m-2 py-1" role="alert">Parking Rules</h4>
                    <div class="row m-5 border-top border-primary">
                      <div class="col-2 pl-0 pr-2 text-center">
                        <h5 class="box">No. 1</h5>
                      </div>
                      <div class="col-10">
                        <p class="mt-1">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.Making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
                      </div>
                    </div>
                    <div class="row m-4 mx-5 border-top border-primary">
                      <div class="col-2 pl-0 pr-2 text-center">
                        <h5 class="box">No. 2</h5>
                      </div>
                      <div class="col-10">
                        <p class="mt-1">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.Making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
                        <p>It uses a dictionary of over Latin words, combined with a handful of model sentencea handful of model sentence structures, to generate Lorem Ipsum which looks structures, to generate Lorem Ipsum which looks reasonable.</p>
                      </div>
                    </div>
                    <div class="row m-5 border-top border-primary">
                      <div class="col-2 pl-0 pr-2 text-center">
                        <h5 class="box">No. 3</h5>
                      </div>
                      <div class="col-10">
                        <p class="mt-1">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.Making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
                      </div>
                    </div>
                    <div class="row m-5 border-top border-primary">
                      <div class="col-2 pl-0 pr-2 text-center">
                        <h5 class="box">No. 4</h5>
                      </div>
                      <div class="col-10">
                        <p class="mt-1">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.Making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
                      </div>
                    </div>
                </div>

            </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- modal2 -->
<div class="modal fade bd-example-modal-lg-2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="container">
            <div class="">
                <div class="gray-bg p-3">
                    <h4 class="dot-box text-center">Cancellation Policy</h4>
                    <div class="p-4">
                      <h5>There are many variations of passages of Lorem</h5>
                      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                      <h5>Richard McClintock, a Latin professor</h5>
                      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia. <br>looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
                      <h5>Lorem Ipsum passages, and more recently with desktop publishing </h5>
                      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                  </div>
                </div>

            </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!---modal3  -->
<div class="modal fade bd-example-modal-lg-3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="container">
            <div class="2">
                <div class="gray-bg p-3">
                    <h4 class="alert alert-secondary text-center" role="alert">Accessibility</h4>
                    <div class="p-4 row">
                      <div class="col-lg-4 shadow-img">
                        <img src="./upload/parking/1535031441popular-img4.png" class="img-fluid shadow p-2 mb-5">
                      </div>
                      <div class="col-lg-8">
                        <h5 class="mb-3">There are many variations of passages of Lorem</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                      </div>

                    <div class="col-lg-8 my-4">
                      <h5 class="mb-3">There are many variations of passages of Lorem</h5>
                      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia. <br>looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                    <div class="col-lg-4  my-4 shadow-img">
                      <img src="./upload/parking/1535032457popular-img7.png" class="img-fluid shadow p-2 mb-5">
                    </div>
                    <div class="col-lg-4 shadow-img">
                      <img src="./upload/parking/1535031441popular-img4.png" class="img-fluid shadow p-2 mb-5">
                    </div>
                    <div class="col-lg-8">
                      <h5 class="mb-3">There are many variations of passages of Lorem</h5>
                      <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful.</p>
                    </div>
                  </div>
                  </div>

            </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
include "include/footer.php";
?>
<style>
    .change_fav{
        background-color: #fff;
        border: 1px solid #3e25e3;
        color: #3e25e3 !important;
        border-radius: 5px;
        padding: 8px 20px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

        var monthval = $('.validate_month').val();
        if (monthval != 0 && ($('.checkme').is(':checked'))) {
            $('.validate_link').removeClass('disabled');
        }else{
            $('.validate_link').addClass('disabled');
        }
        

        $("#datetimepicker1" ).datepicker({
        dateFormat: "yy-mm-d",
        minDate: 0,
        onSelect: function(dateText, inst) {
        //alert(dateText);
        var month = $("#select_month").val();
        //alert(month);
        if(month == 0){
          var start_date = this.value;
          //alert(start_date);
          $.post("ajax_details.php", {month:month,start_date:start_date,parking_id:<?php echo $id; ?>}, function(result){
            var all = result.split("||");
            $("#datetimepicker11").val(all[0]);
            if(parseInt(all[1]) == 0){
                    var price = $("#actual_price").attr("rel")*month;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                     $(".discount_range").html(" ");
                }else{
                    var discount_price = (($("#actual_price").attr("rel")*month)*parseInt(all[1]))/100;
                    var price = ($("#actual_price").attr("rel")*month)-discount_price;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));

                    $(".discount_range").html(" ");
                    $(".discount_range").html("<span>"+all[1]+"% monthly price discount</span>\
                            <span>- $"+discount_price+"</span> ");
                    $(".discount_range").css("display","block");
                }
          });
        }else{
          var start_date = this.value;
          //var start_date = $.datepicker.parseDate('yy-mm-d', dateText);
          //alert(start_date);
          $.post("ajax_details.php", {month:month,start_date:start_date,parking_id:<?php echo $id; ?>}, function(result){
            var all = result.split("||");
            $("#datetimepicker11").val(all[0]);
            if(parseInt(all[1]) == 0){
                    var price = $("#actual_price").attr("rel")*month;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                     $(".discount_range").html(" ");
                }else{
                    var discount_price = (($("#actual_price").attr("rel")*month)*parseInt(all[1]))/100;
                    var price = ($("#actual_price").attr("rel")*month)-discount_price;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));

                    $(".discount_range").html(" ");
                    $(".discount_range").html("<span>"+all[1]+"% monthly price discount</span>\
                            <span>- $"+discount_price+"</span> ");
                    $(".discount_range").css("display","block");
                }
          });
        }

        //  current_date.setDate(current_date.getDate()+1);
        //  //alert(current_date);
        //  $('#datetimepicker6').datepicker("option", "minDate", current_date);
      }
    });

        $(".add_fav").click(function(){
            var id = $(this).attr("rel");
            $.ajax({
                type:"post",
                url:"ajax_fav.php",
                dataType:"json",
                data:{id:id},
                success:function(result){
                    //console.log(result);
                    //alert()
                    if(result.ack == 1){
                        $(".give_status").html("added to favorite").show();
                        setTimeout(function(){ $(".give_status").fadeOut();  },5000);
                        if($(".add_fav").hasClass('change_fav')){

                        }else{
                            $(".add_fav").removeClass('btn-primary');
                            $(".add_fav").addClass('change_fav');
                        }


                    }else if(result.ack == 2){
                        $(".give_status").html("Removed From favorite").show();
                        setTimeout(function(){ $(".give_status").fadeOut();  },5000);
                        if($(".add_fav").hasClass('change_fav')){
                            $(".add_fav").removeClass('change_fav');
                            $(".add_fav").addClass('btn-primary');
                        }

                    }
                }
            });
        });


        $("#select_month").change(function(){
            var month = $(this).val();
            var start_date = $("#datetimepicker1").val();
            //alert(month);

            $.post("ajax_details.php", {month:month,start_date:start_date,parking_id:<?php echo $id; ?>}, function(result){
               // alert(result); return false;
               var all = result.split("||");
               $("#datetimepicker11").val(all[0]);
               //alert($("#actual_price").attr("rel"));
               //alert(month);
                if(parseInt(all[1]) == 0){
                    var price = $("#actual_price").attr("rel")*month;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                     $(".discount_range").html(" ");
                }else{
                    var discount_price = (($("#actual_price").attr("rel")*month)*parseInt(all[1]))/100;
                    var price = ($("#actual_price").attr("rel")*month)-discount_price;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));

                    $(".discount_range").html(" ");
                    $(".discount_range").html("<span>"+all[1]+"% monthly price discount</span>\
                            <span>- $"+discount_price+"</span> ");
                    $(".discount_range").css("display","block");
                }
               //alert(price); return false;
            });


//            $.ajax({
//                type:'post',
//                url:'ajax_details.php',
//                data:{month:month,},
//                success:function(){
//
//                }
//            });

        });

        // $(".validate_link").click(function(){
        //     var initialdate = $(".validate_date").val();
        //     var nomonth = $(".validate_month").val();
        //     var checkme = $(".checkme").val();
        //     if(initialdate !=''){
        //         disabled false;
        //     }else-if(nomonth==''){
        //         disabled false;
        //     }else-if(checkme==''){
        //         disabled false;
        //     }
        // });

        $(".validate_month").change(function() {
            var monthval = $(this).val();
            if (monthval != 0 && ($('.checkme').is(':checked'))) {
                $('.validate_link').removeClass('disabled');
            }else{
                $('.validate_link').addClass('disabled');
            }
        });
        $(".checkme").click(function() {
            var monthval = $('.validate_month').val();
            if (($(this).is(':checked'))&&(monthval != 0)) {
                $('.validate_link').removeClass('disabled');
            }else{
                $('.validate_link').addClass('disabled');
            }
        });
    });
</script>

<script type="text/javascript">
    var map;
    var marker;
    
    function initialize() {
        var mapOptions = {
            zoom: 12
        };
        map = new google.maps.Map(document.getElementById('map_div'),
            mapOptions);

        // Get GEOLOCATION
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);

                map.setCenter(pos);
                marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    draggable: true
                });
            }, function() {
              handleNoGeolocation(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
        }

        function handleNoGeolocation(errorFlag) {
            if (errorFlag) {
                var content = 'Error: The Geolocation service failed.';
            } else {
                var content = 'Error: Your browser doesn\'t support geolocation.';
            }

            var options = {
                map: map,
                position: new google.maps.LatLng(<?php echo $parking_spaces->lat; ?>, <?php echo $parking_spaces->lon; ?>),
                content: content
            };

            map.setCenter(options.position);
            marker = new google.maps.Marker({
                position: options.position,
                map: map
            });

            // Add circle overlay and bind to marker
            var circle = new google.maps.Circle({
                map: map,
                radius: 1500,    // 10 miles in metres
                strokeColor: '#8ac8a7',
                fillColor: '#8bcdb8'
            });
            circle.bindTo('center', marker, 'position');
        }

        // get places auto-complete when user type in location-text-box
        var input = /** @type {HTMLInputElement} */
        (
          document.getElementById('autocomplete1'));


        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();
        
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
            
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            if (place.address_components) {
                $('input[name="lat"]').val(place.geometry.location.lat());
                $('input[name="lon"]').val(place.geometry.location.lng());
            }
        });
        
        

    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initialize&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY " async defer type="text/javascript"></script>
    