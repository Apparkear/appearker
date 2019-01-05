<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from  parking_places where id='" . $item_id . "'");
    $_SESSION['msg']=message('deleted successfully',1);
    header('Location: parking-place-list.php');
    exit();
}


// if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set status='0' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:list_partners.php');
//     exit();
// }
// if (isset($_GET['action']) && $_GET['action'] == 'active') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set status='1' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:list_partners.php');
//     exit();
// }


// if (isset($_GET['action']) && $_GET['action'] == 'notverify') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set is_verifyed='0' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:list_partners.php');
//     exit();
// }
// if (isset($_GET['action']) && $_GET['action'] == 'verify') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set is_verifyed='1' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:list_partners.php');
//     exit();
// }



// if (isset($_GET['action']) && $_GET['action'] == 'hostinactive') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set host_type='0' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:list_partners.php');
//     exit();
// }
// if (isset($_GET['action']) && $_GET['action'] == 'hostactive') {
//     $item_id = $_GET['cid'];
//     mysqli_query($link, "update estejmam_partners set host_type='1' where id='" . $item_id . "'");
//     //$_SESSION['msg']=message('updated successfully',1);
//     header('Location:add_partners.php');
//     exit();
// }
?>
<?php
// /* Bulk Category Delete */
// if (isset($_REQUEST['bulk_delete_submit'])) {



//     $idArr = $_REQUEST['checked_id'];
//     foreach ($idArr as $id) {
//         //echo "UPDATE `estejmam_category` SET status='0' WHERE id=".$id;
//         mysqli_query($link, "DELETE FROM `estejmam_partners` WHERE id=" . $id);
//     }
//     $_SESSION['success_msg'] = 'Users have been deleted successfully.';

//     //die();

//     header("Location:search_user.php");
// }

$sql = "select * from `parking_places`";
$record = mysqli_query($link, $sql);
?>


<script language="javascript">
    function del(aa, bb) {
        var a = confirm("Are you sure, you want to delete this?")
        if (a) {
            location.href = "parking-place-list.php?cid=" + aa + "&action=delete"
        }
    }

    function inactive(aa)
    {
        location.href = "search_partners?cid=" + aa + "&action=inactive"

    }
    function active(aa)
    {
        location.href = "search_partners?cid=" + aa + "&action=active";
    }

    function inactiveVar(aa)
    {
        location.href = "search_user.php?cid=" + aa + "&action=notverify"

    }
    function activeVar(aa)
    {
        location.href = "search_partners?cid=" + aa + "&action=verify";
    }


    function hostinactive(aa)
    {
        location.href = "search_partners?cid=" + aa + "&action=hostinactive"

    }
    function hostactive(aa)
    {
        location.href = "search_partners?cid=" + aa + "&action=hostactive";
    }

</script>
<?php include("includes/header.php"); ?>
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
                List Parking Place
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="search_user.php">List Parking Place</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
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
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                                <thead>
                                    <tr>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Renter
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Action
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($record) == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="3">Sorry, no record found.</td>
                                        </tr>
                                        <?php
                                    } else {
                                        $count = 1;

                                        while ($row = mysqli_fetch_object($record)) {
                                            ?>


                                            <tr>
                                                <td>
                                                    <?php echo $row->title; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->fname . ' ' . $row->lname; ?>
                                                </td>
                                                <td>
                                                	<?php echo $row->email; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" onClick="window.location.href = 'parking-place-edit-general-information.php?id=<?php echo $row->id ?>&action=edit'"><i class="fa fa-pencil"></i></a>
                                                    <?php /* ?> <a onClick="window.location.href='add_billing_details.php?id=<?php echo $row->id ?>&action=edit'">Edit Billing Address</a><br>
                                                      <a onClick="window.location.href='add_shipping_details.php?id=<?php echo $row->id ?>&action=edit'">Edit Shipping Address</a><?php */ ?>

                                                    <a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $row->id; ?>')"><i class="fa fa-close"></i></a>

                                                    <!-- <a class="btn btn-success btn-sm" onClick="window.location.href = 'user_details.php?id=<?php echo $row->id ?>&action=details'"><i class="fa fa-user"></i></a> -->
        <!--                                                    <a class="btn btn-warning btn-sm" onClick="window.location.href = 'my_purchase.php?id=<?php echo $row->id ?>&action=details'"><i class="fa fa-shopping-cart"></i></a> -->
        <!--                                                    <a onClick="window.location.href = 'change_password_user.php?id=<?php echo $row->id ?>&action=details'">Update Password</a>-->
                                                </td>


                                            </tr>
                                            <?php
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
        var result = confirm("Are you sure to delete User?");
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