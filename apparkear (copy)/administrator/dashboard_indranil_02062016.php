<?php 
include("includes/config.php");
include('includes/header.php');

$queryUser="SELECT id from estejmam_user where id<>'' AND `type`='1'";
$resUser=mysql_query($queryUser);
$numLandlord=mysql_num_rows($resUser);

$queryUser="SELECT id from estejmam_user where id<>'' AND `type`='0'";
$resUser=mysql_query($queryUser);
$numUser=mysql_num_rows($resUser);

$queryProduct="SELECT id from estejmam_property where id<>0";
$resProduct=mysql_query($queryUser);
$numProduct=mysql_num_rows($resProduct);


/*$queryStore="SELECT id from estejmam_store where id<>0 and status=1";
$resStore=mysql_query($queryStore);
$numStore=mysql_num_rows($resStore);*/



$queryOrder="SELECT sum(orderamount) as order_amount from estejmam_tblorders where status='1'";
$resOrder=mysql_query($queryOrder);
$rowOrder=mysql_fetch_assoc($resOrder);


$queryOnlineUser="SELECT id,fname,lname,is_loggedin,last_login,image from estejmam_user where id<>0 and type=0 and is_loggedin=1";
$resOnlineUser=mysql_query($queryOnlineUser);
$numOnlineUser=mysql_num_rows($resOnlineUser);

$queryOnlineVendor="SELECT id,fname,lname,is_loggedin,last_login,image from estejmam_user where id<>0 and type=1 and is_loggedin=1";
$resOnlineVendor=mysql_query($queryOnlineVendor);
$numOnlineVendor=mysql_num_rows($resOnlineVendor);


$sql="select DAYOFMONTH(date) AS DAY,sum( `price` ) as price from `estejmam_tblorderdetails` where MONTH(date) =MONTH(CURDATE())  GROUP BY DAYOFMONTH(date)";
$excsql=mysql_query($sql);





while($row_month=mysql_fetch_array($excsql))
{
  
  $rows_month[$row_month['DAY']] = $row_month;

}


$one_visit=isset($rows_month['1']['price']) ? $rows_month['1']['price'] : 0;
$two_visit=isset($rows_month['2']['price']) ? $rows_month['2']['price'] : 0;
$three_visit=isset($rows_month['3']['price']) ? $rows_month['3']['price'] : 0;
$four_visit=isset($rows_month['4']['price']) ? $rows_month['4']['price'] : 0;
$five_visit=isset($rows_month['5']['price']) ? $rows_month['5']['price'] : 0;
$six_visit=isset($rows_month['6']['price']) ? $rows_month['6']['price'] : 0;
$seven_visit=isset($rows_month['7']['price']) ? $rows_month['7']['price'] : 0;
$eight_visit=isset($rows_month['8']['price']) ? $rows_month['8']['price'] : 0;
$nine_visit=isset($rows_month['9']['price']) ? $rows_month['9']['price'] : 0;
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

$sql1="select DAYOFMONTH(date) AS DAY,sum( `quantity` ) as quantity from `estejmam_tblorderdetails` where MONTH(date) =MONTH(CURDATE())  GROUP BY DAYOFMONTH(date)";
$excsql1=mysql_query($sql1);





while($row_month1=mysql_fetch_array($excsql1))
{
  
  $rows_month1[$row_month1['DAY']] = $row_month1;
 
}


$one_visit1=isset($rows_month1['1']['quantity']) ? $rows_month1['1']['quantity'] : 0;
$two_visit1=isset($rows_month1['2']['quantity']) ? $rows_month1['2']['quantity'] : 0;
$three_visit1=isset($rows_month1['3']['quantity']) ? $rows_month1['3']['quantity'] : 0;
$four_visit1=isset($rows_month1['4']['quantity']) ? $rows_month1['4']['quantity'] : 0;
$five_visit1=isset($rows_month1['5']['quantity']) ? $rows_month1['5']['quantity'] : 0;
$six_visit1=isset($rows_month1['6']['quantity']) ? $rows_month1['06']['quantity'] : 0;
$seven_visit1=isset($rows_month1['7']['quantity']) ? $rows_month1['7']['quantity'] : 0;
$eight_visit1=isset($rows_month1['8']['quantity']) ? $rows_month1['8']['quantity'] : 0;
$nine_visit1=isset($rows_month1['9']['quantity']) ? $rows_month1['9']['quantity'] : 0;
$ten_visit1=isset($rows_month1['10']['quantity']) ? $rows_month1['10']['quantity'] : 0;
$eleven_visit1=isset($rows_month1['11']['quantity']) ? $rows_month1['11']['quantity'] : 0;
$twelve_visit1=isset($rows_month1['12']['quantity']) ? $rows_month1['12']['quantity'] : 0;
$thirteen_visit1=isset($rows_month1['13']['quantity']) ? $rows_month1['13']['quantity'] : 0;
$fourteen_visit1=isset($rows_month1['14']['quantity']) ? $rows_month1['14']['quantity'] : 0;
$fifteen_visit1=isset($rows_month1['15']['quantity']) ? $rows_month1['15']['quantity'] : 0;
$sixteen_visit1=isset($rows_month1['16']['quantity']) ? $rows_month1['16']['quantity'] : 0;
$seventeen_visit1=isset($rows_month1['17']['quantity']) ? $rows_month1['17']['quantity'] : 0;
$eighteen_visit1=isset($rows_month1['18']['quantity']) ? $rows_month1['18']['quantity'] : 0;
$nineteen_visit1=isset($rows_month1['19']['quantity']) ? $rows_month1['19']['quantity'] : 0;
$twenty_visit1=isset($rows_month1['20']['quantity']) ? $rows_month1['20']['quantity'] : 0;
$twenty_one_visit1=isset($rows_month1['21']['quantity']) ? $rows_month1['21']['quantity'] : 0;
$twenty_two_visit1=isset($rows_month1['22']['quantity']) ? $rows_month1['22']['quantity'] : 0;
$twenty_three_visit1=isset($rows_month1['23']['quantity']) ? $rows_month1['23']['quantity'] : 0;
$twenty_four_visit1=isset($rows_month1['24']['quantity']) ? $rows_month1['24']['quantity'] : 0;
$twenty_five_visit1=isset($rows_month1['25']['quantity']) ? $rows_month1['25']['quantity'] : 0;
$twenty_six_visit1=isset($rows_month1['26']['quantity']) ? $rows_month1['26']['quantity'] : 0;
$twenty_seven_visit1=isset($rows_month1['27']['quantity']) ? $rows_month1['27']['quantity'] : 0;
$twenty_eight_visit1=isset($rows_month1['28']['quantity']) ? $rows_month1['28']['quantity'] : 0;
$twenty_nine_visit1=isset($rows_month1['29']['quantity']) ? $rows_month1['29']['quantity'] : 0;
$thirty_visit1=isset($rows_month1['30']['quantity']) ? $rows_month1['30']['quantity'] : 0;
$thirty_one_visit1=isset($rows_month1['31']['quantity']) ? $rows_month1['31']['quantity'] : 0;


?>
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
			<!--<div class="theme-panel hidden-xs hidden-sm">
				<div class="toggler">
				</div>
				<div class="toggler-close">
				</div>
				<div class="theme-options">
					<div class="theme-option theme-colors clearfix">
						<span>
						THEME COLOR </span>
						<ul>
							<li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default">
							</li>
							<li class="color-darkblue tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue">
							</li>
							<li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue">
							</li>
							<li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey">
							</li>
							<li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light">
							</li>
							<li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2">
							</li>
						</ul>
					</div>
					<div class="theme-option">
						<span>
						Theme Style </span>
						<select class="layout-style-option form-control input-sm">
							<option value="square" selected="selected">Square corners</option>
							<option value="rounded">Rounded corners</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Layout </span>
						<select class="layout-option form-control input-sm">
							<option value="fluid" selected="selected">Fluid</option>
							<option value="boxed">Boxed</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Header </span>
						<select class="page-header-option form-control input-sm">
							<option value="fixed" selected="selected">Fixed</option>
							<option value="default">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Top Menu Dropdown</span>
						<select class="page-header-top-dropdown-style-option form-control input-sm">
							<option value="light" selected="selected">Light</option>
							<option value="dark">Dark</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Mode</span>
						<select class="sidebar-option form-control input-sm">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Menu </span>
						<select class="sidebar-menu-option form-control input-sm">
							<option value="accordion" selected="selected">Accordion</option>
							<option value="hover">Hover</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Style </span>
						<select class="sidebar-style-option form-control input-sm">
							<option value="default" selected="selected">Default</option>
							<option value="light">Light</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Sidebar Position </span>
						<select class="sidebar-pos-option form-control input-sm">
							<option value="left" selected="selected">Left</option>
							<option value="right">Right</option>
						</select>
					</div>
					<div class="theme-option">
						<span>
						Footer </span>
						<select class="page-footer-option form-control input-sm">
							<option value="fixed">Fixed</option>
							<option value="default" selected="selected">Default</option>
						</select>
					</div>
				</div>
			</div>-->
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Dashboard <small>reports & statistics</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.html">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
						<i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
			
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $numProduct;?> 
							</div>
							<div class="desc">
								Total Properties
							</div>
						</div>
						<a class="more" href="list_product.php">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $numLandlord;?>
							</div>
							<div class="desc">
								 Total Landlords
							</div>
						</div>
						<a class="more" href="search_vendor.php">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $numUser;?>
							</div>
							<div class="desc">
								 Total Tenants
							</div>
						</div>
						<a class="more" href="search_user.php">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								$ <?php echo $rowOrder['order_amount'];?>
							</div>
							<div class="desc">
								 Total Order Amount
							</div>
						</div>
						<a class="more" href="search_order.php">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			
				
			</div>
			
			<!-- END DASHBOARD STATS -->
			<div class="clearfix">
			</div>
			<div class="row">
				
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid grey-cararra bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn"></i>Customer
							</div>
							<!--<div class="actions">
								<div class="btn-group pull-right">
									<a href="" class="btn grey-steel btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									Filter <span class="fa fa-angle-down">
									</span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:;">
											Q1 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q2 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li class="active">
											<a href="javascript:;">
											Q3 2014 <span class="label label-sm label-success">
											current </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q4 2014 <span class="label label-sm label-warning">
											upcoming </span>
											</a>
										</li>
									</ul>
								</div>
							</div>-->
						</div>
						<div class="portlet-body">
							<div id="site_activities_loading">
								<img src="assets/admin/layout/img/loading.gif" alt="loading"/>
							</div>
							<div id="site_activities_content" class="display-none">
								<div id="site_activities" style="height: 228px;">
								</div>
							</div>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-success">
										Months Registered</span>
										<h3></h3>
									</div>
									<!--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-info">
										Tax: </span>
										<h3>$134,900</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-danger">
										Shipment: </span>
										<h3>$1,134</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-warning">
										Orders: </span>
										<h3>235090</h3>
									</div>-->
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
                        <div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid grey-cararra bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn"></i>Per Day Order Sold (Amount) for Month of <?php echo date('M'); ?>
							</div>
							<!--<div class="actions">
								<div class="btn-group pull-right">
									<a href="" class="btn grey-steel btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									Filter <span class="fa fa-angle-down">
									</span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:;">
											Q1 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q2 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li class="active">
											<a href="javascript:;">
											Q3 2014 <span class="label label-sm label-success">
											current </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q4 2014 <span class="label label-sm label-warning">
											upcoming </span>
											</a>
										</li>
									</ul>
								</div>
							</div>-->
						</div>
						<div class="portlet-body">
							<div id="site_activities_loading_1">
								<img src="assets/admin/layout/img/loading.gif" alt="loading"/>
							</div>
							<div id="site_activities_content_1" class="display-none">
								<div id="site_activities_1" style="height: 228px;">
								</div>
							</div>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-success">
										Days in Month</span>
										<h3></h3>
									</div>
									<!--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-info">
										Tax: </span>
										<h3>$134,900</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-danger">
										Shipment: </span>
										<h3>$1,134</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-warning">
										Orders: </span>
										<h3>235090</h3>
									</div>-->
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
                            <div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid grey-cararra bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bullhorn"></i>Per Day Products Sold (Quantity) for Month of <?php echo date('M'); ?>
							</div>
							<!--<div class="actions">
								<div class="btn-group pull-right">
									<a href="" class="btn grey-steel btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									Filter <span class="fa fa-angle-down">
									</span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:;">
											Q1 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q2 2014 <span class="label label-sm label-default">
											past </span>
											</a>
										</li>
										<li class="active">
											<a href="javascript:;">
											Q3 2014 <span class="label label-sm label-success">
											current </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
											Q4 2014 <span class="label label-sm label-warning">
											upcoming </span>
											</a>
										</li>
									</ul>
								</div>
							</div>-->
						</div>
						<div class="portlet-body">
							<div id="site_activities_loading_2">
								<img src="assets/admin/layout/img/loading.gif" alt="loading"/>
							</div>
							<div id="site_activities_content_2" class="display-none">
								<div id="site_activities_2" style="height: 228px;">
								</div>
							</div>
							<div style="margin: 20px 0 10px 30px">
								<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-success">
										Days in Month</span>
										<h3></h3>
									</div>
									<!--<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-info">
										Tax: </span>
										<h3>$134,900</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-danger">
										Shipment: </span>
										<h3>$1,134</h3>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 text-stat">
										<span class="label label-sm label-warning">
										Orders: </span>
										<h3>235090</h3>
									</div>-->
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				
				
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet solid bordered grey-cararra">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-bar-chart-o"></i>Site Visits
							</div>
							<div class="actions">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn grey-steel btn-sm active">
									<input type="radio" name="options" class="toggle" id="option1">New</label>
									<label class="btn grey-steel btn-sm">
									<input type="radio" name="options" class="toggle" id="option2">Returning</label>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<div id="site_statistics_loading">
								<img src="../../assets/admin/layout/img/loading.gif" alt="loading"/>
							</div>
							<div id="site_statistics_content" class="display-none">
								<div id="site_statistics" class="chart">
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
                        
			</div>
			<div class="clearfix">
			</div>
			<div class="row ">
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet paddingless">
						<div class="portlet-title line">
							<div class="caption">
								<i class="fa fa-bell-o"></i>Vendor
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<!--BEGIN TABS-->
							<div class="tabbable tabbable-custom">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_1_1" data-toggle="tab">
										Online Store Owner </a>
									</li>
									
								</ul>
								<div class="tab-content">
									
									
									<div class="tab-pane active" id="tab_1_1">
										<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
											<div class="row">
													
												<?php
												
												
												while($dataOnlineVendor=mysql_fetch_assoc($resOnlineVendor))
												{
												
													if($dataOnlineVendor['image']!='')
													{
													$vendor_image='../upload/userimage/'.$dataOnlineVendor['image'];
													}
													else {
													$vendor_image='../upload/no.png';
													}
												?>
												
												<div class="col-md-6 user-info">
													<img alt="" src="<?php echo $vendor_image;?>" style="width:45px;height:45px;" class="img-responsive"/>
													<div class="details">
														<div>
															<a href="#">
															<?php echo $dataOnlineVendor['fname'].' '.$dataOnlineVendor['lname'];?> 
															</a>
															
														</div>
														<div>
															<?php echo $dataOnlineVendor['last_login'];?>
														</div>
													</div>
												</div>
												
												
												<?php
												}
												?>
												
												
												
												
											</div>
											
											
										</div>
									</div>
								</div>
							</div>
							<!--END TABS-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet paddingless">
						<div class="portlet-title line">
							<div class="caption">
								<i class="fa fa-bell-o"></i>User
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<!--BEGIN TABS-->
							<div class="tabbable tabbable-custom">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_2_1" data-toggle="tab">
										Online User </a>
									</li>
									
								</ul>
								<div class="tab-content">
									
									
									<div class="tab-pane active" id="tab_2_1">
										<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
											<div class="row">
												
												<?php
												
												
												while($dataOnlineUser=mysql_fetch_assoc($resOnlineUser))
												{
												
													if($dataOnlineUser['image']!='')
													{
													$user_image='../upload/userimage/'.$dataOnlineUser['image'];
													}
													else {
													$user_image='../upload/no.png';
													}
												?>
												
												<div class="col-md-6 user-info">
													<img alt="" src="<?php echo $user_image;?>" style="width:45px;height:45px;" class="img-responsive"/>
													<div class="details">
														<div>
															<a href="#">
															<?php echo $dataOnlineUser['fname'].' '.$dataOnlineUser['lname'];?> 
															</a>
															
														</div>
														<div>
															<?php echo $dataOnlineUser['last_login'];?>
														</div>
													</div>
												</div>
												
												
												<?php
												}
												?>
												
												
												
											</div>
											
											
											
											
											
										</div>
									</div>
								</div>
							</div>
							<!--END TABS-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
			
			
			<div class="clearfix">
			</div>
		
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->
	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php');?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
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
<!-- for graph-->


<script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>

<!-- end for graph-->
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!--<script src="../../assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>-->
<script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>



jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
   Demo.init(); // init demo features 
   Index.init();   
   Index.initDashboardDaterange();
  // Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
  // Index.initChat();
   Index.initMiniCharts();
   Tasks.initDashboardWidget();
});



$(document).ready(function(){

   function showChartTooltip(x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }

 if ($('#site_activities').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading').hide();
                $('#site_activities_content').show();
             
                <?php
                
             $query= "SELECT 
                                count( * )as total_user ,
                                UPPER(DATE_FORMAT( `add_date` , '%b' )) as month_name
                            FROM `estejmam_user`
                            WHERE id<>0 and add_date!='0000-00-00'
                            GROUP BY DATE_FORMAT( `add_date` , '%M' )";
                
                $res=mysql_query($query);
                
                
                
                ?>
                
                
                

                var data1 = [
                <?php
                while($row=mysql_fetch_assoc($res))
                {
                    ?>
                 ['<?php echo $row['month_name'];?>', <?php echo $row['total_user'];?>],
                         <?php
                }
                ?>
                
                   
                   /* ['JAN', 500],
                    ['FEB', 1100],
                    ['MAR', 1200],
                    ['APR', 860],
                    ['MAY', 1200],
                    ['JUN', 1450],
                    ['JUL', 1800],
                    ['AUG', 1200],
                    ['SEP', 600]*/
                ];


                var plot_statistics = $.plot($("#site_activities"),

                    [{
                        data: data1,
                        lines: {
                            fill: 0.2,
                            lineWidth: 0,
                        },
                        color: ['#BAD9F5']
                    }, {
                        data: data1,
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        color: '#9ACAE6',
                        shadowSize: 1
                    }, {
                        data: data1,
                        lines: {
                            show: true,
                            fill: false,
                            lineWidth: 3
                        },
                        color: '#9ACAE6',
                        shadowSize: 0
                    }],

                    {

                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                $("#site_activities").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' User');
                        }
                    }
                });

                $('#site_activities').bind("mouseleave", function () {
                    $("#tooltip").remove();
                });
            }


 if ($('#site_activities_1').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading_1').hide();
                $('#site_activities_content_1').show();
             
                <?php
                
             
                
                
                
                ?>
                
                
                

                var data1 = [
                    ['01',<?php echo $one_visit; ?>],
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
                
                
                   
                  /* ['JAN', 500],
                    ['FEB', 1100],
                    ['MAR', 1200],
                    ['APR', 860],
                    ['MAY', 1200],
                    ['JUN', 1450],
                    ['JUL', 1800],
                    ['AUG', 1200],
                    ['SEP', 600]*/
                ];


                var plot_statistics = $.plot($("#site_activities_1"),

                    [{
                        data: data1,
                        lines: {
                            fill: 0.2,
                            lineWidth: 0,
                        },
                        color: ['#BAD9F5']
                    }, {
                        data: data1,
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        color: '#9ACAE6',
                        shadowSize: 1
                    }, {
                        data: data1,
                        lines: {
                            show: true,
                            fill: false,
                            lineWidth: 3
                        },
                        color: '#9ACAE6',
                        shadowSize: 0
                    }],

                    {

                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                $("#site_activities_1").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' $');
                        }
                    }
                });

                $('#site_activities_1').bind("mouseleave", function () {
                    $("#tooltip").remove();
                });
            }

if ($('#site_activities_2').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading_2').hide();
                $('#site_activities_content_2').show();
             
               
                
                
                

                var data1 = [
                    ['01',<?php echo $one_visit1; ?>],
    ['02', <?php echo $two_visit1; ?>],
    ['03', <?php echo $three_visit1; ?>],
    ['04', <?php echo $four_visit1; ?>],
    ['05', <?php echo $five_visit1; ?>],
    ['06', <?php echo $six_visit1; ?>],
    ['07', <?php echo $seven_visit1; ?>],
    ['08', <?php echo $eight_visit1; ?>],
    ['09', <?php echo $nine_visit1; ?>],
    ['10', <?php echo $ten_visit1; ?>],
    ['11', <?php echo $eleven_visit1; ?>],
	 ['12', <?php echo $twelve_visit1; ?>],
         
         
    ['13', <?php echo $thirteen_visit1; ?>],
    ['14', <?php echo $fourteen_visit1; ?>],
    ['15', <?php echo $fifteen_visit1; ?>],
    ['16', <?php echo $sixteen_visit1; ?>],
    ['17', <?php echo $seventeen_visit1; ?>],
    ['18', <?php echo $eighteen_visit1; ?>],
    ['19', <?php echo $nineteen_visit1; ?>],
    ['20', <?php echo $twenty_visit1; ?>],
    ['21', <?php echo $twenty_one_visit1; ?>],
	 ['22', <?php echo $twenty_two_visit1; ?>],
    ['23', <?php echo $twenty_three_visit1; ?>],
    ['24', <?php echo $twenty_four_visit1; ?>],
    ['25', <?php echo $twenty_five_visit1; ?>],
    ['26', <?php echo $twenty_six_visit1; ?>],
    ['27', <?php echo $twenty_seven_visit1; ?>],
    ['28', <?php echo $twenty_eight_visit1; ?>],
    ['29', <?php echo $twenty_nine_visit1; ?>],
	['29', <?php echo $thirty_visit1; ?>],
   
    ['31', <?php echo $thirty_one_visit1; ?>]
                
                
                   
                  /* ['JAN', 500],
                    ['FEB', 1100],
                    ['MAR', 1200],
                    ['APR', 860],
                    ['MAY', 1200],
                    ['JUN', 1450],
                    ['JUL', 1800],
                    ['AUG', 1200],
                    ['SEP', 600]*/
                ];


                var plot_statistics = $.plot($("#site_activities_2"),

                    [{
                        data: data1,
                        lines: {
                            fill: 0.2,
                            lineWidth: 0,
                        },
                        color: ['#BAD9F5']
                    }, {
                        data: data1,
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        color: '#9ACAE6',
                        shadowSize: 1
                    }, {
                        data: data1,
                        lines: {
                            show: true,
                            fill: false,
                            lineWidth: 3
                        },
                        color: '#9ACAE6',
                        shadowSize: 0
                    }],

                    {

                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                $("#site_activities_2").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' Products');
                        }
                    }
                });

                $('#site_activities_2').bind("mouseleave", function () {
                    $("#tooltip").remove();
                });
            }







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
