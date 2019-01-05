<?php
include("includes/config.php");
include('includes/header.php');

$queryUser = "SELECT id from estejmam_user where 1";
$resUser = mysql_query($queryUser);
$numLandlord = mysql_num_rows($resUser);

$curdate = date("Y-m-d");

$todayuser = mysql_num_rows(mysql_query("select * from `estejmam_user` where `add_date`='" . $curdate . "'"));
$tomonthuser = mysql_num_rows(mysql_query("select * from `estejmam_user` where MONTHNAME(add_date)=MONTHNAME(CURDATE())"));
$toyearuser = mysql_num_rows(mysql_query("select * from `estejmam_user` where YEAR(add_date)=YEAR(CURDATE())"));


$queryProduct = "SELECT id from estejmam_main_property where id<>0";
$resProduct = mysql_query($queryProduct);
$numProduct = mysql_num_rows($resProduct);


/* $queryStore="SELECT id from estejmam_store where id<>0 and status=1";
  $resStore=mysql_query($queryStore);
  $numStore=mysql_num_rows($resStore); */



$queryOrder = "SELECT sum(orderamount) as order_amount from estejmam_tblorders where status='1'";
$resOrder = mysql_query($queryOrder);
$rowOrder = mysql_fetch_assoc($resOrder);


$queryOnlineUser = "SELECT id,fname,lname,is_loggedin,last_login,image from estejmam_user where id<>0 and type=0 and is_loggedin=1";
$resOnlineUser = mysql_query($queryOnlineUser);
$numOnlineUser = mysql_num_rows($resOnlineUser);


$numHost = mysql_num_rows(mysql_query("select * from `estejmam_user` where `host_type` = '1'"));


$sql = "select DAYOFMONTH(date) AS DAY,sum( `price` ) as price from `estejmam_tblorderdetails` where MONTH(date) =MONTH(CURDATE())  GROUP BY DAYOFMONTH(date)";
$excsql = mysql_query($sql);


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysql_query("delete from estejmam_user where id='" . $item_id . "'");
    header('Location:teant_dashboard.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
    $item_id = $_GET['cid'];
    mysql_query("update estejmam_user set status='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:teant_dashboard.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];
    mysql_query("update estejmam_user set status='1' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:teant_dashboard.php');
    exit();
}
?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
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
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="teant_dashboard.php">Dashboard</a>
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
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue-madison">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $numLandlord; ?> 
                            </div>
                            <div class="desc">
                                Total Members
                            </div>
                        </div>
                        <a class="more" href="search_user.php">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $numProduct; ?>
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

                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo $numHost; ?>
                            </div>
                            <div class="desc">
                                Total Landlord
                            </div>
                        </div>
                        <a class="more" href="search_user_host.php">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>

                <!--                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat purple-plum">
                                        <div class="visual">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                <?php echo $numUser; ?>
                                            </div>
                                            <div class="desc">
                                                Total Tenants
                                            </div>
                                        </div>
                                        <a class="more" href="search_user.php">
                                            View more <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>-->
                <!--                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat red-intense">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                $ <?php echo $rowOrder['order_amount']; ?>
                                            </div>
                                            <div class="desc">
                                                Total Order Amount
                                            </div>
                                        </div>
                                        <a class="more" href="search_order.php">
                                            View more <i class="m-icon-swapright m-icon-white"></i>
                                        </a>
                                    </div>
                                </div>-->


            </div>

            <!-- END DASHBOARD STATS -->
            <div class="clearfix">
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="caption">
                        <i class="fa fa-user"></i> Total Members
                        : <?php echo $numLandlord; ?>
                    </div> 
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Members</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Today</td>
                                <td>This Month</td>
                                <td>This Year</td>
                            </tr>
                            <tr>
                                <td><?php echo $todayuser; ?></td>
                                <td><?php echo $tomonthuser; ?></td>
                                <td><?php echo $toyearuser; ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>



                <div class="col-md-6 col-sm-6">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i> Recent orders
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $book = mysql_query("select * from `estejmam_booking` where 1 order by `date` DESC");
                            $num_all = mysql_num_rows($book);
                            if ($num_all > 0) {
                                while ($allbooks = mysql_fetch_array($book)) {
                                    $prop_name = mysql_fetch_array(mysql_query("select * from `estejmam_main_property` where `id`='" . $allbooks['prop_id'] . "'"));
                                    if ($allbooks['status'] == '1') {
                                        $sat = "Paid";
                                    } else {
                                        $sat = "Payment Failed";
                                    }
                                    ?>
                                    <tr>
                                        <th>#<?php echo $allbooks['transaction_id'] ?></th>
                                        <td><?php echo $prop_name['name'] ?></td>
                                        <td style="color: green;"><?php echo $sat ?></td>
                                        <td>$<?php echo $allbooks['price'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>




            </div>
            <div class="clearfix">
            </div>
            <div class="row ">

                <div class="col-md-12 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet box blue">
                        <div class="portlet-title line">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>Recent Members
                            </div>
                            <!--                            <div class="tools">
                                                            <a href="" class="collapse">
                                                            </a>
                                                            <a href="#portlet-config" data-toggle="modal" class="config">
                                                            </a>
                                                            <a href="" class="reload">
                                                            </a>
                                                            <a href="" class="remove">
                                                            </a>
                                                        </div>-->
                        </div>
                        <div class="portlet-body">
                            <!--BEGIN TABS-->
                            <div class="table-scrollable">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                            <div class="row">

                                                <?php
                                                $queryOnlineVendor = "SELECT * from estejmam_user where 1 order by `id` DESC LIMIT 8";
                                                $resOnlineVendor = mysql_query($queryOnlineVendor);
                                                $numOnlineVendor = mysql_num_rows($resOnlineVendor);
                                                while ($dataOnlineVendor = mysql_fetch_assoc($resOnlineVendor)) {

                                                    if ($dataOnlineVendor['image'] != '') {
                                                        $vendor_image = '../upload/userimages/' . $dataOnlineVendor['image'];
                                                    } else {
                                                        $vendor_image = '../upload/no.png';
                                                    }
                                                    ?>

                                                    <div class="col-md-6 user-info">
                                                        <img alt="" src="<?php echo $vendor_image; ?>" style="width:45px;height:45px;" class="img-responsive"/>
                                                        <div class="details">
                                                            <div>
                                                                <a href="#">
                                                                    <?php echo $dataOnlineVendor['fname'] . ' ' . $dataOnlineVendor['lname']; ?> 
                                                                </a>

                                                            </div>

                                                            <div>
                                                                Date : <?php echo $dataOnlineVendor['add_date']; ?>
                                                            </div>

                                                            <div>
                                                                <a href="add_user_type.php?id=<?php echo $dataOnlineVendor['id'] ?>&action=edit">Edit</a> |
                                                                <a href="javascript:void(0);" onclick="del('<?php echo $dataOnlineVendor['id']; ?>')">Delete</a> |
                                                                <?php
                                                                if ($dataOnlineVendor['status'] == '1') {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="inactive('<?php echo $dataOnlineVendor['id']; ?>')">Deactive</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="active('<?php echo $dataOnlineVendor['id']; ?>')">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
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





                    <div class="portlet box blue">
                        <div class="portlet-title line">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>Recent Landlord
                            </div>
                            <!--                            <div class="tools">
                                                            <a href="" class="collapse">
                                                            </a>
                                                            <a href="#portlet-config" data-toggle="modal" class="config">
                                                            </a>
                                                            <a href="" class="reload">
                                                            </a>
                                                            <a href="" class="remove">
                                                            </a>
                                                        </div>-->
                        </div>
                        <div class="portlet-body">
                            <!--BEGIN TABS-->
                            <div class="table-scrollable">
                                <!--                                <ul class="nav nav-tabs">
                                                                    <li class="active">
                                                                        <a href="#tab_1_1" data-toggle="tab">
                                                                            Host </a>
                                                                    </li>
                                
                                                                </ul>-->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                            <div class="row">

                                                <?php
                                                $queryOnlineVendor = "SELECT * from estejmam_user where 1 and `host_type`='1' order by `id` DESC LIMIT 8";
                                                $resOnlineVendor = mysql_query($queryOnlineVendor);
                                                $numOnlineVendor = mysql_num_rows($resOnlineVendor);
                                                while ($dataOnlineVendor = mysql_fetch_assoc($resOnlineVendor)) {

                                                    if ($dataOnlineVendor['image'] != '') {
                                                        $vendor_image = '../upload/userimages/' . $dataOnlineVendor['image'];
                                                    } else {
                                                        $vendor_image = '../upload/no.png';
                                                    }
                                                    ?>

                                                    <div class="col-md-6 user-info">
                                                        <img alt="" src="<?php echo $vendor_image; ?>" style="width:45px;height:45px;" class="img-responsive"/>
                                                        <div class="details">
                                                            <div>
                                                                <a href="#">
                                                                    <?php echo $dataOnlineVendor['fname'] . ' ' . $dataOnlineVendor['lname']; ?> 
                                                                </a>

                                                            </div>

                                                            <div>
                                                                Date : <?php echo $dataOnlineVendor['add_date']; ?>
                                                            </div>

                                                            <div>
                                                                <a href="add_user_type_host.php?id=<?php echo $dataOnlineVendor['id'] ?>&action=edit">Edit</a> |
                                                                <a href="javascript:void(0);" onclick="del('<?php echo $dataOnlineVendor['id']; ?>')">Delete</a> |
                                                                <?php
                                                                if ($dataOnlineVendor['status'] == '1') {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="inactive('<?php echo $dataOnlineVendor['id']; ?>')">Deactive</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="active('<?php echo $dataOnlineVendor['id']; ?>')">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
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
<?php include('includes/footer.php'); ?>
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



                                                                        jQuery(document).ready(function () {
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



                                                                        $(document).ready(function () {

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
$query = "SELECT 
                                count( * )as total_user ,
                                UPPER(DATE_FORMAT( `add_date` , '%b' )) as month_name
                            FROM `estejmam_user`
                            WHERE id<>0 and add_date!='0000-00-00'
                            GROUP BY DATE_FORMAT( `add_date` , '%M' )";

$res = mysql_query($query);
?>




                                                                                var data1 = [
<?php
while ($row = mysql_fetch_assoc($res)) {
    ?>
                                                                                        ['<?php echo $row['month_name']; ?>', <?php echo $row['total_user']; ?>],
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

<?php ?>




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

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>


<script language="javascript">
    function del(aa)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "teant_dashboard.php?cid=" + aa + "&action=delete"
        }
    }
    function inactive(aa)
    {

        location.href = "teant_dashboard.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {

        location.href = "teant_dashboard.php?cid=" + aa + "&action=active";
    }
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
