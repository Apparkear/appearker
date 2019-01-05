<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<section class="message-body mt-0">
    <div class="container">
        <div class="row">
            <?php include("include/sidebar.php"); ?>
            <div class="col-md-9">
                <!--/********************write code here***********************/-->
                <div class="message p-4">
                    <div class="text-center mt-5">
                        <img src="images/step-right.png">
                        <h2 class="active-text pt-4"><b>Success!</b></h2>
                        <h5>You have just rented a parking lot</h5>
                        <h2 class="active-text pt-3">$20.50</h2>
                        <a href="#" class="btn btn-primary edit-pro-sv-chng my-5">OK</a>
                    </div>
                </div>
            </div>

        </div>
</section>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>