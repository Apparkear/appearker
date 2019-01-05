<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}
if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: $location");
    
}
if($_SESSION['add_session'] != 2){  
    $location = SITE_URL;
    header("Location: $location");
    
}
unset($_SESSION['six']);
unset($_SESSION['five']);
unset($_SESSION['four']);
unset($_SESSION['three']);
unset($_SESSION['two']);
unset($_SESSION['one']);
unset($_SESSION['add_session']);

include("include/header.php");

unset($_SESSION['new_parking']);
unset($_SESSION['parking_contact']);
 ?>

        <div class="container">
               <div class="row my-5">
                   <div class="col-md-2">              
                   </div>
                   <div class="col-md-8">
                        <div class="shadow-bg">

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Confirmation</h4>
                                    <div class="text-center my-4 p-3">
                                        <img src="images/step-right.png">
                                        <h3 class="my-3">Your parking lots is successfully posted!!</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <a href="dashboard_user.php" class="btn btn-primary edit-pro-sv-chng mt-4">Go to Dashboard</a>
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

<script type="text/javascript">
history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>