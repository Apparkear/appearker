<?php
session_start();
include("includes/config.php");

?>
<?php
$fetch_user=mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_user` where `id`='".$_REQUEST['id']."'"));
$from_email=$fetch_user['email'];
$fname=$fetch_user['fname'];
$lname=$fetch_user['lname'];
?>
<?php
if (isset($_REQUEST['submit']))
{


	$user_id=$_REQUEST['id'];
   $password=md5(mysqli_real_escape_string($link, $_REQUEST['password']));

	$query="update estejmam_user set password='".$password."' where id=".$user_id."";


		$res=mysqli_query($link, $query);
		$last_id=mysqli_insert_id();


		if($res){


		$name=$fname.' '.$lname;

    	$Subject1 ="Change Password";


		$TemplateMessage.="<br/><br />Hello ".$name;
		$TemplateMessage.="<br>";

		$TemplateMessage.="<br> New Password:".$_REQUEST['password'];
		$TemplateMessage.="<br><br>";

		$TemplateMessage.="<br><br>";
		$TemplateMessage.=" Email Address : ".$from_email;
		$TemplateMessage.="<br>";

		$TemplateMessage.="<br>";

		$TemplateMessage.="<br><br><br/>Thanks & Regards<br/>";
		$TemplateMessage.="EMARKET TEAM";
		$TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored
		or answered.";
		$mail1 = new PHPMailer;
		$mail1->FromName = "EMARKET";
		$mail1->From    = "info@emarket.com";
		$mail1->Subject = $Subject1;



		$mail1->Body    = stripslashes($TemplateMessage);
		$mail1->AltBody = stripslashes($TemplateMessage);
		$mail1->IsHTML(true);
		$mail1->AddAddress($from_email,"emarket.com");//info@salaryleak.com
		$mail1->Send();


		 $_SESSION['send_success']="Thank you";
		header('location:change_password_user.php?id='.$_REQUEST['id']);
                exit();
		}
		else
		{

		  $_SESSION['send_fail']="There is some error occurs please try later";
		header('location:change_password_user.php?id='.$_REQUEST['id']);
                exit();

                }



}

?>

<?php



include('includes/header.php');?>
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
			Change Password
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Change Password</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<span>Change Password</span>
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
                                                                                    <?php
                                if($_SESSION['send_fail']!='')
                                {
                                    ?>
                                <span style="color:red"> <?php echo $_SESSION['send_fail']; ?> </span>
                                <?php
                                $_SESSION['send_fail']='';
                                }
                                  if($_SESSION['send_success']!='')
                                {
                                    ?>
                                <span style="color:red"> <?php echo $_SESSION['send_success']; ?> </span>
                                <?php
                                $_SESSION['send_success']='';
                                }



                                ?>
											<i class="fa fa-gift"></i>Change Password
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
										<form action="#" class="form-horizontal" method="post" action="change_password_user.php" enctype="multipart/form-data">
										 <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                                     <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />


											<div class="form-body">
												<div class="form-group">
													<label class="col-md-3 control-label">New Password</label>
													<div class="col-md-4">
														<input type="text" class="form-control" placeholder="Enter New Password"  name="password" required>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
