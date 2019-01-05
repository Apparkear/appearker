<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();
include("include/header.php");
 ?>
<?php 
if($_SESSION['user_id'] == ''){  //echo "vkjfkfj";exit;
   $location = SITE_URL;
    header("Location:index.php");
  //  exit;
} 
$user_id = $_SESSION['user_id']; 

$get_message = mysqli_query($link,"SELECT * FROM `estejmam_message` WHERE `from` != $user_id GROUP BY `from`");
while($row = mysqli_fetch_object($get_message)){
    print_r($row);
}

?>

<section class="message-body">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <div class="message">
                        
                        <div class="media">
                          <img class="mr-4 rounded-circle" src="images/message-img1.png" alt="Generic placeholder image">
                          <div class="media-body">
                            <h5 class="mt-0">Aiden Chavez</h5>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <div class="bottom d-flex">
                                <i class="far fa-clock"></i><p>7 Days</p>
                                <i class="fas fa-star pl-3"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                          </div>
                        </div>
                        
                        <div class="media">
                          <img class="mr-4 rounded-circle" src="images/message-img2.png" alt="Generic placeholder image">
                          <div class="media-body">
                            <h5 class="mt-0">Aiden Chavez</h5>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <div class="bottom d-flex">
                                <i class="far fa-clock"></i><p>7 Days</p>
                                <i class="fas fa-star pl-3"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                          </div>
                        </div>
                        
                        <div class="media">
                          <img class="mr-4 rounded-circle" src="images/message-img3.png" alt="Generic placeholder image">
                          <div class="media-body">
                            <h5 class="mt-0">Aiden Chavez</h5>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <div class="bottom d-flex">
                                <i class="far fa-clock"></i><p>7 Days</p>
                                <i class="fas fa-star pl-3"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                          </div>
                        </div>
                        
                        <div class="media">
                          <img class="mr-4 rounded-circle" src="images/message-img4.png" alt="Generic placeholder image">
                          <div class="media-body">
                            <h5 class="mt-0">Aiden Chavez</h5>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <div class="bottom d-flex">
                                <i class="far fa-clock"></i><p>7 Days</p>
                                <i class="fas fa-star pl-3"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                          </div>
                        </div>
                        
                    </div>
                    <div class="page-bt d-flex justify-content-between mb-3">
                        <button type="button" class="btn-primary"><i class="fas fa-angle-left pr-1"></i> Prev</button>
                        <button type="button" class="btn-primary">Next<i class="fas fa-angle-right pl-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
</section>