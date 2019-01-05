<?php
include_once("controller/productController.php");
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
			Product <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Product</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="list_product.php">Product</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Product</span>
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
											<i class="fa fa-gift"></i>Add Product
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
													<label class="col-md-3 control-label">Name</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name'];?>" name="name" required>
														
													</div>
												</div>
												
													<div class="form-group">
													<label class="col-md-3 control-label">Product Keyword</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Keyword for search" name="product_keyword" value="<?php echo $categoryRowset['product_keyword']; ?>">
														
													</div>
												</div>
												
												
												
												
												<div class="form-group">
													<label class="control-label col-md-3">Store</label>
													<div class="col-md-4">
														<select class="form-control" name="store_id">
															<option value="Select your gender">Select One</option>
																<?php 
										                        $SQL ="SELECT * FROM `estejmam_store` order by `store_title`";
										                        $result = mysql_query($SQL);
										                        
										                        while($row1=mysql_fetch_array($result))
										                        { 
										                        ?>
										                        <option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['store_id']==$row1['id']) { echo "selected";}?> > <?php echo $row1['store_title']; ?></option>
										                        <?php
										                        }
										                        ?>
														</select>
														                              
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Category</label>
													<div class="col-md-4">
														<select class="form-control" name="cat_id" onchange="select_sub(this.value)">
															<option value="Select your gender" >Select One</option>
																<?php 
											                    $SQL ="SELECT * FROM `estejmam_category` order by `name`";
											                    $result = mysql_query($SQL);
											                    
											                    while($row1=mysql_fetch_array($result))
											                    { 
											                    ?>
											                    <option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['cat_id']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
											                    <?php
											                    }
											                    ?>
														</select>
														                              
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-md-3">Sub-Category</label>
													<div class="col-md-4">
														<select class="form-control" id="subcat" name="subcat">
															<option value="Select your gender">Select One</option>
																<?php 
																if(isset($categoryRowset['cat_id']))
																{
																$SQL ="SELECT * FROM `estejmam_subcategory` where `cat_id`='".$categoryRowset['cat_id']."' order by `name`";
																$result = mysql_query($SQL);

																while($row1=mysql_fetch_array($result))
																{ 
																?>
																<option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['subcat']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
																<?php
																}
																}
																?>
														</select>
														                              
													</div>
												</div>
												
												<div class="form-group">
												<label class="control-label col-md-3">Description</label>
												<div class="col-md-9">
												<textarea class="ckeditor form-control" id="editor1" name="desc" rows="6"><?php echo stripslashes($categoryRowset['desc']);?></textarea>
												</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Price ($)</label>
													<div class="col-md-4">
														<div class="input-icon">
															
															<input type="text" name="regular_price" class="form-control" placeholder="100" value="<?php echo $categoryRowset['regular_price'];?>">
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Offer Price($)</label>
													<div class="col-md-4">
														<div class="input-icon">
															
															<input type="text" name="offer_price" class="form-control" placeholder="100" value="<?php echo $categoryRowset['offer_price'];?>">
														</div>
													</div>
												</div>
												
										<div class="form-group">
										<label class="control-label col-md-3">Offer Start Date</label>
										<div class="col-md-4">
											<div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
												<input type="text" name="start_date" class="form-control" readonly name="datepicker" value="<?php echo $categoryRowset['start_date'];?>">
												<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
											
										</div>
									</div>
									
											<div class="form-group">
										<label class="control-label col-md-3">Offer End Date</label>
										<div class="col-md-4">
											<div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
												<input type="text" name="end_date"  class="form-control" readonly name="datepicker" value="<?php echo $categoryRowset['end_date'];?>">
												<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
											
										</div>
									</div>
									
									
									
									
									
									
									
								
												
												<div class="form-group">
													<label class="col-md-3 control-label">Vendor</label>
													<div class="col-md-4">
														<input type="text" name="vendor" class="form-control" placeholder="Enter Brand" value="<?php echo $categoryRowset['vendor'];?>">
														
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Division</label>
													<div class="col-md-4">
														<input type="text" name="division" class="form-control" placeholder="Divison" value="<?php echo $categoryRowset['division'];?>">
														
													</div>
												</div>
												
											<div class="form-group">
													<label class="col-md-3 control-label">Class</label>
													<div class="col-md-4">
														<input type="text"  name="class" class="form-control" placeholder="Enter Class" value="<?php echo $categoryRowset['class'];?>">
														
													</div>
												</div>
												
											<div class="form-group">
													<label class="col-md-3 control-label">Season</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter Season" value="<?php echo $categoryRowset['season'];?>" name="season">
														
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Quantity</label>
													<div class="col-md-4">
														<input type="text" name="inventory" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['inventory'];?>">
														
													</div>
												</div>
												<?php
												if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){
												$res22=mysql_query("SELECT * FROM `estejmam_moreimage` WHERE `pro_id`='".$_REQUEST['id']."'");

												$tot=mysql_num_rows($res22);
												if($tot>0){
												?>
												<div class="form-group">
													<label class="col-md-3 control-label">Previous image</label>
													<div class="col-md-4">
													<?php
													  while($row22=mysql_fetch_array($res22)){
                         							 ?> 
                         							    <span style="float:left;width:70px;border:0px solid red;position:relative;" class="div_div"><input type="hidden" value="<?php echo $row22['image'];?>" class="video_hid" name="imagesfile[]"><img border="0" src="../upload/product/<?php echo $row22['image'];?>" style="height:50px;width:50px;"><a class="del_this" id="<?php echo $row22['id'];?>" data-imgid="<?php echo $row22['id'];?>" href="javascript: void(0)"><img border="0" src="../images/erase.png" style="margin-top:-34px;"></a></span>
                         							 
                         							 
                         							 <?php
                         							 }
                         							 ?> 	
														
													</div>
												</div>
												
												
												<?php
												}
												}
												?>
												
												
				
												
												<div class="form-group">
													<label class="col-md-3 control-label">Image Upload</label>
													<div class="col-md-2">
														<input type="file" name="images[]" multiple="" class=" btn blue" onchange="preview_this_image(this);"  >
														
													</div>
												</div>
												<div class="form-group">
												<label class="col-md-3 control-label"></label>
												<div class="col-md-4" id='previewImg'>
												
												</div>
												</div>
												
												
											
												<div class="form-group ">
									<div class="col-md-offset-2 col-md-4">
										<div class="checkbox">
											<label>
											<input type="checkbox" name="feature" <?php if($categoryRowset['is_feature']=='1'){?> checked <?php } ?> value="1"> Featured </label>
										</div>
									</div>
								</div>
								
								

												
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

<script type="text/javascript">
            function select_sub(id) {
                $.ajax({
                    type: "post",
                    url: "ajax_category.php?action=cat",
                    data: {id: id},
                    success: function (msg) {
                        $('#subcat').html(msg);
                    }
                });
            }
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
