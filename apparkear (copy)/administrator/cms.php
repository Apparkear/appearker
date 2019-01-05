<?php

include_once("controller/CmsManagementController.php");
?>
<script language="javascript">
 function submitdata(val)
  {
  //alert("hh");
  document.location.href="cms.php?id="+val;
  }
</script>

<?php include('includes/header.php');?>


<!-- END HEADER -->
<link rel="stylesheet" href="js/editor/ui/trumbowyg.css">


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
			 Manage CMS</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="cms.php">Manage CMS</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<!--<li>
						<span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Manage CMS</span>
					</li>-->
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Manage CMS
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
							<form action="#" class="form-horizontal" method="post" action="<?php echo basename(__FILE__);?>" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
								<input type="hidden" name="menu_id" value="<?php echo $menu_id;?>" />
								<input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />

								<div class="form-body">

									<div class="form-group">
										<label class="col-md-3 control-label">Page Names</label>
										<div class="col-md-4">
											<select id="selectError" name="pid" onChange="submitdata(this.value);">
												<option value="">Select One</option>
												<?php
												$SQL ="SELECT * FROM `estejmam_cms`";
												$result = mysqli_query($link, $SQL);

												while($row1=mysqli_fetch_array($result))
												{
												?>
												<option value="<?php echo $row1['id']; ?>" <?php if($pid==$row1['id']) { echo "selected";}?> > <?php echo $row1['pagename']; ?></option>
												<?php
												}
												?>
											</select>

										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Banner Image</label>
										<div class="col-md-2">
											<input type="file" name="image" class=" btn blue">
											<input type="hidden" name="bannerimage" class=" btn blue" value="<?php echo $row12['image'] ?>">

										</div>
										<?php if(isset($row12['image']) && $row12['image']!='') { ?>
											<div><img src="../upload/sitebanner/<?php echo $row12['image'] ?>" width="20%" style="margin-left:-157px;margin-top: 46px;"></div>
										<?php } ?>
									</div>
									<!-- Seo Block -->
									<!-- <div class="form-group">
										<label class="col-md-3 control-label">Meta Title</label>
										<div class="col-md-9">
										<input type="text" name="meta_title" id="meta_title" class="form-control" value="<?php echo strip_tags(stripslashes($row12['meta_title'])); ?>">


										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Meta Description</label>
										<div class="col-md-9">
											<textarea class=" form-control" id="meta_description" name="meta_description" cols="100" rows="5"><?php echo stripslashes($row12['meta_description']); ?></textarea>

										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Meta Keywords</label>
										<div class="col-md-9">
											<textarea class=" form-control" id="meta_keywords" name="meta_keywords" cols="100" rows="5"><?php echo stripslashes($row12['meta_keywords']); ?></textarea>

										</div>
									</div> -->
									<!-- Seo Block -->


									<div class="form-group">
										<label class="col-md-3 control-label">Content</label>
										<div class="col-md-9">
											<textarea class="ckeditor form-control" id="editor1" name="elm1" cols="100" rows="20"><?php echo stripslashes($row12['pagedetail']); ?></textarea>

										</div>
									</div>

								<!-- <div class="form-group">
									<label class="col-md-3 control-label">Spanish Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm2" cols="100" rows="20"><?php echo stripslashes($row12['spainsh_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Italian Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm3" cols="100" rows="20"><?php echo stripslashes($row12['italian_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">French Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm4" cols="100" rows="20"><?php echo stripslashes($row12['french_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Portuguese Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm5" cols="100" rows="20"><?php echo stripslashes($row12['portu_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Duch Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm6" cols="100" rows="20"><?php echo stripslashes($row12['duch_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Russian Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm7" cols="100" rows="20"><?php echo stripslashes($row12['russian_content']); ?></textarea>

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Chinese Content</label>
									<div class="col-md-9">
										<textarea class="ckeditor form-control" id="editor1" name="elm8" cols="100" rows="20"><?php echo stripslashes($row12['chinese_content']); ?></textarea>

									</div>
								</div> -->


								<div class="form-actions fluid">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn blue"  name="submit">Submit</button>
											<button type="button" class="btn default" onclick="location.href='cms.php'">Cancel</button>
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
                //$("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
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
        <div class="page-footer">

<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php'); ?>
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
<script src="js/editor/trumbowyg.min.js" type="text/javascript"></script>
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
<!-- <script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script> -->

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
					if (data.ack == 1){
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
    $(".ckeditor").trumbowyg({
    semantic: false
});
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
