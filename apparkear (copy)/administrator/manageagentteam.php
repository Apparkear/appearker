<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
?>
<?php include("includes/header.php"); 
  $record=mysql_query("select * from `estejmam_team` where 1");

?>

<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include("includes/left_panel.php"); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title">
               Manage Team
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Manage Team</a>
<!--                        <i class="fa fa-angle-right"></i>-->
                    </li>
                    <!--<li>
                            <a href="#">Editable Datatables</a>
                    </li>-->
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-edit"></i>Manage Team
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar" style="float:right">
                                <div class="row">

                                </div>
                            </div>
                            <form name="bulk_action_form" action="" method="post" />
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr>

 <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
                                        <th>Sl No.</th>
                                        <th>Email Address</th>
					<th>Mobile No</th>
                                        <th>Action</th>
<!--                                        <th>Actions</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//$sql="select * from estejmam_booking  where id<>''";
//$record=mysql_query($sql);
                                    if (mysql_num_rows($record) == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7">Sorry, no record found.</td>
                                        </tr>
                                        <?php
                                    } else {

                                        $counter = 1;
                                        while ($row = mysql_fetch_object($record)) {
					    $email=mysql_fetch_array(mysql_query('select * from `estejmam_user` where `id`='.$row->agent_id));
				    $template_id=mysql_fetch_array(mysql_query('select * from `estejmam_email_templt` where `id`='.$row->template_id));	
				    
                                            ?>

                                            <tr>
                                                 <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id; ?>"/></td>-->
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $email['fname'].' '.$email['lname']; ?></td>
						<td><?php echo $template_id['name']; ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" onClick="window.location.href = 'addteam.php?id=<?php echo $row->id ?>'">Edit team</a>
						                  <a class="btn btn-info btn-sm" onClick="window.location.href = 'addteam.php?delete=<?php echo $row->id ?>'">Delete team</a>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter++;
                                        }
                                    }
                                    ?>




                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT -->
        </div>
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="page-footer">
    <?php include("includes/footer.php"); ?>
</div>
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
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-editable.js"></script>
<script>
                                                jQuery(document).ready(function () {
                                                    Metronic.init(); // init metronic core components
                                                    Layout.init(); // init current layout
                                                    QuickSidebar.init(); // init quick sidebar
                                                    Demo.init(); // init demo features
                                                    TableEditable.init();
                                                });
</script>

<script type="text/javascript">
    function deleteConfirm() {
        var result = confirm("Are you sure to delete banner?");
        if (result) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length)
            {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });
    });



</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>
</body>
<!-- END BODY -->
</html>
