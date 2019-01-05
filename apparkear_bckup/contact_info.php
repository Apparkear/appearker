 <?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<!--***************************Write code here***************************/-->

<section class="mt-2">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="col-md-9">
				<div class="contact-info-area">
                    <h4 class="">Reservation and Time Preferences</h4>
					<div class="row mt-5">
						<div class="col-md-9 hints-div">
                           
                            <form>
							    <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">First Name:</label>
                                    <div class="col-sm-9 con-info-frmfield">
                                            <input placeholder="First Name" class="form-control">  
                                    </div>
                                </div>
                                        
                                <div class="form-group row con-info-row">
                                        <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Last Name:</label>
                                    <div class="col-sm-9 con-info-frmfield">
                                            <input placeholder="Last Name" class="form-control">  
                                    </div>
                                </div> 
                                    
                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Email:</label>
                                    <div class="col-sm-6 con-info-frmfield pr-0">
                                        <input placeholder="Email" class="form-control">  
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary btn-block" type="submit"> Confirm </button> 
                                    </div>
                                </div>
                                    
                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Home/Work Phone:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Phone Number" class="form-control">   
                                    </div>    
                                </div>
                                    
                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Mobile (Primary):</label>
                                    <div class="col-sm-6 con-info-frmfield pr-0">
                                        <input placeholder="Mobile Number" class="form-control">  
                                    </div>
                                    <div class="col-sm-3">
                                        <button tabindex="0" class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#exampleModal">Confirm </button> 
                                        
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mb-0">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="I will send OTP in the phone & one popup will open for put once user put that will be verified"><img src="images/Question.png" class="pr-1"></a>
                                                </div>
                                            </div>
                                         </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Validation Number:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Validation Number" class="form-control">  
                                    </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <label class="col-sm-3 con-info-label pr-0 pl-0 text-right">Alternate Contact Phone:</label>
                                    <div class="col-sm-9 con-info-frmfield pr-0">
                                        <input placeholder="Phone number" class="form-control">  
                                    </div>
                                </div>

                                <div class="form-group row con-info-row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline2">
                                            <label class="custom-control-label" for="customControlInline2">Terms and conditions agreement</label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="form-group row con-info-row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 edit-pro-frmfield">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline1">
                                            <label class="custom-control-label" for="customControlInline1">Newsletter agreement</label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row ml-2">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-primary my-2 edit-pro-sv-chng" type="submit">Back</button>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-primary my-2 edit-pro-sv-chng" type="submit">Next</button>
                                                </div>
                                            </div>                                                                  
                                        </div>
                                </div>
                            </form>                    
						</div>
						<div class="col-md-3 hints">
                            <img src="images/hints.png">
                        </div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">OTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function () {
    $('[data-toggle="popover"]').popover()
})
</script>

<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
 <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>

