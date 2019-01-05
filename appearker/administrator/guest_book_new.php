<?php
ob_start();
session_start();
include 'includes/config.php';

//include_once("controller/productController.php");


if (isset($_REQUEST['submit'])) {



    $how_far_guest_book = isset($_POST['how_far_guest_book']) ? $_POST['how_far_guest_book'] : '';
    $guest_notice_period = isset($_POST['guest_notice_period']) ? $_POST['guest_notice_period'] : '';
    $ninimum_stay = isset($_POST['ninimum_stay']) ? $_POST['ninimum_stay'] : '';
    $maximum_stay = isset($_POST['maximum_stay']) ? $_POST['maximum_stay'] : '';
    $guest_time = isset($_POST['guest_time']) ? $_POST['guest_time'] : '';



    $fields = array(
        'how_far_guest_book' => mysql_real_escape_string($how_far_guest_book),
        'guest_notice_period' => mysql_real_escape_string($guest_notice_period),
        'ninimum_stay' => mysql_real_escape_string($ninimum_stay),
        'maximum_stay' => mysql_real_escape_string($maximum_stay),
        'guest_time' => mysql_real_escape_string($guest_time),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_SESSION['prop_id']) . "'";

        mysql_query($sql);

        if (mysql_query($editQuery)) {

            header('Location:your_listing-9.php');
            exit();
        }
    }

    if ($_REQUEST['action'] == 'edit') {

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        mysql_query($sql);

        if (mysql_query($editQuery)) {

            header('Location:your_listing-9.php?id=' . $_REQUEST['id'] . '&action=edit');
            exit();
        }
    }
}

if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysql_real_escape_string($_SESSION['prop_id']) . "'"));
}

if ($_REQUEST['action'] == 'edit') {
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
            <?php //include('includes/style_customize.php');    ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Property</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Property</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Property</span>
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
                                <i class="fa fa-gift"></i>Add Property
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
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                <input type="hidden" name="user_id" value="<?php echo $categoryRowset['user_id'] ?>">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <h4>Set Availability</h4>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Months</label>
                                    <div class="col-md-4">
                                        <select name="how_far_guest_book" class="form-control">
                                            <option value="">Select</option>

                                            <option value="0" <?php if ($categoryRowset['how_far_guest_book'] == '0') { ?> selected <?php } ?>>Any time in the future</option>
                                            <option value="1" <?php if ($categoryRowset['how_far_guest_book'] == '1') { ?> selected <?php } ?>>3 Months</option>
                                            <option value="2" <?php if ($categoryRowset['how_far_guest_book'] == '2') { ?> selected <?php } ?>>6 Months</option>
                                            <option value="3" <?php if ($categoryRowset['how_far_guest_book'] == '3') { ?> selected <?php } ?>>12 Months</option>

                                        </select>
                                    </div>

                                </div>

                                <h4>How much advance notice do you need for bookings?</h4>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Advance notice</label>
                                    <div class="col-md-4">
                                        <select name="guest_notice_period" class="form-control" onchange="checkbed(this.value)">
                                            <option value="">Select</option>
                                            <option value="0" <?php if ($categoryRowset['guest_notice_period'] == '0') { ?> selected <?php } ?>>Same Day (customizable cutoff hour)</option>
                                            <option value="1" <?php if ($categoryRowset['guest_notice_period'] == '1') { ?> selected <?php } ?>>At least 1 Day's Notice</option>
                                            <option value="2" <?php if ($categoryRowset['guest_notice_period'] == '2') { ?> selected <?php } ?>>At least 2 Day's Notice</option>
                                            <option value="3" <?php if ($categoryRowset['guest_notice_period'] == '3') { ?> selected <?php } ?>>At least 3 Day's Notice</option>
                                        </select>
                                    </div>

                                </div>





                                <div id="showhide" style="<?php if ($categoryRowset['guest_notice_period'] == '0') { ?> display:block; <?php } else { ?> display:none; <?php } ?>">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Guests can same-day instant book until</label>
                                        <div class="col-md-4">
                                            <select name="guest_time" class="form-control">
                                                <option value="6am" <?php if ($categoryRowset['guest_time'] == '6am') { ?> selected <?php } ?>>6:00 A.M</option>
                                                <option value="7am" <?php if ($categoryRowset['guest_time'] == '7am') { ?> selected <?php } ?>>7:00 A.M</option>
                                                <option value="8am" <?php if ($categoryRowset['guest_time'] == '8am') { ?> selected <?php } ?>>8:00 A.M</option>
                                                <option value="9am" <?php if ($categoryRowset['guest_time'] == '9am') { ?> selected <?php } ?>>9:00 A.M</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>




                                <h4>What's the minimum and maximum time guests can stay?</h4>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Advance notice</label>
                                    <div class="col-md-4">
                                        <label>Minimum stay</label>
<!--                                            <span class="input-group-btn">
                                                <input type="text" name="price" class="form-control" value="<?php echo $categoryRowset['price'] ?>"><button class="btn" id="price" type="button" style="border: 1px solid #e1e1e1">night</button>
                                            </span>-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="ninimum_stay" value="<?php
                                            if (isset($categoryRowset['ninimum_stay']) && $categoryRowset['ninimum_stay'] != '') {
                                                echo $categoryRowset['ninimum_stay'];
                                            } else {
                                                echo '1';
                                            }
                                            ?> ">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Day</button>
                                            </span>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <label>Maximum stay</label>
<!--                                            <span class="input-group-btn">
                                                <input type="text" name="price" class="form-control" value="<?php echo $categoryRowset['price'] ?>"><button class="btn" id="price" type="button" style="border: 1px solid #e1e1e1">night</button>
                                            </span>-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="maximum_stay" value="<?php echo $categoryRowset['maximum_stay'] ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Day</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>






                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <?php
                                            if ($_REQUEST['action'] == "edit" && $_REQUEST['id'] != '') {
                                                ?>
                                                <a href="your_listing-8.php?id=<?php echo $_REQUEST['id'] ?>&action=edit" class="btn btn-warning">Back</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="your_listing-8.php" class="btn btn-warning">Back</a>
                                                <?php
                                            }
                                            ?>
                                            <input type="submit" name="submit" class="btn blue" value="Next" />
<!--                                            <input type="reset" name="reset" class="btn red" value="Reset" />-->

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
    <?php //include('includes/quick_sidebar.php');      ?>
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

<script type="text/javascript">
    function select_sub(id) {
        $.ajax({
            type: "post",
            url: "ajax_category.php?action=cat",
            data: {id: id},
            success: function (msg) {
                $('#subcat').html(msg);
            }
        });
    }
</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>


<script>
    function checksymbol(id)
    {
        $.ajax({
            type: "post",
            url: "../prop_currency_check.php",
            data: {id: id},
            success: function (msg) {
                $('#price').html(msg);
            }
        });
    }
</script>





<script>
    function checkbed(id)
    {

        if (id == 0)
        {

            $("#showhide").show('slow');
        }
        else
        {
            $("#showhide").hide('hide');
        }


    }
</script>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
