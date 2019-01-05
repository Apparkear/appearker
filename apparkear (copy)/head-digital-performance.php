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

<div class="container">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<h1 class="text-center">Head of Digital Performance</h1>
		</div>
	</div>

	<div class="bookedHome how_work_div">
		<div class="row">
			<div class="col-md-12 col-sm-12">

				<div class="text_half_work">
					<div class="avalaiblecities">
						<h4><b class="colorred">WHO WE ARE?</b></h4>
						<ul>
							<li>Roomarate is an online marketplace that offers everyone in the world the most complete local listings, allowing potential newcomers to securely book medium and long term accommodation online before arriving to a new city.</li>
							<li>We are one of the hottest and fastest growing startups in Europe. Since 2014, we have expanded nationwide in Spain, UK, France, Belgium, Ireland, Italy, Germany and Austria. Our aim is to disrupt the business model of rented properties in Europe.</li>
							<li>We have customers from all over the globe. With Roomarate, the world is yours. We are backed by top VCS from Silicon Valley and UK including the backers of Trivago acquired by Expedia in 2013, the people behind Momondo Group, Last.fm, Seedcamp, Last Second Tickets, among others.</li>
							<li>Our headquarters are based in Madrid, Spain, where we count with an international and highly motivated team of 150 professionals in the online and real estate business.</li>

						</ul>
					</div>
					<div class="avalaiblecities">
						<h4><b class="colorred">JOB SUMMARY</b></h4>
						<p>A fantastic opportunity for a results-focussed marketer to join our expanding marketing team. Due to our recent rapid growth, we're on the lookout for an experienced and driven Head of Digital Performance Marketing based in Madrid, and with a love for numbers and proven commercial acumen. The role will report directly to the CMO, and draw on your skills leading the team, managing resources in digital media, online performance marketing, performance SEO and eCRM activity.</p>

                        <p>Managing the online media budget, you will have the responsibility to deliver value and ROI from our SEM, Social Media Ads, Display and Affiliate programs. Also motivate and manage our SEO expert, ensuring that non brand organic traffic grows and that information is fluent between Marketing and Tech. Through diligent management of external agencies and internal resource, coupled with focussed execution of campaign and channel activity, this important role will contribute significantly to Roomarate achieving its key goals.</p>

                        <p>The ideal candidate will be working closely with Tech, in order to ensure the correct implementation of tracking and attribution tools, and with BI to create a top class performance dashboard and an optimum attribution model that will help allocate the investment. You will also have the responsibility of hiring a eCRM Manager and start building the global function. Our goal is to ensure that Roomarate Performance Marketing is cutting edge in the industry.</p>

                        <p>You may have been performing a commercial digital performance role, or other results-focussed online marketing role. High specialization in SEM or paid media, and experience launching and managing campaigns across different European countries (UK, France, Spain and Italy) will be valued.</p>
					</div>

					<div class="avalaiblecities">
						<h4><b class="colorred">RESPONSABILITIES </b></h4>
						<ul>
							<li>The exceptional delivery and optimization of our SEM, Social Media Ads, Affiliate and Display activity.</li>
							<li>Excellent optimization of our SEO onsite, link building and content, ensuring that plans are well coordinated with the regional brand managers and Tech.</li>
							<li>Build the Global eCRM function that will work on the basic activation and retention strategy across markets, and provide the regional brand managers with a powerful tool for brand content email and push notification marketing.</li>
							<li>Creation of attribution models, both by platform and from a wider acquisitions perspective.</li>							<li>Produce and manage a clear testing plan, with a focus on continual evolution across campaign channels.</li>
							<li>Analyze campaign and cross channel effectiveness, reporting back to the business in a concise manner.</li>
							<li>Act as the Marketing team's reporting evangelist and key insight stakeholder, assuming the role of Data Warehouse Marketing Super-user.</li>
							<li>Build, lead, motivate and support the PPC, SEO, Affiliate and eCRM team.</li>
							<li>Harness key relationships with Tech, BI, and local brand managers to ensure consistency of message and a coherent communications plan.</li>

						</ul>
					</div>
					<div class="avalaiblecities">
						<h4><b class="colorred">DESIRE SKILLS</b></h4>
						<ul>
							<li>A strong understanding of online marketing coupled with excellent numerical / analytical ability.</li>
							<li>Core skills in search - both paid and organic.</li>
							<li>Experience in display and retargeting - knowledge of RTB buying across both mobile and desktop.</li>
							<li>Strong relationship management skills.</li>

							<li>Proven ability to optimise media agency relationships.</li>
							<li>Experience of media planning across a broad online mix.</li>
							<li>Experience of working in e-commerce environment.</li>
							<li>Strong communication and presentation skills.</li>
							<li>The ability to translate complex data sets into simple-to-understand terms and reports.</li>
							<li>Ability to think strategically, combining long-term and short-term plans into clear goals and objectives.</li>
							<li>Able to work to tight deadlines, and deliver within agreed timeframes.</li>

						</ul>
					</div>

					<div class="avalaiblecities">
						<h4><b class="colorred">IDEAL CANDIDATE PROFILE</b></h4>
						<ul>
							<li>Highly analytical and inquisitive</li>
							<li>Creative, innovative and capable of making a difference</li>
							<li>Decisive, resilient and personable</li>
							<li>Positive can do attitude</li>

							<li>Good organisational and time management skills</li>
						</ul>
					</div>
					<div class="avalaiblecities">
						<p class="text-center">If you think that this is the job for you, send your CV to <a href="#"></a> with subject line <b>Head of Digital Performance!</b>
Come join the ride.</p>
					</div>
				</div>
				<a onclick="location.href='cms.php?name=work-with-us'">Return to Jobs</a>
			</div>

			<!-- <div class="col-md-6 col-sm-6   hidden_img text-center">
				<div class="big_img_half_work"><img class="img-responsive" src="images/hb1.png" style="margin:0 auto" /></div>
			</div> -->
		</div>
	</div>
</div>

<footer>
    <section class="footer_top">
        <div class="container">
            <ul>
                <li><a href="<?php echo $fb->link; ?>" class="fa fa-facebook" target="_blank"></a></li>
                <li><a href="<?php echo $tw->link; ?>" class="fa fa-twitter" target="_blank"></a></li>
                <li><a href="<?php echo $ytube->link; ?>" class="fa fa-youtube" target="_blank"></a></li>
                <li><a href="<?php echo $pinterest->link; ?>" class="fa fa-pinterest" target="_blank"></a></li>
                <li><a href="<?php echo $vk->link; ?>" class="fa fa-vk" target="_blank"></a></li>
                <li><a href="<?php echo $insta->link; ?>" class="fa fa-instagram" target="_blank"></a></li>
            </ul>
        </div>
    </section>
    <section class="footer_bottom">
        <div class="container">
            <div class="row">

                <?php
                $fcat = mysql_query("select * from `estejmam_footer_category` where 1 order by `id` ASC");
                if (mysql_num_rows($fcat) > 0) {
                    while ($allfcat = mysql_fetch_object($fcat)) {
                        ?>
                        <div class="col-md-3">
                            <b><?php echo $allfcat->name; ?></b>
                            <?php
                            $sub = mysql_query("select * from `estejmam_cms` where `footer_category_id`='" . $allfcat->id . "' order by `id` ASC");
                            while ($sub1 = mysql_fetch_object($sub)) {
                                ?>
                                <a onclick="location.href = 'cms.php?name=<?php echo $sub1->slug ?>'" style="cursor:pointer;"><?php echo $sub1->title ?></a>
                            <?php } ?>

                             <a onclick="location.href = 'partners.php'" style="cursor:pointer;">PARTNERS</a>

                        </div>

                        <?php
                    }
                }
                ?>

                <!--                <div class="col-md-3">
                                    <b>Tenants</b>
                                    <a href="">How it works</a>
                                    <a href="">Blog</a>
                                    <a href="">Help</a>
                                    <a href="">Promotions</a>
                                    <a href="">Contact Us</a>
                                </div>

                                <div class="col-md-3">
                                    <b>Landlords</b>
                                    <a href="">Publish your property</a>
                                    <a href="">Help</a>
                                    <a href="">Contact Us</a>
                                </div>-->


                <div class="col-md-3">
                    <!--                    <b>English</b>-->
                    <button class="btn"><?php echo $logo->footer_button_text ?></button>
                    <p><?php echo $logo->footer_help_center ?><br/>
                        <?php echo $logo->footer_coustomer_support_text ?><br/>
                        <?php echo $logo->site_phone ?><br/>
                        <?php echo $logo->site_email ?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="copy_right">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>�2017 Roomerate � All rights reserved</p>
                    <span>Design & Developed by: NatIt Solved Pvt. Ltd.</span>
                </div>
                <div class="col-md-6">
                    <img src="upload/payment_logo/<?php echo $paymentlogo->image ?>" alt="" class="pull-right"/>
                </div>
            </div>
        </div>
    </section>
</footer>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script>
    $('.bxslider').bxSlider({
    });


    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.navbar-fixed-top').css('background', 'rgba(0,0,0,.8)');
        }
        else {
            $('.navbar-fixed-top').css('background', 'none');
        }
    });
    $(document).on('click', 'a', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });


</script>
