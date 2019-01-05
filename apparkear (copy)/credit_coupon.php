<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 
if($_SESSION['user_id'] == ''){  //echo "vkjfkfj";exit;
   $location = SITE_URL;
    header("Location:index.php");
  //  exit;
} 

/*************************Header********************************/
include("include/header.php");
?>

<section class="message-body">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
      </div>
      <div class="col-md-9">
        <div class="chng-pswrd pt-5">
            <h4 class="text-center active-text mb-4">Credit & Coupon</h4>
                <form class="pt-3 pb-5" method="post" action="change_password.php" id="passchngForm">
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right">Coupon Code:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="text" class="form-control" id="old_pass" name="old_pass" required="" placeholder="256ghl012">
                                                                    
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right">Coupon Ammount:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="text" class="form-control" id="old_pass" name="old_pass" required="" placeholder="$150">
                                                                    
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right">Coupon Validity:</label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="text" class="form-control" id="old_pass" name="old_pass" required="" placeholder="dd-mm-yyyy">
                                                                    
                                        </div>
                                    </div> 
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-4 col-form-label pr-0 pl-0 text-right"></label>
                                        <div class="col-sm-8 edit-pro-frmfield">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Contrary to popular belief, not simply random text.</label>
                                                                    
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-sm-2">
                             <input class="btn btn-primary" type="submit" name="submit" value="Save">
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