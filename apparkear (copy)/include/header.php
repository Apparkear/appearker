<?php
//ob_start();
//session_start();
require_once("administrator/includes/config.php");

$logo = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_sitesettings` where `id`='1'"));
$information_management = mysqli_query($link,"SELECT * FROM `information_management`");

//print_r($information_management);


//print_r($logo);exit;
$fb = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='1'"));
$tw = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='2'"));
$ytube = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='3'"));
$pinterest = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='31'"));
$vk = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='32'"));
$insta = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='33'"));

$paymentlogo = mysql_fetch_object(mysql_query("select * from `estejman_payment_logo` where 1 order by `id` DESC LIMIT 1"));
?>

<?php
// if (isset($_SESSION['lang'])) {
//     $lang = $_SESSION['lang'];
//     $statictext = json_decode(file_get_contents('lang/' . $lang . '.json'));
// } else {
//     $_SESSION['lang'] = 'en';
//     $lang = $_SESSION['lang'];
//     $statictext = json_decode(file_get_contents('lang/' . $lang . '.json'));
// }
if (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
} else {
  $_SESSION['lang'] = 'en';
  $lang = $_SESSION['lang'];
}

$slug = $_GET['name'];
if(strrpos($_SERVER['SCRIPT_NAME'], 'cms.php'))
{
    if (substr ( $_GET['name'], - 1, 1 ) == '/') $_GET['name'] = substr ( $_GET['name'], 0, - 1 );
    $slug = mysql_real_escape_string($_GET['name']);
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE slug ='". $slug. "'"));
    if(!$cmspageDetails){
        header("HTTP/1.0 404 Not Found");
        header("Location: ".SITE_URL."404/");
    }
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'contact_us'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE slug ='contact-us'"));
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'help.php'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE slug ='help'"));
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'guarantee'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id ='57'"));
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'landloard_faq'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id ='58'"));
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'landlord_new'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id ='60'"));
}elseif(strrpos($_SERVER['SCRIPT_NAME'], 'blog'))
{
    $cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id ='59'"));
}


if($cmspageDetails)
{
    if($cmspageDetails->meta_title)$seo_title=strip_tags(stripslashes($cmspageDetails->meta_title));
    if($cmspageDetails->meta_description)$seo_metadescription=strip_tags(stripslashes($cmspageDetails->meta_description));
    if($cmspageDetails->meta_keywords)$seo_metakeywords=strip_tags(stripslashes($cmspageDetails->meta_keywords));
}
?>
    <!DOCTYPE HTML>
    <html lang="en">

    <head>
      <title>
        <?php if($seo_title) echo $seo_title; else echo "Apparkear";?>
      </title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../favicon.ico">
      <title>Apparkear</title>
      <!-- Bootstrap core CSS -->
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
       <link href="fonts/stylesheet.css" rel="stylesheet">
<!--      <link href="css/bootstrap.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- <link href="css/bootstrap-datetimepicker.css" rel="stylesheet"> -->
        <link href="css/datepicker.css" rel="stylesheet">
      <!-- Custom styles for this template -->
	  <link href="css/style.css" rel="stylesheet">
	  <link href="css/style_extra.css" rel="stylesheet">
      <!-- Custom fonts for this template -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
      <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
      <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
      <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css" rel="stylesheet"/>
        <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel="stylesheet"  media="print" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>


      <script src="js/formValidation.js"></script>

      <style>
          .gplussignin{
              border: #000 solid 1px;
              color: #000;
          }
          .error-log{
              color: red;
                margin-top: 62px;
                background: #97e497;
                /*padding: 10px;*/
                color: black;
                text-align: center;
                font-size: 21px;
          }
      </style>



<!--      <meta charset="UTF-8">
      <base href="<?php echo SITE_URL;?>" />
      <link rel="icon" type="image/x-icon" href="favicon-32x32.png" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
      <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
       Add custom CSS here
      <link href="css/normalize.css" rel="stylesheet" type="text/css">
      <link href="css/datepicker.css" rel="stylesheet" type="text/css">
      <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="include/bootstrap-slider-master/css/bootstrap-slider.min.css" rel="stylesheet" type="text/css">-->



    </head>

    <body>
        <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
<!--        <h4 class="modal-title">Modal Header</h4>-->
      </div>
      <div class="modal-body">
          <ul>
              <li class="nav-link" style="font-size: 16px;color: #3e25e3 !important;padding: .5rem 1rem;">Sorry You are not able to see the list</li>
          </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

        <nav class="navbar navbar-expand-lg navbar-light fixed-top top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo SITE_URL; ?>"><img src="./upload/site_logo/<?php echo $logo->sitelogo; ?>"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <!--<a class="nav-link" href="explore.php">Explore</a>-->
                            <a class="nav-link" href="search_list.php?location=&lat=&lon=">Explore</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="help.php">Help Center</a>
                        </li>
                        <?php if($_SESSION['user_id']){

                            $get_image_name = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`=".$_SESSION['user_id']));
                            if($get_image_name->image != ""){
                                $image_logggedin = './upload/user_image/'.$get_image_name->image;
                            }else{
                                $image_logggedin = "./upload/nouser.png";
                            }

                            ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $image_logggedin; ?>" class="mr-1"><?php echo $_SESSION['login_username']; ?></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item d-flex align-items-center" href="favorite.php"> <i class="fas fa-angle-right pr-2"></i> Favorites</a>
                                <a class="dropdown-item d-flex align-items-center" href="feature.php"> <i class="fas fa-angle-right pr-2"></i> Featured</a>
                                <a class="dropdown-item d-flex align-items-center" href="message_list.php"> <i class="fas fa-angle-right pr-2"></i> Inbox</a>
                                <?php if($_SESSION['user_type'] == 0){ ?>
                                    <a class="dropdown-item d-flex align-items-center" href="editprofile.php"> <i class="fas fa-angle-right pr-2"></i> Profile</a>
                                <?php }else{ ?>
                                    <a class="dropdown-item d-flex align-items-center" href="renter_edit_profile.php"> <i class="fas fa-angle-right pr-2"></i> Profile</a>
                                    <a class="dropdown-item d-flex align-items-center" href="booking_history.php"> <i class="fas fa-angle-right pr-2"></i> My Booked Parking Lots</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"> <i class="fas fa-angle-right pr-2"></i> Credit & Coupon</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"> <i class="fas fa-angle-right pr-2"></i> Payment Method</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"> <i class="fas fa-angle-right pr-2"></i> Settings</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"> <i class="fas fa-angle-right pr-2"></i> My Rating</a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"> <i class="fas fa-angle-right pr-2"></i> My Car Details</a>
                                    <a class="dropdown-item d-flex align-items-center" href="renter_payment_list.php"> <i class="fas fa-angle-right pr-2"></i> Payment List</a>
                                <?php } ?>
                                <a class="dropdown-item d-flex align-items-center" href="logout.php"> <i class="fas fa-angle-right pr-2"></i> Logout</a>
                            </div>
                        </li>

                        <?php }else{ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModalLong">Log In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#register-modal">Register</a>
                            </li>

                        <?php } ?>
                            <?php $all = explode('/',$_SERVER['REQUEST_URI']); $total = count($all);  $page_name = $all[$total-1]; ?>
                        <?php  //if(($page_name != 'change_password.php') || ($page_name != 'editprofile.php')){ echo $page_name;
                            if(($page_name == 'message_list.php') || ($page_name == 'booking_history.php') || ($page_name == 'change_password.php') || ($page_name == 'editprofile.php') || ($page_name == 'my_properties.php') || ($page_name == 'dashboard_user.php') || ($page_name == 'review_user.php')){ //echo $page_name;


                                ?>


                        <?php  }else{ //if($_SESSION['user_type'] == 1){  ?>

                            <?php if($_SESSION['user_id']){
                            if($_SESSION['user_type'] == 1){ ?>
                            <button class="btn btn-primary my-2 my-sm-0" type="button" data-toggle="modal" data-target="#myModal">Add Listing</button>
                            <?php }else{ ?>
                            <a class="btn btn-primary my-2 my-sm-0 add_listing" href="javascript:void(0)">Add Listing</a>
                            <?php } }else{ ?>
                            <a class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#exampleModalLong">Add Listing</a>
                            <?php  } ?>
                        <?php //}

                        } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo strtoupper($lang); ?></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a href="#googtrans(en|en)" class="dropdown-item lang-en lang-select" data-lang="en">EN</a>
                                <a href="#googtrans(en|es)" class="dropdown-item lang-es lang-select" data-lang="es">ES</a>
<!--                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>-->
                            </div>
                        </li>

                        <li class="nav-item">
                          <?php if($_SESSION['user_id']){
                            if($_SESSION['user_type'] == 1){ ?>
                            <a class="nav-link switchUser" rel="0" href="javascript:void(0)">Switch to Owner</a>
                            <?php }else{ ?>
                            <a class="nav-link switchUser" rel="1" href="javascript:void(0)">Switch to Renter</a>
                            <?php } 
                            } ?>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog log-in-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase text-center w-100" id="exampleModalLongTitle">LOGIN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <a href="javascript:void(0)" class="fbsignup btn btn-block btn-fb d-flex align-items-center justify-content-center"><i class="fab fa-facebook-f"></i>Connect With Facebook </a>
                        <a href="javascript:void(0)" class="gplussignin btn btn-block btn-google d-flex align-items-center justify-content-center link_btn"> <img src="<?php echo SITE_URL; ?>images/google.png">Connect With Google </a>
                        <p class="or-line">or</p>


                        <form name="UserLoginForm" id="UserLoginForm" action="javascript:void(0);" method="post">
                            <div class="error-set" style="color:red"></div>
                            <div class="form-group">
                                <label>Email Address *</label>
                                <input type="text" class="form-control" name="email_add" id="email_add" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" required="1">
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input type="password" class="form-control" name="pass" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required="1">
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label class="text-grey">
                                        <input type="checkbox" name="remember" id="remember" value="1">Remember me
                                    </label>
                                </div>
                                <div class="col-6">
                                    <a class="text-right d-block link_btn" href="<?php echo SITE_URL; ?>forgot_password.php">Forgot Password</a>
                                </div>
                            </div>
                            <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                            <input type="hidden" name="curr_url" id="curr_url" value="<?php echo $actual_link; ?>">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary text-uppercase login-form-submit-btn">Login</button>
                            </div>
                            <h5 class="text-center bottom-text">Don’t have an account? <a href="javascript:void(0)" data-toggle="modal" data-target="#register-modal" data-dismiss="modal" class="link_btn">Sign up</a></h5>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog log-in-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase text-center w-100" id="exampleModalLongTitle">SIGN UP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <a href="javascript:void(0)" id="fbsignin" class="fbsignup btn btn-block btn-fb d-flex align-items-center justify-content-center"><i class="fab fa-facebook-f"></i> Connect With Facebook</a>
                        <a href="javascript:void(0)" id="gplussignin1" class="gplussignin btn btn-block btn-google d-flex align-items-center justify-content-center link_btn"> <img src="<?php echo SITE_URL; ?>images/google.png"> Connect With Google</a>
                        <p class="or-line">or</p>
                        <form name="UserSignupForm" id="UserSignupForm" action="<?php echo SITE_URL."ajax_signup.php"; ?>" method="post" >
                            <div class="form-group">
                                <label>First Name *</label>
                                <input type="text" class="form-control" name="first_name" onKeyPress="return isAlphaKey(event);">
                                <!--<input type="hidden" class="form-control" name="data[User][role]" value="1">-->
                            </div>
                            <div class="form-group">
                                <label>Last Name *</label>
                                <input type="text" class="form-control" name="last_name" onKeyPress="return isAlphaKey(event);">
                            </div>
                            <div class="form-group">
                                <label>Email Address *</label>
                                <input type="text" class="form-control" name="email_address" required>
                            </div>
                            <div class="form-group">
                                <label>Password *</label>
                                <input type="password" class="form-control" name="pass" required>
                            </div>
                            <input type="hidden" class="form-control" name="type" value="1">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="text-grey">
                                        <input type="checkbox" name="agree" required oninvalid="this.setCustomValidity('Please accept our terms anf conditions')"> I accept Terms & Conditions*
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary text-uppercase">SIGN UP</button>
                            </div>
                            <h5 class="text-center bottom-text">Already have an account?  <a href="#" data-toggle="modal" data-target="#exampleModalLong" data-dismiss="modal" class="link_btn">Login</a></h5>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php if($_SESSION['user_type'] == 0){
    if(($page_name == "learn_more.php" || $page_name == "accessibility.php" || $page_name == "cancle_policy.php" || $page_name == "all_rules.php" || $page_name == "terms_n_condition.php" || $page_name == "privacy_policy.php" || $page_name == "help.php" || $page_name == "site_map.php" || $page_name == "jobs.php" || $page_name == "about_us.php" || $page_name == "help_center.php" || $page_name == "more_info.php" || $page_name == "explore.php" || $page_name == '') || ($page_name == 'index.php') || ($page_name == 'message_list.php') || ($page_name == 'booking_history.php') || ($page_name == 'change_password.php') || ($page_name == 'editprofile.php') || ($page_name == 'my_properties.php') || ($page_name == 'dashboard_user.php') || ($page_name == 'review_user.php') || ($page_name == 'favorite.php') || ($page_name == 'feature.php')){ //echo $page_name;
    }else{   //echo $page_name; echo "moi";
        $page_question = explode("?",$page_name);  ///echo  $page_question[0];
    if($page_question[0] == "booking_faliure.php" || $page_question[0] == "booking_success.php" || $page_question[0] == "booking_step_two.php" || $page_question[0] == "message_page.php" || $page_question[0] == "booking_parking.php" || $page_question[0] == "search_list.php" || $page_question[0] == "details_page.php"){

    }else{

        if($_SESSION['user_id']){

    ?>
        <?php if($page_name == 'rent_parking_step8.php'){ ?>
        <nav class="nav nav-pills nav-justified">
            <div class="container">
                <a class="nav-link <?php if ($page_name == 'rent_parking_step1.php') { ?> active <?php } ?>" href="#">Contact Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step2.php') { ?> active <?php } ?>" href="#">General Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step3.php') { ?> active <?php } ?>" href="#">Property Description</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step4.php') { ?> active <?php } ?>" href="#">Place & Price</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step5.php') { ?> active <?php } ?>" href="#">Reservation& Time</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step6.php') { ?> active <?php } ?>" href="#">Cancellation / Refund Policy / Availablity</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step7.php') { ?> active <?php } ?>" href="#">Add a Co-owner</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step8.php') { ?> active <?php } ?>" href="rent_parking_step8.php">Confirmation</a>
            </div>
        </nav>

        <?php }else{ ?>
        <nav class="nav nav-pills nav-justified">
          <?php
          $one=$_SESSION['one'];
          $two=$_SESSION['two'];
          $three=$_SESSION['three'];
          $four=$_SESSION['four'];
          $five=$_SESSION['five'];
          $six=$_SESSION['six'];
          $seven=$_SESSION['seven'];
          
            if($_SESSION['add_session']==1 && $_SESSION['list_session']==1){ ?>
            <div class="container">
                <a class="nav-link <?php if ($page_name == 'rent_parking_step1.php') { ?> active <?php } ?>" href="rent_parking_step1.php">Contact Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step2.php') { ?> active <?php } ?>" href="<?php if($one==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step2.php<?php } ?>">General Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step3.php') { ?> active <?php } ?>" href="<?php if($two==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step3.php<?php } ?>">Property Description</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step4.php') { ?> active <?php } ?>" href="<?php if($three==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step4.php<?php } ?>">Place & Price</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step5.php') { ?> active <?php } ?>" href="<?php if($four==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step5.php<?php } ?>">Reservation& Time</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step6.php') { ?> active <?php } ?>" href="<?php if($five==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step6.php<?php } ?>">Cancellation / Refund Policy / Availablity</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step7.php') { ?> active <?php } ?>" href="<?php if($six==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step7.php<?php } ?>">Add a Co-owner</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step8.php') { ?> active <?php } ?>" href="<?php if($seven==''){ ?>javascript:void(0)<?php }else{ ?>rent_parking_step8.php<?php } ?>">Confirmation</a>
            </div>
            <?php } else if($_SESSION['add_session']==2){ ?>
            <div class="container">
                <a class="nav-link <?php if ($page_name == 'rent_parking_step1.php') { ?> active <?php } ?>" href="rent_parking_step1.php">Contact Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step2.php') { ?> active <?php } ?>" href="rent_parking_step2.php">General Info</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step3.php') { ?> active <?php } ?>" href="rent_parking_step3.php">Property Description</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step4.php') { ?> active <?php } ?>" href="rent_parking_step4.php">Place & Price</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step5.php') { ?> active <?php } ?>" href="rent_parking_step5.php">Reservation& Time</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step6.php') { ?> active <?php } ?>" href="rent_parking_step6.php">Cancellation / Refund Policy / Availablity</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step7.php') { ?> active <?php } ?>" href="rent_parking_step7.php">Add a Co-owner</a>
                <a class="nav-link <?php if ($page_name == 'rent_parking_step8.php') { ?> active <?php } ?>" href="rent_parking_step8.php">Confirmation</a>
            </div>
            <?php } ?>
        </nav>
        <?php } } ?>
    <?php } } } ?>
<?php if($page_name == "forgot_password.php"){ ?>
        <?php if($_SESSION['msg']){ ?>
        <!--<div class="error-log"><?php //echo $_SESSION['msg']; ?></div>-->
        <div class="error-log p-4" ><?php echo $_SESSION['msg']; ?></div>
<?php } } ?>
<?php if($page_name == $SITE_URL){ ?>
        <?php if($_SESSION['msg']){ ?>
        <!--<div class="error-log"><?php //echo $_SESSION['msg']; ?></div>-->
        <div class="error-log p-4 alert-msg" ><?php echo $_SESSION['msg']; ?></div>
<?php } } ?>
