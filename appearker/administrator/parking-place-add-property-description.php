<?php
include_once 'includes/config.php';

if (!isset($_SESSION['parking_place'])) {
    header('location: parking-place-add-general-information.php');
    exit();
}

if (isset($_POST['submit'])) {
    $_SESSION['parking_place']['property_description'] = [
        'title' => $_POST['title'],
        'about' => $_POST['about'],
        'rules_availability' => $_POST['rules_availability'],
        'amenities' => $_POST['amenities']
    ];
    header('location: parking-place-add-parking-place-n-price.php');
    exit();
}

$amenityQry = mysqli_query($link, "SELECT * FROM `amenities`");

include_once 'includes/header.php';
?>

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
            <?php //include('includes/style_customize.php');      ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking Place</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Parking Place</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking Place</span>
                    </li>
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">

                <?php
                require_once('./parking-place-add-nav-menu.php');
                ?>

                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Property Description
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>">

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Title:</label>
                                        <div class="col-md-4">
                                            <input type="text" name="title" class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">About This Listing:</label>
                                        <div class="col-md-4">
                                            <textarea name="about" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Rules and Availability Days/Hours:</label>
                                        <div class="col-md-4">
                                            <textarea name="rules_availability" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Amenities:</label>
                                        <div class="col-md-4">
                                            <select name="amenities" class="form-control" multiple required>
                                                <?php
                                                while($amenity = mysqli_fetch_object($amenityQry)){
                                                    echo '<option value="'.$amenity->id.'">'.$amenity->name.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Photos:</label>
                                        <div class="col-md-4">
                                            <input type="file" name="photos" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="reset" name="reset" class="btn red" value="Reset" />
                                            <button type="button" class="btn default" onclick="location.href = 'list_product.php'">Cancel</button>
                                            <input type="submit" name="submit" class="btn blue" value="Next" />
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
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index: 999;margin - top: - 34px;'></span>");
                    }
                });
            }
        }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');       ?>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        });</script>

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
    }</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });</script>

<script        >
    function checkbed(id)
    {

        if (id == 1)
        {

            $("#showhide").show();
        }
        else
        {
            $("#showhide").hide();
        }


    }
    $(function () {
        var scntDiv = $('#tubemapmore');
        var i = $('#tubemapmore div').size() + 1;

        $('#addmore').live('click', function () {
            $('<div style="position:relative;" id="new' + i + '"><i class="fa fa-times deleteDiv" aria-hidden="true" style="cursor: pointer; position:absolute;right:0px;" class="remScnt" id="' + i + '"></i><select name="map[icon][]" class="form-control" required><option value="overground">Overground</option><option value="underground">Underground</option><option value="dlh">DLR</option><option value="rail">Rail</option></select><input type="text" name="map[tubename][]"  placeholder="tube name" style="margin-bottom:10px;" /><input type="text" name="map[tubedistance][]"  placeholder="tube distance" style="margin-bottom:10px;" /></div>').appendTo(scntDiv);
            i++;
            return false;
        });

        $('.deleteDiv').live('click', function () {
            $(this).closest("div").remove();
        })

        // $('.remScnt').live('click', function() {
        //         if( i > 2 ) {
        //                 console.log(this.id);
        //                 i--;
        //         }
        //         return false;
        // });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#start_date").datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() + 1);
                $("#end_date").datepicker("option", "minDate", dt);
            }
        });
        $("#end_date").datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() - 1);
                $("#start_date").datepicker("option", "maxDate", dt);
            }
        });

        $('input[name="available_from"]').datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd'
        });
    });
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
