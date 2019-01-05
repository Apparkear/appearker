<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
 ?>

<?php

//echo $_SESSION['user_id'];
if($_SESSION['user_id'] == '' ){
    $location = SITE_URL;
    header("Location: index.php"); exit();
}

$user_id = $_SESSION['user_id'];


//print_r($get_user_details); 

if(isset($_REQUEST['submit'])) {
   // echo "1moi"; exit;
 // print_r($_POST); exit;  
   //print_r($_FILES);
    $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name']; 
   $address = $_POST['address'];
   $country = $_POST['country_list'];
   $state = $_POST['states_list'];
   $city = $_POST['city_list'];
   
   $phone = $_POST['phone'];
   $work = $_POST['work'];
   $dob = $_POST['dob'];
   $gender = $_POST['gender'];
   $client_code = $_POST['client_code'];
  $lat = $_POST['lat'];
  $lon = $_POST['lon']; 
  
  $result = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`= ".$_SESSION['user_id']));
    //echo $result->phone.'ddd'.$phone; exit;
    if ($phone != $result->phone){
      $mobile_update = mysqli_query($link, "UPDATE `estejmam_user` SET `mobile_verifyed`=NULL WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'");
    }  
    
    $fields = array(
        'fname' => mysqli_real_escape_string($link, $first_name),
        'lname' => mysqli_real_escape_string($link, $last_name),
        'address' => mysqli_real_escape_string($link, $address),
        'country' => mysqli_real_escape_string($link, $country),
        'state' => mysqli_real_escape_string($link, $state),
        'city' => mysqli_real_escape_string($link, $city),
        'phone' => mysqli_real_escape_string($link, $phone),
        'work' => mysqli_real_escape_string($link, $work),
        'dob' => mysqli_real_escape_string($link, $dob),
        'gender' => mysqli_real_escape_string($link, $gender),
        'client_code' => mysqli_real_escape_string($link, $client_code),
        'lat' => mysqli_real_escape_string($link, $lat),
        'lon' => mysqli_real_escape_string($link, $lon)
        
    );
//print_r($fields);exit;
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
    $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'";

    mysqli_query($link, $editQuery);

    
   
  
   if ($_FILES['image']['tmp_name'] != '') {
        $target_path = "./upload/user_image/";
        $userfile_name = $_FILES['image']['name']; 
        $userfile_tmp = $_FILES['image']['tmp_name'];
        $img_name = $userfile_name;
        $img = $target_path . $img_name;
        move_uploaded_file($userfile_tmp, $img);

        $image = mysqli_query($link, "UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'");
    }
   
    header("Location: editprofile.php");

}

$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`= ".$_SESSION['user_id']));

?>

<?php include("include/header.php"); ?>
<!--  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
        <script type="text/javascript">
               function initialize() {
                       var input = document.getElementById('geocomplete');
                       var autocomplete = new google.maps.places.Autocomplete(input);
                       console.log(autocomplete);
               }
               google.maps.event.addDomListener(window, 'load', initialize);
       </script>-->
<section class="message-body">
        <div class="container">
            <div class="row">
              <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <div class="my-properties">
                        <form class="pt-3 pb-5 row" action="" id="edit_pf_form" method="post" enctype="multipart/form-data">
                            <div class="col-md-6">
                                  <div class="form-group row edit-pro-row">
                                      <label class="col-sm-3 col-form-label pr-0 text-right">First Name:</label>
                                      <div class="col-sm-9 edit-pro-frmfield">
                                          <input class="form-control" name="first_name" id="first_name" placeholder="Samuel Doe" onkeypress="return isAlfa(event)" value="<?php echo $get_user_details->fname; ?>">
                                          <div class="error-div-fname" style="display:none; color:red;"></div>
                                          <i class="ion-compose"></i>
                                      </div>
                                  </div>
                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Last Name:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Samuel Doe" name="last_name" id="last_name" class="form-control" onkeypress="return isAlfa(event)" value="<?php echo $get_user_details->lname; ?>">
                                            <div class="error-div-lname" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Address:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                              <input id="autocomplete1" onFocus="geolocate()" type="text" class="form-control" name="address" id="address" value="<?php echo $get_user_details->address;?>">
                                              <div class="error-div-address" style="display:none; color:red;"></div>
                                              <input type="hidden" name="lat" value="<?php echo $get_user_details->lat; ?>"/>
                                              <input type="hidden" name="lon" value="<?php echo $get_user_details->lon; ?>"/>
                                              <i class="ion-compose"></i>
                                        </div>
                                  </div>
                                  <div class="form-group row edit-pro-row">
                                      <label class="col-sm-3 col-form-label pr-0 text-right">Country:</label>
                                      <div class="col-sm-9 edit-pro-frmfield">                              
                                            <select class="form-control" name='country_list' id="country_list" onChange="getStateList(this.value);">
                                              <option value="">Select One</option>
                                              <?php
                                              $SQL ="SELECT * FROM `countries`";
                                              $result = mysqli_query($link, $SQL);

                                              while($row1=mysqli_fetch_array($result))
                                              {
                                              ?>
                                              <option value="<?php echo $row1['id']; ?>" <?php if($get_user_details->country==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
                                              <?php
                                              }
                                              ?>
                                          </select>
                                          <div class="error-div-country" style="display:none; color:red;"></div>
                                      </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                      <label class="col-sm-3 col-form-label pr-0 text-right">State/ Province:</label>
                                      <div class="col-sm-9 edit-pro-frmfield">                               
                                               <select class="form-control" name='states_list' id= 'states_list' onChange="getCityList(this.value);">
                                                  <?php
                                                $SQL_state ="SELECT * FROM `states` WHERE `country_id`=".$get_user_details->country;
                                                $result_state = mysqli_query($link, $SQL_state);

                                                while($row_state=mysqli_fetch_array($result_state))
                                                {
                                                ?>
                                                <option value="<?php echo $row_state['id']; ?>" <?php if($get_user_details->state==$row_state['id']) { echo "selected";}?> > <?php echo $row_state['name']; ?></option>
                                                <?php } ?>
                                               </select>
                                               <div class="error-div-state" style="display:none; color:red;"></div>
                                      </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                      <label class="col-sm-3 col-form-label pr-0 text-right">City:</label>
                                      <div class="col-sm-9 edit-pro-frmfield">
                                              <select class="form-control" name="city_list" id="city_list">
                                                  <?php 
                                                  if(!empty($get_user_details->state)){
                                                  $SQL_city ="SELECT * FROM `cities` WHERE `state_id`=".$get_user_details->state;
                                                  $result_city = mysqli_query($link, $SQL_city);
                                                  while($row_city=mysqli_fetch_array($result_city))
                                                {
                                                 ?>
                                                  <option value="<?php echo $row_city['id']; ?>" <?php if($get_user_details->city==$row_city['id']) { echo "selected";}?> > <?php echo $row_city['name']; ?></option>
                                                  <?php } } ?>
                                        </select>
                                        <div class="error-div-city" style="display:none; color:red;"></div>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Phone:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="+100 112 33445566" class="form-control" id="confirm_phone_id" name="phone" onkeypress="return isNumberKey(event)" value="<?php echo $get_user_details->phone; ?>">
                                            <i class="ion-compose"></i>
                                            <div class="error-div-phone" style="display:none; color:red;"></div>
                                            <button type="button" tabindex="0" class="btn btn-primary confirm my-2 my-sm-0 confirm_phone" data-toggle="modal" data-target="#exampleModalphone" <?php if($get_user_details->mobile_verifyed != ''){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button>
                                        </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group row edit-pro-row">
                                      <label class="col-sm-3 col-form-label text-right">Photo:</label>
                                      <div class="col-sm-9 edit-pro-frmfield">
<!--                                            <input class="form-control" placeholder="Upload">-->
                                            <div class="file-upload">
                                                <label for="upload" class="file-upload__label">
                                                    <small class="filename"> Upload </small>
                                                    <span>Browse</span></label>
                                                <input id="upload" class="file-upload__input profile_imgae_upload" type="file" name="image">
                                            </div>

                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Occupation:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Business" class="form-control" name="work" value="<?php echo $get_user_details->work; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">DOB:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="2010-05-08" class="form-control" id="datetimepickerdob" name="dob" value="<?php echo $get_user_details->dob; ?>">
                                            <div class="error-div-dob" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Email:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="sam@email.com" class="form-control" disabled="true" id="get_email" value="<?php echo $get_user_details->email; ?>" >
<!--                                            <i class="ion-compose"></i>-->
                                            <button type="button" tabindex="0" class="btn btn-primary confirm my-2 my-sm-0 confirm_mail" data-toggle="modal" data-target="#exampleModalmail" <?php if($get_user_details->is_email != ''){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Gender:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                    
                                            <select class="form-control" id="inputState" name="gender">
                                                <option value="1" <?php if($get_user_details->gender == 1){ ?> selected <?php } ?>>Female</option>
                                                <option value="0" <?php if($get_user_details->gender == 0){ ?> selected <?php } ?>>Male</option>
                                            </select>
                                        </div>
                                  </div>

                                  <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">ID Number:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="+100 112 33445566" class="form-control" pattern="^\d{10}$"  maxlength="10" name="client_code" value="<?php echo $get_user_details->client_code; ?>" onkeypress="return isNumberKey(event);">
                                            <i class="ion-compose"></i>
                                        </div>
                                  </div>
                              </div>

                              <div class="col-sm-12 mb-lg-5 text-center">                                  
                                  
                                  <button name="submit" class="btn btn-primary my-2 edit-pro-sv-chng" type="submit">Save Changes</button>
                              </div>                            
                        </form>
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
<!--                        <form class="pt-3 pb-5 row" method="post" action="editprofile.php">
                                <div class="col-md-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">First Name:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input class="form-control" name="first_name" placeholder="Samuel Doe" value="<?php echo $get_user_details->fname; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Last Name:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Samuel Doe" name="last_name" class="form-control" value="<?php echo $get_user_details->lname; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Address:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                              <input id="autocomplete1" onFocus="geolocate()" type="text" class="form-control" name="address" value="<?php echo $get_user_details->address;?>" required>
                                              <input type="hidden" name="lat" value=""/>
                                              <input type="hidden" name="lon" value=""/>
                                              <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Country:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">                              
                                              <select class="form-control" name='country_list' id="country_list" onChange="getStateList(this.value);" required>
                                                <option value="">Select One</option>
                                                <?php
                                                $SQL ="SELECT * FROM `countries`";
                                                $result = mysqli_query($link, $SQL);

                                                while($row1=mysqli_fetch_array($result))
                                                {
                                                ?>
                                                <option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['country']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">State/ Province:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                    
                                               <select class="form-control" name='states_list' id= 'states_list' onChange="getCityList(this.value);">
                                                   <?php //if($get_user_details->) ?>
                                               </select>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">City:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                              <select class="form-control" name='city_list' id= 'city_list'>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Phone:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="+100 112 33445566" class="form-control" name="phone" value="<?php echo $get_user_details->phone; ?>">
                                            <i class="ion-compose"></i>
                                            <button type="button" class="btn btn-primary confirm my-2 my-sm-0">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label text-right">Photo:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input class="form-control" placeholder="Upload">
                                            <div class="file-upload">
                                                <label for="upload" class="file-upload__label">Upload <span>Browse</span></label>
                                                <input id="upload" class="file-upload__input" type="file" name="image">
                                            </div>
                                            <button type="submit" class="btn btn-primary my-sm-0">BROWS</button>                                
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Occupation:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Business" class="form-control" name="work" value="<?php echo $get_user_details->work; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">DOB:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="05/08/2010" class="form-control" id="datetimepicker1" name="dob" value="<?php echo $get_user_details->dob; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Email:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="sam@email.com" class="form-control" disabled="true" value="<?php echo $get_user_details->email; ?>" >
                                            <i class="ion-compose"></i>
                                            <a href="javascript:void(0);" class="btn btn-primary confirm my-2 my-sm-0 confirm_mail">Confirm</a>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Gender:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                    
                                            <select class="form-control" id="inputState" name="gender">
                                                <option value="1" <?php if($get_user_details->gender == 1){ ?> selected <?php } ?>>Female</option>
                                                <option value="0" <?php if($get_user_details->gender == 0){ ?> selected <?php } ?>>Male</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">ID Number:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="+100 112 33445566" class="form-control" name="client_code" value="<?php echo $get_user_details->client_code; ?>">
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="row">
                                    <div class="col-sm-12 mb-5 text-center">
                                        <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" value="Save Changes" />
                                    </div>
                                </div>
                                
                            </div>
                        </form>-->
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

    <script src="js/custom_validation_forbootstrap4.js"></script>   
    <script type="text/javascript">
      $(function() {
        //alert(1);
        $('#datetimepickerdob').datepicker({
           dateFormat: "yy-mm-d",
           maxDate:0
        });

        $("#confirm_phone_id").click(function (event) {
            $(".error-div-phone").html("Example: +593xxxxxxxx");
            $(".error-div-phone").css('display','block');
        });
        $("#confirm_phone_id").blur(function (event) {
            $(".error-div-phone").css('display','none');
        });

      });

    </script>
       <script>
           $(document).ready(function(){

               $(".profile_imgae_upload").on("change",function(){
                   var file = $('.profile_imgae_upload')[0].files[0].name;
                    $('.filename').text(file);
               });

               $(".save_otp").click(function(){
                    var otp_value = $("#otp").val();
                    var phone_number = $("#confirm_phone_id").val();
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
                                }else{
                                    alert('OTP does not match');
                                }
                            }
                        });
                    }
                });
                $(".save_otp_mail").click(function(){
                    var otp_value = $("#otp_mail").val();
                    var phone_number = $("#get_email").val();
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
                                }else{
                                    alert('OTP does not match');
                                }
                            }
                        });
                    }
                });

               $(".confirm_phone").click(function(){
                   
                   var phone = $("#confirm_phone_id").val();
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
               
               
              //  $('#edit_pf_form').formValidation({
              //       framework: 'bootstrap',
              //       excluded: ':disabled',
              //       icon: {
              //         valid: 'glyphicon glyphicon-ok',
              //         invalid: 'glyphicon glyphicon-remove',
              //         validating: 'glyphicon glyphicon-refresh'
              //       },
              //       fields: {
              //         'first_name': {
              //           validators: {
              //             notEmpty: {
              //               message: 'The first name is required and cannot be empty'
              //             },
              //             regexp: {
              //                   regexp: "^[a-zA-Z ]*$",
              //                   message: 'First name allows only alphabates'
              //             } 
              //           }
              //         },
              //         'last_name': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'The last name is required and cannot be empty'
              //                 },
              //                 regexp: {
              //                   regexp: "^[a-zA-Z ]*$",
              //                   message: 'Last name allows only alphabates'
              //                 } 
              //             }
              //         },
              //         'address': {
              //             validators: {
              //                 notEmpty: {
              //                   message: 'Address is required and cannot be empty'
              //                 }
              //             }
              //         },
              //         'country_list': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'Country must be selected'
              //                 }
              //             }
              //         },
              //         'states_list': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'State must be selected'
              //                 }
              //             }
              //         },
              //         'city_list': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'City must be selected'
              //                 }
              //             }
              //         },
              //         'phone': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'Phone number is required and cannot be empty'
              //                 },
              //                 regexp: {
              //                   //regexp: "^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$",
              //                   regexp: /^\+(?:[0-9] ?){1,15}[0-9]$/,
              //                   message: 'Number should contain "+" at first then number'
              //                 } 
              //             }
              //         },
              //         'dob': {
              //               validators: {
              //                 notEmpty: {
              //                   message: 'Date of Birth is required and cannot be empty'
              //                 }
              //             }
              //         }
              //     }
              // });
           });
       </script>
    <script>
   function getStateList(val) {
  $.ajax({
  type: "POST",
  url: "ajax_state.php",
  data:{country_id:val},
  success: function(data){
    $("#states_list").html(data);
    $("#city_list").html("<option value=''>Select City</option>");
  }
  });
}
   </script>
<script>
  function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }

  function isAlfa(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
          return false;
      }
      return true;
  }
   function getCityList(val) {
  $.ajax({
  type: "POST",
  url: "ajax_state.php",
  data:{state_id: val},
  success: function(data){
    $("#city_list").html(data);
  }
  });
}
   </script>
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
        }
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY " async defer type="text/javascript"></script><!--
