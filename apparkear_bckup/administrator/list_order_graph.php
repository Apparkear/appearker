<?php 
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


 $sql_month_per_click="SELECT MONTHNAME( `orderdate` ) AS
MONTH , sum( `orderamount` ) AS total_price
FROM estejmam_tblorders
WHERE YEAR( orderdate ) = YEAR( CURDATE( ) )
AND STATUS = '1'
GROUP BY MONTHNAME( orderdate )

 
 ";

	
	    $result_month_per_click=mysql_query($sql_month_per_click);
            
            
        while($row_month=mysql_fetch_array($result_month_per_click))
           
		   { 
            
            
              $rows_month[substr($row_month['MONTH'],0,3)] = $row_month;
	     
	$jan_visit=isset($rows_month['Jan']['total_price']) ? ceil($rows_month['Jan']['total_price']) : 0;
	$feb_visit=isset($rows_month['Feb']['total_price']) ? ceil($rows_month['Feb']['total_price']) : 0;
	$mar_visit=isset($rows_month['Mar']['total_price']) ? ceil($rows_month['Mar']['total_price']) : 0;
	$apr_visit=isset($rows_month['Apr']['total_price']) ? ceil($rows_month['Apr']['total_price']) : 0;
	$may_visit=isset($rows_month['May']['total_price']) ? ceil($rows_month['May']['total_price']) : 0;
	$jun_visit=isset($rows_month['Jun']['total_price']) ? ceil($rows_month['Jun']['total_price']) : 0;
	$jul_visit=isset($rows_month['Jul']['total_price']) ? ceil($rows_month['Jul']['total_price']) : 0;
	$aug_visit=isset($rows_month['Aug']['total_price']) ? ceil($rows_month['Aug']['total_price']) : 0;
	$sep_visit=isset($rows_month['Sep']['total_price']) ? ceil($rows_month['Sep']['total_price']) : 0;
	$oct_visit=isset($rows_month['Oct']['total_price']) ? ceil($rows_month['Oct']['total_price']) : 0;
	$nov_visit=isset($rows_month['Nov']['total_price']) ? ceil($rows_month['Nov']['total_price']) : 0;
	$dec_visit=isset($rows_month['Dec']['total_price']) ? ceil($rows_month['Dec']['total_price']) : 0;
            
    
            }
            
            ?>

<?php include('includes/header.php');




?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<?php include('includes/left_panel.php');?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			
			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Chart <small>Monthly Order Chart</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.html">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					
					<li>
						<span>Monthly Order Chart</span>
					</li>
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					
					<!-- BEGIN ROW -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN CHART PORTLET-->
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-bar-chart font-green-haze"></i>
										<span class="caption-subject bold uppercase font-green-haze"> Bar Charts</span>
										<span class="caption-helper">Monthly Order</span>
									</div>
									<!--<div class="tools">
										<a href="javascript:;" class="collapse">
										</a>
										
										
										<a href="javascript:;" class="fullscreen">
										</a>
										<a href="javascript:;" class="remove">
										</a>
									</div>-->
								</div>
								<div class="portlet-body">
									<div id="chartdiv" class="chart" style="height: 500px;">
									</div>
								</div>
							</div>
							<!-- END CHART PORTLET-->
						</div>
					</div>
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php');?>
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
<script src="assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<!--<script src="assets/admin/pages/scripts/charts-amcharts.js"></script>-->
<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   ChartsAmcharts.init(); // init demo charts
});





  var chart = AmCharts.makeChart( "chartdiv", {
	  "type": "serial",
	  "theme": "light",
	  "dataProvider": [ 
     
	  {
	    "country": "Jan",
	    "visits": <?php echo $jan_visit;?>
	  }, {
	    "country": "Feb",
	    "visits": <?php echo $feb_visit;?>
	  }, {
	    "country": "Mar",
	    "visits": <?php echo $mar_visit;?>
	  }, {
	    "country": "Apr",
	    "visits":<?php echo $apr_visit;?>
	  }, {
	    "country": "May",
	    "visits": <?php echo $may_visit;?>

	  }, {
	    "country": "Jun",
	    "visits": <?php echo $jun_visit;?>
	  }, {
	    "country": "Jul",
	    "visits": <?php echo $jul_visit;?>
	  }, {
	    "country": "Aug",
	    "visits": <?php echo $aug_visit;?>
	  }, {
	    "country": "Sep",
	    "visits": <?php echo $sep_visit;?>
	  } ,{
	    "country": "Oct",
	    "visits": <?php echo $oct_visit;?>
	  }, {
	    "country": "Nov",
	    "visits": <?php echo $nov_visit;?>
	  }, {
	    "country": "Dec",
	    "visits": <?php echo $dec_visit;?>
	  }


	],
	  "valueAxes": [ {
	    "gridColor": "#FFFFFF",
	    "gridAlpha": 0.2,
	    "dashLength": 0
	  } ],
	  "gridAboveGraphs": true,
	  "startDuration": 1,
	  "graphs": [ {
	    "balloonText": "[[category]]: <b>$[[value]]</b>",
	    "fillAlphas": 0.8,
	    "lineAlpha": 0.2,
	    "type": "column",
	    "valueField": "visits"
	  } ],
	  "chartCursor": {
	    "categoryBalloonEnabled": false,
	    "cursorAlpha": 0,
	    "zoomable": false
	  },
	  "categoryField": "country",
	  "categoryAxis": {
	    "gridPosition": "start",
	    "gridAlpha": 0,
	    "tickPosition": "start",
	    "tickLength": 20
	  },
	  "export": {
	    "enabled": true
	  }

	} );



</script>
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
