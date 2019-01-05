<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");
include("class.phpmailer.php");
function randomPassword($length,$count, $characters) {

// $length - the length of the generated password
// $count - number of passwords to be generated
// $characters - types of characters to be used in the password

// define variables used within the function
    $symbols = array();
    $passwords = array();
    $used_symbols = '';
    $pass = '';

// an array of different character types
    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols["numbers"] = '1234567890';
    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

    $characters = split(",",$characters); // get characters types to be used for the passsword
    foreach ($characters as $key=>$value) {
        $used_symbols .= $symbols[$value]; // build a string with all characters
    }
    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

    for ($p = 0; $p < $count; $p++) {
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $symbols_length); // get a random character from the string with all characters
            $pass .= $used_symbols[$n]; // add the character to the password string
        }
        $passwords[] = $pass;
    }

    return $passwords; // return the generated password
}

if (isset($_REQUEST['submit'])) {


    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d");
    $dob = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $dbpass = md5($password);
    $status = 0;
    $is_approved=$_REQUEST['is_approved'];
    $tenants_type = 0;
    $host_type = 1;
    $type = 1;





    $fields = array(
        'fname' => mysqli_real_escape_string($link, $fname),
        'lname' => mysqli_real_escape_string($link, $lname),
        'gender' => mysqli_real_escape_string($link, $gender),
        'email' => mysqli_real_escape_string($link, $email),
        'phone' => mysqli_real_escape_string($link, $phone),
        'address' => mysqli_real_escape_string($link, $address),
        'city' => mysqli_real_escape_string($link, $city),
        'country' => mysqli_real_escape_string($link, $country),
        'state' => mysqli_real_escape_string($link, $state),
        'zip' => mysqli_real_escape_string($link, $zip),
        'ip' => mysqli_real_escape_string($link, $ip),
        'add_date' => mysqli_real_escape_string($link, $date),
        'dob' => mysqli_real_escape_string($link, $dob),
        'password' => mysqli_real_escape_string($link, $dbpass),
        'text_password' => mysqli_real_escape_string($link, $password),
        'status' => mysqli_real_escape_string($link, $status),
        'is_approved' => mysqli_real_escape_string($link, $status),
        'tenants_type' => mysqli_real_escape_string($link, $tenants_type),
        'host_type' => mysqli_real_escape_string($link, $host_type),
	    'is_approved'=> mysqli_real_escape_string($link, $is_approved),
        'type'=> mysqli_real_escape_string($link, $type)
    );

    // $fields = array(
    //     'fname' => $fname,
    //     'lname' => $lname,
    //     'gender' => $gender,
    //     'email' => $email,
    //     'phone' => $phone,
    //     'address' => $address,
    //     'city' => $city,
    //     'country' => $country,
    //     'state' => $state,
    //     'zip' => $zip,
    //     'ip' => $ip,
    //     'add_date' => $date,
    //     'dob' => $dob,
    //     'password' => $dbpass,
    //     'text_password' => $password,
    //     'status' => $status,
    //     'is_approved' => $status,
    //     'tenants_type' => $tenants_type,
    //     'host_type' => $host_type,
    //     'is_approved'=> $is_approved,
    //     'type'=> $type
    // );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }



    if ($_REQUEST['action'] == 'edit') {

        $fileTypes = array('jpg', 'jpeg', 'gif', 'png', ''); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

            if (in_array($fileParts['extension'], $fileTypes)) {
                $editQuery = "UPDATE `estejmam_user` SET " . implode(', ', $fieldsList)
                        . " WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'";
                //exit;

                mysqli_query($link, $editQuery);

                if ($_FILES['image']['tmp_name'] != '') {
                    $target_path = "../upload/userimages/";
                    $userfile_name = $_FILES['image']['name'];
                    $userfile_tmp = $_FILES['image']['tmp_name'];
                    $img_name = $userfile_name;
                    $img = $target_path . $img_name;
                    move_uploaded_file($userfile_tmp, $img);

                    $image = mysqli_query($link, "UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
                }

                if($is_approved==1)
            	{
            	        $userdetais = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $_REQUEST['id'] . "'"));

                        $username = $userdetais->fname;
                        $useremail = $userdetais->email;

                        if(isset($userdetais->text_password) && $userdetais->text_password!='')
                        {
                            $userpassword = $userdetais->text_password;
                        }
                        else
                        {
                        	$userpassword1=randomPassword(10,1,"lower_case,upper_case,numbers,special_symbols");
                            $userpassword=$userpassword1['0'];
                                mysqli_query($link, "update estejmam_user set `password`='".md5($userpassword)."',`text_password`='".$userpassword."' where id='" . $item_id . "'");
                        }

                        $logo = SITE_URL . "images/logo_black.svg";
                        $loginurl = SITE_URL . "login.php";
                        $contactuslink = SITE_URL . "contact_us.php";
                        $helplink = SITE_URL . "help.php";



                        $detail4 = "<body style='background:#f2f2f2'>
                                	<div style='width:560px;height:auto;min-height:200px;background:#fff;border-radius:10px;margin: 0 auto;padding:55px;box-sizing: border-box;'>
                                		<img src='" . $logo . "' alt='' style='display: block;width:200px;margin: 0 auto;margin-bottom: 50px;height:30px;'/>

                                		<h2 style='color: #6e6e6e;font-size:15px;text-transform: uppercase;font-family: arial,sans-serif;font-weight:500;text-align: center;'>thank you for registering with us.</h2><br/>

                                		<p style='font-family: arial,sans-serif;color: #606060;font-size: 14px;line-height: 20px'>Your account is activated now</p>
                                		<table border='1' bordercolor='#ddd' style='border-collapse: collapse;width:100%;font-family: arial,sans-serif;color: #606060;font-size: 14px;'>
                                			<tr>
                                				<td style='padding: 7px'>Email</td>
                                				<td style='padding: 7px'>" . $useremail . "</td>
                                			</tr>
                                			<tr>
                                				<td style='padding: 7px'>Password</td>
                                				<td style='padding: 7px'>" . $userpassword . "</td>
                                			</tr>
                                		</table>
                                		<p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 50px'><a href='" . $loginurl . "' style='background: #EF3D4F;color:#fff;padding:7px 20px;border-radius:15px'>Click here To login</a></p>
                                		<p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px'>Thanks and Regards</p>
                                		<span style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;font-style: italic;'>Roomarate team</span>

                                		<hr style='border:0;border-top:1px solid #ddd;margin-top:20px'>
                                		<ul style='list-style: none;font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;padding: 0;display: table;margin: 0 auto;'>
                                			<li style='float:left;padding:0 10px;border-right:1px solid #ddd'><a href='" . $helplink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Help</a></li>
                                			<li style='float:left;padding:0 10px'><a href='" . $contactuslink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Contact Us</a></li>
                                		</ul>
                                	</div>
                                </body>";


                    $Subject = "Your Roomarate account is verifyed";


                    $TemplateMessage = $detail4;
                    $mail1 = new PHPMailer;
                    $mail1->FromName = "Roomarate";
                    $mail1->From = "info@roomarate.com";
                    $mail1->Subject = $Subject;



                    $mail1->Body = stripslashes($TemplateMessage);
                    $mail1->AltBody = stripslashes($TemplateMessage);
                    $mail1->IsHTML(true);
                    $mail1->AddAddress($useremail, "roomarate.com");
                    $mail1->Send();

                }
                header('Location:search_user_landlord.php');
                exit();
            } else {
                $_SESSION['MSG'] = 1;
                header('location:search_user_landlord.php');
                exit();
            }

    } else {

        // echo '<pre>'; print_r($_REQUEST); echo '</pre>';
        // exit;

        $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {

            $addQuery = "INSERT INTO `estejmam_user` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";
            // echo $addQuery;

            // exit;
            mysqli_query($link, $addQuery);
            $last_id = mysqli_insert_id();
            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/userimages/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysqli_query($link, "UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");

                if($is_approved==1)
                {
                        $userdetais = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $_REQUEST['id'] . "'"));

                        $username = $userdetais->fname;
                        $useremail = $userdetais->email;

                        if(isset($userdetais->text_password) && $userdetais->text_password!='')
                        {
                            $userpassword = $userdetais->text_password;
                        }
                        else
                        {
                            $userpassword1=randomPassword(10,1,"lower_case,upper_case,numbers,special_symbols");
                            $userpassword=$userpassword1['0'];
                                mysqli_query($link, "update estejmam_user set `password`='".md5($userpassword)."',`text_password`='".$userpassword."' where id='" . $item_id . "'");
                        }

                        $logo = SITE_URL . "images/logo_black.svg";
                        $loginurl = SITE_URL . "login.php";
                        $contactuslink = SITE_URL . "contact_us.php";
                        $helplink = SITE_URL . "help.php";



                        $detail4 = "<body style='background:#f2f2f2'>
                                    <div style='width:560px;height:auto;min-height:200px;background:#fff;border-radius:10px;margin: 0 auto;padding:55px;box-sizing: border-box;'>
                                        <img src='" . $logo . "' alt='' style='display: block;width:200px;margin: 0 auto;margin-bottom: 50px;height:30px;'/>

                                        <h2 style='color: #6e6e6e;font-size:15px;text-transform: uppercase;font-family: arial,sans-serif;font-weight:500;text-align: center;'>thank you for registering with us.</h2><br/>

                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 14px;line-height: 20px'>Your account is activated now</p>
                                        <table border='1' bordercolor='#ddd' style='border-collapse: collapse;width:100%;font-family: arial,sans-serif;color: #606060;font-size: 14px;'>
                                            <tr>
                                                <td style='padding: 7px'>Email</td>
                                                <td style='padding: 7px'>" . $useremail . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 7px'>Password</td>
                                                <td style='padding: 7px'>" . $userpassword . "</td>
                                            </tr>
                                        </table>
                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 50px'><a href='" . $loginurl . "' style='background: #EF3D4F;color:#fff;padding:7px 20px;border-radius:15px'>Click here To login</a></p>
                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px'>Thanks and Regards</p>
                                        <span style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;font-style: italic;'>Roomarate team</span>

                                        <hr style='border:0;border-top:1px solid #ddd;margin-top:20px'>
                                        <ul style='list-style: none;font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;padding: 0;display: table;margin: 0 auto;'>
                                            <li style='float:left;padding:0 10px;border-right:1px solid #ddd'><a href='" . $helplink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Help</a></li>
                                            <li style='float:left;padding:0 10px'><a href='" . $contactuslink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Contact Us</a></li>
                                        </ul>
                                    </div>
                                </body>";


                    $Subject = "Your Roomarate account is verifyed";


                    $TemplateMessage = $detail4;
                    $mail1 = new PHPMailer;
                    $mail1->FromName = "Roomarate";
                    $mail1->From = "info@roomarate.com";
                    $mail1->Subject = $Subject;



                    $mail1->Body = stripslashes($TemplateMessage);
                    $mail1->AltBody = stripslashes($TemplateMessage);
                    $mail1->IsHTML(true);
                    $mail1->AddAddress($useremail, "roomarate.com");
                    $mail1->Send();

                }

            }

            if($is_approved==1){
                header('Location:search_user_landlord.php');
            }else{
                header('Location:search_pendinguser_landlord.php');
            }

            exit();
        }
        // else {
        //     $_SESSION['MSG'] = 1;
        //     header('location:search_user_landlord.php');
        //     exit();
        // }
        else {

                if($is_approved==1)
                {
                        $username = $fname.' '.$lname;
                        $useremail = $email;


                        $userpassword = $password;


                        $logo = SITE_URL . "images/logo_black.svg";
                        $loginurl = SITE_URL . "login.php";
                        $contactuslink = SITE_URL . "contact_us.php";
                        $helplink = SITE_URL . "help.php";



                        $detail4 = "<body style='background:#f2f2f2'>
                                    <div style='width:560px;height:auto;min-height:200px;background:#fff;border-radius:10px;margin: 0 auto;padding:55px;box-sizing: border-box;'>
                                        <img src='" . $logo . "' alt='' style='display: block;width:200px;margin: 0 auto;margin-bottom: 50px;height:30px;'/>

                                        <h2 style='color: #6e6e6e;font-size:15px;text-transform: uppercase;font-family: arial,sans-serif;font-weight:500;text-align: center;'>thank you for registering with us.</h2><br/>

                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 14px;line-height: 20px'>Your account is activated now</p>
                                        <table border='1' bordercolor='#ddd' style='border-collapse: collapse;width:100%;font-family: arial,sans-serif;color: #606060;font-size: 14px;'>
                                            <tr>
                                                <td style='padding: 7px'>Email</td>
                                                <td style='padding: 7px'>" . $useremail . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 7px'>Password</td>
                                                <td style='padding: 7px'>" . $userpassword . "</td>
                                            </tr>
                                        </table>
                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 50px'><a href='" . $loginurl . "' style='background: #EF3D4F;color:#fff;padding:7px 20px;border-radius:15px'>Click here To login</a></p>
                                        <p style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px'>Thanks and Regards</p>
                                        <span style='font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;font-style: italic;'>Roomarate team</span>

                                        <hr style='border:0;border-top:1px solid #ddd;margin-top:20px'>
                                        <ul style='list-style: none;font-family: arial,sans-serif;color: #606060;font-size: 12px;line-height: 20px;padding: 0;display: table;margin: 0 auto;'>
                                            <li style='float:left;padding:0 10px;border-right:1px solid #ddd'><a href='" . $helplink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Help</a></li>
                                            <li style='float:left;padding:0 10px'><a href='" . $contactuslink . "' style='color: #606060;font-size: 12px;line-height: 16px;text-decoration: none'>Contact Us</a></li>
                                        </ul>
                                    </div>
                                </body>";


                    $Subject = "Your Roomarate account is verifyed";


                    $TemplateMessage = $detail4;
                    $mail1 = new PHPMailer;
                    $mail1->FromName = "Roomarate";
                    $mail1->From = "info@roomarate.com";
                    $mail1->Subject = $Subject;

                    // echo $detail4; exit;

                    $mail1->Body = stripslashes($TemplateMessage);
                    $mail1->AltBody = stripslashes($TemplateMessage);
                    $mail1->IsHTML(true);
                    $mail1->AddAddress($useremail, "roomarate.com");
                    $mail1->Send();

                }

                $addQuery = "INSERT INTO `estejmam_user` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";
                mysqli_query($link, $addQuery);

                if($is_approved==1){
                    header('Location:search_user_landlord.php');
                }else{
                    header('Location:search_pendinguser_landlord.php');
                }


            exit();
        }
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id`='" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'"));
}
?>
<?php include('includes/header.php'); ?>
<!-- END HEADER -->


<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('includes/left_panel.php'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
            <?php //include('includes/style_customize.php');        ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Renter
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#"> Renter</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Renter</span>
                    </li>
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Renter
                            </div>
                            <!--<div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>

                                    <a href="javascript:;" class="reload">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                            </div>-->
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />


                                <?php
                                if ($_SESSION['MSG'] == 1) {
                                    echo "<span style='color:red;margin-left: 278px;'>File Format Not Supported.</span>";
                                    $_SESSION['MSG'] = '';
                                }
                                ?>

                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">First Name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control allbox" placeholder="Enter First Name"  value="<?php echo $categoryRowset['fname']; ?>" name="fname" required>

                                        </div>
                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-3 control-label">Last name</label>
                                                                            <div class="col-md-4">
                                                                                <input type="text" class="form-control allbox" placeholder="Enter Last name" value="<?php echo $categoryRowset['lname']; ?>" name="lname" required>

                                                                            </div>
                                                                        </div>-->

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Gender</label>
                                        <div class="col-md-4">
                                            <select name="gender" class="form-control" required>
                                                <option value="">Select Gender</option>
                                                <option value="M"  <?php if ($categoryRowset['gender'] == 'M') { ?> selected <?php } ?>>Male</option>
                                                <option value="F" <?php if ($categoryRowset['gender'] == 'F') { ?> selected <?php } ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    $expdob = explode('-', $categoryRowset['dob']);
                                    $year = $expdob[0];
                                    $month = $expdob[1];
                                    $day = $expdob[2];
                                    ?>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Date of Birth</label>
                                        <div class="col-md-9">
<!--                                            <input type="text" class="form-control" placeholder="Date of Birth" value="<?php echo $categoryRowset['dob']; ?>" name="dob" id="dob" required>-->

                                            <div class="row">

                                                <div class="col-md-2">
                                                    <select name="day" class="form-control">
                                                        <option value="">Day</option>
                                                        <?php
                                                        for ($i = 1; $i <= 31; $i++) {
                                                            ?>
                                                            <option value="<?php echo $i ?>" <?php if ($day == $i) { ?> selected <?php } ?>><?php echo $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <select name="month" class="form-control">
                                                        <option value="">Month</option>
                                                        <?php
                                                        for ($j = 1; $j <= 31; $j++) {
                                                            ?>
                                                            <option value="<?php echo $j ?>" <?php if ($month == $j) { ?> selected <?php } ?>><?php echo $j ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <select name="year" class="form-control">
                                                        <option value="">Year</option>
                                                        <?php
                                                        $curdate = date('Y');
                                                        $fromyear = $curdate - 70;
                                                        $endyear = $curdate - 18;
                                                        for ($k = $fromyear; $k <= $endyear; $k++) {
                                                            ?>
                                                            <option value="<?php echo $k ?>" <?php if ($year == $k) { ?> selected <?php } ?>><?php echo $k ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Phone</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Enter Phone" value="<?php echo $categoryRowset['phone']; ?>" name="phone" id="phone" maxlength="12" required><span id="errmsg" style="color: red;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control" placeholder="Enter Email" value="<?php echo $categoryRowset['email']; ?>" name="email" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-4">
                                            <input type="password" class="form-control" placeholder="Enter Password"  name="password" required>

                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-4">
                                            <input type="text" id="autocomplete" onFocus="geolocate()" class="form-control" value="<?php echo $categoryRowset['address']; ?>" name="address" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Country</label>
                                        <div class="col-md-4">
                                            <input type="text" id="country" class="form-control allbox" placeholder="Enter Country" value="<?php echo $categoryRowset['country']; ?>" name="country" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">State/Province</label>
                                        <div class="col-md-4">
                                            <input type="text" id="administrative_area_level_1" class="form-control allbox" placeholder="Enter State" value="<?php echo $categoryRowset['state']; ?>" name="state" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">City</label>
                                        <div class="col-md-4">
                                            <input type="text" id="locality" class="form-control allbox" placeholder="Enter City" value="<?php echo $categoryRowset['city']; ?>" name="city" required>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Zip Code</label>
                                        <div class="col-md-4">
                                            <input type="text" id="postal_code" class="form-control" placeholder="Enter Zip Code" value="<?php echo $categoryRowset['zip']; ?>" name="zip" required>

                                        </div>
                                    </div>


                                 <div class="form-group">
                                                                            <label class="col-md-3 control-label">Status</label>
                                                                            <div class="col-md-4">
                                                                                <select class="form-control" name="is_approved" required>
                                                                                    <option value="">Select</option>
                                                                                    <option value="1" <?php if ($categoryRowset['is_approved'] == '1') { ?> selected <?php } ?>>Active</option>
                                                                                    <option value="0" <?php if ($categoryRowset['is_approved'] == '0') { ?> selected <?php } ?>>Deactive</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>



                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image Upload</label>
                                        <div class="col-md-2">
                                            <input type="file" name="image" class=" btn blue"  >
                                            <?php
                                            if ($categoryRowset['image'] != '') {
                                                $u_iamge = "../upload/userimages/" . $categoryRowset['image'];
                                            } else {
                                                $u_iamge = "../upload/no.png";
                                            }
                                            ?>
                                            <br><img src ="<?php echo $u_iamge; ?>" alt="" style="width:100px;">
                                            <?php if ($categoryRowset['image'] != '') { ?><br><a href="../upload/userimages/<?php echo $categoryRowset['image']; ?>" target="_blank"></a><?php } ?>

                                        </div>
                                    </div>



                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" value="Next" class="btn blue">
                                            <button type="button" class="btn default" onclick="location.href = 'search_user_host.php'">Cancel</button>
                                            <!--                                            <button type="button" class="btn default">Cancel</button>-->
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>



    <style>
        .thumb{
            height: 60px;
            width: 60px;
            padding-left: 5px;
            padding-bottom: 5px;
        }

    </style>

    <script>


        window.preview_this_image = function (input) {

            if (input.files && input.files[0]) {
                $(input.files).each(function () {
                    var reader = new FileReader();
                    reader.readAsDataURL(this);
                    reader.onload = function (e) {
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index:999;margin-top:-34px;'></span>");
                    }
                });
            }
        }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');         ?>
    <!-- END QUICK SIDEBAR -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php include('includes/footer.php'); ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/form-samples.js"></script>
<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function () {
            // initiate layout and plugins
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
            FormSamples.init();

            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    language: "xx"
                });
            }

        });

        $(document).ready(function () {

            $('.del_this').click(function (event) {
                var id = $(this).data('imgid');

                var divs = $(this);
                var formdata = {id: id, action: "deleteImg"};
                $.ajax({
                    url: "del_ajax.php",
                    type: "POST",
                    dataType: "json",
                    data: formdata,
                    success: function (data) {
                        if (data.ack == 1)
                        {

                            $(divs).closest('.div_div').remove();
                        }



                    }

                });
            });



            $(document).on("click", ".del_this", function () {
                $(this).parent().remove();

            });


        });

</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");

        $("#phone").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });

    });
</script>

<script type="text/javascript">
    $('.allbox').bind('keyup blur', function () {
        var node = $(this);
        node.val(node.val().replace(/[^a-z]/g, ''));
    }
    );
</script>


<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete;
    var componentForm = {
        //street_number: 'short_name',
        //route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

// [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
// [END region_geolocation]

</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete&key=AIzaSyBTxguvR1GhfFzDfUUZ7jQG6aG-CJuZZXk " async defer type="text/javascript"></script>


<script>
    $(function () {
        $("#dob").datepicker({format: 'yyyy-mm-dd'});
    });</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
