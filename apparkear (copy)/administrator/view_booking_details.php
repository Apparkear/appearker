<?php
    include("includes/header.php"); 
    
    $query= "SELECT * FROM `estejmam_booking` WHERE `id` = '".$_REQUEST['id']."'";
    $rowOrderDetails = mysql_fetch_array(mysql_query($query));
    
    
    $sql_property_name = mysql_fetch_object(mysql_query("select * from `estejmam_main_property` where `id` = '".$rowOrderDetails['prop_id']."'"));
?>
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
			Booking Details
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
<div class="col-md-12 col-sm-12">
    <div class="portlet grey-cascade box">
    <div class="portlet-title">
            <div class="caption">
                    <i class="fa fa-cogs"></i>Booking Details
            </div>
            <div class="actions">

            </div>
    </div>
    <div class="portlet-body">
            <div class="table-responsive">
                <label class="col-md-3 control-label">Property Name:</label>
                <p><?php echo $sql_property_name->name ;?></p>

                 <label class="col-md-3 control-label">Booking User:</label>
                <p>
                <?php 
                  $name = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` where `id` = '".$rowOrderDetails['user_id']."'")) ;

                  echo $name->fname . ' ' . $name->lname;      
                ?></p>

                <label class="col-md-3 control-label">Booking Start Date:</label>
                <p>
                <?php 
                    $start_date = strtotime($rowOrderDetails['start_date']);

                    echo date('Y-m-d', $start_date);
                ?></p>

                <label class="col-md-3 control-label">Booking End Date:</label>
                <p>
                <?php 
                    $end_date = strtotime($rowOrderDetails['end_date']);

                    echo date('Y-m-d', $end_date);
                ?></p>

                <label class="col-md-3 control-label">Booking Paid Status:</label>
                <p>
                <?php 
                    if($rowOrderDetails['status'] == '1'){echo 'Paid';}else{echo 'Not Paid';}
                ?></p>

                <label class="col-md-3 control-label">Property Owner Name:</label>
                <p>
                <?php 

                    $uplaoder_id = $rowOrderDetails['uploder_user_id'];

                    $sql_uploader_name = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` where `id` = '".$uplaoder_id."'"));
                    
                    echo $sql_uploader_name->fname . ' ' . $sql_uploader_name->lname; 

                ?></p>
                
                <label class="col-md-3 control-label">Booking Payment Amount:</label>
                <p>
                <?php 
                    $property_price = $rowOrderDetails['price'];
                    
                    echo '$ ' . number_format($property_price, 2, '.', '');
                ?>
                </p>
                
                <label class="col-md-3 control-label">Total Staying Days:</label>
                <p>
                <?php 
                    $estenjman_staying_days = $rowOrderDetails['total_days'];
                    echo $estenjman_staying_days . ' Days'; 
                ?>
                </p>
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
