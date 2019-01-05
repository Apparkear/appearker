<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>

<section class="">
    <div class="container">
        <div class="row">
            <?php include("include/sidebar.php");?>
            <div class="col-md-9">
                <div class="message p-4" id="appendchatlist">
                    <p class="mb-5 mt-2">
                        <a class="settings-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
                            <i class="far fa-bell pr-2"></i>Notifications
                        </a>
                        <a class="settings-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-user-cog pr-2"></i>Mail Notifications
                        </a>
                        <a class="settings-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-question-circle pr-2"></i>Help
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            
                            <div class="row">  
                               <div class="col-lg-12 mt-1 mb-3">
                                    <div class="form-group row edit-pro-row">
                                        <label class="col-sm-2 col-form-label text-right">Email:</label>
                                        <div class="col-sm-9 edit-pro-frmfield">
                                            <input placeholder="user@email.com" class="form-control" id="confirm_email" name="phone" onkeypress="return isNumberKey(event)" value="">
                                            <i class="ion-compose"></i>
                                            <div class="error-div-phone" style="display:none; color:red;"></div>
                                            <button type="button" tabindex="0" class="btn btn-primary confirm my-2 my-sm-0 confirm_phone" data-toggle="modal" data-target="#exampleModalphone">Confirm</button>
                                        </div>
                                    </div>
                                   <div class="media my-review">
                                       <img class="mr-3 rounded-circle" src="./upload/user_image/fixed-pic-d.jpg" alt="image">
                                       <div class="media-body"> 
                                           <p class="mb-2">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
                                           <p class="student mb-0"> <i class="far fa-clock"></i> 4 hours ago</p>
                                       </div>
                                   </div>
                                   <div class="media my-review">
                                       <img class="mr-3 rounded-circle" src="./upload/user_image/pic-fix1.jpg" alt="image">
                                       <div class="media-body"> 
                                           <p class="mb-2">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
                                           <p class="student mb-0"> <i class="far fa-clock"></i> 4 hours ago</p>
                                       </div>
                                   </div>
                               </div>
  
                               <div class="col-lg-12 mt-1 mb-3">
                                   <div class="media my-review">
                                       <img class="mr-3 rounded-circle" src="./upload/user_image/fixed-pic-e.jpg" alt="image">
                                       <div class="media-body"> 
                                           <p class="mb-2">Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, for those interested. Sections making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
                                           <p class="student mb-0"> <i class="far fa-clock"></i> 4 hours ago</p>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-12 mt-1 mb-0 text-center">
                                   <a href="#">See All</a>
                               </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
include "include/footer.php";
?>