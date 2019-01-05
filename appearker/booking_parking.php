<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
if($_SESSION['user_id'] == ''){  
    header("Location: index.php");
}
include("include/header.php");
 ?>
<?php

$get_start_date = $_SESSION['start_date'];
$get_end_date = $_SESSION['end_date'];
$actual_price = $_SESSION['actual_price']*$_SESSION['booking_month'];
//unset($_SESSION["start_date"]);
//unset($_SESSION["end_date"]);


$user_id = $_SESSION['user_id'];


$id = base64_decode($_REQUEST['parking']);
//echo "SELECT * FROM `parking` WHERE `id`={$id}";

$parking_spaces = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`={$id}"));
if($_SESSION['booking_month'] == $parking_spaces->discount_month){
    
   $discount_price = ($actual_price*((int)$parking_spaces->discount))/100;
   $actual_price = $actual_price-$discount_price;
}
//echo 2;exit;
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

$user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));

if(isset($_REQUEST['submit'])) {
   // print_r($_POST);exit;
    
//   $order_id = round(uniqid(rand(), true)); 
//   //echo $_POST['dob_month']." ".$_POST['dob_day'];exit;
//   $dob = $_POST['dob_year'].'-'.$_POST['dob_month'].'-'.$_POST['dob_day']; 
//  
//    $fields = array(
//        'prop_id' => mysqli_real_escape_string($link, $id),
//        'order_id' => mysqli_real_escape_string($link, $order_id),
//        'user_id' => mysqli_real_escape_string($link, $user_id),
//        'uploder_user_id' => mysqli_real_escape_string($link, $parking_spaces->user_id),
//        'firstname' => mysqli_real_escape_string($link, $_POST['first_name']),
//        'lastname' => mysqli_real_escape_string($link, $_POST['last_name']),
//        'start_date' => mysqli_real_escape_string($link, $_POST['start_date']),
//        'end_date' => mysqli_real_escape_string($link, $_POST['end_date']),
//        'price' => mysqli_real_escape_string($link, $_POST['price']),
//        'service_charge' => mysqli_real_escape_string($link, $_POST['service_charge']),
//        'email' => mysqli_real_escape_string($link, $_POST['email']),
//        'telephone' => mysqli_real_escape_string($link, $_POST['telephone']),
//        'gender' => mysqli_real_escape_string($link, $_POST['last_name']),
//        'dob' => mysqli_real_escape_string($link, $dob),
//        'payment_date' => mysqli_real_escape_string($link, date('Y-m-d')),
//        
//        
//    );
//    
//    $fieldsList = array();
//    foreach ($fields as $field => $value) {
//        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
//    }
//    
//  $addQuery = "INSERT INTO `estejmam_booking` (`" . implode('`,`', array_keys($fields)) . "`)"
//            . " VALUES ('" . implode("','", array_values($fields)) . "')"; 
//    
////    $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
////        . " WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'";
//
//    mysqli_query($link, $addQuery);
//   $last_id = mysqli_insert_id($link);
//   echo $bookig_id = base64_encode($last_id); 
//   header("Location: booking_step_two.php?gnikrap=$bookig_id");
//    
}






//print_r($user_details);

?>

<section class="booking-step-page">
        <div class="container pt-5">
            <h5 class="heading_te">Great! Your booking is almost done</h5>
            <div class="row my-5">
                <?php include("include/booking_sidebar.php"); ?>
<!--                <div class="col-lg-4">
                    <div class="whitebox-bg">
                        <div class="parking-img">
                            <div class="img-tag">$<?php if($parking_spaces->price_rate_type == 'per month'){ echo $parking_spaces->price+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; }else{ echo ($parking_spaces->price*24)+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; } ?>
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
                                <li><h5>Move in</h5><p><?php echo $get_start_date; ?></p></li>
                                <li><h5>Move out</h5><p><?php echo $get_end_date; ?></p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your payment</h4>
                            <ul>
                                <li><p>First month's rent</p><p>Booking fee</p><p>Total</p></li>
                                <li><p>$ <?php if($parking_spaces->price_rate_type == 'per month'){ echo $parking_spaces->price+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; }else{ echo ($parking_spaces->price*24)+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; } ?></p><p>$ <?php echo $parking_spaces->booking_fee; ?></p><p>$ <?php echo $actual_price+$parking_spaces->booking_fee; ?></p></li>
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
                                <li class="active px-5">
                                    <h5>Application</h5>
                                    <img src="images/step-1.png">
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class="px-5">
                                    <h5>Payment</h5>
                                    <img src="images/step-2.png">
                                </li>
                                <li><img src="images/step-arrow.png"></li>
                                <li class="px-5">
                                    <h5>Done</h5>
                                    <img src="images/step-3.png">
                                </li>
                            </ul>
                        </div>

                        <form name="payment_step1" id ="payment_step1" method="post" action="ajax_booking_step1.php" enctype="multipart/form-data">
                            <h5>Personal details</h5>
                            <?php
                            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            ?>
                            <input type="hidden" name="url" value="<?php echo $actual_link; ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="formGroupExampleInput">First name *</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $user_details->fname; ?>" required>
                                    <div class="error-div-first_name" style="display:none; color:red;"></div>
                                    <input type="hidden" value="<?php echo $get_start_date; ?>" name="start_date" />
                                    <input type="hidden" value="<?php echo $get_end_date; ?>" name="end_date" />
                                    <input type="hidden" value="<?php if($parking_spaces->price_rate_type == 'per month'){ echo $mainprice+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; }else{ echo ($mainprice*24)+ $parking_spaces->cleaning_fee + $parking_spaces->service_fee; } ?>" name="price" />
                                    <input type="hidden" value="<?php echo $parking_spaces->service_charge; ?>" name="service_charge" />
                                    <input type="hidden" value="<?php echo $id; ?>" name="parking_id" />
                                
                                </div>
                                <div class="col-lg-6">
                                    <label for="formGroupExampleInput">Last name *</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $user_details->lname; ?>" required>
                                    <div class="error-div-last_name" style="display:none; color:red;"></div>
                                </div>
                            </div>
                            <div class="row my-3 align-items-end">
                                <div class="col-lg-9">
                                    <label for="formGroupExampleInput">Email *</label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $user_details->email; ?>" <?php if($user_details->is_email != ''){ ?> disabled <?php } ?> >
                                    <div class="error-div-email" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary confirm my-2 my-sm-0 confirm_mail" data-toggle="modal" data-target="#exampleModalmail" <?php if($user_details->is_email != ''){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button>
                                </div>
                            </div>
                            <div class="row my-3 align-items-end">
                                <div class="col-lg-9">
                                    <label for="formGroupExampleInput">Telephone (with country code) *</label>
                                    <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo $user_details->phone; ?>" <?php if($user_details->mobile_verifyed != ''){ ?> disabled <?php } ?>>
                                    <div class="error-div-telephone" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary confirm my-2 my-sm-0 confirm_phone" data-toggle="modal" data-target="#exampleModalphone" <?php if($user_details->mobile_verifyed != ''){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-lg-6">
                                    <label for="formGroupExampleInput">Gender *</label>
                                    <select class="form-control" value="<?php echo $user_details->gender; ?>" name="gender" id="gender">
                                        <option <?php if($user_details->gender == 0){ ?>selected<?php } ?>  value="0">Male</option>
                                        <option <?php if($user_details->gender == 1){ ?>selected<?php } ?> value="1">Female</option>
                                    </select>
                                    <div class="error-div-gender" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="formGroupExampleInput">Date of birth  *</label>
                                    <?php //echo $user_details->dob; 
                                    $year = date('Y',strtotime($user_details->dob));
                                    $month = date('m',strtotime($user_details->dob));
                                    $day = date('d',strtotime($user_details->dob));
                                    
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-4 pr-0">
                                            <select class="form-control" name="dob_year" id="dob_year">
                                                <option value="">Year</option>
                                                <?php 
                                                
                                                $earliest_year = date("Y",strtotime("-150 year"));; 
                                                $latest_year = date('Y'); 
                                                foreach ( range( $latest_year, $earliest_year ) as $k ) {
                                                ?>
                                                <option <?php if($year == $k){ ?> selected<?php } ?> value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="error-div-dob_year" style="display:none; color:red;"></div>
                                        </div>
                                        <div class="col-lg-4 pr-0">
                                            <select class="form-control" name="dob_month" id="dob_month" style="font-size: 12px !important;">
                                                <option value="">Month</option>
                                                <?php 
                                                for ($j = 1; $j <= 12; ++$j) {
                                                   
                                                
                                                ?>
                                                <option <?php if($month == $j){ ?> selected<?php } ?> value="<?php echo str_pad($j, 2, "0", STR_PAD_LEFT); ?>"><?php echo date('F', mktime(0, 0, 0, $j, 1)); ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="error-div-dob_month" style="display:none; color:red;"></div>
                                        </div>
                                        <div class="col-lg-4 pr-0">
                                            <select class="form-control day_append" name="dob_day" id='dob_day'>
                                                <option value="">Day</option>
                                                <?php for($i=1; $i<=31; $i++){ ?>
                                                <option <?php if($day == $i){ ?> selected<?php } ?> value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="error-div-dob_day" style="display:none; color:red;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-lg-12 mt-4">
                                    <h5>Additional details</h5>
                                    <div class="additional-box">
                                        <h6>Parking owner prefer to rent to tenants who provide detailed and accurate information, so please tell us as much as you can, specially about the place at where you are working or studing.</h6>
                                    </div>
                                </div>
                            </div>
                            <?php if ($parking_spaces->is_id == 1 || $parking_spaces->is_workcertificate == 1 || $parking_spaces->is_utility == 1) { ?>
                            <div class="row my-3">
                                <div class="col-lg-12 mt-4">
                                    <h5 style="border-bottom: 1px solid #c5c5c5;padding-bottom: 10px;">Rental Time / Requirements</h5>
                                </div>
                                <?php if($parking_spaces->is_id == 1) { ?>
                                <div class="col-lg-3 pr-0 upload-btn-wrapper">
                                    <button class="btn">Upload ID Proof</button>
                                    <input type="file" name="id_proof" />
                                </div>
                                <?php } ?>
                                <?php if ($parking_spaces->is_workcertificate == 1) { ?>
                                <div class="col-lg-4 pr-0 upload-btn-wrapper">
                                    <button class="btn">Upload Work Certificate</button>
                                    <input type="file" name="work_certificate" />
                                </div>
                                <?php } ?>
                                <?php if ($parking_spaces->is_utility == 1) { ?>
                                <div class="col-lg-4 pr-0 upload-btn-wrapper">
                                    <button class="btn">Upload utility Bill</button>
                                    <input type="file" name="bill_image" />
                                </div>     
                                <?php } ?>
                            </div>
                                <?php } ?>
                            <div class="row my-3">
                                <div class="col-lg-12 mt-4 mb-2">
                                    <h5>License Plates</h5>
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" name="rental_time" placeholder="PBR" maxlength="3" onkeypress="return isAlphaKey(event);">
                                    <div class="error-div-rental_time" style="display:none; color:red;"></div>
                                </div> 
                                <div class="col-lg-3">
                                    <input type="numeric" class="form-control" id="requirement" name="requirement" placeholder="0987" maxlength="4" onkeypress="return isNumberKey(event);">
                                    <div class="error-div-requirement" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="checkbox-step">I accept Owner’s all terms and conditions.
                                        <input type="checkbox" required="true" id="terms_n_cond1">
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="error-div-tnc1" style="color:red;display:none"></div>  
                                </div>    
                            </div>
                            <div class="row my-3">
                                <div class="col-lg-12 mt-4 mb-2">
                                    <h5>Type of vehicle</h5>
                                </div>
                                <div class="col-lg-3 pr-0">
                                    <select class="form-control" name="make" id="make">
                                        <option value="">Make</option>
                                        <?php $get_all_make = mysqli_query($link, "SELECT * FROM `makes` WHERE `status`=1");
                                        while($row_make = mysqli_fetch_object($get_all_make)){
                                        
                                        ?>
                                        <option value="<?php echo $row_make->name; ?>" ><?php echo $row_make->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error-div-make" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-3 pr-0">
                                    <select class="form-control" name="model" id="model">
                                        <option value="">Model</option>
                                    </select>
                                    <div class="error-div-model" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-3 pr-0">
                                    <select class="form-control" name="year" id="year">
                                        <option value="">Year</option>
                                        <?php
                                            $earliest_year = date("Y",strtotime("-150 year"));; 
                                            $latest_year = date('Y'); 
                                            foreach ( range( $latest_year, $earliest_year ) as $m ) {
                                                ?>
                                            <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
                                            <?php } ?>
                                    </select>
                                    <div class="error-div-year" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control" name="color" id="color">
                                        <option value="">Color</option>
                                        <?php $get_colors = mysqli_query($link, "SELECT * FROM `colors` WHERE `status`=1"); 
                                        while($row_colors = mysqli_fetch_object($get_colors)){
                                        ?>
                                        <option value="<?php echo $row_colors->name; ?>"><?php echo $row_colors->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error-div-color" style="display:none; color:red;"></div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-lg-12 mt-4">
                                    <label for="exampleFormControlTextarea1">Please tell us about yourself and where are you studing or working *</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="about_you" id="about_you" ><?php echo $user_details->about_me; ?></textarea>
                                    <div class="error-div-about_you" style="display:none; color:red;"></div>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <label for="exampleFormControlInput1">Insert your promo code to get discount! </label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="promo_code">
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <label class="checkbox-step">I accept the terms and conditions.
                                        <input type="checkbox"  id="terms_n_cond2" required>
                                        <div class="error-div-terms_n_cond" style="display:none; color:red;"></div>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="checkbox-step">Subscribe to our newsletter for helpful info and special offers on getting settled in Madrid.
                                        <input type="checkbox" checked="checked" name="is_subscribe">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary confirm float-right mt-5 submitbtn" <?php if($user_details->is_email == '' || $user_details->mobile_verifyed == ''){ ?> disabled <?php } ?> value="Next Step" />
                        </form>
                    </div>
                  <?php  //echo "here"; ?>
                    
                </div>
            </div>
        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="exampleModalphone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Mobile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Security Code:
          <input type="text" id="otp" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_otp">Send</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Security Code:
          <input type="text" id="otp_mail" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_otp_mail">Send</button>
      </div>
    </div>
  </div>
</div>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script type="text/javascript" src="js/custom_validation_forbootstrap4.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#requirement").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        
        $("#make").change(function(){
            var make = $(this).val();
            
            $.ajax({
                type:"POST",
                url:'ajax_get_model.php',
                //data_type:"json",
                data:{make:make},
                success:function(result){
                    //alert(result);
                    //return false;
                    //alert(result);
                    $("#model").html(result);
                }
            });
        });
        
        $("#dob_month").change(function(){
            var dob_month = $(this).val();
            //alert(dob_month);
            var month_name = $(this).val();
            if(month_name=='01' || month_name=='03' || month_name=='05' || month_name=='07' || month_name=='08' || month_name=='10' || month_name=='12'){
              var day=31;
            }else{
              day=30;
            }
            var daylist ='<select class="form-control" name="dob_day" id="dob_day">\
                <option value="">Day</option>';
            for(i=1; i<=day; i++){
            daylist +='<option value="'+i+'">'+i+'</option>';
            }
            daylist +='</select>';
            $('.day_append').html('');
            $('.day_append').html(daylist);
                                       
            
            for(var  i = <?php echo $latest_year; ?>; i < <?php echo $earliest_year; ?>; i++) {
                alert(1);
                console.log(i + ': ' + daysInMonth(2, i) + '<br />');
            }
            if(dob_month == 02){
                
            }
        });

        $(".save_otp").click(function(){
            var otp_value = $("#otp").val();
            var phone_number = $("#telephone").val();
            if(phone_number != ""){
                $.ajax({
                    type:"post",
                    url:"ajax_user_otp.php",
                    datatype:"json",
                    data:{otp_value:otp_value, otp_type:'phone', phone_number:phone_number},
                    success:function(result){
                        //console.log(result);
                        //alert(result);
                        //window.location.reload();
                        if (result==1) {
                            $('#exampleModalphone').modal('hide');
                            $('.confirm_phone').text("Confirmed");
                            $('.confirm_phone').attr("disabled","true");
                            if($(".confirm_mail").is(":disabled")){
                               $('.submitbtn').attr("disabled", false); 
                            }
                        }else{
                            alert('OTP does not match');
                        }
                    }
                });
            }
        });
        $(".save_otp_mail").click(function(){
            var otp_value = $("#otp_mail").val();
            var phone_number = $("#email").val();
            if(phone_number != ""){
                $.ajax({
                    type:"post",
                    url:"ajax_user_otp.php",
                    datatype:"json",
                    data:{otp_value:otp_value, otp_type:'mail', phone_number:phone_number},
                    success:function(result){
                        //alert(result); return false;
                        //window.location.reload();
                        if (result==1) {
                            $('#exampleModalmail').modal('hide');
                            $('.confirm_mail').text("Confirmed");
                            $('.confirm_mail').attr("disabled","true");
                            if($(".confirm_phone").is(":disabled")){
                               $('.submitbtn').attr("disabled", false); 
                            }
                        }else{
                            alert('OTP does not match');
                        }
                    }
                });
            }
        });

       $(".confirm_phone").click(function(){
           
           var phone = $("#telephone").val();
           // alert(phone);
           // return false;
           if(phone != ""){
                $.ajax({
                    type:"POST",
                    url:"ajax_editprofile.php",
                    datatype:'json',
                    data:{action:'confphone',phone:phone },
                    success:function(data){
                        //console.log(data); return false;
                        //alert(data);
                        if(data == 1){
                            //alert(1); return false;
                            //alert($(this).text());
                            $(this).text("Confirmed");
                            $(this).attr("disabled","true");
                        }
                    }
                });
            }
       });
       $(".confirm_mail").click(function(){
          var phone = "";
           $.ajax({
               type:"POST",
               url:"ajax_editprofile.php",
               datatype:'json',
               data:{action:'confmail' },
               success:function(data){
                   //console.log(data); return false;
                   //alert(data);
                   if(data == 1){
                       //alert(1); return false;
                       //alert($(this).text());
                       $(this).text("Confirmed");
                       $(this).attr("disabled");
                   }
               }
           });
       });
    });
    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }
    
</script>