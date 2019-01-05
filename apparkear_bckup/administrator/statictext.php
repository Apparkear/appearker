<?php include('includes/header.php'); ?>

<?php
$langArray = ['en', 'esp', 'ita', 'fre', 'por', 'cmn', 'yue'];

if ( isset($_POST['submit']) ) {
    $en = $_POST['en']; 
    $esp = $_POST['esp'];
    $ita = $_POST['ita'];
    $fre = $_POST['fre'];
    $por = $_POST['por'];
//    $dch = $_POST['dch'];
//    $rus = $_POST['rus'];
//    $chi = $_POST['chi'];
    $cmn = $_POST['cmn'];
    $yue = $_POST['yue'];
    
    $updateSql = "UPDATE `rar_language` "
            . "SET "
            . "`en`='".addslashes($en)."', `esp`='".addslashes($esp)."', `ita`='".addslashes($ita)."', `fre`='".addslashes($fre)."', `por`='".addslashes($por)."', `cmn`='".addslashes($cmn)."', `yue`='".addslashes($yue)."' "
            . "WHERE `id`='1'";
    
    mysql_query($updateSql);
    
    foreach($langArray as $v){
        $val = "${$v}";
        file_put_contents('../lang/'.$v.'.json', $val);
    }
} else {
    foreach($langArray as $v){
        ${$v} = stripcslashes(file_get_contents('../lang/'.$v.'.json'));
    }
}




$languageSql = "SELECT * FROM `rar_language` WHERE `id` = '1'";
$query = mysql_query($languageSql);
$obj = mysql_fetch_object($query);
?>


<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Manage CMS</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="statictext.php">Manage Static Text</a>
                        <i class="fa fa-angle-right"></i>
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
                                <i class="fa fa-gift"></i>Manage Static Text
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">English Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="en" cols="100" rows="20"><?php echo $en; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Spanish Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="esp" cols="100" rows="20"><?php echo $esp; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Italian Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="ita" cols="100" rows="20"><?php echo $ita; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">French Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="fre" cols="100" rows="20"><?php echo $fre; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Portuguese Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="por" cols="100" rows="20"><?php echo $por; ?></textarea>

                                        </div>
                                    </div>
<!--                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Duch Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="dch" cols="100" rows="20"><?php //echo $dch; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">	
                                        <label class="col-md-3 control-label">Russian Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="rus" cols="100" rows="20"><?php //echo $rus; ?></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Chinese Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="chi" cols="100" rows="20"><?php //echo $chi; ?></textarea>

                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Mandarin Chinese</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="cmn" cols="100" rows="20"><?php echo $cmn; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Cantonese Chinese</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="yue" cols="100" rows="20"><?php echo $yue; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn blue"  name="submit">Submit</button>
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
                        
                    };
                });
            }
        }
    </script>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="page-footer">

    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php include('includes/footer.php'); ?>
</div>
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
<!--<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>-->

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
                        if (data.ack == 1) {

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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
