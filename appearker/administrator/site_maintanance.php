<?php
include_once("controller/MaintananceController.php");
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
    <?php
    if(isset($_REQUEST['submit'])) {
    $alt_text = $_POST['alt_text'];
    $team_member_title = $_POST['team_member_title']; 
    $team_member_description = $_POST['team_member_description'];
    $footer_button_text = $_POST['footer_button_text'];
    $footer_help_center = $_POST['footer_help_center'];
    $site_email = $_POST['site_email'];
    $site_phone = $_POST['site_phone'];
    $footer_coustomer_support_text = $_POST['footer_coustomer_support_text'];
    $check_home_text = $_POST['check_home_text'];
    $testimonial_manage_text = $_POST['testimonial_manage_text'];
    $our_value_manage_text = $_POST['our_value_manage_text'];
    $featured_city_title = $_POST['featured_city_title'];
    $featured_city_description = $_POST['featured_city_description'];
    $care_about_title = $_POST['care_about_title'];
    $care_about_desc = $_POST['care_about_desc'];
    $care_about_button_text = $_POST['care_about_button_text'];
    $footer_help_button_text = $_POST['footer_help_button_text']; 
    $header_publish_property_text = $_POST['header_publish_property_text'];
    $header_how_work_text = $_POST['header_how_work_text'];
    $what_is_this_text = $_POST['what_is_this_text'];
    $learn_more_text = $_POST['learn_more_text'];
    $bill_text = $_POST['bill_text'];
    $price_text = $_POST['price_text'];
    $booking_fee_text = $_POST['booking_fee_text'];
    $cleaning_fee = $_POST['cleaning_fee'];
    $service_fee = $_POST['service_fee'];
    
    
    $fields = array(
        'alt_text' => mysqli_real_escape_string($link, $alt_text),
        'team_member_title' => mysqli_real_escape_string($link, $team_member_title),
        'team_member_description' => mysqli_real_escape_string($link, $footer_button_text),
        'footer_button_text' => mysqli_real_escape_string($link, $footer_button_text),
        'footer_help_center' => mysqli_real_escape_string($link, $footer_help_center),
        'site_email' => mysqli_real_escape_string($link, $site_email),
        'site_phone' => mysqli_real_escape_string($link, $site_phone),
        'footer_coustomer_support_text' => mysqli_real_escape_string($link, $footer_coustomer_support_text),
        'check_home_text' => mysqli_real_escape_string($link, $check_home_text),
        'testimonial_manage_text' => mysqli_real_escape_string($link, $testimonial_manage_text),
        'our_value_manage_text' => mysqli_real_escape_string($link, $our_value_manage_text),
        'featured_city_title' => mysqli_real_escape_string($link, $featured_city_title),
        'featured_city_description' => mysqli_real_escape_string($link, $featured_city_description),
        'care_about_title' => mysqli_real_escape_string($link, $care_about_title),
        'care_about_desc' => mysqli_real_escape_string($link, $care_about_desc),
        'care_about_button_text' => mysqli_real_escape_string($link, $care_about_button_text),
        'footer_help_button_text' => mysqli_real_escape_string($link, $footer_help_button_text),
        'header_publish_property_text' => mysqli_real_escape_string($link, $header_publish_property_text),
        'header_how_work_text' => mysqli_real_escape_string($link, $header_how_work_text),
        'what_is_this_text' => mysqli_real_escape_string($link, $what_is_this_text),
        'learn_more_text' => mysqli_real_escape_string($link, $learn_more_text),
        'bill_text' => mysqli_real_escape_string($link, $bill_text),
        'price_text' => mysqli_real_escape_string($link, $price_text),
        'booking_fee_text' => mysqli_real_escape_string($link, $booking_fee_text),
        'cleaning_fee' => mysqli_real_escape_string($link, $cleaning_fee),
        'service_fee' => mysqli_real_escape_string($link, $service_fee)
        
    );
//print_r($fields);exit;
    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }
    
    $editQuery = "UPDATE `estejmam_sitesettings` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '1'";

    mysqli_query($link, $editQuery);
   
    header("Location: site_maintanance.php");

}

$get_site_settings = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_sitesettings` WHERE `id`= 1"));

?>
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <?php //include('includes/style_customize.php');?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Maintanance Status
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="site_maintanance.php">Maintenance Status</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Maintenance Status</span>
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
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Maintenance Status
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
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />


                                <div class="form-body">
                                    <!-- <div class="form-group">
                                        <label class="col-md-3 control-label">Maintenance Status</label>
                                        <div class="col-md-4"> <input type="checkbox"  <?php
                                            if ($rowStatus == 'Y') {
                                                echo 'checked';
                                            } else {
                                                echo 'unchecked';
                                            }
                                            ?>  id="focusedInput"  name="checkbox" id="checkbox">
                                            <span style="valign:middle;">Maintenance Status</span>

                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tile</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="alt_text" value="<?php echo $get_site_settings->alt_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Team member title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="team_member_title" value="<?php echo $get_site_settings->team_member_title; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Team member description</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="team_member_description"><?php echo $get_site_settings->team_member_description; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer button text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="footer_button_text" value="<?php echo $get_site_settings->footer_button_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer help center</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="footer_help_center" value="<?php echo $get_site_settings->footer_help_center; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Site Email</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="site_email" value="<?php echo $get_site_settings->site_email; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Site Phone</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="site_phone" value="<?php echo $get_site_settings->site_phone; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer coustomer support text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="footer_coustomer_support_text" value="<?php echo $get_site_settings->footer_coustomer_support_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Home text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="check_home_text" value="<?php echo $get_site_settings->check_home_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Testimonial manage text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Title" name="testimonial_manage_text" value="<?php echo $get_site_settings->testimonial_manage_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Our value manage text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="our_value_manage_text" value="<?php echo $get_site_settings->our_value_manage_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Featured city title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="featured_city_title" value="<?php echo $get_site_settings->featured_city_title; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Featured city description</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="featured_city_description"><?php echo $get_site_settings->featured_city_description; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Care about title</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="care_about_title" value="<?php echo $get_site_settings->care_about_title; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Care about description</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="care_about_desc"><?php echo $get_site_settings->care_about_desc; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Care about button text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="care_about_button_text" value="<?php echo $get_site_settings->care_about_button_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Footer help button text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="footer_help_button_text" value="<?php echo $get_site_settings->footer_help_button_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Header publish property text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="header_publish_property_text" value="<?php echo $get_site_settings->header_publish_property_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Header how work text</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="header_how_work_text" value="<?php echo $get_site_settings->header_how_work_text; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">what_is_this_text</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="what_is_this_text"><?php echo $get_site_settings->what_is_this_text; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Learn more text</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="learn_more_text"><?php echo $get_site_settings->learn_more_text; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bill text</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="bill_text"><?php echo $get_site_settings->bill_text; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Price text</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="price_text"><?php echo $get_site_settings->price_text; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Booking fee texte</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" id="" cols="10" rows="5" name="booking_fee_text"><?php echo $get_site_settings->booking_fee_text; ?></textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Total text</label>
                                        <div class="col-md-4">
                                            <textarea class=" form-control" id="" cols="10" rows="5" name="total_text"><?php echo $get_site_settings->total_text; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Cleaning fee</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="cleaning_fee" value="<?php echo $get_site_settings->cleaning_fee; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Service fee</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="service_fee" value="<?php echo $get_site_settings->service_fee; ?>">
                                            
                                        </div>
                                    </div>


                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <!--                                            <button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                            <button type="button" class="btn default" onclick="location.href='dashboard.php'">Cancel</button>
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

    <script>


        window.preview_this_image = function (input) {

            if (input.files && input.files[0]) {
                $(input.files).each(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this);
                    reader.onload = function (e) {
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
                    }
                });
            }
        }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');  ?>
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
