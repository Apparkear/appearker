<?php 
include_once("includes/session.php");
include_once("includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');

if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysql_query("delete from  estejmam_blog where id='".$item_id."'");
	$_SESSION['msg']=message('deleted successfully',1);
	header('Location: '.basename(__FILE__));
	exit();
}


if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysql_query("update estejmam_blog set status='0' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: '.basename(__FILE__));
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysql_query("update estejmam_blog set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location: '.basename(__FILE__));
	exit();
} 



//-----------------------------Data Manage----------------------------
$name="";

if(isset($_REQUEST['name']) && $_REQUEST['name']!="")
{
	$name=$_REQUEST['name'];
}


if(isset($_GET['search']))
{
	$keyword=$_GET['in_keyword'];	
	$recperpage=$_GET['in_recperpage'];
}
else
{
	$keyword="";	
	$recperpage=30;
}
$start_key=isset($_GET['in_start_key'])?$_GET['in_start_key']:"";


//-----------------------------/Data Manage----------------------------

//-----------------------------------Generate Sql----------------------

$sql="select * from estejmam_blog";
if(isset($_REQUEST['name']) && $_REQUEST['name']!="")
{
    $sql .=" where `name` LIKE '%".trim($_REQUEST['name'])."%'";
}


//$sql="select * from pricecomparison_scrap_data  where id<>'' order by id desc";


if(isset($_GET['in_page'])&& $_GET['in_page']!="")
	$page=$_GET['in_page'];
else
	$page=1;

$total_count=mysql_num_rows(mysql_query($sql));
$sql=$sql." limit ".(($page-1)*$recperpage).", $recperpage";



	if($page>1)
	{
		$url_prev=stristr($url,"&in_page=".$page)==FALSE?$url."&page=".($page-1):str_replace("&in_page=".$page,"&in_page=".($page-1),$url);
                $url_catprev=stristr($url,"&name=".$name)==FALSE?"&name=".$name:str_replace("&name=".$name,"&name=".$name,$url);
		$prev="<a href='".$url_prev."".$url_catprev."' class='small_link'>Prev</a>";
	}
	else
		$prev="Prev";
		
	if((($page)*$recperpage)<$total_count)
	{
		$url_next=stristr($url,"&in_page=".$page)==FALSE?$url."&in_page=".($page+1):str_replace("&in_page=".$page,"&in_page=".($page+1),$url);
             $url_catnext=stristr($url,"&name=".$name)==FALSE?"&name=".$name:str_replace("&name=".$name,"&name=".$name);
		$next="<a href='".$url_next."".$url_catnext."' class='small_link'>Next</a>";
	}
	else
		$next="Next";
		
	$page_temp=(($page)*$recperpage);
	$page_temp=$page_temp<$total_count?$page_temp:$total_count;
	$showing=" Showing ".(($page-1)*$recperpage+1)." - ".$page_temp." of ".$total_count." | ";

//-----------------------------------/Pagination------------------------------

?>

     <script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_blog.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_blog.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_blog.php?cid="+aa+"&action=active";
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
			Blog <small>List Blog</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
				
					<li>
						<span>List Blog</span>
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
								<i class="fa fa-edit"></i>List Blog
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
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
								<tr>
							
								<th>Name</th>
								<th>Category Name</th>
								<th>Sub Category Name</th>
								<th>Status</th>
								<!-- <th>End Date</th>-->
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$record=mysql_query($sql);
							
							
                                                       
                            $num=mysql_num_rows($record);
                            if($num>0)
                             {
                              while($row=mysql_fetch_object($record))
                               {
									 $cat=mysql_fetch_object(mysql_query("select * from `estejmam_blogs_category` where `id`='".$row->category_id."'"));
             						 $subcat=mysql_fetch_object(mysql_query("select * from `estejmam_blogs_sub_category` where `id`='".$row->sub_category_id."'"));
?>

							
							<tr>
								<td>
									<?php echo $row->name;?>
								</td>
								  <td><?php echo $cat->name;?></td>
								<td><?php echo $subcat->name;?></td>
								
								
								<td>
								
								<?php if($row->status=='0'){?>
<button class="btn btn-mini"  onClick="javascript:active('<?php echo $row->id;?>');">Activate</button>
<?php } else {?>
<button class="btn btn-mini"  onClick="javascript:inactive('<?php echo $row->id;?>');">Deactivate</button>
		  <?php }?>
								
								</td>
								<td>
									<a onClick="javascript:del('<?php echo $row->id; ?>')">
									Delete </a>
									
									
									
									
								</td>
							</tr>
                                                       <?php
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
<script>

$(document).ready(function(){
    $(".san_open").parent().parent().addClass("active open");
});
</script>
</body>
<!-- END BODY -->
</html>
