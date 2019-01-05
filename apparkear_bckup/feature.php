<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 
if($_SESSION['user_id'] == ''){  
   $location = SITE_URL;
    header("Location:index.php");
  //  exit;
} 

/*************************Header********************************/
include("include/header.php");

?>


<section class="featured mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="message">
          <?php
          $result = mysqli_query($link,"SELECT * FROM `estejmam_feature` WHERE status=1 ORDER BY id DESC");
          //print_r($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_object($result)) {
            $name = $row->name;
            $description = $row->description;
            $img = $row->feature_image;
            $image = $SITE_URL.'upload/featureimg/'.$img;
            ?>
            <div class="media bottom-border m-3 feature-img">
              <img class="mr-4 rounded-circle" src="<?php echo $image; ?>" alt="Generic placeholder image" class="">
              <div class="media-body">
                <h4 class="mt-0"><?php echo $name; ?></h4>
                <p><?php echo $description; ?></p>
                <div class="bottom d-flex">
                  <i class="fas fa-star booking-his-star"></i><i class="fas fa-star booking-his-star"></i><i class="far fa-star booking-his-star"></i><i class="far fa-star booking-his-star"></i><i class="far fa-star booking-his-star"></i>
                </div>
              </div>
              <div class="arrow-sign mt-4">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          <?php }
          } ?>

          <!-- <div class="media bottom-border m-3">
            <img class="mr-4 rounded-circle" src="./images/auto-care.png" alt="Generic placeholder image" class="">
            <div class="media-body">
              <h4 class="mt-0">Auto Care</h4>
              <p>Lorem fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              <div class="bottom d-flex">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
              </div>
            </div>
            <div class="arrow-sign mt-4">
              <i class="fas fa-chevron-right"></i>
            </div>
          </div>

          <div class="media bottom-border m-3">
            <img class="mr-4 rounded-circle" src="./images/car-insurance.png" alt="Generic placeholder image" class="">
            <div class="media-body">
              <h4 class="mt-0">Insurance</h4>
              <p>Lorem fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              <div class="bottom d-flex">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
              </div>
            </div>
            <div class="arrow-sign mt-4">
              <i class="fas fa-chevron-right"></i>
            </div>
          </div>

          <div class="media bottom-border m-3">
            <img class="mr-4 rounded-circle" src="./images/towing.png" alt="Generic placeholder image" class="">
            <div class="media-body">
              <h4 class="mt-0">Towing Service</h4>
              <p>Lorem fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              <div class="bottom d-flex">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
              </div>
            </div>
            <div class="arrow-sign mt-4">
              <i class="fas fa-chevron-right"></i>
            </div>
          </div> -->

        </div>
      </div>
    </div>
  </div>
</section>




<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>