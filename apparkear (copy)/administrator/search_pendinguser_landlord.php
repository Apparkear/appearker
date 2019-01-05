<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
include("class.phpmailer.php");
require('../Twilio.php');

$adminDetails = mysqli_fetch_object(mysqli_query($link, "SELECT * FROM estejmam_tbladmin WHERE `id` = 1"));

function randomPassword($length, $count, $characters) {

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
    //$symbols["special_symbols"] = '!?~@#-_+[]{}';

    $characters = split(",", $characters); // get characters types to be used for the passsword
    foreach ($characters as $key => $value) {
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

$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "delete from  estejmam_user where id='" . $item_id . "'");
    //$_SESSION['msg']=message('deleted successfully',1);
    header('Location:search_pendinguser_landlord.php');
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'notverify') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_user set is_approved='0' where id='" . $item_id . "'");
    //$_SESSION['msg']=message('updated successfully',1);
    header('Location:search_pendinguser_landlord.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'verify') {
    $item_id = $_GET['cid'];
    mysqli_query($link, "update estejmam_user set is_approved='1' where id='" . $item_id . "'");

    $userdetais = mysqli_fetch_object(mysqli_query($link, "select * from `estejmam_user` where `id`='" . $item_id . "'"));

    $username = $userdetais->fname;
    $useremail = $userdetais->email;
    if (isset($userdetais->text_password) && $userdetais->text_password != '') {
        $userpassword = $userdetais->text_password;
    } else {
        $userpassword1 = randomPassword(10, 1, "lower_case,upper_case,numbers,special_symbols");
        $userpassword = $userpassword1['0'];
        mysqli_query($link, "update estejmam_user set `password`='" . md5($userpassword) . "',`text_password`='" . $userpassword . "' where id='" . $item_id . "'");
    }

    $mailHeaderAdmin = 'New Landlord is Activated';
    $mailHeaderLandlord = 'Your Account is Activated';
    $phoneAdmin = $adminDetails->phone_no;
    $user_email = $useremail;
    $password = $userdetais->text_password;
    $phoneLandlord = $userdetais->phone;

    //mailFunction($mailHeaderAdmin, $user_email, $userpassword, $phoneAdmin, $userdetais->fname);
    //mailFunction($mailHeaderLandlord, $user_email, $userpassword, $phoneLandlord, $userdetais->fname);

    header('Location:search_pendinguser_landlord.php');
    exit();
}

function mailFunction($mailheader, $user_email, $password, $phone, $name=null) {

    $emailTemplate = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM estejmam_email_templt WHERE `id` = 4"));

    $logo = SITE_URL . "images/logo_black.svg";
    $loginurl = SITE_URL . "login.php";
    $contactuslink = SITE_URL . "contact_us.php";
    $helplink = SITE_URL . "help.php";

    $detail4 = str_replace(
        array(
            '[Landlord]',
            '[MAILHEADER]',
            '[EMAIL]',
            '[PASSWORD]',
            '[LOGINURL]',
            '&nbsp;'
        ),
        array(
            $name,
            $mailheader,
            $user_email,
            $password,
            'https://www.roomarate.com/login.php',
            ''
        ),
        $emailTemplate['description']
    );




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
            //'Body' => "New Landlord is Activated. Email: $user_email, Password: $password"
            'Body' => str_replace(
                array(
                    '[EMAIL]',
                    '[PASSWORD]',
                    '[LINK]',
                    '&nbsp;'
                ),
                array(
                    $user_email,
                    $password,
                    'https://www.roomarate.com/login.php',
                    ''
                ),
                strip_tags($emailTemplate['sms'])
            )
        ));

        //----------- SMS TO USER END -------------//
    } catch (Exception $e) {
        $data['msg'] = $e->getMessage();
    }
}
?>




<?php
$sql = "select * from estejmam_user where `type`='1' AND `is_approved`='0'";
$record = mysqli_query($link, $sql);
?>


<script language="javascript">
    function del(aa, bb)
    {
        var a = confirm("Are you sure, you want to delete this?")
        if (a)
        {
            location.href = "search_pendinguser_landlord.php?cid=" + aa + "&action=delete"
        }
    }



    function inactiveVar(aa)
    {
        location.href = "search_pendinguser_landlord.php?cid=" + aa + "&action=notverify"

    }
    function activeVar(aa)
    {
        location.href = "search_pendinguser_landlord.php?cid=" + aa + "&action=verify";
    }

</script>
<?php include("includes/header.php"); ?>
<div class="clearfix">
</div>
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
                List Renter
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="index.html">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">List Renter</a>
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
                            <!-- <div class="caption">
            <form action="" method="post">
                <i class="fa fa-edit"></i>Editable Table
                <button type="submit" class="btn btn-primary"  name="ExportCsv"> Export Member List</button>
            </form>
            </div>-->
                            <!--<div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                            <!--<a href="#portlet-config" data-toggle="modal" class="config">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                    </div>-->
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <!--<div class="col-md-6">
                                        <div class="btn-group">
                                                <button id="sample_editable_1_new" class="btn blue">Add New <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>-->
                                    <!-- <div class="col-md-6">
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
                            <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                                <thead>
                                    <tr>
                                                                        <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
                                        <th>Name</th>
<!--                                        <th>Lname</th>-->
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Verify</th>
                                        <th>Create Date</th>

                                        <!--<th>Address</th>
                                        <th>Online Status</th>-->

                                        <th>Actions</th>

                                                                                <!--  <th>
                                                                                    Quick Links
                                                                                </th>
                                                                                <th>
                                                                                    Status
                                                                                </th>-->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//$sql="select * from estejmam_user  where `type`=0";
//$record=mysqli_query($link, $sql);

                                    if (mysqli_num_rows($record) == 0) {
                                        ?>

                                        <tr>

                                            <td colspan="6">Sorry, no record found.</td>

                                        </tr>

                                        <?php
                                    } else {

                                        $count = 1;

                                        while ($row = mysqli_fetch_object($record)) {
                                            if ($row->is_loggedin == 1) {
                                                $a = "Online";
                                            } else {
                                                $a = "Offline";
                                            }
                                            if ($row->image != '') {
                                                $image_link = '../upload/userimages/' . $row->image;
                                            } else {
                                                $image_link = '../upload/no.png';
                                            }
                                            ?>


                                            <tr>
                                                 <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id; ?>"/></td>-->

                                                <td>
                                                    <?php echo $row->fname; ?>
                                                </td>

                                                                                                                                                                                                                                                                <!--                                                <td>
                                                <?php echo $row->lname; ?>
                                                                                                                                                                                                                                                                                                                </td>-->


                                                <td>
                                                    <?php echo $row->email; ?>
                                                </td>

                                                <td>
                                                    <img src="<?php echo stripslashes($image_link); ?>" height="70" width="70" style="border:1px solid #666666" />
                                                </td>


                                                <td>
                                                    <?php if ($row->is_approved == '0') { ?>
                                                        <a class="btn btn-danger"  onClick="javascript:activeVar('<?php echo $row->id; ?>');">No</a>
                                                    <?php } else { ?>
                                                        <a class="btn btn-success" onClick="javascript:inactiveVar('<?php echo $row->id; ?>');">Yes</a>
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php echo $row->add_date; ?>
                                                </td>


                                                                                                                                                                                                                                                                           <!--<td><?php echo $row->address; ?></td>
                                                                                                                                                                                                                                                                           <td><?php echo $a; ?></td>-->
                                                <td>
                                                    <a class="btn btn-info btn-sm" onClick="window.location.href = 'add_user_type_host.php?id=<?php echo $row->id ?>&action=edit'"><i class="fa fa-pencil"></i></a>
                                                    <?php /* ?> <a onClick="window.location.href='add_billing_details.php?id=<?php echo $row->id ?>&action=edit'">Edit Billing Address</a><br>
                                                      <a onClick="window.location.href='add_shipping_details.php?id=<?php echo $row->id ?>&action=edit'">Edit Shipping Address</a><?php */ ?>

                                                    <a class="btn btn-danger btn-sm" onClick="javascript:del('<?php echo $row->id; ?>')"><i class="fa fa-close"></i></a>

                                                    <a class="btn btn-success btn-sm" onClick="window.location.href = 'user_details.php?id=<?php echo $row->id ?>&action=details'"><i class="fa fa-user"></i></a>
                                                                                                <!-- <a class="btn btn-warning btn-sm" onClick="window.location.href = 'my_purchase.php?id=<?php echo $row->id ?>&action=details'"><i class="fa fa-shopping-cart"></i></a> -->
                                                                                                <!-- <a onClick="window.location.href = 'change_password_user.php?id=<?php echo $row->id ?>&action=details'">Update Password</a>-->
                                                </td>


                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>




                                </tbody>
                            </table>
                        <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            </form>
                        </div>
                    </div>
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

<?php if (mysqli_num_rows($record) > 0) { ?>
    <script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<?php } ?>

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
        var result = confirm("Are you sure to delete User?");
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