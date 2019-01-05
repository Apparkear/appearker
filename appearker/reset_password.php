<?php
ob_start();
session_start();
include("administrator/includes/config.php");
require_once "./PHPMailer/class.phpmailer.php";
include("include/header.php");


if(isset($_REQUEST['submit'])) {
   //echo '1Mo9i';exit;
    $user_email = $_POST['email']; 
    $user_pass = $_POST['user_pass'];
    $get_user = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `email` = '" . $user_email . "'"));
      //print_r($get_user); exit;
    if(empty($get_user)){
        $data['ack']= 0;
    }else{
       $result = mysqli_query($link,"UPDATE `estejmam_user` SET `password`='" . md5($user_pass) . "' WHERE `id` = '$get_user->id'");
       if($result == 1){
          $data['ack'] =1 ;
          $_SESSION['username'] = $get_user->fname . ' ' . $get_user->lname;
            //$_SESSION['landlord_id'] = $row->id;
            $_SESSION['user_id'] = $get_user->id;
       }else{
          $data['ack']= 0;
       } 
    }
    if($data['ack'] ==1){
        $_SESSION['msg'] = "Successfully Updated";
        header("Location: index.php");
        die();
    }else{
        $_SESSION['msg'] = "Invalid email";
        header("Location: index.php");
        die();
    }
    
   
    
    
    exit;
    
}



?>




	<section class="login_plane pb-5 forgot-password-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5 col-md-7">
					<div class="log_in_full">
						<div class="logo_login text-center">
							<img src="./upload/site_logo/<?php echo $logo->sitelogo; ?>" style="margin: 15px auto;"/>
						</div>
						<p class="mt-4"><b>Forget Password</b></p>

						<div class="login_box" >
					 		<div id="ack" style="color:red;margin-left: 84px;"></div>
					 		<div id="ack1" style="color:green;margin-left: 84px;"></div>
                                                        <form method="post" action="reset_password.php" id="forget_form">

					  			<div class="form-group">
                                                                    <label style="font-weight:500;" for="exampleInputEmail1">New password</label>
                                                                    <input type="password" class="form-control" id="user_pass" aria-describedby="emailHelp" placeholder="new password" required name="user_pass">
                                                                    <div class="error-div-pass" style="display:none; color:red;"></div>
                                                                    <input type="hidden" value="<?php echo base64_decode($_REQUEST['liame']); ?>" name="email"/>
                                                                </div>
					  			<div class="form-group">
                                                                    <label style="font-weight:500;" for="exampleInputEmail1">Confirm Password</label>
                                                                    <input type="password" class="form-control" id="cnf_password" aria-describedby="emailHelp" placeholder="confirm new password" required name="cnf_password">
                                                                    <div class="error-div-cnfpass" style="display:none; color:red;"></div>
                                                                </div>
					   			<div class="form-group" style="padding-top: 15px;margin-bottom: 15px;">
                                                                    <!--<input type="submit" name="submit" style="display:none" />-->
                                                                    <input type="submit" name="submit" style="margin: 0 auto; padding: 7px 30px;" class="btn btn-primary"  id="btn" value="Submit">
					  			</div>
				   			</form>
				   
				   			
						</div>
				 	</div>
				</div>
			</div>
		</div>
	</section>

<?php
include("include/footer.php");
?>

<!--	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>-->
<script src="js/custom_validation_forbootstrap4.js"></script>
	<script>
		$(window).scroll(function(){
		    if ($(window).scrollTop() >= 100) {
		       $('.navbar-fixed-top').css('background','rgba(0,0,0,.8)');
		    }
		    else {
		       $('.navbar-fixed-top').css('background','none');
		    }
		});
	</script>
	
<!--   <script>
       $(document).ready(function(){
           
           
           $("#btn").click(function(){ //alert("xdgfjdfhg");exit;
               
               
               
               var user_pass = $("#user_pass").val();
               var cnf_password = $("#cnf_password").val();
               //alert(user_pass);
              var is_valid_pass = validate_password(user_pass);
              //alert(is_valid_pass);
              var is_valid_cnf_pass = validate_password(cnf_password);
              
               
               if(is_valid_pass == 0){
                   $(".error-div-pass").html("this field can not be empty"); 
                   $(".error-div-pass").css('display','block');
                   setTimeout(function(){ 

                    $(".error-div-pass").fadeOut();
                    },1500);
                  // alert("Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter");
               }
               if(is_valid_cnf_pass == 0){
                   $(".error-div-cnfpass").html("this field can not be empty");
                   $(".error-div-cnfpass").css('display','block');
                    setTimeout(function(){ 

                    $(".error-div-cnfpass").fadeOut();
                    },1500);
                   //alert("Confirm Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter");
               }
               
               if(is_valid_pass == 1 && is_valid_cnf_pass == 1){
                  // alert("both1");
                   var is_same = check_password_validation(user_pass,cnf_password);
                  // alert(is_same);
                   if(is_same == 0){
                       // alert("The password and its confirm password are not the same");
                       $(".error-div-cnfpass").html("The password and its confirm password are not the same"); 
                       $(".error-div-cnfpass").css('display','block');
                        setTimeout(function(){ 

                    $(".error-div-cnfpass").fadeOut();
                    },1500);
                       
                   }else{
                       $("form").submit();
                       //$("#forget_form").submit();
                   }
               }
               
               
//               if(user_pass != "" && cnf_password !=""){
//                    if(user_pass == cnf_password){
//                        $("#forget_form").submit();
//                    }else{
//                        $("#user_password").focus();
//                        $("#user_password").css("border","red");
//                    }
//                }
           });
           
           
           
//           $("#forget_form").formValidation({
//                framework: 'bootstrap',
//                excluded: ':disabled',
//                icon: {
//                  valid: 'glyphicon glyphicon-ok',
//                  invalid: 'glyphicon glyphicon-remove',
//                  validating: 'glyphicon glyphicon-refresh'
//                },
//                fields: {
//                  'user_pass': {
//                    validators: {
//                      notEmpty: {
//                        message: 'The password is required and cannot be empty. '
//                        },
//                        // stringLength: {
//                        //     //message: 'Password must be atleast 8 characters long ',
//                        //     min: 8
//                        // },
//                        regexp: {
//                                regexp: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$",
//                                message: 'Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter'
//                        }
//                    }
//                },
//                  'cnf_password': {
//                    validators: {
//                      notEmpty: {
//                        message: 'The password is required and cannot be empty.'
//                        },
//                        identical: {
//                            field: 'user_pass',
//                            message: 'The password and its confirm password are not the same'
//                        }
//                    }
//                  }
//                }
//              });
//           
       });
       function check_password_validation(pass, cnfpass){
           if(pass && cnfpass){
               if(pass == cnfpass){
                   return 1;
               }else{
                   return 0;
               }
               
           }else{
               return 0;
           }
       }
       
       function validate_password(get_pass){
           //alert(get_pass);
            var regex = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$";
           
            if (get_pass.match(regex)) {
     
                return 1;
            }else{
                return 0;
            }
       }
	</script>-->
</body>
</html>