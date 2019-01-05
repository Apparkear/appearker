<style type="text/css">
  .icon-a {
     color: yellow;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: orange;
}

.icon-b {
    color: orange;
}
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<?php
include_once "./includes/session.php";
include_once "./includes/config.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php

    $sql = "select * from user_ratings order by id desc";

    $record = mysqli_query($link, $sql);

?>

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
			List User Ratings
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="dashboard.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="list_parkingrule.php">View User Ratings</a>
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
								<i class="fa fa-edit"></i>List User Ratings
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
								<th>
						          User Name
								</th>

                                <th>
                                  Parking Name
                                </th>

                                <th>
                                  Rating Category
                                </th>

                                <th>
                                  Rating
                                </th>

                                 <th>
                                  Comments
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

        $username = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id`='" . mysqli_real_escape_string($link, $row->user_id) . "'"));

         $parking = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`='" . mysqli_real_escape_string($link, $row->parking_id) . "'"));

          $rating = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `ratings_category` WHERE `id`='" . mysqli_real_escape_string($link, $row->rating_id) . "'"));



        ?>

							<tr>
						          <td>
									<?php echo stripslashes($username['fname']." ".$username['lname']); ?>
								</td>

                                    <td>
                                    <?php echo stripslashes($parking['name']); ?>
                                </td>

                                    <td>
                                    <?php echo stripslashes($rating['name']); ?>
                                </td>

                                <td>
                                    
                                    <?php
                                    for($x=1;$x<=$row->rating;$x++) { ?>
                                        <i class="icon-a fas fa-star"></i>
                                        <?php }
                                        if (strpos($row->rating,'.')) { ?>
                                        <i class="icon-star-half-empty"></i>
                                        <?php 
                                        $x++;
                                        }
                                        while ($x<=5) { ?>
                                        <i class="icon-star-empty icon-b far fa-star"></i>
                                        <?php 
                                        $x++;
                                        }
                                    ?>
                                </td>

                                   <td>
                                    <?php echo stripslashes($row->comments); ?>
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
