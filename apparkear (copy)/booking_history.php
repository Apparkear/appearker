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
    header("Location:index.php");
  //  exit;
} 
$user_id = $_SESSION['user_id'];
//echo "SELECT * FROM `estejmam_booking` ,`estejmam_user`,`parking` WHERE `estejmam_user`.`id`= `estejmam_booking`.`user_id` AND `parking`.`id`=`estejmam_booking`.`prop_id` AND `estejmam_booking`.`user_id`=".$user_id." AND `estejmam_booking`.`end_date`>='".date('Y-m-d')."'";
// FOR RENTER SITE
$get_booking = mysqli_query($link,"SELECT * FROM `estejmam_booking` ,`parking` WHERE `parking`.`id`=`estejmam_booking`.`prop_id` AND `estejmam_booking`.`user_id`=".$user_id." AND `estejmam_booking`.`end_date`>='".date('Y-m-d')."'");

// FOR OWNER SITE
$get_booking_owner = mysqli_query($link,"SELECT * FROM `estejmam_booking` ,`parking` WHERE `parking`.`id`=`estejmam_booking`.`prop_id` AND `estejmam_booking`.`uploder_user_id`=".$user_id." AND `estejmam_booking`.`end_date`>='".date('Y-m-d')."'");

//while($booking_row1 = mysqli_fetch_object($get_booking)){ 
//  $parking_id = $booking_row1->prop_id;
//  $get_user_rating = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `user_ratings` WHERE `given_by`=$user_id AND `parking_id`=$parking_id"));  
//  if(!empty($get_user_rating)){
//      $booking_row1->is_rating = 1;
//  }else{
//      $booking_row1->is_rating = 0;
//  }
//}


?>


<section class="message-body">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <div class="my-properties">
                        <?php if($_SESSION['user_type'] == 0){ ?>
                        
                        <?php while($owner_booking_row = mysqli_fetch_object($get_booking_owner)){ 
                            $parking_id = $owner_booking_row->prop_id;
                            $get_user_rating = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `user_ratings` WHERE `given_by`=$user_id AND `parking_id`=$parking_id"));  
                              if(!empty($get_user_rating)){
                                  $is_rating = 1;
                              }else{
                                  $is_rating = 0;
                              }
                            
                           //print_r($booking_row);
                            if($owner_booking_row->image != ""){
                                $parking_image = "./upload/parking/".$owner_booking_row->image;
                            }else{
                            
                               $parking_image = "./upload/noimage.Jpeg"; 
                            }
                            
                            ?>
                        <div class="media pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid"  src="<?php echo $parking_image; ?>" alt="">
                            </div>
                            
                            <div class="media-body">
                                <h6 class="mt-2"><?php echo $owner_booking_row->name; ?></h6>   
                                <p class="mb-0"> <i class="ion-location mr-1"></i><?php echo $owner_booking_row->address; ?></p>
                                <p><i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="fas fa-star booking-his-star"></i> <i class="far fa-star booking-his-star"></i></p>
                                <a class="btn btn-primary entry-dt" href="javascript:void(0)">Entry date: <?php echo date('F j, Y',strtotime($owner_booking_row->start_date)); ?></a>
                            
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <?php if($is_rating == 0) {?>
                                <a class="btn btn-outline-primary rate-renter mb-4" data-toggle="modal" data-target="#myModalReview" rel="<?php echo $owner_booking_row->uploder_user_id; ?>" data="<?php echo $owner_booking_row->prop_id; ?>">Rate Renter</a>
                                <?php }else{ ?>
                                <a class="btn btn-outline-primary rate-renter mb-4" href="javascript:void(0)">Rated</a>
                                <?php } ?>
                                <a class="btn" href="javascript:void(0)" onclick="message(<?php echo $owner_booking_row->user_id; ?>)" style="margin-top: -20px;"><i class="far fa-comment"></i></a>
                                
                                <h4 class="book-his-price"><?php if($owner_booking_row->currency == 'usd'){ ?>$ <?php } ?> <?php echo $owner_booking_row->price; ?>/<?php echo $owner_booking_row->price_rate_type; ?></h4>
                                                                    
                                <a class="btn btn-primary entry-dt" href="javascript:void(0)">Exit date: <?php echo date('F j, Y',strtotime($owner_booking_row->end_date)); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php }else{ ?>
                        <!-- <h5 class="pt-3 pb-3">My Properties</h5> -->
                        <?php while($booking_row = mysqli_fetch_object($get_booking)){ 
                            $parking_id = $booking_row->prop_id;
                            $get_user_rating = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `user_ratings` WHERE `given_by`=$user_id AND `parking_id`=$parking_id"));  
                              if(!empty($get_user_rating)){
                                  $is_rating = 1;
                              }else{
                                  $is_rating = 0;
                              }
                            
                           //print_r($booking_row);
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
                                <a class="btn btn-primary entry-dt" href="javascript:void(0)">Entry date: <?php echo date('F j, Y',strtotime($booking_row->start_date)); ?></a>
                            
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <?php if($is_rating == 0) {?>
                                <a class="btn btn-outline-primary rate-renter mb-4" data-toggle="modal" data-target="#myModalReview" rel="<?php echo $booking_row->uploder_user_id; ?>" data="<?php echo $booking_row->prop_id; ?>">Rate Owner</a>
                                <?php }else{ ?>
                                <a class="btn btn-outline-primary rate-renter mb-4" href="javascript:void(0)">Rated</a>
                                <?php } if($_SESSION['user_type'] == 1){ ?>
                                <a class="btn" href="javascript:void(0)" onclick="message(<?php echo $booking_row->uploder_user_id; ?>)" style="margin-top: -20px;"><i class="far fa-comment"></i></a>
                                <?php } ?>
                                <h4 class="book-his-price"><?php if($booking_row->currency == 'usd'){ ?>$ <?php } ?> <?php echo $booking_row->price; ?>/<?php echo $booking_row->price_rate_type; ?></h4>
                                                                    
                                <a class="btn btn-primary entry-dt" href="javascript:void(0)">Exit date: <?php echo date('F j, Y',strtotime($booking_row->end_date)); ?></a>
                            </div>
                        </div>
                        <?php } ?>
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
<div id="myModalReview" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content send-message">
            <div class="modal-header">
                <h5 class="modal-title">Give review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 right-section">
                        <form id="review_form" action="ajax_save_review.php" method="post">
                            <div class="row review-box">


<!--        <input id="input-21b" value="4" type="text" class="rating" data-min=0 data-max=5 data-step=0.2 data-size="lg"
required title="">-->
                                <div class="col-md-12 border-right">
                                    <p>Rating: </p>
                                    <div class='rating-stars text-left'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

<!--                                <div class="col-md-4 border-right">
                                    <p>Service Rating: </p>
                                    <div class='rating-stars text-left'>
                                        <ul id='stars2'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->

<!--                                <div class="col-md-4">
                                    <p>Recommend: </p>
                                    <div class='rating-stars text-left'>
                                        <ul id='stars3'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>                                                     -->
                                <input type="hidden" name="rating" id="seller_communication" value="0"/>      
<!--                                <input type="hidden" name="service_rating" value="0" id="service_rating"/>          
                                <input type="hidden" name="would_recomended" value="0" id="would_recomended"/> -->
                                <input type="hidden" id="given_to_whom" name="given_to_whom" value=""/>      
                                <input type="hidden" name="given_by" value="<?php echo $_SESSION['user_id']; ?>"/>          
                                <input type="hidden" id="parking_id" name="parking_id" value="<?php echo $booking_row->prop_id; ?>"/> 
<!--                                <input type="hidden" id='order_id' name="order_id" value=""/>      -->

                            </div>
                            <p>Review:</p>
                            <div class="text-area-box d-flex">
                                <textarea id="comment" maxlength="2500" minlength="12" name="comments" required style="width:100%; height:200px;"></textarea>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary reviewsubmit" value="Send" onclick="$('#review_form').submit();"/>
            </div>
            
        </div>
    </div>

</div>
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
<style>
    /* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:1.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    $('#seller_communication').val(ratingValue);
    
  });
  
  $(".rate-renter").click(function(){
      var owner_id = $(this).attr("rel");
      var parking_id = $(this).attr("data");
      //alert(owner_id);
      $("#given_to_whom").val(owner_id);
      $("#parking_id").val(parking_id);
  });
  
    });


    function message(get_id=null){
        $.ajax({
            type:'POST',
            url:'ajax_setchat.php',
            data:{page:"messagelist",message_receiver_id : get_id},
            datatype:"json",
            success: function(response){
               response = JSON.parse(response);
                console.log(response);
                //alert(response.Ack);
                if(response.Ack == 1){
                    window.location.href = 'message_page.php?messenger_id='+btoa(get_id);
                } else {
                    alert('something went wrong');
                }
            }
        })
    }
</script>




</body>
</html>