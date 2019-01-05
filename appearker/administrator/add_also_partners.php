<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


if (isset($_REQUEST['submit'])) {


    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
   



    $fields = array(
        'name' => mysql_real_escape_string($fname),
        'link' => mysql_real_escape_string($lname),
        
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        $fileTypes = array('jpg', 'jpeg', 'gif', 'png', ''); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {
            $editQuery = "UPDATE `estejmam_also_partners` SET " . implode(', ', $fieldsList)
                    . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";
            //exit;

            mysql_query($editQuery);

            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/userimages/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysql_query("UPDATE `estejmam_also_partners` SET `logo`='" . $img_name . "' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
            }

            header('Location:list_also_partners.php');
            exit();
        } else {
            $_SESSION['MSG'] = 1;
            header('Location:add_also_partners.php?id=' . $_REQUEST['id'] . '&action=edit');
            exit();
        }
    } else {

        $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {

            $addQuery = "INSERT INTO `estejmam_also_partners` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";

            //exit;
            mysql_query($addQuery);
            $last_id = mysql_insert_id();
            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/userimages/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysql_query("UPDATE `estejmam_also_partners` SET `logo`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
            }

            header('Location:list_also_partners.php');
            exit();
        } else {
            $_SESSION['MSG'] = '1';
            header('Location:add_also_partners');
            exit();
        }
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_also_partners` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
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
            <?php //include('includes/style_customize.php');       ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Agent
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Agent</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent</span>
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
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent
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
                                if ($_SESSION['MSG'] == 1) {
                                    echo "<span style='color:red;margin-left: 278px;'>File Format Not Supported.</span>";
                                    $_SESSION['MSG'] = '';
                                }
                                ?>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control allbox" placeholder="Enter First Name"  value="<?php echo $categoryRowset['name']; ?>" name="fname" required>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">link</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control allbox" placeholder="Enter Last name" value="<?php echo $categoryRowset['link']; ?>" name="lname" required>

                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image Upload</label>
                                        <div class="col-md-2">
                                            <input type="file" name="image" class=" btn blue"  >
                                            <?php
                                            if ($categoryRowset['logo'] != '') {
                                                $u_iamge = "../upload/userimages/" . $categoryRowset['logo'];
                                            } else {
                                                $u_iamge = "../upload/no.png";
                                            }
                                            ?>
                                            <br><img src ="<?php echo $u_iamge; ?>" alt="" style="width:100px;">
                                            <?php if ($categoryRowset['logo'] != '') { ?><br><a href="../upload/userimages/<?php echo $categoryRowset['logo']; ?>" target="_blank"></a><?php } ?>

                                        </div>
                                    </div>



                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" value="Save" class="btn blue">
                                            <button type="button" class="btn default" onclick="location.href = 'search_user.php'">Cancel</button>
                                            <!--                                            <button type="button" class="btn default">Cancel</button>-->
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
    <?php //include('includes/quick_sidebar.php');          ?>
    <!-- END QUICK SIDEBAR -->
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
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


<script type="text/javascript" >



                                                function changeState(val)
                                                {

                                                    $.ajax({
                                                        type: "post",
                                                        url: "ajax_state.php",
                                                        data: {stId: val, userid:<?php echo $_REQUEST['id'] ?>},
                                                        success: function (msg) {
                                                            $('#StateId').html(msg);
                                                        }
                                                    });
                                                }



                                                function selectCity(val)
                                                {

                                                    $.ajax({
                                                        type: "post",
                                                        url: "ajax_city.php",
                                                        data: {stId: val, userid:<?php echo $_REQUEST['id'] ?>},
                                                        success: function (msg) {
                                                            $('#CityId').html(msg);
                                                        }
                                                    });

                                                }
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



<?php
if ($_REQUEST['action'] == 'edit') {
    ?>
    <script>
        changeState(<?php echo $categoryRowset['country'] ?>, <?php echo $_REQUEST['id'] ?>);
        selectCity(<?php echo $categoryRowset['state'] ?>, <?php echo $_REQUEST['id'] ?>);
    </script>
    <?php
}
?>



<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");


        $("#phone").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });


    });
</script>












<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
