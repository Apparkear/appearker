<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
//echo $_SESSION['user_type']."Moi";
if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}
if($_SESSION['add_session'] != 2 && $_SESSION['one']==''){
   $location = SITE_URL;
    header("Location: $location"); 
}
include("include/header.php");
 ?>
<?php 


if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: $location");exit;
}

if($_SESSION['new_parking']){
    $parking_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$_SESSION['new_parking']}"));
    $country =$parking_details->country;
    $state =$parking_details->state;
    $city =$parking_details->city;
    $car_type = $parking_details->car_type;
    
    
}else{
    $country ="";
    $state ="";
    $city ="";
    $car_type ="";
}



?>
<link rel="stylesheet" href="css/asRange.css">
<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="">General Information</h4>
                            <h6 class="my-3"><b>Car Type/Size Accepted</b></h6>
                            <div class="row my-5 custom-color">
                                <div class="col-md-12">
                                    <div class="example">
                                        <div id="mobile" class="range-example-single"></div>
                                    </div>
                                </div>
                                <div class="error-div-car_type" style="display:none; color:red;"></div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group row edit-pro-row">
                                        <div class="col-sm-6 edit-pro-frmfield">
                                            <div class="form-check pl-0">
                                                <label class="car-type">Small
                                                    <input type="radio" class="car_type_class" <?php if($car_type == 's'){ ?>checked="checked"<?php } ?> value="s" name="radio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 chk-field">
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="Car size is Small"><img src="images/Question.png" class="pr-1">
                                            </a>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group row edit-pro-row">
                                            <div class="col-sm-6 edit-pro-frmfield">
                                                <div class="form-check pl-0">
                                                    <label class="car-type">Medium
                                                        <input type="radio" class="car_type_class" value="m" <?php if($car_type == 'm'){ ?>checked="checked"<?php } ?> name="radio">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <div class="col-sm-6 chk-field">
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="Car size is Medium"><img src="images/Question.png" class="pr-1">
                                            </a>
                                            
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group row edit-pro-row">
                                            <div class="col-sm-6 edit-pro-frmfield">
                                                <div class="form-check pl-0">
                                                    <label class="car-type">Large
                                                        <input type="radio" class="car_type_class" value="l" <?php if($car_type == 'l'){ ?>checked="checked"<?php } ?> name="radio">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 chk-field">
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Car size is Large"><img src="images/Question.png" class="pr-1">
                                                    </a>
                                            </div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group row edit-pro-row">
                                            <div class="col-sm-9 edit-pro-frmfield pr-0">
                                                <div class="form-check pl-0">
                                                    <label class="car-type">Extra-Large
                                                        <input type="radio" class="car_type_class" value="exl" <?php if($car_type == 'exl'){ ?>checked="checked"<?php } ?> name="radio">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        <div class="col-sm-3 chk-field pl-0">
                                            <a href="#" data-toggle="tooltip" data-placement="right" title="Car size is Extra-Large"><img src="images/Question.png" class="pr-1">
                                            </a>
                                        </div>
                                    </div> 
                                </div> -->
                                
                            </div>

                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div" id="general_info" action="ajax_general_info.php" method="post">
                                     
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12">

                                                <div class="form-group row edit-pro-row">
                                                    <label  class="col-sm-2 col-form-label pr-0 pl-0 text-right">Country:</label>
                                                    <div class="col-sm-8 edit-pro-frmfield">
                                                        <select class="form-control" name='country_list' id="country_list" onChange="getStateList(this.value);" >
                                                            <option value="">Select One</option>
                                                            <?php
                                                            $SQL ="SELECT * FROM `countries`";
                                                            $result = mysqli_query($link, $SQL);

                                                            while($row1=mysqli_fetch_array($result))
                                                            {
                                                            ?>
                                                            <option <?php if($country == $row1['id']){ ?>selected<?php } ?> value="<?php echo $row1['id']; ?>"> <?php echo $row1['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="error-div-country" style="display:none; color:red;"></div>
                                                        <input type="hidden" class="form-control" name="car_type" id="car_type" value="<?php echo $car_type; ?>">
                                                        <input type="hidden" name="parking_id" value="<?php echo $_SESSION['parking_id']; ?>" id="parking_id" /> 
                                                    </div>
                                                </div>                                    
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12">
                                                <div class="form-group row edit-pro-row">
                                                    <label  class="col-sm-2 col-form-label pr-0 pl-0 text-right">Province:</label>
                                                    <div class="col-sm-8 edit-pro-frmfield">
                                                        <select class="form-control" name='states_list' id= 'states_list' onChange="getCityList(this.value);" >
                                                            <option value="">Selet One</option>
                                                             <?php if($country != ""){ 
                                                                $get_state_list = mysqli_query($link,"SELECT * FROM `states` WHERE `country_id`=$country");
                                                                while($row_state = mysqli_fetch_array($get_state_list)){
                                                                ?>
                                                            <option <?php if($state == $row_state['id']){ ?>selected<?php } ?> value="<?php echo $row_state['id']; ?>"> <?php echo $row_state['name']; ?></option>
                                                            
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="error-div-state" style="display:none; color:red;"></div>
                                                    </div>
                                                </div>                                    
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-12">
                                                <div class="form-group row edit-pro-row">
                                                    <label  class="col-sm-2 col-form-label pr-0 pl-0 text-right">City:</label>
                                                    <div class="col-sm-8 edit-pro-frmfield">
                                                        <select class="form-control" name='city_list' id= 'city_list'>
                                                            <option value="">Selet One</option>
                                                            <?php if($state != ""){ 
                                                                $get_city_list = mysqli_query($link,"SELECT * FROM `cities` WHERE `state_id`=$state");
                                                                while($row_city = mysqli_fetch_array($get_city_list)){
                                                                ?>
                                                            <option <?php if($city == $row_city['id']){ ?>selected<?php } ?> value="<?php echo $row_city['id']; ?>"> <?php echo $row_city['name']; ?></option>
                                                            
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="error-div-city" style="display:none; color:red;"></div>
                                                    </div>
                                                </div>                                    
                                            </div>
                                        </div>
                                    
                                    <div class="row ml-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-3">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" href="rent_parking_step1.php" style="color:#ffffff">Back</a>
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
  <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script src="js/custom_validation_forbootstrap4.js"></script>
<script src="js/jquery-asRange.js"></script>
<script>
    function getStateList(val) {
        
        $.ajax({
            type: "POST",
            url: "ajax_state.php",
            data:{country_id:val},
            success: function(data){
                //console.log(data);return false;
              $("#states_list").html(data);
              $("#city_list").html("<option value=''>Select City</option>");
            }
        });
    }
    
    function getCityList(val) {
        $.ajax({
            type: "POST",
            url: "ajax_state.php",
            data:{state_id:val},
            success: function(data){
              $("#city_list").html(data);
            }
        });
    }
    
    $(document).ready(function(){
        // $('.car_type_class').click(function(){
        //     $("#car_type").val($(this).val());
        // });
        $(".range-example-single").asRange({
            //tip: false,
            step: 10,
            range: false,
            limit: true,
            min: 0,
            max: 40,
            format: function(value) {
                if(value==10){
                   return 'S'; 
                }else if(value==20){
                    return 'M';
                }else if(value==30){
                    return 'L';
                }else if(value==40){
                    return 'XL';
                }else{
                    return 0;
                }
            },
            onChange: function(value) {
                if(value==10){
                   $("#car_type").val('s'); 
                }else if(value==20){
                    $("#car_type").val('m');
                }else if(value==30){
                    $("#car_type").val('l');
                }else if(value==40){
                    $("#car_type").val('exl');
                }else if(value==0){
                    $("#car_type").val(0);
                }
                
            }
        });
        <?php if($car_type=='s'){ ?>
        $(".range-example-single").asRange('val', '10');
        <?php }else if($car_type=='m'){ ?>
        $(".range-example-single").asRange('val', '20');
        <?php }else if($car_type=='l'){ ?>
        $(".range-example-single").asRange('val', '30');
        <?php }else if($car_type=='exl'){ ?>
        $(".range-example-single").asRange('val', '40');
        <?php }else{ ?>
        $(".range-example-single").asRange('val', '0');
        <?php } ?>
    });
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>