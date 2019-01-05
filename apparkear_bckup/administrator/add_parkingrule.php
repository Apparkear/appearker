<?php
include_once "./includes/session.php";
include_once "./includes/config.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select * from parking_rules  where id<>''";

    $record = mysqli_query($link, $sql);
}

if (isset($_REQUEST['submit'])) {



    $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
    $rule = isset($_POST['rule']) ? $_POST['rule'] : '';

    $fields = array(
        'parking_id' =>mysqli_real_escape_string($link, $pid),
        'rule' => mysqli_real_escape_string($link, $rule),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        $editQuery = "UPDATE `parking_rules` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'";
 
        mysqli_query($link, $editQuery);

        // if ($_FILES['image']['tmp_name'] != '') {
        //     $target_path = "../upload/footerpages/";
        //     $userfile_name = $_FILES['image']['name'];
        //     $userfile_tmp = $_FILES['image']['tmp_name'];
        //     $img_name = $userfile_name;
        //     $img = $target_path . $img_name;
        //     move_uploaded_file($userfile_tmp, $img);

        //     $image = mysqli_query($link, "UPDATE `footer_pages` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
        // }
        header('Location:list_parkingrule.php');
        exit();
    } else {

            $addQuery = "INSERT INTO `parking_rules` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')";

            mysqli_query($link, $addQuery);
            $last_id = mysqli_insert_id($link);
            // if ($_FILES['image']['tmp_name'] != '') {
            //     $target_path = "../upload/footerpages/";
            //     $userfile_name = $_FILES['image']['name'];
            //     $userfile_tmp = $_FILES['image']['tmp_name'];
            //     $img_name = $userfile_name;
            //     $img = $target_path . $img_name;
            //     move_uploaded_file($userfile_tmp, $img);

            //     $image = mysqli_query($link, "UPDATE `footer_pages` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
            // }
            header('Location:list_parkingrule.php');
            exit();
      
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `parking_rules` WHERE `id`='" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'"));
}

/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {

    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        mysqli_query($link, "DELETE FROM`parking_rules` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';


    header("Location:list_parkingrule.php");
}
?>
<?php include 'includes/header.php';?>
<!-- END HEADER -->


<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include 'includes/left_panel.php';?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <?php //include('includes/style_customize.php');  ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Parking Rule<small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking Rule</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="add_pages.php">Parking Rule</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking Rule</span>
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
                                <i class="fa fa-gift"></i>Add Parking Rule
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_parkingrule.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                    <div class="form-group" style="padding-top: 2%;">
                                        <label class="col-md-3 control-label">Select Parking Name</label>
                                        <div class="col-md-4">
                                            <select id="selectError" name="pid">
                                                <option value="">Select One</option>
                                                <?php
                                                $SQL ="SELECT * FROM `parking`";
                                                $result = mysqli_query($link, $SQL);

                                                while($row1=mysqli_fetch_array($result))
                                                {
                                                ?>
                                                <option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['parking_id']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                <div class="form-body">
                                
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Parking Rule</label>
                                        <div class="col-md-9">
                                        <textarea class="ckeditor form-control" id="editor1" name="rule"><?php echo stripslashes($categoryRowset['rule']); ?></textarea>
                                    </div>
                                    </div>

                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href = 'list_parkingrule.php'">Cancel</button>
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
<?php include 'includes/footer.php';?>
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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
