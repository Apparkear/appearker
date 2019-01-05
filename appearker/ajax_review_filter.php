<?php

ob_start();
session_start();
include 'administrator/includes/config.php';
include("class.phpmailer.php");
include 'Twilio.php';
?>


<?php

if(isset($_REQUEST)){
  $filter_vlue = $_POST["filter_value"]; 
    
  $user_id = $_SESSION['user_id'];  

if($filter_vlue == "rvdsc"){
    $Query = "SELECT * FROM `estejmam_property_review` JOIN `parking` ON `parking`.`id` = `estejmam_property_review`.`prop_id` LEFT JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_property_review`.`user_id` LEFT JOIN `estejmam_property_rate` ON `estejmam_property_rate`.`review_id` = `estejmam_property_review`.`id` WHERE `parking`.`user_id`=$user_id ORDER BY `estejmam_property_review`.`date` DESC";
}elseif ($filter_vlue == "rvasc") {
    $Query = "SELECT * FROM `estejmam_property_review` JOIN `parking` ON `parking`.`id` = `estejmam_property_review`.`prop_id` LEFT JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_property_review`.`user_id` LEFT JOIN `estejmam_property_rate` ON `estejmam_property_rate`.`review_id` = `estejmam_property_review`.`id` WHERE `parking`.`user_id`=$user_id ORDER BY `estejmam_property_review`.`date` ASC";    
}elseif($filter_vlue == "rdsc"){
    $Query = "SELECT * FROM `estejmam_property_review` JOIN `parking` ON `parking`.`id` = `estejmam_property_review`.`prop_id` LEFT JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_property_review`.`user_id` LEFT JOIN `estejmam_property_rate` ON `estejmam_property_rate`.`review_id` = `estejmam_property_review`.`id` WHERE `parking`.`user_id`=$user_id ORDER BY `estejmam_property_rate`.`score` DESC";
}else{
   $Query = "SELECT * FROM `estejmam_property_review` JOIN `parking` ON `parking`.`id` = `estejmam_property_review`.`prop_id` LEFT JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_property_review`.`user_id` LEFT JOIN `estejmam_property_rate` ON `estejmam_property_rate`.`review_id` = `estejmam_property_review`.`id` WHERE `parking`.`user_id`=$user_id ORDER BY `estejmam_property_rate`.`score` ASC"; 
}  
  
$all_array = mysqli_query($link, $Query);  
$htm = "";
while($get_row = mysqli_fetch_object($all_array)){
    //print_r($get_row);
    
    if(!empty($get_row->image)){
        $image_usr = "./upload/user_image/".$get_row->image;
    } else {
        $image_usr = './upload/nouser.png';
    }
    $htm .= '<div class="media reviews pt-2 pb-2">
                <div class="pic-area align-self-center mr-3">
                    <img class="img-fluid"  src="'.$image_usr.'" alt="">
                </div>
                 <div class="media-body">
                    <h6 class="mt-2">'.$get_row->fname." ".$get_row->lname; 
                        //for($i=0;$i<(int)$get_row->score; $i++){ 
                        //$htm .= '<i class="fas fa-star"></i>';
                        // } 
    $htm .= '</h6>   
                    <p class="mb-0">'.date("j F, Y",strtotime($get_row->date)).'</p>                                      
                    <p class="mb-0">'.$get_row->review_desc.'</p>                                      

                </div>                          
            </div>';
}
//exit;
$data['ack']=1;
$data['htm'] = $htm;
echo json_encode($data);
exit;
}



?>