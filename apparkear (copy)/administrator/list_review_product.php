<?php
include_once("controller/productReviewController.php");
?>

  
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
			Products Review</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
				
					<li>
						<span>Products Review</span>
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
								<i class="fa fa-edit"></i>Product Review
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
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
                                                            <th>
                                                            </th>
								<th>
									 User Name
								</th>
								<th>
									 Product Name
								</th>
								
								<th>
									 Title
								</th>
								<th>
									 Review
								</th>
                                                                <th>
									 Rate
								</th>
                                                                 <th>
									 Post Date
								</th>
                                                                <th>
									 Edit
								</th>
							</tr>
							</thead>
							<tbody>
							   
                                    <?php 
                                   //  $sql="select * from estejmam_rate_review  where id<>''";
				   // $record=mysql_query($sql);
				    if(mysql_num_rows($record)==0)
				    {
					?>
                  <tr>
                    <td colspan="8">Sorry, no record found.</td>
                  </tr>
		    <?php 
		    }
		    else
		    {
		  
			    while($row=mysql_fetch_object($record))
			    {
				$products = mysql_fetch_object(mysql_query("SELECT * FROM `estejmam_product` WHERE `id` = '".$row->product_id."'"));
                                $username=mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id`='".$row->user_id."'"));
			    if($row->store_photo!="")
			    {
				$image_link='../upload/site_logo/'.$row->store_photo;
			    }
			    else
			    {
				$image_link='../upload/no.png';
			    }				
		    ?>


			<tr>
                              <td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td>
			    
			    <td><?php echo stripslashes($username->fname);?> <?php echo stripslashes($username->lname);?></td>
			 
                            <td><?php echo stripslashes($products->name);?></td>
                            <td><?php echo stripslashes($row->title);?></td>
                            <td><?php echo stripslashes($row->review);?></td>
                            <td><?php echo stripslashes($row->rate);?></td>
                         

			    <td><?php echo date("d F, Y",strtotime($row->post_date));?></td>
                <td><!--<button class="btn btn-mini"  onClick="javascript:del('<?php echo $row->id; ?>')">Delete</button>--><a onClick="window.location.href='add_review_product.php?id=<?php echo $row->id ?>&action=edit'">Edit</a> <!--<button class="btn btn-mini" onClick="window.location.href='details_store.php?id=<?php echo $row->id ?>&action=details'">Details</button>-->
                    <!--<button class="btn btn-mini" onClick="window.location.href='monthly_report_store.php?id=<?php echo $row->id ?>&action=details'">Monthly Chart</button>-->
                    
</td>
			</tr>
			<?php 
				
				}
			}
			?>   
                                                       
                                                        
                                                        
                                                        
                                                        
							</tbody>
							</table>
                                                    </table>
                                                     <input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>
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