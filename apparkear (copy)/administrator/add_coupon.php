<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if (isset($_REQUEST['submit'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $max_use = isset($_POST['max_use']) ? $_POST['max_use'] : '';
    $valid_from = isset($_POST['valid_from']) ? $_POST['valid_from'] : '';
    $valid_to = isset($_POST['valid_to']) ? $_POST['valid_to'] : '';
    $coupon_type = isset($_POST['coupon_type']) ? $_POST['coupon_type'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $discount_type = isset($_POST['discount_type']) ? $_POST['discount_type'] : '';
    $date = date("Y-m-d");


    $fields = array(
        'name' => mysql_real_escape_string($name),
        'code' => mysql_real_escape_string($code),
        'max_use' => mysql_real_escape_string($max_use),
        'valid_from' => mysql_real_escape_string($valid_from),
        'valid_to' => mysql_real_escape_string($valid_to),
        'coupon_type' => mysql_real_escape_string($coupon_type),
        'amount' => mysql_real_escape_string($amount),
        'description' => mysql_real_escape_string($description),
        'discount_type' => mysql_real_escape_string($discount_type)
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {
        $editQuery = "UPDATE `estejmam_coupon` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        if (mysql_query($editQuery)) {


            $_SESSION['msg'] = "Category Updated Successfully";
        } else {
            $_SESSION['msg'] = "Error occuried while updating Category";
        }

        header('Location:list_coupon.php');
        exit();
    } else {

        $cj = mysql_fetch_array(mysql_query("select * from `estejmam_coupon` where 1"));
        $prev_c_code = $cj['code'];

        if ($prev_c_code != $code) {
            $addQuery = "INSERT INTO `estejmam_coupon` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";
            mysql_query($addQuery);
            $last_id = mysql_insert_id();
            header('Location:list_coupon.php');
            exit();
        } else {
            $_SESSION['MSG'] = 0;
            header('Location:list_coupon.php');
            exit();
        }
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_coupon` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
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
            <?php //include('includes/style_customize.php');     ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Coupon</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Coupon</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Coupon</span>
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
                                <i class="fa fa-gift"></i>Add Coupon
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
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <?php
                                if ($_SESSION['MSG'] != '') {
                                    echo "<span style='color:red;'>Coupon Code Allready Exists.</span>";
                                    $_SESSION['MSG'] = '';
                                }
                                ?>


                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Name" value="<?php echo $categoryRowset['name']; ?>" name="name" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Code</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Code" value="<?php echo $categoryRowset['code']; ?>" name="code" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Max Use</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Max Use" value="<?php echo $categoryRowset['max_use']; ?>" name="max_use" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Valid From</label>
                                        <div class="col-md-4">
                                            <input type="text" id="sdate" class="form-control" placeholder="Valid From" value="<?php echo $categoryRowset['valid_from']; ?>" name="valid_from" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Valid To</label>
                                        <div class="col-md-4">
                                            <input type="text" id="edate" class="form-control" placeholder="Valid To" value="<?php echo $categoryRowset['valid_to']; ?>" name="valid_to" required>

                                        </div>
                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-3 control-label">Coupon Type</label>
                                                                            <div class="col-md-4">
                                                                                <input type="text" class="form-control" placeholder="" value="<?php echo $categoryRowset['coupon_type']; ?>" name="coupon_type" required>
                                                                                <select name="coupon_type" class="form-control">
                                                                                    <option value="">Select</option>
                                                                                    <option value="gift card" <?php if ($categoryRowset['coupon_type'] == 'gift card') { ?> selected <?php } ?>>Gift Card</option>
                                                                                    <option value="buisness" <?php if ($categoryRowset['coupon_type'] == 'buisness') { ?> selected <?php } ?>>Business</option>
                                                                                    <option value="promotion" <?php if ($categoryRowset['coupon_type'] == 'promotion') { ?> selected <?php } ?>>Promotion</option>
                                                                                </select>
                                    
                                                                            </div>
                                                                        </div>-->


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Discount Type</label>
                                        <div class="col-md-4">
                                            <select name="discount_type" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="1" <?php if ($categoryRowset['discount_type'] == '1') { ?> selected <?php } ?>>Flat</option>
                                                <option value="2" <?php if ($categoryRowset['discount_type'] == '2') { ?> selected <?php } ?>>Percentage</option>
                                            </select>


                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Amount</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Amount" value="<?php echo $categoryRowset['amount']; ?>" name="amount" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-4">
<!--                                            <input type="text" class="form-control" placeholder="" value="<?php echo $categoryRowset['description']; ?>" name="description" required>-->
                                            <textarea name="description" class="form-control" placeholder="Description" required><?php echo $categoryRowset['description']; ?></textarea>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href='list_coupon.php'">Cancel</button>
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
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>

<script>
    $(function () {
        $("#sdate,#edate").datepicker({format: 'yyyy-mm-dd'});
    });</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
