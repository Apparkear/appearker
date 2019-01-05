<?php
ob_start();
session_start();
include 'includes/config.php';

//include_once("controller/productController.php");
function create_slug($string, $ext = '') {
    $replace = '-';
    $string = strtolower($string);

//replace / and . with white space     
    $string = preg_replace("/[\/\.]/", " ", $string);
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

//remove multiple dashes or whitespaces     
    $string = preg_replace("/[\s-]+/", " ", $string);

//convert whitespaces and underscore to $replace     
    $string = preg_replace("/[\s_]/", $replace, $string);

//limit the slug size     
    $string = substr($string, 0, 200);

//slug is generated     
    return ($ext) ? $string . $ext : $string;
}

if (isset($_REQUEST['submit'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';

    $slug_name = create_slug($name);


    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $room_description = isset($_POST['room_description']) ? $_POST['room_description'] : '';
    $details = isset($_POST['details']) ? $_POST['details'] : '';
    $transpotation = isset($_POST['transpotation']) ? $_POST['transpotation'] : '';
    $neighborhood_information = isset($_POST['neighborhood_information']) ? $_POST['neighborhood_information'] : '';

    $publishing_date = isset($_POST['publishing_date']) ? $_POST['publishing_date'] : '';

    $landlord_policies = isset($_POST['landlord_policies']) ? $_POST['landlord_policies'] : '';
    $what_we_liked_most = isset($_POST['what_we_liked_most']) ? $_POST['what_we_liked_most'] : '';
    $keep_in_mind = isset($_POST['keep_in_mind']) ? $_POST['keep_in_mind'] : '';

    if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
        $id = $_REQUEST['id'];
    }
    if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {
        $id = $_SESSION['prop_id'];
    }

    $ft = mysql_fetch_array(mysql_query("select * from `estejmam_main_property` where `id`='" . $id . "'"));
    $val = $ft['step_comp'];

    if ($_POST['name'] != '' && $_POST['description'] != '') {
        $val1 = $val + 1;
        mysql_query("update `estejmam_main_property` set `step_comp`='" . $val1 . "' where `id`='" . $id . "'");
    } else {
        mysql_query("update `estejmam_main_property` set `step_comp`='" . $val . "' where `id`='" . $id . "'");
    }

    $date = date("Y-m-d");

    $fields = array(
        'name' => mysql_real_escape_string($name),
        'slug' => mysql_real_escape_string($slug_name),
        'description' => mysql_real_escape_string($description),
        'room_description' => mysql_real_escape_string($room_description),
        'details' => mysql_real_escape_string($details),
        'transpotation' => mysql_real_escape_string($transpotation),
        'neighborhood_information' => mysql_real_escape_string($neighborhood_information),
        'landlord_policies' => mysql_real_escape_string($landlord_policies),
        'what_we_liked_most' => mysql_real_escape_string($what_we_liked_most),
        'keep_in_mind' => mysql_real_escape_string($keep_in_mind),
        'edited_date' => mysql_real_escape_string($date),
        'publishing_date' => mysql_real_escape_string($publishing_date)
    );

    // echo '<pre>'; print_r($fields); echo '</pre>';
    // exit;

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_SESSION['prop_id']) . "'";

        if (mysql_query($editQuery)) {

            header('Location:your_listing-3.php');
            exit();
        }
    }


    if ($_REQUEST['action'] == 'edit') {

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        if (mysql_query($editQuery)) {

            header('Location:your_listing-3.php?id=' . $_REQUEST['id'] . '&action=edit');
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                Site Settings <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Site Settings</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Site Settings</a>
                        <!-- <i class="fa fa-angle-right"></i> -->
                    </li>
                    <!-- <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Property</span>
                    </li> -->
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Site Settings
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
                               <!--  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                <input type="hidden" name="user_id" value="<?php echo $categoryRowset['user_id'] ?>">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" /> -->


                                <div class="form-body">



                                    <div class="form-group">
                                        <label class="control-label col-md-3"> alternative Text </label>
                                        <div class="col-md-4">
                                            <input type="text" name="alt_text" value="<?php echo $categoryRowset['alt_text'] ?>" class="form-control" placeholder="alternative Text" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Site Email</label>
                                        <div class="col-md-4">
                                            <input type="text" name="site_email" value="<?php echo $categoryRowset['site_email'] ?>" class="form-control" placeholder="Site Email" id="publishingDate" >

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Site Phone No.</label>
                                        <div class="col-md-9">
                                            <input type="text" name="site_phone" value="<?php echo $categoryRowset['site_phone'] ?>" class="form-control" placeholder="Site Phone No." id="publishingDate" >
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="description" placeholder="Description" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['description'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Details</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="details" placeholder="Details" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['details'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Transpotation</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="transpotation" placeholder="Transpotation" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['transpotation'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Neighborhood Information</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="neighborhood_information" placeholder="Neighborhood Information" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['neighborhood_information'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Landlord policies</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="landlord_policies" placeholder="Landlord policies" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['landlord_policies'] ?></textarea>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-md-3">What we liked most</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="what_we_liked_most" placeholder="What we liked most" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['what_we_liked_most'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Keep in mind</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="keep_in_mind" placeholder="Keep in mind" rows="5" onKeyDown="limitText(this.form.description, this.form.namdes, 250);"onKeyUp="limitText1(this.form.description, this.form.namdes, 250);" style="width: 630px;height: 200px"><?php echo $categoryRowset['keep_in_mind'] ?></textarea>
                                        </div>
                                    </div>




                                    <!--                                    <div class="form-group">
                                                                            <div class="col-md-8">
                                    <?php
                                    if ($_REQUEST['action'] == "edit" && $_REQUEST['id'] != '') {
                                        ?>
                                            <?php
                                    } else {
                                        ?>
                                    <?php
                                    }
                                    ?>
                                                                            </div>
                                                                        </div>-->


                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <?php
                                            if ($_REQUEST['action'] == "edit" && $_REQUEST['id'] != '') {
                                                ?>
                                                <a href="add_property.php?id=<?php echo $_REQUEST['id'] ?>&action=edit" class="btn btn-warning">Back</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="add_property.php" class="btn btn-warning">Back</a>
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

<!-- <script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->

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

            var dateToday = new Date();
            $("#publishingDate").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: dateToday 
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


<script language="javascript" type="text/javascript">
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }

    function limitText1(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }

    function limitText2(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            limitCount.value = limitNum - limitField.value.length;
        }
    }
</script>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
