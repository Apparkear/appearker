<?php 
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");
if(isset($_REQUEST['submit']))
{

	$logo = isset($_POST['logo']) ? $_POST['logo'] : '';
	$social_medial = isset($_POST['social_media']) ? $_POST['social_media'] : '';
	$banner = isset($_POST['banner']) ? $_POST['banner'] : '';
        $store_banner = isset($_POST['store_banner']) ? $_POST['store_banner'] : '';
        $store_category = isset($_POST['store_category']) ? $_POST['store_category'] : '';
        $store = isset($_POST['store']) ? $_POST['store'] : '';
         $event = isset($_POST['event']) ? $_POST['event'] : '';
          $maintain = isset($_POST['maintain']) ? $_POST['maintain'] : '';
	$add = isset($_POST['add']) ? $_POST['add'] : '';
        $group = isset($_POST['group']) ? $_POST['group'] : '';
        $cms = isset($_POST['cms']) ? $_POST['cms'] : '';
        $user = isset($_POST['user']) ? $_POST['user'] : '';
        $customer_say = isset($_POST['customer_say']) ? $_POST['customer_say'] : '';
        $category = isset($_POST['category']) ? $_POST['category'] : '';
        $subcategory = isset($_POST['subcategory']) ? $_POST['subcategory'] : '';
        $product = isset($_POST['product']) ? $_POST['product'] : '';
        $order = isset($_POST['order']) ? $_POST['order'] : '';
        $news = isset($_POST['news']) ? $_POST['news'] : '';
        $coupon = isset($_POST['coupon']) ? $_POST['coupon'] : '';
        $paypal = isset($_POST['paypal']) ? $_POST['paypal'] : '';
        
      
	$fields = array(
		'logo' => mysql_real_escape_string($logo),
		'social' => mysql_real_escape_string($social_medial),
		'banner' => mysql_real_escape_string($banner),
                'store_banner' => mysql_real_escape_string($store_banner),
                'store_category' => mysql_real_escape_string($store_category),
                'store' => mysql_real_escape_string($store),
            'maintain' => mysql_real_escape_string($maintain),
                 'event' => mysql_real_escape_string($event),
                'add' => mysql_real_escape_string($add),
                'group' => mysql_real_escape_string($group),
                'cms' => mysql_real_escape_string($cms),
		'user' => mysql_real_escape_string($user),
                'customer_say' => mysql_real_escape_string($customer_say),
		'category' => mysql_real_escape_string($category),
                'subcategory' => mysql_real_escape_string($subcategory),
		'product' => mysql_real_escape_string($product),
		'order' => mysql_real_escape_string($order),
                'news' => mysql_real_escape_string($news),
		'coupon' => mysql_real_escape_string($coupon),
                'paypal' => mysql_real_escape_string($paypal)
            
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 		  
	  $editQuery = "UPDATE `estejmam_tbladmin` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

		if (mysql_query($editQuery)) {
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_user.php');
		exit();
	
	 
	 		
				
}

if($_REQUEST['action']=='privilege')
{
$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_tbladmin` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

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
			Subadmin
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Set Privilege</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Set Privilege</span>
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
											<i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Set Privilege
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
													<label class="col-md-3 control-label">Logo</label>
													<div class="col-md-4"> <input type="checkbox" name="logo" value=1 <?php if($categoryRowset['logo']==1){?>
                             checked="checked" <?php }?> >
														
													</div>
												</div>
                                                                                            
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Social Media</label>
													<div class="col-md-4"><input type="checkbox" name="social_media" value=1  <?php if($categoryRowset['social']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Banner</label>
													<div class="col-md-4">
														 <input type="checkbox" name="banner" value=1  <?php if($categoryRowset['banner']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Store Banner</label>
													<div class="col-md-4">
														 <input type="checkbox" name="store_banner" value=1  <?php if($categoryRowset['store_banner']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">SiteSettings</label>
													<div class="col-md-4">
														  <input type="checkbox" name="maintain" value=1  <?php if($categoryRowset['maintain']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Advertisement</label>
													<div class="col-md-4">
														   <input type="checkbox" name="add" value=1  <?php if($categoryRowset['add']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Cms</label>
													<div class="col-md-4">
														   <input type="checkbox" name="cms" value=1  <?php if($categoryRowset['cms']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Customer Say</label>
													<div class="col-md-4">
														    <input type="checkbox" name="customer_say" value=1  <?php if($categoryRowset['customer_say']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Customer</label>
													<div class="col-md-4">
														   <input type="checkbox" name="user" value=1  <?php if($categoryRowset['user']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                             <div class="form-group">
													<label class="col-md-3 control-label">Category</label>
													<div class="col-md-4">
														  <input type="checkbox" name="category" value=1  <?php if($categoryRowset['category']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                             <div class="form-group">
													<label class="col-md-3 control-label">Subcategory</label>
													<div class="col-md-4">
														  <input type="checkbox" name="subcategory" value=1  <?php if($categoryRowset['subcategory']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Store category</label>
													<div class="col-md-4">
														   <input type="checkbox" name="store_category" value=1  <?php if($categoryRowset['store_category']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Store</label>
													<div class="col-md-4">
														   <input type="checkbox" name="store" value=1  <?php if($categoryRowset['store']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Event</label>
													<div class="col-md-4">
														  <input type="checkbox" name="event" value=1  <?php if($categoryRowset['event']==1){?>
                             checked="checked" <?php }?>>
														
													</div>
												</div>
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label">Product</label>
													<div class="col-md-4">
														  <input type="checkbox" name="product" value=1  <?php if($categoryRowset['product']==1){?>
                             checked="checked" <?php }?>>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Order</label>
													<div class="col-md-4">
														  <input type="checkbox" name="order" value=1 <?php if($categoryRowset['order']==1){?>
                             checked="checked" <?php }?>>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">News</label>
													<div class="col-md-4"> <input type="checkbox" name="news" value=1 <?php if($categoryRowset['news']==1){?>
                             checked="checked" <?php }?>>
													</div>
												</div>
                                                                                            <!--<div class="form-group">
													<label class="col-md-3 control-label">Coupon</label>
													<div class="col-md-4">
                                                                                                            <input type="checkbox" name="coupon" value=1 <?php if($categoryRowset['coupon']==1){?>
                             checked="checked" <?php }?>>
													</div>
												</div>-->
												<div class="form-group">
													<label class="col-md-3 control-label">Paypal</label>
													<div class="col-md-4">
                                                                                                            <input type="checkbox" name="paypal" value=1 <?php if($categoryRowset['paypal']==1){?>
                             checked="checked" <?php }?>>
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
