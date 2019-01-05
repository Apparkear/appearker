<?php
ob_start();
session_start();
include 'includes/config.php';

//phpinfo();
//exit;
//echo $dir = dirname(__FILE__);
?>



<?php
if ($_REQUEST['action'] == 'edit') {
    $res22 = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_image` WHERE `id`='" . $_REQUEST['id'] . "'"));
}


if (isset($_REQUEST['submit'])) {



//    $imagepath = "/var/www/html/team4/roomarate/upload/property/" . $res22['image'];
//
//    $stamp = imagecreatefrompng('/var/www/html/team4/roomarate/images/payment.png');
//    $imt = imagecreatefromjpeg($imagepath);
//
//    $marge_right = 10;
//    $marge_bottom = 10;
//
//    $sx = imagesx($stamp);
//    $sy = imagesy($stamp);
//
//    imagecopy($imt, $stamp, imagesx($imt) - $sx - $marge_right, imagesy($imt) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
//
//    header('Content-type: image/png');
//
//    imagejpeg($imt, $imagepath, 100);
//    imagedestroy($imt);




    $imagepath1 = "../upload/property/" . $res22['image'];
    $stamp = imagecreatefrompng('../images/watermarknew.png');
    $im = imagecreatefromjpeg($imagepath1);

    $marge_right = 0;
    $marge_top = 310;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_top, 0, 0, imagesx($stamp), imagesy($stamp));

    header('Content-type: image/png');
    imagejpeg($im, $imagepath1, 100);
    imagedestroy($im);



    header("location:add_watermark.php?id=" . $_REQUEST['id'] . "&action=edit");
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
            <?php //include('includes/style_customize.php');                ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Watermark</small>
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
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Watermark</span>
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
                                <i class="fa fa-gift"></i>Add Watermark
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

                                <h3>Watermark</h3>


                                <img src="<?php echo $imagepath1 = "../upload/property/" . $res22['image']; ?>" style="width: 100%;">


                                <br><br>


                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-4">
                                        <div class="input-group">

                                            <input type="submit" name="submit" value="Add Watermark" class="btn btn-warning">
                                        </div>
                                    </div>

                                </div>




                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <?php
                                            if ($_REQUEST['action'] == "edit" && $_REQUEST['id'] != '') {
                                                ?>
                                                <a href="your_listing-5.php?id=<?php echo $_REQUEST['id'] ?>&action=edit" class="btn btn-warning">Back</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="your_listing-5.php" class="btn btn-warning">Back</a>
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
    <?php //include('includes/quick_sidebar.php');                   ?>
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


<style>
    .input-group-btn {
        position: relative;
        font-size: 0;
        white-space: nowrap;
    }
    .step-right-area #price {
        padding: 9px 12px;
    }
    .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
        margin-right: -1px;
    }
    .input-group-addon, .input-group-btn
    group-btn {
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
    }
    .input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }
</style>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
