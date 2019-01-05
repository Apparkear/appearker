<?php
include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");


if ($_REQUEST['submit']) {

    $fromid = isset($_REQUEST['fromid']) ? $_REQUEST['fromid'] : '';
    $toid = isset($_REQUEST['toid']) ? $_REQUEST['toid'] : '';
    $propid = isset($_REQUEST['propid']) ? $_REQUEST['propid'] : '';
    $staying = isset($_REQUEST['staying']) ? $_REQUEST['staying'] : '';
    $host_improve = isset($_REQUEST['host_improve']) ? $_REQUEST['host_improve'] : '';
    $feedback = isset($_REQUEST['feedback']) ? $_REQUEST['feedback'] : '';

    if ($_REQUEST['overall_exp'] == '') {
        $overall_exp = isset($_REQUEST['prev_overall_exp']) ? $_REQUEST['prev_overall_exp'] : '';
    } else {
        $overall_exp = isset($_REQUEST['overall_exp']) ? $_REQUEST['overall_exp'] : '';
    }
    if ($_REQUEST['acuuracy'] == '') {
        $acuuracy = isset($_REQUEST['prev_acuuracy']) ? $_REQUEST['prev_acuuracy'] : '';
    } else {
        $acuuracy = isset($_REQUEST['acuuracy']) ? $_REQUEST['acuuracy'] : '';
    }
    if ($_REQUEST['clean'] == '') {
        $clean = isset($_REQUEST['prev_clean']) ? $_REQUEST['prev_clean'] : '';
    } else {
        $clean = isset($_REQUEST['clean']) ? $_REQUEST['clean'] : '';
    }
    if ($_REQUEST['arrival'] == '') {
        $arrival = isset($_REQUEST['prev_arrival']) ? $_REQUEST['prev_arrival'] : '';
    } else {
        $arrival = isset($_REQUEST['arrival']) ? $_REQUEST['arrival'] : '';
    }
    if ($_REQUEST['amenities'] == '') {
        $amenities = isset($_REQUEST['prev_amenities']) ? $_REQUEST['prev_amenities'] : '';
    } else {
        $amenities = isset($_REQUEST['amenities']) ? $_REQUEST['amenities'] : '';
    }
    if ($_REQUEST['communication'] == '') {
        $communication = isset($_REQUEST['prev_communication']) ? $_REQUEST['prev_communication'] : '';
    } else {
        $communication = isset($_REQUEST['communication']) ? $_REQUEST['communication'] : '';
    }
    if ($_REQUEST['location'] == '') {
        $location = isset($_REQUEST['prev_location']) ? $_REQUEST['prev_location'] : '';
    } else {
        $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : '';
    }
    if ($_REQUEST['value'] == '') {
        $value = isset($_REQUEST['prev_value']) ? $_REQUEST['prev_value'] : '';
    } else {
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    }
    if ($_REQUEST['recomend'] == '') {
        $recomendation = isset($_REQUEST['prev_recomend']) ? $_REQUEST['prev_recomend'] : '';
    } else {
        $recomendation = isset($_REQUEST['recomend']) ? $_REQUEST['recomend'] : '';
    }





    $overall_note = isset($_REQUEST['overall_note']) ? $_REQUEST['overall_note'] : '';
    $accuracy_note = isset($_REQUEST['accuracy_note']) ? $_REQUEST['accuracy_note'] : '';
    $clean_note = isset($_REQUEST['clean_note']) ? $_REQUEST['clean_note'] : '';
    $arrival_note = isset($_REQUEST['arrival_note']) ? $_REQUEST['arrival_note'] : '';
    $aminities_note = isset($_REQUEST['aminities_note']) ? $_REQUEST['aminities_note'] : '';
    $communication_note = isset($_REQUEST['communication_note']) ? $_REQUEST['communication_note'] : '';
    $location_note = isset($_REQUEST['location_note']) ? $_REQUEST['location_note'] : '';
    $value_note = isset($_REQUEST['value_note']) ? $_REQUEST['value_note'] : '';

    $status = 1;
    $date = date("Y-m-d");


    $fields = array(
        'fromid' => mysql_real_escape_string($fromid),
        'toid' => mysql_real_escape_string($toid),
        'propid' => mysql_real_escape_string($propid),
        'staying' => mysql_real_escape_string($staying),
        'host_improve' => mysql_real_escape_string($host_improve),
        'feedback' => mysql_real_escape_string($feedback),
        'overall_exp' => mysql_real_escape_string($overall_exp),
        'acuuracy' => mysql_real_escape_string($acuuracy),
        'clean' => mysql_real_escape_string($clean),
        'arrival' => mysql_real_escape_string($arrival),
        'amenities' => mysql_real_escape_string($amenities),
        'communication' => mysql_real_escape_string($communication),
        'location' => mysql_real_escape_string($location),
        'value' => mysql_real_escape_string($value),
        'recomendation' => mysql_real_escape_string($recomendation),
        'overall_note' => mysql_real_escape_string($overall_note),
        'accuracy_note' => mysql_real_escape_string($accuracy_note),
        'clean_note' => mysql_real_escape_string($clean_note),
        'arrival_note' => mysql_real_escape_string($arrival_note),
        'aminities_note' => mysql_real_escape_string($aminities_note),
        'communication_note' => mysql_real_escape_string($communication_note),
        'location_note' => mysql_real_escape_string($location_note),
        'value_note' => mysql_real_escape_string($value_note),
        'status' => mysql_real_escape_string($status),
        'date' => mysql_real_escape_string($date),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }


    $editQuery = "UPDATE `estejmam_host_review` SET " . implode(', ', $fieldsList)
            . " WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'";

    mysql_query($editQuery);


    header('location:list_reviews.php');
    exit();
}

if ($_REQUEST['action'] == 'edit') {
    $categoryRowset = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_host_review` WHERE `id`='" . mysql_real_escape_string($_REQUEST['id']) . "'"));
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
            <?php //include('includes/style_customize.php');            ?>
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Review
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Add Review</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Review</span>
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
                                <i class="fa fa-gift"></i><?php echo $_REQUEST['action'] == 'edit' ? "Edit" : "Add"; ?> Review
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

                                <input type="hidden" name="toid" id="toid" value="<?php echo $categoryRowset['toid'] ?>">
                                <input type="hidden" name="fromid" id="fromid" value="<?php echo $categoryRowset['fromid'] ?>">
                                <input type="hidden" name="propid" id="propid" value="<?php echo $categoryRowset['propid'] ?>">
                                <input type="hidden" name="overall_exp" id="rateexpval" value="">
                                <input type="hidden" name="acuuracy" id="ratecccuval" value="">
                                <input type="hidden" name="clean" id="ratecleanval" value="">
                                <input type="hidden" name="arrival" id="ratearrivval" value="">
                                <input type="hidden" name="amenities" id="rateamenival" value="">
                                <input type="hidden" name="communication" id="ratecomuval" value="">
                                <input type="hidden" name="location" id="ratelocval" value=""> 
                                <input type="hidden" name="value" id="ratevalval" value="">
                                <input type="hidden" name="recomend" id="recomend" value="">


                                <input type="hidden" name="prev_overall_exp" value="<?php echo $categoryRowset['overall_exp'] ?>">
                                <input type="hidden" name="prev_acuuracy" value="<?php echo $categoryRowset['acuuracy'] ?>">
                                <input type="hidden" name="prev_clean" value="<?php echo $categoryRowset['clean'] ?>">
                                <input type="hidden" name="prev_arrival" value="<?php echo $categoryRowset['arrival'] ?>">
                                <input type="hidden" name="prev_amenities" value="<?php echo $categoryRowset['amenities'] ?>">
                                <input type="hidden" name="prev_communication" value="<?php echo $categoryRowset['communication'] ?>">
                                <input type="hidden" name="prev_location" value="<?php echo $categoryRowset['location'] ?>"> 
                                <input type="hidden" name="prev_value" value="<?php echo $categoryRowset['value'] ?>">
                                <input type="hidden" name="prev_recomend" value="<?php echo $categoryRowset['recomendation'] ?>">



                                <div class="form-body">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Describe Your Experience</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" name="staying" rows="5" placeholder="How did you host make you fell welcome? Was the listing description accurate? What was the neighborhood like." onKeyDown="limitText(this.form.staying, this.form.nam, 500);"onKeyUp="limitText(this.form.staying, this.form.nam, 500);" required><?php echo $categoryRowset['staying'] ?></textarea>
                                            <p class="text-right"><input type="text" name="nam" value="500" readonly disabled style="border:none;background:#f5f5f5;width:25px;"> words left</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Private host feedback</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" name="feedback" rows="5" required><?php echo $categoryRowset['feedback'] ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">How can your host improved?</label>
                                        <div class="col-md-4">
                                            <textarea class="form-control" name="host_improve" rows="5" required><?php echo $categoryRowset['host_improve'] ?></textarea>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Overall Experience</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['overall_exp']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Overall Experience</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateExp"></span>
                                            </p>
                                            <p><textarea class="form-control" name="overall_note" rows="5" id="overall_note" style="<?php if ($categoryRowset['overall_exp'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['overall_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Accuracy</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['acuuracy']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Accuracy</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateAccu"></span>
                                            </p>
                                            <p><textarea class="form-control" name="accuracy_note" rows="5" id="accuracy_note" style="<?php if ($categoryRowset['acuuracy'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['accuracy_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Cleanliness</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['clean']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Cleanliness</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateClean"></span>
                                            </p>
                                            <p><textarea class="form-control" name="clean_note" rows="5" id="clean_note" style="<?php if ($categoryRowset['clean'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['clean_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Arrival</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['arrival']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Arrival</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateArriv"></span>
                                            </p>
                                            <p><textarea class="form-control" name="arrival_note" rows="5" id="arrival_note" style="<?php if ($categoryRowset['arrival'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['arrival_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Amenities</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['amenities']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Amenities</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateAmeni"></span>
                                            </p>
                                            <p><textarea class="form-control" name="aminities_note" rows="5" id="aminities_note" style="<?php if ($categoryRowset['amenities'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['aminities_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Communication</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['communication']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Communication</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateComu"></span>
                                            </p>
                                            <p><textarea class="form-control" name="communication_note" rows="5" id="communication_note" style="<?php if ($categoryRowset['communication'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['communication_note'] ?></textarea></p>
                                        </div>
                                    </div>


                                    <hr>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Location</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['location']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Location</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateLoc"></span>
                                            </p>
                                            <p><textarea class="form-control" name="location_note" rows="5" id="location_note" style="<?php if ($categoryRowset['location'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['location_note'] ?></textarea></p>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Value</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <?php
                                                $output1 = '';
                                                $k = 1;
                                                for ($f = 1; $f <= 5; $f++) {
                                                    if ($k <= $categoryRowset['value']) {
                                                        $output1.='<i class=fa><img src=lib/img/star-on.png></i>' . '&nbsp;';
                                                    } else {
                                                        $output1.='<i class=fa><img src=lib/img/star-off.png></i>' . '&nbsp;';
                                                    }
                                                    $k++;
                                                }
                                                echo $output1;
                                                ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Value</label>
                                        <div class="col-md-4">
                                            <p class="rate-star">
                                                <span id="rateVal"></span>
                                            </p>
                                            <p><textarea class="form-control" name="value_note" rows="5" id="value_note" style="<?php if ($categoryRowset['value'] < 5) { ?> display:block; <?php } else { ?> display:none; <?php } ?>"><?php echo $categoryRowset['value_note'] ?></textarea></p>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Previous Recomendation</label>
                                        <div class="col-md-4">
                                            <p>
                                                <?php echo $categoryRowset['recomendation']; ?>  
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Would you recommend staying here?</label>
                                        <div class="col-md-4">
                                            <p>
                                                <a href="javascript:void(0);" id="no" name="no"><i class="fa  fa-thumbs-down"></i> No</a> 
                                                <a href="javascript:void(0);" id="yes" name="yes"><i class="fa  fa-thumbs-up"></i> Yes</a>
                                            </p>
                                        </div>
                                    </div>



                                </div>

                                <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="submit" value="Save" class="btn blue">
                                            <!-- <button type="button" class="btn default" onclick="location.href='list_reviews.php'">Cancel</button> -->
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
                        $("#previewImg").append("<span><img class='thumb' src='" + e.target.result + "'><img border='0' src='../images/erase.png'  border='0' class='del_this' style='z-index: 999;
                                margin - top: - 34px;
                                '></span>");
                        }
                        });
                        }
                }
    </script>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php //include('includes/quick_sidebar.php');              ?>
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

                });</script>


<script src="../js/jquery.raty.min.js"></script>
<link rel="stylesheet" href="../css/jquery.raty.css">

<script>
                        $(function () {
                        $('#rateExp').raty({
                        click: function (score, evt) {

                        $("#rateexpval").attr('value', score);
                                if (score < 5)
                        {
                        $("#overall_note").show("slow");
                        } else
                        {
                        $("#overall_note").hide("slow");
                                $("#overall_note").val("");
                        }

                        }
                        });
                                $('#rateAccu').raty({
                        click: function (score, evt) {

                        $("#ratecccuval").attr('value', score);
                                if (score < 5)
                        {
                        $("#accuracy_note").show("slow");
                        } else
                        {
                        $("#accuracy_note").hide("slow");
                                $("#accuracy_note").val("");
                        }

                        }
                        });
                                $('#rateClean').raty({
                        click: function (score, evt) {

                        $("#ratecleanval").attr('value', score);
                                if (score < 5)
                        {
                        $("#clean_note").show("slow");
                        } else
                        {
                        $("#clean_note").hide("slow");
                                $("#clean_note").val("");
                        }
                        }
                        });
                                $('#rateArriv').raty({
                        click: function (score, evt) {

                        $("#ratearrivval").attr('value', score);
                                if (score < 5)
                        {
                        $("#arrival_note").show("slow");
                        } else
                        {
                        $("#arrival_note").hide("slow");
                                $("#arrival_note").val("");
                        }
                        }
                        });
                                $('#rateAmeni').raty({
                        click: function (score, evt) {

                        $("#rateamenival").attr('value', score);
                                if (score < 5)
                        {
                        $("#aminities_note").show("slow");
                        } else
                        {
                        $("#aminities_note").hide("slow");
                                $("#aminities_note").val("");
                        }
                        }
                        });
                                $('#rateComu').raty({
                        click: function (score, evt) {

                        $("#ratecomuval").attr('value', score);
                                if (score < 5)
                        {
                        $("#communication_note").show("slow");
                        } else
                        {
                        $("#communication_note").hide("slow");
                                $("#communication_note").val("");
                        }
                        }
                        });
                                $('#rateLoc').raty({
                        click: function (score, evt) {

                        $("#ratelocval").attr('value', score);
                                if (score < 5)
                        {
                        $("#location_note").show("slow");
                        } else
                        {
                        $("#location_note").hide("slow");
                                $("#location_note").val("");
                        }
                        }
                        });
                                $('#rateVal').raty({
                        click: function (score, evt) {

                        $("#ratevalval").attr('value', score);
                                if (score < 5)
                        {
                        $("#value_note").show("slow");
                        } else
                        {
                        $("#value_note").hide("slow");
                                $("#value_note").val("");
                        }
                        }
                        });
                                $("#no").click(function () {
                        var val = $("#no").attr('name');
                                $("#recomend").attr('value', val);
                        });
                                $("#yes").click(function () {
                        var vall = $("#yes").attr('name');
                                $("#recomend").attr('value', vall);
                        });
                        });</script>

<script    language="javascript" type="text/javascript">
                    function limitText(limitField, limitCount, limitNum) {
                    if (limitField.value.length > limitNum) {
                    limitField.value = limitField.value.substring(0, limitNum);
                    } else {
                    limitCount.value = limitNum - limitField.value.length;
                    }
                    }
</script>





<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
