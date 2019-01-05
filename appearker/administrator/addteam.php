<?php
ob_start();
session_start();
include 'includes/config.php';
if(isset($_REQUEST['delete']) && $_REQUEST['delete']!='')
{
   $editrow=mysql_query("delete from `estejmam_team` where `id`='".$_REQUEST['delete']."'"); 
   header('Location:manageagentteam.php');
    
}
if(isset($_REQUEST['submit']) && $_REQUEST['submit']!='')
{
    if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
    {
	$insertquery=mysql_query("update `estejmam_team` set `agent_id`='".$_REQUEST['teammember']."',`template_id`='".$_REQUEST['emailtemplate']."' where id=".$_REQUEST['id']);
	
	$_SESSION['msg']='Team member edit successfully';
	header('Location:manageagentteam.php');
	
    }
    else
    {
	$insertquery=mysql_query("insert into `estejmam_team`(`agent_id`,`template_id`,`status`) values('".$_REQUEST['teammember']."','".$_REQUEST['emailtemplate']."',1)");
	
	$_SESSION['msg']='Team member addedd successfully';
	header('Location:manageagentteam.php');
    }
    
    
    
    
}
if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
{
   $editrow=mysql_fetch_array(mysql_query("select * from `estejmam_team` where `id`='".$_REQUEST['id']."'")); 
    
}
else
{
  $editrow=array();  
}

?>
<?php include('includes/header.php'); ?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Add Team
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
{ echo $_REQUEST['id']; } ?>"

<div class="form-body">
    <?php 
    if(isset($_SESSION['errmsg']) && $_SESSION['errmsg']!='')
    {
	
	echo '<span style="color:red;">Email Already Exist!</span>';
	unset($_SESSION['errmsg']);
    }
    ?>
    <?php
    $sql = "select * from `estejmam_email_templt` where 1";
$record = mysql_query($sql);
?>
             <div class="form-group">
                                        <label class="control-label col-md-3">Choose Team Member</label>
                                        <div class="col-md-4">
					    <select name="teammember" class="form-control" required="">
                                                <option value="">Select Team Member</option>
                                               <?php
					       $sql1 = "select * from estejmam_user  where id<>'' AND `type`='2' AND `host_type`='1' ";
$record1= mysql_query($sql1);
					    while($row1=mysql_fetch_object($record1))
					    {
						?>
					    <option value="<?php echo $row1->id;  ?>" <?php if(isset($editrow['agent_id']) && $row1->id==$editrow['agent_id']){ echo "selected"; } ?>><?php echo $row1->fname.' '.$row1->lname;  ?></option>
						
						
					    <?php	
					    }
					    ?>
                                            </select>
					

                                        </div>
                                    </div>
              <div class="form-group">
                                        <label class="control-label col-md-3">Choose Email Template</label>
                                        <div class="col-md-4">
					    <select name="emailtemplate" class="form-control" required="">
                                                <option value="">Select Email Template</option>
                                               <?php
					    while($row=mysql_fetch_object($record))
					    {
						?>
					     <option value="<?php echo $row->id;  ?>" <?php if(isset($editrow['template_id']) && $row->id==$editrow['template_id']){ echo "selected"; } ?>><?php echo $row->name;  ?></option>
						
						
					    <?php	
					    }
					    ?>
                                            </select>
					

                                        </div>
                                    </div>
       <div class="form-group">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-4">
                                          <input type="submit" name="submit" class="btn blue" value="Save" />

                                        </div>
                                    </div>
</div>
			    </form>
                        </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>



<style>
    .thumb{
        height: 60px;
        width: 60px;
        padding-left: 5px;
        padding-bottom: 5px;
    }

</style>

<script>


    window.preview_this_image = function (input) {

        if (input.files && input.files[0]) {
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
                }
            });
        }
    }
</script>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<?php //include('includes/quick_sidebar.php');    ?>
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php'); ?>
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/form-samples.js"></script>
<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


<!--<script src="js/jquery.watermark.min.js"></script>


<script>

    function changeWatermark(id)
    {
        $('img.watermark_img_' + id).watermark({
            path: '../images/watermark.png'
        });

    }
</script>-->


<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        // initiate layout and plugins
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        FormSamples.init();

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                orientation: "left",
                autoclose: true,
                language: "xx"
            });
        }

    });

    $(document).ready(function () {

        $('.del_this').click(function (event) {
            var id = $(this).data('imgid');

            var divs = $(this);
            var formdata = {id: id, action: "deleteImg"};
            $.ajax({
                url: "del_ajax.php",
                type: "POST",
                dataType: "json",
                data: formdata,
                success: function (data) {
                    if (data.ack == 1)
                    {

                        $(divs).closest('.div_div').remove();
                    }



                }

            });
        });



        $(document).on("click", ".del_this", function () {
            $(this).parent().remove();

        });


    });

</script>

<script type="text/javascript">
    function select_sub(id) {
        $.ajax({
            type: "post",
            url: "ajax_category.php?action=cat",
            data: {id: id},
            success: function (msg) {
                $('#subcat').html(msg);
            }
        });
    }
</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>

<link href="../css/uploadfilemulti.css" rel="stylesheet">
<script src="../js/jquery.fileuploadmulti.min.js"></script>

<script>

    $(document).ready(function ()
    {

        var settings = {
            url: "upload.php?id=<?php echo $_REQUEST['id'] ?>",
            method: "POST",
            allowedTypes: "jpg,png,gif,doc,pdf,zip",
            fileName: "myfile",
            multiple: true,
            onSuccess: function (files, data, xhr)
            {
                $("#status").html("<font color='green'>Upload is success</font>");

            },
            afterUploadAll: function ()
            {
                //alert("all images uploaded!!");
                window.location.href = '<?php echo $url ?>';
            },
            onError: function (files, status, errMsg)
            {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#mulitplefileuploader").uploadFile(settings);

        $(".addWatermark").click(function(){
            var id = $(this).data('id');
            var current_url = window.location.href;
            console.log(id);
            $.ajax({
                type: "post",
                url: 'ajax_add_watermark.php',
                data: {id: id,action: 'edit',url:current_url,submit:'1'},
                success: function (msg) {
                    if(msg==1){
                        window.location.href=current_url;
                    }
                }
            });
        })

    });
</script>


<style>
    .photo-box {
        padding: 5px;
        border: 1px solid #e1e1e1;
        position: relative;
        height: 150px;
    }
    .photo-box img {
        height: 100%;
        width: 100%;
    }
    .photo-box a {
        position: absolute;
        top: 40%;
        left: 0;
        width: 100%;
        padding: 5px;
        background: rgba(255,255,255,0.7);
        text-align: center;
        color: #000;
        text-decoration: none;
    }
</style>


<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
