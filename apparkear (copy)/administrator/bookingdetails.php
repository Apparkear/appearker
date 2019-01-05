<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");

mysql_query("SET SESSION character_set_results = 'UTF8'");
header('Content-Type: text/html; charset=UTF-8');


if ($_REQUEST['action'] == 'details') {
    $bookingdetails = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_booking` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));


    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysql_real_escape_string($bookingdetails['prop_id']) . "'"));

    $user = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . mysql_real_escape_string($bookingdetails['user_id']) . "'"));

    
$states= mysql_fetch_array(mysql_query("SELECT * FROM `states` WHERE `id`='" . mysql_real_escape_string($categoryRowset['state']) . "'"));

  $cities= mysql_fetch_array(mysql_query("SELECT * FROM `cities` WHERE `id`='" . mysql_real_escape_string($categoryRowset['city']) . "'")); 

    $ptype = mysql_fetch_array(mysql_query("select * from `estejmam_property_type` where `id`='" . $categoryRowset['prop_type'] . "'"));

    $country = mysql_fetch_array(mysql_query("select * from `estejmam_countries` where `id`='" . $categoryRowset['country'] . "'"));

    $ctype = mysql_fetch_array(mysql_query("select * from `estejmam_currency` where `id` = '" . $categoryRowset['currency'] . "'"));


    if ($categoryRowset['review_each_request'] == '1') {
        $sat = "Host Will Check Guest Request For Booking.";
    }
    if ($categoryRowset['guest_book_instant'] == '2') {
        $sat = "Guest Can Book The Property Instanly without Host Confermations.";
    }


    if ($categoryRowset['availability'] == '0') {
        $bookeble = "Always Bookble.";
    }
    if ($categoryRowset['availability'] == '1') {
        $bookeble = "Sometime Bookble.";
    }
    if ($categoryRowset['availability'] == '3') {
        $bookeble = "Onetime Bookble.";
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
            <?php //include('includes/style_customize.php');    ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Booking Details
            </h3>

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Booking Details</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Booking Details</span>
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
                                <i class="fa fa-gift"></i>Booking Details 
                            </div>
                            <!--                            <div class="tools">
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

                                <h4 style="margin-left:10px;margin-top: 10px;"> Property Name and Description</h4>
                                <div class="form-body">
                                    <div class="form-group">

                                        <div class="col-md-5 ">Property Name:</div>
                                        <div class="col-md-5"><?php echo $categoryRowset['name']; ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description:</label>
                                        <div class="col-md-8"> <?php echo $categoryRowset['description']; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property owner:</label>
                                        <div class="col-md-8"><?php echo $user['fname'].' '. $user['lname']?>
                                        </div>
                                    </div>
                                </div>

                                <hr>


                                

                               
                                <hr>
                                <h4 style="margin-left:10px;margin-top: 10px; ">Basic payment information</h4>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">price:</label>
                                        <div class="col-md-4">   <?php echo $bookingdetails['price']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Transaction Number:</label>
                                        <div class="col-md-4">   <?php echo $bookingdetails['transaction_id']; ?>

                                        </div>
                                    </div>
                                </div>

                               

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">  Payment Type:</label>
                                        <div class="col-md-4">   <?php echo $bookingdetails['payment_type']; ?>

                                        </div>
                                    </div>
                                </div>


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Payment Date:</label>
                                        <div class="col-md-4">   <?php echo $bookingdetails['payment_date']; ?>

                                        </div>
                                    </div>
                                </div>



                                <hr>

                                <div class="portlet-body">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs nav-tabs-lg">
                                            <li class="active">
                                                <h3 style="margin-left:10px;"> Details </h3>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="row">



                                                    <div class="col-md-6 col-sm-12">
                                                     <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>User information 
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                               
                                                       
                                                        

                                                               

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Name: <?php echo $bookingdetails['firstname']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Email: <?php echo $bookingdetails['email']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Telephone: <?php echo $bookingdetails['telephone']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Date of birth : <?php echo $bookingdetails['dob']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                    Gender: <?php echo $bookingdetails['gender']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Nationality: <?php echo $bookingdetails['nationality']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                Are you moving in with your partner: <?php echo $bookingdetails['moving_in_with_your_partner']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                    What brings you to madrid: <?php echo $bookingdetails['brings_you_to_madrid']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Please tell us about you and where you will study or work: <?php echo $bookingdetails['study_or_work']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                     Where did you hear about us: <?php echo $bookingdetails['you_hear_about_us']; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                               


</div>



                                                            </div>
                                                            </div>
                                                       
                                                   
                                                    







                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Cost :: 
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                            price : <?php echo $bookingdetails['price'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                
                                                               
                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                            Service charge: <?php echo $bookingdetails['service_charge'] ?>
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

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <!--<button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                            <button type="reset" class="btn blue" onClick="window.location.href = 'list_booking.php'" style="margin-left: 150px">Back</button>
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
    <?php //include('includes/quick_sidebar.php');           ?>
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

    jQuery(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>


<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script type="text/javascript">
    $(document).ready(function () {

        $('.fancybox').fancybox();

    });


</script>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
