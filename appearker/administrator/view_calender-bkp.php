
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
						<a href="#">Offer list</a>
						<i class="fa fa-angle-right"></i>
					</li>
				</ul>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
                            	Offer list
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div id="calendar"></div>
								</div>
							</div>
							
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
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
<script language="JavaScript" src="../calendar_db.js"></script>
        <link rel="stylesheet" href="calendar.css">
        <link href='../event_calendar/fullcalendar.css' rel='stylesheet' />
        <link href='../event_calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
        <script src="../event_calendar/lib/moment.min.js"></script>
        <script src="../event_calendar/fullcalendar.min.js"></script>

		<script type="text/javascript">

		$(document).ready(function() {

		$('#calendar').fullCalendar({
		eventClick: function(calEvent, jsEvent, view) {
		var id = calEvent.id;
		var d = new Date(calEvent.start);
		var f = new Date(calEvent.end);
		var st = d.getFullYear() + "-" + (parseInt(d.getMonth()) + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes();
		var et = f.getFullYear() + "-" + (parseInt(f.getMonth()) + 1) + "-" + f.getDate() + " " + f.getHours() + ":" + f.getMinutes();
		var seconds = (f - d) / (1000 * 3600);
		},
		defaultDate: '<?php echo date('Y-m-d'); ?>',
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		<?php
		$counter = 1;
		$first_day_of_current_month = date('Y-m-01');
		$last_day_of_current_month = date('Y-m-t');
		$sql_booking = "SELECT * FROM `estejmam_booking` WHERE `prop_id`='" . $_REQUEST['id'] . "'";
		$exe_booking = mysql_query($sql_booking) or die(mysql_error());
		$num_booking = mysql_num_rows($exe_booking);
		if ($num_booking > 0) {
		?>
		events: [
		<?php
		$arr_booking = mysql_fetch_array($exe_booking);
		$property_booking = mysql_fetch_array(mysql_query("select * from `estejmam_main_property` where `id`='" . $arr_booking['prop_id'] . "'"));
		$enddate = $arr_booking['end_date'];
		$nexdate = date('Y-m-d', strtotime($enddate . ' +1 day'));
		?>
		{
		id:'<?php echo $arr_booking['id']; ?>',
		title: '<?php echo $property_booking['name'] ?>',
		url: '',
		start: '<?php echo $arr_booking['start_date'] ?>',
		end: '<?php echo $nexdate ?>'
		},
		<?php ?>

		]
		<?php
		} else {
		?>
		events: [
		]
		<?php
		}
		?>
		});
		});
		</script>

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
<style type="text/css">
#calendar{width: 90% !important;height: auto;}
</style>
</body>
<!-- END BODY -->
</html>
