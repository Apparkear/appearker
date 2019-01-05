<?php
include("includes/config.php");
include('includes/header.php');

$queryUser = "SELECT id from estejmam_user where 1";
$resUser = mysqli_query($link, $queryUser);
$numLandlord = mysqli_num_rows($resUser);

$curdate = date("Y-m-d");

$todayuser = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where `add_date`='" . $curdate . "'"));
$tomonthuser = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where MONTHNAME(add_date)=MONTHNAME(CURDATE())"));
$toyearuser = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where YEAR(add_date)=YEAR(CURDATE())"));


$queryProduct = "SELECT id from estejmam_main_property where id<>0";
$resProduct = mysqli_query($link, $queryProduct);
$numProduct = mysqli_num_rows($resProduct);


/* $queryStore="SELECT id from estejmam_store where id<>0 and status=1";
  $resStore=mysqli_query($link, $queryStore);
  $numStore=mysqli_num_rows($resStore); */



$queryOrder = "SELECT sum(orderamount) as order_amount from estejmam_tblorders where status='1'";
$resOrder = mysqli_query($link, $queryOrder);
$rowOrder = mysqli_fetch_assoc($resOrder);


$queryOnlineUser = "SELECT id,fname,lname,is_loggedin,last_login,image from estejmam_user where id<>0 and type=0 and is_loggedin=1";
$resOnlineUser = mysqli_query($link, $queryOnlineUser);
$numOnlineUser = mysqli_num_rows($resOnlineUser);


$numHost = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where `host_type` = '1'"));

$num_acive_host = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where `host_type` = '1' and `status`='1'"));
$num_inacive_host = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_user` where `host_type` = '1' and `status`='0'"));



$sql = "select DAYOFMONTH(date) AS DAY,sum( `price` ) as price from `estejmam_tblorderdetails` where MONTH(date) =MONTH(CURDATE())  GROUP BY DAYOFMONTH(date)";
$excsql = mysqli_query($link, $sql);


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from estejmam_user where id='" . $item_id . "'");
    header('Location:teant_dashboard.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_user set status='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:teant_dashboard.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_user set status='1' where id='" . $item_id . "'");
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
                        <a href="property_dashboard.php">Dashboard</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
                        <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row ">

                <div class="col-md-12 col-sm-6">




                    <div class="portlet box blue">
                        <div class="portlet-title line">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>Properties
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
                            <div class="table-scrollable">
                                <div class="col-sm-6">
                                    <section class="panel" style="margin-bottom: 0px;">
                                        <div class="panel-body" style="padding-bottom: 0px;">
                                            <div id="pie-chart" class="pie-chart">
                                                <ul data-pie-id="pie_prop_report">
                                                    <?php
                                                    $ho1 = mysqli_query($link, "select * from `estejmam_property_type` where 1");
                                                    $numhost1 = mysqli_num_rows($ho1);
                                                    if ($numhost1 > 0) {
                                                        while ($totalhost1 = mysqli_fetch_object($ho1)) {
                                                            $totalprop1 = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_main_property` where `prop_type`='" . $totalhost1->id . "'"));
                                                            ?>
                                                            <li data-value="<?php echo $totalprop1; ?>"><?php echo $totalhost1->name ?></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </ul>

                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-sm-6">
                                    <div id="pie_prop_report"></div>
                                </div>
                            </div>
                        </div>
                    </div>










                    <div class="portlet box blue">
                        <div class="portlet-title line">
                            <div class="caption">
                                <i class="fa fa-bell-o"></i>Landlord
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
                            <div class="table-scrollable">
                                <div class="col-sm-6">
                                    <section class="panel" style="margin-bottom: 0px;">
                                        <div class="panel-body" style="padding-bottom: 0px;">
                                            <div id="pie-chart" class="pie-chart">
                                                <ul data-pie-id="pie_user_report">
                                                    <?php
                                                    $ho = mysqli_query($link, "select * from `estejmam_user` where `host_type` = '1'");
                                                    $numhost = mysqli_num_rows($ho);
                                                    if ($numhost > 0) {
                                                        while ($totalhost = mysqli_fetch_object($ho)) {
                                                            $totalprop = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_main_property` where `user_id`='" . $totalhost->id . "'"));
                                                            ?>
                                                            <li data-value="<?php echo $totalprop; ?>"><?php echo $totalhost->fname ?></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </ul>

                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-sm-6">
                                    <div id="pie_user_report"></div>
                                </div>
                            </div>
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

</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>


<link href="piecss/normalize.css" rel="stylesheet">
<link href="piecss/pizza.css" rel="stylesheet">
<script src="piejs/modernizr.js" type="text/javascript"></script>
<script src="piejs/dependencies.js" type="text/javascript"></script>
<script src="piejs/pizza.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
//alert(1);
        Pizza.init();
    });
//init index page's custom scripts

    /*Index.initCalendar(); // init index page's custom scripts

     Index.initCharts(); // init index page's custom scripts

     // Index.initChat();

     Index.initMiniCharts();

     Tasks.initDashboardWidget();

     });jQuery(document).ready(function() {
     Metronic.init(); // init metronic core componets
     Layout.init(); // init layout
     QuickSidebar.init(); // init quick sidebar
     Demo.init(); // init demo features
     Index.init();
     Index.initDashboardDaterange();
     Index.initJQVMAP(); // init index page's custom scripts
     Index.initCalendar(); // init index page's custom scripts
     Index.initCharts(); // init index page's custom scripts
     Index.initChat();
     Index.initMiniCharts();
     Tasks.initDashboardWidget();
     });*/
</script>

<style>
    #pie_prop_report svg {
        width: 62%;
        height: auto;
        font-size: 33px;

    }

    #pie_user_report svg {
        width: 62%;
        height: auto;
        font-size: 33px;

    }
</style>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
