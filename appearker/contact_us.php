<?php

include('include/header.php');



$result = mysql_query("SELECT * FROM `estejmam_sitesettings` WHERE `id` = '1'");

$data = mysql_fetch_array($result);





?>

<style>

    /*.contact-us__title-box #logo, .contact-us__title-box #lndlord, .contact-us__title-box #prtner, .contact-us__title-box #enqu { display: none; color: #ed4854; }*/



.contact-us__title-box {

    margin-top: 16px;

}



select{

	outline:none; 

}

.newSelectBox .btn-group .btn-default{ border: 1px solid red; border-radius: 4px; position: relative;  height: 48px; padding-left: 20px; padding-right: 35px; }
.newSelectBox .btn-group .btn-default .caret{ position: absolute; top: 13px; right: 10px; }

.newSelectBox .btn-group .btn-default em{ color: red; }

.newSelectBox .btn-group .btn-default .caret{color:red;}

.newSelectBox .btn-group .dropdown-menu{border: 1px solid red; top: -2px;  border-radius: 4px;}

.newSelectBox .btn-group .dropdown-menu li a{ color: red; }

.newSelectBox .btn-group .btn-default .caret{margin-top:5px !important;}

</style>



<section class="other_banner" style="background-image:url(images/team_hugo.jpg);background-size: auto 100%; background-position: bottom center; background-repeat: no-repeat;">

	<div class="blackBackground">

	    <h2>

	        <?php echo $statictext->Contact_Us; ?>

	    </h2>

    </div>

</section>



<section class="contactUs">

    <h3 class="hiw__title"><?php echo $statictext->Contact; ?></h3>

    <p class="hiw__claim"><?php echo $statictext->In_Order; ?></p>

    <div class="grid__wrapper contact-us__main-content">



        <div class="gridConactus">

            <form>

                <!-- <div class="form-group">

                    <select class="form-control selectField" name="select_reason" id="enquery">

                        <option><?php echo $statictext->why_are_you ?></option>

                        <option value="1"><?php echo $statictext->moving_in ?></option>

                        <option value="2"><?php echo $statictext->renting_property ?></option>

                        <option value="3"><?php echo $statictext->regard ?></option>

                        <option value="4"><?php echo $statictext->enquires ?></option>

                    </select>

                </div> -->

                

                <div class="newSelectBox">

                    <div class="btn-group">

    					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><em id="ContactingUsBtn"><?php echo $statictext->why_are_you ?></em><span class="caret"></span>

                            </span>

    					  </button>

    					  <ul class="dropdown-menu" id="ContactingUsDD">

    					    <li><a href="javascript:void(0)" data-value="<?php echo $statictext->moving_in; ?>" class="selectDropdown" id="first_li" ><?php echo $statictext->moving_in ?></a></li>

    					    <li><a href="javascript:void(0)" data-value="<?php echo $statictext->renting_property; ?>" class="selectDropdown" ><?php echo $statictext->renting_property ?></a></li>

    					    <li><a href="javascript:void(0)" data-value="<?php echo $statictext->regard; ?>" class="selectDropdown" ><?php echo $statictext->regard ?></a></li>

    					    <li><a href="javascript:void(0)" data-value="<?php echo $statictext->enquires; ?>" class="selectDropdown" ><?php echo $statictext->enquires ?></a></li>

    					  </ul>

    				</div>

				</div>

            </form>

        </div>

        <div class="gridConactus" >

            <div class="contact-us__title-box">

                <!-- <div id="logo" class="hideit"> -->

                    <!-- <img src="images/iconHelper.png"> -->

                    <!-- <i class="fa fa-suitcase fa-5x"></i>

                    <h3 class="contact-us__title">

                        Your Are Moving In

                        <span>Tenant</span>

                    </h3>

                </div>

                <div id="lndlord" class="hideit">

                    <i class="fa fa-tags fa-5x"></i>

                    <h3 class="contact-us__title">

                        You Are Renting Your Property

                        <span>Landlord</span>

                    </h3>

                </div>

                <div id="prtner" class="hideit">

                    <i class="fa fa-street-view fa-5x"></i>

                    <h3 class="contact-us__title">

                        Partner Up With Us

                        <span>Partner</span>

                    </h3>

                </div>

                <div id="enqu" class="hideit">

                    <i class="fa fa-ellipsis-h fa-5x"></i>

                    <h3 class="contact-us__title">

                        You Have Another Enquiries?

                        <span>Let Us Know</span>

                    </h3>

                </div> -->

                <div id="succ"></div>

                <form name="user_form" id="enquery_form" method="post">



                    <!-- <div class="form-group">

                        <select class="form-control selectField" name="city" id="destination_city">

                            <option>Select Your City Destination</option>

                            <option>London</option>

                            <option>Brussels</option>

                            <option>Lyon</option>

                            <option>Paris</option>

                        </select>

                    </div> -->



                    <input type="hidden" value="" name="enqueryFor" id="enqueryFor" />

                    <div id="general_form1">

                        <div class="form-group">

                            <input type="text" name="user_name" class="form-control textfield" id="usr_nm" placeholder="<?php echo $statictext->name ?>">

                        </div>

                        <span id="err"></span>

                        <div class="form-group">

                            <input type="email" name="user_email" class="form-control textfield" id="usr_email" placeholder="<?php echo $statictext->email ?>">

                        </div>

                        <span id="err1"></span>

                        <div class="form-group">

                            <input type="text" name="user_subject" class="form-control textfield" id="usr_sub" placeholder="<?php echo $statictext->sub ?>">

                        </div>

                        <span id="err2"></span>

                        <div class="form-group">

                            <input type="text" name="user_phone" class="form-control textfield" id="user_phone" placeholder="<?php echo $statictext->user_phone ?>">

                        </div>

			<span id="err3"></span>

                        <div class="form-group">

                            <textarea class="form-control textArea" name="user_message" rows="5" id="usr_comment" placeholder="<?php echo $statictext->msg ?>"></textarea>

                        </div>

                        <span id="err4"></span>

                        <button class="btn btn-primary btn-block" type="button"><?php echo $statictext->send ?></button> 

                    </div>

                </form>



                <div class="contactUstext">
<!--                    <p>If you are interested in listing your property with us, then we would love to hear from you! Just go to http://www.roomarate.com/contact_us.php and fill out the form there. A member of our team will then be in touch to tell you our terms and conditions, and let you know what the next steps are.</p>-->
                    <p>
                        <?php echo $statictext->below_contact; ?>
                    </p>

                    

                    <p class="contact-us__data-telephone text-center"><?php echo $data['site_phone']; ?></p>



                    <p><?php echo $statictext->openingtime ?></p>



                    <p><a href="#"><?php echo $data['site_email']; ?></a></p>
                    <p><iframe frameborder="0" height="450" src="https://www.google.com/maps/embed/v1/place?q=25+Canada+Square,+Level+33,+Canary+Wharf,+London+UK,+E14+5LB&amp;key=AIzaSyBGMqrnpYbNIJUj2aK-eG9S5CFPl6h6v68" style="border:0;margiin:0px auto:text-align:center;" width="100%"></iframe></p>

                </div>



            </div>

        </div>

    </div>

</section>





<?php include('include/footer.php'); ?>



<script>

$( document ).ready(function() {

	$("#ContactingUsDD li a").click(function() {

		var ContactingUsTxt = $(this).text();

		$("#ContactingUsBtn").text(ContactingUsTxt);

		//$(".ContactingUsBtn").

    });



    $(".selectDropdown").click(function(){

        var selectVal = $(this).data('value');

        $("#enqueryFor").val(selectVal);

    });



    var text = $("#first_li").text();

    $("#enqueryFor").val(text);



});

</script>



<script type="text/javascript">

    $('#enquery').on("change", function () {

        var select_name = $('#enquery').val();

        

        if (select_name == 1) {

            $('.hideit').hide();

            $('#logo').show();

        } else if (select_name == 2) {

            $('.hideit').hide();

            $('#lndlord').show();

        } else if (select_name == 3) {

            $('.hideit').hide();

            $('#prtner').show();

        } else if(select_name == 4) {

            $('.hideit').hide();

            $('#enqu').show();

        }

        

        if (select_name == 1 || select_name == 2) {

            $('.gridConactus').css('display', 'block');

            $('#destination_city').show();

            $('#general_form').hide();

            $('.contactUstext').hide();

            $('.contactUstext1').hide();

        }



        if (select_name == 3 || select_name == 4) {

            $('.gridConactus').css('display', 'block');

            $('#destination_city').hide();

            $('#general_form').show();

            $('.contactUstext').hide();

            $('.contactUstext1').show();

        }

    });



    $('#destination_city').on("change", function () {

        var select_name = $('#destination_city').val();

        $('#general_form').show();

        $('.contactUstext').show();

        $('.contactUstext1').hide();

    });



    $('.btn-block').on('click', function (e) {

        e.preventDefault();

        var name = $('#usr_nm').val();

        var email = $('#usr_email').val();

        var sub = $('#usr_sub').val();

	 var userphone = $('#user_phone').val();

        var comment = $('#usr_comment').val();

        if (name == '') {

            $('#err').html('Provide your name').delay(3000).fadeOut();

        }

        if (email == '') {

            $('#err1').html('Provide your email').delay(3000).fadeOut();

        }

        if (sub == '') {

            $('#err2').html('Provide your subject').delay(3000).fadeOut();

        }

	   if (userphone == '') {

            $('#err3').html('Provide your phone').delay(3000).fadeOut();

        }

        if (comment == '') {

            $('#err4').html('Provide your comment').delay(3000).fadeOut();

        }

        if (name != '' && email != '' && sub != '' && comment != '') {

            $.ajax({

                type: 'post',

                url: 'ajax_forgetpassword.php?action=contactus',

                data: $('#enquery_form').serialize(),

                success: function (response) {

                    console.log(response);

                    if (response == 1) {

			$('#usr_nm').val('');

       $('#usr_email').val('');

      $('#usr_sub').val('');

	$('#user_phone').val('');

       $('#usr_comment').val('');

                        $('#succ').html('<span style="color:green;">Mail Successfully send</span>');

                    } else {

                        $('#succ').html('<span style="color:red;">Ups,Some problem is there</span>');

                    }

                }

            });

        }

    });

</script>