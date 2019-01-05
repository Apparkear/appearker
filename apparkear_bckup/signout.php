<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>

<section class="message-body">
        <div class="container">
            <div class="row">
              <?php include("include/sidebar.php");?>
 <!--***************************Write code here***************************/-->
 			<div class="col-md-9">
                    <div class="my-properties">
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
                        <form class="pt-5 pb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-12">
                                	<div class="dash-succes text-center"> 
                                		<img class="img-fluid" alt="" src="images/tick-mark.png"> 
                                		<h2>You are successfully signed out </h2>
                                		<button type="submit" class="btn btn-primary chng-pswrd-btn text-uppercase"> Sign In </button> 
                                	</div>                                     
                                </div>
                               
                            </div>
                            </form></div>
                        
                    </div>
 
            </div>
        </div>
 </section>

  <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>