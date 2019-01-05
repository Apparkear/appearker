<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");
$status_array=array('New','In Proceess',"Done","Rejected","Booked");
mysql_query("SET SESSION character_set_results = 'UTF8'");
header('Content-Type: text/html; charset=UTF-8');
$thisurl=$SITE_URL.$_SERVER['REQUEST_URI'];
function GetStatus($stat_id,$row_id){
	global $status_array;
	foreach ($status_array as $key=>$value) {
		if($key==$stat_id)$chk="selected=\"selected\"";
		else $chk="";
		$option[]="<option $chk value='$key'>$value</option>";
	}

	$return=implode("",$option);
	$return="<select name=\"status[$row_id]\" class=\"status\" data-id=\"$row_id\">$return</select>";
	return $return;
}

if($_POST['pk']==1)
{
	$_REQUEST['action']="comment";
	$_REQUEST['id']=$_REQUEST['name'];

}

if($_REQUEST['action']!="" and intval($_REQUEST['id'])!=0){
	$id=intval($_REQUEST['id']);
	$check=mysql_fetch_array(mysql_query("SELECT `status`,id FROM estejmam_booking_view  where id='{$id}'"));
	$action=trim($_REQUEST['action']);
	if($check['id'])
	{
		if($action=="confirm"){
				// if($check['status']=='0')$status=2;else $status=0;
				$status=intval($_POST['status']);
				mysql_query("UPDATE estejmam_booking_view set `status`='$status' where id='{$id}'");	
				// -- die("UPDATE estejmam_booking_view set `status`='$status' where id='{$id}'");
		}elseif($action=="remove")
		{
			mysql_query("DELETE FROM estejmam_booking_view where id='{$id}'");
		}elseif($action=="comment")
		{
			$comment=mysql_real_escape_string(strip_tags($_POST['value']));
			$comment=trim($comment);
			mysql_query("UPDATE estejmam_booking_view set `comment`='$comment' where id='{$id}'");	
		}
	}
	
	// echo 'ok';
	// die();
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

include('includes/header.php'); ?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
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
                Viewing Request 
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home">
                        </i>
                        <a href="dashboard.php">
                            Home
                        </a>
                        <i class="fa fa-angle-right">
                        </i>
                    </li>
                    <li>
                        <span>
                            Viewing Requests
                        </span>
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
                                <i class="fa fa-gift">
                                </i>
                                Viewing Requests
                            </div>
                        </div>
                        <div class="portlet-body ">
						<!-- BODY -->
							<div class="table-toolbar">
							    <div class="row">
							    </div>
							</div>
							<form action="" method="post" name="bulk_action_form" onsubmit="return deleteConfirm();">
							</form>
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							    <thead>
							        <tr>
							            <th>Sl No</th>
							            <th>Property Name</th>
							            <th>Request ID</th>
							            <th>Request Date</th>
							            <th>Name</th>
							            <th>Phone</th>
							            <th>Email</th>
							            <th>Viewing Date</th>
							            <th>Price</th>
							            <th>Comment</th>
							            <th>Status</th>
							            <th>Action</th>
							        </tr>
							    </thead>
							    <tbody>
							    <?php 
							    	$query=mysql_query("SELECT bv.*,mp.id as prop_id,mp.name as prop_name,mp.price,mp.fees FROM estejmam_booking_view bv left join estejmam_main_property mp on mp.id=bv.prop_id order by bv.id desc");
						    		while ($row=mysql_fetch_array($query)) {
						    			$i++;

							     ?>
							    	<tr>
							    		<td><?php echo $i; ?></td>
							    		<td><a href="/administrator/property_details.php?id=<?php echo $row['prop_id']; ?>&action=details"><?php echo $row['prop_name']; ?></a></td>
							    		<td><?php echo $row['id']; ?></td>
							    		<td><?php echo $row['added']; ?></td>
							    		<td><?php echo $row['fname']." ".$row['lname']; ?></td>
							    		<td><?php echo $row['phone']; ?></td>
							    		<td><?php echo $row['email']; ?></td>
							    		<td><?php echo date("d/m/Y",$row['day'])." ({$row['daypart']})"; ?></td>
							    		<td><?php echo $row['price']; ?></td>
							    		<td>
										<a href="#" class="comment" id="<?php echo $row['id'];?>" data-type="textarea" data-pk="1" data-url="<?php echo $thisurl;?> " data-title="Enter Comment">
							    		<?php echo $row['comment']; ?></a></td>
							    		<td><?php echo GetStatus($row['status'],$row['id']); ?></td>
							    		<td>
                                        <a data-type="textarea" class="btn btn-success btn-sm bookingStatus" title="<?php echo ($row['status']==0) ?  'Confirm request' :  'Mark as NEW'; ?>" onClick="javascript:Action('<?php echo $row['id']; ?>','confirm')" ><i class="fa <?php echo ($row['status']==0) ?  'fa-check-square-o' :  'fa-file'; ?>"></i></a>
                                        <!-- <a class="btn btn-danger btn-sm bookingStatus" onClick="javascript:Remove('<?php echo $row['id']; ?>')" ><i class="fa fa-trash"></i></a>
                                        <a class="btn btn-danger btn-sm bookingStatus" onClick="javascript:Remove('<?php echo $row['id']; ?>')" ><i class="fa fa-trash"></i></a> -->
                                        <a class="btn btn-danger btn-sm bookingStatus" title="Remove Request" onClick="javascript:Action('<?php echo $row['id']; ?>','remove')" ><i class="fa fa-trash"></i></a>


							    		</td>
							    		
							    		
							    	</tr>
							    	<?php } ?>
							    </tbody>
							</table>
						<!-- BODY -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-footer">
    <?php include("includes/footer.php"); ?>
</div>


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
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
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
		$.fn.editable.defaults.mode = 'inline';

	    Metronic.init(); // init metronic core components
	    Layout.init(); // init current layout
	    QuickSidebar.init(); // init quick sidebar
	    Demo.init(); // init demo features
	    TableEditable.init();
	    $('.comment').editable();
	    $("select.status").on("change",function(data) {
	    	var id=$(this).data('id');
	    	var status=$(this).val();

	    	$.post('/administrator/booking_viewing.php',{id:id,action:"confirm",status:status})
	    	console.log("Dataid:"+$(this).data('id'))
	    	console.log("VALUE:"+$(this).val())
	    })

	});

	function Action(id,action) {
		if(action=="remove")
		{
			if(confirm("Are you sure want delete Request?"))
			{
				window.location=window.location.href+"?action=remove&id="+id;
			}
		}
		if(action=="confirm")
		{
			window.location=window.location.href+"?action=confirm&id="+id;
		}

	}


</script>
