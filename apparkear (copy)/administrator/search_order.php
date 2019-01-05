<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='inactive')

{

	 $item_id=$_GET['cid'];

	 mysql_query("update estejmam_booking set status='0' where id='".$item_id."'");

	$_SESSION['msg']=message('updated successfully',1);

	header('Location:search_order.php');

	exit();

}

if(isset($_GET['action']) && $_GET['action']=='active')

{

	$item_id=$_GET['cid'];

	mysql_query("update `estejmam_tblorderdetails` set order_status='1' where id='".$item_id."'");
        mysql_query("update `estejmam_booking` set status='1' where id='".$item_id."'");

	$_SESSION['msg']=message('updated successfully',1);

	header('Location:search_order.php');

	exit();

} 

//csv download
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="SELECT * from `estejmam_booking`";
   
    
		

$query=mysql_query($sql);

  $output='';

    $output .='Order ID,User Name,Order Date,Order Amount';

    $output .="\n";

    if(mysql_num_rows($query)>0)
    {
        while($result = mysql_fetch_assoc($query))
        {
            $fetch_user=mysql_fetch_assoc(mysql_query("select * from `estejmam_user` where `id`='".$result['order_user_id']."'"));
           $order_ID = $result['new_order_id'];
           $user_fname = $fetch_user['fname'];
           $user_lname = $fetch_user['lname'];
           $user_Name=$user_fname.' '.$user_lname;
           $order_date = $result['orderdate'];
           $order_amount = $result['orderamount'];
           
          
           if($order_ID!=""){
            $output .='"'.$order_ID.'","'.$user_Name.'","'.$order_date.'","'.$order_amount.'"';
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


//-----------------------------Data Manage----------------------------

$query="SELECT * FROM estejmam_booking ";
if(isset($_REQUEST['transId']) && $_REQUEST['transId']!="")
{
	$transId=$_REQUEST['transId'];
	
	$query .=" where new_order_id=".trim($transId);
}
if(isset($_REQUEST['store']) && $_REQUEST['store']!="")
{
    $query .=" where `storeid`=".$_REQUEST['store'];
}
 $query.= "  order by `id` DESC ";


$res=mysql_query($query);
$num=mysql_num_rows($res);


//-----------------------------/Data Manage----------------------------


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            //echo "UPDATE `estejmam_booking` SET status='0' WHERE id=".$id;
            mysql_query("DELETE FROM  `estejmam_booking` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Orders have been deleted successfully.';
        
        //die();
        
        header("Location:search_order.php");
    }


?>



<script language="javascript">

   function del(aa,bb)

   {

      var a=confirm("Are you sure, you want to delete this?")

      if (a)

      {

        location.href="search_order.php?cid="+ aa +"&action=delete"

      }  

   } 

   

function inactive(aa)

   { 

       location.href="search_order.php?cid="+ aa +"&action=inactive"



   } 

   function active(aa)

   {

     location.href="search_order.php?cid="+aa+"&action=active";

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
		<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Booking Lists
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Booking List</a>
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
								<i class="fa fa-edit"></i>Booking List
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

                                                            </div>
							</div>
							  <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
					<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
					<thead>
					<tr>
                                            <th>SlNo.</th>
                                            <th>Customer Name</th>
                                            <th>Owner Name</th>
                                            <th>Owner Email</th>
                                            <th>Booking Property Name</th>
                                            <th>Booking Amount</th>
                                            <th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php
					
					if($num>0)
					{
					
					$count=1;
					while($row=mysql_fetch_object($res))
					{
                                            $fetch_user=mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id`='".$row->user_id."'"));
                                            $fetch_owner=mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id`='".$row->uploder_user_id."'"));
                                            $fetch_property = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_main_property` where `id` = '".$row->prop_id."'"));

                                        //	$fetch_store=mysql_fetch_object(mysql_query("select * from `estejmam_store` where `id`='".$row->storeid."'"));
					
					
					/*$fetch_tblorder=mysql_fetch_object(mysql_query("select * from `estejmam_booking` where `id`='".$row->id."'"));
					$fetch_billingdetails=mysql_fetch_object(mysql_query("select * from `estejmam_billing` where `billing_id`='".$fetch_tblorder->billing_id."'"));*/
					/*echo "select * from `estejmam_billing` where `billing_id`='".$fetch_tblorder->billing_id."'";
					exit;*/
					?>
					
					<tr>
					
					<td><?php echo $count;?></td>
					
					<td>
					<?php echo $fetch_user->fname . ' ' . $fetch_user->lname;?>
					</td>
					<td>
					<?php echo $fetch_owner->fname . ' ' . $fetch_owner->lname;?>
					</td>
					
					
					<td>
					<?php echo $fetch_owner->email;?>
					</td>
					
                                        <td>
                                            <?php echo $fetch_property->name;?>
                                        </td>
					
					<td>
					<?php echo '$ ' . number_format($row->price , 2, '.',''); ?>
					</td>
					<td>
						<!-- http://team3.nationalitsolution.co.in/estejmam/administrator/view_booking_details.php?id=1-->
					<a href="view_booking_details.php?id=<?php echo $row->id; ?>&action=details" class="btn btn-mini green">Booking Details</a>
					</td>
					</tr> 
					<?php
					$count++;
					}
					}
					else
					{
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
    var result = confirm("Are you sure to delete Orders?");
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
