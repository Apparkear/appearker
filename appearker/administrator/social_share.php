<?php
ob_start();
session_start();
include 'includes/config.php';

//include_once("controller/productController.php");

// if ($_REQUEST['action'] == "edit" && $_REQUEST['id'] != '') {
//     $url = "your_listing-5.php?id=" . $_REQUEST['id'] . '&action=edit';
// } else {
//     $url = "your_listing-5.php";
// }



if (isset($_REQUEST['del']) && $_REQUEST['del']!='' ){
    $del = "UPDATE `estejmam_sitesettings` set `social_share_image`='' where `id`='1'";
    $unset = "../upload/social_image/".$_REQUEST['del'];

    $agentSQL = mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `type`='2' ");

    while ($dataUser = mysqli_fetch_array($agentSQL)) {
        // $imagepath1 = "../upload/social_image/". $NewImageName;
        $i1 = $dataUser['id'].'owner.jpeg';
        $i2 = $dataUser['id'].'client.jpeg';
        $i3 = $dataUser['id'].'agent.jpeg';
        $pathOwner       = "../upload/social_image/".$i1;
        $pathClient      = "../upload/social_image/".$i2;
        $pathAgent       = "../upload/social_image/".$i3;

        unlink($pathOwner); unlink($pathClient); unlink($pathAgent);
        mysqli_query($link, "UPDATE `estejmam_user` set `onner_rimage`='', `client_rimage`='', `agent_rimage`=''  where `id`='".$dataUser['id']."'");
    }

    mysqli_query($link, $del);
    unlink($unset);

    header("location:social_share.php");
}
?>
<?php include('includes/header.php'); ?>
<!-- END HEADER -->


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
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <?php //include('includes/style_customize.php');  ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Photo <small> Add Social Share Image </small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Setting</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span> Social Share Image </span>
                    </li>
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Add Social Share Image
                            </div>
                            <!--<div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>

                                    <a href="javascript:;" class="reload">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                            </div>-->
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                <input type="hidden" name="user_id" value="<?php echo $categoryRowset['user_id'] ?>">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />
                                <input type="hidden" name="listing1" value="4" />

                                <?php
                                        $imgSQL = mysqli_query($link, "SELECT * FROM `estejmam_sitesettings` WHERE `id`='1'");
                                        $siteSetting = mysqli_fetch_array($imgSQL);
                                if($siteSetting['social_share_image']==''){
                                ?>

                                <div id="mulitplefileuploader"><i class="fa fa-cloud-upload"></i>Add Social Share Photos</div>
                                <?php } ?>
                                <div id="status"></div>



                                <div class="form-group">
                                    <div class="col-md-12">
                                        <?php
                                        if($siteSetting['social_share_image']!=''){?>

                                                <div class="col-md-4" style="width: 20.333% !important;">
                                                    <div class="photo-box">

                                                            <img src="../upload/social_image/<?php echo $siteSetting['social_share_image']; ?>" alt="" class="watermark_img">


                                                            <a href="social_share.php?del=<?php echo $siteSetting['social_share_image']; ?>"><i class="fa fa-minus"></i> Delete</a>

                                                        <?php } ?>

                                                    </div>
                                                </div>
                                    </div>






                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">

                                        <a href="dashboard.php" class="btn btn-warning">Back</a>


                                </div>
                            </div>
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
            url: "socialUpload.php",
            method: "POST",
            allowedTypes: "jpg,png,gif,jpeg",
            fileName: "myfile",
            multiple: false,
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
