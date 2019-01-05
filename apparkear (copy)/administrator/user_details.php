<?php
include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");





if ($_REQUEST['action'] == 'details') {

    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
    if ($categoryRowset['is_loggedin'] == 1) {
        $a = "Online";
    } else {
        $a = "Offline";
    }
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
                Details
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Details</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Details</span>
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
                                <i class="fa fa-gift"></i>Details
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>

                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="javascript:;" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" method="post" action="add_social.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">First Name:</label>
                                        <div class="col-md-4">  <?php echo $categoryRowset['fname']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last Name:</label>
                                        <div class="col-md-4">  <?php echo $categoryRowset['lname']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email:</label>
                                        <div class="col-md-4"> <?php echo $categoryRowset['email']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Phone:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['phone']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Gender:</label>
                                        <div class="col-md-4"> <?php echo $categoryRowset['gender']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">DOB:</label>
                                        <div class="col-md-4"> <?php echo $categoryRowset['dob']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Register Date:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['add_date']; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Online Status:</label>
                                        <div class="col-md-4">   <?php echo $a; ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">User Image:</label>
                                        <div class="col-md-4">   <?php
                                            if ($categoryRowset['image'] != '') {
                                                ?>

                                                <span class="input-xlarge"><img src="../upload/userimages/<?php echo $categoryRowset['image']; ?>" height="70" width="70" style="border:1px solid #666666" /></span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="input-xlarge"><img src="../upload/no.png" height="70" width="70" style="border:1px solid #666666" /></span>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>


                                <div class="portlet-body">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs nav-tabs-lg">
                                            <li class="active">
                                                <h4 style="margin-left: 10px;"> Details </h4>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="row">

                                                    <!--                                                    <div class="col-md-6 col-sm-12">
                                                                                                            <div class="portlet yellow-crusta box">
                                                                                                                <div class="portlet-title">
                                                                                                                    <div class="caption">
                                                                                                                        <i class="fa fa-cogs"></i>Bank Details
                                                                                                                    </div>
                                                                                                                    <div class="actions">
                                                    
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="portlet-body">
                                                    
                                                                                                                    <div class="row static-info">
                                                                                                                        <div class="col-md-5 name">
                                                                                                                            Paypal Email: <?php echo $categoryRowset['paypal_email'] ?>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-7 value">
                                                    
                                                                                                                        </div>
                                                                                                                    </div>
                                                    
                                                    
                                                                                                                    <div class="row static-info">
                                                                                                                        <div class="col-md-5 name">
                                                                                                                            Account Name: <?php echo $categoryRowset['account_name'] ?>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-7 value">
                                                    
                                                                                                                        </div>
                                                                                                                    </div>
                                                    
                                                    
                                                    
                                                                                                                    <div class="row static-info">
                                                                                                                        <div class="col-md-5 name">
                                                                                                                            Account Number: <?php echo $categoryRowset['account_number'] ?>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-7 value">
                                                    
                                                                                                                        </div>
                                                                                                                    </div>
                                                    
                                                    
                                                                                                                    <div class="row static-info">
                                                                                                                        <div class="col-md-5 name">
                                                                                                                            Bank Name: <?php echo $categoryRowset['bank_name'] ?>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-7 value">
                                                    
                                                                                                                        </div>
                                                                                                                    </div>
                                                    
                                                    
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>-->


                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Address Details
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-8 name">
                                                                        Address: <?php echo $categoryRowset['address'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">
                                                                    </div>
                                                                </div>

                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Country: <?php echo $categoryRowset['country'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Province/State: <?php echo $categoryRowset['state'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        City: <?php echo $categoryRowset['city'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Zip Code/Post Code: <?php echo $categoryRowset['zip'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>




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
    <?php //include('includes/quick_sidebar.php'); ?>
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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>