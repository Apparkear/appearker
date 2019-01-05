<?php
ob_start();
session_start();
include 'includes/config.php';

//include_once("controller/productController.php");



if (isset($_REQUEST['submit'])) {



    $what_is_this_text = isset($_POST['what_is_this_text']) ? $_POST['what_is_this_text'] : '';
    $learn_more_text = isset($_POST['learn_more_text']) ? $_POST['learn_more_text'] : '';
    $bill_text = isset($_POST['bill_text']) ? $_POST['bill_text'] : '';
    $price_text = isset($_POST['price_text']) ? $_POST['price_text'] : '';
    $booking_fee_text = isset($_POST['booking_fee_text']) ? $_POST['booking_fee_text'] : '';
    $total_text = isset($_POST['total_text']) ? $_POST['total_text'] : '';




    $fields = array(
        'what_is_this_text' => mysqli_real_escape_string($link, $what_is_this_text),
        'learn_more_text' => mysqli_real_escape_string($link, $learn_more_text),
        'bill_text' => mysqli_real_escape_string($link, $bill_text),
        'price_text' => mysqli_real_escape_string($link, $price_text),
        'booking_fee_text' => mysqli_real_escape_string($link, $booking_fee_text),
        'total_text' => mysqli_real_escape_string($link, $total_text)
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }


    $editQuery = "UPDATE `estejmam_sitesettings` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '1'";

    mysqli_query($link, $sql);

    if (mysqli_query($link, $editQuery)) {

        header('Location:booking_text.php');
        exit();
    }
}

$categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_sitesettings` WHERE `id`='1'"));
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
            <?php //include('includes/style_customize.php');   ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Booking Page Text <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Booking Page Text</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="booking_text.php">Booking Page Text</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Booking Page Text</span>
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
                                <i class="fa fa-gift"></i>Header Text
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



                                <div class="form-body">



                                    <div class="form-group">
                                        <label class="control-label col-md-3">What is this Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="what_is_this_text" cols="100" rows="20"><?php echo $categoryRowset['what_is_this_text'] ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Learn More Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="learn_more_text" cols="100" rows="20"><?php echo $categoryRowset['learn_more_text'] ?></textarea>

                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="control-label col-md-3">Bill Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="bill_text" cols="100" rows="20"><?php echo $categoryRowset['bill_text'] ?></textarea>

                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="control-label col-md-3">Price Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="price_text" cols="100" rows="20"><?php echo $categoryRowset['price_text'] ?></textarea>

                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="control-label col-md-3">Booking Fee Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="booking_fee_text" cols="100" rows="20"><?php echo $categoryRowset['booking_fee_text'] ?></textarea>

                                        </div>
                                    </div>

                                     <div class="form-group">
                                        <label class="control-label col-md-3">Total Text</label>
                                        <div class="col-md-9">

                                            <textarea class="ckeditor form-control" id="editor1" name="total_text" cols="100" rows="20"><?php echo $categoryRowset['total_text'] ?></textarea>

                                        </div>
                                    </div>





                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" class="btn blue" value="Submit" />
<!--                                            <input type="reset" name="reset" class="btn red" value="Reset" />-->
                                            <button type="button" class="btn default">Cancel</button>

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
    <?php //include('includes/quick_sidebar.php');     ?>
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
    function checkbed(id)
    {

        if (id == 1)
        {

            $("#showhide").show();
        }
        else
        {
            $("#showhide").hide();
        }


    }
</script>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
