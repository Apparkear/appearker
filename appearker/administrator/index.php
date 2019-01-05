<?php
ob_start();
session_start();
include_once("./includes/config.php");

if (isset($_POST['submit'])) {
    $un = stripslashes(trim($_REQUEST['un']));

    $pass = $_REQUEST['pass'];

    $sql = "SELECT * FROM `estejmam_tbladmin` WHERE `admin_username`='" . mysqli_real_escape_string($link, $_REQUEST['un']) . "' and `admin_password`='" . mysqli_real_escape_string($link, $pass) . "'";

    $noofrow = mysqli_num_rows(mysqli_query($link, $sql));
    
    if($noofrow == 0){
        $pass = md5($pass);
        
        $sql1 = "SELECT * FROM `estejmam_user` WHERE `email`='" . mysqli_real_escape_string($link, $_REQUEST['un']) . "' and `password`='" . mysqli_real_escape_string($link, $pass) . "' and `type` = '2' and `host_type` = '1' ";
        $noofAgent = mysqli_num_rows(mysqli_query($link, $sql1));
        if($noofAgent == 1){
              
            $rs1 = mysqli_query($link, $sql1) or die(mysqli_error());
            if ($row1 = mysqli_fetch_object($rs1)) {

                $_SESSION['username'] = $row1->fname.' '.$row1->lname;
                $_SESSION['admin_id'] = $row1->id;
                $_SESSION['myy'] = $row1->id;
                $_SESSION['admin_type'] = 'subadmin';
                header("location:dashboard.php");
            } else {
                $msg = "Invalid Username or Password.";
            }

        }else{
            $msg = "Invalid Username or Password.";
        }
    }else{

        $rs = mysqli_query($link, $sql) or die(mysqli_error());
        if ($row = mysqli_fetch_object($rs)) {

            $_SESSION['username'] = $row->admin_username;
            $_SESSION['admin_id'] = $row->id;
            $_SESSION['myy'] = $row->id;
            $_SESSION['admin_type'] = 'superadmin';
            header("location:dashboard.php");
        } else {
            $msg = "Invalid Username or Password.";
        }

    }

}
?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Admin Panel</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="assets/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link href="assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME STYLES -->
        <link href="assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.php">
                <?php
                $fetch_logo = mysqli_fetch_array(mysqli_query($link, "select * from `estejmam_sitesettings` where `id`=1"));
                ?>
                <img src="../upload/site_logo/<?php echo $fetch_logo['sitelogo']; ?>" alt="" style="width:30%;">
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="menu-toggler sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                <h3 class="form-title">Login to your account</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span>
                        Enter any username and password. </span>
                </div>
                <div class="form-group" >
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="un"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="pass"/>
                    </div>
                </div>
                <div class="form-actions">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1"/> Remember me </label>
                    <button type="submit" class="btn blue-haze pull-right"  name="submit">
                        Login <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>


            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->

            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->

            <!-- END REGISTRATION FORM -->
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">
            <?php echo date('Y'); ?> &copy; Admin Panel. Admin Dashboard Template.
        </div>
        <!-- END COPYRIGHT -->
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="assets/global/plugins/respond.min.js"></script>
        <script src="assets/global/plugins/excanvas.min.js"></script> 
        <![endif]-->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
        <script src="assets/admin/pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Login.init();
                Demo.init();
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>
