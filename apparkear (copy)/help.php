<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>

<section class="baner mt-5 pt-4">
    <div class="baner-img" style="background: url(./upload/sitebanner/help.jpg) no-repeat;min-height: 300px;
    opacity: 0.6;background-size: cover;">
        <div class="container text-center pt-4">
            <div class="baner-text text-bg">
                <h1 class="mb-0"><b>Help</b></h1>
            </div>
        </div>
    </div>
</section>

<section class="help">
    <div class="">
        <div class="help text-center">
            <h2 class="d-block white-text">How can we help?</h2>
            <form class="example" action="/action_page.php"                 style="margin:auto;max-width:40%">
                <input type="text" placeholder="Search..." name="search2">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</section>

<div class="light-bg">
<section class="help-box container">
    <div class="row py-5">

        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Important Updates</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Parking With Us</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Need More Help</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>
        
        <div class="col-md-6 renter" data-toggle="collapse" data-target="#Renter" style="cursor:pointer;">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Renter</h4>
            </div>
        </div>

        <div class="col-md-6 owner" data-toggle="collapse" data-target="#Owner" style="cursor:pointer;">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Owner</h4>
            </div>
        </div>
       
        <div class="col-md-12 renterpage collapse" id="Renter">
            <div class="help-bg p-4 text-center my-3">
                <div class="accordion text-left" id="accordionExample">
                  <?php
                  $number = 1;
                  $get_renterfaq  = mysqli_query($link,"SELECT * FROM `estejmam_faq` WHERE `category`=1");
                  while($row = mysqli_fetch_object($get_renterfaq)){
                  $question = $row->quns;
                  $answer = $row->uns;
                  ?>
                  <div class="card faq">
                    <div class="card-header" id="heading<?php echo $number; ?>">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $number; ?>" aria-expanded="false" aria-controls="collapse<?php echo $number; ?>">
                          <?php echo $question; ?>
                        </button>
                      </h5>
                    </div>

                    <div id="collapse<?php echo $number; ?>" class="collapse" aria-labelledby="heading<?php echo $number; ?>" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer; ?>
                      </div>
                    </div>
                  </div>
                  <?php $number++; } ?>
                  
                </div>

            </div>
        </div>
        <div class="col-md-12 ownerpage collapse" id="Owner">
            
            <div class="help-bg p-4 text-center my-3">
                <div class="accordion text-left" id="accordionExample">
                  <?php
                  $numbers = 30;
                  $get_ownaefaq  = mysqli_query($link,"SELECT * FROM `estejmam_faq` WHERE `category`=2");
                  while($row2 = mysqli_fetch_object($get_ownaefaq)){
                  $question2 = $row2->quns;
                  $answer2 = $row2->uns;
                  ?>
                  <div class="card faq">
                    <div class="card-header" id="heading<?php echo $numbers; ?>">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $numbers; ?>" aria-expanded="false" aria-controls="collapse<?php echo $numbers; ?>">
                          <?php echo $question2; ?>
                        </button>
                      </h5>
                    </div>

                    <div id="collapse<?php echo $numbers; ?>" class="collapse" aria-labelledby="heading<?php echo $numbers; ?>" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer2; ?>
                      </div>
                    </div>
                  </div>
                  <?php $numbers++; } ?>
                  
                </div>
            </div>
            
        </div>

    </div>
</section>
</div>

<?php
include "include/footer.php";
?>

<?php //include('include/header.php');
//$cmspageDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id =54"));
?>

<!--<div class="container-fluid">
	<div class="help-banner">
		<img src="images/faqs-banner.jpg"/>
	</div>
</div>-->

<!--<section class="help-banner" style="background:url(<?php echo SITE_URL;  ?>upload/sitebanner/<?php echo $cmspageDetails->image; ?>);background-size: cover; height: 330px;"></section>
    <?php
		$cmspageDetails1 = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_cms WHERE id =54"));

    if($cmspageDetails1!=''){
    	if($lang=='esp'){
        	echo $cmspageDetails1->spainsh_content;
        }elseif($lang=='ita'){
        	echo $cmspageDetails1->italian_content;
        }elseif ($lang=='fre') {
        	echo $cmspageDetails1->french_content;
        }elseif($lang=='por'){
        	echo $cmspageDetails1->portu_content;
        }elseif ($lang=='dch') {
        	echo $cmspageDetails1->duch_content;
        }elseif($lang=='rus'){
        	echo $cmspageDetails1->russian_content;
        }elseif ($lang=='chi') {
        	echo $cmspageDetails1->chinese_content;
        }else{
        	echo $cmspageDetails1->pagedetail;
        }
    }else{
        echo 'No data found';
    }
    ?>
<style>
 p:first-child {
    font-size: 16px !important;
    font-weight: 600 !important;
}
</style>-->

<?php //include('include/footer.php'); ?>

<!--<script src="js/jquery-1.9.1.min.js"></script>
<script src='js/jquery.scrollto.js'></script>-->
