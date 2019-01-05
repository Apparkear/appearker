<?php
include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");


if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {

    $id = intval(mysql_real_escape_string($_REQUEST['id']));
    $queryStore = "SELECT * FROM estejmam_store  where id<>'' and id=" . $id . "";
    $resStore = mysql_query($queryStore);
    $numStore = mysql_num_rows($resStore);
    $rowStore = mysql_fetch_assoc($resStore);


    $queryUser = "SELECT fname,lname FROM estejmam_user WHERE id=" . $rowStore['user_id'] . "";
    $resUser = mysql_query($queryUser);
    $rowUser = mysql_fetch_assoc($resUser);
}
?>

<?php include("includes/header.php"); ?>
<div class="clearfix">
</div>
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include("includes/left_panel.php"); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Store Detail <small>view Store details</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="index.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>

                    <li>
                        <span>Store View</span>
                    </li>
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->




            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet">

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
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet yellow-crusta box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Store Details
                                                        </div>
                                                        <div class="actions">

                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">




                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Store Logo :
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php
                                                                if ($rowStore['store_photo'] != "") {
                                                                    $store_logo = '../upload/site_logo/' . $rowStore['store_photo'];
                                                                } else {
                                                                    $store_logo = '../upload/no.png';
                                                                }
                                                                ?>

                                                                <img alt="" src="<?php echo $store_logo; ?>" style="width:60px;height:60px;" class="img-responsive"/>
                                                            </div>
                                                        </div>




                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Owner :
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowUser['fname'] . ' ' . $rowUser['lname']; ?>
                                                            </div>
                                                        </div>



                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Store :
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowStore['store_title']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Start Date :
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowStore['create_date']; ?>
                                                            </div>
                                                        </div>


                                                        <!--<div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                         Order Status:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                                        <span class="label label-success">
                                                        <?php
                                                        if ($rowOrderDetails['orderdate'] == '1') {
                                                            echo 'Success';
                                                        } else {
                                                            echo 'Pending';
                                                        };
                                                        ?>  </span>
                                                                </div>
                                                        </div>-->
                                                        <!--<div class="row static-info">
                                                                <div class="col-md-5 name">
                                                                         Expiration Date:
                                                                </div>
                                                                <div class="col-md-7 value">
                                                        <?php echo $rowStore['expiry_date']; ?>
                                                                </div>
                                                        </div>-->

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet blue-hoki box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Contact Information
                                                        </div>
                                                        <div class="actions">

                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">

                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Store Banner :
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php
                                                                if ($rowStore['store_banner'] != "") {
                                                                    $store_banner = '../upload/storebanner/' . $rowStore['store_banner'];
                                                                } else {
                                                                    $store_banner = '../upload/no.png';
                                                                }
                                                                ?>

                                                                <img alt="" src="<?php echo $store_banner; ?>" style="width:60px;height:60px;" class="img-responsive"/>
                                                            </div>
                                                        </div>


                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Contact Person:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowStore['owner']; ?> 
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Email:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowStore['email']; ?> 
                                                            </div>
                                                        </div>

                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                Phone Number:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $rowStore['phone']; ?> 
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
															
                                                            <div class="col-md-5 name">
																                                                            Facebook Link:
															
                                                            </div>
															
                                                            <div class="col-md-7 value">
																                                                            <?php echo $rowStore['fb_link'];?> 
															
                                                            </div>
														
                                                        </div>
                                                        <div class="row static-info">
															
                                                            <div class="col-md-5 name">
																                                                            Twitter Link:
															
                                                            </div>
															
                                                            <div class="col-md-7 value">
																                                                         <?php echo $rowStore['tw_link'];?> 
															
                                                            </div>
                                                        </div>
                                                            <div class="row static-info">
															
                                                                <div class="col-md-5 name">
																                                                               Viber Link:
															
                                                                </div>
															
                                                                <div class="col-md-7 value">
																                                                            <?php echo $rowStore['vb_link'];?> 
															
                                                                </div>
														
                                                            </div>
                                                            <div class="row static-info">
															
                                                                <div class="col-md-5 name">
																                                                                    Skype Link:
															
                                                                </div>
															
                                                                <div class="col-md-7 value">
																                                                            <?php echo $rowStore['sk_link'];?> 
															
                                                                </div>
														
                                                            </div>
														
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet green-meadow box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>More About Store
                                                        </div>
                                                        <div class="actions">

                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-12 value">
                                                                <?php echo $rowStore['store_details']; ?>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet red-sunglo box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Store Address
                                                        </div>
                                                        <div class="actions">

                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-12 value">
                                                                <?php echo $rowStore['address']; ?>
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






            <!-- END PAGE CONTENT-->
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
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<script src="assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js"></script>
<script src="assets/admin/pages/scripts/ecommerce-orders-view.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        // EcommerceOrdersView.init();
        MapsGoogle.init();
        // Index.initCharts(); 
    });

</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
