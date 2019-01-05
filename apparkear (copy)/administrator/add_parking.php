<?php
include_once "./includes/session.php";
include_once "./includes/config.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php

$amenities = mysqli_query($link, "SELECT * FROM `amenities`");

function getLatLong($address){

    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        // $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}


if ((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action']))) {

    $sql = "select * from parking  where id<>''";

    $record = mysqli_query($link, $sql);
}

if (isset($_REQUEST['submit'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $currency = 'usd';
    $price_rate_type = 'per hour';
    $amenities_string = implode(', ', $_POST['amenities']);
    $is_popular = isset($_POST['is_popular']) ? $_POST['is_popular'] : '';
    $country_id = isset($_POST['country_list']) ? $_POST['country_list'] : '';
    $state_id = isset($_POST['states_list']) ? $_POST['states_list'] : '';
    $city_id = isset($_POST['city_list']) ? $_POST['city_list'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $latLong = getLatLong($address);
    $lat = $latLong['latitude']?$latLong['latitude']:'0';
    $lon = $latLong['longitude']?$latLong['longitude']:'0';


    $fields = array(
        'name' => mysqli_real_escape_string($link, $name),
        'description' => mysqli_real_escape_string($link, $description),
        'price' => mysqli_real_escape_string($link, $price),
        'currency' => mysqli_real_escape_string($link, $currency),
        'price_rate_type' => mysqli_real_escape_string($link, $price_rate_type),
        'amenities' => mysqli_real_escape_string($link,$amenities_string),
        'is_popular' => mysqli_real_escape_string($link, $is_popular),
        'country' => mysqli_real_escape_string($link, $country_id),
        'state' => mysqli_real_escape_string($link, $state_id),
        'city' => mysqli_real_escape_string($link, $city_id),
        'address' => mysqli_real_escape_string($link, $address),
        'lat' => mysqli_real_escape_string($link, $lat),
        'lon' => mysqli_real_escape_string($link, $lon),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    if ($_REQUEST['action'] == 'edit') {

        $editQuery = "UPDATE `parking` SET " . implode(', ', $fieldsList)
        . " WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'";

        mysqli_query($link, $editQuery);

        if ($_FILES['image']['tmp_name'] != '') {
            $target_path = "../upload/parking/";
            $userfile_name = $_FILES['image']['name'];
            $userfile_tmp = $_FILES['image']['tmp_name'];
            $img_name = time().$userfile_name;
            $img = $target_path . $img_name;
            move_uploaded_file($userfile_tmp, $img);

            $image = mysqli_query($link, "UPDATE `parking` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
        }
        header('Location:list_parking.php');
        exit();
    } else {

            $addQuery = "INSERT INTO `parking` (`" . implode('`,`', array_keys($fields)) . "`)"
            . " VALUES ('" . implode("','", array_values($fields)) . "')";

            mysqli_query($link, $addQuery);
            $last_id = mysqli_insert_id($link);
            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/parking/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = time().$userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysqli_query($link, "UPDATE `parking` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
            }
            header('Location:list_parking.php');
            exit();
      
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `parking` WHERE `id`='" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'"));
}

/* Bulk Category Delete */
if (isset($_REQUEST['bulk_delete_submit'])) {

    $idArr = $_REQUEST['checked_id'];
    foreach ($idArr as $id) {
        mysqli_query($link, "DELETE FROM `parking` WHERE id=" . $id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';


    header("Location:list_parking.php");
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
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
              <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
        <script type="text/javascript">
               function initialize() {
                       var input = document.getElementById('geocomplete');
                       var autocomplete = new google.maps.places.Autocomplete(input);
               }
               google.maps.event.addDomListener(window, 'load', initialize);
       </script>
            <h3 class="page-title">
                Parking<small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="add_parking.php">Parking</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Parking</span>
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
                                <i class="fa fa-gift"></i>Add Parking
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_parking.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name']; ?>" name="name" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                        <textarea class="ckeditor form-control" id="editor1" name="description"><?php echo stripslashes($categoryRowset['description']); ?></textarea>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Price</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" placeholder="Enter price" value="<?php echo $categoryRowset['price']; ?>" name="price" required>

                                        </div>
                                    </div>

                                     <div class="form-group">
                           <label class="col-md-3 control-label">Select Amenities</label>
                                    <div class="col-md-4">

                                <?php
                                $allselectedcat=explode(',',$categoryRowset['amenities']);  

                                $sql = "SELECT * FROM amenities";
                                $result = mysqli_query($link,$sql);
                                ?>
                             <select name='amenities[]' multiple>
                                <?php 
                                while ($row = mysqli_fetch_array($result)) {
                                                                    ?>
                            <option value='<?php echo $row['id'];?>'  <?php if(in_array($row['id'], $allselectedcat)){?> selected="selected"<?php }?>><?php echo $row['name'];?></option>
                                    <?php 
                                }?>

                             </select>


                            </div>
                        </div>

                                   <div class="form-group">
                                    <label class="col-md-3 control-label">Available from</label>
                                  <div class="col-md-4">
                                   <select name='date'>
                                 <option value=''> Select Date</option>
                                 <?php
                                 for($i=1;$i<=31;$i++)
                                 { ?>
                                 <option value=<?php echo $i; ?> <?php if($i==$day_exploded){?> selected="selected" <?php } ?>><?php echo $i; ?></option> 
                                 <?php 
                             }
                                 ?>
                            
                                    
                            </select>&nbsp;&nbsp;
                             
                             <select name='month'>
                                 <option value=''> Select...</option>
                                  <option value='01' <?php if('01'==$month_exploded){?> selected="selected" <?php } ?>>Jan</option> 
                                   <option value='02' <?php if('02'==$month_exploded){?> selected="selected" <?php } ?>>Feb</option> 
                                    <option value='03' <?php if('03'==$month_exploded){?> selected="selected" <?php } ?>>Mar</option> 
                                     <option value='04' <?php if('04'==$month_exploded){?> selected="selected" <?php } ?>>Apr</option> 
                                      <option value='05' <?php if('05'==$month_exploded){?> selected="selected" <?php } ?>>May</option> 
                                       <option value='06' <?php if('06'==$month_exploded){?> selected="selected" <?php } ?>>Jun</option> 
                                        <option value='07' <?php if('07'==$month_exploded){?> selected="selected" <?php } ?>>July</option> 
                                         <option value='08' <?php if('08'==$month_exploded){?> selected="selected" <?php } ?>>Aug</option> 
                                          <option value='09' <?php if('09'==$month_exploded){?> selected="selected" <?php } ?>>Sept</option> 
                                           <option value='10' <?php if('10'==$month_exploded){?> selected="selected" <?php } ?>>Oct</option> 
                                            <option value='11' <?php if('11'==$month_exploded){?> selected="selected" <?php } ?>>Nov</option> 
                                             <option value='12' <?php if('12'==$month_exploded){?> selected="selected" <?php } ?>>Dec</option>                                   
                             </select>
                       
                                <select name='year'>
                                 <option value=''> Select...</option>
                                  <option value='2018' <?php if('2019'==$year_exploded){?> selected="selected" <?php } ?>>2018</option> 
                                  <option value='2017' <?php if('2018'==$year_exploded){?> selected="selected" <?php } ?>>2017</option>
                                  
                             </select>

                              </div>
                                </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Is Popular</label>
                                        <div class="col-md-4">
                                            <input type="radio" class="form-control"  value="1" <?php if(1==$categoryRowset['is_popular']){?> checked="checked" <?php } ?> name="is_popular">Yes
                                             <input type="radio" class="form-control"  value="0" <?php if(0==$categoryRowset['is_popular']){?> checked="checked" <?php } ?> name="is_popular">No
                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">Select Country</label>
                                        <div class="col-md-4">
                                             <select name='country_list' id="country_list" onChange="getStateList(this.value);" required>
                                                <option value="">Select One</option>
                                                <?php
                                                $SQL ="SELECT * FROM `countries`";
                                                $result = mysqli_query($link, $SQL);

                                                while($row1=mysqli_fetch_array($result))
                                                {
                                                ?>
                                                <option value="<?php echo $row1['id']; ?>" <?php if($categoryRowset['country']==$row1['id']) { echo "selected";}?> > <?php echo $row1['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                         <div class="form-group">
                                        <label class="col-md-3 control-label">Select State</label>
                                        <div class="col-md-4">
                                          <select name='states_list' id= 'states_list' onChange="getCityList(this.value);">
                                        </select>

                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 control-label">Select City</label>
                                        <div class="col-md-4">
                                         <select name='city_list' id= 'city_list'>
                                        </select>

                                        </div>
                                    </div>

                                     <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-4">
                                           <input id="geocomplete" type="text" class="form-control" name="address" autocomplete="on" value="<?php echo $categoryRowset['address'];?>" required>
                                        </div>
                                    </div>

                     
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image Upload</label>
                                        <div class="col-md-2">
                                            <input type="file" name="image" class=" btn blue"  ><?php if ($categoryRowset['image'] != '') {?><br><a href="../upload/parking/<?php echo $categoryRowset['image']; ?>" target="_blank">View</a><?php }?>

                                        </div>
                                    </div>



                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue"  name="submit">Submit</button>
                                            <button type="button" class="btn default" onclick="location.href = 'list_parking.php'">Cancel</button>
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
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>
    <script>
   function getStateList(val) {
  $.ajax({
  type: "POST",
  url: "get_states.php",
  data:'country_id='+val,
  success: function(data){
    $("#states_list").html(data);
  }
  });
}
   </script>
<script>
   function getCityList(val) {
  $.ajax({
  type: "POST",
  url: "get_states.php",
  data:'state_id='+val,
  success: function(data){
    $("#city_list").html(data);
  }
  });
}
   </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
