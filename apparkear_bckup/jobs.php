<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>


<section class="baner">
    <div class="baner-img" style="background: url(./upload/sitebanner/jobs.jpg) no-repeat;min-height: 300px;
    opacity: 0.6;">
        <div class="container text-center pt-4">
            <div class="baner-text text-bg">
                <h1 class="mb-0"><b>Jobs</b></h1>
            </div>
        </div>
    </div>

</section>
<?php if($_SESSION['msg']){ ?>
        <div class="error-log p-4 alert-msg" ><?php echo $_SESSION['msg']; ?></div>
<?php } 
unset($_SESSION['msg']); ?>
<section class="container">
    <div class="py-5">
        <div class=" p-3">
            <div class="p-4">
              <h5 class="active-text">There are many variations of passages of Lorem</h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
              <h5 class="active-text">Richard McClintock, a Latin professor</h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia. <br>looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
              <h5 class="active-text">Lorem Ipsum passages, and more recently with desktop publishing </h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>

          </div>
        </div>

    </div>
</section>
<div class="container">
  <h4 class="border-bottom text-center mb-5">Fill up this form</h4>
  <form id="jobForm" method="post" action="ajax_send_job.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row edit-pro-row">
                <label class="col-sm-3 col-form-label pr-0 text-right">First Name:</label>
                <div class="col-sm-9 edit-pro-frmfield">
                    <input class="form-control" name="first_name" id="first_name" placeholder="Samuel" onkeypress="return isAlfa(event)">
                    <div class="error-div-fname" style="display:none; color:red;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row edit-pro-row">
                <label class="col-sm-3 col-form-label pr-0 text-right">Last Name:</label>
                <div class="col-sm-9 edit-pro-frmfield">
                    <input class="form-control" name="last_name" id="last_name" placeholder="Doe" onkeypress="return isAlfa(event)">
                    <div class="error-div-lname" style="display:none; color:red;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row edit-pro-row">
                <label class="col-sm-3 col-form-label pr-0 text-right">Email:</label>
                <div class="col-sm-9 edit-pro-frmfield">
                    <input class="form-control" name="email" id="email" placeholder="user@email.com">
                    <div class="error-div-email" style="display:none; color:red;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group row edit-pro-row">
              <label class="col-sm-3 col-form-label pr-0 text-right">Phone:</label>
              <div class="col-sm-9 edit-pro-frmfield">
                  <input class="form-control" name="phone" id="phone" maxlength="14" placeholder="+xxxxxxxxxxxxx" onkeypress="return isNumberKey(event)">
                  <div class="error-div-phone" style="display:none; color:red;"></div>
              </div>
          </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group row edit-pro-row">
            <label class="col-sm-3 col-form-label pr-0 text-right">City:</label>
            <div class="col-sm-9 edit-pro-frmfield">
                <input class="form-control" name="city" id="city" placeholder="Cuenca" onkeypress="return isAlfa(event)">
                <div class="error-div-city" style="display:none; color:red;"></div>
            </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group row edit-pro-row">
            <label class="col-sm-3 col-form-label text-right">Upload CV:</label>
            <div class="col-sm-9 edit-pro-frmfield">
                  <div class="file-upload">
                      <label for="upload" class="file-upload__label">
                          <small class="filename"> Upload </small>
                          <span>Browse</span></label>
                      <input id="upload" class="file-upload__input cv_upload" type="file" name="cv">
                      <div class="error-div-cv" style="display:none; color:red;"></div>
                  </div>

              </div>
        </div>
    </div>
    
    <div class="col-sm-12 mb-lg-5 text-center">
        <button name="submit" class="btn btn-primary my-2 edit-pro-sv-chng" type="submit">Submit</button>
    </div>
  </div>
</form>
</div>


<?php
include "include/footer.php";
?>

<script src="js/custom_validation_forbootstrap4.js" type="text/javascript"></script>
<script type="text/javascript">
  $(".cv_upload").on("change",function(){
     var file = $('.cv_upload')[0].files[0].name;
      $('.filename').text(file);
  });
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
</script>
