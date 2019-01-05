<?php
include_once "./includes/session.php";
include_once "./includes/config.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from parking_rules where id='" . $item_id . "'");
    header('Location:list_parkingrule.php');
    exit();
}

if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select * from parking_rules  where id<>''";

    $record = mysqli_query($link, $sql);

}

if (isset($_REQUEST['submit'])) {

    $rule = isset($_POST['rule']) ? $_POST['rule'] : '';

    $fields = array(
        'rule' => mysql_real_escape_string($rule),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {
        $editQuery = "UPDATE `parking_rules` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        if (mysqli_query($link, $editQuery)) {

            // if ($_FILES['image']['tmp_name'] != '') {
            //     $target_path = "../upload/footerpages/";
            //     $userfile_name = $_FILES['image']['name'];
            //     $userfile_tmp = $_FILES['image']['tmp_name'];
            //     $img_name = $userfile_name;
            //     $img = $target_path . $img_name;
            //     move_uploaded_file($userfile_tmp, $img);

            //     $image = mysqli_query($link, "UPDATE `footer_pages` SET `image`='" . $img_name . "' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
            // }

            $_SESSION['msg'] = "Category Updated Successfully";
        } else {
            $_SESSION['msg'] = "Error occuried while updating Category";
        }

        header('Location:list_parkingrule.php');
        exit();

    } else {

        $addQuery = "INSERT INTO `parking_rules` (`" . implode('`,`', array_keys($fields)) . "`)"
        . " VALUES ('" . implode("','", array_values($fields)) . "')";

        //exit;
        mysqli_query($link, $addQuery);
        $last_id = mysql_insert_id();
        // if ($_FILES['image']['tmp_name'] != '') {
        //     $target_path = "../upload/footerpages/";
        //     $userfile_name = $_FILES['image']['name'];
        //     $userfile_tmp = $_FILES['image']['tmp_name'];
        //     $img_name = $userfile_name;
        //     $img = $target_path . $img_name;
        //     move_uploaded_file($userfile_tmp, $img);

        //     $image = mysqli_query($link, "UPDATE `parking_rules` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
        // }

        header('Location:list_parkingrule.php');
        exit();

    }

}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysqli_query($link, "SELECT * FROM `parking_rules` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));

}

/*Bulk Category Delete*/
if (isset($_REQUEST['bulk_delete_submit'])) {

    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        mysqli_query($link, "DELETE FROM`parking_rules` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';
    header("Location:list_parkingrule.php");
}
?>
<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_parkingrule.php?cid=" + aa + "&action=delete"
        }
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
			List Parking Rule
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="list_parkingrule.php">View Parking Rule</a>
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
								<i class="fa fa-edit"></i>List Parking Rule
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
								<!-- <th>
									 Image
								</th> -->
								<th>
								Parking Rule
								</th>

								<th>
									 Edit
								</th>
							</tr>
							</thead>
							<tbody>
							<?php
if (mysqli_num_rows($record) == 0) {?>
                  <tr>
                    <td colspan="3">Sorry, no record found.</td>
                  </tr>
                  <?php
} else {

    while ($row = mysqli_fetch_object($record)) {
        // if ($row->image == '') {
        //     $img = '../upload/noimage.Jpeg';
        // } else {
        //     $img = '../upload/footerpages/' . $row->image;
        // }

        ?>

							<tr>
                                                          
							<!-- 	<td>
									<img src="<?php echo stripslashes($img); ?>" height="70" width="70" style="border:1px solid #666666" />
								</td> -->
								<td>
									<?php echo stripslashes($row->rule); ?>
								</td>

								<td>

									<a class="btn btn-info btn-sm" onClick="window.location.href = 'add_parkingrule.php?id=<?php echo $row->id ?>&action=edit'"><i class="fa fa-pencil"></i></a>

									<a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $row->id; ?>')"><i class="fa fa-close"></i></a>
								</td>
							</tr>
                                                       <?php
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
<?php if(mysqli_num_rows($record)> 0){?>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<?php } ?>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-editable.js"></script>
<script>
jQuery(document).ready(function() {
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   TableEditable.init();
});
</script>

<script type="text/javascript">
function deleteConfirm(){
    var result = confirm("Are you sure to delete pages from footer?");
    if(result){
        return true;
    }else{
        return false;
    }
}

$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });

    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length)
        {
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});



</script>
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>
</body>
<!-- END BODY -->
</html>
