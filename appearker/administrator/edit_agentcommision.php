<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php

    $sql1 = "select id,name from blog  where parent_id='0'";
    $record1 = mysql_query($sql1);

    if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

        $sql = "select * from blog  where id<>''";

        $record = mysql_query($sql);
    }

if (isset($_REQUEST['submit'])) {

    //print_r($_POST); exit;

    $client_commition = isset($_POST['client_commition']) ? $_POST['client_commition'] : '';
    $reffered_commition = isset($_POST['reffered_commition']) ? $_POST['reffered_commition'] : '';
    $agent_commition = isset($_POST['agent_commition']) ? $_POST['agent_commition'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    $fields = array(
        'client_commition' => mysql_real_escape_string($client_commition),
        'reffered_commition' => mysql_real_escape_string($reffered_commition),
        'agent_commition' => mysql_real_escape_string($agent_commition),
        'status' => mysql_real_escape_string($status)
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {


        $editQuery = "UPDATE `estejmam_agent_commition` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        mysql_query($editQuery);

        header('Location:list_agentcommision.php');
        exit();
    } else {

        
    }
}

if ($_REQUEST['action'] == 'edit') {
    
   // $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_agent_commition` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
    
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT estejmam_agent_commition.*,estejmam_user.fname,estejmam_user.lname,estejmam_main_property.name FROM ((estejmam_agent_commition LEFT JOIN estejmam_user ON estejmam_agent_commition.agent_id = estejmam_user.id) LEFT JOIN estejmam_main_property ON estejmam_agent_commition.prop_id = estejmam_main_property.id) WHERE estejmam_agent_commition.id='".mysql_real_escape_string($_REQUEST['id'])."'"));

    //echo $categoryRowset; exit;
}


/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {



    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        //echo "UPDATE `estejmam_banner` SET status='0' WHERE id=".$id;
        mysql_query("DELETE FROM`blog` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Category have been deleted successfully.';

    //die();

    header("Location:list_blog.php");
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
            <?php //include('includes/style_customize.php');  ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Agent Commision <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent Commision</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="add_banner.php">Agent Commision</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent Commision</span>
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
                                <i class="fa fa-gift"></i>Edit Agent Commision
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
                            <form class="form-horizontal" method="post" action="edit_agentcommision.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <div class="form-body">
                                
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Agent Name</label>
                                        <div class="col-md-4">
                                            <input type="text" disabled class="form-control" value="<?php echo $categoryRowset['fname'].' '.$categoryRowset['lname']; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Name</label>
                                        <div class="col-md-4">
                                            <input type="text" disabled class="form-control" value="<?php echo $categoryRowset['name']; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Client Reffered Commission</label>
                                        <div class="col-md-4">
                                            <input type="text" disabled class="form-control" value="<?php echo $categoryRowset['client_commition']; ?>" name="client_commition">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Reffered Commission</label>
                                        <div class="col-md-4">
                                            <input type="text" disabled class="form-control" value="<?php echo $categoryRowset['reffered_commition']; ?>" name="reffered_commition">

                                        </div>
                                    </div>

                                    

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Agent Reffered Commission</label>
                                        <div class="col-md-4">
                                            <input type="text" disabled class="form-control" value="<?php echo $categoryRowset['agent_commition']; ?>" name="agent_commition">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Status</label>
                                        <div class="col-md-4">
                                            <select name="status" class="form-control">
                                                <option value="1">Paid</option>
                                                <option value="0">Not Paid</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                               </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href = 'list_agentcommision.php'">Cancel</button>
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
