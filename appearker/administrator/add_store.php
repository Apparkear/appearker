<?php include_once("controller/storeController.php");?>
<?php include('includes/header.php');?>
<!-- END HEADER -->


<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php include('includes/left_panel.php');?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			<?php //include('includes/style_customize.php');?>
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Store <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Store</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="list_store.php">Store</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Store</span>
					</li>
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Store
										</div>
										<!--<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											
											<a href="javascript:;" class="reload">
											</a>
											<a href="javascript:;" class="remove">
											</a>
										</div>-->
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="#" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
											
											<div class="form-body">
											
												
												<div class="form-group">
													<label class="control-label col-md-3">Category</label>
													<div class="col-md-4">
														<select class="form-control"  name="store_cat_id" >
																<option value="" >Select One</option>
															  <?php 
																$SQL ="SELECT * FROM `estejmam_store_category`";
																$result = mysql_query($SQL);

																while($row1=mysql_fetch_array($result))
																{ 
																?>
																<option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['store_cat_id']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
																<?php
																}
																?>
														</select>
														                              
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3">Store Package</label>
													<div class="col-md-4">
														<select class="form-control" id="store_package"  name="store_package"  >
															<option value="">Select One</option>
															<?php 
															$SQL ="SELECT * FROM `estejmam_store_package`";
															$result = mysql_query($SQL);

															while($row1=mysql_fetch_array($result))
															{ 
															?>
															<option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['package_id']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
															<?php
															}
															?>
														</select>
														                              
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Name</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Name" value="<?php echo $categoryRowset['store_title'];?>" name="store_title" required>
														
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Ntn Number</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter NTN Number" value="<?php echo $categoryRowset['ntn']; ?>" name="ntn" required>
														
													</div>
												</div>
												
												
												
													<div class="form-group">
												<label class="control-label col-md-3">Description</label>
												<div class="col-md-9">
												<textarea class="ckeditor form-control" id="editor1" name="store_details" rows="6"><?php echo stripslashes($categoryRowset['store_details']);?></textarea>
												</div>
												</div>
												
													<div class="form-group">
												<label class="control-label col-md-3">Address</label>
												<div class="col-md-9">
												<textarea class="ckeditor form-control" id="editor1" name="address" rows="6"><?php echo stripslashes($categoryRowset['address']);?></textarea>
												</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Location</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Location" value="<?php echo $categoryRowset['location']; ?>" name="location" required>
														
													</div>
												</div>
												
													<div class="form-group">
													<label class="col-md-3 control-label">Owner Name</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Owner Name" value="<?php echo $categoryRowset['owner']; ?>" name="owner" required>
														
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Email</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $categoryRowset['email']; ?>">
														
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Phone</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Phone" name="phone" value="<?php echo $categoryRowset['phone']; ?>">
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Facebook link</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Fb Link" name="fb_link" value="<?php echo $categoryRowset['fb_link']; ?>">
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Skype link</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Skype Link" name="sk_link" value="<?php echo $categoryRowset['sk_link']; ?>">
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Viber Link</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Viber Link" name="vb_link" value="<?php echo $categoryRowset['vb_link']; ?>">
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Twitter Link</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Twitter Link" name="tw_link" value="<?php echo $categoryRowset['tw_link']; ?>">
														
													</div>
												</div>
												
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Store Logo</label>
													<div class="col-md-2">
														<input type="file" name="image" class=" btn blue"   >
														<?php if($categoryRowset['store_photo']!=''){?><br><a href="../upload/site_logo/<?php echo $categoryRowset['store_photo'];?>" target="_blank">View</a><?php }?>
														
													</div>
												</div>
												
												
												
											
												
								
								

												
											</div>
											
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn blue"  name="submit">Submit</button>
														<button type="button"  class="btn default">Cancel</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	
	
	



	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<?php //include('includes/quick_sidebar.php');?>
	<!-- END QUICK SIDEBAR -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php'); ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/form-samples.js"></script>
<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   FormSamples.init();
   
    if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: "xx"
            });
        }
   
});


    
</script>
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
