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

$user_id = $_SESSION['user_id'];
$booking_id = base64_decode($_REQUEST['gnikrap']); 


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
            <h5 class="heading_te">Great! Your booking is almost done</h5>
            <div class="row my-5">
                <?php include("include/booking_sidebar.php"); ?>
<!--                <div class="col-lg-4">
                    <div class="whitebox-bg">
                        <div class="parking-img">
                            <div class="img-tag">€395
                                    month</div>
                            <img src="images/booking-step-1-img.png" class="img-fluid">
                        </div>
                        <div class="place-name p-3">
                            <h5>Parking place name goes here</h5>
                            <ul class="p-0 m-0">
                                <li class="pr-3"><img src="images/security-guard.png"><p>Security Guard</p></li>
                                <li><img src="images/cars.png"><p>More than 300 cars</p></li>
                                <li><img src="images/cctv.png"><p>CCTV camera</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your booking dates</h4>
                            <ul>
                                <li><h5>Move in</h5><p>2018-02-18</p></li>
                                <li><h5>Move out</h5><p>2018-03-17</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your payment</h4>
                            <ul>
                                <li><p>First month's rent</p><p>Booking fee</p><p>Total</p></li>
                                <li><p>$ 395</p><p>$ 192</p><p>$ 587</p></li>
                            </ul>
                            <a href="#">What is this?</a>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your payment</h4>
                            <ul>
                                <li><p>Contract type</p></li>
                                <li><p>monthly</p></li>
                            </ul>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                    <div class="grey-bg">
                        <div class="step-left p-3">
                            <h4>Other information</h4>
                            <ul>
                                <li><p>Contract type</p></li>
                                <li><p>monthly</p></li>
                            </ul>
                            <h4 class="pt-3 pb-0">This fee will be paid directly to the provider to cover administrative and other costs.</h4>
                        </div>
                    </div>
                </div>-->
                
                <div class="col-lg-8">
                    <div class="whitebox-bg p-4">
                        <div class="grey-bg mb-5">
                            <ul class="my-4 p-0">
                                <li class="px-5" <?php if(isset($_SESSION['booking_park_step1'])){ ?>onclick="window.location.href='<?php echo $_SESSION['booking_park_step1']; ?>'" <?php } ?>>
                                    <h5>Application</h5>
                                    <?php if(isset($_SESSION['booking_park_step1'])){ ?>
                                    <img src="images/step-1.png" style="cursor:pointer;">
                                    <?php }else{ ?>
                                    <img src="images/step-1-active.png">
                                    <?php } ?>
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class="active px-5">
                                    <h5>Payment</h5>
                                    <img src="images/step-2-active.png">
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class="px-5">
                                    <h5>Done</h5>
                                    <img src="images/step-3.png">
                                </li>
                            </ul>
                        </div>

                        <div class="">
                            <h5>Payment</h5>
                            <form method="post" action="ajax_booking_step2.php" id="booking_step2">
                            
                                <div class="form-group row">
                                    <label for="holder_name" class="col-sm-3 col-form-label">Cardholder Name:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="holder_name" id="holder_name" onkeypress="return isAlphaKey(event);">
                                        <div class="error-div-holdername" style="display: none; color: red;"></div>
                                    </div>                            
                                </div>
                                <div class="form-group row">
                                    <label for="card_number" class="col-sm-3 col-form-label">Credit Card Number:</label>
                                    <div class="col-sm-6">
                                        <!--<input type="text" class="form-control" id="card_number" pattern="[0-9]" maxlength="16" name="card_number" >-->
                                        <input type="text" class="form-control" id="card_number" maxlength="16" name="card_number" onkeypress="return isNumberKey(event);">
                                        <div class="error-div-cardnumber" style="display: none; color: red;"></div>
                                        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>"/>
                                        <input type="hidden" name="price" value="<?php echo $actual_price+$parking_spaces->booking_fee; ?>"/>
                                                              
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Valid Upto:</label>
                                    <div class="col-sm-2">
                                        <select name="exp_month" id="exp_month" >
                                            <option value="">Month</option>
                                            <?php 
                                                for ($j = 1; $j <= 12; ++$j) {
                                            ?>
                                            <option value="<?php echo str_pad($j, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($j, 2, "0", STR_PAD_LEFT); ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="error-div-expmonth" style="display: none; color: red;"></div>
                                    </div>
                                    &nbsp;/&nbsp;
                                    <div class="col-sm-4">
                                        <select name="exp_year" id="exp_year" >
                                            <option value="">Year</option>
                                            <?php 
                                            $earliest_year = date("Y", strtotime("+50 year"));
                                            ;
                                            $latest_year = date('Y');
                                            foreach (range($latest_year, $earliest_year) as $k) {
                                                ?>
                                                <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="error-div-expyear" style="display: none; color: red;"></div>
                                    </div>                            
                                </div>
                                <div class="form-group row">
                                    <label for="cvv" class="col-sm-3 col-form-label">CVV:</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" maxlength="3" name="cvv" id="cvv" >
                                        <div class="error-div-cvv" style="display: none; color: red;"></div>
                                    </div>                            
                                </div>
                                <div class="form-group row">
                                    <input type="submit" name="submit" class="btn-primary float-right" value="Next Step" />
                                </div>
                            </form>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </section>
<script src="js/custom_validation_forbootstrap4.js"></script>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<!--<script src="js/custom_validation_forbootstrap4.js"></script>-->
<script type="text/javascript">
    
     $("#cvv").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#card_number").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    
//    $("#booking_step2").formValidation({
//        framework: 'bootstrap',
//        excluded: ':disabled',
//        icon: {
//          valid: 'glyphicon glyphicon-ok',
//          invalid: 'glyphicon glyphicon-remove',
//          validating: 'glyphicon glyphicon-refresh'
//        },
//        fields: {
//          'holder_name': {
//            validators: {
//              notEmpty: {
//                message: 'The holder_name is required and cannot be empty. '
//                }
//                
//             }
//            },
//          'card_number': {
//            validators: {
//              notEmpty: {
//                message: 'The card_number is required and cannot be empty. '
//                }
//                
//             }
//            },
//          'exp_year': {
//            validators: {
//              notEmpty: {
//                message: 'The exp_year is required and cannot be empty. '
//                }
//                
//             }
//            },
//          'exp_month': {
//            validators: {
//              notEmpty: {
//                message: 'The exp_month is required and cannot be empty. '
//                }
//                
//             }
//            },
//          'cvv': {
//            validators: {
//              notEmpty: {
//                message: 'The cvv is required and cannot be empty. '
//                },
//                stringLength: {
//                     //message: 'Password must be atleast 8 characters long ',
//                     max: 4,
//                     min:4
//                 }
//                
//             }
//            },
//            
//        }
//        });
</script>