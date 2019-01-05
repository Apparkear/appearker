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
   $location = 'http://104.131.83.218/team4/apparkear/';
    header("Location: $location");
   // exit;
}

$user_id = $_SESSION['user_id'];

$get_properties = mysqli_query($link,"SELECT * FROM `parking` WHERE `user_id`=$user_id AND `status`=1 ORDER BY `id` DESC");
//$get_properties = mysqli_query($link,"SELECT * FROM `parking` WHERE `user_id`=$user_id ORDER BY `id` DESC");

//while($row = mysqli_fetch_object($get_properties)){
//    
//    $get_image_array = mysqli_query($link, "SELECT * FROM `parking_images` WHERE `parking_id`={$row->id}");
//    print_r($row);
//}

?>
<section class="message-body">
        <div class="container">
            <div class="row">
                
                <?php include("include/sidebar.php");?>
        <div class="col-md-9">
                    <div class="my-properties">
                        <h5 class="pt-3 pb-3">My Properties</h5>
                        <?php while($row = mysqli_fetch_object($get_properties)){ //print_r($row);
                            $get_image_array = mysqli_query($link, "SELECT * FROM `parking_images` WHERE `parking_id`={$row->id}");
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
                            
                            ?>
                        <div class="media" rel="<?php echo $row->id; ?>">
                            <div class="pic-area align-self-center mr-3">
                                <?php if($img_parking == ""){ ?>
                                <img class="img-fluid"  src="./upload/parking.jpg" alt="">
                                <?php }else{ ?>
                                        <img class="img-fluid"  src="<?php echo $img_parking; ?>" alt="">
                                <?php } ?>
                            </div>
                            
                            <div class="media-body">
                                <h6 class="mt-2"><?php echo $row->name; ?></h6>
                                <p>Car Type: <span class="sub"><?php 
                                if($row->car_type != ""){
                                    if($row->car_type == 's'){ 
                                        echo "SMALL"; 

                                    }elseif($row->car_type == 'm'){
                                        echo "MEDIUM"; 
                                    }elseif($row->car_type == 'l'){
                                        echo "LARGE"; 
                                    }elseif($row->car_type == 'exl'){
                                        echo "EXTRA LARGE";
                                    } 
                                }
                                
                                ?></span></p>
                                <?php //echo $row->available_start; ?>
                                <p class="mb-0">  <i class="ion-android-calendar mr-1"></i>Available from <?php echo date("j F, Y",strtotime($row->available_start)); ?></p>
                                <p class="mb-0"> <i class="ion-location mr-1"></i><?php echo $row->address;  ?></p>
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <h3><?php if($row->currency == 'usd'){ ?>$<?php } ?><?php echo $row->price; ?></h3>
                                <i class="ion-compose edit_icon" rel="<?php echo $row->id; ?>" style="cursor: pointer;"></i>
                                <i class="ion-close ml-2 delete_icon" rel="<?php echo $row->id; ?>" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        <?php } ?>

<!--                        <div class="media">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/dash-img-b.png" alt="">
                            </div>
                            
                            <div class="media-body">
                                <h6 class="mt-2">Trisa Appartment near Kolkata</h6>
                                <p>Car Type:
                                    <span class="sub">SUB</span>
                                </p>
                                <p class="mb-0">
                                    <i class="ion-android-calendar mr-1"></i>Available from 22nd March 2018</p>
                                <p class="mb-0">
                                    <i class="ion-location mr-1"></i>Baguiati, Kolkata - 700059</p>
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <h3>$100.00</h3>
                                <i class="ion-compose"></i>
                                <i class="ion-close ml-2"></i>
                            </div>
                        </div>

                        <div class="media">
                            <div class="pic-area align-self-center mr-3">
                                <img class="img-fluid" src="images/dash-img-b.png" alt="">
                            </div>
                           
                            <div class="media-body">
                                <h6 class="mt-2">Trisa Appartment near Kolkata</h6>
                                <p>Car Type:
                                    <span class="sub">SUB</span>
                                </p>
                                <p class="mb-0">
                                    <i class="ion-android-calendar mr-1"></i>Available from 22nd March 2018</p>
                                <p class="mb-0">
                                    <i class="ion-location mr-1"></i>Baguiati, Kolkata - 700059</p>
                            </div>
                            <div class="rt-part ml-3 text-right">
                                <h3>$100.00</h3>
                                <i class="ion-compose"></i>
                                <i class="ion-close ml-2"></i>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit_icon').click(function(){
            var parking_id = $(this).attr("rel");
            //console.log("ajax_properties.php?di="+btoa(parking_id));return false;
            window.location.href = "ajax_properties.php?di="+btoa(parking_id);
        });
        
        $('.delete_icon').click(function(){
            if (confirm("Are you sure?")) {
            var parking_id = $(this).attr("rel");
            $.ajax({
                type:"post",
                url:"ajax_delete.php",
                dataType:'json',
                data:{parking_id :parking_id },
                success:function(data){
                   // alert(data);return false;
                    if(data.ack == 1){
                        $(".media[rel='"+parking_id+"']").css("display","none");
//                        alert($(this).parent().html());
//                        $(this).parent().parent().hide();
                    }
                }
            });
            }
            return false;
        });
    });
</script>
</body>
</html>