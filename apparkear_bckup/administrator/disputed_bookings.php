<?php
ob_start();
session_start();
include "./includes/config.php";
//include_once("controller/productController.php");
mysqli_query($link, "SET SESSION character_set_results = 'UTF8'");
header('Content-Type: text/html; charset=UTF-8');

unset($_SESSION['prop_id']);

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from estejmam_booking where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_booking.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'unfeatured') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set is_featured='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'featured') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set is_featured='1' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set status='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set status='1' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}
?>


<?php
if (isset($_POST['ExportCsv'])) {

    $sql = "select * from estejmam_main_property where 1";

    $query = mysqli_query($link, $sql);

    $output = '';

    $output .= 'Prop ID,Property Type,Name,Desc,Price,Added By,Added Date,status';

    $output .= "\n";

    if (mysqli_num_rows($query) > 0) {
        while ($result = mysqli_fetch_assoc($query)) {

            $proptype = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_property_type` where `id`='" . $result['prop_type'] . "'"));
            $user = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $result['user_id'] . "'"));

            if ($result['status'] == 1) {
                $allstat = "Active";
            } else {
                $allstat = "Not Active";
            }

            $prop_ID = $result['id'];
            $prop_type = $proptype['name'];
            $name = $result['name'];
            $description = $result['description'];
            $price = $result['price'];
            $addedby = $user['fname'];
            $add_date = $result['created_date'];
            $status = $allstat;

            if ($prop_ID != "") {
                $output .= '"' . $prop_ID . '","' . $prop_type . '","' . $name . '","' . $description . '","' . $price . '","' . $addedby . '","' . $add_date . '","' . $status . '"';
                $output .= "\n";
            }
        }
    }

    $filename = "myFile" . time() . ".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;

    //echo'<pre>';
    //print_r($result);

    exit;
}
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_booking.php?cid=" + aa + "&action=delete"
        }
    }

    function featured(aa)
    {
        location.href = "list_booking.php?cid=" + aa + "&action=featured"

    }
    function unfeatured(aa)
    {
        location.href = "list_booking.php?cid=" + aa + "&action=unfeatured";
    }


    function active(aa)
    {
        location.href = "list_booking.php?cid=" + aa + "&action=active"

    }
    function inactive(aa)
    {
        location.href = "list_booking.php?cid=" + aa + "&action=inactive";
    }

</script>
<?php include "includes/header.php";?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include "includes/left_panel.php";?>
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
                Disputed Booking list
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="index.html">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="disputed_bookings.php">Disputed Booking list</a>
                        <i class="fa fa-angle-right"></i>
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
                               Disputed Booking list
                                    <!--<i class="fa fa-edit"></i>Editable Table-->
                            </div>
                            <div class="tools">
                                <!--                                <a href="javascript:;" class="collapse"></a>-->

                                <!--<a href="#portlet-config" data-toggle="modal" class="config">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="javascript:;" class="remove">
                                </a>-->

                                <!--                                <form action="" method="post">
                                                                    <i class="fa fa-edit"></i>Editable Table
                                                                    <button type="submit" class="btn btn-primary"  name="ExportCsv"> Export Property</button>
                                                                </form>-->
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <!--									<div class="col-md-6">
                                                                                                                    <div class="btn-group">
                                                                                                                            <button id="sample_editable_1_new" class="btn blue">
                                                                                                                            Add New <i class="fa fa-plus"></i>
                                                                                                                            </button>
                                                                                                                    </div>
                                                                                                            </div>-->
                                    <!--									<div class="col-md-6">
                                                                                                                    <div class="btn-group pull-right">
                                                                                                                            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                                                                                                            </button>
                                                                                                                            <ul class="dropdown-menu pull-right">
                                                                                                                                    <li>
                                                                                                                                            <a href="#">
                                                                                                                                            Print </a>
                                                                                                                                    </li>
                                                                                                                                    <li>
                                                                                                                                            <a href="#">
                                                                                                                                            Save as PDF </a>
                                                                                                                                    </li>
                                                                                                                                    <li>
                                                                                                                                            <a href="#">
                                                                                                                                            Export to Excel </a>
                                                                                                                                    </li>
                                                                                                                            </ul>
                                                                                                                    </div>
                                                                                                            </div>-->
                                </div>
                            </div>
                            <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Parking Place</th>
										<th>Booking ID</th>
                                        <th>Order by</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                                   <th>Total Price</th>
                                       <th>Price</th>
				       <th>Service Fees</th>
				       <th>Discount</th>

                                        <th>Payment Date</th>

                                        <th>payment type</th>
                                        <th>Status</th>
                                        <th>Booking Action</th>
                                        <th>Actions</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
$fetch_product = mysqli_query($link, "select * from estejmam_booking where `status`='3' ORDER BY id DESC");
$num = mysqli_num_rows($fetch_product);
if ($num > 0) {
    $i = 1;
    while ($product = mysqli_fetch_array($fetch_product)) {
        $sql_uploader_details = mysqli_fetch_object(mysqli_query($link, "select * from estejmam_user where `id` = '" . $product['user_id'] . "'"));
        $estejmam_main_property = mysqli_query($link, "select * from estejmam_main_property where id=" . $product['prop_id']);
        while ($productifo = mysqli_fetch_array($estejmam_main_property)) {
            $Product_name = $productifo['name'];
            $addedby = $productifo['name'];
        }
        if ($product['user_id'] != '0') {
            $added_by = $sql_uploader_details->fname . ' ' . $sql_uploader_details->lname;
        } else {
            $added_by = 'admin';
        }

        ?>

                                            <tr>
						<td><?php echo $i; ?></td>
                                         <td><?=$Product_name?></td>
										 <td><?php echo $product['order_id'] ?></td>
                                         <td><?=$added_by?></td>

                                        <td><?=$product['start_date']?></td>
                                        <td><?=$product['end_date']?></td>
                                               <td><?=$product['total_price']?></td>
                                        <td><?=$product['price']?></td>
					 <td><?=$product['service_charge']?></td>
					 				       <td><? echo (($product['price']+$product['service_charge']) - $product['total_price']);?></td>

                                        <td><?=$product['payment_date']?></td>
                                        <td><?php if ($product['payment_type'] == 'BT') {echo 'Braintree';}
        if ($product['payment_type'] == 'PP') {echo 'PayPal Pro';}
        if ($product['payment_type'] == 'stripe') {echo 'Stripe';}
        ?></td>
                                        <td><?php
if ($product['status'] == 0) {echo 'In Rewiew';}
        if ($product['status'] == 1) {echo 'Confirm';}
        if ($product['status'] == 2) {echo 'Canceled';}
        if ($product['status'] == 3) {echo 'Disputed';}
        ?></td>
                                        <td>
                                            <?php if ($product['status'] == 0) {?>
                                            <a class="btn btn-success btn-sm bookingStatus" onClick="javascript:bookingStatus('<?php echo $product['id']; ?>')" ><i class="fa fa-check-square-o"></i></a>
                                            <a class="btn btn-danger btn-sm bookingStatus" onClick="javascript:cancelBooking('<?php echo $product['id']; ?>')" ><i class="fa fa-ban"></i></a>
                                            <a class="btn btn-warning btn-sm bookingStatus" onClick="javascript:disputeBooking('<?php echo $product['id']; ?>')" ><i class="fa fa-repeat"></i></a>
                                            <?php }?>
                                            <?php if ($product['status'] == 1) {?>
                                            <a class="btn btn-danger btn-sm bookingStatus" onClick="javascript:cancelBooking('<?php echo $product['id']; ?>')" ><i class="fa fa-ban"></i></a>
                                            <a class="btn btn-warning btn-sm bookingStatus" onClick="javascript:disputeBooking('<?php echo $product['id']; ?>')" ><i class="fa fa-repeat"></i></a>
                                            <?php }?>
                                            <?php if ($product['status'] == 3) {?>
                                            <a class="btn btn-danger btn-sm bookingStatus" onClick="javascript:cancelBooking('<?php echo $product['id']; ?>')" ><i class="fa fa-ban"></i></a>
                                            <a class="btn btn-success btn-sm bookingStatus" onClick="javascript:bookingStatus('<?php echo $product['id']; ?>')" ><i class="fa fa-check-square-o"></i></a>
                                            <?php }?>
                                        </td>



                                                <td>
                                                    <a class="btn btn-success btn-sm" href="bookingdetails.php?id=<?php echo $product['id'] ?>&action=details"><i class="fa fa-eye"></i></a>

                                <!--                                                    <a class="btn btn-warning btn-sm" href="view_calender.php?id=<?php echo $product['id'] ?>&action=view"><i class="fa fa-calendar"></i></a>-->

                                                    <!--<a class="btn btn-info btn-sm" href="add_property.php?id=<?php echo $product['id'] ?>&action=edit"><i class="fa fa-pencil"></i></a>!-->


                                                    <a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $product['id']; ?>')"><i class="fa fa-close"></i></a>

                                                </td>
                                            </tr>
                                            <?php
$i++;
    }
} else {
    ?>
                                        <tr>
                                            <td colspan="4">Sorry, no record found.</td>
                                        </tr>

                                        <?php
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
    <?php include "includes/footer.php";?>
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
        var result = confirm("Are you sure to delete product?");
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

    function bookingStatus(id){
        var bookingID = id;
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'../ajax_booking_status.php?action=acceptBooking',
            data:{ bookingID:bookingID },
            success:function(data){
                if(data.ack==1){
                    alert(data.res);
                    window.location.href='accept_bookings.php';
                }
                if(data.ack==0){
                    alert(data.res);
                }
            }
        });
    }

    function cancelBooking(id){
        var bookingID = id;
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'../ajax_booking_status.php?action=cancelBooking',
            data:{ bookingID:bookingID },
            success:function(data){
                if(data.ack==1){
                    alert(data.res);
                    window.location.href='canceled_bookings.php';
                }
                if(data.ack==0){
                    alert(data.res);
                }
            }
        });
    }

    function disputeBooking(id){
        var bookingID = id;
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'../ajax_booking_status.php?action=disputeBooking',
            data:{ bookingID:bookingID },
            success:function(data){
                if(data.ack==1){
                    alert(data.res);
                    window.location.reload();
                }
                if(data.ack==0){
                    alert(data.res);
                }
            }
        });
    }

</script>
</body>
<!-- END BODY -->
</html>
