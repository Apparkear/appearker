<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysql_query("delete from blog_post where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_post.php');
    exit();
}

if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))){

	$sql = "SELECT estejmam_agent_commition.*,estejmam_user.fname,estejmam_user.lname,estejmam_main_property.name FROM ((estejmam_agent_commition LEFT JOIN estejmam_user ON estejmam_agent_commition.agent_id = estejmam_user.id) LEFT JOIN estejmam_main_property ON estejmam_agent_commition.prop_id = estejmam_main_property.id)";

	//echo $sql; exit;

	$record=mysql_query($sql);
}

// if(isset($_REQUEST['submit']))
// {
// 	$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
//     $name = isset($_POST['name']) ? $_POST['name'] : '';
//     $blog_banner_desc = isset($_POST['blog_banner_desc']) ? $_POST['blog_banner_desc'] : '';
//     $blog_desc = isset($_POST['blog_desc']) ? $_POST['blog_desc'] : '';

//     $fields = array(
//         'parent_id' => mysql_real_escape_string($parent_id),
//         'name' => mysql_real_escape_string($name),
//         'blog_banner_desc' => mysql_real_escape_string($blog_banner_desc),
//         'blog_desc' => mysql_real_escape_string($blog_desc)
//     );

// 	$fieldsList = array();
// 	foreach ($fields as $field => $value) {
// 		$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
// 	}
					 
// 	if($_REQUEST['action']=='edit'){

// 		$editQuery = "UPDATE `blog` SET " . implode(', ', $fieldsList)
// 			. " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

// 		if (mysql_query($editQuery)) {
		
// 		if($_FILES['image']['tmp_name']!='')
// 		{
// 		$target_path="../upload/siteblog/";
// 		$userfile_name = $_FILES['image']['name'];
// 		$userfile_tmp = $_FILES['image']['tmp_name'];
// 		$img_name =$userfile_name;
// 		$img=$target_path.$img_name;
// 		move_uploaded_file($userfile_tmp, $img);
		
// 		$image =mysql_query("UPDATE `blog` SET `image`='".$img_name."' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
// 		}
		
		
// 			$_SESSION['msg'] = "Blog Updated Successfully";
// 		}
// 		else {
// 			$_SESSION['msg'] = "Error occuried while updating Blog";
// 		}

// 		header('Location:list_blog.php');
// 		exit();
	
// 	 }
// 	 else
// 	 {
	 
// 	 $addQuery = "INSERT INTO `blog` (`" . implode('`,`', array_keys($fields)) . "`)"
// 			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
// 			//exit;
// 		mysql_query($addQuery);
// 		$last_id=mysql_insert_id();
// 		if($_FILES['image']['tmp_name']!='')
// 		{
// 		$target_path="../upload/siteblog/";
// 		$userfile_name = $_FILES['image']['name'];
// 		$userfile_tmp = $_FILES['image']['tmp_name'];
// 		$img_name =$userfile_name;
// 		$img=$target_path.$img_name;
// 		move_uploaded_file($userfile_tmp, $img);
		
// 		$image =mysql_query("UPDATE `blog` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
// 		}
		 
// /*		if (mysql_query($addQuery)) {
		
// 			$_SESSION['msg'] = "Category Added Successfully";
// 		}
// 		else {
// 			$_SESSION['msg'] = "Error occuried while adding Category";
// 		}
// 		*/
// 		header('Location:list_blog.php');
// 		exit();
	
// 	 }
				
				
// }

if($_REQUEST['action']=='edit')
{
	//$categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_agent_commition` WHERE `id`='".mysql_real_escape_string($_REQUEST['id'])."'"));



	$categoryRowset = mysql_fetch_array(mysql_query("SELECT estejmam_agent_commition.*,estejmam_user.fname,estejmam_user.lname,estejmam_main_property.name FROM ((estejmam_agent_commition LEFT JOIN estejmam_user ON estejmam_agent_commition.agent_id = estejmam_user.id) LEFT JOIN estejmam_main_property ON estejmam_agent_commition.prop_id = estejmam_main_property.id) WHERE `estejmam_agent_commition.id`='".mysql_real_escape_string($_REQUEST['id'])."'"));

}


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `estejmam_banner` SET status='0' WHERE id=".$id;
            mysql_query("DELETE FROM`blog_post` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Post have been deleted successfully.';
        
        //die();
        
        header("Location:list_post.php");
    }
?>
<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_post.php?cid=" + aa + "&action=delete"
        }
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
			List of Agent Commision
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="list_banner.php">View Agent Commision</a>
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
								<i class="fa fa-edit"></i>List Agent Commision
							</div>
							<!--<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<!--<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>-->
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
									<!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
										
										<th>Client Name</th>

										<th>Property Name</th>

										<th>Client Reffered Commission</th>

										<th>Property Reffered Commission</th>

										<th>Agent Reffered Commission</th>

										<th>Status</th>
										
										<th>Edit</th>

										<!--<th>
											 Delete
										</th>-->
									</tr>
								</thead>
								<tbody>
									<?php
										if(mysql_num_rows($record)==0)
										{	?>
										    <tr><td colspan="3">Sorry, no record found.</td></tr>
										<?php 
										}
										else
										{

											while($row=mysql_fetch_object($record))
											{
												
											?>

											<tr>
												
												<td>
													<?php echo stripslashes($row->fname).' '.($row->lname);?>
												</td>

												<td>
													<?php echo stripslashes($row->name);?>
												</td>

												<td>
													<?php echo stripslashes($row->client_commition);?>
												</td>

												<td>
													<?php echo stripslashes($row->reffered_commition);?>
												</td>

												<td>
													<?php echo stripslashes($row->agent_commition);?>
												</td>
												
												<td>
													<?php if($row->status == 0) { echo 'Not Paid';}else{echo 'Paid';}?>
												</td>

												<td>
													<!-- <a  href="add_banner.php?id=<?php echo $row->id ?>&action=edit">
													Edit </a> -->

													<a class="btn btn-info btn-sm" onClick="window.location.href = 'edit_agentcommision.php?id=<?php echo $row->id ?>&action=edit'"><i class="fa fa-pencil"></i></a>
												
													<!-- <a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $row->id; ?>')"><i class="fa fa-close"></i></a> -->
												</td>
											</tr>
		                                 <?php } } ?>
	                                                                         
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
    var result = confirm("Are you sure to delete banner?");
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
