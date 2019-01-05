<style>
.tp-widget-wrapper, .trustpilot-widget {
  max-width: 167px !important;
}

</style>

<?php

if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) {

    ?>


    <?php

}

$fb = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='1'"));

$tw = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='2'"));

$ytube = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='3'"));

$pinterest = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='31'"));

$vk = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='32'"));

$insta = mysql_fetch_object(mysql_query("select * from `estejmam_social` where `id`='33'"));

$company = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_footer_category` where id=1"));

$company_pages = mysqli_query($link,"select * from `footer_pages` where category_id=1");

$terms = mysqli_fetch_object(mysqli_query($link,"select * from `estejmam_footer_category` where id=2"));

$terms_pages =mysqli_query($link,"select * from `footer_pages` where category_id=2");

$social = mysqli_query($link,"select * from `estejmam_social`");

$get_storelink = mysqli_query($link,"SELECT * FROM `footer_pages` WHERE category_id=3");

?>

<section class="footer">
        <div class="upper">
            <div class="container">
                <div class="row">
                    <?php if(!empty($information_management)){ 
                        while($get_info = mysqli_fetch_object($information_management)){
                            if ($get_info->image == '') {
                                $img_info = './upload/noimage.Jpeg';
                            } else {
                                $img_info = './upload/infomgmt/' . $get_info->image;
                            }
                        
                        ?>
                    <div class="col-md-4 py-3 py-lg-5">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?php echo $img_info; ?>">
                            </div>
                            <div class="col-md-10">
                                <h5><?php echo $get_info->name; ?></h5>
                                <p><?php echo $get_info->description; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php }
                    
                            } ?>
                </div>
            </div>
        </div>
        <div class="container footer-bottom">
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <h5><?php echo $company->name;?>:</h5>
                                <?php while ($row = mysqli_fetch_object($company_pages)) { ?>
                            <p><a href="<?php echo $row->link; ?>"> <span class="arrow"><img src="images/ftr-arw.png" alt=""></span> <span class="ftr-brdr w-80 d-inline-block pb-2"><?php echo $row->name;?></span>  </a></p> 
                                <?php } ?>
                            
                        </div>
                        
                        <div class="col-md-3">
                            <h5><?php echo $terms->name;?>:</h5>
                            <?php while ($row = mysqli_fetch_object($terms_pages)) { ?>
                              <p><a href="<?php echo $row->link; ?>"> <span class="arrow"><img src="images/ftr-arw.png" alt=""></span> <span class="ftr-brdr w-80 d-inline-block pb-2"><?php echo $row->name;?></span> </a></p>
                            <?php } ?>
                        </div>

                        <div class="col-md-3">
                                    <h5>Follow us</h5>
                                    <div class="social">
                                        <ul>
                                            <?php while ($row = mysqli_fetch_object($social)) { ?>
                                            <li>
                                                <?php if($row->name == 'facebook'){?>
                                                <a href="<?php echo $row->link;?>"><i class="fab fa-<?php echo $row->name;?>-f"></i></a>
                                                <?php } else {?>
                                                 <a href="<?php echo $row->link;?>"><i class="fab fa-<?php echo $row->name;?>"></i></a>
                                                <?php } ?>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                        </div>

                        <div class="col-md-3">
                            <?php while($row_link = mysqli_fetch_object($get_storelink)){ ?>
                            <a href="<?php echo $row_link->link; ?>"><img src="./upload/footerpages/<?php echo $row_link->image; ?>" /></a>
<!--                                <img src="images/1.png" />-->
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
        
            <div class="row top-border">
                <ul>
                    <li>
                        <p> Copyright © 2018 Apparkear.</p>
                    </li>
<!--                    <li>
                        <img src="images/footer-dot.png" />
                        <p>Address</p>
                    </li>
                    <li>
                        <img src="images/footer-dot.png" />
                        <p>Tel: 12-345-6789</p>
                    </li>
                    <li>
                        <img src="images/footer-dot.png" />
                        <p>Get the Theme</p>
                    </li>
                    <li>
                        <img src="images/footer-dot.png" />
                        <p>Contact</p>
                    </li>-->
                </ul>
            </div>
        </div>
		
    </section>
      
<style>
    .help-block{
        color:red;
       /* display:block !important;*/
    }
</style>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="js/bootstrap-datepicker.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<script type="text/javascript">
  $(function () {
    $("#datetimepickertest" ).datepicker({
      dateFormat: "yy-mm-d",
      minDate: 0,
      onSelect: function(dateText, inst) {
        //alert(dateText);
        var month = $("#select_month").val();
        //alert(month);
        if(month == 0){
          var start_date = this.value;
          //alert(start_date);
          $.post("ajax_details.php", {month:month,start_date:start_date}, function(result){
            var all = result.split("||");
            $("#datetimepicker11").val(all[0]);
            if(parseInt(all[1]) == 0){
                    var price = $("#actual_price").attr("rel")*month;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                     $(".discount_range").html(" ");
                }else{
                    var discount_price = (($("#actual_price").attr("rel")*month)*parseInt(all[1]))/100;
                    var price = ($("#actual_price").attr("rel")*month)-discount_price;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                    
                    $(".discount_range").html(" ");
                    $(".discount_range").html("<span>"+all[1]+"% monthly price discount</span>\
                            <span>- $"+discount_price+"</span> ");
                    $(".discount_range").css("display","block");
                }
          }); 
        }else{
          var start_date = this.value;
          //var start_date = $.datepicker.parseDate('yy-mm-d', dateText);
          //alert(start_date);
          $.post("ajax_details.php", {month:month,start_date:start_date}, function(result){
            var all = result.split("||");
            $("#datetimepicker11").val(all[0]);
            if(parseInt(all[1]) == 0){
                    var price = $("#actual_price").attr("rel")*month;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                     $(".discount_range").html(" ");
                }else{
                    var discount_price = (($("#actual_price").attr("rel")*month)*parseInt(all[1]))/100;
                    var price = ($("#actual_price").attr("rel")*month)-discount_price;
                    $("#actual_price").children("b").html('$'+price.toFixed(2));
                    
                    $(".discount_range").html(" ");
                    $(".discount_range").html("<span>"+all[1]+"% monthly price discount</span>\
                            <span>- $"+discount_price+"</span> ");
                    $(".discount_range").css("display","block");
                }
          });
        }
                          
        //  current_date.setDate(current_date.getDate()+1);
        //  //alert(current_date);
        //  $('#datetimepicker6').datepicker("option", "minDate", current_date);
      }
    });
// .on("click", function() {
//       alert(1);
//       var month = $("#select_month").val();
//       var start_date = $("#datetimepicker1").val();
//       alert(start_date);
      
//       $.post("ajax_details.php", {month:month,start_date:start_date}, function(result){
//          // alert(result); return false;
//          $("#datetimepicker11").val(result);
//          //alert($("#actual_price").attr("rel"));
//          //alert(month);
//          var price = $("#actual_price").attr("rel")*month;
//          $("#actual_price").children("b").html('$'+price.toFixed(2));
//          //alert(price); return false;
//       });
//     });
    
    $( "#datetimepicker2" ).datepicker({
         dateFormat: "yy-mm-d"
    });
                
//                $('#datetimepicker1').datetimepicker({
//                    format:"YYYY-MM-DD",
//                    debug: true
//                });
//                $('#datetimepicker2').datetimepicker({
//                    format:"YYYY-MM-DD"
////                    ,
////                    autoclose: false
//                });
            });
        </script>
<script src="js/jquery.bxslider.js"></script>

<script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $(".fixed-top").addClass("fixed-me");
        } else {
            $(".fixed-top").removeClass("fixed-me");
        }
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){

        $('.add_listing').click(function(){
            window.location.href = "ajax_session_manage.php";
        });

        $('.switchUser').click(function(){
            var user_type = $(this).attr('rel');
            $.ajax({
                type:"post",
                url:"ajax_switch_user.php",
                dataType:"json",
                data:{user_type:user_type},
                success:function(data){
                  url = window.location.href;
                  window.location.href = url;
                }
            });
        });
        
    $('#UserSignupForm').formValidation({
      framework: 'bootstrap',
      excluded: ':disabled',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        'first_name': {
          validators: {
            notEmpty: {
              message: 'The first name is required and cannot be empty'
            },
            stringLength: {
                min: 2,
                message: 'First name minimum 2 characters'
              },
            regexp: {
                  regexp: "^[a-zA-Z ]*$",
                  message: 'First name allows only alphabates'
            } 
          }
        },
        'last_name': {
          validators: {
            notEmpty: {
              message: 'The last name is required and cannot be empty'
            },
            stringLength: {
                min: 2,
                message: 'Last name minimum 2 characters'
              },
            regexp: {
              regexp: "^[a-zA-Z ]*$",
              message: 'Last name allows only alphabates'
            } 
          }
        },
        'email_address': {
          validators: {
            notEmpty: {
              message: 'The email is required and cannot be empty'
            },
            regexp: {
                    regexp: "^([a-zA-Z0-9_\.\-]{3,})+\@(([a-zA-Z0-9\-]{3,})+\.)+([a-zA-Z0-9]{2,4})+$",
                   message: 'Please enter valid email address'
            }
          }
        },
          
        'pass': {
            validators: {
                notEmpty: {
                  message: 'The password is required and cannot be empty'
                },
                  regexp: {
                          regexp: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$",
                          message: 'Password must contain 1 uppercase,1 lowercase,1 number and 1 symbol and atleast 8 characters long'
                  }
            }
        },
        'agree': {
            validators: {
                notEmpty: {
                    message: 'You must agree with the terms and conditions'
                }
            }
        }
      }
    });
        
    
        
        $(".login-form-submit-btn").click(function(){
          var curr_url=$("#curr_url").val();
                $.ajax({
                  url : '<?php echo SITE_URL."ajax_login.php"; ?>',
                  type: "POST",
                  dataType: 'json',
                  data:$('#UserLoginForm').serialize(),
          beforeSend: function() {
            //$('#error').html('<div class="alert alert-info"><i class="fa fa-spinner fa-pulse"></i> Please wait ...');
          },
                  success:function(data){
                      //console.log(data);
                    //alert(data.ack); return false;               
                    if (data.ack == 1) {
                        //alert("if"); return false;
                   //$(".error").html('<div class="alert alert-success">You are successfully logged in</div>');
                        if (data.type == 1) {
                            //window.location = "<?php echo SITE_URL; ?>dashboard_user.php";
                            window.location = curr_url;
                        }else{
                            window.location = "<?php echo SITE_URL; ?>dashboard_user.php";
                        }
                        } else {
                             //alert("else"); return false;
                            $("#email_add").html("");
                            $(".error-set").html(data.msg).show();
                            setTimeout(function(){ $(".error-set").fadeOut();  },1500);
                            $("#email_add").focus();
                            //setTimeout(function(){ $(".error").html(data.msg)},1500);
                        }


                  }
              });
            });
            setTimeout(function(){ $('.error-log').hide('slow'); $('.error-log').html(""); }, 5000);
    });
</script>
<script type="text/javascript">
  function isAlphaKey(evt){
    var keyCode = (evt.which) ? evt.which : evt.keyCode
    if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
        return false;
    return true;
  }

  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }

    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT}, 'google_translate_element');
    }

    function triggerHtmlEvent(element, eventName) {
      var event;
      if (document.createEvent) {
        event = document.createEvent('HTMLEvents');
        event.initEvent(eventName, true, true);
        element.dispatchEvent(event);
      } else {
        event = document.createEventObject();
        event.eventType = eventName;
        element.fireEvent('on' + event.eventType, event);
      }
    }

    jQuery('.lang-select').click(function() {
      var theLang = jQuery(this).attr('data-lang');
      jQuery('.goog-te-combo').val(theLang);

      window.location = jQuery(this).attr('href');
      location.reload();
    });
</script>
<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->

<!--</body>
</html>-->
<style type="text/css">
    .social ul li a{
        padding-top: 0px;
    }
</style>
