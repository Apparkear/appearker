<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysql_query("delete from  estejmam_user where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:search_vendor.php');
	exit();
}


if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysql_query("update estejmam_user set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_vendor.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysql_query("update estejmam_user set status='1' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:search_vendor.php');
	exit();
} 

?>
<?php
if(isset($_POST['ExportCsv']))
{
   
   
  //  $sql="SELECT
  //  			id,
  //  			concat(`fname`,' ', `lname`) as name,
  //  			email,
  //  				CASE `gender` 
  //  				WHEN 'M' THEN 'Male'  
		// 		WHEN 'F' THEN 'Female'   
 
		// 	END as 'gender',
		//  	address,
		//  	about_me,
		//  	add_date,
		//  	CASE `status` 
  //  				WHEN 1 THEN 'UnBlock'  
		// 		WHEN 0 THEN 'Block'   
 
		// 	END as 'status'
		//  	FROM 
		// `estejmam_user` 
		// 	WHERE type=1 and `status`!=2 ";

$sql = "SELECT
id,
concat(`fname`,' ', `lname`) as name,
email,
CASE `gender` 
WHEN 'M' THEN 'Male'  
WHEN 'F' THEN 'Female'   

END as 'gender',
address,
about_me,
add_date,
phone,
city,
last_login,

CASE `status` 
WHEN 1 THEN 'UnBlock'  
WHEN 0 THEN 'Block'   

END as 'status'
FROM 
`estejmam_user` 
WHERE type = '1' and `status` != '2'";
   
    
		

$query=mysql_query($sql);

  $output='';

    $output .='User ID,User Name,Email,Gender,About Me,Contact Number,City,Address,Joining Date, Status';

    $output .="\n";

    if(mysql_num_rows($query)>0)
    {
        while($result = mysql_fetch_assoc($query))
        {	
           $user_ID = $result['id'];
           $user_Name = $result['name'];
           $email = $result['email'];
           $gender = $result['gender'];
           $about_me = $result['about_me'];
           $contact_num = $result['phone'];
           $city = $result['city'];
           $address = $result['address'];
           $about_me = $result['about_me'];
           $status = $result['status'];
          
           if($user_ID!=""){
            $output .='"'.$user_ID.'","'.$user_Name.'","'.$email.'","'.$gender.'","'.$about_me.'","'.$contact_num.'","'.$city.'","'.$address.'","'.$add_date.'","'.$status.'"';
            $output .="\n";
            }
        }
    }



    $filename = "myFile".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
	
	
}

?>
<?php
if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

    $sql="select * from estejmam_user  where id<>'' AND `type`='1'";     

 

$record=mysql_query($sql);


}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `estejmam_category` SET status='0' WHERE id=".$id;
            mysql_query("DELETE FROM `estejmam_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:search_vendor.php");
    }
?>

<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="search_vendor.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="search_vendor.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="search_vendor.php?cid="+aa+"&action=active";
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
			List Landlords
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.html">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">List Sellers</a>
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
                                                            <form action="" method="post">
								<!--<i class="fa fa-edit"></i>Editable Table-->
                                                                <button type="submit" class="btn btn-primary"  name="ExportCsv"> Download CSV</button>
                                                            </form>
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
                                                            <!--<td>#</td>-->
                                                             <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
                                                             <th>
                                                                  Image
                                                              </th>
								<th>
									Name
								</th>
								<th>
									 Email
								</th>
                                                                <!--<th>
									 Address
								</th>-->
								
								<th>
									 Edit
								</th>
                                                                <th>
									 Delete
								</th>
                                                                <th>
									Sellers Details
								</th>
                                                                 <th>
									Status
								</th>
								
							</tr>
							</thead>
							<tbody>
							<?php
                                                  // $sql="select * from estejmam_user  where `type`=1 and `status`!=2";
                                                        

 

//$record=mysql_query($sql);

if(mysql_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php 

}

else

{

$count=1;

	while($row=mysql_fetch_object($record))

	{
            if($row->image!='')
                                                            {
                                                                $image_link='../upload/userimages/'.$row->image;
                                                            }
                                                        else {
                                                           $image_link='../upload/no.png';
                                                             }


	

?>

							
							<tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td>-->
                                                             <td>
                                                              <img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" />   
                                                             </td>
                                                             
								<td>
									<?php echo $row->fname;?> <?php echo $row->lname;?>
								</td>
								
								
								<td>
									<?php echo $row->email;?>
								</td>
                                                                <!--<td>
									<?php echo $row->address;?>
								</td>-->
								<td>
									<a onClick="window.location.href='add_vendor_type.php?id=<?php echo $row->id ?>&action=edit'">Edit</a>
								</td>
                                 <td>
									<a onClick="javascript:del('<?php echo $row->id; ?>')">Delete</a>
								</td>
                                                                <td>
									<a onClick="window.location.href='vendor_details.php?id=<?php echo $row->id ?>&action=details'">Details</a><br />
									<a onClick="window.location.href='store_product.php?id=<?php echo $row->id ?>&action=details'">Property List</a>
									
								</td>
                                                                 <td>
									<?php if($row->status=='0'){?>
<a  onClick="javascript:active('<?php echo $row->id;?>');">UnBlock</a>
<?php } else {?>
<a  onClick="javascript:inactive('<?php echo $row->id;?>');">Block</a>
		  <?php }?>
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
    var result = confirm("Are you sure to delete vendor?");
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