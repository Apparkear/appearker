<?php
session_start();

require_once("administrator/includes/config.php");
if(!$_REQUEST['propertyid'] || intval($_REQUEST['propertyid'])==0)
{
	header("Location: /404.php");
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$propertyid=intval($_REQUEST['propertyid']);

$check=mysql_fetch_array(mysql_query("SELECT mp.*,GROUP_CONCAT(img.image SEPARATOR '||') as imgs FROM estejmam_main_property mp left join estejmam_image img on img.prop_id=mp.id  where mp.id='{$propertyid}' and mp.status='1' GROUP BY mp.id LIMIT 0,1"));

if(!$check['id'])
{
	include dirname(__FILE__).'/404.php';
	die();
}
function GenSess()
{
	if(!isset($_SESSION['keysession']))$_SESSION['keysession']=md5(rand().time());
	return	$_SESSION['keysession'];
}

$room_rand_hash=sha1(md5($_SERVER['HTTP_HOST']."_".get_client_ip()."-".date("DMYH")."-".$propertyid."+".GenSess()));

// Firstname
// Name
// TELEPHONE
// EMAIL ADDRESS:
// MESSAGE
// PREFERRED VIEWING TIME: DATE + DayPart



if(isset($_POST['makereservation']) && $_POST['_hash']==$room_rand_hash)
{

	$fields=array("fname","lname","email","phone","day","daypart");
	foreach ($fields as $key) {
		$$key=mysql_real_escape_string(trim(strip_tags($_POST[$key])));
		$insert[]="$key = '".mysql_real_escape_string(trim(strip_tags($_POST[$key])))."'";
		$kval[$key]=mysql_real_escape_string(trim(strip_tags($_POST[$key])));
	}
	$kval['prop_id']=$propertyid;

	$insert=implode(",",$insert);
	$keys=implode(",", array_keys($kval));
	$vals=implode("','", array_values($kval));
	$query="INSERT into estejmam_booking_view ($keys) VALUES ('$vals')";
	$result = mysql_query($query) or trigger_error(mysql_error()." ".$query);
  $bookview_id=mysql_insert_id();

  // Mail and sms to admin
  include("include/helpers.php");

  $template="";
  $subject="New booking viewing request";
  $check['name']="<a href=\"".SITE_URL."details/PRD00{$check['id']}\">{$check['name']}</a>";
  $replaceFrom=array("[BOOKVIEW_ID]", "[FNAME]", "[LNAME]", "[PHONE]", "[EMAIL]", "[VIEWING_TIME]", "[PROP_NAME]", "[PROP_ID]");
  $replaceTo=array($bookview_id,$kval['fname'],$kval['lname'],$kval['phone'],$kval['email'],date("l jS F Y",$kval['day'])." ({$kval['daypart']})",$check['name'],$check['id']);
  $receiverMail="hello@roomarate.com";
  $receiverPhone=array("+447841478505","+34662343108","+447476871134","+447730383711");
  sendMailFromTemplate(19, $replaceFrom, $replaceTo, $receiverMail, $receiverPhone);
  echo "bookok";

  // Mail and sms to admin

	unset($_SESSION['keysession']);
}elseif(isset($_POST['makereservation']) && isset($_POST['_hash']) && $_POST['_hash']!=$room_rand_hash || !$_POST['makereservation']){

for($i=1;$i<12;$i++)
{
	$day=mktime(0, 0, 0, date("m")  , date("d")+$i, date("Y"));
	$input.="<option value='$day'>".date("l jS F Y",$day)."</option>";
}


?>
<!DOCTYPE html>
<html>
<head>
<base href="<?php echo SITE_URL;?>">
  <title>Room viewing request - ROOMARATE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="newdes/js/tether-1.3.3/dist/css/tether.min.css"/>
	<link rel="stylesheet" href="newdes/js/tether-1.3.3/dist/css/tether-theme-basic.min.css"/>
	<link rel="stylesheet" href="newdes/js/tether-1.3.3/dist/css/tether-theme-arrows.min.css"/>
	<link rel="stylesheet" href="newdes/include/slick/slick.css"/>
	<link rel="stylesheet" href="newdes/include/slick/slick-theme.css"/>
	<link rel="stylesheet" href="newdes/css/main.css"/>
	<link rel="stylesheet" href="newdes/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
	<script src="newdes/js/modernizr.custom.js"></script>
  <style type="text/css">

    .c-property-card .c-property-card__slider, .c-property-card .c-property-card__slider-image{
      height: 250px;
    }
  </style>
   <?php include_once(dirname(__FILE__)."/agent/includes/header.php"); ?>
</head>
<body>
    <div class="header">
    <!-- <img class="logo" src="img/logo-white.png"/> -->
      <ul class="c-top-menu">
      </ul>
    </div>
    <section class="bg-gray" style="padding: 70px 0;">
          <div id="success-modal" class="modal fade book-view-success" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
						<span class="c-close c-close--top-right" type="button" data-toggle="modal" data-target=".book-view-success">X </span>
            <div class="checkmark-circle">
              <div class="background"></div>
              <div class="checkmark draw"></div>
            </div>
            <h2 class="send-message__title">Your booking request was successfully sent. We will contact you shortly.</h2><a class="send-message__back-to-search-link" href="javascript:history.back(-1);">Back to search result</a>
          </div>
        </div>
      </div>
      <div class="c-book container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="c-book__title">BOOK A View</h1>
          </div>
        </div>
        <div class="row">
          <div class="c-sidebar col-sm-4 col-md-5">
            <div class="c-property-card">
            <!-- <a href="<?php echo SITE_URL.'details/'.$check['unique_prop_id'].'/';?>"> -->
                <div class="c-property-card__favorite"></div>
                <div class="c-property-card__slider">
                  <?php
                  	$pic=explode("||", $check['imgs']);
                  	foreach ($pic as $image) {
                  	?>
						<div class="c-property-card__slider-image" style="background-image: url('<?php echo SITE_URL.'upload/property/'.$image;?>');"></div>
                  <?php
              		}

              		$amenities_query=mysql_query("SELECT id,name,img,type FROM estejmam_amenities where id in ({$check['amenities']}) order by id");
                   ?>

                </div>
                <h3 class="c-property-card__title"><?php echo $check['name']; ?></h3>
                <ul class="c-property-card__amenities">
                <?php while ($amen = mysql_fetch_array($amenities_query)) {
                	echo "<li>{$amen['name']}</li>";
                } ?>

                </ul>
                <!-- </a> -->
                </div>
          </div>
          <div class="col-sm-8 col-md-7">
            <div class="c-book__form c-book__form--2">
              <div class="c-alert col-sm-12 col-md-12">
                <p class="c-alert__message c-alert__message--gray">Book a viewing using this form or  <b>call +44 20-3856-4546</b></p>
              </div>
              <div class="col-sm-12 col-md-12">
                <h5>Your contact details:</h5>
              </div>
              <form method="POST" class="makereservation">
                <div class="form-group c-book__form-wrapper col-sm-12">
                  <div class="form-group c-book__form-input">
                    <input class="form-control" id="fname" name="fname" type="text" placeholder="First name"/>
                  </div>
                  <div class="form-group c-book__form-input">
                    <input class="form-control" id="lname" name="lname" type="text" placeholder="Last name"/>
                  </div>
                  <div class="form-group c-book__form-input">
                    <input class="form-control" id="phone" name="phone" type="tel" placeholder="Phone"/>
                  </div>
                  <div class="form-group c-book__form-input">
                    <input class="form-control" id="email" name="email" type="email" placeholder="Email"/>
                  </div><br/>
                </div>
                <div class="col-sm-12 col-md-12">
                  <h5>Preferred Viewing Time</h5>
                </div>
                <div class="form-group c-book__form-wrapper col-sm-12">
                  <div class="c-book__form-input">
                    <select class="form-control" name="day">
					<?php echo $input; ?>

                    </select>
                  </div>
                  <div class="c-book__form-input">
                    <select class="form-control" name="daypart">
                    <?php for($i=0;$i<14;$i++){
                      $time=date("H:i",mktime(8+$i,0));
                      echo "<option value=\"{$time}\">{$time}</option>";
                      ?>
                      
                    <?php } ?><!-- 
                      <option value="morning">Morning</option>
                      <option value="afternoon">Afternoon</option>
                      <option value="evening">Evening</option> -->
                    </select>
                  </div>
                </div>
                <input type="hidden" name="_hash" value="<?php echo $room_rand_hash;?>">
                <input type="hidden" name="makereservation" value="<?php echo md5($room_rand_hash);?>">
                <div class="col-sm-12 col-md-12"><br/>
                  <button class="btn btn-default btn-red btn-md" id="load" type="submit" name="makereservationforme" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Sending...">Book a viewing</button>
									<h5>We will contact you shortly</h5>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <script src="newdes/js/tether-1.3.3/dist/js/tether.min.js"></script>
  <script src="newdes/include/slick/slick.js">   </script>
  <script src="newdes/js/main.js"></script>
  <script type="text/javascript">
  	$(function(){
  		$("form input").on("keyup",function(){
  			if($(this).val()!="") {
  				$(this).parent().addClass('has-success')
				$(this).parent().removeClass('has-error')
  			}
  			else{
  				$(this).parent().removeClass('has-success')
				$(this).parent().addClass('has-error')
  			}
  		})
  		var error=true
  		$('form.makereservation').on('submit',function(){
  			$("form input").each(function(){
  				if ($(this).val()==""){
  					$(this).parent().removeClass('has-success')
  					$(this).parent().addClass('has-error')
  				}else
  				{
  					$(this).parent().removeClass('has-error')
  					$(this).parent().addClass('has-success')
  				}
  			})

  			if($("form .has-error").length>0) return false;
        var senddata = $("form.makereservation").serialize()
        $("#load").button('loading');
        $.post("<?php echo SITE_URL;?>booking-view/<?php echo $propertyid; ?>",senddata,function(data){
          if(data=="bookok"){
            $('#success-modal').modal()
            $("form.makereservation")[0].reset();
            $("#load").button('reset');
          }else{
            window.location.reload()
          }
        });
        return false;

  		})
  	})

  </script>

<?php } ?>
