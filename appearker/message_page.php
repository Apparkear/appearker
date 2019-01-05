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
//echo "SELECT * FROM `estejmam_message` WHERE `from` != $user_id GROUP BY `from`";
$get_message = mysqli_query($link,"SELECT * FROM `estejmam_message` JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_message`.`from_id`  WHERE `from_id` != $user_id GROUP BY `from_id` ORDER BY `date` DESC");
//while($row = mysqli_fetch_object($get_message)){
//    print_r($row);
//}
//echo 1;exit;
$get_user_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$user_id}")); 
$userName = $get_user_details->fname." ".$get_user_details->lname;
$userimage = './upload/user_image/'.$get_user_details->image;

//$_SESSION['message_receiver_id'] =32; 

if($_SESSION['message_receiver_id']){
    $get_receiver_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `id`={$_SESSION['message_receiver_id']}")); 
   // print_r($get_receiver_details);
    $chatuserName = $get_receiver_details->fname." ".$get_receiver_details->lname;
    $chatuserImage ='./upload/user_image/'.$get_receiver_details->image;
}


?>

<section class="message-body">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                <div class="col-md-9">
                    <div class="message chat-page" id="appendchatscroll">
                        
                        <div class="media" style="border:none;" >
                          <img class="mr-4 rounded-circle" style="width: 90px; height: 90px;" src="<?php echo $chatuserImage; ?>" alt="Generic placeholder image">
                          <div class="media-body">
                            <h5 class="mt-4 mb-0"><?php echo $chatuserName; ?></h5>
                            <h5><span id="is_login"></span></h5>
                          </div>
                        </div>
                        
                        
                      <!--  /*****************************************************/ -->
                      <div id="appendchat" >
<!--                        <div class="media chat ml-lg-5" style="border:none;">
                          <a href="#">
                            <img class="rounded-circle" src="images/message-img1.png" alt="Generic placeholder image">
                          </a>
                          <div class="media-body bg">
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                          </div>
                        </div>
                        
                        <div class="media chat mr-lg-5" style="border:none;"> 
                          <div class="media-body color-bg">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry Ipsum five?
                          </div>
                          <a href="#">
                            <img class="rounded-circle float-right" src="images/message-img1.png" alt="Generic placeholder image">
                          </a>
                        </div>
                        <div class="media chat ml-lg-5" style="border:none;">
                          <a href="#">
                            <img class="rounded-circle" src="images/message-img1.png" alt="Generic placeholder image">
                          </a>
                          <div class="media-body bg">
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. 
                          </div>
                        </div>
                        
                       <div class="media chat pr-lg-5"> 
                          <div class="media-body color-bg">
                            Actually everything was fine. I'm very excited to show this to our team. 
                          </div>
                          <a href="#">
                              <img class="rounded-circle float-right" style="height: 75px; margin-left: 18px;" src="images/message-img1.png" alt="Generic placeholder image">
                          </a>
                        </div>--> 
                      </div>
                        
                        <form class="clearfix">
                            <div class="form-group clearfix p-4">
                                <textarea class="form-control float-left keypress" style="width:85%;" id="exampleFormControlTextarea1" rows="3" placeholder="Type Your Message Here"></textarea>
                                <a onclick="message()" href="javascript:void(0)" class="btn-primary float-right"><i class="fas fa-paper-plane pr-1"></i>Send</a>
                              </div>
                        </form>
                        
                        
                        
                        
                        
                        
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

$chatuser1 = $_SESSION['message_receiver_id'];
$user1 = $user_id;
$ids = [$chatuser1, $user1];
            sort($ids, 1);
            $id_val = implode('-',$ids);
            //echo "Moi";
//echo $id_val;
?>
 <script>
  
  // var chatuser = null;
  var user  = <?php echo  $user_id ; ?>;
  var chatuser = <?php echo  $_SESSION['message_receiver_id'] ; ?>;
  var chatroom = '<?php echo $id_val;//echo $user_id.'-'.$_SESSION['message_receiver_id'] //echo (isset($id)) ? $id : ''; ?>';
  var userimage = '<?php echo (isset($userimage)) ? $userimage : ''; ?>';
  var chatuserImage = '<?php echo (isset($chatuserImage)) ? $chatuserImage : ''; ?>';
  var userName = '<?php echo (isset($userName)) ? $userName : ''; ?>';
  var chatuserName = '<?php echo (isset($chatuserName)) ? $chatuserName : ''; ?>';


$('.keypress').keypress(function(e) {
    if(e.which == 13) {
        message()
    }
});

function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}
// console.log(chatroom);
  function message() {
    var text = $('#exampleFormControlTextarea1').val();
    if(text != ''){
        var currentdate = new Date();
        var date = currentdate.getFullYear()+'-'+(currentdate.getMonth()+1)+'-'+currentdate.getDate();
        var time =formatAMPM(currentdate); 
//console.log(user+"---"+text+"---"+time+"---"+date); 
        sendMessage(user,text,time,date);
        $('#exampleFormControlTextarea1').val('');
    }
    
  }
</script>   

<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase.js"></script>
<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-database.js"></script>

<script src="js/firebase_chat.js"></script>

<script type="text/javascript">
function waitIsLogin() {
      var id=<?php echo  $_SESSION['message_receiver_id'] ; ?>;
      $.ajax({
         type: 'POST',
         url: 'ajax_checklogin.php',
         data:{id: id},
         dataType: 'json',
         async: true,
         cache: false,
         timeout: 50000,
         success: function (data) {
            if(data.res==1){
               $('#is_login').html('<i class="fa fa-circle pr-2" aria-hidden="true" style="color: #17cd1c; font-size: 10px;"></i>Online');
            }else{
              $('#is_login').html('<i class="fa fa-circle pr-2" aria-hidden="true" style="color: #7d7d7d; font-size: 10px;"></i>Offline');
            }
            setTimeout(
                  'waitIsLogin()',
                  5000
               );
         },
         error: function( XMLHttpRequest, textStatus, errorThrown ) {
            //alert("error:" + textStatus + "(" + errorThrown + ")");
            setTimeout(
                'waitIsLogin()', /* Try again after.. */
                 "15000");       /* milliseconds (15seconds) */
         }
      });
   };

   $(document).ready(function () {
       waitIsLogin();
   });
</script>
