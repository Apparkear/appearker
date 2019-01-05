<?php
session_start();
include_once("controller/categoryController.php");
include("includes/config");


?>

<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_amenities.php?cid="+ aa +"&action=delete"
      }
   }

function inactive(aa)
   {
       location.href="list_amenities.php?cid="+ aa +"&action=inactive"

   }
   function active(aa)
   {
     location.href="list_amenities.php?cid="+aa+"&action=active";
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
			List Amenities
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">List Amenities</a>
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
								<i class="fa fa-edit"></i>List Amenities
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<!--<a href="#portlet-config" data-toggle="modal" class="config">-->
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
                                                            <!--<td>#</td>-->
                                                             <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
									<th>
										Name
									</th>
									<th>
										Edit
									</th>
									<th>
										Delete
									</th>
                                                               <!-- <th>
									 Product List
								</th>
                                                                <th>
									Status
								</th>-->

							</tr>
							</thead>
							<tbody>
							<?php
                                                  //  $sql="select * from estejmam_category  where 1";




//$record=mysqli_query($link, $sql);

if(mysqli_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php

}

else

{

$count=1;

	while($row=mysqli_fetch_object($record))

	{
            $cat=mysqli_query($link, "select * from `estejmam_product` where `cat_id`='".$row->id."'");
            $num=mysqli_num_rows($cat);
            if($num>0)
            {
                $a=$num;

            }
            else
            {
                $a=0;

            }



?>


							<tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td>-->
								<td>
									<?php echo stripslashes($row->name);?>
								</td>


								<!--<td>
									<?php echo $row->email;?>
								</td>-->
								<td>
									<a onClick="window.location.href='add_amenities.php?id=<?php echo $row->id ?>&action=edit'">Edit</a>
								</td>
                                                                <td>
									<a onClick="javascript:del('<?php echo $row->id; ?>')">Delete</a>
								</td>
                                                                <!--<td>
                                                                    <a href="category_product_list.php?id=<?php echo $row->id ?>">Product List(<?php echo $a ?>)</a>
                                                                </td>
                                                                <td>
									<?php if($row->status=='0'){?>
<a  onClick="javascript:active('<?php echo $row->id;?>');">Activate</a>
<?php } else {?>
<a onClick="javascript:inactive('<?php echo $row->id;?>');">Deactivate</a>
		  <?php }?>
								</td>-->
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
    var result = confirm("Are you sure to delete Categories?");
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
