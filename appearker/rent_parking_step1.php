<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 


if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: index.php");
    
}
if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: index.php");
    
}
/***************Header********************/
include("include/header.php");

$user_id = $_SESSION['user_id'];
if($_SESSION['new_parking']){
    $get_parking  = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$_SESSION['new_parking']}"));
    
    $user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking_contact` WHERE `id`={$get_parking->contact}"));

    $fname= $user_details->first_name;
    $lname= $user_details->last_name;
    $email =$user_details->email;
    $phone =$user_details->phone;
    $mobile =$user_details->mobile;
    $validation_number =$user_details->validation_number;
    $alternate_phone =$user_details->alternate_phone;
    $terms_n_cond_agree =$user_details->terms_n_cond_agree;
    $newsletter_agree =$user_details->newsletter_agree;
    
}else{
    $user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));
    
    $fname= $user_details->fname;
    $lname= $user_details->lname;
    $email =$user_details->email;
    $phone =$user_details->phone;
    $mobile =$user_details->phone;
    $validation_number ="";
    $alternate_phone ="";
    $terms_n_cond_agree =0;
    $newsletter_agree =0;
    
}

$confirm_mobile = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `confirmation` WHERE `user_id`=".$user_id." AND `phone_number` ='".$mobile."'")) ;
//print_r($confirm_mobile); echo "kjfkjfdg";
if($confirm_mobile != ""){
    $is_confirm_mobile = 1;
}else{
    $is_confirm_mobile = 0;
}

$confirm_mail = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM `confirmation` WHERE `user_id`=".$user_id." AND `mail_address` ='".$email."'")) ;
//print_r($confirm_mobile); echo "kjfkjfdg";
if($confirm_mail != ""){
    $is_confirm_mail = 1;
}else{
    $is_confirm_mail = 0;
}

//print_r($user_details);

?>



<section class="mt-2">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-md-9">
				<div class="contact-info-area">
                    <h4 class="">Reservation and Time Preferences</h4>
					<div class="row mt-5">
						<div class="col-md-9 hints-div">
                           
                                                    <form id="rent_step1" method="post" action="ajax_contact.php" >
							    <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">First Name:</label>
                                    <div class="col-sm-9 con-info-frmfield">
                                            <input placeholder="First Name" id="first_name" class="form-control" name='first_name' value='<?php echo $fname; ?>' onkeypress="return isAlphaKey(event);">  
                                            <div class="error-div-fname" style="display:none; color:red;"></div>
                                    </div>
                                </div>
                                        
                                <div class="form-group row con-info-row">
                                        <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Last Name:</label>
                                    <div class="col-sm-9 con-info-frmfield">
                                            <input placeholder="Last Name" id="last_name" class="form-control" name='last_name' value='<?php echo $lname; ?>' onkeypress="return isAlphaKey(event);">  
                                            <div class="error-div-lname" style="display:none; color:red;"></div>
                                    </div>
                                </div> 
                                    
                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Email:</label>
                                    <div class="col-sm-6 con-info-frmfield pr-0">
                                        <input placeholder="Email" type="text" id="email" required class="form-control" name='email' id="email" value='<?php echo $email; ?>'>  
                                        <div class="error-div-email" style="display:none; color:red;"></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary btn-block confirm_mail" type="button" data-toggle="modal" data-target="#exampleModalmail" <?php if($is_confirm_mobile == 1){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button> 
                                    </div>
                                </div>
                                    
                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Home/Work Phone:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Phone Number" id="phone1" class="form-control onlynumber" name='phone' value='<?php echo $phone; ?>' onkeypress="return isNumberKey(event);" maxlength="14">   
                                        <div class="error-div-telephone" style="display:none; color:red;"></div>
                                    </div>    
                                </div>
                                    
                                <div class="form-group row con-info-row mb-2">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Mobile (Primary):</label>
                                    <div class="col-sm-6 con-info-frmfield pr-0">
                                        <input placeholder="Mobile Number" required class="form-control onlynumber" name='mobile' id="mobile" value='<?php echo $mobile; ?>' onkeypress="return isNumberKey(event);" maxlength="14">  
                                        <div class="error-div-mobile" style="display:none; color:red;"></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <button tabindex="0" class="btn btn-primary btn-block confirm_phone" type="button" data-toggle="modal" data-target="#exampleModal" <?php if($is_confirm_mail == 1){ ?> disabled >Confirmed<?php }else{ ?>>Confirm<?php } ?></button> 
                                        
                                    </div>
                                </div>

                                <div class="row justify-content-center mb-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mb-0">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="I will send OTP in the phone & one popup will open for put once user put that will be verified"><img src="images/Question.png" class="pr-1">
                                                    </a>
                                                </div>
                                            </div>
                                         </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Validation Number:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Validation Number" class="form-control" name='validation_number' value="<?php echo $validation_number; ?>" onkeypress="return isNumberKey(event);" maxlength="14">  
                                    </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Alternate Contact Phone:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Phone number" class="form-control" name='alternate_phone' value="<?php echo $alternate_phone; ?>" onkeypress="return isNumberKey(event);" maxlength="14">  
                                    </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" required id="customControlInline2" name='terms_n_cond_agree' <?php if($terms_n_cond_agree == 1){ ?>checked <?php } ?>>
                                            <label class="custom-control-label" for="customControlInline2">Terms and conditions agreement</label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="form-group row con-info-row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline1" name='newsletter_agree' <?php if($newsletter_agree == 1){ ?>checked <?php } ?>>
                                            <label class="custom-control-label" for="customControlInline1">Newsletter agreement</label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row ml-2">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-3">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" style="color:#ffffff" href="index.php">Back</a>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input class="btn btn-primary my-2 save_contact submitbtn" type="submit" name="submit" <?php if($is_confirm_mobile == 0 || $is_confirm_mail == 0){ ?> disabled <?php } ?> value="Next" />
                                                </div>
                                            </div>                                                                  
                                        </div>
                                </div>
                            </form>                    
						</div>
						<div class="col-md-3 hints">
                            <img src="images/hints.png">
                        </div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<script src="<?php echo SITE_URL; ?>js/custom_validation_forbootstrap4.js"></script>
<script>
//$('.popover-dismiss').popover({
//  trigger: 'focus'
//})
</script>

<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

  <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script>
    $(document).ready(function(){
        // $(".onlynumber").keypress(function (event) {
        //     var keycode = event.which;
        //     if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        //         event.preventDefault();
        //     }
        // });
        $("#phone1").click(function (event) {
            $(".error-div-telephone").html("Example: +593xxxxxxxx");
            $(".error-div-telephone").css('display','block');
        });
        $("#phone1").blur(function (event) {
            $(".error-div-telephone").css('display','none');
        });
        $("#mobile").click(function (event) {
            $(".error-div-mobile").html("Example: +593xxxxxxxx");
            $(".error-div-mobile").css('display','block');
        });
        $("#mobile").blur(function (event) {
            $(".error-div-mobile").css('display','none');
        });
        
        $(".save_otp").click(function(){
            var otp_value = $("#otp").val();
            var phone_number = $("#mobile").val();
            if(phone_number != ""){
                $.ajax({
                    type:"post",
                    url:"ajax_otp.php",
                    datatype:"json",
                    data:{otp_value:otp_value, otp_type:'phone', phone_number:phone_number},
                    success:function(result){
                        if (result==1) {
                            $('#exampleModal').modal('hide');
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
                    url:"ajax_otp.php",
                    datatype:"json",
                    data:{otp_value:otp_value, otp_type:'mail', phone_number:phone_number},
                    success:function(result){
                        //alert(result); return false;
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
                   
            var phone_number = $("#mobile").val();
            if(phone_number != ""){
                 $.ajax({
                     type:"POST",
                     url:"ajax_confirm_phone.php",
                     datatype:'json',
                     data:{action:'confphone',phone:phone_number },
                     success:function(data){
                        console.log(data); return false;
                         //alert(data);
                         if(data == 1){
                             //alert(1); return false;
                             //alert($(this).text());
                             $(this).text("Confirmed");
                             $(this).attr("disabled");
                         }
                     }
                 });
             }
        });
        $(".confirm_mail").click(function(){
                   
            var phone_number = $("#email").val();
            if(phone_number != ""){
                 $.ajax({
                     type:"POST",
                     url:"ajax_confirm_phone.php",
                     datatype:'json',
                     data:{action:'confmail',phone:phone_number },
                     success:function(data){
                        console.log(data); return false;
                         //alert(data);
                         if(data == 1){
                             //alert(1); return false;
                             //alert($(this).text());
                             $(this).text("Confirmed");
                             $(this).attr("disabled");
                         }
                     }
                 });
             }
        });
        
        
//        
//        $('#rent_step1').formValidation({
//                    framework: 'bootstrap',
//                    excluded: ':disabled',
//                    icon: {
//                      valid: 'glyphicon glyphicon-ok',
//                      invalid: 'glyphicon glyphicon-remove',
//                      validating: 'glyphicon glyphicon-refresh'
//                    },
//                    fields: {
//                      'first_name': {
//                        validators: {
//                          notEmpty: {
//                            message: 'The first name is required and cannot be empty'
//                          },
//                          regexp: {
//                                regexp: "^[a-zA-Z ]*$",
//                                message: 'First name allows only alphabates'
//                          } 
//                        }
//                      },
//                      'last_name': {
//                            validators: {
//                              notEmpty: {
//                                message: 'The last name is required and cannot be empty'
//                              },
//                              regexp: {
//                                regexp: "^[a-zA-Z ]*$",
//                                message: 'Last name allows only alphabates'
//                              } 
//                          }
//                      },
//                      'email': {
//                        validators: {
//                          notEmpty: {
//                            message: 'The email is required and cannot be empty'
//                          },
//                        regexp: {
//                                regexp: "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$",
//                               message: 'Please enter valid email address'
//                        }      
//                                
////                          emailAddress: {
////                            message: 'Please enter valid email'
////                          }
//                        }
//                      },
//                      'phone': {
//                            validators: {
//                              notEmpty: {
//                                message: 'Phone number is required and cannot be empty'
//                              },
//                              regexp: {
//                                regexp: "^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$",
//                                message: 'Number should contain "+" at first then number'
//                              } 
//                          }
//                      },
//                      'mobile': {
//                            validators: {
//                              notEmpty: {
//                                message: 'Phone number is required and cannot be empty'
//                              },
//                              regexp: {
//                                regexp: "^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$",
//                                message: 'Number should contain "+" at first then number'
//                              } 
//                          }
//                      }
//                  }
//              });
    });
</script>