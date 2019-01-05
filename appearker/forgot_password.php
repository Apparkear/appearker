<?php
ob_start();
session_start();
include("administrator/includes/config.php");
require_once "./PHPMailer/class.phpmailer.php";
include("include/header.php");

unset($_SESSION["msg"]);
function landlorduserMailFunction($toemailLandlord, $name, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails) {
 
    $adminEmail = $adminDetails->email;
    $logo = SITE_URL . "./upload/site_logo/".$site_settings->sitelogo;
    $resetpass_urlAdmin = SITE_URL . "reset_password.php?liame=".base64_encode($user_email);
    $detail4 = "<p>Reset your password by clicking below link</p>"
            . "<a href=".$resetpass_urlAdmin." target='blank' >".$resetpass_urlAdmin."</a>";

    $Subject = "Reset Password Apparkear";


    $TemplateMessage = $detail4; 
    

    $mail1 = new PHPMailer;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->Username = 'mail@natitsolved.com';
    $mail->Password = 'Natit#2019';
    
    
    $mail->IsHTML(true);
    $mail->From = $adminEmail;
    $mail->FromName = "Apparkear";
    $mail->Sender = $adminEmail; // indicates ReturnPath header
    $mail->AddReplyTo($adminEmail, "Apparkear"); // indicates ReplyTo headers
    //$mail->AddCC('cc@site.com.com', 'CC: to site.com');
    $mail->Subject = $Subject;
    $mail->Body = $TemplateMessage;
    $mail->AddAddress($user_email);
    if($mail->Send()){
        $data['ack'] = 1;
    }else{
        $data['ack'] = 0;
    }

}


if(isset($_REQUEST['submit'])) {
    //echo '1Mo9i';exit;
    // $_SESSION['msg'] = "";
     //unset($_SESSION['msg']);
     
    $user_email = $_POST['email']; 
    
    $get_user = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `estejmam_user` WHERE `email` = '" . $user_email . "'"));
      
    if(empty($get_user)){
        
        $data['ack']= 0;
    }else{
        $data['ack']= 1;
        $result_query = mysqli_query($link,"SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
        $adminDetails = mysqli_fetch_object($result_query);
        $toemailAdmin = $adminDetails->email;
        $phonenoAdmin = $adminDetails->phone_no;


        $mailheaderAdmin = 'A new user signup on apparkear.';
        $resetpass_urlAdmin = SITE_URL . "reset_password.php?email=".$user_email;

        $toemailLandlord = $user_email;
        $mailheaderLandlord = 'Thank You for signup on apparkear.';
        //$login_urlLandlord = SITE_URL . "login.php";
        $login_urlLandlord = SITE_URL;
        landlorduserMailFunction($toemailLandlord, $fname.' '.$lname, $user_email, $mailheaderAdmin,$phonenoAdmin,$adminDetails);
    }
   // echo $data['ack'];exit;
    unset($_SESSION["msg"]);
    if($data['ack'] ==1){
        $_SESSION['msg'] = "check your mail we have sent the reset password link";
        header("Location: forgot_password.php");
        die();
    }else{
        $_SESSION['msg'] = "Invalid email";
        header("Location: forgot_password.php");
        die();
    }
    
   
    
    
    
    
}



?>




	<section class="login_plane pb-5 forgot-password-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5 col-md-7">
					<div class="log_in_full">
						<div class="logo_login text-center">
							<img src="./upload/site_logo/<?php echo $logo->sitelogo; ?>" style="margin: 15px auto;"/>
						</div>
						<p class="mt-4"><b>Forgot Password</b></p>

						<div class="login_box" >
					 		<div id="ack" style="color:red;margin-left: 84px;"></div>
					 		<div id="ack1" style="color:green;margin-left: 84px;"></div>
                                                        <form method="post" action="forgot_password.php" id="forget_form">

					  			<div class="form-group">
                                                                    <label style="font-weight:500;" for="exampleInputEmail1">Email address</label>
                                                                    <input type="email" class="form-control" id="forgot_email" aria-describedby="emailHelp" placeholder="Enter email" required name="email">
					  			</div>
					   			<div class="form-group" style="padding-top: 15px;margin-bottom: 15px;">
                                                                    <input type="submit" name="submit" style="margin: 0 auto; padding: 7px 30px;" class="btn btn-primary"  id="btn" value="Submit">
					  			</div>
				   			</form>
				   
				   			
						</div>
				 	</div>
				</div>
			</div>
		</div>
	</section>

<?php
include("include/footer.php");
?>

<!--	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>-->
	<script>
		$(window).scroll(function(){
		    if ($(window).scrollTop() >= 100) {
		       $('.navbar-fixed-top').css('background','rgba(0,0,0,.8)');
		    }
		    else {
		       $('.navbar-fixed-top').css('background','none');
		    }
		});
	</script>
	
   <script>
       $(document).ready(function(){
       });
	</script>
</body>
</html>