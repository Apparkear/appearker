<?php 

include_once('includes/session.php');

include_once("includes/config.php");

include_once("includes/functions.php");

?>
<?php
if($_REQUEST['submit'])
{
    $id= $_REQUEST['hid_id'];
    $message=$_REQUEST['message'];
    $update=mysql_query("UPDATE `estejmam_orders` SET `message`='".$message."' WHERE `id`='".$id."'");
    header("location:order_details.php?orderid=".$id);
}
?>
<?php

  if($_REQUEST['orderid'])
    {

  $id=$_REQUEST['orderid'];
 $sql="select * from `estejmam_orders` where `orderid`='$id'";

$res=mysql_query($sql);
$row8=mysql_fetch_array($res);

 $tt=mysql_query("select * from `estejmam_billing` where `billing_id`='".$row8['billingid']."'");
   $row11=mysql_fetch_array($tt);
$tt1=mysql_query("select * from `estejmam_user` where `id`='".$row8['order_user_id']."'");
   $row12=mysql_fetch_array($tt1);
   $price=mysql_query("select * from `estejmam_tblorderdetails` where `id`='".$id."'");
   while($fetch=mysql_fetch_array($price))
   {
       $houid[] = $fetch['id'];
   
   }
    $happid = implode(',' , $houid);
   
    }


if($_REQUEST['orderid']!="")

{


$rowOrderDetails = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_orders` WHERE `orderid`=".mysql_real_escape_string($_REQUEST['orderid'])." "));


/*
$query_user="SELECT id,fb_user_id,concat(fname,' ',lname) as name,email,phone,add_date from estejmam_user where id=".$rowOrderDetails['order_user_id']." ";
$res_user=mysql_query($query_user);
$row_user=mysql_fetch_assoc($res_user);

$query_billing="select * from estejmam_billing where billing_id =".$rowOrderDetails['billingid']."";
$res_billing=mysql_query($query_billing);
$row_billing=mysql_fetch_assoc($res_billing);

$query_order_details="select id,productid,quantity,price from estejmam_tblorderdetails where orderid=".mysql_real_escape_string($_REQUEST['orderid'])."";
$res_order_details=mysql_query($query_order_details);
$num_order_details=mysql_num_rows($res_order_details);*/

}
?>
<?php include("includes/header.php"); ?>
<div class="clearfix">
</div>
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php include("includes/left_panel.php"); ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Order Detail <small>view order details</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="index.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					
					<li>
						<span>Order View</span>
					</li>
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-shopping-cart"></i>Order #<?php echo $rowOrderDetails['new_order_id'];?> <span class="hidden-480">
								| <?php echo $rowOrderDetails['orderdate'];?> </span>
							</div>
							<!--<div class="actions">
								<a href="#" class="btn default yellow-stripe">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
								<div class="btn-group">
									<a class="btn default yellow-stripe dropdown-toggle" href="#" data-toggle="dropdown">
									<i class="fa fa-cog"></i>
									<span class="hidden-480">
									Tools </span>
									<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="#">
											Export to Excel </a>
										</li>
										<li>
											<a href="#">
											Export to CSV </a>
										</li>
										
									</ul>
								</div>
							</div>-->
						</div>
						<div class="portlet-body">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-lg">
									<li class="active">
										<a href="#tab_1" data-toggle="tab">
										Details </a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet yellow-crusta box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Order Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order #:
															</div>
															<div class="col-md-7 value">
																 <?php echo $rowOrderDetails['new_order_id'];?> 
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Order Date & Time:
															</div>
															<div class="col-md-7 value">
																<?php echo $rowOrderDetails['orderdate'];?> 
															</div>
														</div>
                                                                                                            <div class="row static-info">
															<div class="col-md-5 name">
																 Order Type:
															</div>
															<div class="col-md-7 value">
																<?php echo $rowOrderDetails['order_type'];?> 
															</div>
														</div>
														<!--<div class="row static-info">
															<div class="col-md-5 name">
																 Order Status:
															</div>
															<div class="col-md-7 value">
																<span class="label label-success">
																<?php if($rowOrderDetails['orderdate']=='1'){ echo 'Success'; }else{ echo 'Pending';} ;?>  </span>
															</div>
														</div>-->
														<div class="row static-info">
															<div class="col-md-5 name">
																 Grand Total:
															</div>
															<div class="col-md-7 value">
																 $<?php echo $rowOrderDetails['orderamount'];?>
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Customer Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row11['billing_fname'] ?>&nbsp;<?php echo $row11['billing_lname'] ?>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Email:
															</div>
															<div class="col-md-7 value">
																<?php echo $row11['email'] ?>
															</div>
														</div>
														
														<div class="row static-info">
															<div class="col-md-5 name">
																 Phone Number:
															</div>
															<div class="col-md-7 value">
																 <?php echo $row11['billing_ephone'] ?>
															</div>
														</div>
														
														
													</div>
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet green-meadow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Billing Address
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																 <?php echo $row11['billing_fname'];?><br>
																 #<?php echo $row11['billing_add'];?><br>
																 <?php echo $row11['billing_add2'];?><br>
																  <?php echo $row11['billing_city'];?><br>
																 <?php echo $row11['billing_state'];?><br>
																T: <?php echo $row11['billing_ephone'];?><br>
																E: <?php echo $row11['email'];?><br>
																
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="portlet red-sunglo box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shipping Address
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																  <?php echo $row11['shiping_fname'];?><br>
																 #<?php echo $row11['shiping_add'];?><br>
																 <?php echo $row11['shiping_add2'];?><br>
																  <?php echo $row11['shiping_city'];?><br>
																 <?php echo $row11['shiping_state'];?><br>
																T: <?php echo $row11['shiping_ephone'];?><br>
																E: <?php echo $row11['email1'];?><br>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet grey-cascade box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<table class="table table-hover table-bordered table-striped">
															<thead>
																<tr>
																
																<td>
																Item Name
																</td>
																
																<td>
																Image
																</td>
																<td>
																Store Name
																</td>
																<td>
																QTY
																</td>
																<td>
																Regular Price
																</td>
																<td>
																Offer Price
																</td>
																<td>
																Offer Start Date
																</td>
																<td>
																Offer End Date
																</td>
																<td>
																Total
																</td>

																</tr>
															</thead>
															<tbody>
															
															<?php
															
															$sum=0;
															  $x="select * from estejmam_tblorderdetails where orderid='".$id."'";
															  	$rs=mysql_query($x);
																while($row_r=mysql_fetch_object($rs))
																{
															 
															// $sum=$sum+$row_order_details['quantity']*$row_order_details['price'];
															 
																$product_image=mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_product` WHERE `id`='".$row_r->productid."'"));
                $start_date = date('Y-m-d', strtotime($product_image->start_date));
$end_date = date('Y-m-d', strtotime($product_image->end_date));
$current_date = date('Y-m-d');
                $product_store=mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_store` WHERE `id`='".$product_image->store_id."'"));
                
                $product_moreimage=mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_moreimage` WHERE `pro_id`='".$product_image->id."'"));
																
																?>
																<tr>
																
																<td>
																<?php echo $product_image->name;?>
																</td>
																
																<?php $im=$product_image->img;
																if($product_moreimage->image=='')
																{
																$imgage= '../upload/no.png';
																}
																else {
																$imgage= '../upload/product/'.$product_moreimage->image;  
																}
																?>
																<td>
																<img src="<?php echo $imgage; ?>" width="100" height="100"  border="0" align="center" alt="" />
																</td>
																<td>
																<?php echo $product_store->store_title;?>
																</td>
																<td>
																<?php echo $row_r->quantity;?>   
																</td>

																<td>
																$<?php  
																echo $product_image->regular_price;

																?>
																</td>
																<td>
																$<?php  
																echo $product_image->offer_price;

																?>
																</td>
																<td>
																<?php echo $product_image->start_date ?>
																</td>
																<td>
																<?php echo $product_image->end_date ?>
																</td>
																<?php
																if($product_image->offer_price!='' || $product_image->offer_price!=0.00 ){
																if($current_date >= $start_date && $current_date <= $end_date)
																{
																?>
																<td>
																$ <?php echo $price_db = ($row_r->quantity)*($product_image->offer_price);?></td>
																				
																<?php      
																}
																else
																{
																?>
																<td>
																$<?php echo $price_db = ($row_r->quantity)*($product_image->regular_price);?></td>
																<?php                                                   


																}
																}

																		


																else
																{
																?>
																<td>                                               
																$<?php echo $price_db =($row_r->quantity)*($product_image->regular_price);?></td>
																		
																<?php
																}
																?>
																   



																</tr>
																
																
																
																<?php
																
															 $sum=$sum+$price_db;
															 }
															 ?>
															
															<tr style="background-color: #67809f;color:#fff;">
															<th colspan="7">Grand Total</th>
															
															<th colspan="2">$ <?php echo $sum;?></th>
															</tr>
															
															
															
															</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
                                                                            
                                                                            
                                                                            <div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Comment
										</div>
										<div class="tools">
											<a href="javascript:;" class="collapse">
											</a>
											
											<a href="javascript:;" class="reload">
											</a>
											<a href="javascript:;" class="remove">
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="#" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
										         
                                            <input type="hidden" name="hid_id" value="<?php echo $_REQUEST['orderid'] ?>">
                                    
											
											<div class="form-body">
												
                                                 <div class="form-group">
												<label class="control-label col-md-3">Add Note</label>
												<div class="col-md-9">
												<textarea class="ckeditor form-control" id="editor1" name="message" rows="6"><?php echo $row8['message'] ?></textarea>
												</div>
												</div>
												
												
												
                                                  
												
											

												
											</div>
											
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn blue" value="Add"  name="submit">Submit</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
				</div>
			</div>
										
									</div>
									
									
									
									
								</div>
							</div>
						</div>
					</div>
					<!-- End: life time stats -->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('include/footer.php');?>
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
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/global/scripts/datatable.js"></script>
<script src="assets/admin/pages/scripts/ecommerce-orders-view.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
           EcommerceOrdersView.init();
        });
    </script>
    <script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
