<?php
include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");

if ($_REQUEST['action'] == 'details') {
    // $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_product` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));
    // $store_id = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_store` WHERE `id`='".mysql_real_escape_string($categoryRowset['store_id'])."'"));
    // $category_id = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_category` WHERE `id`='".mysql_real_escape_string($categoryRowset['cat_id'])."'"));
    // $subcategory_id = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_subcategory` WHERE `id`='".mysql_real_escape_string($categoryRowset['subcat'])."'"));

    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
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
                Property Details
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Property</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Property Details</span>
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
                                <i class="fa fa-gift"></i> Property Details
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

                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-6">Room Details</a></li>
                                <li><a href="#tabs-1">Property</a></li>
                                <li><a href="#tabs-2">Property Address</a></li>
                                <li><a href="#tabs-3">Ameneties</a></li>
                                <li><a href="#tabs-4">Safety Points</a></li>
                                <li><a href="#tabs-5">Check In Details</a></li>
                            </ul>
                            <div id="tabs-1">
                                <label class="col-md-3 control-label">Property Name:</label>
                                <p><?php echo $categoryRowset['name']; ?></p>

                                <label class="col-md-3 control-label">Property Description:</label>
                                <p><?php echo $categoryRowset['description']; ?></p>

                                <label class="col-md-3 control-label">Accomodation:</label>
                                <p><?php echo $categoryRowset['accommodates']; ?></p>

                                <label class="col-md-3 control-label">Room Type:</label>
                                <p><?php echo $categoryRowset['room_type']; ?></p>

                                <label class="col-md-3 control-label">Property Type:</label>
                                <p><?php
                                    $property_type_id = $categoryRowset['prop_type'];

                                    $show_property_type_name = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_property_type` WHERE `id` = '" . $property_type_id . "'"));

                                    echo $show_property_type_name->name;
                                    ?>
                                </p>

                                <label class="col-md-3 control-label">Number of Bathrooms:</label>
                                <p><?php echo $categoryRowset['bathrooms']; ?></p>

                                <label class="col-md-3 control-label">Number of Bedrooms:</label>
                                <p><?php echo $categoryRowset['bedrooms']; ?></p>

                                <label class="col-md-3 control-label">Number of Beds:</label>
                                <p><?php echo $categoryRowset['beds']; ?></p>

                                <label class="col-md-3 control-label">Property Uploader Name:</label>
                                <p><?php
                                    $user_id_of_uploader = $categoryRowset['user_id'];

                                    $sql_uploader_det = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` where `id` = '" . $user_id_of_uploader . "'"));

                                    echo $sql_uploader_det->fname . ' ' . $sql_uploader_det->lname;
                                    ?></p>

                                <label class="col-md-3 control-label">Property Image:</label>
                                <p>
                                    <?php
                                    $sql_image_property = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_image` WHERE `prop_id` = '" . $categoryRowset['id'] . "' LIMIT 0,1"));
                                    ?>
                                    <img src="../upload/property/<?php echo $sql_image_property->image; ?>" height="50px" width="50px" />
                                </p>
                            </div>
                            <div id="tabs-2">
                                <label class="col-md-3 control-label">Country:</label>
                                <p><?php
                                    $country_id = $categoryRowset['country'];

                                    $sql_country_name = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_countries` WHERE id = '" . $country_id . "'"));

                                    echo $sql_country_name->name;
                                    ?>
                                </p>

                                <label class="col-md-3 control-label">State Name:</label>
                                <p><?php echo $categoryRowset['state']; ?></p>

                                <label class="col-md-3 control-label">City:</label>
                                <p><?php echo $categoryRowset['city']; ?></p>

                                <label class="col-md-3 control-label">Street Address:</label>
                                <p><?php echo $categoryRowset['street_addr']; ?></p>

                                <label class="col-md-3 control-label">Zipcode:</label>
                                <p><?php
                                    echo $categoryRowset['zipcode'];
                                    ?>
                                </p>

                                <label class="col-md-3 control-label">Amenities:</label>
                                <p><?php
                                    $arr_amenities = explode(',', $categoryRowset['amenities']);

                                    foreach ($arr_amenities as $show_all_amenities) {
                                        echo $show_all_amenities;
                                    }
                                    ?></p>

                                <label class="col-md-3 control-label">Home Safety:</label>
                                <p><?php
                                    if ($categoryRowset['home_safety']) {
                                        $arr_home_safety = explode(',', $categoryRowset['home_safety']);

                                        foreach ($arr_home_safety as $show_home_safety) {
                                            echo $show_home_safety;
                                        }
                                    } else {
                                        echo 'NA';
                                    }
                                    ?>
                                </p>

                                <label class="col-md-3 control-label">Fire Extinguisher:</label>
                                <p><?php
                                    if ($categoryRowset['fire_extingursher']) {
                                        echo $categoryRowset['fire_extingursher'];
                                    } else {
                                        echo 'NA';
                                    }
                                    ?></p>

                                <label class="col-md-3 control-label">Fire Alarm:</label>
                                <p><?php echo $categoryRowset['fire_alarm']; ?></p>

                            </div>
                            <div id="tabs-3">
                                <label class="col-md-3 control-label">Gas Valve:</label>
                                <p><?php echo $categoryRowset['gas_valve']; ?></p>

                                <label class="col-md-3 control-label">Emergency Note:</label>
                                <p><?php echo $categoryRowset['emargency_note']; ?></p>

                                <label class="col-md-3 control-label">Medical Phone:</label>
                                <p><?php echo $categoryRowset['medical_phone']; ?></p>

                                <label class="col-md-3 control-label">Fire Phone:</label>
                                <p><?php echo $categoryRowset['fire_phone']; ?></p>

                                <label class="col-md-3 control-label">Police Phone:</label>
                                <p><?php echo $categoryRowset['police_phone']; ?></p>

                                <label class="col-md-3 control-label">Created Date:</label>
                                <p><?php
                                    $date_of_creation = strtotime($categoryRowset['created_date']);
                                    echo date('Y-m-d', $date_of_creation);
                                    ?></p>

                                <label class="col-md-3 control-label">Edited Date:</label>
                                <p><?php
                                    $date_of_editation = strtotime($categoryRowset['edited_date']);
                                    echo date('Y-m-d', $date_of_editation);
                                    ?></p>

                                <label class="col-md-3 control-label">Phone:</label>
                                <p><?php
                                    if ($categoryRowset['phone']) {
                                        echo $categoryRowset['phone'];
                                    } else {
                                        echo 'NA';
                                    }
                                    ?></p>
                                <label class="col-md-3 control-label">Price:</label>
                                <p><?php
                                    $estejman_currncy_id = $categoryRowset['currency'];

                                    $sql_get_curr_code = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_currency` WHERE `id` = '" . $estejman_currncy_id . "'"));


                                    echo $sql_get_curr_code->code . ' ' . number_format($categoryRowset['price'], 2, '.', '');
                                    ?></p>

                            </div>
                            <div id="tabs-4">
                                <label class="col-md-3 control-label">Booking Start Date:</label>
                                <p><?php echo $categoryRowset['booking_start_date']; ?></p>

                                <label class="col-md-3 control-label">Booking End Date:</label>
                                <p><?php echo $categoryRowset['booking_end_date']; ?></p>

                                <label class="col-md-3 control-label">Property Status:</label>
                                <p><?php
                                    if ($categoryRowset['status'] == '1') {
                                        echo 'Active';
                                    } else {
                                        echo 'Inactive';
                                    }
                                    ?></p>

                                <label class="col-md-3 control-label">Availibility:</label>
                                <p><?php
                                    if ($categoryRowset['availability'] == '0') {
                                        echo 'Always';
                                    } elseif ($categoryRowset['availability'] == '1') {
                                        echo 'Sometimes';
                                    } elseif ($categoryRowset['availability'] == '3') {
                                        echo 'One Time';
                                    }
                                    ?></p>


                                <label class="col-md-3 control-label">Bed Type:</label>
                                <p><?php echo $categoryRowset['bed_type']; ?></p>


                                <label class="col-md-3 control-label">The Space:</label>
                                <p><?php echo $categoryRowset['the_space']; ?></p>

                                <label class="col-md-3 control-label">Guest Access:</label>
                                <p><?php echo $categoryRowset['guest_access']; ?></p>

                                <label class="col-md-3 control-label">Guest Interaction:</label>
                                <p><?php echo $categoryRowset['interection_guest']; ?></p>

                                <label class="col-md-3 control-label">Other Things:</label>
                                <p><?php echo $categoryRowset['other_things']; ?></p>

                                <label class="col-md-3 control-label">House Rule:</label>
                                <p><?php echo $categoryRowset['house_rule']; ?></p>
                            </div>
                            <div id="tabs-5">
                                <label class="col-md-3 control-label">Overview:</label>
                                <p><?php echo $categoryRowset['overview']; ?></p>

                                <label class="col-md-3 control-label">Getting Around:</label>
                                <p><?php echo $categoryRowset['getting_arraound']; ?></p>

                                <label class="col-md-3 control-label">Building Number:</label>
                                <p><?php echo $categoryRowset['apt_suit_blding']; ?></p>

                                <label class="col-md-3 control-label">Street:</label>
                                <p><?php echo $categoryRowset['street']; ?></p>

                                <label class="col-md-3 control-label">Review Request:</label>
                                <p><?php
                                    if ($categoryRowset['review_each_request'] == '1') {
                                        echo 'Yes';
                                    } else {
                                        echo 'No';
                                    }
                                    ?></p>

                                <label class="col-md-3 control-label">Instant Guest Booking:</label>
                                <p><?php
                                    if ($categoryRowset['guest_book_instant'] == '2') {
                                        echo 'Yes';
                                    } elseif ($categoryRowset['guest_book_instant'] == '0') {
                                        echo 'No';
                                    }
                                    ?></p>

                                <label class="col-md-3 control-label">Guest Notice Period:</label>
                                <p><?php echo $categoryRowset['guest_notice_period'] . ' Days'; ?></p>

                                <label class="col-md-3 control-label">Minimum Stay Period:</label>
                                <p><?php echo $categoryRowset['ninimum_stay']; ?></p>

                                <label class="col-md-3 control-label">Maximum Stay Period:</label>
                                <p><?php echo $categoryRowset['maximum_stay']; ?></p>

                                <label class="col-md-3 control-label">Guuest Arrival Time:</label>
                                <p><?php echo $categoryRowset['guest_time']; ?></p>
                            </div>


                        </div>



                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <!--<button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                    <button type="reset" class="btn blue" onClick="window.location.href = 'list_product.php'">Back</button>
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
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css">
<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>

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

    $(document).ready(function () {

        $('.del_this').click(function (event) {
            var id = $(this).data('imgid');

            var divs = $(this);
            var formdata = {id: id, action: "deleteImg"};
            $.ajax({
                url: "del_ajax.php",
                type: "POST",
                dataType: "json",
                data: formdata,
                success: function (data) {
                    if (data.ack == 1)
                    {

                        $(divs).closest('.div_div').remove();
                    }



                }

            });
        });



        $(document).on("click", ".del_this", function () {
            $(this).parent().remove();

        });


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
