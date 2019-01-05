<?php 
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


if(isset($_REQUEST['submit']))
{

	
	$add1= isset($_POST['add1']) ? $_POST['add1'] : '';
        $add2= isset($_POST['add2']) ? $_POST['add2'] : '';
	$company_name= isset($_POST['company_name']) ? $_POST['company_name'] : '';
        $designation= isset($_POST['designation']) ? $_POST['designation'] : '';
        $city= isset($_POST['city']) ? $_POST['city'] : '';
        $country= isset($_POST['country']) ? $_POST['country'] : '';
        $post_code= isset($_POST['post_code']) ? $_POST['post_code'] : '';
        $phone= isset($_POST['phone']) ? $_POST['phone'] : '';
        $state= isset($_POST['state']) ? $_POST['state'] : '';
         $email= isset($_POST['email']) ? $_POST['email'] : '';
            $website= isset($_POST['website']) ? $_POST['website'] : '';
        
        
	$fields = array(
		'add1' => mysql_real_escape_string($add1),
                'add2' => mysql_real_escape_string($add2),
                'company_name' => mysql_real_escape_string($company_name),
            'designation' => mysql_real_escape_string($designation),
                'city' => mysql_real_escape_string($city),
            'country' => mysql_real_escape_string($country),
             'phone' => mysql_real_escape_string($phone),
             'post_code' => mysql_real_escape_string($post_code),
             'state' => mysql_real_escape_string($state),
            'email' => mysql_real_escape_string($email),
             'website' => mysql_real_escape_string($website),
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `estejmam_new_billing_address` SET " . implode(', ', $fieldsList)
			. " WHERE `user_id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";
          //exit;

		if (mysql_query($editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/userimage/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysql_query("UPDATE `estejmam_new_billing_address` SET `image`='".$img_name."' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:search_user.php');
		exit();
	
	 }
	 else
	 {
	 
	  $addQuery = "INSERT INTO `estejmam_new_billing_address` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
		mysql_query($addQuery);
		$last_id=mysql_insert_id();
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/directory/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysql_query("UPDATE `estejmam_new_billing_address` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysql_query($addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:search_user.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_new_billing_address` WHERE `user_id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

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
			Billing Address
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Billing Address</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Billing Address</span>
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
											<i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Billing Address
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
										<form action="#" class="form-horizontal" method="post" action="add_user_type.php" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />
                                      
											
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">Company Name</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Company Name"  value="<?php echo $categoryRowset['company_name'];?>" name="company_name" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Designation</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Designation" value="<?php echo $categoryRowset['designation'];?>" name="designation" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Address1</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Address1" value="<?php echo $categoryRowset['add1'];?>" name="add1" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Address2</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Address2" value="<?php echo $categoryRowset['add2'];?>" name="add2" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">City</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter City" value="<?php echo $categoryRowset['city'];?>" name="city" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Country</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Country" value="<?php echo $categoryRowset['country'];?>" name="country" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Zip Code</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter PostCode" value="<?php echo $categoryRowset['post_code'];?>" name="post_code" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">State</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter State" value="<?php echo $categoryRowset['state'];?>" name="state" required>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Phone</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Phone" value="<?php echo $categoryRowset['phone'];?>" name="phone" required>
														
													</div>
												</div>
                                                                                            
                                                                                            
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Email</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Email" value="<?php echo $categoryRowset['email'];?>" name="email" required>
														
													</div>
												</div>
                                                                                            
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Website</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Website" value="<?php echo $categoryRowset['website'];?>" name="website" required>
														
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
									
								
												
												
												
												
												
											
												
											
												
												
												
												
				
												
												
												
												
										

												
											</div>
											
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn blue"  name="submit">Submit</button>
														<button type="button" class="btn default">Cancel</button>
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