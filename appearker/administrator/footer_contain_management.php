<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


//$pid=$_REQUEST['id'];
$sql2 = "SELECT * FROM `estejmam_sitesettings` where id=1";
$res = mysql_query($sql2);
$row = mysql_fetch_array($res);
//print_r($row);
if (isset($_REQUEST['submit'])) {
    //$email=$_REQUEST['email'];

    $footer_button_text = isset($_POST['footer_button_text']) ? $_POST['footer_button_text'] : '';
    $footer_help_center = isset($_POST['footer_help_center']) ? $_POST['footer_help_center'] : '';
    $site_email = isset($_POST['site_email']) ? $_POST['site_email'] : '';
    $site_phone = isset($_POST['site_phone']) ? $_POST['site_phone'] : '';
    $footer_coustomer_support_text = isset($_POST['footer_coustomer_support_text']) ? $_POST['footer_coustomer_support_text'] : '';

    $fields = array('footer_button_text' => mysql_real_escape_string($footer_button_text),
                    'footer_help_center' => mysql_real_escape_string($footer_help_center),
                    'site_email' => mysql_real_escape_string($site_email),
                    'site_phone' => mysql_real_escape_string($site_phone),
                    'footer_coustomer_support_text' => mysql_real_escape_string($footer_coustomer_support_text));
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    $editQuery = "UPDATE `estejmam_sitesettings` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = 1" ;
    /*echo $editQuery;
    exit();*/

    if (mysql_query($editQuery)) {
        $_SESSION['msg'] = "Email Updated Successfully";
    } else {
        $_SESSION['msg'] = "Error occuried while updating Email";
    }

    header('Location: footer_contain_management.php');
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
<?php //include('includes/style_customize.php'); ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Update footer contain
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>

                    <li>
                        <span>Update footer contain</span>
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
                                <i class="fa fa-gift"></i>Update footer contain
                            </div>
                            <!--<div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    
                                    <a href="javascript:;" class="reload">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                            </div>-->
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form  class="form-horizontal" method="post" action="" enctype="multipart/form-data">


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer button text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter footer button value"  value="<?php echo $row['footer_button_text']; ?>" name="footer_button_text" required>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer help center</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter help center contain"  value="<?php echo $row['footer_help_center']; ?>" name="footer_help_center" required>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Site email</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control" placeholder="Enter site email"  value="<?php echo $row['site_email']; ?>" name="site_email" required>

                                        </div>
                                    </div>

<div class="form-group">
                                        <label class="col-md-3 control-label">Site phone</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter site phone"  value="<?php echo $row['site_phone']; ?>" name="site_phone" required>

                                        </div>
                                    </div>

<div class="form-group">
                                        <label class="col-md-3 control-label">Coustomer support text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter site phone"  value="<?php echo $row['footer_coustomer_support_text']; ?>" name="footer_coustomer_support_text" required>

                                        </div>
                                    </div>






                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <!--														<button type="button" class="btn default" onClick="location.href='list_category.php'">Cancel</button>-->
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
