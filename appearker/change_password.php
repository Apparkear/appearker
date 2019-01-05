<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: index.php");
    
}


include("include/header.php");
 ?>
<?php 


if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: index.php");
    
}
if(isset($_REQUEST['submit'])) {
   
    $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
    $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';
    $user_id = $_SESSION['user_id'];
  
    $result = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id` = '" . $user_id . "' AND `password` = '".md5($old_pass)."'"));
    
    if ($result) {
        $query = mysqli_query($link,"UPDATE `estejmam_user` SET `password`='" . md5($new_pass) . "' WHERE `id` = '$user_id'");
      
        $_SESSION['msg'] = "successfully updated";
    }else{
        $_SESSION['msg'] = "current password does not match";
        
    }
  
}


?>

 <section class="message-body">
        <div class="container">
            <div class="row">
              <?php include("include/sidebar.php");?>
              <div class="col-md-9">
                    <div class="chng-pswrd">
                        <div id="ack" style="color:red; text-align: center;"><?php if($_SESSION['msg']){ echo $_SESSION['msg']; } ?></div>
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
                        <form class="pt-3 pb-5" method="post" action="change_password.php" id="passchngForm">
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label  class="col-sm-4 col-form-label pr-0 pl-0 text-right">Old Password:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="password" class="form-control" id="old_pass" name="old_pass" required  placeholder="******">
                                            <div class="error-div-crntpass" style="display:none; color:red;"></div>
                                                                    
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right">New Password:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="password" class="form-control" id="user_pass"  name="new_pass" required placeholder="******">
                                            <div class="error-div-pass" style="display:none; color:red;"></div>
                                                                    

                                        </div>
                                    </div>
                                </div>
                                                           
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right">Confirm Password:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="password" class="form-control" id="cnf_password" required name="cnf_pass" placeholder="******">
                                            <div class="error-div-cnfpass" style="display:none; color:red;"></div>
                                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-2 offset-sm-7">
                             <input class="btn btn-primary chng-pswrd-btn" type="submit" name="submit" value="Save" />
                                </div>
                            </div>                            
                        </form>
                    </div>
                    
                   
                </div> 
            </div>
        </div>
 </section>

  <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script src="js/custom_validation_forbootstrap4.js"></script>
<script>
    $(document).ready(function(){
//      $("#passchngForm").formValidation({
//        framework: 'bootstrap',
//        excluded: ':disabled',
//        icon: {
//          valid: 'glyphicon glyphicon-ok',
//          invalid: 'glyphicon glyphicon-remove',
//          validating: 'glyphicon glyphicon-refresh'
//        },
//        fields: {
//          'new_pass': {
//            validators: {
//              notEmpty: {
//                message: 'The password is required and cannot be empty. '
//                },
//                // stringLength: {
//                //     //message: 'Password must be atleast 8 characters long ',
//                //     min: 8
//                // },
//                regexp: {
//                        regexp: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$",
//                        message: 'Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter'
//                }
//            }
//        },
//          'cnf_pass': {
//            validators: {
//              notEmpty: {
//                message: 'The password is required and cannot be empty.'
//                },
//                identical: {
//                    field: 'new_pass',
//                    message: 'The password and its confirm password are not the same'
//                }
//            }
//          }
//        }
//      });
  });
</script>

</body>

      </html>