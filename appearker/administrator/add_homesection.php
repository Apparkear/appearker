<?php
include_once "./includes/session.php";
include_once "./includes/config.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select * from home_section  where id<>''";

    $record = mysqli_query($link, $sql);
}

if (isset($_REQUEST['submit'])) {




    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $fields = array(
        'name' => mysqli_real_escape_string($link, $name),
        'description' => mysqli_real_escape_string($link, $description),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        $editQuery = "UPDATE `home_section` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'";

        mysqli_query($link, $editQuery);

        if ($_FILES['image']['tmp_name'] != '') {
            $target_path = "../upload/homesection/";
            $userfile_name = $_FILES['image']['name'];
            $userfile_tmp = $_FILES['image']['tmp_name'];
            $img_name = $userfile_name;
            $img = $target_path . $img_name;
            move_uploaded_file($userfile_tmp, $img);

            $image = mysqli_query($link, "UPDATE `home_section` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
        }
        header('Location:list_homesection.php');
        exit();
    } else {

        $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {

            $addQuery = "INSERT INTO `home_section` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')";

            //exit;
            mysqli_query($link, $addQuery);
            $last_id = mysqli_insert_id($link);
            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/homesection/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysqli_query($link, "UPDATE `home_section` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
            }
            header('Location:list_homesection.php');
            exit();
        } else {
            $_SESSION['MSG'] = 1;
            header('Location:add_homesection.php');
            exit();
        }
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `home_section` WHERE `id`='" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'"));
}

/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {

    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        mysqli_query($link, "DELETE FROM`home_section` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';


    header("Location:list_homesection.php");
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
                Home Section <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Home Section</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="add_homesection.php">Home Section</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Home Section</span>
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
                                <i class="fa fa-gift"></i>Add Home Section
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_homesection.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name']; ?>" name="name" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-4">
                                            <input type="text" name="description" class="form-control" value="<?php echo $categoryRowset['description']; ?>" placeholder="Enter Description" required>
                                        </div>
                                    </div>

                     
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image Upload</label>
                                        <div class="col-md-2">
                                            <input type="file" name="image" class=" btn blue"  ><?php if ($categoryRowset['image'] != '') {?><br><a href="../upload/homesection/<?php echo $categoryRowset['image']; ?>" target="_blank">View</a><?php }?>

                                        </div>
                                    </div>



                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href = 'list_homesection.php'">Cancel</button>
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
