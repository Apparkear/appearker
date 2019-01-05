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

$get_properties = mysqli_query($link,"SELECT * FROM `parking` WHERE `user_id`=$user_id ORDER BY `id` DESC limit 5");

$review_array = array();
$count = 0;
while($parking_row = mysqli_fetch_object($get_properties)){
    //print_r($parking_row);
    
    //echo "SELECT * FROM `estejmam_property_review` WHERE `prop_id`=$parking_row->id";eit;
    $get_val = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_property_review` join `estejmam_user` ON `estejmam_user`.`id`= `estejmam_property_review`.`user_id` WHERE `prop_id`=$parking_row->id" ));
    
    if(!empty($get_val)){
        $review_array[$count]['details'] = $get_val;
//        $get_rat = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_property_rate` WHERE `prop_id`=$parking_row->id "));
//        $review_array[$count]['rating'] = $get_rat;
        $count++;
    }
//    if(!empty($get_rat)){
//        $review_array[$count]['rating'] = $get_rat->score;
//        $count++;
//    }
}
//exit;
//print_r($review_array);
//exit();
?>

<section class="message-body">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                
                <div class="col-md-9">
                    <div class="my-properties">
                        <div class="col-md-8">
                            <h5 class="pt-0 pb-3">Reviews</h5>
                        </div>
                        <div class="col-md-4">
                            <select class="select_class" id="filtering">
                                <option value="">Order By</option>
                                <option value="rasc">Rating Asc</option>
                                <option value="rdsc">Rating Desc</option>
                                <option value="rvasc">Review date Asc</option>
                                <option value="rvdsc">Review date Dsc</option>
<!--                                <option>Order By</option>-->
                            </select>
                        </div>
                        <div id="filtered_value">
                        <?php foreach($review_array as $key => $value){ 
                            
                            //print_r($value);
                            
                            if(!empty($value['details']->image)){
                                        $image_usr = "./upload/user_image/".$value['details']->image;
                                    }else{
                                        $image_usr ='./upload/nouser.png';
                                    }
                            
                            ?>
                        <div class="media reviews pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid"  src="<?php echo $image_usr; ?>" alt="">
                            </div>
                             <div class="media-body">
                                <h6 class="mt-2"><?php echo $value['details']->fname." ".$value['details']->lname; ?> 
                                    <?php for($i=0;$i<(int)$value['rating']->score; $i++){ ?>
                                    <i class="fas fa-star"></i>
                                    <?php } ?>
                                </h6>
                                 <?php //echo $value['details']->date; //print_r($value['details']); ?>
                                <p class="mb-0"><?php echo date("j F, Y",strtotime($value['details']->date)); ?></p> 
                                <p class="mb-0"><?php echo $value['details']->review_desc; ?> </p>                                      
                            
                            </div>                          
                        </div>
                        <?php } ?>
                        </div>

<!--                        <div class="media reviews pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/review-b.png" alt="">
                            </div>
                            <div class="media-body">
                                <h6 class="mt-2">John Doe
                                    <i class="fas fa-star"></i>
                                </h6>
                                <p class="mb-0"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s,</p>
                        
                            </div>
                            
                        </div>

                        <div class="media reviews pt-2 pb-2">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/review-c.png" alt="">
                            </div>
                            <div class="media-body">
                                <h6 class="mt-2">John Doe
                                    <i class="fas fa-star"></i>
                                </h6>
                                <p class="mb-0"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                    dummy text ever since the 1500s,</p>
                        
                            </div>
                        </div>-->

                        
                    </div>
                    
                   
                </div>
            </div>
        </div>
</section>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script>
    $(document).ready(function(){
        $("#filtering").change(function(){
            var filter_value = $(this).val();
            //alert(filter_value);
            
            $.ajax({
                type:"POST",
                url:"ajax_review_filter.php",
                dataType:"json",
                data:{filter_value:filter_value},
                success:function(data){
                    //console.log(data);return false;
                    $("#filtered_value").html(data.htm);
                }
            });
        });
    });
</script>
