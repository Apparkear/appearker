<?php include('include/header.php'); ?>
<?php
$banner = mysql_fetch_object(mysql_query("select * from `estejmam_banner` where 1 order by `id` DESC LIMIT 1"));

$bannerVideo = mysql_fetch_object(mysql_query("select * from `estejmam_video_banner` where 1 order by `id` DESC LIMIT 1"));

$bannerType = mysql_fetch_object(mysql_query("select * from `estejmam_banner_type` where 1 order by `id` DESC LIMIT 1"));
//print_r($bannerType);exit;
$site_settings = mysql_fetch_object(mysql_query("select * from `estejmam_sitesettings` where `id`='1'"));

if($bannerType->banner_type==1){
    if ($banner->image != '') {
        $banner_image = "upload/sitebanner/" . $banner->image;
    } else {
        $banner_image = "upload/noImageFound.jpg";
    }
}else{
    //$banner_image = "upload/video_banner/".$bannerVideo->video;
    $banner_image = "upload/video_banner/";
}
?>
<style type="text/css">
    .newbannerBack{
        width: 80%!important;
    }
</style>
<section class="banner" style="background:url('<?php echo $banner_image; ?>') no-repeat; position:relative; background-color: #515561; overflow:hidden; height:600px;">

<?php
 if($bannerType->banner_type==2){ ?>


    <video width="100%" loop autoplay muted>
        <source src="<?php echo $banner_image.'london_720p.mp4' ?>" type="video/mp4">
        <source src="<?php echo $banner_image.'london_720p.ogv' ?>" type="video/ogv">
        <source src="<?php echo $banner_image.'london_720p.webm' ?>" type="video/webm">
        Your browser does not support HTML5 video.
     </video>

     <div class="bannerBack newbannerBack" style="width:80%; position:absolute; left:10%; top:30%; z-index:999">
     
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center"><?php echo $banner->name; ?></h2>
                    <p class="text-center"><?php echo $banner->description; ?></p>
                    <form action="search-listing.php" method="GET" name="searchform" id="searchform" class="searchform">
                        <div class="what_looking_back">
                            <div class="lookingfor">
                                <ul>
                                    <li  class="selectFormField">
                                        <div class="form-group">
                                            <select class="form-control selectfield" id="cities" name="cities">
                                                <?php
                                                $homecities = mysql_query("select * from `cities` where `is_featured`='1' order by `id` DESC");
                                                if (mysql_num_rows($homecities) > 0) {
                                                    while ($allcitieshome = mysql_fetch_object($homecities)) {
                                                        ?>
                                                        <option value="<?php echo $allcitieshome->name ?>"><?php echo $allcitieshome->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <i class="fa fa-map-marker"></i>

                                        </div>
                                    </li>
                                    <li class="dateIn">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="datetimepicker"  placeholder="Date In ">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                    </li>
                                    <li class="dateIn border-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="usr" placeholder="Date Out">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                            <div class="button">
                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="videoTour">
                        <ul>
                            <li>
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-ios-videocam-outline"></i></div>
                                    <p>Video Tour </p>
                                </a>
                            </li>

                            <li>
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-map"></i></div>
                                    <p>Floor Plan</p>
                                </a>
                            </li>

                            <li class="complete">
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-ios-home-outline"></i></div>
                                    <p>Personally Checked</p>
                                </a>
                            </li>

                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </div>
            </div>
     </div>
    
<?php } else { ?>

    <div class="bannerBack" style="background:url('images/backgroundImage.png') no-repeat center top;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center"><?php echo $banner->name; ?></h2>
                    <p class="text-center"><?php echo $banner->description; ?></p>
                    <form action="search-listing.php" method="GET" name="searchform" id="searchform" class="searchform">
                        <div class="what_looking_back">
                            <div class="lookingfor">
                                <ul>
                                    <li  class="selectFormField">
                                        <div class="form-group">
                                            <select class="form-control selectfield" id="cities" name="cities">
                                                <?php
                                                $homecities = mysql_query("select * from `cities` where `is_featured`='1' order by `id` DESC");
                                                if (mysql_num_rows($homecities) > 0) {
                                                    while ($allcitieshome = mysql_fetch_object($homecities)) {
                                                        ?>
                                                        <option value="<?php echo $allcitieshome->name ?>"><?php echo $allcitieshome->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <i class="fa fa-map-marker"></i>

                                        </div>
                                    </li>
                                    <li class="dateIn">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="datetimepicker"  placeholder="Date In ">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                    </li>
                                    <li class="dateIn border-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="usr" placeholder="Date Out">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                            <div class="button">
                                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="videoTour">
                        <ul>
                            <li>
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-ios-videocam-outline"></i></div>
                                    <p>Video Tour </p>
                                </a>
                            </li>

                            <li>
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-map"></i></div>
                                    <p>Floor Plan</p>
                                </a>
                            </li>

                            <li class="complete">
                                <a href="#hyper"><div class="videoPart"><i class="icon ion-ios-home-outline"></i></div>
                                    <p>Personally Checked</p>
                                </a>
                            </li>

                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

</section>

<?php
    
    $internship_faq = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id =24"));
    
    if($internship_faq!=''){
        echo $internship_faq->pagedetail;
    }else{
        echo 'No data found';
    }
 ?>
<?php include('include/footer.php'); ?>