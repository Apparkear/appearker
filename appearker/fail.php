<?php
ob_start();
session_start();
include 'administrator/includes/config.php';
include("class.phpmailer.php");
require('Twilio.php');
date_default_timezone_set('UTC');

$getSymbolNRate = curencyrateAndSymbol();

$convertionRate = $getSymbolNRate['rate'];
$symbol = $getSymbolNRate['symbol'];
$countryCode = $getSymbolNRate['country'];
// $f=fopen("paypal.txt",'a+');
// $data=var_export($_SESSION, true);
// fwrite($f, $data);
// fclose($f);
// $logo = mysql_fetch_object(mysql_query("select * from `estejmam_sitesettings` where `id`='1'"));
if ($_REQUEST['suc'] == 'success') {
    $latid = $_SESSION['last_id'];
    $propertyId = $_SESSION['property_id'];

    $tranid = $_REQUEST['txn_id'];
    // $sql = mysql_query("update `estejmam_booking` set `status`=0,`payment_type`= 'PP',`transaction_id`='" . $tranid . "' where `id`='" . $latid . "'");


}else {

    if ($_REQUEST['custom'] != '') {
        $coustom = explode('|', $_REQUEST['custom']);
        $latid = $coustom[0];
        $propertyId = $coustom[1];
    } else {
        $latid = $_SESSION['last_id'];
        $propertyId = $_SESSION['property_id'];
    }


    $tranid = $_REQUEST['txn_id'];
    // $sql = mysql_query("update `estejmam_booking` set `status`=0,`payment_type`= 'PP',`transaction_id`='" . $tranid . "' where `id`='" . $latid . "'");
}

unset($_SESSION['discountprice']);


$adminSetting   = mysql_fetch_object(mysql_query("select * from `estejmam_tbladmin` where `id`='1'"));
$all_details    = mysql_fetch_object(mysql_query("select * from `estejmam_booking` where `id`='" . $latid . "'"));
$prop_details   = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where `id`='" . $all_details->prop_id . "'"));
$user_details   = mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id`='" . $prop_details->user_id . "'"));

$email = $_SESSION['email'];




if (!isset($propertyId) && $propertyId == '') {
    $prop_id = $propertyId;
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $fees = $_REQUEST['sendfees'];
    $totals = $_REQUEST['sendtotal'];
    $type_of_contract = $_REQUEST['type_of_contract'];
    $maxstay = $_REQUEST['maxstay'];
    $minstay = $_REQUEST['numofdays'];


    $_REQUEST['custom'] = $prop_id;
    $_SESSION['start_date'] = $start_date;
    $_SESSION['end_date'] = $end_date;
    $_SESSION['sendfees'] = $fees;
    $_SESSION['sendtotal'] = $totals;
    $_SESSION['type_of_contract'] = $type_of_contract;
    $_SESSION['maxstay'] = $maxstay;
    $_SESSION['minstay'] = $minstay;
    $_SESSION['user_id'] = 0;
} else {
    //$_REQUEST['custom'] = $_REQUEST['custom'];
    $_SESSION['start_date'] = $_SESSION['start_date'];
    $_SESSION['end_date'] = $_SESSION['end_date'];
    $_SESSION['sendfees'] = $_SESSION['sendfees'];
    $_SESSION['sendtotal'] = $_SESSION['sendtotal'];
    $_SESSION['type_of_contract'] = $_SESSION['type_of_contract'];
    $_SESSION['maxstay'] = $_SESSION['maxstay'];
    $_SESSION['minstay'] = $_SESSION['minstay'];
    $_SESSION['user_id'] = $_SESSION['user_id'];
}


$logo = mysql_fetch_object(mysql_query("select * from `estejmam_sitesettings` where `id`='1'"));
$propdetails = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where `id` = '" . $propertyId . "'"));
$image_details = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $propertyId . "' LIMIT 1"));

if ($image_details->image != '') {
    $image = "upload/property/" . $image_details->image;
} else {
    $image = "upload/noImageFound.jpg";
}

// var_dump($propertyId);
// var_dump($image_details);
// var_dump($propdetails);
// die("STOP");


if ($propdetails->type_of_contract == 1) {
    $type_of_contract = "Monthly";
}
if ($propdetails->type_of_contract == 2) {
    $type_of_contract = "Fortnightly";
}
if ($propdetails->type_of_contract == 3) {
    $type_of_contract = "Daily";
}
?>

<?php

    $getSymbolNRate = curencyrateAndSymbol();
    $convertionRate = $getSymbolNRate['rate'];
    $symbol = $getSymbolNRate['symbol'];
    $countryCode = $getSymbolNRate['country'];
    $currencyCode = $getSymbolNRate['currencyCode'];

if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];

    $statictext = json_decode(file_get_contents('lang/' . $lang . '.json'));
} else {
    $statictext = json_decode(file_get_contents('lang/en.json'));
    $lang == 'en';
}

?>







<!DOCTYPE HTML>
<html>
    <head>
        <title>ROOMARATE</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
         <meta property="og:image" content="https://www.roomarate.com/images/sitescreenshot.png" />
        <!-- Add custom CSS here -->
        <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/ionicons.css" rel="stylesheet">
        <link href="css/jquery.bxslider.css" rel="stylesheet">
        <style>
        	@media (max-width:320px) {
				 .navbar-brand img{ width: 190px!important; }
			}
        </style>

        <!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/3410365.js"></script>
<!-- End of HubSpot Embed Code -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '608981985933006', {
em: 'insert_email_variable,'
});
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=608981985933006&ev=PageView&noscript=1"
/></noscript>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100328478-1', 'auto');
  ga('send', 'pageview');

</script>
<link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="/anifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


    </head>
    <body>
        <!--<div class="l-main-menu">
                <div class="search-menu">
                        <nav class="menu menu-mobile-disabled">
                                <div class="menu_toggle"></div>
                                <div class="menu_items">
                                        <div class="menu_items-main-top">
                                                <ul>
                                                        <li><a class="" href=""><i class="ion-android-checkbox-outline"></i></a></li>
                                                        <li><a class="" href=""><i class="ion-ios-location-outline"></i> <span>Explore</span></a></li>
                                                        <li><a class="" href=""><i class="ion-help-buoy"></i> <span>how it works</span></a></li>
                                                        <li><a class="" href=""><i class="ion-ios-heart-outline"></i> <span>favorites</span></a></li>
                                                </ul>
                                        </div>
                                        <div class="menu_items-secondary-bottom">
                                                <ul>
                                                        <li><a class="" href="">English <i class="fa fa-angle-down"></i></a></li>
                                                        <li><a class="" href="">Blog</a></li>
                                                        <li><a class="" href="">About us</a></li>
                                                </ul>
                                        </div>
                                </div>
                        </nav>
                </div>
        </div>-->
        <nav class="navbar navbar-default" role="navigation" style=" padding: 10px 0;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
                    <a class="navbar-brand" target="_parent" href="index.php"><img src="<?php echo SITE_URL ?>images/logo_black.svg" style="width: 230px;"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right nav-part">

                        <li><a style="color: #818080;" target="_parent" href="<?php echo SITE_URL ?>help.php"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;Help</a></li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>





        <div class="l-main-section" style="padding-left: 0">
            <div class="l-property-body">

                <div class="row">
                    <div class="col-md-3">

                        <!-- <ul class="prod-listing">
                            <li style="width: 95%; margin-top: 0">
                                <a href="" class="total-wrapper">
                                    <div class="product-image">
                                        <img src="<?php echo $image ?>" alt="">
                                        <div class="rent-price">
                                            <b>
                                                <?php
                                                    if($countryCode!='GB') {
                                                        echo $symbol .' '. $propdetails->price*$convertionRate;
                                                    } else {
                                                        echo $symbol .' '. $propdetails->price;
                                                    }
                                                ?>
                                            </b>
                                            <span>month</span>
                                        </div>
                                    </div>
                                    <div class="product-info" style="border-bottom: 2px solid #ff4d55">
                                        <h4><?php echo $propdetails->name ?></h4>
                                        <?php
                                        $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($propdetails->amenities) order by `id` DESC limit 4");
                                        while ($amenities = mysql_fetch_object($amm)) {
                                            ?>
                                            <div class="icon-holder"><span><img src="upload/amentiesimage/<?php echo $amenities->img ?>" alt=""></span><?php echo $amenities->name ?></div>
                                        <?php } ?>
                                        <div class="clearfix"></div>

                                    </div>
                                </a>
                            </li>
                        </ul> -->
                        <div id="divshowresult">
                                <div id="myList">
                                    <?php
                                        $totalprop = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where  `id`='" .$_SESSION['prop_id']. "'"));
                                    ?>
                                            <div class="marker search-list-box" id="map_<?php echo $totalprop->id; ?>" onmouseleave="removeBounce('<?php echo $totalprop->id; ?>')" onmouseover="toggleBounce('<?php echo $totalprop->id; ?>')" style='width:100% !important;'>
                                                <div id="carousel-example-generic-<?php echo $totalprop->id; ?>" class="carousel slide mapcls" data-ride="carousel">
                                                    <!-- Indicators -->
                                                    <ol class="carousel-indicators" style="display:none" >
                                                        <li data-target="#carousel-example-generic-<?php echo $totalprop->id; ?>" data-slide-to="0" class="active"></li>
                                                        <li data-target="#carousel-example-generic-<?php echo $totalprop->id; ?>" data-slide-to="1"></li>
                                                        <li data-target="#carousel-example-generic-<?php echo $totalprop->id; ?>" data-slide-to="2"></li>
                                                    </ol>

                                                    <!-- Wrapper for slides -->
                                                    <div class="carousel-inner sendToDetails" data-slug="<?php echo $totalprop->slug; ?>" data-check-in="<?php echo $_GET['check_in']; ?>" data-check-out="<?php echo $_GET['check_out']; ?>" style="cursor: pointer;"  role="listbox">
                                                        <?php
                                                        $sCount = 1;
                                                        $image = mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $_SESSION['prop_id'] . "' LIMIT 5");
                                                        while ($image_details = mysql_fetch_object($image)) {
                                                            // if ($image_details->image != '') {
                                                            $picture = "upload/property/" . $image_details->image;
                                                            // } else {
                                                            // $image = "upload/noImageFound.jpg";
                                                            // }
                                                            ?>
                                                            <div class="item <?php
                                                            if ($sCount == 1) {
                                                                echo 'active';
                                                            }
                                                            ?>" style="background: url('<?php echo $picture; ?>') no-repeat center center; background-size:cover;height:157px; width: 100%" >
                                                                <!-- <img style="height:157px; width: 281px;" src="<?php echo $picture; ?>" alt=""/> -->
                                                                <div class="rent-price-b"> <b>
                                                                        <?php
                                                                        if ($countryCode != 'GB') {
                                                                            echo $symbol . ' ' . $totalprop->price * $convertionRate;
                                                                        } else {
                                                                            echo $symbol . ' ' . $totalprop->price;
                                                                        }
                                                                        ?></b>
                                                                    <span> / <?php echo $totalprop->durationtime; ?></span>
                                                                </div>
                                                                <!--<div class="favorite-icon">
                                                                          <i class="ion-android-favorite"></i>
                                                                </div>-->
                                                            </div>
                                                            <?php
                                                            $sCount++;
                                                        }
                                                        ?>
                                                        <div class="category-slide-text-area">
                                                            <h4 style="margin-left: 13px;" > <?php echo $totalprop->name; ?>    </h4>
                                                            <?php
                                                            $amm = mysql_query("select * from `estejmam_amenities` where `id` IN($totalprop->amenities) order by `id` DESC limit 4");
                                                            while ($amenities = mysql_fetch_object($amm)) {
                                                                // print_r($amenities->name);
                                                                ?>
                                                                <div class="icon-holder" style="margin-right: 8px; margin-left: 22px;" >
                                                                    <span style="margin-right:-1px;" ><img style="margin-left:-10px;" src="upload/amentiesimage/<?php echo $amenities->img ?>" alt=""></span>
                                                                    <?php echo ($lang != 'en') ? $amenities->{name.'_'.$lang} : $amenities->name; ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <!-- Controls -->
                                                    <a style="background: none;" class="left carousel-control" href="#carousel-example-generic-<?php echo $totalprop->id; ?>" role="button" data-slide="prev">
                                                        <span style="margin-top:-75px" class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                        <span class="sr-only"><?php echo $statictext->previous ?></span>
                                                    </a>
                                                    <a style="background: none;" class="right carousel-control" href="#carousel-example-generic-<?php echo $totalprop->id; ?>" role="button" data-slide="next">
                                                        <span style="margin-top:-75px" class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                        <span class="sr-only"><?php echo $statictext->next ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                </div>
                            </div>

                        <div class="description-holdr bookings">
                            <h3>More information</h3>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="book_in">
                                        Move in
                                    </p>
                                    <p class="book_in_date">
                                        <?php echo $_SESSION['start_date'] ?>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="book_out">
                                        Move out
                                    </p>
                                    <p class="book_out_date">
                                        <?php echo $_SESSION['end_date'] ?>
                                    </p>
                                </div>
                            </div>

                        </div>



                        <div class="description-holdr bookings">
                            <h3>Your payment</h3>
                            <div class="row">

                                <div class="col-sm-8">
                                    <p class="book_in_date">
                                        First month's rent
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="book_in_date">
                                        <!-- $<?php echo $propdetails->price ?> -->
                                        <?php
                                            if($countryCode!='GB') {
                                                echo $symbol .' '. $propdetails->price*$convertionRate;
                                            } else {
                                                echo $symbol .' '. $propdetails->price;
                                            }
                                        ?>
                                    </p>
                                </div>

                                <div class="col-sm-8">
                                    <p class="book_in_date">
                                        Booking fee
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="book_in_date">
                                        <!-- $<?php echo number_format($_SESSION['sendfees'], 2) ?> -->
                                        <?php
                                            if($countryCode!='GB') {
                                                echo $symbol .' '. number_format($_SESSION['sendfees'], 2)*$convertionRate;
                                            } else {
                                                echo $symbol .' '. number_format($_SESSION['sendfees'], 2);
                                            }
                                        ?>
                                    </p>
                                </div>

                                <div class="col-sm-8">
                                    <p class="book_in_date">
                                        Total
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="book_in_date">
                                        <b><!-- $<?php echo number_format($_SESSION['sendtotal'], 2) ?> -->
                                            <?php
                                                if($countryCode!='GB') {
                                                    echo $symbol .' '. number_format($_SESSION['sendtotal'], 2)*$convertionRate;
                                                } else {
                                                    echo $symbol .' '. number_format($_SESSION['sendtotal'], 2);
                                                }
                                            ?>
                                        </b>
                                    </p>
                                </div>

                                <!-- <div class="col-sm-8">
                                    <p class="book_in_date">
                                        <a href="#" style="color: #ff4d55;">What is this?</a>
                                    </p>
                                </div> -->

                            </div>

                        </div>


                        <div class="description-holdr bookings">
                            <h3>Your payment</h3>
                            <div class="row">

                                <div class="col-sm-8">
                                    <p class="book_in_date">
                                        Contract type
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="book_in_date">
                                        <?php echo $type_of_contract ?>
                                    </p>
                                </div>

                                <!-- <div class="col-sm-8">
                                    <p class="book_in_date">
                                        <a href="#" style="color: #ff4d55;">What is this?</a>
                                    </p>
                                </div> -->

                            </div>

                        </div>

                        <!--								<div class="description-holdr grey">
                        -->

                        <div class="we-accept" style="margin-top: -10px;">
                            <p>We accept: <span><img src="images/master-card.jpg" alt=""></span> <span><img src="images/visa.jpg" alt=""></span> <span><img src="images/paypal.jpg" alt=""></span></p>
                        </div>

                    </div>

                    <div class="col-md-9">


                        <div class="room-description c-success" style="">
                            <!-- <div class="steps_booking text-center">
                                <ul style="padding: 0">
                                    <li class="active"><span>1</span> <p>Application</p></li>
                                    <li class="active"><span>2</span> <p>Payment</p></li>
                                    <li class="active"><span>3</span> <p>Done</p></li>
                                </ul>
                            </div> -->
                            <div class="c-success__checkmark-circle">
                              <div class="c-success__background"></div>
                              <div class="c-success__checkmark draw"></div>
                            </div>


                            <p class="c-success__text">Payment request done!</p>
                            <!-- <p style="float: left; text-align:center;width:100%;">
                                <img src="images/success-2.png" class="img-responsive" style="margin: 25px auto;" />
                            </p> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) {

    ?>



    <!--<section class="partner">

        <div class="container">

            <ul>



                <?php

                $part = mysql_query("select * from `estejmam_partners` where 1 order by `id` DESC LIMIT 4");

                if (mysql_num_rows($part) > 0) {

                    while ($allpartner = mysql_fetch_object($part)) {



                        if ($allpartner->logo != '') {

                            $client_image = "upload/userimages/" . $allpartner->logo;

                        } else {

                            $client_image = "upload/noImageFound.jpg";

                        }

                        ?>



                        <li onclick="location.href = '<?php echo $allpartner->link; ?>'"><span class="helper"></span><img src="<?php echo $client_image; ?>" alt="" /></li>



                        <?php

                    }

                }

                ?>

            </ul>

        </div>

    </section>-->

    <?php

}

$fb = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='1'"));

$tw = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='2'"));

$ytube = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='3'"));

$pinterest = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='31'"));

$vk = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='32'"));

$insta = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='33'"));

?>

<footer>

    <section class="footer_top">

        <div class="container">

            <ul>

                <li><a href="<?php echo $fb->link; ?>" class="fa fa-facebook" target="_blank"></a></li>

                <li><a href="<?php echo $tw->link; ?>" class="fa fa-twitter" target="_blank"></a></li>

                <li><a href="<?php echo $ytube->link; ?>" class="fa fa-youtube" target="_blank"></a></li>

                <li><a href="<?php echo $insta->link; ?>" class="fa fa-instagram" target="_blank"></a></li>

            </ul>

        </div>

    </section>

    <section class="footer_bottom">

        <div class="container">

            <div class="row">



                <?php

                $fcat = mysql_query("select * from `estejmam_footer_category` where id = 1");

                if (mysql_num_rows($fcat) > 0) {

                    while ($allfcat = mysql_fetch_object($fcat)) {

                        ?>

                        <div class="col-md-2">

                            <b><?php echo $allfcat->name; ?></b>

                            <?php

                            $sub = mysql_query("select * from `estejmam_cms` where `footer_category_id`='" . $allfcat->id . "' and `status`=1 order by `id` ASC limit 4" );

                            while ($sub1 = mysql_fetch_object($sub)) {

                                ?>

                                <a onclick="location.href = 'cms.php?name=<?php echo $sub1->slug ?>'" style="cursor:pointer;"><?php echo $sub1->title ?></a>

                            <?php } ?>

                            <a onclick="location.href = 'cms.php?name=how-it-works'" style="cursor:pointer;">How It Works</a>

                            <a onclick="location.href = 'contact_us.php'" style="cursor:pointer;">Contact Us</a>

                        </div>



                        <?php

                    }

                }

                ?>



                <?php

                $fcat2 = mysql_query("select * from `estejmam_footer_category` where id = 2");

                if (mysql_num_rows($fcat2) > 0) {

                    while ($allfcat2 = mysql_fetch_object($fcat2)) {

                        ?>

                        <div class="col-md-2">

                            <b><?php echo $allfcat2->name; ?></b>

                            <a onclick="location.href = 'landlord.php'" style="cursor:pointer;">Publish Your Property</a>

                            <a onclick="location.href = 'search-listing.php?cities=&check_in=&check_out='" style="cursor:pointer;">Find a Room</a>

                            <?php

                            $sub2 = mysql_query("select * from `estejmam_cms` where `footer_category_id`='" . $allfcat2->id . "' and `status`=1 order by `id` DESC");

                            while ($sub3 = mysql_fetch_object($sub2)) {

                                ?>

                                <a onclick="location.href = 'cms.php?name=<?php echo $sub3->slug ?>'" style="cursor:pointer;"><?php echo $sub3->title ?></a>

                            <?php } ?>

				<a onclick="location.href = 'agent/index.php'" style="cursor:pointer;">Work With Us</a>

                            <a onclick="location.href = 'help.php'" style="cursor:pointer;">FAQ</a>

                        </div>

                        <?php

                    }

                }

                ?>

				<div class="col-md-5">

					<div class="phoneGroup">

	        				<ul>

	        					<li>

	        						<a>

	        							<i class="flag flag-uk"></i>

	        							<span>+44</span>20-3856-4546</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-us"></i>

	        							<span>+1</span>518-282-0574</a>

	        					</li>

	        					<li>

	        						<a href="tel:+55-11-3181-9820">

	        						<i class="flag flag-br"></i>

	        							<span>+55</span>11-3181-9820</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-au"></i>

	        							<span>+61</span>2-8017-2637</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-jp"></i>

	        							<span>+81</span>3-4510-8224</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-it"></i>

	        							<span>+39</span>06-9480-1653</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-pt"></i>

	        							<span>+81</span>308-808-373</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-cn"></i>

	        							<span>+86</span>21-8024-5953</a>

	        					</li>

	        					<li>



	        						<a>

	        						<i class="flag flag-hk"></i>

	        							<span>+852</span>5803-9390</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-my"></i>

	        							<span>+60</span>3-8408-1162</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-se"></i>

	        							<span>+46</span>10-138-84-03</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-fi"></i>

	        							<span>+358</span>75-3263820</a>

	        					</li>

	        					<!--<li>

	        						<a>

	        						<i class="flag flag-fr"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-es"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-sg"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-no"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-dk"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>

	        					<li>

	        						<a>

	        						<i class="flag flag-de"></i>

	        							<em>Processing</em>

	        						</a>

	        					</li>-->

	        				</ul>

	        			</div>

				</div>



                <div class="col-md-3">

                    <!--<b>English</b>-->

                    <button class="btn" onclick="location.href = 'help.php'"><?php echo $logo->footer_button_text ?></button>

                    <p><?php echo $logo->footer_help_center ?><br/>

                        <?php echo $logo->footer_coustomer_support_text ?><br/>

                        <?php echo $logo->site_phone ?><br/>
                        Customer Number<br />
                        10216368 (England & Wales)
                        <a href="mailto:<?php echo $logo->site_email ?>"><?php echo $logo->site_email ?></a>

                    </p>

                    <div class="trust-pilot">

						<span class="trust-image"><img src="images/trustpilot2.png" alt=""/></span>

						<div class="star-holder">

							<span class="star"><i class="fa fa-star"></i></span>

							<span class="star"><i class="fa fa-star"></i></span>

							<span class="star"><i class="fa fa-star"></i></span>

							<span class="star"><i class="fa fa-star"></i></span>

							<span class="star grey-bg">

								<div class="top-bg"></div>

								<i class="fa fa-star"></i>



							</span>

						</div>

					</div>

                </div>

            </div>

        </div>

    </section>

    <section class="copy_right">

        <div class="container">

            <div class="row">

                <div class="col-md-3 ">

                    <p>©2017 Roomarate — All rights reserved</p>

                    <!-- <span>Design & Developed by: NatIt Solved Pvt. Ltd.</span> -->

                </div>

                <div class="col-md-9 ">
		    <div class="pull-right">
                    <!--<img src="upload/payment_logo/<?php //echo $paymentlogo->image ?>" alt="" class="pull-right"/>-->
		    <!-- Begin ScanVerify Seal Code -->
<script src='https://scanverify.com/javascript.js'> </script>
<a target=_blank href="https://scanverify.com/siteverify.php?ref=stp&site=https://www.roomarate.com" style="display: inline-block;
    height:39px;
    overflow: hidden;width: 90px; margin-right: 7px;">
<img src='https://scanverify.com/seal/seal.php?site=https://www.roomarate.com' border=0 ALT='ScanVerify.com Trust Seal' class="highsucIng" style="height:50px;"></a>
<!-- End ScanVerify Seal Code -->
<!-- Begin Good Business Commission Seal Code -->
<script src='https://www.goodbusinesscomm.com/javascript.js'> </script>
<a target=_blank href="https://www.goodbusinesscomm.com/siteverify.php?ref=stp&site=https://www.roomarate.com" style="display: inline-block;
    height:39px;
    overflow: hidden;width: 90px; margin-right: 7px;">
<img src='images/gb.png' border=0 ALT='GoodBusinessComm.com Trust Seal' class="highsucIng" style="height:50px;"></a>

<!-- End Good Business Commission Seal Code -->
<img src='https://community.norton.com/en/system/files/u1537183/NSec_SYM_MKTG_RGB.png
' border=0 ALT='Nortone Security' class="highsucIng" >
                    <img src="upload/payment_logo/payment.png" alt="" class="pull-right"/>
		    </div>
                </div>
            </div>

        </div>

    </section>

</footer>
<?php
//session_destroy();
// unset($_SESSION['last_id']);
// unset($_SESSION['property_id']);
// unset($_SESSION['sendtotal']);
// unset($_SESSION['start_date']);
// unset($_SESSION['start_date']);
// unset($_SESSION['end_date']);
// unset($_SESSION['sendfees']);
?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/formValidation.js"></script>



<script>
    $('.bxslider2').bxSlider({
        pager: false,
    });
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.navbar-fixed-top').css('background', 'rgba(0,0,0,.8)');
        }
        else {
            $('.navbar-fixed-top').css('background', 'none');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('#more-filter').click(function () {
            $('.extra-filter').slideToggle('slow');
        });
        $('#ex1').slider({
            formatter: function (value) {
                return 'Current value: ' + value;
            }
        });
    });
</script>

</body>
</html>
