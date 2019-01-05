<?php 
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");
$sql="select DAYOFMONTH(date) AS DAY,sum( `price` ) as price from `estejmam_tblorderdetails` where MONTH(date) =MONTH(CURDATE())  GROUP BY DAYOFMONTH(date)";
$excsql=mysql_query($sql);





while($row_month=mysql_fetch_array($excsql))
{
 echo $row_month['DAY'].'<br>'; 
$rows_month[$row_month['DAY']] = $row_month;
 
}


$one_visit=isset($rows_month['1']['price']) ? $rows_month['1']['price'] : 0;
$two_visit=isset($rows_month['02']['price']) ? $rows_month['02']['price'] : 0;
$three_visit=isset($rows_month['03']['price']) ? $rows_month['03']['price'] : 0;
$four_visit=isset($rows_month['04']['price']) ? $rows_month['04']['price'] : 0;
$five_visit=isset($rows_month['05']['price']) ? $rows_month['05']['price'] : 0;
$six_visit=isset($rows_month['06']['price']) ? $rows_month['06']['price'] : 0;
$seven_visit=isset($rows_month['07']['price']) ? $rows_month['07']['price'] : 0;
$eight_visit=isset($rows_month['08']['price']) ? $rows_month['08']['price'] : 0;
$nine_visit=isset($rows_month['09']['price']) ? $rows_month['09']['price'] : 0;
$ten_visit=isset($rows_month['10']['price']) ? $rows_month['10']['price'] : 0;
$eleven_visit=isset($rows_month['11']['price']) ? $rows_month['11']['price'] : 0;
$twelve_visit=isset($rows_month['12']['price']) ? $rows_month['12']['price'] : 0;
$thirteen_visit=isset($rows_month['13']['price']) ? $rows_month['13']['price'] : 0;
$fourteen_visit=isset($rows_month['14']['price']) ? $rows_month['14']['price'] : 0;
$fifteen_visit=isset($rows_month['15']['price']) ? $rows_month['15']['price'] : 0;
$sixteen_visit=isset($rows_month['16']['price']) ? $rows_month['16']['price'] : 0;
$seventeen_visit=isset($rows_month['17']['price']) ? $rows_month['17']['price'] : 0;
$eighteen_visit=isset($rows_month['18']['price']) ? $rows_month['18']['price'] : 0;
$nineteen_visit=isset($rows_month['19']['price']) ? $rows_month['19']['price'] : 0;
$twenty_visit=isset($rows_month['20']['price']) ? $rows_month['20']['price'] : 0;
$twenty_one_visit=isset($rows_month['21']['price']) ? $rows_month['21']['price'] : 0;
$twenty_two_visit=isset($rows_month['22']['price']) ? $rows_month['22']['price'] : 0;
$twenty_three_visit=isset($rows_month['23']['price']) ? $rows_month['23']['price'] : 0;
$twenty_four_visit=isset($rows_month['24']['price']) ? $rows_month['24']['price'] : 0;
$twenty_five_visit=isset($rows_month['25']['price']) ? $rows_month['25']['price'] : 0;
$twenty_six_visit=isset($rows_month['26']['price']) ? $rows_month['26']['price'] : 0;
$twenty_seven_visit=isset($rows_month['27']['price']) ? $rows_month['27']['price'] : 0;
$twenty_eight_visit=isset($rows_month['28']['price']) ? $rows_month['28']['price'] : 0;
$twenty_nine_visit=isset($rows_month['29']['price']) ? $rows_month['29']['price'] : 0;
$thirty_visit=isset($rows_month['30']['price']) ? $rows_month['30']['price'] : 0;
$thirty_one_visit=isset($rows_month['31']['price']) ? $rows_month['31']['price'] : 0;


?>



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
			Chart <small>Monthly Chart</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
				
					<li>
						<span>Monthly Chart</span>
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
								<i class="fa fa-edit"></i>Monthly Chart for Month -<?php echo date('F');
								
								
								
								
								
								
								
								?>
							</div>
							<!--<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<!--<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>-->
						</div>
						<div class="portlet-body">
									<div id="container" class="chart" style="height: 500px;">
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

 <script src="anychart.min.js"></script>
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
            $( document ).ready(function() {
  // create data set on our data,also we can pud data directly to series
  var dataSet = anychart.data.set([
    ['1',<?php echo $one_visit; ?>],
    ['02', <?php echo $two_visit; ?>],
    ['03', <?php echo $three_visit; ?>],
    ['04', <?php echo $four_visit; ?>],
    ['05', <?php echo $five_visit; ?>],
    ['06', <?php echo $six_visit; ?>],
    ['07', <?php echo $seven_visit; ?>],
    ['08', <?php echo $eight_visit; ?>],
    ['09', <?php echo $nine_visit; ?>],
    ['10', <?php echo $ten_visit; ?>],
    ['11', <?php echo $eleven_visit; ?>],
	 ['12', <?php echo $twelve_visit; ?>],
    ['13', <?php echo $thirteen_visit; ?>],
    ['14', <?php echo $fourteen_visit; ?>],
    ['15', <?php echo $fifteen_visit; ?>],
    ['16', <?php echo $sixteen_visit; ?>],
    ['17', <?php echo $seventeen_visit; ?>],
    ['18', <?php echo $eighteen_visit; ?>],
    ['19', <?php echo $nineteen_visit; ?>],
    ['20', <?php echo $twenty_visit; ?>],
    ['21', <?php echo $twenty_one_visit; ?>],
	 ['22', <?php echo $twenty_two_visit; ?>],
    ['23', <?php echo $twenty_three_visit; ?>],
    ['24', <?php echo $twenty_four_visit; ?>],
    ['25', <?php echo $twenty_five_visit; ?>],
    ['26', <?php echo $twenty_six_visit; ?>],
    ['27', <?php echo $twenty_seven_visit; ?>],
    ['28', <?php echo $twenty_eight_visit; ?>],
    ['29', <?php echo $twenty_nine_visit; ?>],
	['29', <?php echo $thirty_visit; ?>],
   
    ['31', <?php echo $thirty_one_visit; ?>]
  ]);
  
 



  // map data for the first series,take value from first column of data set
  var seriesData_1 = dataSet.mapAs({x: [0], value: [1]});

  // map data for the second series,take value from second column of data set
  //var seriesData_2 = dataSet.mapAs({x: [0], value: [2]});

  // map data for the third series, take x from the zero column and value from the third column of data set
  //var seriesData_3 = dataSet.mapAs({x: [0], value: [3]});

  // create line chart
  chart = anychart.line();

  // turn on chart animation
  chart.animation(true);

  // turn on the crosshair
  chart.crosshair(true);

  // disable one of the chart grids
  chart.grid(0).enabled(false);

  // set container id for the chart
  chart.container('container');

  // set chart title text settings
  chart.title('Monthly Order Chart');

  // set yAxis title
  chart.yAxis().title('order per month In Dollar($)');
  chart.xAxis().title('Days in Month');

  /** We can edit series stroke by function in which context available
   *  @param color - stroke color
   *  @param style - dash lines style
   *  @return string/Object - acgraph.vector.Stroke type (string/Object)
  */
  var seriesStrokeFunction = function(color, style) {
    return {color: color, dash: style};
  };

  // temp variable to store series instance
  var series;

  // we can use local variables to change series settings
  series = chart.line(seriesData_1);
  series.stroke(seriesStrokeFunction(series.color(), '2 5'));
  series.name('order');
  series.markers(true);

  // or just use chaining calls
  //series = chart.line(seriesData_2);
  //series.stroke(seriesStrokeFunction(series.color(), '3 5 10 5'));
 // series.name('Delivery Failure');
  //series.markers(true);

  // or access series by index from chart
 //series = chart.line(seriesData_3);
  //series.stroke(seriesStrokeFunction(series.color(), '2 5'));
  //series.name('Order Cancellation');
  //series.markers(true);

  // turn the legend on
  chart.legend().enabled(true).align('center').fontSize(13);
 //chart.legend().enabled(true).align('right').fontSize(13);
  // initiate chart drawing
  chart.draw();
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
