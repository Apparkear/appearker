<?php
ob_start();
session_start();
include 'includes/config.php';
include("../class.phpmailer.php");
require('../Twilio.php');

//include_once("controller/productController.php");

function productkeygenarate() {
    $productcodeformat = "PRD00000";
    $keychk = mysqli_num_rows(mysqli_query($link, "select * from `estejmam_main_property` where 1"));
    if ($keychk == 0) {
        $unique_prop_id = "PRD00001";
    } else {
        $chk = mysqli_fetch_array(mysqli_query($link, "SELECT max(`id`) as `max_key` FROM `estejmam_main_property` WHERE 1"));
        $unique_prop_id = $chk['max_key'] + 1;
    }
    $pro_key = substr($productcodeformat, 0, -(strlen($unique_prop_id))) . $unique_prop_id;
    return $pro_key;
}

$nametype = mysqli_query($link, "select * from estejmam_main_property where id<>'' AND  prop_type <>'2'");



if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysqli_real_escape_string($link, $_SESSION['prop_id']) . "'"));
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_main_property` WHERE `id`='" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'"));
}




if (isset($_REQUEST['submit'])) {


    $tubemaps = array();

    $i = 0;
    if (!empty($_REQUEST['map'])) {
        foreach ($_REQUEST['map']['tubename'] as $key => $tname) {
            $tubemaps[$i]['name'] = $tname;
            $i++;
        }

        $j = 0;
        foreach ($_REQUEST['map']['tubedistance'] as $key => $tdis) {
            $tubemaps[$j]['distance'] = $tdis;
            $j++;
        }
        $k = 0;
        foreach ($_REQUEST['map']['icon'] as $key => $ticon) {
            $tubemaps[$k]['icon'] = $ticon;
            $k++;
        }
    } else {
        $tubemaps = array();
    }
    //echo '<pre>'; print_r($tubemaps); echo '</pre>';
    //exit;

    $sutable_for_val = isset($_POST['sutable_for']) ? $_POST['sutable_for'] : '';
    $sutable_for = implode(',', $sutable_for_val);


    $user_id = $_REQUEST['user_id'];
    $agent_id = $_REQUEST['agent_id'];

    $bedrooms = isset($_POST['bedrooms']) ? $_POST['bedrooms'] : '';
    $beds = isset($_POST['beds']) ? $_POST['beds'] : '';
    $bathrooms = isset($_POST['bathrooms']) ? $_POST['bathrooms'] : '';
    $prop_type = isset($_POST['prop_type']) ? $_POST['prop_type'] : '';
    $bedtype = isset($_POST['bedtype']) ? $_POST['bedtype'] : '';
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';

    $not_included = isset($_POST['not_included']) ? $_POST['not_included'] : '';

    $ninimum_stay = isset($_POST['ninimum_stay']) ? $_POST['ninimum_stay'] : '';
    $maximum_stay = isset($_POST['maximum_stay']) ? $_POST['maximum_stay'] : '';
    $type_of_contract = isset($_POST['type_of_contract']) ? $_POST['type_of_contract'] : '';

    $host_type = isset($_POST['host_type']) ? $_POST['host_type'] : '';
    $gender_type = isset($_POST['gender_type']) ? $_POST['gender_type'] : '';
    $startblockdate = isset($_POST['startblockdate']) ? $_POST['startblockdate'] : '';
    $endblockdate = isset($_POST['endblockdate']) ? $_POST['endblockdate'] : '';
    $date = date("Y-m-d");
//    $lat = '00.0000000';
//    $lng = '00.0000000';


    $lat = isset($categoryRowset['lat']) ? $categoryRowset['lat'] : '00.0000000';
    $lng = isset($categoryRowset['lng']) ? $categoryRowset['lng'] : '00.0000000';

    $room_left = isset($_POST['room_left']) ? $_POST['room_left'] : '';
    $deposit_amount = isset($_POST['deposit_amount']) ? $_POST['deposit_amount'] : '';
    $squar_feet = isset($_POST['squar_feet']) ? $_POST['squar_feet'] : '';
    $is_furnised = isset($_POST['is_furnised']) ? $_POST['is_furnised'] : '';
    $available_from = isset($_POST['available_from']) ? $_POST['available_from'] : '';
    $falmatesno_of_living = isset($_POST['falmatesno_of_living']) ? $_POST['falmatesno_of_living'] : '';
    $occupation_housemate = isset($_POST['occupation_housemate']) ? $_POST['occupation_housemate'] : '';
    $current_flamets_age = isset($_POST['current_flamets_age']) ? $_POST['current_flamets_age'] : '';
    $current_flamets_ageto = isset($_POST['current_flamets_ageto']) ? $_POST['current_flamets_ageto'] : '';
    $housemate_gender = isset($_POST['housemate_gender']) ? $_POST['housemate_gender'] : '';
    $housemate_somking = isset($_POST['housemate_somking']) ? $_POST['housemate_somking'] : '';
    $preferred_gender = isset($_POST['preferred_gender']) ? $_POST['preferred_gender'] : '';
    $preferred_occupation = isset($_POST['preferred_occupation']) ? $_POST['preferred_occupation'] : '';
    $preferred_agefrom = isset($_POST['preferred_agefrom']) ? $_POST['preferred_agefrom'] : '';
    $preferred_ageto = isset($_POST['preferred_ageto']) ? $_POST['preferred_ageto'] : '';
    $i_am = isset($_POST['i_am']) ? $_POST['i_am'] : '';
    $house_rule = isset($_POST['house_rule']) ? $_POST['house_rule'] : '';

    $fields = array(
        'bedrooms' => mysqli_real_escape_string($link, $bedrooms),
        'beds' => mysqli_real_escape_string($link, $beds),
        'parent_id' => mysqli_real_escape_string($link, $parent_id),
        'bathrooms' => mysqli_real_escape_string($link, $bathrooms),
        'prop_type' => mysqli_real_escape_string($link, $prop_type),
        'bed_type' => mysqli_real_escape_string($link, $bedtype),
        'created_date' => mysqli_real_escape_string($link, $date),
        'edited_date' => mysqli_real_escape_string($link, $date),
        'lat' => mysqli_real_escape_string($link, $lat),
        'lng' => mysqli_real_escape_string($link, $lng),
        'sutable_for' => mysqli_real_escape_string($link, $sutable_for),
        'not_included' => mysqli_real_escape_string($link, $not_included),
        'ninimum_stay' => mysqli_real_escape_string($link, $ninimum_stay),
        'maximum_stay' => mysqli_real_escape_string($link, $maximum_stay),
        'type_of_contract' => mysqli_real_escape_string($link, $type_of_contract),
        'user_id' => mysqli_real_escape_string($link, $host_type),
        'agent_id' => $agent_id,
        'gender_type' => mysqli_real_escape_string($link, $gender_type),
        'step_comp' => 1,
        'startblockdate' => mysqli_real_escape_string($link, $startblockdate),
        'endblockdate' => mysqli_real_escape_string($link, $endblockdate),
        'room_left' => mysqli_real_escape_string($link, $room_left),
        'deposit_amount' => mysqli_real_escape_string($link, $deposit_amount),
        'squar_feet' => mysqli_real_escape_string($link, $squar_feet),
        'is_furnised' => mysqli_real_escape_string($link, $is_furnised),
        'available_from' => mysqli_real_escape_string($link, $available_from),
        'falmatesno_of_living' => mysqli_real_escape_string($link, $falmatesno_of_living),
        'occupation_housemate' => mysqli_real_escape_string($link, $occupation_housemate),
        'current_flamets_age' => mysqli_real_escape_string($link, $current_flamets_age),
        'current_flamets_ageto' => mysqli_real_escape_string($link, $current_flamets_ageto),
        'housemate_gender' => mysqli_real_escape_string($link, $housemate_gender),
        'housemate_somking' => mysqli_real_escape_string($link, $housemate_somking),
        'preferred_gender' => mysqli_real_escape_string($link, $preferred_gender),
        'preferred_occupation' => mysqli_real_escape_string($link, $preferred_occupation),
        'preferred_agefrom' => mysqli_real_escape_string($link, $preferred_agefrom),
        'preferred_ageto' => mysqli_real_escape_string($link, $preferred_ageto),
        'i_am' => mysqli_real_escape_string($link, $i_am),
        'house_rule' =>  implode(',', $house_rule)
    );

    if ($_REQUEST['action'] == 'edit') {
        $fields = array(
            'bedrooms' => mysqli_real_escape_string($link, $bedrooms),
            'beds' => mysqli_real_escape_string($link, $beds),
            'parent_id' => mysqli_real_escape_string($link, $parent_id),
            'bathrooms' => mysqli_real_escape_string($link, $bathrooms),
            'prop_type' => mysqli_real_escape_string($link, $prop_type),
            'bed_type' => mysqli_real_escape_string($link, $bedtype),
            'created_date' => mysqli_real_escape_string($link, $date),
            'edited_date' => mysqli_real_escape_string($link, $date),
            'lat' => mysqli_real_escape_string($link, $lat),
            'lng' => mysqli_real_escape_string($link, $lng),
            'sutable_for' => mysqli_real_escape_string($link, $sutable_for),
            'not_included' => mysqli_real_escape_string($link, $not_included),
            'ninimum_stay' => mysqli_real_escape_string($link, $ninimum_stay),
            'maximum_stay' => mysqli_real_escape_string($link, $maximum_stay),
            'type_of_contract' => mysqli_real_escape_string($link, $type_of_contract),
            'user_id' => mysqli_real_escape_string($link, $host_type),
            'agent_id' => $agent_id,
            'gender_type' => mysqli_real_escape_string($link, $gender_type),
            'step_comp' => 1,
            'startblockdate' => mysqli_real_escape_string($link, $startblockdate),
            'endblockdate' => mysqli_real_escape_string($link, $endblockdate),
            'room_left' => mysqli_real_escape_string($link, $room_left),
            'deposit_amount' => mysqli_real_escape_string($link, $deposit_amount),
            'squar_feet' => mysqli_real_escape_string($link, $squar_feet),
            'is_furnised' => mysqli_real_escape_string($link, $is_furnised),
            'available_from' => mysqli_real_escape_string($link, $available_from),
            'falmatesno_of_living' => mysqli_real_escape_string($link, $falmatesno_of_living),
            'occupation_housemate' => mysqli_real_escape_string($link, $occupation_housemate),
            'current_flamets_age' => mysqli_real_escape_string($link, $current_flamets_age),
            'current_flamets_ageto' => mysqli_real_escape_string($link, $current_flamets_ageto),
            'housemate_gender' => mysqli_real_escape_string($link, $housemate_gender),
            'housemate_somking' => mysqli_real_escape_string($link, $housemate_somking),
            'preferred_gender' => mysqli_real_escape_string($link, $preferred_gender),
            'preferred_occupation' => mysqli_real_escape_string($link, $preferred_occupation),
            'preferred_agefrom' => mysqli_real_escape_string($link, $preferred_agefrom),
            'preferred_ageto' => mysqli_real_escape_string($link, $preferred_ageto),
            'i_am' => mysqli_real_escape_string($link, $i_am),
            'house_rule' =>  implode(',', $house_rule)
        );
    }

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . ' = ' . "'" . $value . "'";
    }


    if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($link, $_SESSION['prop_id']) . "'";

        mysqli_query($link, $sql);

        if (mysqli_query($link, $editQuery)) {

            header('Location:your_listing-2.php');
            exit();
        }
    }

    if ($_REQUEST['action'] == 'edit') {

        // echo '<pre>'; print_r($_FILES); echo '</pre>';
        // echo '<pre>'; print_r($_REQUEST); echo '</pre>';
        // echo '<pre>'; print_r($tubemaps); echo '</pre>';
        // exit;


        $nametype = mysqli_query($link, "select * from estejmam_main_property where id<>" . $_REQUEST['id'] . " AND  prop_type <>'2'");
        $maxstay = mysqli_query($link, "select maximum_stay from estejmam_main_property where id=9");

        $editQuery = "UPDATE `estejmam_main_property` SET " . implode(', ', $fieldsList)
                . " WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . " '";
        mysqli_query($link, "DELETE FROM `estejmam_tubemap` WHERE `prop_id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
        $ti = 0;
        foreach ($tubemaps as $key => $tubemap) {

            $addMap = "INSERT INTO `estejmam_tubemap` (`prop_id`, `station_name`, `distance`, `logo`) VALUES ('" . mysqli_real_escape_string($link, $_REQUEST['id']) . "','" . $tubemap['name'] . "','" . $tubemap['distance'] . "','" . $tubemap['icon'] . "')";
            //echo $addMap;
            mysqli_query($link, $addMap);
            $ti++;
        }
        //exit;

        mysqli_query($link, $sql);

        if (mysqli_query($link, $editQuery)) {

            header('Location:your_listing-2.php?id=' . $_REQUEST['id'] . '&action=edit');
            exit();
        }
    } else {

        // echo '<pre>'; print_r($tubemaps); echo '</pre>'; exit;
var_dump($categoryRowset);
        $pro_key = productkeygenarate();

        $addQuery = "INSERT INTO `estejmam_main_property` (`" . implode('`,`', array_keys($fields)) . "`)"
                . " VALUES ('" . implode("','", array_values($fields)) . "')";

        $result = mysqli_query($link, "SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
        $adminDetails = mysqli_fetch_object($result);
        $adminEmail = $adminDetails->email;

        $teamSQL = mysqli_query($link, "SELECT * FROM estejmam_team LEFT JOIN estejmam_user ON estejmam_team.agent_id = estejmam_user.id WHERE `template_id`=3 ");

        $agentSQL = mysqli_query($link, "SELECT * FROM estejmam_user WHERE `id` = '" . $agent_id . "' ");

        $agentData = mysqli_fetch_object($agentSQL);
        // echo '<pre>'; print_r($agentData); echo '</pre>';

        $agentName = $agentData->fname . ' ' . $agentData->lname;

        // $teamData = mysqli_fetch_array($teamSQL);
        // echo '<pre>'; print_r($teamData); echo '</pre>';
        while ($teamData = mysqli_fetch_array($teamSQL)) {
            echo $teamData['email'];
            postProperty($agentName, $teamData['email']);
        }
        postProperty($agentName, $adminEmail);

        mysqli_query($link, $addQuery);
        $last_id = mysqli_insert_id();

        $upd = mysqli_query($link, "update `estejmam_main_property` set `unique_prop_id` = '" . $pro_key . "' where `id` = '" . $last_id . "'");

        foreach ($tubemaps as $key => $tubemap) {

            $addMap = "INSERT INTO `estejmam_tubemap` (`prop_id`, `station_name`, `distance`, `logo`) VALUES ('" . $last_id . "','" . $tubemap['name'] . "','" . $tubemap['distance'] . "','" . $tubemap['icon'] . "') ";
            echo $addMap;
            mysqli_query($link, $addMap);
        }

        $_SESSION['prop_id'] = $last_id;

        header('Location:your_listing-2.php');
        exit();
    }
}

function postProperty($name, $sendEmail) {


    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id` = 3"));



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
      'To' => $adminDetails->phone,
      'From' => "+15807012787",
      'Body' => "Hi.. $name, Thank you for Resistered on Roomarate"
      ));

      //----------- SMS TO USER END -------------//

      } catch (Exception $e) {
      $data['msg'] = $e->getMessage();
      } */

    $logo = SITE_URL . "upload/site_logo/1490718901Asset_562.png";
    $loginurl = SITE_URL . 'administrator/index.php';
    $contactuslink = SITE_URL . "contact_us.php";
    $helplink = SITE_URL . "help.php";

    $detail4 = str_replace(
            array(
        '[Agent]',
        '[MAILHEADER]',
        '[LOGINURL]',
        '[HELPLINK]',
        '[CONTACTUS]',
        '[LOGO]'
            ), array(
        $name,
        $emailTemplate['subject'],
        $loginurl,
        $helplink,
        $contactuslink,
        $logo
            ), $emailTemplate['description']
    );

    $Subject = $emailTemplate['subject'];



    $TemplateMessage = $detail4;
    $mail1 = new PHPMailer;
    $mail1->FromName = "Roomarate";
    $mail1->From = "info@roomarate.com";
    $mail1->Subject = $Subject;



    $mail1->Body = stripslashes($TemplateMessage);
    $mail1->AltBody = stripslashes($TemplateMessage);
    $mail1->IsHTML(true);
    $mail1->AddAddress($sendEmail, "roomarate.com");
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
            <?php //include('includes/style_customize.php');      ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Property <small><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Property</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="list_product.php">Property</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Property</span>
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
                                <i class="fa fa-gift"></i>Add Property
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
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                <input type="hidden" name="user_id" value="<?php echo $categoryRowset['user_id'] ?>">
                                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>" />


                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Properties Name:</label>
                                        <div class="col-md-4">
                                            <select name="parent_id" class="form-control" required>
                                                <option value="0">No parent property</option>
                                                <?php
                                                while ($value = mysqli_fetch_array($nametype)) {
                                                    ?>
                                                    <option value="<?php echo $value['id'] ?>" <?php if ($categoryRowset['parent_id'] == $value['id']) { ?> selected <?php } ?>><?php echo $value['name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-md-3">Landlord</label>
                                        <div class="col-md-4">
                                            <select name="host_type" class="form-control" required>
                                                <?php
                                                $ptype = mysqli_query($link, "select * from estejmam_user where `type`='1' AND `is_approved`='1'");
                                                while ($proptype1 = mysqli_fetch_array($ptype)) {
                                                    ?>
                                                    <option value="<?php echo $proptype1['id'] ?>" <?php if ($categoryRowset['user_id'] == $proptype1['id']) { ?> selected <?php } ?>><?php echo $proptype1['fname'] . ' ' . $proptype1['lname'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Agent</label>
                                        <div class="col-md-4">
                                            <select name="agent_id" class="form-control" required>
                                                <?php
                                                $ptype = mysqli_query($link, "select * from estejmam_user where `type`='2' AND `host_type`='1'");
                                                while ($proptype1 = mysqli_fetch_array($ptype)) {
                                                    ?>
                                                    <option value="<?php echo $proptype1['id'] ?>" <?php if ($categoryRowset['agent_id'] == $proptype1['id']) { ?> selected <?php } ?>><?php echo $proptype1['fname'] . ' ' . $proptype1['lname'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-md-3">Property Type</label>
                                        <div class="col-md-4">
                                            <select name="prop_type" class="form-control" required>
                                                <?php
                                                $ptype = mysqli_query($link, "select * from `estejmam_property_type` where `status`='1'");
                                                while ($proptype = mysqli_fetch_array($ptype)) {
                                                    ?>
                                                    <option value="<?php echo $proptype['id'] ?>" <?php if ($categoryRowset['prop_type'] == $proptype['id']) { ?> selected <?php } else if ($_REQUEST['prophidid'] == $proptype['id']) { ?> selected <?php } ?>><?php echo $proptype['name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                    <br><div class="form-group">
                                        <label class="control-label col-md-3">Bedrooms</label>
                                        <div class="col-md-4">
                                            <select name="bedrooms" class="form-control" required>
                                                <option value="" disabled selected>Select</option>
                                                <option value="studio" <?php if ($categoryRowset['bedrooms'] == 'studio') { ?> selected <?php } ?>>Studio</option>
                                                <option value="1" <?php if ($categoryRowset['bedrooms'] == '1') { ?> selected <?php } ?>>1</option>
                                                <option value="2" <?php if ($categoryRowset['bedrooms'] == '2') { ?> selected <?php } ?>>2</option>
                                                <option value="3" <?php if ($categoryRowset['bedrooms'] == '3') { ?> selected <?php } ?>>3</option>
                                                <option value="4" <?php if ($categoryRowset['bedrooms'] == '4') { ?> selected <?php } ?>>4</option>
                                                <option value="5" <?php if ($categoryRowset['bedrooms'] == '5') { ?> selected <?php } ?>>5</option>
                                                <option value="6" <?php if ($categoryRowset['bedrooms'] == '6') { ?> selected <?php } ?>>6</option>
                                                <option value="7" <?php if ($categoryRowset['bedrooms'] == '7') { ?> selected <?php } ?>>7</option>
                                                <option value="8" <?php if ($categoryRowset['bedrooms'] == '8') { ?> selected <?php } ?>>8</option>
                                                <option value="9" <?php if ($categoryRowset['bedrooms'] == '9') { ?> selected <?php } ?>>9</option>
                                                <option value="10" <?php if ($categoryRowset['bedrooms'] == '10') { ?> selected <?php } ?>>10</option>
                                            </select>

                                        </div>
                                    </div>


                                    <!-- <div class="form-group">
                                        <label class="control-label col-md-3">Beds</label>
                                        <div class="col-md-4">
                                            <select name="beds" class="form-control" required onclick="checkbed(this.value)">
                                                <option value="" disabled selected>Select</option>
                                                <option value="1" <?php if ($categoryRowset['beds'] == '1') { ?> selected <?php } ?>>1</option>
                                                <option value="2" <?php if ($categoryRowset['beds'] == '2') { ?> selected <?php } ?>>2</option>
                                                <option value="3" <?php if ($categoryRowset['beds'] == '3') { ?> selected <?php } ?>>3</option>
                                                <option value="4" <?php if ($categoryRowset['beds'] == '4') { ?> selected <?php } ?>>4</option>
                                                <option value="5" <?php if ($categoryRowset['beds'] == '5') { ?> selected <?php } ?>>5</option>
                                                <option value="6" <?php if ($categoryRowset['beds'] == '6') { ?> selected <?php } ?>>6</option>
                                                <option value="7" <?php if ($categoryRowset['beds'] == '7') { ?> selected <?php } ?>>7</option>
                                                <option value="8" <?php if ($categoryRowset['beds'] == '8') { ?> selected <?php } ?>>8</option>
                                                <option value="9" <?php if ($categoryRowset['beds'] == '9') { ?> selected <?php } ?>>9</option>
                                                <option value="10" <?php if ($categoryRowset['beds'] == '10') { ?> selected <?php } ?>>10</option>
                                                <option value="11" <?php if ($categoryRowset['beds'] == '11') { ?> selected <?php } ?>>11</option>
                                                <option value="12" <?php if ($categoryRowset['beds'] == '12') { ?> selected <?php } ?>>12</option>
                                                <option value="13" <?php if ($categoryRowset['beds'] == '13') { ?> selected <?php } ?>>13</option>
                                                <option value="14" <?php if ($categoryRowset['beds'] == '14') { ?> selected <?php } ?>>14</option>
                                                <option value="15" <?php if ($categoryRowset['beds'] == '15') { ?> selected <?php } ?>>15</option>
                                                <option value="16" <?php if ($categoryRowset['beds'] == '16') { ?> selected <?php } ?>>16</option>
                                            </select>

                                        </div>
                                    </div>-->


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Bed Type</label>
                                        <div class="col-md-4">
                                            <select name="bedtype" class="form-control">
                                                <option value="" disabled selected>Select</option>
                                                <option value="single" <?php if ($categoryRowset['bed_type'] == 'single') { ?> selected <?php } ?>>Single</option>
                                                <option value="double" <?php if ($categoryRowset['bed_type'] == 'double') { ?> selected <?php } ?>>Double</option>
                                                <option value="twin" <?php if ($categoryRowset['bed_type'] == 'twin') { ?> selected <?php } ?>>Twin</option>
                                                <option value="bunk" <?php if ($categoryRowset['bed_type'] == 'bunk') { ?> selected <?php } ?>>Bank</option>
                                            </select>

                                        </div>
                                    </div>


                                    <!-- <div class="form-group">
                                        <label class="control-label col-md-3">Only For</label>
                                        <div class="col-md-4">
                                            <select name="gender_type" class="form-control">
                                                <option value="" disabled selected>Select</option>
                                                <option value="1" <?php if ($categoryRowset['gender_type'] == '1') { ?> selected <?php } ?>>Only Males</option>
                                                <option value="0" <?php if ($categoryRowset['gender_type'] == '0') { ?> selected <?php } ?>>Only Females</option>
                                            </select>

                                        </div>
                                    </div> -->

                                    <!-- <div class="form-group">
                                        <label class="control-label col-md-3">Bathrooms</label>
                                        <div class="col-md-4">
                                            <select name="bathrooms" class="form-control" required>
                                                <option value="" disabled selected>Select</option>
                                                <option value="0" <?php if ($categoryRowset['bathrooms'] == '0') { ?> selected <?php } ?>>0</option>
                                                <option value="0.5" <?php if ($categoryRowset['bathrooms'] == '0.5') { ?> selected <?php } ?>>0.5</option>
                                                <option value="1" <?php if ($categoryRowset['bathrooms'] == '1') { ?> selected <?php } ?>>1</option>
                                                <option value="1.5" <?php if ($categoryRowset['bathrooms'] == '1.5') { ?> selected <?php } ?>>1.5</option>
                                                <option value="2" <?php if ($categoryRowset['bathrooms'] == '2') { ?> selected <?php } ?>>2</option>
                                                <option value="2.5" <?php if ($categoryRowset['bathrooms'] == '2.5') { ?> selected <?php } ?>>2.5</option>
                                                <option value="3" <?php if ($categoryRowset['bathrooms'] == '3') { ?> selected <?php } ?>>3</option>
                                                <option value="3.5" <?php if ($categoryRowset['bathrooms'] == '3.5') { ?> selected <?php } ?>>3.5</option>
                                                <option value="4" <?php if ($categoryRowset['bathrooms'] == '4') { ?> selected <?php } ?>>4</option>
                                                <option value="4.5" <?php if ($categoryRowset['bathrooms'] == '4.5') { ?> selected <?php } ?>>4.5</option>
                                                <option value="5" <?php if ($categoryRowset['bathrooms'] == '5') { ?> selected <?php } ?>>5</option>
                                                <option value="5.5" <?php if ($categoryRowset['bathrooms'] == '5.5') { ?> selected <?php } ?>>5.5</option>
                                                <option value="6" <?php if ($categoryRowset['bathrooms'] == '6') { ?> selected <?php } ?>>6</option>
                                                <option value="6.5" <?php if ($categoryRowset['bathrooms'] == '6.5') { ?> selected <?php } ?>>6.5</option>
                                                <option value="7" <?php if ($categoryRowset['bathrooms'] == '7') { ?> selected <?php } ?>>7</option>
                                                <option value="7.5" <?php if ($categoryRowset['bathrooms'] == '7.5') { ?> selected <?php } ?>>7.5</option>
                                                <option value="8" <?php if ($categoryRowset['bathrooms'] == '8') { ?> selected <?php } ?>>8</option>
                                            </select>

                                        </div>
                                    </div>-->

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Not Included</label>
                                        <div class="col-md-4">
                                            <input type="text" name="not_included" value="<?php echo $categoryRowset['not_included'] ?>" class="form-control" placeholder="Couples not allowed.">

                                        </div>
                                    </div>

                                    <?php $sutable1_for = explode(',', $categoryRowset['sutable_for']);
                                    ?>
<!--
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Suitable for</label>
                                        <div class="col-md-4">
                                            <!-- <select name="sutable_for[]" class="form-control" multiple="multiple">
                                                <option value="0">Select</option>


                                                <option value="1" <?php if (in_array('1', $sutable1_for)) { ?> selected <?php } ?>>Professionals</option>
                                                <option value="2" <?php if (in_array('2', $sutable1_for)) { ?> selected <?php } ?>> Couples</option>
                                                <option value="3" <?php if (in_array('3', $sutable1_for)) { ?> selected <?php } ?>>Students</option>
                                                <option value="4" <?php if (in_array('4', $sutable1_for)) { ?> selected <?php } ?>>Erasmus</option>

                                            </select> -->
                                            <!---
                                            <label>Professionals</label>
                                            <input type="checkbox" value="1" name="sutable_for[]" class="form-control" <?php if (in_array('1', $sutable1_for)) { ?> checked <?php } ?> >
                                            <label>Couples</label>
                                            <input type="checkbox" value="2" name="sutable_for[]" class="form-control" <?php if (in_array('2', $sutable1_for)) { ?> checked <?php } ?> >
                                            <label>Students</label>
                                            <input type="checkbox" value="3" name="sutable_for[]" class="form-control" <?php if (in_array('3', $sutable1_for)) { ?> checked <?php } ?> >
                                            <label>Erasmus</label>
                                            <input type="checkbox" value="4" name="sutable_for[]" class="form-control" <?php if (in_array('4', $sutable1_for)) { ?> checked <?php } ?> >

                                        </div>
                                    </div>
 -->



                                    <div class="form-group">
                                        <label class="control-label col-md-3">Minimum stay <?php echo $categoryRowset['ninimum_stay']; ?></label>
                                        <div class="col-md-4">
                                        <!--<input type="text" name="ninimum_stay" value="<?php echo $categoryRowset['ninimum_stay'] ?>" class="form-control" placeholder="Minimum stay" required>-->

                                            <select name="ninimum_stay" class="form-control" required>

                                                <?php for ($i=1;$i<13;$i++){ ?>
                                                    <option value="<?php echo $i*30; ?>" <?php if ($categoryRowset['ninimum_stay'] == $i*30) { ?> selected <?php } ?>><?php echo $i ?> Months</option>
                                                <?php } ?>

                                                <!-- <option value="30" <?php if ($categoryRowset['ninimum_stay'] == "30") { ?> selected <?php } ?>>1 Months</option>
                                                <option value="60" <?php if ($categoryRowset['ninimum_stay'] == "60") { ?> selected <?php } ?>> 2 Months</option>
                                                <option value="90" <?php if ($categoryRowset['ninimum_stay'] == "90") { ?> selected <?php } ?>>3 Months</option>
                                                <option value="120" <?php if ($categoryRowset['ninimum_stay'] == "120") { ?> selected <?php } ?>>4 Months</option>

                                                <option value="150" <?php if ($categoryRowset['ninimum_stay'] == "150") { ?> selected <?php } ?>>5 Months</option>
                                                <option value="180" <?php if ($categoryRowset['ninimum_stay'] == "180") { ?> selected <?php } ?>> 6 Months</option>
                                                <option value="210" <?php if ($categoryRowset['ninimum_stay'] == "210") { ?> selected <?php } ?>>7 Months</option>
                                                <option value="240" <?php if ($categoryRowset['ninimum_stay'] == "240") { ?> selected <?php } ?>>8 Months</option>

                                                <option value="270" <?php if ($categoryRowset['ninimum_stay'] == "270") { ?> selected <?php } ?>>9 Months</option>
                                                <option value="300" <?php if ($categoryRowset['ninimum_stay'] == "300") { ?> selected <?php } ?>>10 MOnths</option>
                                                <option value="330" <?php if ($categoryRowset['ninimum_stay'] == "330") { ?> selected <?php } ?>>11 Months</option>
                                                <option value="360" <?php if ($categoryRowset['ninimum_stay'] == "360") { ?> selected <?php } ?>>12 Months</option>



                                                <option value="390" <?php if ($categoryRowset['ninimum_stay'] == "390") { ?> selected <?php } ?>>13 Months</option>
                                                <option value="420" <?php if ($categoryRowset['ninimum_stay'] == "420") { ?> selected <?php } ?>> 14 MOnths</option>
                                                <option value="450" <?php if ($categoryRowset['ninimum_stay'] == "450") { ?> selected <?php } ?>>15 Months</option>
                                                <option value="480" <?php if ($categoryRowset['ninimum_stay'] == "480") { ?> selected <?php } ?>>16 Months</option>

                                                <option value="510" <?php if ($categoryRowset['ninimum_stay'] == "510") { ?> selected <?php } ?>>17 Months</option>
                                                <option value="540" <?php if ($categoryRowset['ninimum_stay'] == "540") { ?> selected <?php } ?>> 18 MOnths</option>
                                                <option value="570" <?php if ($categoryRowset['ninimum_stay'] == "570") { ?> selected <?php } ?>>19 Months</option>
                                                <option value="600" <?php if ($categoryRowset['ninimum_stay'] == "600") { ?> selected <?php } ?>>20 Months</option>

                                                <option value="630" <?php if ($categoryRowset['ninimum_stay'] == "630") { ?> selected <?php } ?>>21 Months</option>
                                                <option value="660" <?php if ($categoryRowset['ninimum_stay'] == "660") { ?> selected <?php } ?>> 22 MOnths</option>
                                                <option value="690" <?php if ($categoryRowset['ninimum_stay'] == "690") { ?> selected <?php } ?>>23 Months</option>
                                                <option value="730" <?php if ($categoryRowset['ninimum_stay'] == "730") { ?> selected <?php } ?>>24 Months</option> -->


                                            </select>



                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Maximum stay <?php echo  $categoryRowset['maximum_stay'];?></label>
                                        <div class="col-md-4">
                                        <?php if($categoryRowset['maximum_stay']==""|!$categoryRowset['maximum_stay']|$categoryRowset['maximum_stay']>720)$categoryRowset['maximum_stay']=12*30; ?>
                                            <select name="maximum_stay" class="form-control" required>
                                                <?php for ($i=1;$i<25;$i++){ ?>
                                                    <option value="<?php echo $i*30; ?>" <?php if ($categoryRowset['maximum_stay'] == $i*30) { ?> selected <?php } ?>><?php echo $i ?> Months</option>
                                                <?php } ?>
                                                <!-- <option value="30" <?php if ($categoryRowset['maximum_stay'] == "30") { ?> selected <?php } ?>>1 Months</option>
                                                <option value="60" <?php if ($categoryRowset['maximum_stay'] == "60") { ?> selected <?php } ?>> 2 Months</option>
                                                <option value="90" <?php if ($categoryRowset['maximum_stay'] == "90") { ?> selected <?php } ?>>3 Months</option>
                                                <option value="120" <?php if ($categoryRowset['maximum_stay'] == "120") { ?> selected <?php } ?>>4 Months</option>

                                                <option value="150" <?php if ($categoryRowset['maximum_stay'] == "150") { ?> selected <?php } ?>>5 Months</option>
                                                <option value="180" <?php if ($categoryRowset['maximum_stay'] == "180") { ?> selected <?php } ?>> 6 Months</option>
                                                <option value="210" <?php if ($categoryRowset['ninimum_stay'] == "210") { ?> selected <?php } ?>>7 Months</option>
                                                <option value="240" <?php if ($categoryRowset['maximum_stay'] == "240") { ?> selected <?php } ?>>8 Months</option>

                                                <option value="270" <?php if ($categoryRowset['maximum_stay'] == "270") { ?> selected <?php } ?>>9 Months</option>
                                                <option value="300" <?php if ($categoryRowset['maximum_stay'] == "300") { ?> selected <?php } ?>>10 MOnths</option>
                                                <option value="330" <?php if ($categoryRowset['maximum_stay'] == "330") { ?> selected <?php } ?>>11 Months</option>
                                                <option value="360" <?php if ($categoryRowset['maximum_stay'] == "360") { ?> selected <?php } ?>>12 Months</option>



                                                <option value="390" <?php if ($categoryRowset['maximum_stay'] == "390") { ?> selected <?php } ?>>13 Months</option>
                                                <option value="420" <?php if ($categoryRowset['maximum_stay'] == "420") { ?> selected <?php } ?>> 14 MOnths</option>
                                                <option value="450" <?php if ($categoryRowset['maximum_stay'] == "450") { ?> selected <?php } ?>>15 Months</option>
                                                <option value="480" <?php if ($categoryRowset['maximum_stay'] == "480") { ?> selected <?php } ?>>16 Months</option>

                                                <option value="510" <?php if ($categoryRowset['maximum_stay'] == "510") { ?> selected <?php } ?>>17 Months</option>
                                                <option value="540" <?php if ($categoryRowset['maximum_stay'] == "540") { ?> selected <?php } ?>> 18 MOnths</option>
                                                <option value="570" <?php if ($categoryRowset['maximum_stay'] == "570") { ?> selected <?php } ?>>19 Months</option>
                                                <option value="600" <?php if ($categoryRowset['maximum_stay'] == "600") { ?> selected <?php } ?>>20 Months</option>

                                                <option value="630" <?php if ($categoryRowset['maximum_stay'] == "630") { ?> selected <?php } ?>>21 Months</option>
                                                <option value="660" <?php if ($categoryRowset['maximum_stay'] == "660") { ?> selected <?php } ?>> 22 MOnths</option>
                                                <option value="690" <?php if ($categoryRowset['maximum_stay'] == "690") { ?> selected <?php } ?>>23 Months</option>
                                                <option value="730" <?php if ($categoryRowset['maximum_stay'] == "730" || empty($_GET['id'])) { ?> selected <?php } ?>>24 Months</option>

 -->
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-md-3">Type of Contract</label>
                                        <div class="col-md-4">
<!--                                            <input type="text" name="type_of_contract" value="<?php echo $categoryRowset['type_of_contract'] ?>" class="form-control" placeholder="monthly" required>-->
                                            <?php if($categoryRowset['type_of_contract']==0 or !$categoryRowset['type_of_contract'])$categoryRowset['type_of_contract']=1; ?>
                                            <select name="type_of_contract" class="form-control" required>
                                                <option value="0">Select</option>


                                                <option value="1" <?php if ($categoryRowset['type_of_contract'] == "1") { ?> selected <?php } ?>>Monthly</option>
                                                <option value="2" <?php if ($categoryRowset['type_of_contract'] == "2") { ?> selected <?php } ?>> Fortnightly</option>
                                                <option value="3" <?php if ($categoryRowset['type_of_contract'] == "3") { ?> selected <?php } ?>>Daily</option>

                                            </select>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Unavailable Dates</label>
                                        <div class="col-md-4">
                                            <input type="text" name="startblockdate"  value="<?php echo $categoryRowset['startblockdate'] ?>" class="form-control" id="start_date" placeholder="Start Block Date">
                                            <input type="text" name="endblockdate"  style="margin-top:10px;"value="<?php echo $categoryRowset['endblockdate'] ?>" class="form-control" id="end_date" placeholder="End Block Date">


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tube Map</label>
                                        <div class="col-md-4">
                                            <div id="tubemapmore">
                                                <?php
                                                if ($_REQUEST['action'] == 'edit') {
                                                    $tubeSQL = "SELECT * FROM `estejmam_tubemap` WHERE `prop_id` = '" . $categoryRowset['id'] . "'";
                                                    $exeSQL = mysqli_query($link, $tubeSQL);
                                                    $noofTube = mysqli_num_rows($exeSQL);

                                                    if ($noofTube != 0) {
                                                        $ic = 1;
                                                        while ($tubeData = mysqli_fetch_array($exeSQL)) {
                                                            ?>
                                                            <div>
                                                                <?php if ($ic > 1) { ?>
                                                                    <i class="fa fa-times deleteDiv" aria-hidden="true" style="cursor: pointer; position:absolute;right:0px;" id="6"></i>
                                                                <?php }
                                                                ?>
                                                                <select name="map[icon][]" class="form-control"   style="margin-bottom:10px; display:inline-block;" >
                                                                    <option value="overground" <?php
                                                                    if (isset($tubeData['logo']) && $tubeData['logo'] == 'overground') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Overground</option>
                                                                    <option value="underground" <?php
                                                                    if (isset($tubeData['logo']) && $tubeData['logo'] == 'underground') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Underground</option>
                                                                    <option value="dlh" <?php
                                                                    if (isset($tubeData['logo']) && $tubeData['logo'] == 'dlh') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>DLR</option>
                                                                    <option value="rail" <?php
                                                                    if (isset($tubeData['logo']) && $tubeData['logo'] == 'rail') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Rail</option>
                                                                </select>
                                                                <input type="text" name="map[tubename][]" value = "<?php echo $tubeData['station_name']; ?>"  placeholder="tube name" style="margin-bottom:10px; "/>
                                                                <input type="text" name="map[tubedistance][]"  value = "<?php echo $tubeData['distance']; ?>"  placeholder="tube distance" style="margin-bottom:10px;" />
                                                            </div>
                                                            <?php
                                                            $ic++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <div>
                                                            <select name="map[icon][]" class="form-control" style="margin-bottom:10px;" >
                                                                <option value="overground">Overground</option>
                                                                <option value="underground">Underground</option>
                                                                <option value="dlh">DLR</option>
                                                                <option value="rail">Rail</option>
                                                            </select>

                                                            <input type="text" name="map[tubename][]"  placeholder="tube name" style="margin-bottom:10px;"/>
                                                            <input type="text" name="map[tubedistance][]"  placeholder="tube distance" style="margin-bottom:10px;" />
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>

                                                    <div>
                                                        <select name="map[icon][]" class="form-control" style="margin-bottom:10px;" >
                                                            <option value="overground">Overground</option>
                                                            <option value="underground">Underground</option>
                                                            <option value="dlh">DLR</option>
                                                            <option value="rail">Rail</option>
                                                        </select>
                                                        <input type="text" name="map[tubename][]"  placeholder="tube name" style="margin-bottom:10px;"/>
                                                        <input type="text" name="map[tubedistance][]"  placeholder="tube distance" style="margin-bottom:10px;" />
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a href="javascript:void(0)" id="addmore">Add More Tube Map</a>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-3">Available rooms to rent</label>
                                    <div class="col-md-4">
                                        <select name="room_left" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($rl=1; $rl<10; $rl++){
                                            ?>
                                            <option value="<?php echo $rl; ?>" <?php echo ($categoryRowset['room_left'] == $rl) ? 'selected' : ''; ?>><?php echo $rl; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Deposit amount</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="deposit_amount" value="<?php echo $categoryRowset['deposit_amount']; ?>" />
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-md-3">Square Feet</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="squar_feet" value="<?php echo $categoryRowset['squar_feet']; ?>" />
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="control-label col-md-3">Furnished or Unfurnished <?php echo $categoryRowset['is_furnised']; ?></label>
                                    <div class="col-md-4">
                                    <?php if($categoryRowset['is_furnised'] == '1'){$furn="checked";}else{$nofu="checked";} ?>
                                        <label class="radio-inline"><input type="radio" name="is_furnised" value="1" <?=$furn;?> >Furnished</label>
                                        <label class="radio-inline"><input type="radio" name="is_furnised" value="0" <?=$nofu;?> >Unfurnished</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Available from</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="available_from" value="<?php echo $categoryRowset['available_from']; ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Number of housemates already living there</label>
                                    <div class="col-md-4">
                                        <select name="falmatesno_of_living" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($nfm=1; $nfm<10; $nfm++){
                                            ?>
                                            <option value="<?php echo $nfm; ?>" <?php echo ($categoryRowset['falmatesno_of_living'] == $nfm) ? 'selected' : ''; ?>><?php echo $nfm; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Occupation of current housemates</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="occupation_housemate" value="student" <?php echo (strtolower($categoryRowset['occupation_housemate']) == 'student') ? 'checked' : ''; ?>>Student</label>
                                        <label class="radio-inline"><input type="radio" name="occupation_housemate" value="professional" <?php echo (strtolower($categoryRowset['occupation_housemate']) == 'professional') ? 'checked' : ''; ?>>Professional</label>
                                        <label class="radio-inline"><input type="radio" name="occupation_housemate" value="Student and Professional" <?php echo ($categoryRowset['occupation_housemate'] == 'Student and Professional') ? 'checked' : ''; ?>>Student & Proffesional</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred age range from</label>
                                    <div class="col-md-4">
                                        <select name="current_flamets_age" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($par=18; $par<=99; $par++){
                                            ?>
                                            <option value="<?php echo $par; ?>" <?php echo ($categoryRowset['current_flamets_age'] == $par) ? 'selected' : ''; ?>><?php echo $par; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred age range to</label>
                                    <div class="col-md-4">
                                        <select name="current_flamets_ageto" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($part=18; $part<=99; $part++){
                                            ?>
                                            <option value="<?php echo $part; ?>" <?php echo ($categoryRowset['current_flamets_ageto'] == $part) ? 'selected' : ''; ?>><?php echo $part; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Housemates gender</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="housemate_gender" value="male" <?php echo ($categoryRowset['housemate_gender'] == 'male') ? 'checked' : ''; ?>>Male</label>
                                        <label class="radio-inline"><input type="radio" name="housemate_gender" value="female" <?php echo ($categoryRowset['housemate_gender'] == 'female') ? 'checked' : ''; ?>>Female</label>
                                        <label class="radio-inline"><input type="radio" name="housemate_gender" value="male-female" <?php echo ($categoryRowset['housemate_gender'] == 'male-female') ? 'checked' : ''; ?>>Male & Female</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Do any of the current housemates smoke?</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="housemate_somking" value="yes" <?php echo ($categoryRowset['housemate_somking'] == 'yes') ? 'checked' : ''; ?>>Yes</label>
                                        <label class="radio-inline"><input type="radio" name="housemate_somking" value="no" <?php echo ($categoryRowset['housemate_somking'] == 'no') ? 'checked' : ''; ?>>No</label>
                                        <label class="radio-inline"><input type="radio" name="housemate_somking" value="outside" <?php echo ($categoryRowset['housemate_somking'] == 'outside') ? 'checked' : ''; ?>>Outside Only</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred gender?</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="preferred_gender" value="male" <?php echo ($categoryRowset['housemate_gender'] == 'male') ? 'checked' : ''; ?>>Male</label>
                                        <label class="radio-inline"><input type="radio" name="preferred_gender" value="female" <?php echo ($categoryRowset['housemate_gender'] == 'female') ? 'checked' : ''; ?>>Female</label>
                                        <label class="radio-inline"><input type="radio" name="preferred_gender" value="male-female" <?php echo ($categoryRowset['housemate_gender'] == 'male-female') ? 'checked' : ''; ?>>Male & Female</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred occupation</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="preferred_occupation" value="student" <?php echo ($categoryRowset['preferred_occupation'] == 'student') ? 'checked' : ''; ?>>Student</label>
                                        <label class="radio-inline"><input type="radio" name="preferred_occupation" value="professional" <?php echo ($categoryRowset['preferred_occupation'] == 'professional') ? 'checked' : ''; ?>>Professional</label>
                                        <label class="radio-inline"><input type="radio" name="preferred_occupation" value="student-proffesional" <?php echo ($categoryRowset['preferred_occupation'] == 'student-proffesional') ? 'checked' : ''; ?>>Student & Professional</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred age range from</label>
                                    <div class="col-md-4">
                                        <select name="preferred_agefrom" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($parrf=18; $parrf<=99; $parrf++){
                                            ?>
                                            <option value="<?php echo $parrf; ?>" <?php echo ($categoryRowset['preferred_agefrom'] == $parrf) ? 'selected' : ''; ?>><?php echo $parrf; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Preferred age range to</label>
                                    <div class="col-md-4">
                                        <select name="preferred_ageto" class="form-control">
                                            <option value="0">Select</option>
                                            <?php
                                            for($parrt=18; $parrt<=99; $parrt++){
                                            ?>
                                            <option value="<?php echo $parrt; ?>" <?php echo ($categoryRowset['preferred_ageto'] == $parrt) ? 'selected' : ''; ?>><?php echo $parrt; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    $hs_rule = explode(',',$categoryRowset['house_rule']);
                                    ?>
                                    <label class="control-label col-md-3">House rules</label>
                                    <div class="col-md-4">
                                        <label class="checkbox-inline"><input name="house_rule[]" type="checkbox" value="family_accdepted" <?php echo in_array('family_accdepted', $hs_rule) ? 'checked' : ''; ?>>Families & children accepted</label>
                                        <label class="checkbox-inline"><input name="house_rule[]" type="checkbox" value="coupal_accdepted" <?php echo in_array('coupal_accdepted', $hs_rule) ? 'checked' : ''; ?>>Couples accepted</label>
                                        <label class="checkbox-inline"><input name="house_rule[]" type="checkbox" value="pets_allowed" <?php echo in_array('pets_allowed', $hs_rule) ? 'checked' : ''; ?>>Pets allowed</label>
                                        <label class="checkbox-inline"><input name="house_rule[]" type="checkbox" value="somking_inside" <?php echo in_array('somking_inside', $hs_rule) ? 'checked' : ''; ?>>Smoking inside the property allowed</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">I am advertising as</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline"><input type="radio" name="i_am" value="flatmate" <?php echo ($categoryRowset['i_am'] == 'flatmate') ? 'checked' : ''; ?>>Flatmate</label>
                                        <label class="radio-inline"><input type="radio" name="i_am" value="landlord" <?php echo ($categoryRowset['i_am'] == 'landlord') ? 'checked' : ''; ?>>Landlord</label>
                                        <label class="radio-inline"><input type="radio" name="i_am" value="agent" <?php echo ($categoryRowset['i_am'] == 'agent') ? 'checked' : ''; ?>>Agent</label>
                                    </div>
                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" class="btn blue" value="Next" />
<!--                                            <input type="reset" name="reset" class="btn red" value="Reset" />-->
                                            <button type="button" class="btn default" onclick="location.href = 'list_product.php'">Cancel</button>

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
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index: 999;margin - top: - 34px;'></span>");
                    }
                });
            }
        }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');       ?>
    <!-- END QUICK SIDEBAR -->
</div>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        });</script>

<script type="text/javascript">
    function select_sub(id) {
        $.ajax({
            type: "post",
            url: "ajax_category.php?action=cat",
            data: {id: id},
            success: function (msg) {
                $('#subcat').html(msg);
            }
        });
    }</script>
<script>

    $(document).ready(function () {
        $(".san_open").parent().parent().addClass("active open");
    });</script>

<script        >
    function checkbed(id)
    {

        if (id == 1)
        {

            $("#showhide").show();
        }
        else
        {
            $("#showhide").hide();
        }


    }
    $(function () {
        var scntDiv = $('#tubemapmore');
        var i = $('#tubemapmore div').size() + 1;

        $('#addmore').live('click', function () {
            $('<div style="position:relative;" id="new' + i + '"><i class="fa fa-times deleteDiv" aria-hidden="true" style="cursor: pointer; position:absolute;right:0px;" class="remScnt" id="' + i + '"></i><select name="map[icon][]" class="form-control" required><option value="overground">Overground</option><option value="underground">Underground</option><option value="dlh">DLR</option><option value="rail">Rail</option></select><input type="text" name="map[tubename][]"  placeholder="tube name" style="margin-bottom:10px;" /><input type="text" name="map[tubedistance][]"  placeholder="tube distance" style="margin-bottom:10px;" /></div>').appendTo(scntDiv);
            i++;
            return false;
        });

        $('.deleteDiv').live('click', function () {
            $(this).closest("div").remove();
        })

        // $('.remScnt').live('click', function() {
        //         if( i > 2 ) {
        //                 console.log(this.id);
        //                 i--;
        //         }
        //         return false;
        // });
    });
</script>

<script type="text/javascript">
    $(function () {
        $("#start_date").datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() + 1);
                $("#end_date").datepicker("option", "minDate", dt);
            }
        });
        $("#end_date").datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd',
            onSelect: function (selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() - 1);
                $("#start_date").datepicker("option", "maxDate", dt);
            }
        });

        $('input[name="available_from"]').datepicker({
            minDate: new Date(),
            dateFormat: 'yy-mm-dd'
        });
    });

</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
