<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");

mysql_query("SET SESSION character_set_results = 'UTF8'");
header('Content-Type: text/html; charset=UTF-8');


if ($_REQUEST['action'] == 'details') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));

    $user = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . mysql_real_escape_string($categoryRowset['user_id']) . "'"));

    
$states= mysql_fetch_array(mysql_query("SELECT * FROM `states` WHERE `id`='" . mysql_real_escape_string($categoryRowset['state']) . "'"));

  $cities= mysql_fetch_array(mysql_query("SELECT * FROM `cities` WHERE `id`='" . mysql_real_escape_string($categoryRowset['city']) . "'")); 

    $ptype = mysql_fetch_array(mysql_query("select * from `estejmam_property_type` where `id`='" . $categoryRowset['prop_type'] . "'"));

    $country = mysql_fetch_array(mysql_query("select * from `countries` where `id`='" . $categoryRowset['country'] . "'"));

    $ctype = mysql_fetch_array(mysql_query("select * from `estejmam_currency` where `id` = '" . $categoryRowset['currency'] . "'"));


    if ($categoryRowset['review_each_request'] == '1') {
        $sat = "Host Will Check Guest Request For Booking.";
    }
    if ($categoryRowset['guest_book_instant'] == '2') {
        $sat = "Guest Can Book The Property Instanly without Host Confermations.";
    }


    if ($categoryRowset['availability'] == '0') {
        $bookeble = "Always Bookble.";
    }
    if ($categoryRowset['availability'] == '1') {
        $bookeble = "Sometime Bookble.";
    }
    if ($categoryRowset['availability'] == '3') {
        $bookeble = "Onetime Bookble.";
    }

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
            <?php //include('includes/style_customize.php');    ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property Details
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Property Details</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Property Details</span>
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
                                <i class="fa fa-gift"></i> Property Details
                            </div>
                            <!--                            <div class="tools">
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
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />

                                <h4 style="margin-left:10px;margin-top: 10px;"> Property Name and Description</h4>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Name:</label>
                                        <div class="col-md-4"><?php echo $categoryRowset['name']; ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description:</label>
                                        <div class="col-md-8"> <?php echo $categoryRowset['description']; ?>
                                        </div>
                                    </div>
                                </div>

                                <hr>


                                <h4 style="margin-left:10px;margin-top: 10px;"> Others Description </h4>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Room Description:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['room_description']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Details:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['details']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Transpotation:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['transpotation']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Neighborhood Information:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['neighborhood_information']; ?>

                                        </div>
                                    </div>
                                </div>


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Landlord policies:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['landlord_policies']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">What we liked most:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['what_we_liked_most']; ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Keep in mind:</label>
                                        <div class="col-md-4">   <?php echo $categoryRowset['keep_in_mind']; ?>

                                        </div>
                                    </div>
                                </div>




                                <hr>
                                <h4 style="margin-left:10px;margin-top: 10px;"> Property Price</h4>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Price:</label>
                                        <div class="col-md-4">$<?php echo $categoryRowset['price']; ?>/month

                                        </div>
                                    </div>
                                </div>

                                

                                <?php
                                if ($categoryRowset['guest_book_instant'] == '2') {

                                    if ($categoryRowset['how_far_guest_book'] == '0') {
                                        $v = "Any time in the future";
                                    }
                                    if ($categoryRowset['how_far_guest_book'] == '1') {
                                        $v = "3 Months";
                                    }
                                    if ($categoryRowset['how_far_guest_book'] == '2') {
                                        $v = "6 Months";
                                    }
                                    if ($categoryRowset['how_far_guest_book'] == '3') {
                                        $v = "12 Months";
                                    }
                                    ?>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Availability :</label>
                                            <div class="col-md-4"><?php echo $v; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($categoryRowset['guest_notice_period'] == '0') {
                                        $s = "Same Day (customizable cutoff hour)";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '1') {
                                        $s = "At least 1 Day's Notice";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '2') {
                                        $s = "At least 2 Day's Notice";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '3') {
                                        $s = "At least 3 Day's Notice";
                                    }
                                    ?>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">How much advance notice do you need for bookings? :</label>
                                            <div class="col-md-4"><?php echo $s; ?>
                                            </div>
                                        </div>
                                    </div>



                                    <?php if ($categoryRowset['guest_notice_period'] == '0') { ?>

                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Guests can same-day instant book until? :</label>
                                                <div class="col-md-4"><?php echo $categoryRowset['guest_time']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Minimum stay :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['ninimum_stay']; ?> Days
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Maximum stay :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['maximum_stay']; ?> Days
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                }
                                ?>

                                

                                <?php if ($categoryRowset['availability'] == '3') { ?>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Booking Start Date :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['booking_start_date']; ?>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Booking End Date :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['booking_end_date']; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Minimum stay :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['ninimum_stay']; ?> Days
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Maximum stay :</label>
                                            <div class="col-md-4"><?php echo $categoryRowset['maximum_stay']; ?> Days
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                    if ($categoryRowset['guest_notice_period'] == '0') {

                                        $val = "Same Day (customizable cutoff hour)";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '1') {

                                        $val = "At least 1 Day's Notice";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '2') {

                                        $val = "At least 2 Day's Notice";
                                    }
                                    if ($categoryRowset['guest_notice_period'] == '1') {

                                        $val = "At least 3 Day's Notice";
                                    }
                                    ?>

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Advance notice :</label>
                                            <div class="col-md-4"><?php echo $val; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($categoryRowset['guest_notice_period'] == '0') {
                                        ?>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Guests can same-day instant book until :</label>
                                                <div class="col-md-4"><?php echo $categoryRowset['guest_time']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                <?php } ?>


                                <hr>

                                <h4 style="margin-left:10px;margin-top: 10px;"> Gallery</h4>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Image:</label>
                                        <div class="col-md-8">   
                                            <?php
                                            $propimage = mysql_query("select * from `estejmam_image` where `prop_id`='" . $categoryRowset['id'] . "'");
                                            while ($alliamge = mysql_fetch_array($propimage)) {
                                                if ($alliamge['image'] != '') {
                                                    ?>
                                                    <span class="input-xlarge">
                                                        <a class="fancybox-thumbs fancybox" data-fancybox-group="thumb" href="../upload/property/<?php echo $alliamge['image']; ?>" data-fancybox-group="gallery" title="" data-caption=""><img src="../upload/property/<?php echo $alliamge['image']; ?>" height="70" width="70" style="border:1px solid #666666" /></a>
                                                    </span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="input-xlarge"><img src="../upload/no.png" height="70" width="70" style="border:1px solid #666666" /></span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Property Video:</label>
                                        <div class="col-md-8">   
                                            
                                                    <span class="input-xlarge">
                                                         <video width="320" height="240" controls>
                                        <source src="../upload/prop_video/<?php echo $categoryRowset['video']; ?>" type="video/mp4">
                                    
                                    </video>
                                                
                                                 
                                        </div>
                                    </div>









  <div class="form-group">
                                        <label class="col-md-3 control-label">Floor plan Image:</label>
                                        <div class="col-md-8">   
                                            
                                           <?php
                                                if ($categoryRowset['floor_plan'] != '') {
                                                    ?>
                                                   
                                                     <span class="input-xlarge"><img src="../upload/floor_plan/<?php echo $categoryRowset['floor_plan']; ?>" height="70" width="70" style="border:1px solid #666666" /></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="input-xlarge"><img src="../upload/no.png" height="70" width="70" style="border:1px solid #666666" /></span>
                                              <?php   
                                            }
                                            ?>
                                        </div>
                                    </div>






                                   
                                   
                               
                                
                                   
                                   


                                </div>

                                <hr>

                                <div class="portlet-body">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs nav-tabs-lg">
                                            <li class="active">
                                                <h3 style="margin-left:10px;"> Details </h3>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <div class="row">



                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Basic Details
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">


                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Property Type : <?php echo $ptype['name'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">
                                                                    </div>
                                                                </div>


                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                       Landlord : <?php echo $user['fname'].' '.$user['lname'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>


                                                                    <div class="row static-info">
                                                                        <div class="col-md-5 name">
                                                                            Bed Type : <?php echo $categoryRowset['bed_type'] ?>
                                                                        </div>
                                                                        <div class="col-md-7 value">

                                                                        </div>
                                                                    </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        bedrooms : <?php echo $categoryRowset['bedrooms'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>



<?php
if($categoryRowset['bedrooms']==1)
{
    $bedtype="single";
}
 if($categoryRowset['bedrooms']==2)
{
    $bedtype="double";
}
 if($categoryRowset['bedrooms']==3)
{
    $bedtype="twin";
}
if($categoryRowset['bedrooms']==4)
{
    $bedtype="bank";
}
?>

                                                                <!--<div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Bed Type: <?php echo $bedtype; ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>-->
                                                                


<?php
if($categoryRowset['gender_type']==1)
{
    $onlyfor="males";
}
 if($categoryRowset['gender_type']==2)
{
    $onlyfor="females";
}

?>


                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Only For: <?php echo $onlyfor ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Not Included: <?php echo $categoryRowset['not_included'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                    Sutable for:
                                                                    <?php
                                                                    $sutablinfo = mysql_query("select * from `sutable_for` where `id` IN(".$categoryRowset['sutable_for'].")");
                                                                        while ($sut = mysql_fetch_array($sutablinfo)) {
                                                                            ?>


                                                                        <?php echo $sut['name'] ?>
                                                                       <?php
                                                                   }
                                                                   ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                     Minimum stay: <?php echo round($categoryRowset['ninimum_stay']/30) ?>Month
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Maximum stay: <?php echo round($categoryRowset['maximum_stay']/30) ?>Month
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                 <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Type of Contract: <?php echo $categoryRowset['type_of_contract'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>














                                                            </div>
                                                        </div>
                                                        
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Amenities
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        <h4>Common Amenities :</h4>
                                                                        <?php
                                                                        $dbcommon = $categoryRowset['amenities'];
                                                                        $dbexpcommon = explode(',', $dbcommon);
                                                                        $common = mysql_query("select * from `estejmam_amenities` where `id` IN(".$categoryRowset['amenities'].") and `type`='1' order by `id` DESC");
                                                                        while ($commanaminities = mysql_fetch_array($common)) {
                                                                            ?>
                                                                            <li style="margin-left:10px;"><?php echo $commanaminities['name'] ?></<li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>


                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        <h4>Additional Amenities :</h4>
                                                                        <?php
                                                                        $dbcommon = $categoryRowset['amenities'];
                                                                        $dbexpcommon = explode(',', $dbcommon);
                                                                        $common = mysql_query("select * from `estejmam_amenities` where `id` IN(".$categoryRowset['amenities'].") and `type`='2' order by `id` DESC");
                                                                        while ($commanaminities = mysql_fetch_array($common)) {
                                                                            ?>
                                                                            <li style="margin-left:10px;"><?php echo $commanaminities['name'] ?></<li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>



                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        <h4>Special Features :</h4>
                                                                        <?php
                                                                        $dbcommon = $categoryRowset['amenities'];
                                                                        $dbexpcommon = explode(',', $dbcommon);
                                                                        $common = mysql_query("select * from `estejmam_amenities` where `id` IN(".$categoryRowset['amenities'].") and `type`='3' order by `id` DESC");
                                                                        while ($commanaminities = mysql_fetch_array($common)) {
                                                                            ?>
                                                                            <li style="margin-left:10px;"><?php echo $commanaminities['name'] ?></<li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    


                                                    </div>





                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Address
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        Address : <?php echo $categoryRowset['street_addr'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>

                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Apt, Suite, Bldg : <?php echo $categoryRowset['apt_suit_blding'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>

                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Street : <?php echo $categoryRowset['street'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>

                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Country : <?php echo $country['name'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>



                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        State : <?php echo $states['name'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        City : <?php echo $cities['name'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>

                                                                <div class="row static-info">
                                                                    <div class="col-md-5 name">
                                                                        Zip : <?php echo $categoryRowset['zipcode'] ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                   


                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>Bills included
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        <h4>Bills included :</h4>
                                                                        <?php
                                                                        $dbcommon = $categoryRowset['amenities'];
                                                                        $dbexpcommon = explode(',', $dbcommon);
                                                                        $common = mysql_query("select * from `estejmam_bills_include` where `id` IN(".$categoryRowset['bills_include_id'].") order by `id` DESC");
                                                                        while ($commanaminities = mysql_fetch_array($common)) {
                                                                            ?>
                                                                            <li style="margin-left:10px;"><?php echo $commanaminities['name'] ?></<li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="portlet blue-hoki box">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs">Apartment features</i>
                                                                </div>
                                                                <div class="actions">

                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">

                                                                <div class="row static-info">
                                                                    <div class="col-md-12 name">
                                                                        <h4>Apartment features:</h4>
                                                                        <?php
                                                                        $dbcommon = $categoryRowset['amenities'];
                                                                        $dbexpcommon = explode(',', $dbcommon);
                                                                        $common = mysql_query("select * from `estejmam_apartment_feature` where `id` IN(".$categoryRowset['apartment_feature_id'].") order by `id` DESC");
                                                                        while ($commanaminities = mysql_fetch_array($common)) {
                                                                            ?>
                                                                            <li style="margin-left:10px;"><?php echo $commanaminities['name'] ?></<li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <div class="col-md-7 value">

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    



                                                    



                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <!--<button type="submit" class="btn blue"  name="submit">Submit</button>-->
                                            <button type="reset" class="btn blue" onClick="window.location.href = 'list_product.php'" style="margin-left: 150px">Back</button>
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
    <?php //include('includes/quick_sidebar.php');           ?>
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

    jQuery(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>


<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script type="text/javascript">
    $(document).ready(function () {

        $('.fancybox').fancybox();

    });


</script>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
