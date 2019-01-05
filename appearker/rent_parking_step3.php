<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 
/*************header***************/
include("include/header.php");

if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location"); 
}
if($_SESSION['add_session'] != 2 && $_SESSION['two'] == ''){  
    $location = SITE_URL;
    header("Location: $location"); 
}

//$_SESSION['new_parking'] =7;
$get_parking_id = $_SESSION['new_parking'];
$user_id =$_SESSION['user_id'];

$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}"));
$email = $get_user_details->email;

$email_add = str_replace("@","%40",$email);
//echo $email_add;

if($get_parking_id){
    $get_details= mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$get_parking_id}"));
    $get_booking = mysqli_query($link,"SELECT * FROM `estejmam_booking` WHERE `transaction_id` != '' AND `prop_id`={$get_parking_id}");
    $event =""; $count = 1; 
    while($row_booking = mysqli_fetch_array($get_booking)){
        ///print_r($row_booking);
        //echo $row_booking->start_date."--".$row_booking->end_date;
        $get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$row_booking['user_id']}"));
        $booked_name= $get_user_details->fname." ".$get_user_details->lname;
        $event .="{title  : '".$booked_name."',start  : '".$row_booking['start_date']."',end : '".$row_booking['end_date']."' },";
    }
    
    //echo $event;
}



?>


<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Property Description</h4>
                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div pb-5" method='post' action="ajax_parking_description.php" enctype="multipart/form-data">

                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-0 text-right">Title:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Title of the Parking place" name='name' value='<?php if($get_parking_id){ echo $get_details->name; } ?>' required>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-0 text-right">About this listing:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" name='description' rows="3"><?php if($get_parking_id){ echo $get_details->description; } ?></textarea>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-0 text-right">Rules:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" name='rules' rows="3"><?php if($get_parking_id){ echo $get_details->rules; } ?></textarea>
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mt-3">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-0 text-right mt-2">Rules & Availability 
												Days/Hours:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <div id='calendar'></div>
<!--                                                    <input id="datepicker" type="text" style="display:none;" />-->
                                                    <!--<iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;mode=WEEK&amp;height=300&amp;wkst=1&amp;hl=en_GB&amp;bgcolor=%23FFFFFF&amp;src=<?php echo $email_add; ?>&amp;color=%231B887A&amp;src=%23contacts%40group.v.calendar.google.com&amp;color=%2328754E&amp;src=en.indian%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Asia%2FCalcutta" style="border-width:0" width="365" height="300" frameborder="0" scrolling="no"></iframe>-->
                                                    <!--<img src="images/property-img.png" class="img-fluid mt-3">-->
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-3"></div>
                                                <div class="col-sm-9 edit-pro-frmfield mt-3">
                                                	<h5>Accessibility:</h5>
                                                    <textarea class="form-control" name='accessibility' id="exampleFormControlTextarea1" rows="3"><?php if($get_parking_id){ echo $get_details->accessibility; } ?></textarea>
                                                </div>
                                        </div>                                                                  
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12 row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 row pr-0 mt-4">
                                            <?php $get_all_amenities = mysqli_query($link, "SELECT * FROM `amenities` WHERE `status`=1"); ?>
                                            <?php $count = 1; while($amnities = mysqli_fetch_object($get_all_amenities)){ 
                                                    
                                                ?>
                                            <div class="col-sm-12 edit-pro-frmfield mt-1 pr-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" name='amenities[]'
                                                           <?php 
                                                           if($get_parking_id){ 
                                                                $all_am = $get_details->amenities; 
                                                                $string = (string)$amnities->id;
                                                                if(stripos($all_am, $string) !== false){
                                                                    echo "checked";
                                                                }
                                                            }
                                                           ?>
                                                           value='<?php echo $amnities->id; ?>' class="custom-control-input" id="customControlInline<?php echo $count; ?>">
                                                    <label class="custom-control-label" for="customControlInline<?php echo $count; ?>"><?php echo $amnities->name; ?></label>
                                                 </div>
                                             </div> 
                                            <?php $count++; } ?>
<!--                                             <div class="col-sm-9 edit-pro-frmfield mt-1 pr-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    <label class="custom-control-label" for="customControlInline">Accessibility for people with disabilities</label>
                                                 </div>
                                             </div> 
                                             <div class="col-sm-7 edit-pro-frmfield mt-1 pr-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    <label class="custom-control-label" for="customControlInline">Indoor Parking Lot</label>
                                                 </div>
                                             </div> 
                                             <div class="col-sm-9 edit-pro-frmfield mt-1 pr-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    <label class="custom-control-label" for="customControlInline">Security Guards / Concierge</label>
                                                 </div>
                                             </div>
                                             <div class="col-sm-11 edit-pro-frmfield mt-1 pr-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    <label class="custom-control-label" for="customControlInline">Keys or Access card provided by Renter</label>
                                                 </div>
                                             </div>-->
                                          </div>                                                                
                                        </div>
                                    </div>
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-3"></div>
                                                <div class="col-sm-9 edit-pro-frmfield mt-3 pr-0">
                                                	<h5>Photos:</h5>
                                                    <ul class="p-0">
                                                    	<li class="photo-img upload-btn-wrapper frst_image">
                                                            
                                                            <!-- <button type="button" class="close" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button> -->

                                                         	<img src="images/photo-img.png" class="img-fluid" >
                                                                <input type="file" name="parking_images[]" id="pic-input" multiple="multiple" style="height: 88px !important; width: 88px !important;">
                                                        </li>
                                                        <?php if($get_parking_id){  
                                                            $get_images = mysqli_query($link,"SELECT * FROM `parking_images` WHERE `parking_id`={$get_parking_id}");
                                                           while($row_image = mysqli_fetch_object($get_images)){
                                                            ?>
                                                        <li class="cover_img photo-img upload-btn-wrapper">
                                                         	<img src="./upload/parking/<?php echo $row_image->image; ?>" class="img-fluid" >
                                                        </li>
                                                           <?php } } ?>
                                                        <!--
                                                        <li class="photo-img upload-btn-wrapper">
                                                         	<img src="images/photo-img.png" class="img-fluid" id="uploadbox_profileimage">
                                                            <input type="file" name="profile_image">
                                                        </li>
                                                        <li class="photo-img upload-btn-wrapper">
                                                         	<img src="images/photo-img.png"  class="img-fluid" id="uploadbox_profileimage">
                                                            <input type="file" name="profile_image">
                                                        </li>
                                                        <li class="photo-img upload-btn-wrapper">
                                                         	<img src="images/photo-img.png"  class="img-fluid" id="uploadbox_profileimage">
                                                            <input type="file" name="profile_image">
                                                        </li>-->
                                                    </ul>
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    <div class="row ml-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" style='color:#ffffff' href="rent_parking_step2.php" >Back</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" name='submit' value='Next' />
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-3 hints">
                                    <img src="images/hints.png">
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
           </div>
           <div class="col-md-2">              
            </div>
       </div>
   </div>
<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<style>
    #ui-datepicker-div{
        margin-top:24%;
        width:28%;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        var calendar = $("#calendar").fullCalendar({  
            header: {
				//left: 'prev,next today',
				left: 'prev,next',
				center: 'title',
				//right: 'month,agendaWeek,agendaDay,listWeek'
				right: 'month,agendaWeek,agendaDay,listWeek'
			},

			navLinks: true, 
			editable: true,
			eventLimit: true, 
//            events: [
//		        {
//		            title  : 'event1',
//		            start  : '2017-04-01'
//		        },
//		        {
//		            title  : 'event2',
//		            start  : '2018-09-08',
//		            end    : '2018-09-15'
//		        },
//		        {
//		            title  : 'event3',
//		            start  : '2017-04-09T12:30:00',
//		            allDay : false // will make the time show
//		        }
//    		],  // request to load current events
            events: [
		        <?php echo $event; ?>
    		],  // request to load current events
           
        });

        $("#datepicker").datepicker({
            dateFormat: "yy-mm-d",
            onSelect: function() {
                $(this).data('datepicker').inline = true;                               
            },
            onClose: function() {
                $(this).data('datepicker').inline = false;
            }
        });
        //$("#datepicker").datepicker('show');
        $('#pic-input').change(function () {
            $(".cover_img").remove();
            for (var i=0, len = this.files.length; i < len; i++) {
                (function (j, self) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        
                        $('<li class="cover_img photo-img upload-btn-wrapper" rel="' + self.files[j].name + '"><img src="' + e.target.result + '" class="img-fluid"><figcaption class="text-center">' + self.files[j].name + '</figcaption></li>').insertAfter(".frst_image");
                        
                    }
                    reader.readAsDataURL(self.files[j])
                })(i, this);
            }
        });
    });
</script>