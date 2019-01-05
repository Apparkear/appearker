<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: index.php");
    
}

include("include/header.php");
 ?>
<?php 
if($_SESSION['user_id'] == ''){  //echo "vkjfkfj";exit;
   $location = SITE_URL;
    header("Location:".$location);
  //  exit;
}

$user_id = $_SESSION['user_id'];

$get_properties = mysqli_query($link,"SELECT * FROM `parking` WHERE `user_id`=$user_id order by `id` DESC limit 5");
$my_properties = mysqli_query($link,"SELECT * FROM `parking` WHERE `user_id`=$user_id AND `status`=1 ORDER BY `id` DESC limit 5");
//while($prop_row = mysqli_fetch_object($my_properties)){
//    print_r($prop_row);
//}


$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`=$user_id"));
if($get_user_details->image != ""){
    $user_image = "./upload/user_image/".$get_user_details->image;
}else{
    $user_image = "./upload/nouser.png";
}

$get_booking = mysqli_query($link,"SELECT * FROM `estejmam_booking` join `estejmam_user` ON `estejmam_user`.`id`= `estejmam_booking`.`user_id` WHERE `estejmam_booking`.`uploder_user_id`=".$user_id." AND `estejmam_booking`.`end_date`>='".date('Y-m-d')."'");

$review_array = array();
$count = 0;
while($parking_row = mysqli_fetch_object($get_properties)){
   // print_r($parking_row);
    
    //echo "SELECT * FROM `estejmam_property_review` WHERE `prop_id`=$parking_row->id";eit;
    $get_val = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_property_review` join `estejmam_user` ON `estejmam_user`.`id`= `estejmam_property_review`.`user_id` WHERE `prop_id`=$parking_row->id" ));
    if(!empty($get_val)){
        $review_array[$count] = $get_val;
        $count++;
    }
}
//echo "--------------------";
//print_r($review_array);

//while($row = mysqli_fetch_object($get_booking)){
//    print_r($row);
//}

?>

<section class="message-body">
        <div class="container">
            <div class="row">
                
                <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <div class="message">
                        
                        <div class="media">
                          <img class="mr-4 rounded-circle" src="<?php echo $user_image; ?>" alt="Generic placeholder image" style="height: 155px;width: 155px;">
                          <div class="media-body">
                            <h5 class="mt-0"><?php echo $get_user_details->fname.' '.$get_user_details->lname; ?> </h5>
                            <?php if($_SESSION['user_type'] == 0){ ?>
                            <a class="btn-primary float-right" href="editprofile.php">Edit</a>
                            <?php }else{ ?>
                            <a class="btn-primary float-right" href="renter_edit_profile.php">Edit</a>
                            <?php } ?>
                            <div class="bottom d-flex">
                                <i class="fas fa-map-marker-alt"></i><p><?php echo $get_user_details->address; ?></p>
                               
                            </div>
                            <p><?php echo $get_user_details->about_me; ?></p>
                            
                          </div>
                        </div>
                        <?php if($_SESSION['user_type'] == 0){ ?>
                        <div class="dashboard">
                            <h5>My Properties</h5>
                            <?php while($row_prop = mysqli_fetch_object($my_properties)){ 
                                
                                $get_image_array = mysqli_query($link, "SELECT * FROM `parking_images` WHERE `parking_id`={$row_prop->id}");
                                if ($row->image == '') {

                                    if(count($get_image_array)>=1){
                                        while($row_image_get = mysqli_fetch_object($get_image_array)){
                                            $img_parking = './upload/parking/' . $row_image_get->image;
                                            break;
                                        }

                                    }else{
                                        $img_parking = './upload/noimage.Jpeg';
                                    }
                                } else {
                                    $img_parking = './upload/parking/' . $row->image;
                                }
                                
                                
//                                if ($row_prop->image == '') {
//                                    $img_parking = './upload/noimage.Jpeg';
//                                } else {
//                                    $img_parking = './upload/parking/' . $row_prop->image;
//                                }
                                ?>
                            <div class="dash-sec row mb-3">
                                <div class="col-md-2">
                                    <img src="<?php echo $img_parking; ?>" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <h6><?php echo $row_prop->name; ?></h6>
                                    <p>Car Type: <?php if($row_prop->car_type == 's'){  ?>Small<?php }elseif($row_prop->car_type == 'm'){ ?>Medium<?php }elseif($row_prop->car_type == 'l'){ ?>Large<?php }else{ ?>Extra Large<?php } ?></p>
                                    <p><i class="far fa-calendar mr-1"></i>Available from 22nd March 2018</p>
                                    <p><i class="fas fa-map-marker-alt mr-1"></i><?php echo $row_prop->address;  ?></p>
                                </div>
                                <div class="col-md-2 icon">
                                    <h3><?php if($row_prop->currency == 'usd'){ ?>$<?php } ?><?php echo $row_prop->price; ?></h3>
<!--                                    <i class="far fa-edit"></i>
                                    <i class="ion-ios-close-empty ml-2"></i>-->
                                </div>
                            </div>
                            <?php } ?>
<!--                            <div class="dash-sec row">
                                <div class="col-md-2">
                                    <img src="images/dash-img.png" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <h6>Trisa Appartment near Kolkata</h6>
                                    <p>Car Type: SUB</p>
                                    <p><i class="far fa-calendar mr-1"></i>Available from 22nd March 2018</p>
                                    <p><i class="fas fa-map-marker-alt mr-1"></i>Baguiati, Kolkata - 700059</p>
                                </div>
                                <div class="col-md-2 icon">
                                    <h3>$100.00</h3>
                                    <i class="far fa-edit"></i>
                                    <i class="ion-ios-close-empty ml-2"></i>
                                </div>
                            </div>-->
                            
                        </div>
                        <?php } ?>
                        
                        <div class="dashboard">
                            <h5>Recent Booking</h5>
                            <?php while($row_booking = mysqli_fetch_object($get_booking)){
                                if($row_booking->image != ""){
                                    $image_logggedin = './upload/user_image/'.$row_booking->image;
                                }else{
                                    $image_logggedin = "./upload/nouser.png";
                                }
                                //print_r($row_booking);
                             ?>
                            <div class="dash-sec row mb-3 dash-img">
                                <div class="col-md-2">
                                    <img class="mr-4 rounded-circle" src="<?php echo $image_logggedin; ?>" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-8">
                                    <h6><?php echo $row_booking->fname." ".$row_booking->lname; ?></h6>
                                    <p>Car Type: SUB</p>
                                    <p><i class="far fa-calendar mr-1"></i>Available from <?php echo date('F j, Y', strtotime($row_booking->end_date. ' + 1 days')); ?></p>
                                    <p><i class="fas fa-map-marker-alt mr-1"></i><?php if($row_booking->address){ echo $row_booking->address; }else{ echo "Kolkata, West Bengal"; }  ?></p>
                                </div>
                                <div class="col-md-2 icon">
                                    <p>Bill Ammount</p>
                                    <h3>$ <?php echo $row_booking->price; ?></h3>
                                    
                                </div>
                            </div>
                            <?php } ?>
<!--                            <div class="dash-sec row">
                                <div class="col-md-2">
                                    <img class="mr-4 rounded-circle" src="images/message-img2.png" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-8">
                                    <h6>John Doe</h6>
                                    <p>Car Type: SUB</p>
                                    <p><i class="far fa-calendar mr-1"></i>Available from 22nd March 2018</p>
                                    <p><i class="fas fa-map-marker-alt mr-1"></i>Baguiati, Kolkata - 700059</p>
                                </div>
                                <div class="col-md-2 icon">
                                    <p>Bill Ammount</p>
                                    <h3>$100.00</h3>
                                    
                                </div>
                            </div>-->
                            
                        </div>
                        
                        <div class="dashboard">
                            <h5>Reviews</h5>
                            <?php if(!empty($review_array)){ 
                                
                                foreach($review_array as $key => $val){
                                      
                                    if($val->image){
                                        $image_usr = "./upload/user_image/".$val->image;
                                    }else{
                                        $image_usr ='./upload/nouser.png';
                                    }
                                    
                                ?>
                            <div class="dash-sec row mb-3 dash-img">
                                <div class="col-md-2">
                                    <img class="mr-4 rounded-circle" src="<?php echo $image_usr; ?>" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-10">
                                    <h6><?php echo $val->fname." ".$val->lname; ?></h6>
                                    <p><?php echo $val->review_desc; ?> </p>
                                </div>
                                
                            </div>
                                <?php } } ?>
<!--                            <div class="dash-sec row">
                                <div class="col-md-2">
                                    <img class="mr-4 rounded-circle" src="images/message-img2.png" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-10">
                                    <h6>John Doe</h6>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
                                </div>
                                
                            </div>-->
                            
                        </div>
                        
                    </div>
                    <div class="page-bt d-flex justify-content-between mb-3" style="display:none !important">
                        <button type="button" class="btn-primary"><i class="fas fa-angle-left pr-1"></i> Prev</button>
                        <button type="button" class="btn-primary">Next<i class="fas fa-angle-right pl-1"></i></button>
                    </div>
                </div>
                
                
            </div>
        </div>
</section>

<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>

</body>

      </html>