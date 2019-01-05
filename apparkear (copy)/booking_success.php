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
$actual_price = $_SESSION['actual_price']*$_SESSION['booking_month'];


$booking_id = base64_decode($_REQUEST['gnikoob']); 


$get_deatils = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_booking` WHERE `id`={$booking_id}"));
//print_r($get_deatils);
//echo "ji";
$parking_space_id = $get_deatils->prop_id; 


$parking_spaces = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`={$parking_space_id}"));
//print_r($parking_spaces);
$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));


if($_SESSION['booking_month'] == $parking_spaces->discount_month){
    
   $discount_price = ($actual_price*((int)$parking_spaces->discount))/100;
   $actual_price = $actual_price-$discount_price;
}
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
?>
<section class="booking-step-page">
        <div class="container pt-5">
            <h5>Great! Your booking is almost done</h5>
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
                                <li class="px-5" <?php if(isset($_SESSION['booking_park_step1'])){ ?>onclick="window.location.href='<?php echo $_SESSION['booking_park_step2']; ?>'" <?php } ?>>
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
                                <img src="./images/step-right.png">
                                <h2>Your parking lot was successfully booked!</h2>
                            </div>
                                <div class="col-lg-8 step-3 mt-5">
                                    <h4><?php echo $parking_spaces->name; ?><!-- <span class="ml-4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span> --></h4>
                                    <h4>Booking ID: <?php echo $get_deatils->order_id; ?> </h4>
                                    <h6>Address: <?php echo $parking_spaces->address; ?></h6>
                                </div>
                                <!-- <div class="col-lg-4 step-3 mt-5">
                                    <i class="far fa-thumbs-up mr-3"></i><i class="far fa-heart"></i>
                                </div> -->
                            <div class="col-lg-12 step-3 my-4">
                                <h6>Parking Summery:</h6>
                                <p><?php echo $parking_spaces->description; ?></p>
                            </div>
                            <div class="col-lg-12">
                                <h6>Give review:</h6>
                                <form id="review_form" action="ajax_save_review.php" method="post">
                                <div class="row review-box">
                                    <div class="col-md-4">
                                        <p>Rating: </p>
                                        <div class="rating-stars">
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
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="foo rating-value"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="given_by" value="<?php echo $_SESSION['user_id']; ?>">          
                                <input type="hidden" name="parking_id" value="<?php echo $parking_space_id; ?>">
                                <input type="hidden" name="rating" id="rating">
                                <p>Review:</p>
                                <div class="text-area-box d-flex">
                                    <textarea id="comment" maxlength="2500" minlength="12" name="comments" required style="width:100%; height:50px;"></textarea>
                                </div>
                                <div class="pt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
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

<script type="text/javascript">
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
    $('#rating').val(rating);
    $('.foo').text(rating);
});
</script>