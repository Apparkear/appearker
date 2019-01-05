<?php 
include('includes/config.php');

?>
<?php
$store=mysql_fetch_array(mysql_query("select * from `estejmam_store` where `id`='".$_REQUEST['id']."'"));
?>
<?php
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            //echo "UPDATE `estejmam_tblorders` SET status='0' WHERE id=".$id;
            mysql_query("DELETE FROM  `estejmam_tblorderdetails` WHERE orderid=".$id);
        }
        $_SESSION['success_msg'] = 'Orders have been deleted successfully.';
        
        //die();
        
        header("Location:store_order.php");
    }
?>

<script language="javascript">

   function del(aa,bb)

   {

      var a=confirm("Are you sure, you want to delete this?")

      if (a)

      {

        location.href="store_order.php?cid="+ aa +"&action=delete"

      }  

   } 

   

function inactive(aa)

   { 

       location.href="store_order.php?cid="+ aa +"&action=inactive"



   } 

   function active(aa)

   {

     location.href="store_order.php?cid="+aa+"&action=active";

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
			Order list for <?php echo $store['store_title'] ?>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.html">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Order list</a>
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
								<i class="fa fa-edit"></i>Order List
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
								<th>
									Image
								</th>
								<th>
									Product Name
								</th>
                                                                
								<th>
									Total Price
								</th>
								<th>
									 Quantity
								</th>
                                                                <th>
									 Order Date
								</th>
								
								<!--<th>
									 Details
								</th>-->
								
								
								
							</tr>
							</thead>
							<tbody>
							<?php
                                                       $query1="SELECT * FROM estejmam_tblorderdetails where `storeid`='".$_REQUEST['id']."'";
                                                       $res=mysql_query($query1);
                                                       $num=mysql_num_rows($res);
                                                        if($num>0)
                                                        {
                                                        
                                                        $count=1;
                                                        while($row=mysql_fetch_array($res))
                                                        {
                                                                            	
                                     $product=mysql_fetch_array(mysql_query("select * from `estejmam_product` where `id`='".$row['productid']."'"));
                                                    	
                                     $fetchimage=mysql_fetch_array(mysql_query("select * from `estejmam_moreimage` where `pro_id`='".$row['productid']."' limit 1"));
                                                        
                                     $fetchstore=mysql_fetch_array(mysql_query("select * from `estejmam_store` where `id`='".$fetchproduct['store_id']."'"));

                                                        ?>
							
							<tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->orderid ; ?>"/></td>-->
								<td>
                                                                    <?php
                                                            if($fetchimage['image']!='')
                                                            {
                                                            ?>
                                                            <a href="details_product.php?id=<?php echo $product['id'] ?>"><img src="../upload/product/<?php echo $fetchimage['image'] ?>"  height="70" width="70" style="border:1px solid #666666"></a>
                                                            <?php
                                                            }
                                                       else {
                                                            ?>
                                                        <a href="details_product.php?id=<?php echo $product['id'] ?>"><img src="../upload/no.png"  height="70" width="70" style="border:1px solid #666666"></a>
                                                            <?php
                                                             }
                                                            ?>
								</td>
								<td>
								<?php echo $product['name'] ?>
								</td>
								<!--<td>
								<?php echo $fetchstore['store_title'] ?>
								</td>-->
								
								<td>
								$<?php echo $row['price'] * $row['quantity']; ?>	
								</td>
								
								<td>
								<?php echo $row['quantity'] ?>
								
								</td>
                                                                <td>
                                                                 <?php echo $row['date'] ?>   
                                                                </td>
								
								<!--<td>
									 <!--<button class="btn btn-mini green" type="button"  onClick="location.href='order_details.php?orderid=<?php echo $row->orderid;?>'">Details</button>&nbsp;
								</td>-->
							</tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="5">Sorry, no record found.</td>
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
