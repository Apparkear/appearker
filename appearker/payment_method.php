<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<section class="">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                <section class=" col-md-9 mb-3">
                    <div class="payment-page message">
                        <div class="div-center">
                            <div class="payment-form">
                                <h3 class="active-text">Payment Methods</h3>
                                <div class="card-pic row mb-4 accordion" id="accordionExample">
    																<button class="col-4" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  		<img src="images/credit-card-1.png" alt="" class="img-responsive">
                                      <h5>Card</h5>
    																</button>
    																<button class="col-4" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  		<img src="images/net-banking.png" alt="" class="img-responsive">
                                      <h5>Net Banking</h5>
    																</button>
    																<button class="col-4" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  		<img src="images/wallet.png" alt="" class="img-responsive">
                                      <h5>Wallet</h5>
    																</button>
                                </div>



                                    <h4 class="mb-30">Card Information</h4>
                                    <form class="form-area row" id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="form-group col-12">
                                            <label>Name Of Card Holder</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Card Number</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-4">
                                            <label>Expiry Month</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-4">
                                            <label>Expiry Date</label>
                                            <select class="form-control">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-4">
                                            <label>CVV</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-12 text-center mt-2">
                                            <button class="btn btn-primary">Continue</button>
                                        </div>
                                    </form>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">net.....
                                    </div>
                                     <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">wallet...
                                     </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
</section>



<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
