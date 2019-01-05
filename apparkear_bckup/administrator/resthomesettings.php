<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");

$sql2 = "SELECT * FROM `home_settings` where id=1";
$res = mysqli_query($link, $sql2);
$row = mysqli_fetch_array($res);
if (isset($_REQUEST['submit'])) {
    $howitworks_title = isset($_POST['howitworks_title']) ? $_POST['howitworks_title'] : '';
    $howitworks_description = isset($_POST['howitworks_description']) ? $_POST['howitworks_description'] : '';
    $parkingspace_title = isset($_POST['parkingspace_title']) ? $_POST['parkingspace_title'] : '';
    $parkingspace_description = isset($_POST['parkingspace_description']) ? $_POST['parkingspace_description'] : '';
    $moreinfo_title = isset($_POST['moreinfo_title']) ? $_POST['moreinfo_title'] : '';
    $moreinfo_description = isset($_POST['moreinfo_description']) ? $_POST['moreinfo_description'] : '';

    $fields = array('howitworks_title' => mysqli_real_escape_string($link, $howitworks_title),
        'howitworks_description' => mysqli_real_escape_string($link, $howitworks_description),
        'parkingspace_title' => mysqli_real_escape_string($link, $parkingspace_title),
        'parkingspace_description' => mysqli_real_escape_string($link, $parkingspace_description),
        'moreinfo_title' => mysqli_real_escape_string($link, $moreinfo_title),
        'moreinfo_description' => mysqli_real_escape_string($link, $moreinfo_description)
);

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }


    $editQuery = "UPDATE `home_settings` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '" . mysqli_real_escape_string($link, $_SESSION['admin_id']) . "'";

    if (mysqli_query($link, $editQuery)) {
        $_SESSION['msg'] = "Home Settings Updated Successfully";
    } else {
        $_SESSION['msg'] = "Error occuried while updating Home Settings";
    }

    header('Location: resthomesettings.php');
    exit();
}
?>
<?php include('includes/header.php'); ?>
<!-- END HEADER -->


<div class="clearfix">
</div>
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
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Home Settings
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>

                    <li>
                        <span>Home Settings</span>
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
                                <i class="fa fa-gift"></i>Home Settings
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" method="post" action="" enctype="multipart/form-data">


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">How it works Title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter how it works title"  value="<?php echo $row['howitworks_title']; ?>" name="howitworks_title" required>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">How it works Description</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter how it works description"  value="<?php echo $row['howitworks_description']; ?>" name="howitworks_description" required>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">Parking Space Title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter parking space title"  value="<?php echo $row['parkingspace_title']; ?>" name="parkingspace_title" required>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">Parking Space Description</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter parking space description"  value="<?php echo $row['parkingspace_description']; ?>" name="parkingspace_description" required>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">More Information Title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Information Title"  value="<?php echo $row['moreinfo_title']; ?>" name="moreinfo_title" required>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">More Information Description</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Information Description"  value="<?php echo $row['moreinfo_description']; ?>" name="moreinfo_description" required>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
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


    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
<?php //include('includes/quick_sidebar.php'); ?>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
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
    jQuery(document).ready(function () {
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
