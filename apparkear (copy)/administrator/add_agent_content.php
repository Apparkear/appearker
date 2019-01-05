<?php
ob_start();
session_start();
include_once("./includes/session.php");
include_once("./includes/config.php");

$sql = "SELECT * FROM `estejmam_agent_homepage` WHERE `id` = '1' ";
$data = mysql_fetch_array(mysql_query($sql));

if(!empty($_POST)){
    
    $link      = isset($_POST['youtube_link']) ? $_POST['youtube_link'] : '';
    $content   = isset($_POST['content']) ? $_POST['content'] : '';

    $fields = array(
        'youtube_link' => $link,
        'content' => $content
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    $updateQuery = "UPDATE `estejmam_agent_homepage` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

    mysql_query($updateQuery);        
            
    header('Location: add_agent_content.php');
    exit();        
}

?>
<?php include('includes/header.php'); ?>
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    
    <?php include('includes/left_panel.php'); ?>
    
    <div class="page-content-wrapper">
        <div class="page-content">
            
            <?php //include('includes/style_customize.php');  ?>
            
            <h3 class="page-title">
                Manage Agent Homepage Content</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Manage Agent Homepage Content</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    
                </ul>

            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Manage Agent Homepage Content
                            </div>
                            
                        </div>
                        <div class="portlet-body form">
                            
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                                
                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Video Link</label>
                                        <div class="col-md-9">

                                            <input type="text" name="youtube_link" value="<?php echo $data['youtube_link']; ?>" class="form-control">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Content</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" id="editor1" name="content" cols="100" rows="20"><?php echo stripslashes($data['content']); ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn blue" name="submit"> Submit </button>
                                                <button type="button" class="btn default" onclick="location.href='email_temp.php'"> Cancel </button>
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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="page-footer">

    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php include('includes/footer.php'); ?>
</div>

<script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>