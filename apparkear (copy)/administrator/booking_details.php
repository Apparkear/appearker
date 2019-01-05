<?php include("includes/header.php"); ?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php include("includes/left_panel.php"); ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Offer list
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Booking Details</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<!--<li>
						<a href="#">Editable Datatables</a>
					</li>-->
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Details <span class="hidden-480">
								 </span>
							</div>
							<!--<div class="actions">
								<a href="#" class="btn default yellow-stripe">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
								<div class="btn-group">
									<a class="btn default yellow-stripe dropdown-toggle" href="#" data-toggle="dropdown">
									<i class="fa fa-cog"></i>
									<span class="hidden-480">
									Tools </span>
									<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="#">
											Export to Excel </a>
										</li>
										<li>
											<a href="#">
											Export to CSV </a>
										</li>
										
									</ul>
								</div>
							</div>-->
						</div>
						<div class="portlet-body">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-lg">
									<li class="active">
										<a href="#tab_1" data-toggle="tab">
										Details </a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet yellow-crusta box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Booking Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $rowOrderDetails['fname'];?> <?php echo $rowOrderDetails['lname'];?> 
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Email:
															</div>
															<div class="col-md-7 value">
																<?php echo $rowOrderDetails['email'];?> 
															</div>
														</div>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 Phone:
															</div>
															<div class="col-md-7 value">
																 <?php echo $rowOrderDetails['phone'];?>
															</div>
														</div>
                                                        <div class="row static-info">
															<div class="col-md-5 name">
																Register Date:
															</div>
															<div class="col-md-7 value">
																 <?php echo $rowOrderDetails['add_date'];?>
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>More Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Image:
															</div>
															<div class="col-md-7 value">
																 <?php
                                              if($rowOrderDetails['image']!='')
                                              {
                                              ?>

                                          <span class="input-xlarge"><img src="../upload/userimage/<?php echo $rowOrderDetails['image'] ;?>" height="70" width="70" style="border:1px solid #666666" /></span>
                                              <?php
                                              }
 else {
     ?>
                                          <span class="input-xlarge"><img src="../upload/no.png" height="70" width="70" style="border:1px solid #666666" /></span>
                                              <?php
                                          
                                         
 }
                                              ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 License Document:
															</div>
															<div class="col-md-7 value">
																<?php
                                              if($rowOrderDetails['upload']!='')
                                              {
                                              ?>

                                              <span class="input-xlarge"><a href="../upload/upload1/<?php echo $rowOrderDetails['upload'] ;?>" height="70" width="70" style="border:1px solid #666666" /><?php echo $rowOrderDetails['upload'] ?></a></span>
                                              <?php
                                              }
 else {
     ?>
                                          <span class="input-xlarge"> No file Uploaded </span>
                                            <?php
                                          
                                         
 }
                                              ?>

															</div>
														</div>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 NTN Certificate:
															</div>
															<div class="col-md-7 value">
																  <?php
                                              if($rowOrderDetails['ntn_image']!='')
                                              {
                                              ?>

                                              <span class="input-xlarge"><a href="../upload/upload1/<?php echo $rowOrderDetails['ntn_image'] ;?>" height="70" width="70" style="border:1px solid #666666" /><?php echo $rowOrderDetails['ntn_image'] ?></a></span>
                                              <?php
                                              }
 else {
     ?>
                                          <span class="input-xlarge"> No file Uploaded </span>
                                            <?php
                                          
                                         
 }
                                              ?>

															</div>
														</div>
                                                                                                            <div class="row static-info">
															<div class="col-md-5 name">
																 Bussiness Registeration Certificate:
															</div>
															<div class="col-md-7 value">
																  <?php
                                          
                                              if($rowOrderDetails['business_image']!='')
                                              {
                                              ?>

                                              <span class="input-xlarge"><a href="../upload/upload1/<?php echo $rowOrderDetails['business_image'] ;?>" height="70" width="70" style="border:1px solid #666666" /><?php echo $rowOrderDetails['business_image'] ?></a></span>
                                              <?php
                                              }else {
     										?>
                                          <span class="input-xlarge"> No file Uploaded </span>
											<?php
												}
											?>
															</div>
														</div>
														
														
													</div>
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet grey-cascade box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>List of Uploaded Property
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<table class="table table-hover table-bordered table-striped">
															<thead>
																<tr>
																
																<td>
																Logo
																</td>
																
																<td>
																Store Name
																</td>
																<td>
																Create Date
																</td>
																<td>
																Details
																</td>
																

																</tr>
															</thead>
															<tbody>
															
															<?php
															
															
															 	$x = "select * from estejmam_main_property where user_id = '".$_REQUEST['id']."'";
															  	$rs = mysql_query($x);
																while($row_r = mysql_fetch_object($rs))
																{
															 
															// $sum=$sum+$row_order_details['quantity']*$row_order_details['price'];
															 
																	$estejman_img = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` where `prop_id` = '".$row_r->id."' LIMIT 0,1"));
																?>
																<tr>
																
																
																
																<?php
																if($estejman_img->image == '')
																{
																	$imgage= '../upload/no.png';
																}
																else {
																	$imgage= '../upload/property/'.$estejman_img->image;  
																}
																?>
																<td>
																<img src="<?php echo $imgage; ?>" width="100" height="100"  border="0" align="center" alt="" />
																</td>
																<td>
																<?php echo $row_r->name;?>
																</td>
																<td>
																<?php if($row_r->created_date){
																	$str_created_date = strtotime($row_r->created_date);
																	echo date('Y-m-d',$str_created_date);
																}else{
																	echo 'NA';
																}?>   
																</td>

																<td>
                                                                   <a href="details_store.php?id=<?php echo $row_r->id ?>">Details</a>
																</td>
																</tr>
                                                                <?php
                                                                }
                                                                ?>
																
															</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
                                                                            
                                                                            
                                                                            
				</div>
			</div>
										
									</div>
									
									
									
									
								</div>
							</div>
						</div>
					</div>
					<!-- End: life time stats -->
				</div>
			</div>



			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<!-- END CONTENT -->
	
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="page-footer">
	<?php include("includes/footer.php"); ?>
</div>
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
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-editable.js"></script>
<script>
jQuery(document).ready(function() {       
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   TableEditable.init();
});
</script>

<script type="text/javascript">
function deleteConfirm(){
    var result = confirm("Are you sure to delete product?");
    if(result){
        return true;
    }else{
        return false;
    }
}

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length)
        {
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
    
 

</script>
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>
</body>
<!-- END BODY -->
</html>
