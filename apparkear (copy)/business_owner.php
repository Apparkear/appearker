<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>
<?php
session_start();
if($_SESSION['user_id']){ 
  $location = SITE_URL;
    header("Location: $location");
}
?>


<section class="container mt-5">
    <div class="py-5">
        <div class="row dark-bg p-4 pt-5">
            <!-- <h4 class="alert alert-secondary text-center" role="alert">Apparkear for Business</h4> -->

          <div class="col-6">
              <h4 class="pl-4">Register your Business</h4>
              <p class="pl-4">There are many variations of passages available, but the look even slightly there isn't anything majority.</p>
          </div>
          <div class="col-4 business-form">
            <form name="OwnerSignupForm" id="OwnerSignupForm" action="<?php echo SITE_URL."ajax_signup.php"; ?>" method="post" >
              <div class="form-group">
                  <label>First Name *</label>
                  <input type="text" class="form-control" name="first_name" id="first_name" onKeyPress="return isAlphaKey(event);">
                  <div class="error-div-first_name" style="display:none; color:red;"></div>
              </div>
              <div class="form-group">
                  <label>Last Name *</label>
                  <input type="text" class="form-control" name="last_name" id="last_name" onKeyPress="return isAlphaKey(event);">
                  <div class="error-div-last_name" style="display:none; color:red;"></div>
              </div>
              <div class="form-group">
                <label>Email*</label>
                <input type="text" class="form-control" name="email_address" id="email">
                <div class="error-div-email" style="display:none; color:red;"></div>
              </div>
              <div class="row">
                <div class="form-group col-6">
                    <label>Gender*</label>
                    <select class="form-control" name="gender" id="gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <div class="error-div-gender" style="display:none; color:red;"></div>
                </div>
                <div class="form-group col-6">
                    <label>Phone Number*</label>
                    <input type="text" class="form-control" name="phone" id="phone" maxlength="14" onKeyPress="return isNumberKey(event);">
                    <div class="error-div-phone" style="display:none; color:red;"></div>
                </div>
              </div>
              <div class="form-group">
                  <label>Password *</label>
                  <input type="password" class="form-control" name="pass" id="password">
                  <div class="error-div-password" style="display:none; color:red;"></div>
              </div>
              <div class="form-group">
                  <label>Confirm Password*</label>
                  <input type="password" class="form-control" name="cnfpassword" id="cnfpassword">
                  <div class="error-div-cnfpassword" style="display:none; color:red;"></div>
              </div>
              <input type="hidden" class="form-control" name="type" value="0">
              <div class="form-group mt-4">
                <button name="submit" class="btn btn-primary my-2 btn-block" type="submit">Submit</button>
              </div>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text There are many of available, but the majority </p>
            </form>
          </div>

          <div class="row b-image">
            <img src="./upload/user_image/business.png">
          </div>

          <div class="row mt-5">
              <div class="col-5">
                <h4 class="pl-4">Lorem Ipsum Doler</h4>
                <p class="pl-4">There are many variations of passages available, but the look even slightly there isn't anything majority.</p>
              </div>
              <div class="col-3">
                <div class="card" style="width: 100%">
                    <img class="card-img-top" src="./upload/user_image/business-icon1.png" alt="Card image cap">
                    <div class="card-body py-1">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
              </div>
              <div class="col-3">
                <div class="card" style="width: 100%">
                    <img class="card-img-top" src="./upload/user_image/business-icon2.png" alt="Card image cap">
                    <div class="card-body py-1">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up card's content.</p>
                    </div>
                </div>
              </div>
          </div>

          <div class="row my-4">
              <div class="col-5">

              </div>
              <div class="col-3">
                <div class="card" style="width: 100%">
                    <img class="card-img-top" src="./upload/user_image/business-icon3.png" alt="Card image cap">
                    <div class="card-body py-1">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
              </div>
              <div class="col-3">
                <div class="card" style="width: 100%">
                    <img class="card-img-top" src="./upload/user_image/business-icon4.png" alt="Card image cap">
                    <div class="card-body py-1">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up card's content.</p>
                    </div>
                </div>
              </div>
          </div>

        </div>



    </div>
</section>
<script src="js/custom_validation_forbootstrap4.js"></script>
<?php
include "include/footer.php";
?>