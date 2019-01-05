<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<section class="message-body mt-0">
        <div class="container">
            <div class="row">
              <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <!--/********************write code here***********************/-->

                    <div class="message p-4">
                        <h3>Select payment Method</h3>

                        <p class="mt-4">
                        <a class="btn btn-primary mr-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Card
                        </a>
                        <a class="btn btn-primary mr-2" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                            Net Banking
                        </a>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                            Other
                        </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body form">
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0">Card Holder Name:</label>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <input class="form-control" name="" placeholder="Samuel Doe">
                                    </div>
                                </div>
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0">Card Number:</label>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <input class="form-control" name="first_name" placeholder="123456789">
                                    </div>
                                </div>
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0">CVV Number:</label>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <input class="form-control" name="first_name" placeholder="123">
                                    </div>
                                </div>
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0">Expiry Date:</label>
                                    <div class="col-sm-5 edit-pro-frmfield">
                                        <select class="form-control" id="inputState" name="gender">
                                            <option value="1" selected="">April</option>
                                            <option value="0">May</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 edit-pro-frmfield">
                                        <select class="form-control" id="inputState" name="gender">
                                            <option value="1" selected="">2025</option>
                                            <option value="0">2026</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0"></label>
                                    <div class="col-sm-9">
                                    <input name="submit" class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" value="Submit Payment">
                                    </div>
                                </div>
                            </div></form>
                        </div>
                        <div class="collapse" id="collapseExample2">
                            <div class="card card-body form">
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0 text-right">First Name:</label>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <input class="form-control" name="first_name" placeholder="Samuel Doe" value="Maitrayee12">
                                        <i class="ion-compose"></i>
                                    </div>
                                </div>
                            </div></form>
                        </div>

                        <div class="collapse" id="collapseExample3">
                            <div class="card card-body form">
                                <div class="form-group row edit-pro-row">
                                    <label class="col-sm-3 col-form-label pr-0 text-right">Other</label>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                    </div>
                                </div>
                            </div></form>
                        </div>

                    </div>
                    
            </div>
                
        </div>
</section>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>