<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 


if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}

if($_SESSION['add_session'] != 2 && $_SESSION['four']==''){  
    $location = SITE_URL;
    header("Location: $location");
    
}


/******************header***************/
include("include/header.php");


$get_parking_id = $_SESSION['new_parking'];

if($get_parking_id){
    $get_details= mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$get_parking_id}"));
}
//print_r($get_details);

?>
<!--<p>Work is in progress</p>-->
<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="">Reservation and Time Preferences</h4>
                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div" method="post" action="ajax_reservation_owner.php">

                                    <!-- <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-4 col-form-label pr-0 pl-lg-0 text-right">Advance Notice Time:</label>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <input type="number" class="form-control" placeholder="30" max="31" min="1" name="notice_time" value="<?php echo $get_details->notice_time; ?>">
                                                </div>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <select class="form-control" name="notice_time_type">
                                                        <option>Select</option>
                                                        <option <?php if($get_details->notice_time_type == "day"){ ?>selected<?php } ?> value="day">Days</option>
                                                        <option <?php if($get_details->notice_time_type == "month"){ ?>selected<?php } ?> value="month">Months</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 edit-pro-frmfield">     </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-0">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-4 col-form-label pr-0 pl-lg-0 text-right">Preparation Time:</label>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <input type="number" class="form-control" placeholder="30" max="31" min="1" name="preparation_time" value="<?php echo $get_details->preparation_time; ?>">
                                                </div>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <select class="form-control" name="preparation_time_type">
                                                        <option value="">Select</option>
                                                        <option <?php if($get_details->preparation_time_type == "day"){ ?>selected<?php } ?> value="day">Days</option>
                                                        <option <?php if($get_details->preparation_time_type == "month"){ ?>selected<?php } ?> value="month">Months</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 edit-pro-frmfield">     </div>
                                            </div>                                  
                                        </div>
                                    </div> -->
                                    <?php  //if($get_details->access_card || $get_details->extrakey){ ?>
                                     <div class="row justify-content-center mb-2">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row mb-0">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-8">
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="In case of renter provides key or access cards"><img src="images/Question.png" class="pr-1">
                                                    </a>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-4 col-form-label pr-0 pl-lg-0 text-right">Booking Window:</label>
                                                
                                                <div class="col-sm-6 edit-pro-frmfield">
                                                    <select class="form-control" name="booking_window">
                                                        <option value="">select</option>
                                                        <option <?php if($get_details->booking_window == 1){ ?>selected<?php } ?> value="1">1 year</option>
                                                        <option <?php if($get_details->booking_window == 2){ ?>selected<?php } ?> value="2">2 year</option>
                                                        <option <?php if($get_details->booking_window == 3){ ?>selected<?php } ?> value="3">3 year</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 edit-pro-frmfield">     </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                     <div class="row justify-content-center mt-4">
                                        <div class="col-sm-11">
                                        <p style="font-size:18px">Rental Time / Requirements</p>
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-4 col-form-label pr-0 pl-lg-0 text-right">Max Period:</label>
                                                
                                                <div class="col-sm-6 edit-pro-frmfield">
                                                    <select class="form-control" name="rental_max">
                                                        <option value="">select</option>
                                                        <option <?php if($get_details->rental_max == 1){ ?>selected<?php } ?> value="1">1 Months</option>
                                                        <option <?php if($get_details->rental_max == 2){ ?>selected<?php } ?> value="2">2 Months</option>
                                                        <option <?php if($get_details->rental_max == 3){ ?>selected<?php } ?> value="3">3 Months</option>
                                                        <option <?php if($get_details->rental_max == 4){ ?>selected<?php } ?> value="4">4 Months</option>
                                                        <option <?php if($get_details->rental_max == 5){ ?>selected<?php } ?> value="5">5 Months</option>
                                                        <option <?php if($get_details->rental_max == 6){ ?>selected<?php } ?> value="6">6 Months</option>
                                                        <option <?php if($get_details->rental_max == 7){ ?>selected<?php } ?> value="7">7 Months</option>
                                                        <option <?php if($get_details->rental_max == 8){ ?>selected<?php } ?> value="8">8 Months</option>
                                                        <option <?php if($get_details->rental_max == 9){ ?>selected<?php } ?> value="9">9 Months</option>
                                                        <option <?php if($get_details->rental_max == 10){ ?>selected<?php } ?> value="10">10 Months</option>
                                                        <option <?php if($get_details->rental_max == 11){ ?>selected<?php } ?> value="11">11 Months</option>
                                                        <option <?php if($get_details->rental_max == 12){ ?>selected<?php } ?> value="12">12 Months</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 edit-pro-frmfield">     </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                     <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-4 col-form-label pr-0 pl-lg-0 text-right">Min Period:</label>
                                                
                                                <div class="col-sm-6 edit-pro-frmfield">
                                                    <select class="form-control" name="rental_min" value="<?php echo $get_details->rental_min; ?>">
                                                        <option value="">select</option>
                                                        <option <?php if($get_details->rental_min == 1){ ?>selected<?php } ?> value="1">1 Months</option>
                                                        <option <?php if($get_details->rental_min == 2){ ?>selected<?php } ?> value="2">2 Months</option>
                                                        <option <?php if($get_details->rental_min == 3){ ?>selected<?php } ?> value="3">3 Months</option>
                                                        <option <?php if($get_details->rental_min == 4){ ?>selected<?php } ?> value="4">4 Months</option>
                                                        <option <?php if($get_details->rental_min == 5){ ?>selected<?php } ?> value="5">5 Months</option>
                                                        <option <?php if($get_details->rental_min == 6){ ?>selected<?php } ?> value="6">6 Months</option>
                                                        <option <?php if($get_details->rental_min == 7){ ?>selected<?php } ?> value="7">7 Months</option>
                                                        <option <?php if($get_details->rental_min == 8){ ?>selected<?php } ?> value="8">8 Months</option>
                                                        <option <?php if($get_details->rental_min == 9){ ?>selected<?php } ?> value="9">9 Months</option>
                                                        <option <?php if($get_details->rental_min == 10){ ?>selected<?php } ?> value="10">10 Months</option>
                                                        <option <?php if($get_details->rental_min == 11){ ?>selected<?php } ?> value="11">11 Months</option>
                                                        <option <?php if($get_details->rental_min == 12){ ?>selected<?php } ?> value="12">12 Months</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 edit-pro-frmfield">     </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pl-lg-0 text-left"><p style="font-size:18px">Requirements</p></label>
                                                
                                                <div class="col-sm-2 edit-pro-frmfield pr-0">
                                                    <div class="custom-control custom-checkbox my-2 mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline" name="is_id" <?php if($get_details->is_id == 1){ ?>checked<?php } ?>>
                                                        <label class="custom-control-label" for="customControlInline">ID</label>
                                                    </div>
                                                </div>
                                                 <div class="col-sm-4 edit-pro-frmfield pl-lg-0 pr-0">
                                                    <div class="custom-control custom-checkbox my-2 mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline2" name="is_workcertificate" <?php if($get_details->is_workcertificate == 1){ ?>checked<?php } ?>>
                                                        <label class="custom-control-label" for="customControlInline2">Work Certificate</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 edit-pro-frmfield pl-lg-0 pr-0">
                                                    <div class="custom-control custom-checkbox my-2 mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline3" name="is_utility" <?php if($get_details->is_utility == 1){ ?>checked<?php } ?>>
                                                        <label class="custom-control-label" for="customControlInline3">Basic Utilities</label>
                                                    </div>
                                                </div>
                                                
                                            </div>                                                
                                        </div>
                                    </div>
                                    <?php //} ?>
                                    
                                    <div class="row ml-2">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-3">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" href="rent_parking_step4.php" >Back</a>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" name="submit" value="Next" />
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                    
                                    
                                </form>
                                <div class="col-md-3 hints">
                                    <img src="images/hints.png">
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
           </div>
           <div class="col-md-2">              
            </div>
       </div>
   </div>
    
<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>