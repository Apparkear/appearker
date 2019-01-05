<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
if (isset($_REQUEST['ref']) && $_REQUEST['ref'] != '') {

    //----------- Social Share Count ---------------//
    //----------- Social Share Count ---------------//
    // echo '<pre>'; print_r($_SERVER); echo '</pre>'; exit;
    $code = $_REQUEST['ref'];
    $userData = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `onner_code`='" . $code . "'"));
    // var_dump($userData);
    if($userData['id'])
    {
      set_cookie("roomarateclientcode",$userData['onner_code'], time()+36000);
    }
    ?>
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      var substr = window.location.hash.substr(1);
      var id = "<?php echo $userData['id']; ?>";
      $.ajax({
        type: 'POST',
        url: 'agent/ajax_clickCount.php',
        data: {
          id: id,
          string: substr
        },
        success: function(response) {
          console.log(response);
        }
      })
    })
  </script>
  <?php
    //----------- Social Share Count ---------------//
    //----------- Social Share Count ---------------//

    $_SESSION['refcode'] = $_REQUEST['ref'];
}

require_once("class.phpmailer.php");
//session_destroy();
//unset($_SESSION['last_id']);
//unset($_SESSION['property_id']);
//unset($_SESSION['sendtotal']);
//unset($_SESSION['start_date']);
//unset($_SESSION['start_date']);
//unset($_SESSION['end_date']);
//unset($_SESSION['sendfees']);
if(isset($_REQUEST['debugmail'])){
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  sendMailFromTemplate(7,'','',"dimayarema@gmail.com",'',false);
  echo "string";
  die();
}
if (isset($_REQUEST['reply']) && $_REQUEST['reply'] != '') {


    $adminSetting = mysql_fetch_object(mysql_query("select * from `estejmam_tbladmin` where id = 1"));
    // $all_details = mysql_fetch_object(mysql_query("select * from `estejmam_booking` where `id`='" . $_REQUEST['bookingid'] . "'"));
    $all_details = mysql_fetch_object(mysql_query("select * from `estejmam_booking` where `id`='" . $_REQUEST['bookingid'] . "' AND `status` = '0'"));
    // $all_details->prop_id=588;
    $prop_details = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where `id`='" . $all_details->prop_id . "'"));
    $user_details = mysql_fetch_array(mysql_query("select * from `estejmam_user` where `id`='" . $prop_details->user_id . "'"));


     $image = mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $prop_details->id . "'");
    $image_details = mysql_fetch_object($image);

    $prop_image = "https://www.roomarate.com/upload/property/" . $image_details->image;

    if (!$all_details || !$prop_details) {
        print "Booking with id  {$_REQUEST['bookingid']} not found! <a href='/'>Go back to home!</a>";
        die();
    }
      // if(isset($all_details->ref_code) &&$all_details->ref_code!=''){

      //                   $agentDSQl = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `client_code` = '".$all_details->ref_code."'"));
      //                   $commitionAmmount = 50;
      //                   $typeDrirect = 1;
      //                   $derectComition = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `client_commition`, `status`) VALUES ('".$agentDSQl['id']."','".$all_details->prop_id."','".$all_details->id."','".$commitionAmmount."','0')";
      //                   mysql_query($derectComition);

      //                   if($prop_details->ref_code !="")
      //                   {
      //                     $get_agent_id=mysql_fetch_object(mysql_query("SELECT id FROM `estejmam_user` WHERE `client_code` = '".$prop_details->ref_code."'"));

      //                     $commitionAmmount = 15;
      //                       $typeDrirect = 2;
      //                       $derectComition2 = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `reffered_commition`, `status`) VALUES ('".$get_agent_id->id."','".$all_details->prop_id."','".$all_details->id."','".$commitionAmmount."','0')";
      //                       mysql_query($derectComition2);
      //                   }

      //                   if(isset($agentDSQl['agent_id']) && $agentDSQl['agent_id']==0 && $agentDSQl['type'] == 2)
      //                   {

      //                   }
      //                   else
      //                   {
      //                       $commitionAmmount = 15;
      //                       $typeDrirect = 2;
      //                       $derectComition2 = "INSERT INTO `estejmam_agent_commition`( `agent_id`,  `prop_id`, `booking_id`, `agent_commition`, `status`) VALUES ('".$agentDSQl['agent_id']."','".$all_details->prop_id."','".$all_details->id."','".$commitionAmmount."','0')";
      //                       mysql_query($derectComition2);
      //                       // die("GOOGLE");
      //                   }
      //                   // die("STOP== ".$derectComition2);
      //               }
    sendMailFromTemplate(7, array(
        "[LANDLORD]",
        "[LANDLORDEMAIL]",
        "[LANDLORDPHONE]",
        "[TENANTFULLNAME]",
        "[TENANTEMAIL]",
        "[TENANTCONTACTNUMBER]",
        "[NATIONALITY]",
        "[GENDER]",
        "[Dateofbirth]",
        "[PROPERTYID]",
        "[BOOKINGID]"
            ), array(
        $user_details["fname"] . " " . $user_details["lname"],
        $user_details["email"],
        $user_details["phone"],
        $all_details->firstname,
        $all_details->email,
        $all_details->telephone,
        $all_details->nationality,
        $all_details->gender,
        $all_details->dob,
        $all_details->prop_id,
        $all_details->id
            ), $user_details["email"], $user_details["phone"], true);

    sendMailFromTemplate(8, array(
        "[LANDLORD]",
        "[LANDLORDEMAIL]",
        "[LANDLORDPHONE]",
        "[TENANTFULLNAME]",
        "[TENANTEMAIL]",
        "[TENANTCONTACTNUMBER]",
        "[NATIONALITY]",
        "[GENDER]",
        "[Dateofbirth]",
        "[PROPERTYID]",
        "[BOOKINGID]",
        "[MOVEIN]",
        "[MOVEOUT]",
        "[PROPERTYADDRESS]",
        "[LANDLORDPOLICIES]",
        "[PROPERTYPHOTO]",
        "[LANDLORDEMAIL]",
        "[LANDLORDPHONE]"
            ), array(
        $user_details["fname"] . " " . $user_details["lname"],
        $user_details["email"],
        $user_details["phone"],
        $all_details->firstname,
        $all_details->email,
        $all_details->telephone,
        $all_details->nationality,
        $all_details->gender,
        $all_details->dob,
        $all_details->prop_id,
        $all_details->id,
        $all_details->start_date,
        $all_details->end_date,
        $all_details->address,
        $prop_details->landlord_policies,
        $prop_image,
        $user_details->email,
        $user_details->phone,
            ), $all_details->email, $all_details->telephone, true);
    $toUrl = [];
    $toUrl['LANDLORD'] = $user_details["fname"] . " " . $user_details["lname"];
    $toUrl['BOOKINGID'] = $all_details->id;
    if ($_REQUEST['reply'] == 'yes') {
        $toUrl['name'] = "booking-confirmation";
        confirmBooking($_REQUEST['bookingid'], true);
        //print "Booking Accepted! <a href='/'>Go back to home!</a>";
    } else {
        $toUrl['name'] = "booking-rejection";
        confirmBooking($_REQUEST['bookingid'], false);
        // print "Booking Rejected! <a href='/'>Go back to home!</a>";
    }


    header("Location: cms.php?".    http_build_query($toUrl));
    // die("stope");
}


include("include/header.php");
//print_r($site_settings);exit;
/*******************************new design addition *****************************/
$banner = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_banner` where `id`= 16"));
$banner_mobile = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_banner` where `id`= 19"));
//print_r($banner);exit;
$bannerVideo1 = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_banner` where `id`= 17"));
$bannerVideo2 = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_banner` where `id`= 18"));

$how_it_work = mysqli_query($link,"select * from `how_it_works`");

$home_section = mysqli_query($link,"SELECT * FROM `home_section`");
$home_section_2_one = mysqli_query($link,"SELECT * FROM `home_section_second` ORDER BY `id` ASC limit 2");
$home_section_2_two = mysqli_query($link,"SELECT * FROM `home_section_second` ORDER BY `id` DESC limit 2");

//$information_management = mysqli_query($link,"SELECT * FROM `information_management`");
//print_r($how_it_work);exit;
$home_setting_how = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `home_settings` WHERE `id`=1"));

$parkingplaces = mysqli_query($link,"SELECT `parking`.*,`parking_images`.`image` as `parking_image` FROM `parking` LEFT JOIN `parking_images` on `parking_images`.`parking_id` =`parking`.`id` WHERE `is_popular`=1 ORDER BY `id` DESC limit 8");
$parkinArrayAll = array();
$parkinArray = array();
$count = 0;
while($get_val = mysqli_fetch_object($parkingplaces)){
    //print_r($get_val);
    //echo "----";
    $parkinArrayAll[$count]= $get_val;
    $count++;
}

$parkinArray[0] = array_slice($parkinArrayAll, 0, 4);
$parkinArray[1] = array_slice($parkinArrayAll, 4, 8);
//print_r($parkinArray);

$bannerType = mysql_fetch_object(mysql_query("select * from `estejmam_banner_type` where 1 order by `id` DESC LIMIT 1"));
//print_r($bannerType);exit;
$site_settings = mysql_fetch_object(mysql_query("select * from `estejmam_sitesettings` where `id`='1'"));

if ($bannerType->banner_type == 1) {
    if ($banner->image != '') {
        $banner_image = "upload/sitebanner/" . $banner->image;
    } else {
        $banner_image = "upload/noImageFound.jpg";
    }
} else {
    $banner_image = "upload/video_banner/";
}

if (isset($_REQUEST['refcd']) && $_REQUEST['refcd'] != '') {

    //----------- Social Share Count ---------------//
    //----------- Social Share Count ---------------//
    // echo '<pre>'; print_r($_SERVER); echo '</pre>'; exit;
    $code = $_REQUEST['refcd'];
    $userData = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `onner_code`='" . $code . "'"));
    ?>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function() {
        var substr = window.location.hash.substr(1);
        var id = "<?php echo $userData['id']; ?>";
        $.ajax({
          type: 'POST',
          url: 'agent/ajax_clickCount.php',
          data: {
            id: id,
            string: substr
          },
          success: function(response) {
            console.log(response);
          }
        })
      })
    </script>
    <?php
    //----------- Social Share Count ---------------//
    //----------- Social Share Count ---------------//

    $_SESSION['refcode'] = $_REQUEST['refcd'];
}
?> 
    
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/2P8pIzM7b68" frameborder="0" allow="autoplay; encrypted-media"
                                allowfullscreen></iframe>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/2P8pIzM7b68" frameborder="0" allow="autoplay; encrypted-media"
                                allowfullscreen></iframe>
                    </div>

                </div>
            </div>
        </div>
    
      <section class="baner">
          <div class="baner-img" style="background: url(./upload/sitebanner/<?php echo $banner->image; ?>) no-repeat;">
            <div class="container">
                <div class="baner-text">
                    <h1 class="font-weight-bold"><?php echo $banner->name; ?></h1>
                    <p><?php echo $banner->description; ?></p>
                    <form class="form-inline mt-2 mt-md-0" action="<?php echo SITE_URL; ?>search_list.php" method="GET" name="searchform" id="searchform" class="searchform">
                            <i class="fas fa-search"></i>
                            <input class="form-control" name="location" type="text" placeholder="Try ‘Orlando’" aria-label="Search" id="autocomplete1" onFocus="geolocate()">                      
                            <input type="hidden" name="lat" value=""/>
                            <input type="hidden" name="lon" value=""/>
                            <button class="btn btn-primary search-bt my-2 my-sm-0"type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
      <section class="video py-5">
        <div class="container">

            <div id="carouselExampleIndicators" class="carousel slide video-ban" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>                   
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
                        <div class="row w-100">
                            <div class="col-md-6 baner-text">
                                <h3 class="white-text text-uppercase font-weight-bold"><?php echo $bannerVideo1->name; ?></h3>
                                <p><?php echo $bannerVideo1->description; ?></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="video-img">
                                    <div class="video-icon">
                                        <a href="#" data-toggle="modal" data-target="#exampleModal1">
                                            <img src="images/video-icon.png">
                                        </a>
                        
                        
                                        
                        
                                    </div>
                                    <img src="./upload/sitebanner/<?php echo $bannerVideo1->image; ?>" class="img-fluid">
                                </div>
                                <p class="mt-5 white-text text-uppercase font-13"><?php echo $bannerVideo1->des_trans; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <!-- <img class="d-block w-100" src="..." alt="Second slide"> -->
                        <div class="row w-100">
                            <div class="col-md-6 baner-text">
                                <h3 class="white-text text-uppercase font-weight-bold"><?php echo $bannerVideo2->name; ?></h3>
                                <p><?php echo $bannerVideo2->description; ?></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="video-img">
                                    <div class="video-icon">
                                        <a href="#" data-toggle="modal" data-target="#exampleModal2">
                                            <!--<img src="/upload/sitebanner/<?php echo $bannerVideo1->image; ?>">-->
                                            <img src="images/video-icon.png">
                                        </a>
                        
                        
                                    </div>
                                    <img src="./upload/sitebanner/<?php echo $bannerVideo2->image; ?>" class="img-fluid">
                                </div>
                                <p class="mt-5 white-text text-uppercase font-13"><?php echo $bannerVideo2->des_trans; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
      </section>
    
    <section class="how-it-works container my-5">
      <div class="row">
        <div class="hd">
            <h2><?php echo $home_setting_how->howitworks_title; ?></h2>
            <p><?php echo $home_setting_how->howitworks_description; ?></p>
        </div>
        </div>
        <div class="row">
            <?php while($row = mysqli_fetch_object($how_it_work)){ 
                if ($row->image == '') {
                    $img_how_it_work = './upload/noimage.Jpeg';
                } else {
                    $img_how_it_work = './upload/howitworks/' . $row->image;
                }
                
                ?>
            <div class="col-md-4">
                <div class="how-sec">
                    <img src="<?php echo $img_how_it_work; ?>">
                    <h3><?php echo $row->name ?></h3>
                    <p><?php echo $row->description ?></p>
                </div>
            </div>
            <?php } ?>
      </div>
    </section>

    <section class="blue">
        <div class="container">
            <div class="row">
                <?php while($home = mysqli_fetch_object($home_section)){ 
                    if ($home->image == '') {
                        $img_home = './upload/noimage.Jpeg';
                    } else {
                        $img_home = './upload/homesection/' . $home->image;
                    }
                    ?>
                <div class="col-md-4">
                    <div class="blue-sec">
                       <div class="row">
                           <div class="col-md-3">
                                <img src="<?php echo $img_home; ?>">
                            </div>
                           <div class="col-md-9">
                                <h4 class="white-text"><?php echo $home->name; ?></h4>
                                <p class="font-15"><?php echo $home->description; ?></p>
                            </div>
                       </div>
                    </div>
                </div>
                <?php } ?> 
            </div>
        </div>
    </section>
    <section class="popular my-5">
        <div class="container">
            <h2 class="mb-0">Popular Parkings</h2>
            <?php foreach($parkinArray as $key => $val){ ?>
            <div class="row my-4">
                <?php if(count($val) >=1){
                    foreach($val as $chKey => $chVal){ 
                        
                        if ($chVal->parking_images == '') {
                                if($chVal->image == ''){
                                    $img_parking = './upload/parking.jpg';
                                }else{
                                    $img_parking = './upload/parking/' . $chVal->image;
                                }
                            } else {
                                $img_parking = './upload/parking/' . $chVal->parking_images;
                            }
                        $encoded_id = base64_encode($chVal->id); //print_r($chVal); ?>
                <div class="col-md-3">
                    <a href="<?php echo SITE_URL; ?>details_page.php?data=<?php echo $encoded_id; ?>">
                        <img src="<?php echo $img_parking ?>" class="img-fluid my-2"></a>
                    <p><?php echo $chVal->address; ?></p>
                    <h4><?php echo $chVal->name; ?></h4>
                    <h5> <b><?php if($chVal->currency == "usd"){ ?> $ <?php } ?> <?php echo $chVal->price; ?></b> /<?php echo $chVal->price_rate_type; ?></h5>
                    <p class="rate"><i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                       <i class="fas fa-star"></i>
                    (4.5)</p>
                </div>
                    <?php } } ?>

            </div>
            <?php } ?>
        </div>
    </section>
    
    <section class="parking">
        <div class="container">
            <div class="row my-2">
                <div class="col-md-8 my-5">
                    <h3><?php echo $home_setting_how->parkingspace_title; ?></h3>
                    <div class="row my-4">
                        <?php while($get_sec_two = mysqli_fetch_object($home_section_2_one)){ 
                            if ($get_sec_two->image == '') {
                                $img_home_2 = './upload/noimage.Jpeg';
                            } else {
                                $img_home_2 = './upload/homesection/' . $get_sec_two->image;
                            }
                            ?>
                        <div class="col-md-2">
                            <img src="<?php echo $img_home_2; ?>" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo $get_sec_two->description; ?></h5>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="row my-2">
                        <?php while($get_sec_two_one = mysqli_fetch_object($home_section_2_two)){ 
                            if ($get_sec_two_one->image == '') {
                                $img_home_2_two = './upload/noimage.Jpeg';
                            } else {
                                $img_home_2_two = './upload/homesection/' . $get_sec_two_one->image;
                            }
                            ?>
                        <div class="col-md-2">
                            <img src="<?php echo $img_home_2_two; ?>" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo $get_sec_two_one->description; ?></h5>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dark py-5">
                        <p><?php echo $home_setting_how->parkingspace_description; ?></p>   
                        <?php if($_SESSION['user_id']){ 
                            if($_SESSION['user_type'] == 1){ ?>
                        <button type="button" class="white-button my-3" data-toggle="modal" data-target="#myModal">List a Space</button>
                        <?php }else{ ?>
                        <a class="white-button my-3" href="rent_parking_step1.php">List a Space</a>
                       <?php } }else{ ?>
                        <a href="#" class="white-button my-3" data-toggle="modal" data-target="#exampleModalLong">List a Space</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="parking-zone my-5">
        <div class="container">
            <div class="row">
            <div class="col-md-5">
               
                <img src="./upload/sitebanner/<?php echo $banner_mobile->image; ?>" class="img-fluid">
            </div>
            <div class="col-md-7">
                <h3><?php echo $banner_mobile->name; ?></h3>
                <p><?php echo $banner_mobile->description; ?></p>
                <a href="#"><i class="fab fa-apple"></i> <i class="fab fa-android"></i></a>
            </div>
          </div>
        </div>
    </section>
    
    <section class="business py-5">
        <div class="container">
            <div class="hd">
                <h2 class="my-4"><?php echo $home_setting_how->moreinfo_title; ?></h2>
                <p><?php echo $home_setting_how->moreinfo_description; ?></p>
                <a class="btn-primary my-2" href="<?php if($_SESSION['user_id']){ ?>javascript:void(0) <?php }else{ ?>business_owner.php <?php } ?>" style="display:inline-block">More Information</a>
            </div>
        </div>
    </section>    

      <?php
include("include/footer.php");
?>

      <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        var placeSearch, autocomplete1;
        var componentForm = {
          //street_number: 'short_name',
          //route: 'long_name',
          //locality: 'long_name',
          //administrative_area_level_1: 'long_name',
          //country: 'long_name',
          //postal_code: 'short_name'
        };

        function initAutocomplete() {

          /*autocomplete1 = new google.maps.places.Autocomplete(
           (document.getElementById('autocomplete1')),
           {types: ['geocode']});

           autocomplete1.addListener('place_changed', fillInAddress);*/

          
           autocomplete1 = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete1')),
                    {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete1.addListener('place_changed', fillInAddress);
        }



        function fillInAddress() {

          // Get the place details from the autocomplete object.
          var place = autocomplete1.getPlace();

          $('input[name="lat"]').val(place.geometry.location.lat());
          $('input[name="lon"]').val(place.geometry.location.lng());

        }

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete1.setBounds(circle.getBounds());
                });
            }
//          if (navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition(function(position) {
//              var geolocation = {
//                lat: position.coords.latitude,
//                lng: position.coords.longitude
//              };
//              var circle = new google.maps.Circle({
//                center: geolocation,
//                radius: position.coords.accuracy
//              });
//              autocomplete1.setBounds(circle.getBounds());
//            });
//          }
        }
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY " async defer type="text/javascript"></script><!--

      <script>
        function submitForm() {
          $("#searchform").submit();
        }


        var video = document.getElementById('video');
        video.addEventListener('click', function() {
          video.play();
        }, false);
      </script>
      <script src="//vjs.zencdn.net/5.19.2/video.js"></script>-->
      </body>

      </html>
