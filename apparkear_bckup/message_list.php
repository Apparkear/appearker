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

//echo "SELECT * FROM `estejmam_message` WHERE `from` != $user_id GROUP BY `from`";
$get_message = mysqli_query($link,"SELECT * FROM `estejmam_message` JOIN `estejmam_user` ON `estejmam_user`.`id` = `estejmam_message`.`from_id`  WHERE `from_id` != $user_id GROUP BY `from_id` ORDER BY `date` DESC");
//while($row = mysqli_fetch_object($get_message)){
//    print_r($row);
//}

?>

<section class="message-body">
        <div class="container">
            <div class="row">
                <?php include("include/sidebar.php");?>
                <div class="col-md-9">

                    <div class="message" id="appendchatlist">
                        <div class="emptychatbox">
                            
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
<script>
     var user  = <?php echo  $user_id ; ?>;
     var chatroom = ''; 
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
<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase.js"></script>
<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-database.js"></script>

<script src="js/firebase_chat.js"></script>
