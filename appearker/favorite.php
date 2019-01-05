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

$user_id = $_SESSION['user_id'];
//echo "SELECT * FROM `estejmam_booking` ,`estejmam_user`,`parking` WHERE `estejmam_user`.`id`= `estejmam_booking`.`user_id` AND `parking`.`id`=`estejmam_booking`.`prop_id` AND `estejmam_booking`.`user_id`=".$user_id." AND `estejmam_booking`.`end_date`>='".date('Y-m-d')."'";
$get_booking = mysqli_query($link,"SELECT * FROM `estejmam_favourite_property` ,`parking` WHERE `parking`.`id`=`estejmam_favourite_property`.`prop_id` AND `estejmam_favourite_property`.`user_id`=$user_id");




?>


<section class="message-body">
        <div class="container">
            <div class="row">
                <?php //include("include/sidebar.php");?>
                <div class="col-md-12">
                    <div class="my-properties">
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
                        <?php while($booking_row = mysqli_fetch_object($get_booking)){ 
                            
                          // print_r($booking_row);
                            if($booking_row->image != ""){
                                $parking_image = "./upload/parking/".$booking_row->image;
                            }else{
                            
                               $parking_image = "./upload/noimage.Jpeg"; 
                            }
                            
                            ?>
                        <div class="media pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid"  src="<?php echo $parking_image; ?>" alt="">
                            </div>
                            
                            <div class="media-body">
                                <h6 class="mt-2"><?php echo $booking_row->name; ?></h6>   
                                <p class="mb-0"> <i class="ion-location mr-1"></i><?php echo $booking_row->address; ?></p>
                                <p><i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="far fa-star booking-his-star"></i></p>
                                <button type="button" class="btn btn-primary entry-dt">Entry date: <?php echo date('F j, Y',strtotime($booking_row->start_date)); ?></button>
                            
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <h5 class="mt-2" ></h5>
                                <!--<h4 class="book-his-price"><?php echo $booking_row->order_id; ?></h4>-->
                                <h4 class="book-his-price mb-4" ></h4>
                                                                    
                                <button type="button" class="btn btn-primary entry-dt" style="margin-top: 45px;">Exit date: <?php echo date('F j, Y',strtotime($booking_row->end_date)); ?></button>
                            </div>
                        </div>
                        <?php } ?> 

<!--                        <div class="media pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/booking-his-b.png" alt="">
                            </div>
                        
                            <div class="media-body">
                                <h6 class="mt-2">City Center 2, Newtown</h6>
                                <p class="mb-0">
                                    <i class="ion-location mr-1"></i>1241 Newtown, Rajarhat, kolkata, <br> West bengal</p>
                                <p>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="far fa-star booking-his-star"></i>
                                </p>
                                <button type="submit" class="btn btn-primary entry-dt">Entry date: 12-6-18</button>
                        
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <button type="button" class="btn btn-outline-primary rate-renter mb-5">Rate Renter</button>
                        
                                <h4 class="book-his-price">$15/m</h4>
                        
                                <button type="submit" class="btn btn-primary entry-dt">Exit date: 14-6-18</button>
                            </div>
                        </div>

                        <div class="media pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/booking-his-c.png" alt="">
                            </div>
                        
                            <div class="media-body">
                                <h6 class="mt-2">City Center 2, Newtown</h6>
                                <p class="mb-0">
                                    <i class="ion-location mr-1"></i>1241 Newtown, Rajarhat, kolkata, <br> West bengal</p>
                                <p>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="fas fa-star booking-his-star"></i>
                                    <i class="far fa-star booking-his-star"></i>
                                </p>
                                <button type="submit" class="btn btn-primary entry-dt">Entry date: 12-6-18</button>
                        
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <button type="button" class="btn btn-outline-primary rate-renter mb-5">Rate Renter</button>
                        
                                <h4 class="book-his-price">$15/m</h4>
                        
                                <button type="submit" class="btn btn-primary entry-dt">Exit date: 14-6-18</button>
                            </div>
                        </div>-->

<ul class="pagination mt-5 mb-0 justify-content-center" style="display:none">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">5</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>