<?php
ob_start();
session_start();
include("./includes/config.php");
require_once("../class.phpmailer.php");
require('../Twilio.php');
include("../include/helpers.php");
//include_once("controller/productController.php");
mysqli_query($link, "SET SESSION character_set_results = 'UTF8'");
header('Content-Type: text/html; charset=UTF-8');

unset($_SESSION['prop_id']);

$adminDetails = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from estejmam_main_property where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:list_product.php');
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'unfeatured') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set is_featured='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'featured') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set is_featured='1' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}



if (isset($_GET['action']) && $_GET['action'] == 'inactive') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set status='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:list_product.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_main_property set status='1' where id='" . $item_id . "'");

    $propDetails = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id` = " . $item_id));
    $lanlordDetails = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id` = " . $propDetails['user_id']));

    //echo '<pre>'; print_r($propDetails); echo '</pre>';
    //echo '<pre>'; print_r($lanlordDetails); echo '</pre>';
    //exit;

    $email = $lanlordDetails['email'];
    $landlordName = $lanlordDetails['lname'] . ' ' . $lanlordDetails['fname'];
    $property_name = $propDetails['name'];
    $property_address = $propDetails['street_addr'];
    $textLandlord = 'Hi. ' . $lanlordDetails['fname'] . ' ' . $lanlordDetails['lname'] . ' one of Your Property,"' . $propDetails['name'] . '" is published by admin';
    $textAdmin = $lanlordDetails['fname'] . ' ' . $lanlordDetails['lname'] . ' one  Property,"' . $propDetails['name'] . '" is published by admin';
    $Subject = 'Property is Published';

    $emailLandlord = $email;
    $emailAdmin = $adminDetails->email;
    $emailTemplate1 = mysqli_query($link, "SELECT * FROM `estejmam_team` WHERE `template_id`=1");
    while ($row = mysqli_fetch_array($emailTemplate1)) {
        $agent_id = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_user WHERE `id` = '" . $row['agent_id'] . "'"));
        $emailAdmin .= ',' . $agent_id['email'];
    }
    $phoneLandlord = $lanlordDetails['phone'];
    $phoneAdmin = $adminDetails->phone_no;
    $loginurl = SITE_URL . 'login.php';
    if (isset($lanlordDetails['is_email']) && $lanlordDetails['is_email'] == 1) {
        sendMailFromTemplate(4, array("[EMAIL]", "[PASSWORD]", "[LINK]", "[LOGINURL]"), array($lanlordDetails['email'], $lanlordDetails['text_password'], $loginurl, $loginurl), $lanlordDetails['email'], $phoneLandlord, true);
//        activationMail1($emailLandlord, $landlordName, $lanlordDetails['email'], $lanlordDetails['text_password'], $Subject, $phoneLandlord);
//        activationMail2($emailAdmin, $landlordName, $lanlordDetails['email'], $lanlordDetails['text_password'], $Subject, $phoneAdmin);
    } else {
        sendMailFromTemplate(4, array("[EMAIL]", "[PASSWORD]", "[LINK]", "[LOGINURL]"), array($lanlordDetails['email'], $lanlordDetails['text_password'], $loginurl, $loginurl), $lanlordDetails['email'], $phoneLandlord, true);
//        activationMaillandlord($emailLandlord, $landlordName, $lanlordDetails['email'], $lanlordDetails['text_password'], $Subject, $phoneLandlord);
//        activationMail($emailAdmin, $landlordName, $lanlordDetails['email'], $lanlordDetails['text_password'], $Subject, $phoneAdmin);
    }


    $teamSQL = mysqli_query($link, "SELECT * FROM estejmam_team LEFT JOIN estejmam_user ON estejmam_team.agent_id = estejmam_user.id WHERE `template_id`= 4 ");
    while ($teamData = mysqli_fetch_array($teamSQL)) {

        $toteamemail = $teamData['email'];
        $toteamphone = $teamData['no_code'] . $teamData['phone'];
        if (isset($lanlordDetails['is_email']) && $lanlordDetails['is_email'] == 1) {

        } else {
//            activationMail($toteamemail, $landlordName, $lanlordDetails['email'], $lanlordDetails['text_password'], $Subject, $toteamphone);
            sendMailFromTemplate(4, array("[EMAIL]", "[PASSWORD]", "[LINK]", "[LOGINURL]"), array($lanlordDetails['email'], $lanlordDetails['text_password'], $loginurl, $loginurl), $teamData['email'], $toteamphone, true);
        }
    }

    mysqli_query($link, "update `estejmam_user` set `is_email`='1' where id='" . $propDetails['user_id'] . "'");

    header('Location:list_product.php');
    exit();
}

function activationMaillandlord($toemail, $lname, $lemail, $lpassword, $Subject,
        $phone)
{

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_email_templt` WHERE `id`=4"));
    $loginurl = SITE_URL . 'login.php';
//    $sms = str_replace(
//            array(
//        '[LOGIN]',
//        '[EMAIL]',
//        '[PASSWORD]'
//            ), array(
//        $lname,
//        $lemail,
//        $lpassword
//            ), strip_tags($emailTemplate['sms'])
//    );

    $sms = str_replace(
            array(
        '[EMAIL]',
        '[PASSWORD]',
        '[LINK]'
            ), array(
        $lemail,
        $lpassword,
        $loginurl
            ), strip_tags($emailTemplate['sms'])
    );
    try {

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
            'Body' => str_replace('&nbsp;', ' ', $sms)
        ));

        //----------- SMS TO USER END -------------//
    } catch (Exception $e) {
        $data['msg'] = $e->getMessage();
    }

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";


    $detail4 = str_replace(
            array(
        '[Landlord]',
        '[EMAIL]',
        '[PASSWORD]',
        '[LOGO]',
        '[LOGINURL]'
            ), array(
        $lname,
        $lemail,
        $lpassword,
        $logo,
        $loginurl
            ), $emailTemplate['description']
    );

    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "The Roomarate Team";
    $mail1->From = "info@roomarate.com";
    $mail1->Subject = $Subject;

    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($toemail, "roomarate.com"); //info@salaryleak.com
    $mail1->Send();
}

function activationMail($toemail, $lname, $lemail, $lpassword, $Subject, $phone)
{

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_email_templt` WHERE `id`=4"));
    $loginurl = SITE_URL . 'login.php';
//    $sms = str_replace(
//            array(
//        '[LOGIN]',
//        '[EMAIL]',
//        '[PASSWORD]'
//            ), array(
//        $lname,
//        $lemail,
//        $lpassword
//            ), strip_tags($emailTemplate['sms'])
//    );

    $sms = str_replace(
            array(
        '[EMAIL]',
        '[PASSWORD]',
        '[LINK]'
            ), array(
        $lemail,
        $lpassword,
        $loginurl
            ), strip_tags($emailTemplate['sms'])
    );


    try {

        //----------- SMS TO USER START -------------//

        $account_sid = 'AC740f0d30d09056acd3d2f6430d8e8dd0';
        $auth_token = 'e71f23dc67ddcf9fa5ffcee7a8deccef';
        $client = new Services_Twilio($account_sid, $auth_token);

        // print_r($client->account->messages);
        // $name = $_SESSION['name'];
        // $phone = $all_details->telephone;
        $sender['user_first_name'] = "Roomarate";
        // echo '<pre>'; print_r($client); echo '</pre>'; exit;
//        $client->account->messages->create(array(
//            'To' => $phone,
//            'From' => "+15807012787",
//            'Body' => str_replace('&nbsp;', ' ', $sms)
//        ));
        //----------- SMS TO USER END -------------//
    } catch (Exception $e) {
        $data['msg'] = $e->getMessage();
    }

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";


    $detail4 = str_replace(
            array(
        '[Landlord]',
        '[EMAIL]',
        '[PASSWORD]',
        '[LOGO]',
        '[LOGINURL]'
            ), array(
        $lname,
        $lemail,
        $lpassword,
        $logo,
        $loginurl
            ), $emailTemplate['description']
    );

    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "The Roomarate Team";
    $mail1->From = "info@roomarate.com";
    $mail1->Subject = $Subject;

    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($toemail, "roomarate.com"); //info@salaryleak.com
    $mail1->Send();
}

function activationMail1($toemail, $lname, $lemail, $lpassword, $Subject, $phone)
{

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_email_templt` WHERE `id`=4"));
    $loginurl = SITE_URL . 'login.php';
//    $sms = str_replace(
//            array(
//        '[LOGIN]',
//        '[EMAIL]',
//        '[PASSWORD]'
//            ), array(
//        $lname,
//        $lemail,
//        $lpassword
//            ), strip_tags($emailTemplate['sms'])
//    );

    $sms = str_replace(
            array(
        '[EMAIL]',
        '[PASSWORD]',
        '[LINK]'
            ), array(
        $lemail,
        $lpassword,
        $loginurl
            ), strip_tags($emailTemplate['sms'])
    );


    /* try {

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
      'Body' => str_replace('&nbsp;', ' ', $sms)
      ));

      //----------- SMS TO USER END -------------//
      } catch (Exception $e) {
      $data['msg'] = $e->getMessage();
      } */

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";


    $detail4 = str_replace(
            array(
        '[Landlord]',
        '[EMAIL]',
        '[PASSWORD]',
        '[LOGO]',
        '[LOGINURL]'
            ), array(
        $lname,
        $lemail,
        $lpassword,
        $logo,
        $loginurl
            ), $emailTemplate['description']
    );

    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "The Roomarate Team";
    $mail1->From = "info@roomarate.com";
    $mail1->Subject = $Subject;

    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($toemail, "roomarate.com"); //info@salaryleak.com
    $mail1->Send();
}

function activationMail2($toemail, $lname, $lemail, $lpassword, $Subject, $phone)
{

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_email_templt` WHERE `id`=4"));
    $loginurl = SITE_URL . 'login.php';
//    $sms = str_replace(
//            array(
//        '[LOGIN]',
//        '[EMAIL]',
//        '[PASSWORD]'
//            ), array(
//        $lname,
//        $lemail,
//        $lpassword
//            ), strip_tags($emailTemplate['sms'])
//    );

    $sms = str_replace(
            array(
        '[EMAIL]',
        '[PASSWORD]',
        '[LINK]'
            ), array(
        $lemail,
        $lpassword,
        $loginurl
            ), strip_tags($emailTemplate['sms'])
    );


    try {

        //----------- SMS TO USER START -------------//

        $account_sid = 'AC740f0d30d09056acd3d2f6430d8e8dd0';
        $auth_token = 'e71f23dc67ddcf9fa5ffcee7a8deccef';
        $client = new Services_Twilio($account_sid, $auth_token);

        // print_r($client->account->messages);
        // $name = $_SESSION['name'];
        // $phone = $all_details->telephone;
        $sender['user_first_name'] = "Roomarate";
        // echo '<pre>'; print_r($client); echo '</pre>'; exit;
//        $client->account->messages->create(array(
//            'To' => $phone,
//            'From' => "+15807012787",
//            'Body' => str_replace('&nbsp;', ' ', $sms)
//        ));
        //----------- SMS TO USER END -------------//
    } catch (Exception $e) {
        $data['msg'] = $e->getMessage();
    }

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";


    $detail4 = str_replace(
            array(
        '[Landlord]',
        '[EMAIL]',
        '[PASSWORD]',
        '[LOGO]',
        '[LOGINURL]'
            ), array(
        $lname,
        $lemail,
        $lpassword,
        $logo,
        $loginurl
            ), $emailTemplate['description']
    );

    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "The Roomarate Team";
    $mail1->From = "info@roomarate.com";
    $mail1->Subject = $Subject;

    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($toemail, "roomarate.com"); //info@salaryleak.com
    $mail1->Send();
}
?>


<?php
if (isset($_POST['ExportCsv'])) {


    $sql = "select * from estejmam_main_property where ";

    $query = mysqli_query($link, $sql);

    $output = '';

    $output .= 'Prop ID,Property Type,Name,Desc,Price,Added By,Added Date,status';

    $output .= "\n";

    if (mysqli_num_rows($query) > 0) {
        while ($result = mysqli_fetch_assoc($query)) {


            $proptype = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_property_type` where `id`='" . $result['prop_type'] . "'"));
            $user = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $result['user_id'] . "'"));

            if ($result['status'] == 1) {
                $allstat = "Active";
            } else {
                $allstat = "Not Active";
            }


            $prop_ID = $result['id'];
            $prop_type = $proptype['name'];
            $name = $result['name'];
            $description = $result['description'];
            $price = $result['price'];
            $addedby = $user['fname'];
            $add_date = $result['created_date'];
            $status = $allstat;





            if ($prop_ID != "") {
                $output .= '"' . $prop_ID . '","' . $prop_type . '","' . $name . '","' . $description . '","' . $price . '","' . $addedby . '","' . $add_date . '","' . $status . '"';
                $output .= "\n";
            }
        }
    }



    $filename = "myFile" . time() . ".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename=' . $filename);



    echo $output;

    //echo'<pre>';
    //print_r($result);

    exit;
}
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "list_product.php?cid=" + aa + "&action=delete"
        }
    }

    function featured(aa)
    {
        location.href = "list_product.php?cid=" + aa + "&action=featured"

    }
    function unfeatured(aa)
    {
        location.href = "list_product.php?cid=" + aa + "&action=unfeatured";
    }


    function active(aa)
    {
        location.href = "list_product.php?cid=" + aa + "&action=active"

    }
    function inactive(aa)
    {
        location.href = "list_product.php?cid=" + aa + "&action=inactive";
    }

</script>
<?php include("includes/header.php"); ?>
<div class="clearfix">
</div>
<style>
    #mailButton{
        margin-top: 2px;
        padding: 5px;
        margin-left: 12px;
        cursor: default;
    }
</style>
<?php
if($_REQUEST['searchbyid']!=""){
    $searchbyid=intval($_REQUEST['searchbyid']);
    if($searchbyid!=0)
        $where[]="id LIKE '%{$searchbyid}%'";
}
 ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include("includes/left_panel.php"); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->

            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property list
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="index.html">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Property list</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <!--<li>
                            <a href="#">Editable Datatables</a>
                    </li>-->
                </ul>

            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                Property list
                                    <!--<i class="fa fa-edit"></i>Editable Table-->
                            </div>
                            <div class="tools">
                                <!--                                <a href="javascript:;" class="collapse"></a>-->

                                <!--<a href="#portlet-config" data-toggle="modal" class="config">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                                <a href="javascript:;" class="remove">
                                </a>-->

                               <!--                                  <form action="" method="post">
                                                                    <i class="fa fa-edit"></i>Editable Table
                                                                    <button type="submit" class="btn btn-primary"  name="ExportCsv"> Export Property</button>
                                                                </form> -->
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
<div class="col-md-6">
    <div class="btn-group">
    <form method="GET">
        <input type="text" name="searchbyid" value='<?php echo $searchbyid; ?>' placeholder="Search By Id">
        <button class="btn blue" id="" type="submit">
            <i class="fa fa-search"></i>
            Search
        </button>
        <a href="<?php echo SITE_URL."administrator/list_product.php"; ?>" class="btn red">Reset</a>
    </form>

    </div>
</div>
                                    <!--									<div class="col-md-6">
                                                                                                                    <div class="btn-group">
                                                                                                                            <button id="sample_editable_1_new" class="btn blue">
                                                                                                                            Add New <i class="fa fa-plus"></i>
                                                                                                                            </button>
                                                                                                                    </div>                                                                                                           </div>-->
                                    <!--									<div class="col-md-6">
                                                                                                                    <div class="btn-group pull-right">
                                                                                                                            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                                                                                                            </button>
                                                                                                                            <ul class="dropdown-menu pull-right">
<li>
                                                                                                                                            <a href="#">
                                                                                                                                            Print </a>
                                                                                                                                    </li>
                                                                                                                                    <li>
                                                                                                                                            <a href="#">
                                                                                                                                            Save as PDF </a>
                                                                                                                                    </li>
                                                                                                                                    <li>
                                                                                                                                            <a href="#">
                                                                                                                                            Export to Excel </a>
                                                                                                                                    </li>
                                                                                                                            </ul>
                                                                                                                    </div>
                                                                                                            </div>-->
                                </div>
                            </div>
                            <!-- <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/> -->
                            <table class="table table-striped table-hover table-bordered" >
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Property Name</th>
                                        <th>Address</th>
                                        <th>Property Id</th>
                                        <th>Price</th>
                                        <th>Added By</th>
                                        <!-- <th>Status</th> -->
                                        <th>Created On</th>
                                        <!--<th>Property Link</th>-->
                                        <!-- <th>Make Featured</th> -->
                                        <th>Actions</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                // Pagination
                                include dirname(__FILE__)."/../class/class.paginator.php";
                                if($where){
                                        $where="WHERE ".implode(" AND ",$where);
                                }
                                // Pagination
                                $perpage=50;
                                $current_page=intval($_GET['page']);
                                $total = mysqli_fetch_assoc(mysqli_query($link, "SELECT count(*) as count FROM estejmam_main_property $where"));

                                $pagination = new Pagination($current_page,$perpage);
                                $pages = $pagination->CreatePages($total['count'],"google");
                                $start = $pagination->_start;
                                // TMP CONFIG
                                $all= $pagination->_arrayPages;
                                // echo ROOT_DIR;
                                $markers = $pagination->_indexes;
                                $last = $pagination->_totalPages;
                                $prev = $pagination->_previousPage;
                                $next = $pagination->_nextPage;

                                    $fetch_product = mysqli_query($link, "select * from estejmam_main_property $where order by `status`,`id` DESC LIMIT $start,$perpage");
                                    $num = mysqli_num_rows($fetch_product);
                                    if ($num > 0) {
                                        while ($product = mysqli_fetch_array($fetch_product)) {

                                            $sql_uploader_details = mysqli_fetch_object(mysqli_query($link, "select * from estejmam_user where `id` = '" . $product['agent_id'] . "'"));
                                            $fetch_currency = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_currency` where `id`='" . $product['currency'] . "'"));
                                            $image = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_image` WHERE `prop_id`='" . $product['id'] . "'"));
                                            if ($image['image'] != '') {
                                                if(file_exists(ROOT_DIR.'/upload/property/cached/'.$image['image']))
                                                    $image_link='upload/property/cached/'.$image['image'];
                                                else
                                                    $image_link = 'upload/property/' . $image['image'];
                                            } else {
                                                $image_link = 'upload/no.png';
                                            }

                                            if ($product['agent_id'] != '0') {
                                                $added_by = $sql_uploader_details->fname . ' ' . $sql_uploader_details->lname;
                                            } else {
                                                $added_by = "Admin";
                                            }
                                            ?>

                                            <tr>
                                            <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $product['id']; ?>"/></td>-->
                                                <td>
                                                    <img src="https://www.roomarate.com/<?php echo $image_link; ?>"  width="100" style="border:1px solid #666666" />
                                                </td>
                                                <td>
                                                    <?php echo stripslashes($product['name']); ?>
                                                </td>
                                                <td>
                                                    <?php echo stripslashes($product['street_addr']); ?>
                                                </td>

                                                <td>
                                                    <?php echo stripslashes($product['id']); ?>
                                                </td>

                                                <td>
                                                    &pound;<?php echo $product['price']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $added_by; ?>
                                                </td>

                                                <!-- <td>
                                                    <?php if ($product['status'] == '0') { ?>
                                                        <a class="btn btn-danger"  onClick="javascript:active('<?php echo $product['id']; ?>');">Make Publish</a>
                                                    <?php } else { ?>
                                                        <a class="btn btn-success"  onClick="javascript:inactive('<?php echo $product['id']; ?>');">Un Publish</a>
                                                        <a class="btn btn-info btn-sm " id="mailButton"  href="javascript:void(0)">Mail Send</a>
                                                    <?php } ?>
                                                </td> -->

                                                <td>
                                                    <?php echo stripslashes($product['created_date']); ?>
                                                </td>                                                                                                                                                      <!-- <td>
                                                     a href="javascript:void(0);">Click Here</a>
                                                                                                                                                        </td>-->



                                                                                                                                                        <!-- <td>
                                                <?php if ($product['is_featured'] == '0') { ?>                                                                                                                                                                                                                   <a class="btn btn-danger"  onClick="javascript:featured('<?php echo $product['id']; ?>');">Make Feature</a>
                                                <?php } else { ?>                                                                                                                                                                                                                    <a class="btn btn-success"  onClick="javascript:unfeatured('<?php echo $product['id']; ?>');">Unfeatured</a>
                                                <?php } ?>                                                                                                                                                        </td> -->



                                                <td>
                                                    <a class="btn btn-success btn-sm" href="property_details.php?id=<?php echo $product['id'] ?>&action=details"><i class="fa fa-eye"></i></a>
<!--                                                    <a class="btn btn-warning btn-sm" href="view_calender.php?id=<?php echo $product['id'] ?>&action=view"><i class="fa fa-calendar"></i></a>-->

                                                    <a class="btn btn-info btn-sm" href="add_property.php?id=<?php echo $product['id'] ?>&action=edit"><i class="fa fa-pencil"></i></a>


                                                    <a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $product['id']; ?>')"><i class="fa fa-close"></i></a>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">Sorry, no record found.</td>
                                        </tr>

                                        <?php
                                    }
                                    ?>




                                </tbody>
                            </table>
                             <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            </form>
                        </div>
                    </div>
                        <nav class="c-pagination">
                    <ul class="pagination">
                <?php if($current_page!=1){ ?>
                    <li><a href="<?php echo $PHP_SELF; ?>?page=<?php echo $prev; ?>" onclick="CallTPL(<?php echo $prev;?>);return false;" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                <?php } ?>
                <?php foreach($markers as $pagenum) {
                    $active=($current_page==$pagenum)?"class=\"active\"":"";
                    ?>
                    <li <?php echo $active; ?>><a href="<?php echo $PHP_SELF; ?>?page=<?php echo $pagenum; ?>" data-pageid="<?php echo $pagenum; ?>"><?php echo $pagenum; ?></a></li>
                    <!-- <li <?php echo $active; ?>><a href="<?php echo $PHP_SELF; ?>?page=<?php echo $pagenum; ?>" onclick="CallTPL(<?php echo $pagenum;?>);return false;"><?php echo $pagenum; ?></a></li> -->

                <?php } ?>

              <!--   <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li> -->
                <?php if($last!=$current_page && $next!=1) { ?>
                    <li><a href="<?php echo $PHP_SELF; ?>?page=<?php echo $next; ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                <?php } ?>
                    </ul>
                    </nav>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT -->
        </div>
    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="page-footer">
    <?php include("includes/footer.php"); ?>
</div>
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
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-editable.js"></script>
<script>
                                                        jQuery(document).ready(function () {
                                                            Metronic.init(); // init metronic core components
                                                            Layout.init(); // init current layout
                                                            QuickSidebar.init(); // init quick sidebar
                                                            Demo.init(); // init demo features
                                                            TableEditable.init();
                                                        });
</script>

<script type="text/javascript">
    function deleteConfirm() {
        var result = confirm("Are you sure to delete product?");
        if (result) {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length)
            {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });
    });



</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });
</script>
</body>
<!-- END BODY -->
</html>
