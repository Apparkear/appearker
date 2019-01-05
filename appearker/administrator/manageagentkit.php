<?php
ob_start();
session_start();
include 'includes/config.php';
$output_dir = "../upload/social_image/";

$stamp       = imagecreatefrompng('../images/watermarknew.png');
$marge_right = 0;
$marge_top   = 310;
$sx          = imagesx($stamp);
$sy          = imagesy($stamp);
$font_path   = "../fonts/Open_Sans/OpenSans-Bold.ttf"; // Font file
$font_size   = 30; // in pixcels

if (isset($_REQUEST['submit']) && $_REQUEST['submit'] != '') {
    $getdata    = mysql_fetch_array(mysql_query("select * from `media_kit_image` where id=3"));
    $datadecode = json_decode($getdata['json']);
    $image      = $datadecode->{'landlordimage'};
    if (isset($_FILES["image"])) {
        $ret = array();

        if (($_FILES["image"]['name']) != "") {
            //single file
            $RandomNum = time();

            $ImageName = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $ImageType = $_FILES['image']['type']; //"image/png", image/jpeg etc.

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);
            if ($ImageExt == "php") {
                die("Stop! Dont upload PHP ;)");
            }
            $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
            if ($ImageExt == "php") {
                die("Stop! Dont upload PHP ;)");
            }

            move_uploaded_file($_FILES["image"]["tmp_name"], $output_dir . $NewImageName);

            $agentSQL = mysql_query("SELECT * FROM `estejmam_user` WHERE `type`='2' ");
            while ($dataUser = mysql_fetch_array($agentSQL)) {
                $imagepath1 = "../upload/social_image/" . $NewImageName;
                $i1         = $dataUser['id'] . 'agent1.jpeg';
                $pathClient = "../upload/social_image/" . $i1;
                resizeImage($imagepath1);
                watermark_text($imagepath1, $pathClient, $dataUser['agent_code']);
                $noofrow1 = mysql_num_rows(mysql_query("SELECT * FROM `agent_mediakit` WHERE `user_id`= '" . $dataUser['id'] . "' "));
                if ($noofrow1 == 1) {
                    mysql_query("UPDATE `agent_mediakit` set `agent1`='" . $i1 . "'  where `user_id`='" . $dataUser['id'] . "'");
                } else {
                    mysql_query("INSERT INTO `agent_mediakit`(`user_id`,`agent1`) VALUES ('" . $dataUser['id'] . "','" . $i1 . "')");
                }
            }
            $image = $NewImageName;

        }
    } else {
    }
    $image1 = $datadecode->{'landlordimage1'};
    if (isset($_FILES["image1"])) {
        $ret = array();

        if (($_FILES["image1"]['name']) != "") {
            //single file
            $RandomNum = time();

            $ImageName1 = str_replace(' ', '-', strtolower($_FILES['image1']['name']));
            $ImageType1 = $_FILES['image1']['type']; //"image/png", image/jpeg etc.

            $ImageExt1 = substr($ImageName1, strrpos($ImageName1, '.'));
            $ImageExt1 = str_replace('.', '', $ImageExt1);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            if ($ImageExt1 == "php") {
                die("Stop! Dont upload PHP ;)");
            }
            $NewImageName1 = $ImageName1 . '-' . $RandomNum1 . '.' . $ImageExt1;

            move_uploaded_file($_FILES["image1"]["tmp_name"], $output_dir . $NewImageName1);

            $agentSQL = mysql_query("SELECT * FROM `estejmam_user` WHERE `type`='2' ");
            while ($dataUser = mysql_fetch_array($agentSQL)) {
                $imagepath2  = "../upload/social_image/" . $NewImageName1;
                $i2          = $dataUser['id'] . 'agent2.jpeg';
                $pathClient1 = "../upload/social_image/" . $i2;
                resizeImage($imagepath2);
                watermark_text($imagepath2, $pathClient1, $dataUser['agent_code']);
                $noofrow2 = mysql_num_rows(mysql_query("SELECT * FROM `agent_mediakit` WHERE `user_id`='" . $dataUser['id'] . "' "));
                if ($noofrow2 == 1) {
                    mysql_query("UPDATE `agent_mediakit` set `agent2`='" . $i2 . "'  where `user_id`='" . $dataUser['id'] . "'");
                } else {
                    mysql_query("INSERT INTO `agent_mediakit`(`user_id`,`agent2`) VALUES ('" . $dataUser['id'] . "','" . $i2 . "')");
                }

            }
            $image1 = $NewImageName1;
        }

    } else {

    }
    $image2 = $datadecode->{'landlordimage2'};

    if (isset($_FILES["image2"])) {
        $ret = array();

        if (($_FILES["image2"]['name']) != "") {
            //single file
            $RandomNum = time();

            $ImageName2 = str_replace(' ', '-', strtolower($_FILES['image2']['name']));
            $ImageType2 = $_FILES['image2']['type']; //"image/png", image/jpeg etc.

            $ImageExt2 = substr($ImageName2, strrpos($ImageName2, '.'));
            $ImageExt2 = str_replace('.', '', $ImageExt2);
            if ($ImageExt2 == "php") {
                die("Stop! Dont upload PHP ;)");
            }
            $ImageName2    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName2);
            $NewImageName2 = $ImageName2 . '-' . $RandomNum2 . '.' . $ImageExt2;

            move_uploaded_file($_FILES["image2"]["tmp_name"], $output_dir . $NewImageName2);

            $agentSQL = mysql_query("SELECT * FROM `estejmam_user` WHERE `type`='2' ");
            while ($dataUser = mysql_fetch_array($agentSQL)) {
                $imagepath3  = "../upload/social_image/" . $NewImageName2;
                $i3          = $dataUser['id'] . 'agent3.jpeg';
                $pathClient2 = "../upload/social_image/" . $i3;
                resizeImage($imagepath3);
                watermark_text($imagepath3, $pathClient2, $dataUser['agent_code']);
                $noofrow2 = mysql_num_rows(mysql_query("SELECT * FROM `agent_mediakit` WHERE `user_id`='" . $dataUser['id'] . "' "));
                if ($noofrow2 == 1) {
                    mysql_query("UPDATE `agent_mediakit` set `agent3`='" . $i3 . "'  where `user_id`='" . $dataUser['id'] . "'");
                } else {
                    mysql_query("INSERT INTO `agent_mediakit`(`user_id`,`agent3`) VALUES ('" . $dataUser['id'] . "','" . $i3 . "')");
                }
            }
            $image2 = $NewImageName2;

        }
    } else {
    }
    $grandarr = array('lardlordtitle' => $_REQUEST['title'], 'landlorddescription' => $_REQUEST['description'], 'landlordimage' => $image, 'lardlordtitle1' => $_REQUEST['title1'], 'landlorddescription1' => $_REQUEST['description1'], 'landlordimage1' => $image1, 'lardlordtitle2' => $_REQUEST['title2'], 'landlorddescription2' => $_REQUEST['description2'], 'landlordimage2' => $image2);
    mysql_query("Update `media_kit_image` set `json`='" . json_encode($grandarr) . "' where id=3");

}
$getdata    = mysql_fetch_array(mysql_query("select * from `media_kit_image` where `id`=3"));
$datadecode = json_decode($getdata['json']);

function watermark_text($oldimage_name, $new_image_name, $code)
{
// $water_mark_text_2 = "Referral Code:".$code; // Watermark Text

//     global $font_path, $font_size, $marge_right,$marge_top,$sx,$sy;
    //     list($owidth,$oheight) = getimagesize($oldimage_name);
    //     $width = $owidth;
    //     $height = $oheight;
    //     $image = imagecreatetruecolor($width, $height);
    //         $extension=explode('.',$oldimage_name);
    //  $type=end($extension);
    //     if($type=='png')
    //     {
    //      $image_src =imagecreatefrompng($oldimage_name);
    //     }
    //     else
    //     {
    //     $image_src = imagecreatefromjpeg($oldimage_name);
    //     }
    //     imagecopyresampled($image, $image_src, 0, 0, 0, 0, $owidth, $oheight, $owidth, $oheight);
    //     $blue = imagecolorallocate($image, 79, 166, 185);
    //     imagettftext($image, $font_size, 0, imagesx($image_src) - $sx - $marge_right-250, imagesy($image_src) - $sy - $marge_top, $blue, $font_path, $water_mark_text_2);
    //     imagejpeg($image, $new_image_name, 100);
    //     imagedestroy($image);
    //     // unlink($oldimage_name);
    //     return true;
    $water_mark_text_2 = "Code:" . $code; // Watermark Text
    global $font_path, $font_size;

    $extension = explode('.', $oldimage_name);
    $type      = end($extension);
    if ($type == 'png') {
        $im = imagecreatefrompng($oldimage_name);
    } else {
        $im = imagecreatefromjpeg($oldimage_name);
    }
//$im = imagecreatefromjpeg($oldimage_name);
    $stamp     = imagecreatetruecolor(140, 40);
    $bg        = imagecolorallocate($im, 255, 77, 85);
    $textcolor = imagecolorallocate($im, 255, 255, 255);
    imagefilledrectangle($stamp, 0, 0, 450, 40, $bg);
// imagestring($stamp, 30, 10, 10, $water_mark_text_2, $textcolor);
    imagettftext($stamp, 10, 0, 19, 25, $textcolor, $font_path, $water_mark_text_2);

    $marge_right  = 10;
    $marge_bottom = 10;
    $sx           = imagesx($stamp);
    $sy           = imagesy($stamp);
    imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);
    imagejpeg($im, $new_image_name, 100);
    imagedestroy($im);
// unlink($oldimage_name);
    return true;
}

function resizeImage($filename)
{
    $max_width                      = 640;
    $max_height                     = 480;
    $max_size                       = 800;
    list($orig_width, $orig_height) = getimagesize($filename);

    // list($img_width, $img_height) = getimagesize($imagepath1);

    //Construct a proportional size of new image
    $image_scale = min($max_size / $orig_width, $max_size / $orig_height);
    $width       = ceil($image_scale * $orig_width);
    $height      = ceil($image_scale * $orig_height);

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0,
        $width, $height, $orig_width, $orig_height);
    //header("Content-Type: image/jpeg");
    imagejpeg($image_p, $filename, 100);
    return $image_p;
}

?>
<?php include 'includes/header.php';?>
<!-- END HEADER -->


<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include 'includes/left_panel.php';?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Manage Agent Media
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

<div class="form-body">

                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord title</label>
                                        <div class="col-md-4">
                        <input type="text" name="title" value="<?php if (isset($datadecode->{'lardlordtitle'}) && $datadecode->{'lardlordtitle'} != '') {echo $datadecode->{'lardlordtitle'};}?>" class="form-control"  required>

                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Description</label>
                                        <div class="col-md-4">
                        <input type="text" name="description" value="<?php if (isset($datadecode->{'landlorddescription'}) && $datadecode->{'landlorddescription'} != '') {echo $datadecode->{'landlorddescription'};}?>" class="form-control" required >

                                        </div>
                                    </div>
              <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Image</label>
                                        <div class="col-md-4">
                                            <input type="file" name="image" value="" class="form-control" />
            <?php if (isset($datadecode->{'landlordimage'})) {echo '<img src="../upload/social_image/' . $datadecode->{'landlordimage'} . '" width="50" style="width:50" />';}?>

                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord title1</label>
                                        <div class="col-md-4">
                        <input type="text" name="title1" value="<?php if (isset($datadecode->{'lardlordtitle1'}) && $datadecode->{'lardlordtitle1'} != '') {echo $datadecode->{'lardlordtitle1'};}?>" class="form-control"  required>

                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Description1</label>
                                        <div class="col-md-4">
                        <input type="text" name="description1" value="<?php if (isset($datadecode->{'landlorddescription1'}) && $datadecode->{'landlorddescription1'} != '') {echo $datadecode->{'landlorddescription1'};}?>" class="form-control"  required>

                                        </div>
                                    </div>
              <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Image1</label>
                                        <div class="col-md-4">
                                            <input type="file" name="image1" value="" class="form-control" >
 <?php if (isset($datadecode->{'landlordimage1'}) && $datadecode->{'landlordimage1'} != '') {echo '<img src="../upload/social_image/' . $datadecode->{'landlordimage1'} . '" width="50" style="width:50" />';}?>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord title2</label>
                                        <div class="col-md-4">
                        <input type="text" name="title2" value="<?php if (isset($datadecode->{'lardlordtitle2'}) && $datadecode->{'lardlordtitle2'} != '') {echo $datadecode->{'lardlordtitle2'};}?>" class="form-control"  required>

                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Description2</label>
                                        <div class="col-md-4">
                        <input type="text" name="description2" value="<?php if (isset($datadecode->{'landlorddescription2'}) && $datadecode->{'landlorddescription2'} != '') {echo $datadecode->{'landlorddescription2'};}?>" class="form-control"  required>

                                        </div>
                                    </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3">Landlord Image2</label>
                                        <div class="col-md-4">
                                            <input type="file" name="image2" value="" class="form-control"  >
 <?php if (isset($datadecode->{'landlordimage2'}) && $datadecode->{'landlordimage2'} != '') {echo '<img src="../upload/social_image/' . $datadecode->{'landlordimage2'} . '" width="50" style="width:50"/>';}?>
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
<?php include 'includes/footer.php';?>
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
