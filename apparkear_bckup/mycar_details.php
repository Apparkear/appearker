<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 
if($_SESSION['user_id'] == ''){  //echo "vkjfkfj";exit;
   $location = SITE_URL;
    header("Location:index.php");
  //  exit;
} 

/*************************Header********************************/
include("include/header.php");
?>

<section class="message-body">
<div class="container">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <div class="my-properties">
            <h4 class="text-center active-text mb-4">Car Details</h4>
                        <div class="media pt-2 pb-2">
                            <div class="car-pic align-self-center mr-3">
                                <img class="img-fluid"  src="./upload/parking/car-img1.png" alt="">
                            </div>
                            <div class="media-body">
                                <h5 class="mt-2"><b>Mercedes-Benz CLS II (W218) 350 CDI</b></h5> 
                                <h6>BLACK COUPE, 4 SEATS, 4/5 DORS, V12, EURO6, 18'' WHEEL SIZE</h6>  
                                <p><b>Car Owner no:</b> +102 091823098 mobile</p>
                                <p class="mb-0"> <i class="ion-location mr-1"></i>126km/hr</p>
                                <p><i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="far fa-star booking-his-star"></i></p>
                                <p></p>                           
                            </div>
                        </div>
                        <div class="media pt-2 pb-2">
                            <div class="car-pic align-self-center mr-3">
                                <img class="img-fluid"  src="./upload/parking/car-img2.png" alt="">
                            </div>
                            <div class="media-body">
                                <h5 class="mt-2"><b>Mercedes-Benz CLS II (W218) 350 CDI</b></h5> 
                                <h6>BLACK COUPE, 4 SEATS, 4/5 DORS, V12, EURO6, 18'' WHEEL SIZE</h6>  
                                <p><b>Car Owner no:</b> +102 091823098 mobile</p>
                                <p class="mb-0"> <i class="ion-location mr-1"></i>126km/hr</p>
                                <p><i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="far fa-star booking-his-star"></i></p>
                                <p></p>                           
                            </div>
                        </div>
                        <div class="media pt-2 pb-2">
                            <div class="car-pic align-self-center mr-3">
                                <img class="img-fluid"  src="./upload/parking/car-img3.png" alt="">
                            </div>
                            <div class="media-body">
                                <h5 class="mt-2"><b>Mercedes-Benz CLS II (W218) 350 CDI</b></h5> 
                                <h6>BLACK COUPE, 4 SEATS, 4/5 DORS, V12, EURO6, 18'' WHEEL SIZE</h6>  
                                <p><b>Car Owner no:</b> +102 091823098 mobile</p>
                                <p class="mb-0"> <i class="ion-location mr-1"></i>126km/hr</p>
                                <p><i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="far fa-star booking-his-star"></i></p>
                                <p></p>                           
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary mr-2">Next</a>
                            <a href="#" class="btn btn-primary">Back</a>
                        </div>
            </div>
        </div>
    </div>
</div>
</section>

<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>