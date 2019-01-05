<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
$sql = "select * from `estejmam_commision`";
$record = mysql_query($sql);

/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {



    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        //echo "UPDATE `estejmam_booking` SET status='0' WHERE id=".$id;
        mysql_query("DELETE FROM`estejmam_booking` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';

    //die();

    header("Location:list_banner.php");
}

if (isset($_POST['ExportCsv'])) {


    $sql = "select * from estejmam_booking  where status='1'";
    $query = mysql_query($sql);
    $output = '';
    $output .='Sl No,User Email,Payment Date,Booking No,Total,Payment Type,Status';
    $output .="\n";

    if (mysql_num_rows($query) > 0) {
        $count = 1;
        while ($result = mysql_fetch_object($query)) {

            $userDetails = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . $result->user_id . "'"));

            $slno = $count;
            $email = $userDetails->email;
            $paymentdate = $result->date;
            $bookingNo = $result->transaction_id;
            $total = $result->price;
            $pay_type = $result->payment_type;
            $status = $result->status;

            if ($status == 1) {
                $allstat = "Paid";
            } else {
                $allstat = "Failed";
            }


            $output .='"' . $slno . '","' . $email . '","' . $paymentdate . '","' . $bookingNo . '","' . $total . '","' . $pay_type . '","' . $allstat . '"';
            $output .="\n";

            $count++;
        }
    }

    $filename = "paid_payments_" . time() . ".csv";

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=' . $filename);
    echo $output;
    //echo'<pre>';
    //print_r($result);

    exit;
}


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysql_query("delete from estejmam_commision where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_commission.php');
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
    $item_id = $_GET['cid'];
    mysql_query("update estejmam_commision set status='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_commission.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];
    mysql_query("update estejmam_commision set status='1' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_commission.php');
    exit();
}
?>
<?php include("includes/header.php"); ?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_commission.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "list_commission.php?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "list_commission.php?cid=" + aa + "&action=active";
    }
</script>

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
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->

            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Commission
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">View Commission</a>
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
                                <i class="fa fa-edit"></i>Commission
                            </div>
                            <div class="tools">
                                <!--                                   <form action="" method="post">
                                                                    <button type="submit" class="btn btn-primary"  name="ExportCsv"> Export Data</button>
                                                                </form>-->
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar" style="float:right">
                                <div class="row">

                                </div>
                            </div>
                            <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr>

 <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
                                        <th>Sl No.</th>
										<th>Commission Type</th>
                                        <th>Fee Type</th>                                       
                                        <th>Amount</th>
                                        <th>Date</th>
										<th>Status</th>
                                        <th>Actions</th>
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
                                        $commissiontype = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_commision_type` WHERE `id`='" . $row->commision_type_id . "'"));
                                           
											if($row->fee_type=='1')
											{
												$dfr = "Flat";
											}
											if($row->fee_type=='2')
											{
												$dfr = "Percentage";
											}
											if($row->status=='1')
											{
												$stfr = "Active";
											}
                                            if($row->status=='0')
											{
												$stfr = "Incctive";
											}
                                            ?>

                                            <tr>
                                                 <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id; ?>"/></td>-->
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $commissiontype->name; ?></td>
                                                <td><?php echo $dfr; ?></td>
												<td>$<?php echo $row->commission_fee; ?></td>
                                                <td><?php echo $row->date; ?></td>
												<td>
												<?php if ($row->status == '0') { ?>
                                                        <a class="btn btn-danger"  onClick="javascript:active('<?php echo $row->id; ?>');">Deactive</a>
                                                    <?php } else { ?>
                                                        <a class="btn btn-success"  onClick="javascript:inactive('<?php echo $row->id; ?>');">Active</a>
                                                    <?php } ?>
												</td>
                                                <td>
												<a class="btn btn-info btn-sm" onClick="window.location.href = 'add_commission.php?id=<?php echo $row->id ?>&action=edit'"><i class="fa fa-pencil"></i></a>
												<a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $row->id; ?>')"><i class="fa fa-close"></i></a>
												</td>
                                                



                                            </tr>
                                            <?php
                                            $counter++;
                                        }
                                    }
                                    ?>




                                </tbody>
                            </table>
                                <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
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
