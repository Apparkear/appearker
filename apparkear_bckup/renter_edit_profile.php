<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

if($_SESSION['user_type'] == 0){
     header("Location: index.php");
     exit;
}
include("include/header.php");
 ?>
<?php //echo $_SESSION['user_type']."Moi";
if($_SESSION['user_id'] == ''){  
   
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];





$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`= ".$_SESSION['user_id']));

?>
    <section class="profile-baner">
        <div class="container">
            <div class="profile-baner-img">
                <img src="images/renter-profile-baner.png" class="img-fluid">
                <div class="renter-img">
                    <span id="replaceimage">
                        <?php if($get_user_details->image){ ?>
                            <img src="./upload/user_image/<?php echo $get_user_details->image; ?>" class="img-fluid">
                        <?php }else{ ?>    
                            <img src="./upload/nouser.png" class="img-fluid">
                        <?php } ?>
                    </span>
                    <div class="img-edit upload-btn-wrapper" style="display: none;">
                        <i class="far fa-edit" id="uploadbox_profileimage"></i>
                        <input type="file" name="profile_image">
                    </div>
                </div>
                
            </div>
        </div>
    </section>
<?php //echo $_SESSION['user_type']."Moi"; ?>
    <section class="message-body">
        <div class="container pt-5">
            <div class="row">
                
                
                <div class="col-md-12">
                    <div class="">
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
                        <form class="pt-3 pb-5" method="post" action="ajax_renter_edit.php" enctype="multipart/form-data" id="renter_edit_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">First Name:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input class="form-control" id="first_name" name="first_name" placeholder="Samuel Doe" onkeypress="return isAlfa(event)" value="<?php echo $get_user_details->fname; ?>">
                                            <div class="error-div-fname" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Last Name:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Samuel Doe" id="last_name" class="form-control" name="last_name" onkeypress="return isAlfa(event)" value="<?php echo $get_user_details->lname; ?>">
                                            <div class="error-div-lname" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Address:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Newtown" id="autocomplete1" onFocus="geolocate()" class="form-control" name="address" value="<?php echo $get_user_details->address;?>">
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
                                    
                                            <select class="form-control" name='city_list' id= 'city_list'>
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
                                        <label class="col-sm-3 col-form-label px-0 text-right">Company/Educational Institution:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="Company/ Education"  class="form-control" name="comapny" value="<?php echo $get_user_details->company;?>">
<!--                                            <select class="form-control" id="inputState">
                                                <option selected="">West Bengal</option>
                                                <option>Mumbai</option>
                                            </select>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label text-right">Photo:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <div class="file-upload">
                                                <label for="upload" class="file-upload__label">
                                                    <small class="filename"> Upload </small>
                                                    <span>Browse</span>
                                                </label>
                                                <input id="upload" class="file-upload__input profile_imgae_upload" type="file" name="image">
                                            </div>                                
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Email:</label>
                                        <div class="col-sm-6 edit-pro-frmfield ">
                                            <input placeholder="sam@email.com" class="form-control" disabled="true" value="<?php echo $get_user_details->email; ?>">
<!--                                            <i class="ion-compose"></i>-->
                                        </div>
                                        <div class="col-sm-3">
                                            <button tabindex="0" class="btn btn-primary confirm my-2 my-sm-0 confirm_mail" data-toggle="modal" data-target="#exampleModalmail" <?php if($get_user_details->is_email != ''){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button>
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
                                        <label class="col-sm-3 col-form-label pr-0 text-right">DOB:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="2010-05-08"  class="form-control" id="datetimepickerdob" name="dob" value="<?php echo $get_user_details->dob; ?>">
                                            <div class="error-div-dob" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Password:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input  type="password" placeholder="........" class="form-control" name="user_pass" id="user_pass">
                                            <div class="error-div-pass" style="display:none; color:red;"></div>
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">ID Number:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="............." class="form-control" name="client_code" value="<?php echo $get_user_details->client_code; ?>" pattern="^\d{10}$"  maxlength="10"> 
                                            <i class="ion-compose"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-3 col-form-label pr-0 text-right">Phone:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input type="tel" placeholder="+100 112 33445566" title="only numbers allows" class="form-control" id="confirm_phone_id" name="phone" onkeypress="return isNumberKey(event)" value="<?php echo $get_user_details->phone; ?>">
                                            <i class="ion-compose"></i>
                                            <div class="error-div-phone" style="display:none; color:red;"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                                <div class="row">
                                    <div class="col-sm-12 mb-lg-5 text-center">
                                        <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" value="Save Changes" name="submit"/>
                                    </div>
                                </div>
                                
                        </form>
                    </div>
                    
                   
                </div>
            </div>
        </div>
    </section>
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

<script>
   
   
        $(document).ready(function(){
            
            $('#datetimepickerdob').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate:0
             });
            
            $("#confirm_phone_id").click(function (event) {
                $(".error-div-phone").html("Example: +593xxxxxxxx");
                $(".error-div-phone").css('display','block');
            });
            $("#confirm_phone_id").blur(function (event) {
                $(".error-div-phone").css('display','none');
            });
            
            $(".profile_imgae_upload").on("change",function(){
               var file = $('.profile_imgae_upload')[0].files[0].name;
                $('.filename').text(file);
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
               
//                $(document).on("click", "#uploadbox_profileimage", function () {
//                    $("#renter_edit_form").trigger("click");
//                });
//
//                $(document).on("change", "#renter_edit_form", function () {
//
//                    var file_data = $("#renter_edit_form").prop("files")[0];   
//                    //alert(file_data);return false;
//                    var form_data = new FormData();                 
//                    form_data.append("file", file_data);              
//                                    
//                    $.ajax({
//                        url: 'upload_pimage.php',
//                        data: form_data, 
//                        type: 'post', 
//                        success: function (result) {
//                          //alert(result);return false;
//                            if(result != 0){
//                                $("#replaceimage").html('');
//                               $("#replaceimage").html('<img src="./upload/user_image/'+result+'" class="img-fluid"/>');
//
//                //$("#navbarDropdown").load();
//                               //var url_link = window.location.href;
//                              // alert(url_link);
//                                //$('#prof').load(url_link+' #prof');
//                           }
//                        }
//                    });
//                });
               
               
//               $(".confirm_phone").click(function(){
//                   
//                   var phone = $("#confirm_phone_id").val();
//                   if(phone != ""){
//                        $.ajax({
//                            type:"POST",
//                            url:"ajax_editprofile.php",
//                            datatype:'json',
//                            data:{action:'confphone',phone:phone },
//                            success:function(data){
//                                //console.log(data); return false;
//                                //alert(data);
//                                if(data == 1){
//                                    //alert(1); return false;
//                                    alert($(this).text());
//                                    $(this).text("Confirmed");
//                                    $(this).attr("disabled");
//                                }
//                            }
//                        });
//                    }
//               });
               
           });
       </script>
    <script>
    function isNumberKey(evt)
    {
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

   function getStateList(val) {
        $.ajax({
            type: "POST",
            url: "administrator/get_states.php",
            data:'country_id='+val,
            success: function(data){
              $("#states_list").html(data);
            }
        });
    }

   function getCityList(val) {
        $.ajax({
            type: "POST",
            url: "administrator/get_states.php",
            data:'state_id='+val,
            success: function(data){
              $("#city_list").html(data);
            }
        });
    }
    

</script>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script src="js/custom_validation_forbootstrap4.js"></script>
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
