<?php 

include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");


if($_REQUEST['action']=='details')

{

$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_event` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));



}


?>
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
		Event Details
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Event Details</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
                                            <span>Event Details </span>
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>> Product Details
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											
											<a href="javascript:;" class="reload">
											</a>
											<a href="javascript:;" class="remove">
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="#" class="form-horizontal" method="post" action="add_social.php" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
										<div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Name:</label>
													<div class="col-md-4"> 
                                           <?php echo $categoryRowset['name'];?> 
														
													</div>
												</div>
                                                                                        </div>
                                     <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Venue:</label>
													<div class="col-md-4"> <?php echo $categoryRowset['venue'];?>
														
													</div>
												</div>
                                                                                        </div>
                                     <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Zip:</label>
													<div class="col-md-4">     <?php echo $categoryRowset['zip'];?>
														
													</div>
												</div>
                                                                                        </div>
                                     <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Start Date:</label>
													<div class="col-md-4">    
                                           <?php echo $categoryRowset['start_date'];?>
														
													</div>
												</div>
                                                                                        </div>
                                     <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">End Date:</label>
													<div class="col-md-4">    
                                             <?php echo $categoryRowset['end_date'];?>
														
													</div>
												</div>
                                                                                        </div>
                                        <div class="form-body">
												<div class="form-group">
                                                                                                    <label class="col-md-3 control-label">Start Time</label>										<div class="col-md-4">    
                                        <?php echo $categoryRowset['start_time'];?>
														
													</div>
												</div>
                                                                                        </div>
                                       <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">End Time</label>
:</label>
													<div class="col-md-4">    
                                            <?php echo $categoryRowset['end_time'];?>

														
													</div>
												</div>
                                                                                        </div>
                                        <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">No of Person:</label>
													<div class="col-md-4">    
                                                 <?php echo $categoryRowset['no_person'];?>

														
													</div>
												</div>
                                                                                        </div>
                                         <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Description:</label>
													<div class="col-md-4">    
                                         <?php echo $categoryRowset['description'];?>

														
													</div>
												</div>
                                                                                        </div>
                                        
											
                                        
                                        
                                                                                        
                                        
                                        
                                            
                                            <div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Images</label>
													<div class="col-md-4">        <?php 
                                                                                                        $moreimage1 = mysql_query("SELECT * FROM `estejmam_image_event` WHERE `pro_id`='".mysql_real_escape_string($_REQUEST['id'])."'");
                                              while($moreimage=mysql_fetch_array($moreimage1))
                                              {
                                              
                                    
                                          if($moreimage['image']!="")
			    {
				$image_link='../upload/event/'.$moreimage['image'];
			    }
			    else
			    {
				$image_link='../upload/no.png';
			    }
                            ?>
                                              <span class="input-xlarge"><img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" /></span>
                                              <?php
                                              }
                                              ?>


														
													</div>
												</div>
                                                                                        </div>
                                        
											
												
											
												
												
										<!--<div class="form-group">
										<label class="control-label col-md-3">Datepicker</label>
										<div class="col-md-4">
											<div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
												<input type="text" class="form-control" readonly name="datepicker">
												<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
											
										</div>
									</div>-->
									
								
												
												
												
												
												
											
												
											
												
												
												
												
				
												
												<!--<div class="form-group">
													<label class="col-md-3 control-label">Image Upload</label>
													<div class="col-md-2">
														<input type="file" name="image" class=" btn blue"  ><?php if($categoryRowset['image']!=''){?><br><a href="../upload/banner/<?php echo $categoryRowset['image'];?>" target="_blank">View</a><?php }?>
														
													</div>
												</div>-->
												
											
												
												
										

												
											</div>
											
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<!--<button type="submit" class="btn blue"  name="submit">Submit</button>-->
														<button type="reset" class="btn blue" onClick="window.location.href='list_event.php'">Back</button>
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
	
	
	
<style>
.thumb{
    height: 60px;
    width: 60px;
    padding-left: 5px;
    padding-bottom: 5px;
}

</style>

<script>

     
window.preview_this_image = function (input) {

    if (input.files && input.files[0]) {
        $(input.files).each(function () {
            var reader = new FileReader();
            reader.readAsDataURL(this);
            reader.onload = function (e) {
                $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
            }
        });
    }
}
</script>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	<?php //include('includes/quick_sidebar.php');?>
	<!-- END QUICK SIDEBAR -->
</div>
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

$(document).ready(function(){

   $('.del_this').click(function (event) {
                var id = $(this).data('imgid');

                var divs = $(this);
                var formdata = {id: id, action: "deleteImg"};
                $.ajax({
                    url: "del_ajax.php",
                    type: "POST",
                    dataType: "json",
                    data: formdata,
                    success: function (data) {
                        if (data.ack == 1)
                        {

                            $(divs).closest('.div_div').remove();
                        }



                    }

                });
            });



$(document).on("click",".del_this",function(){
$(this).parent().remove();

});
     
    
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
