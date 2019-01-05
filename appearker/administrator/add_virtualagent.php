<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>

<?php

    $stamp  = imagecreatefrompng('../images/watermarknew.png');
    $marge_right = 0;
    $marge_top = 310;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    $font_path = "../fonts/Lato-Light.ttf"; // Font file

    $font_size = 30; // in pixcels

?>

<?php
    $sql1 = "select id,fname,lname from estejmam_user where type ='2' AND host_type = '0'";
    $record1 = mysql_query($sql1);
if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select id,fname,lname from estejmam_user where type ='2' AND host_type = '0'";

    $record = mysql_query($sql);
}

if (isset($_REQUEST['submit'])) {

    //print_r($_POST); exit;

    $agent_id = isset($_POST['agent_id']) ? $_POST['agent_id'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    
    $fields = array(
        'agent_id' => mysql_real_escape_string($agent_id),
        'fname' => mysql_real_escape_string($fname),
        'lname' => mysql_real_escape_string($lname),
        'email' => mysql_real_escape_string($email),
        'password' => md5($password),
        'text_password' => $password,
        'no_code' => mysql_real_escape_string($code),
        'phone' => mysql_real_escape_string($number),
        'address' => mysql_real_escape_string($address),
        'type' => '2',
        'host_type' => '0'
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        //echo $_REQUEST['id'];exit;


        $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

        //echo $editQuery; exit;

        mysql_query($editQuery);

        header('Location:list_virtualagent.php');
        exit();
    }else{

        $emailexist  = mysql_num_rows(mysql_query("SELECT * FROM `estejmam_user` WHERE `email` = '".$email."'"));

        if($emailexist == 0){

            $addQuery = "INSERT INTO `estejmam_user` (`" . implode('`,`', array_keys($fields)) . "`)"
                . " VALUES ('" . implode("','", array_values($fields)) . "')";

            //echo $addQuery; exit;
            //exit;
       
            mysql_query($addQuery);
            $lastID = mysql_insert_id();

            $dataUser = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='".$lastID."' "));

            $oonerCode  = substr($fname,0,3).$lastID.'1';
            $clientCode = substr($fname,0,3).$lastID.'2';
            $agentCode  = substr($fname,0,3).$lastID.'3';

            $simageSQL = mysql_query("SELECT * FROM `estejmam_sitesettings` WHERE `id`='1' ");
            $dataImage = mysql_fetch_array($simageSQL);

            $imagepath1 = "../upload/social_image/". $dataImage['social_share_image'];
            $i1 = $dataUser['id'].'owner.jpeg'; $i2 = $dataUser['id'].'client.jpeg'; $i3 = $dataUser['id'].'agent.jpeg';
            $pathOwner = "../upload/social_image/".$i1; $pathClient = "../upload/social_image/".$i2; $pathAgent = "../upload/social_image/".$i3;
            
            watermark_text($imagepath1,$pathOwner,$dataUser['onner_code']);
            watermark_text($imagepath1,$pathClient,$dataUser['client_code']);
            watermark_text($imagepath1,$pathAgent,$dataUser['agent_code']);

            $updateSql  = "UPDATE `estejmam_user` SET `onner_code`= '".$oonerCode."',`client_code`= '".$clientCode."',`agent_code`= '".$agentCode."',`onner_rimage`='".$i1."', `client_rimage`='".$i2."', `agent_rimage`='".$i3."' WHERE `id` = '".$lastID."'";
            
            mysql_query($updateSql);
            
            header('Location:list_virtualagent.php');
            exit();
        }
        else{
            $_SESSION['error_msg'] = 1;
            header('Location:add_virtualagent.php');

        }
        exit();
    } 
}

function watermark_text($oldimage_name,$new_image_name,$code){
$water_mark_text_2 = "Referral Code:".$code; // Watermark Text
    
    global $font_path, $font_size, $marge_right,$marge_top,$sx,$sy;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $width = $owidth;
    $height = $oheight; 
    $image = imagecreatetruecolor($width, $height);
    $image_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $owidth, $oheight, $owidth, $oheight);
    $blue = imagecolorallocate($image, 79, 166, 185);
    imagettftext($image, $font_size, 0, imagesx($image_src) - $sx - $marge_right-20, imagesy($image_src) - $sy - $marge_top, $blue, $font_path, $water_mark_text_2);
    imagejpeg($image, $new_image_name, 100);
    imagedestroy($image);
    // unlink($oldimage_name);
    return true;
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
}


/* Bulk Category Delete */
// if (isset($_REQUEST['bulk_delete_submit'])) {



//     $idArr = $_REQUEST['checked_id'];
//     foreach ($idArr as $id) {
//         //echo "UPDATE `estejmam_banner` SET status='0' WHERE id=".$id;
//         mysql_query("DELETE FROM`blog_post` WHERE id=" . $id);
//     }
//     $_SESSION['success_msg'] = 'Post have been deleted successfully.';

//     //die();

//     header("Location:list_post.php");
// }
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
                Virtual Agent <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Virtual Agent</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="add_virtualagent.php">Virtual Agent</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Virtual Agent</span>
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
                                <i class="fa fa-gift"></i>Add Virtual Agent
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
                            <?php if($_SESSION['error_msg'] == 1){ ?>
                                <span id="errorEmail" style="display:none; color: red;margin-left:255px;"> *Email Already Exist </span>
                            <?php } if(isset($_SESSION['error_msg'])){ unset($_SESSION['error_msg']); } ?>
                            <form class="form-horizontal" method="post" action="add_virtualagent.php" enctype="multipart/form-data" id="myForm">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <div class="form-body">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Agent</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="agent_id">
                                                <option value="0">--Select Agent--</option>
                                                <?php while ($dataf = mysql_fetch_row($record1)) { ?>
                                                    <option value="<?php echo $dataf['0']; ?>" <?php if($dataf['0'] == $categoryRowset['agent_id']) {echo 'selected';}?>><?php echo $dataf['1'].' '.$dataf['2']; ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">First Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $categoryRowset['fname']; ?>" name="fname" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $categoryRowset['lname']; ?>" name="lname" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $categoryRowset['email']; ?>" name="email" required>

                                        </div>
                                    </div>
                                    <label id="myEmail" style="display:none; width:auto; margin:0 34px;"><font color="red">*Email id already exist</font></label>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-4">
                                            <input type="password" class="form-control" id="password" placeholder="Enter Your Password" value="<?php echo $categoryRowset['text_password']; ?>" name="password" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Confirm Password</label>
                                        <div class="col-md-4">
                                            <input type="password" class="form-control" id="confirm" placeholder="Enter Your Password" value="<?php echo $categoryRowset['text_password']; ?>" name="confirm">

                                        </div>
                                    </div>

                                    <label id="myElem" style="display:none; width:auto; margin:0 255px;"><font color="red">*Password and Confirm Password does not match</font></label>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Mobile Number</label>
                                        <div class="col-md-1">

                                            <input type="text" class="form-control" placeholder="+44" value="<?php echo $categoryRowset['no_code']; ?>" name="code" required>
                                         </div>
                                         <div class="col-md-3">
                                            <input type="text" class="form-control" placeholder="9932135511" value="<?php echo $categoryRowset['phone']; ?>" name="number" required>

                                        </div>

                                    </div>

                                

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="address" rows="7"><?php echo stripslashes($categoryRowset['address']); ?></textarea>

                                        </div>
                                    </div>

                                    
                               </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href = 'list_virtualagent.php'">Cancel</button>
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
    <?php //include('includes/quick_sidebar.php');  ?>
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

        
</script>

<script>

$(document).ready(function(){
    $("#myForm").submit(function(){
        var password = $("#password").val();
        var confirm  = $("#confirm").val();
        var email    = $("#email").val();
        if(password==confirm){
            
            // $.ajax({
            //     url: "../agent/ajax_all.php?action=checkEmail",
            //     type: "POST",
            //     dataType: "json",
            //     data:{
            //         email:email
            //     },
            //     success: function (data) {
            //         if(data==1){
            //             return true;
            //         }else{
            //             $("#myEmail").show().delay(3000).fadeOut();
            //             return false;
            //         }
            //     }
            // });

            return true;
        
        }else{
            $("#myElem").show().delay(3000).fadeOut();
            return false;
        }
    })

    $("#errorEmail").show().delay(3000).fadeOut();

})

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
