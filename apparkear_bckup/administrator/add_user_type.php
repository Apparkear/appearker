<?php
include_once("includes/config.php");
include_once('includes/session.php');
include_once("includes/functions.php");
include("../class.phpmailer.php");
require('../Twilio.php');

$adminDetails = mysql_fetch_object(mysql_query("SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));
if (isset($_REQUEST['submit'])) {
// if (!empty($_POST)) {

    $_REQUEST['menu_access'] = serialize($_REQUEST['menu_access']);
    // echo '<pre>'; print_r($_REQUEST); echo '</pre>'; exit;

    $fname      = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname      = isset($_POST['lname']) ? $_POST['lname'] : '';
    $email      = isset($_POST['email']) ? $_POST['email'] : '';
    $phone      = isset($_POST['phone']) ? $_POST['phone'] : '';
    $code       = isset($_POST['code']) ? $_POST['code'] : '';
    $address    = isset($_POST['address']) ? $_POST['address'] : '';
    $city       = isset($_POST['city']) ? $_POST['city'] : '';
    $country    = isset($_POST['country']) ? $_POST['country'] : '';
    $state      = isset($_POST['state']) ? $_POST['state'] : '';
    $zip        = isset($_POST['zip']) ? $_POST['zip'] : '';
    $gender     = isset($_POST['gender']) ? $_POST['gender'] : '';
    $ip         = $_SERVER['REMOTE_ADDR'];
    $date       = date("Y-m-d");
    $dob        = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
    $password   = isset($_POST['password']) ? $_POST['password'] : '';
    $dbpass     = md5($password);
    $status     = isset($_POST['status']) ? $_POST['status'] : '';

    $tenants_type = 1;
    $host_type = 1;
    $type = 2;




    $fields = array(
        'fname' => $fname,
        'lname' => $lname,
        'gender' => $gender,
        'email' => $email,
        'no_code' => $code,
        'phone' => $phone,
        'address' => $address,
        'city' => $city,
        'country' => $country,
        'state' => $state,
        'zip' => $zip,
        'ip' => $ip,
        'add_date' => $date,
        'dob' => $dob,
        'password' => $dbpass,
        'status' => $status,
        'tenants_type' => $tenants_type,
        'host_type' => $host_type,
        'type' => $type,
        'menu_access' => $_REQUEST['menu_access']
    );
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
                    . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";
            //exit;

            mysql_query($editQuery);

            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/userimages/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysql_query("UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
            }

            header('Location:search_user.php');
            exit();
        } else {
            $_SESSION['MSG'] = 1;
            header('Location:add_user_type.php?id=' . $_REQUEST['id'] . '&action=edit');
            exit();
        }
    } 
    else {  



        $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
        $fileParts = pathinfo($_FILES['image']['name']);

        if (in_array($fileParts['extension'], $fileTypes)) {

            $addQuery = "INSERT INTO `estejmam_user` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";

            //exit;
            mysql_query($addQuery);
            $last_id = mysql_insert_id();
            if ($_FILES['image']['tmp_name'] != '') {
                $target_path = "../upload/userimages/";
                $userfile_name = $_FILES['image']['name'];
                $userfile_tmp = $_FILES['image']['tmp_name'];
                $img_name = $userfile_name;
                $img = $target_path . $img_name;
                move_uploaded_file($userfile_tmp, $img);

                $image = mysql_query("UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . $last_id . "'");
            }
            
            $toemailAdmin = $adminDetails->email;
            $mailheaderAdmin = 'A new Agent is added';
            $toemailAgent = $email;
            $mailheaderAgent = 'Your new agent account is created';
            $user_email = $email;
            $password = $password;
            $phoneAdmin = $adminDetails->phone_no;
            $phoneAgent =$code.$phone;
	    MailFunction($toemailAgent,$mailheaderAgent,$user_email,$password,$_POST['code'].$_POST['phone']);    
            MailFunction($toemailAdmin,$mailheaderAdmin,$user_email,$password,$phoneAdmin);
          

            header('Location:search_user.php');
            exit();
        } else {
            // echo '<pre>'; print_r($_REQUEST); echo '</pre>';
            // exit;
            // $_SESSION['MSG'] = '1';
            $addQuery = "INSERT INTO `estejmam_user` (`" . implode('`,`', array_keys($fields)) . "`)"
                    . " VALUES ('" . implode("','", array_values($fields)) . "')";
            // echo $addQuery;
            // exit;        
            mysql_query($addQuery);

            $toemailAdmin = $adminDetails->email;
            $mailheaderAdmin = 'A new Agent is added';
            $toemailAgent = $email;
            $mailheaderAgent = 'Your new agent account is created';
            $user_email = $email;
            $password = $password;
            $phoneAdmin = $adminDetails->phone_no;
            $phoneAgent = $phone;
MailFunction($toemailAgent,$mailheaderAgent,$user_email,$password,$_POST['code'].$_POST['phone']);
            MailFunction($toemailAdmin,$mailheaderAdmin,$user_email,$password,$phoneAdmin);          
            header('Location:search_user.php');
            exit();
        }
    }
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_user` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
}

function MailFunction($toemail,$mailheader,$user_email,$password,$phone){


        try {
  $emailTemplate = mysql_fetch_array(mysql_query("SELECT * FROM estejmam_email_templt WHERE `id` =2"));
    
    
    $adminEmail = $toemail;

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";
    $loginurl = $login_url;
    $contactuslink = SITE_URL . "contact_us.php";
    $helplink = SITE_URL . "help.php";

   $detail4 = str_replace(
            array(
                '[user]',
                '[password]',
                '[login link]'
                ),
            array(
                $user_email,
                $password,
                'http://roomarate.com/administrator/'
                ),
            $emailTemplate['sms']
        );
                //----------- SMS TO USER START -------------//
        
                    $account_sid = 'AC740f0d30d09056acd3d2f6430d8e8dd0';
                    $auth_token = 'e71f23dc67ddcf9fa5ffcee7a8deccef';
                    $client = new Services_Twilio($account_sid, $auth_token);

                    // print_r($client->account->messages);
                    // $name = $_SESSION['name'];
                    // $phone = $all_details->telephone;
                    $sender['user_first_name'] = "Roomarate";
                    // echo '<pre>'; print_r($client); echo '</pre>'; exit;

                    $client->account->messages->create(array(
                        'To' => $phone,
                        'From' => "+15807012787",
                        'Body' =>str_replace('&nbsp;',' ',strip_tags($detail4))
                    ));
                    
                //----------- SMS TO USER END -------------//
                
            } catch (Exception $e) {
                $data['msg'] = $e->getMessage(); 
            }
    
    
    $emailTemplate = mysql_fetch_array(mysql_query("SELECT * FROM estejmam_email_templt WHERE `id` =2"));
    
    
    $adminEmail = $toemail;

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";
    $loginurl = $login_url;
    $contactuslink = SITE_URL . "contact_us.php";
    $helplink = SITE_URL . "help.php";

    $detail4 = str_replace(
            array(
                '[user]',
                '[password]',
                '[LOGIN]'
                ),
            array(
                $user_email,
                $password,
                'http://roomarate.com/administrator/'
                ),
            $emailTemplate['description']
        );

    $Subject = "A New Agent Added";
    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "Roomarate";
    $mail1->From = "roomarate@gmail.com";
    $mail1->Subject = $Subject;



    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($adminEmail, "roomarate.com");
    $mail1->Send();

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
            <?php //include('includes/style_customize.php');       ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Agent
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Agent</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent</span>
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
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Agent
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
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last name</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control allbox" placeholder="Enter Last name" value="<?php echo $categoryRowset['lname']; ?>" name="lname" required>

                                        </div>
                                    </div>

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
                                                        for ($j = 1; $j <=12; $j++) {
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
                                            <input type="text" class="form-control" placeholder="+44" value="<?php echo $categoryRowset['no_code']; ?>" name="code" id="phoneCode" maxlength="3" >
                                            <input type="text" class="form-control" placeholder="Enter Phone" value="<?php echo $categoryRowset['phone']; ?>" name="phone" id="phone" maxlength="14" required><span id="errmsg" style="color: red;"></span>
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
                                            <input type="text" id="autocomplete" onFocus="geolocate()" class="form-control" placeholder="Enter Address" value="<?php echo $categoryRowset['address']; ?>" name="address" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Country</label>
                                        <div class="col-md-4">
                                            <!-- <select name="country" id="country" class="form-control" onchange="changeState(this.value);"> -->
                                            <select name="country" id="country" class="form-control" >
                                                <option value="">Select Country</option>
                                                <?php
                                                $sq = mysql_query("select * from `countries` where 1");
                                                while ($qq = mysql_fetch_array($sq)) {
                                                    ?>
                                                    <option value="<?php echo $qq['id'] ?>" <?php if ($categoryRowset['country'] == $qq['id']) { ?> selected <?php } ?>><?php echo $qq['name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">State/Province</label>
                                        <div class="col-md-4">
                                            <!-- <select name="state" id="StateId" class="form-control" onchange="selectCity(this.value)"> -->
                                            <select name="state" id="StateId" class="form-control">    
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">City</label>
                                        <div class="col-md-4">
                                            <select name="city" id="CityId" class="form-control">
                                                <option value="">Select City</option>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Zip Code</label>
                                        <div class="col-md-4">
                                            <input type="text" id="postal_code" class="form-control" placeholder="Enter Zip Code" value="<?php echo $categoryRowset['zip']; ?>" name="zip" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Sidemenu Access</label>
                                        <div class="col-md-4">
                                            
                                            <?php 
                                                $menuAccess = unserialize($categoryRowset['menu_access']); 
                                                // echo '<pre>'; print_r($menuAccess); echo '</pre>'; 
                                            ?>
                                            
                                            <label>Site Setting</label> 
                                            <div class=""><span><input <?php if(in_array('site_setting', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="site_setting" name="menu_access[]" class="form-control"></span></div>
                                            <label>Banner</label> 
                                            <div class=""><span><input <?php if(in_array('banner', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="banner" name="menu_access[]" class="form-control"></span></div>
                                            <label>Defalt Banner</label> 
                                            <div class=""><span><input <?php if(in_array('defalt_banner', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="defalt_banner" name="menu_access[]" class="form-control"></span></div>
                                            <label>Booking</label> 
                                            <div class=""><span><input <?php if(in_array('booking', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="booking" name="menu_access[]" class="form-control"></span></div>
                                            <label>Booking In Review</label> 
                                            <div class=""><span><input <?php if(in_array('booking_in_review', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="booking_in_review" name="menu_access[]" class="form-control"></span></div>
                                            <label>Booking Accepted</label> 
                                            <div class=""><span><input <?php if(in_array('booking_accepted', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="booking_accepted" name="menu_access[]" class="form-control"></span></div>
                                            <label>Booking Dispute</label> 
                                            <div class=""><span><input <?php if(in_array('booking_dispute', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="booking_dispute" name="menu_access[]" class="form-control"></span></div>
                                            <label>Booking Canceled</label> 
                                            <div class=""><span><input <?php if(in_array('booking_canceled', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="booking_canceled" name="menu_access[]" class="form-control"></span></div>
                                            <label>Blog Category Management</label> 
                                            <div class=""><span><input <?php if(in_array('blog_category_management', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="blog_category_management" name="menu_access[]" class="form-control"></span></div>
                                            <label>Blog Management</label> 
                                            <div class=""><span><input <?php if(in_array('blog_management', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="blog_management" name="menu_access[]" class="form-control"></span></div>
                                            <label>Agent</label> 
                                            <div class=""><span><input <?php if(in_array('agent', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="agent" name="menu_access[]" class="form-control"></span></div>
                                            <label>Partners</label> 
                                            <div class=""><span><input <?php if(in_array('partners', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="partners" name="menu_access[]" class="form-control"></span></div>
                                            <label>Landlord</label> 
                                            <div class=""><span><input <?php if(in_array('landlord', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="landlord" name="menu_access[]" class="form-control"></span></div>
                                            <label>Country Wise City List</label> 
                                            <div class=""><span><input <?php if(in_array('country_wise_city_list', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="country_wise_city_list" name="menu_access[]" class="form-control"></span></div>
                                            <label>Contact US</label> 
                                            <div class=""><span><input <?php if(in_array('contact_us', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="contact_us" name="menu_access[]" class="form-control"></span></div>
                                            <label>Reviews</label> 
                                            <div class=""><span><input <?php if(in_array('reviews', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="reviews" name="menu_access[]" class="form-control"></span></div>
                                            <label>Backups</label> 
                                            <div class=""><span><input <?php if(in_array('backup', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="backup" name="menu_access[]" class="form-control"></span></div>
                                            <label>Testimonials</label> 
                                            <div class=""><span><input <?php if(in_array('testimonial', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="testimonial" name="menu_access[]" class="form-control"></span></div>
                                            <label>Email Template</label> 
                                            <div class=""><span><input <?php if(in_array('email_template', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="email_template" name="menu_access[]" class="form-control"></span></div>
                                            <label>Properties</label> 
                                            <div class=""><span><input <?php if(in_array('properties', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="properties" name="menu_access[]" class="form-control"></span></div>
                                            <label>Our Clients</label> 
                                            <div class=""><span><input <?php if(in_array('our_clients', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="our_clients" name="menu_access[]" class="form-control"></span></div>
                                            <label>Homepage Management</label> 
                                            <div class=""><span><input <?php if(in_array('homepage_management', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="homepage_management" name="menu_access[]" class="form-control"></span></div>
                                            <label>Footer Management</label> 
                                            <div class=""><span><input <?php if(in_array('footer_management', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="footer_management" name="menu_access[]" class="form-control"></span></div>
                                            <label>Header Management</label> 
                                            <div class=""><span><input <?php if(in_array('header_management', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="header_management" name="menu_access[]" class="form-control"></span></div>
                                            <label>Settings</label> 
                                            <div class=""><span><input <?php if(in_array('settings', $menuAccess)){ echo 'checked'; } ?> type="checkbox" value="settings" name="menu_access[]" class="form-control"></span></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Status</label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="status" required>
                                                <option value="">Select</option>
                                                <option value="1" <?php if ($categoryRowset['status'] == '1') { ?> selected <?php } ?>>Active</option>
                                                <option value="0" <?php if ($categoryRowset['status'] == '0') { ?> selected <?php } ?>>Deactive</option>
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
                                            <input type="submit" name="submit" value="Save" class="btn blue">
                                            <button type="button" class="btn default" onclick="location.href = 'search_user.php'">Cancel</button>
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


    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');          ?>
    <!-- END QUICK SIDEBAR -->
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
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


<script type="text/javascript" >

        // function changeState(val)
        // {
        //     console.log('Hiii');
        //     $.ajax({
        //         type: "post",
        //         url: "ajax_state.php",
        //         data: {stId: val, userid:<?php echo $_REQUEST['id'] ?>},
        //         success: function (msg) {
        //             $('#StateId').html(msg);
        //         }
        //     });
        // }



        // function selectCity(val)
        // {

        //     $.ajax({
        //         type: "post",
        //         url: "ajax_city.php",
        //         data: {stId: val, userid:<?php echo $_REQUEST['id'] ?>},
        //         success: function (msg) {
        //             $('#CityId').html(msg);
        //         }
        //     });

        // }

        $("#country").change(function(){
            var val = $(this).val();
            $.ajax({
                type: "post",
                url: "ajax_state.php",
                data: {id: val, userid:'<?php echo $_REQUEST["id"] ?>'},
                success: function (msg) {
                    $('#StateId').html(msg);
                }
            });
        })

        $("#StateId").change(function(){
            var val = $(this).val();
            $.ajax({
                type: "post",
                url: "ajax_city.php",
                data: {id: val, userid:'<?php echo $_REQUEST["id"] ?>'},
                success: function (msg) {
                    $('#CityId').html(msg);
                }
            });
        })

</script>



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



<?php
// if ($_REQUEST['action'] == 'edit') {
    ?>
    <script>
        // changeState('<?php echo $categoryRowset["country"] ?>', '<?php echo $_REQUEST["id"] ?>');
        // selectCity('<?php echo $categoryRowset["state"] ?>', '<?php echo $_REQUEST["id"] ?>');
    </script>
    <?php
// }
?>



<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");


        // $("#phone").keypress(function (e) {
        //     //if the letter is not digit then display error and don't type anything
        //     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //         //display error message
        //         $("#errmsg").html("Digits Only").show().fadeOut("slow");
        //         return false;
        //     }
        // });


    });
</script>












<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
