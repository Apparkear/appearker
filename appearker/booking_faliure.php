<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<?php
if($_SESSION['user_id'] == ''){  
   
    header("Location: index.php");
    
}
 $get_start_date = $_SESSION['start_date'];
 $get_end_date = $_SESSION['end_date'];
$actual_price = $_SESSION['actual_price'];


$booking_id = base64_decode($_REQUEST['gnikoob']); 


$get_deatils = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_booking` WHERE `id`={$booking_id}"));
//print_r($get_deatils);
//echo "ji";
$parking_space_id = $get_deatils->prop_id; 


$parking_spaces = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`={$parking_space_id}"));
//print_r($parking_spaces);
$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));



?>
<section class="booking-step-page">
        <div class="container">
            <h5 class="heading_te">Great! Your booking is almost done</h5>
            <div class="row my-5">
                <?php include("include/booking_sidebar.php"); ?>
                 <div class="col-lg-8">
                    <div class="whitebox-bg p-4">
                        <div class="grey-bg mb-5">
                            <ul class="my-4 p-0">
                                <li class="px-5">
                                    <h5>Application</h5>
                                    <img src="images/step-1-active.png">
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class=" px-5">
                                    <h5>Payment</h5>
                                    <img src="images/step-2.png">
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class="active px-5">
                                    <h5>Done</h5>
                                    <img src="images/step-3-active.png">
                                </li>
                            </ul>
                        </div>

                        

                        <div class="row my-5">
                            <div class="col-lg-12 text-center">
                                <img src="./images/cancel.png">
                                <h2>Sorry, not booked!</h2>
                            </div>
<!--                                <div class="col-lg-8 step-3 mt-5">
                                    <h4><?php echo $parking_spaces->name; ?><span class="ml-4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></h4>
                                    <h4>Booking ID: <?php echo $get_deatils->order_id; ?> </h4>
                                    <h6>Address: <?php echo $parking_spaces->address; ?></h6>
                                </div>
                                <div class="col-lg-4 step-3 mt-5">
                                    <i class="far fa-thumbs-up mr-3"></i><i class="far fa-heart"></i>
                                </div>
                            <div class="col-lg-12 step-3 my-4">
                                <h6>Parking Summery:</h6>
                                <p><?php echo $parking_spaces->description; ?></p>
                            </div>-->
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
</section>
                


<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>