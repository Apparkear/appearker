!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '608981985933006', {
em: 'insert_email_variable,'
});
fbq('track', 'PageView');

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100328478-1', 'auto');
  ga('send', 'pageview');


            $(function() {
                $('.lazy').lazy();
            });




            // $('.bxslider').bxSlider({});

            $(window).scroll(function () {
                if ($(window).scrollTop() >= 100) {
                    $('.navbar-fixed-top').css({'background': 'rgba(0,0,0,.8)'});
                }
                else {
                    $('.navbar-fixed-top').css('background', 'none');
                }
            });
            $(document).on('click', 'a.clicks', function (event) {
                event.preventDefault();

                $('html, body').animate({
                    scrollTop: $($.attr(this, 'href')).offset().top
                }, 500);
            });


            var aud = document.getElementById("myVideo");
            aud.onended = function () {
                document.getElementById('myVideo').load();
                document.getElementById('myVideo').play();
            };

                            //minDate: (input.id == "edate" ? $("#sdate").datepicker("getDate") : new Date())


                            function customRange(input)
                            {
                                return {
                                    minDate: $('#edate').val()
                                };
                            }




                            function customRangeStart(input)
                            {
                                return {
                                    maxDate: (input.id == "sdate" ? $("#edate").datepicker("getDate") : null)
                                };
                            }

                            $(document).ready(function () {


                                var arrayd = '<?php echo json_encode($alltotalnewarray) ?>';
                                function available(date) {
                                    dmy = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                                    if ($.inArray(dmy, arrayd) != -1) {
                                        return [true, "", "Available"];
                                    } else {
                                        return [false, "", "unAvailable"];
                                    }
                                }



                                $(function () {
                                    //$("#sdate,#edate").datepicker({dateFormat: 'yy-mm-dd'});
                                    var dateToday = new Date();
                                    var array = ["<?php echo $val ?>"];
                                    var dates = $("#sdate").datepicker({
                                        beforeShow: customRangeStart,
                                        defaultDate: "+1w",
                                        changeMonth: false,
  										changeYear: false,
                                        numberOfMonths: 1,
                                        minDate: dateToday,
                                        dateFormat: 'yy-mm-dd',
                                        beforeShow:function(textbox, instance){
										    /*$('#ui-datepicker-div').css({
										        position: 'static',
										        display:block
										    });*/
										    $('#datePkrBox').append($('#ui-datepicker-div'));

										},
                                        onSelect: function (dateText, instance) {

                                            var nights = parseInt($('#numofdays').val());
                                            date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
                                            date.setDate(date.getDate() + nights);
                                            $("#edate").datepicker("setDate", date);
                                            $("#edate").trigger("click");
                                            $("#pricediv").show('slow');
                                            $("#datePkrBox").slideUp();
                                            var alldata = $('#submit_review').serialize();
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_date.php",
                                                data: alldata,
                                                success: function (msg) {
                                                    // var data = $.parseJSON(msg);
                                                    if (msg.trim() == 000)
                                                    {
                                                        $("#submit").attr("disabled", false);
                                                        $("#showAlert").hide();
                                                        $("#pricediv").show("slow");
                                                    }

                                                    if(msg.trim() == '100')
                                                    {
                                                        $("#dateMsg").text('Minimum Stay Not Match');
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                    if(msg.trim() == '010')
                                                    {
                                                        var maximum_stay_month=$('#maximum_stay_month').val();
                                                        if(maximum_stay_month==60)
                                                        {
                                                            var msg=" Maximum 2 months booking";
                                                        }
                                                        else
                                                        {
                                                            var msg=" Maximum 3 months booking";
                                                        }
                                                        $("#dateMsg").text(msg);
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                    if(msg.trim() == '001')
                                                    {
                                                        $("#dateMsg").text('This Date Range is Booked');
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }
                                                }
                                            });
                                        },
                                        beforeShowDay: function (date) {
                                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                            return [arrayd.indexOf(string) == -1];
                                        }

                                    });
                                    $("#edate").datepicker({
                                    	changeMonth: false,
  										changeYear: false,
                                        beforeShow: customRange,
                                        dateFormat: "yy-mm-dd",
                                        beforeShow:function(textbox, instance){
										    /*$('#ui-datepicker-div').css({
										        position: 'static',
										        display:block
										    });*/
										    $('#datePkrBox').append($('#ui-datepicker-div'));

										},
                                        onSelect: function (selectedDate) {
                                        	$("#datePkrBox").slideUp();
                                            var alldata = $('#submit_review').serialize();
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_date.php",
                                                data: alldata,
                                                success: function (msg) {

                                                    // console.log(msg);
                                                    if (msg.trim() == 000)
                                                    {
                                                        $("#submit").attr("disabled", false);
                                                        $("#showAlert").hide();
                                                        $("#pricediv").show("slow");
                                                    }

                                                    if(msg.trim() == '100')
                                                    {
                                                        $("#dateMsg").text('Minimum Stay Not Match');
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                    if(msg.trim() == '010')
                                                    {
                                                        var maximum_stay_month=$('#maximum_stay_month').val();
                                                        if(maximum_stay_month==60)
                                                        {
                                                            var msg=" Maximum 2 months booking";
                                                        }
                                                        else
                                                        {
                                                            var msg=" Maximum 3 months booking";
                                                        }

                                                        $("#dateMsg").text(msg);
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                    if(msg.trim() == '001')
                                                    {
                                                        $("#dateMsg").text('This Date Range is Booked');
                                                        $("#submit").attr("disabled", true);
                                                        $("#showAlert").show();
                                                        $("#pricediv").hide("slow");
                                                    }

                                                    // else
                                                    // {
                                                    //     $("#submit").attr("disabled", true);
                                                    //     $("#showAlert").show();
                                                    //     $("#pricediv").hide("slow");
                                                    // }

                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "ajax_check_price.php",
                                                data: alldata,
                                                success: function (msg) {

                                                    var data = msg.split("@@");

                                                    //$("#pricediv").html(msg);
                                                    $("#fees").html("<?php if($countryCode!='GB') {
                                                                echo $symbol;
                                                            } else {
                                                                echo $symbol;
                                                            } ?>" + data[0].trim());
                                                    $("#total").html("<?php if($countryCode!='GB') {
                                                                echo $symbol;
                                                            } else {
                                                                echo $symbol;
                                                            } ?>" + data[1].trim());

                                                    $("#sendfees").attr('value', data[0].trim());
                                                    $("#sendtotal").attr('value', data[1].trim());
                                                }
                                            });
                                        },
                                        beforeShowDay: function (date) {
                                            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                                            return [arrayd.indexOf(string) == -1];
                                        }
                                    });
                                });
                            });

		$(document).mouseup(function (e){
		    var container = $("#sdate,#edate,#datePkrBox");

		    if (!container.is(e.target) // if the target of the click isn't the container...
		        && container.has(e.target).length === 0) // ... nor a descendant of the container
		    {
		        $("#datePkrBox").slideUp();
		    }
		});

		$(function () {

		    $("#sdate,#edate").click(function(){
			  $("#datePkrBox").slideDown();
			});
		});



            function initialize() {
                var fenway = {lat: <?php echo $propdetails->lat ?>, lng: <?php echo $propdetails->lng ?>};
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: fenway,
                    zoom: 14
                });
                var marker = new google.maps.Marker({
                    position: fenway,
                    map: map,
                    title: ''
                });
                var panorama = new google.maps.StreetViewPanorama(
                        document.getElementById('pano'), {
                    position: fenway,
                    pov: {
                        heading: 34,
                        pitch: 10
                    }
                });
                map.setStreetView(panorama);
            }

            $('.bxslider2').bxSlider({
                pager: false
            });
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 100) {
                    $('.navbar-fixed-top').css('background', 'rgba(0,0,0,.8)');
                }
                else {
                    $('.navbar-fixed-top').css('background', 'none');
                }
            });
            $(document).ready(function () {
                $('#more-filter').click(function () {
                    $('.extra-filter').slideToggle('slow');
                });
                $('#ex1').slider({
                    formatter: function (value) {
                        return 'Current value: ' + value;
                    }
                });
            });
	    // $('.bxslider').bxSlider({
     //                mode: 'horizontal',
     //                moveSlides: 1,
     //                slideMargin:20,
     //                infiniteLoop: true,
     //                slideWidth: 264,
     //                minSlides: 1,
     //                maxSlides: 1,
     //                speed: 800,
     //                pager:false
     //            });

            function openExplore()
            {
                window.history.back();
            }


            $(document).on('click', ".cc", function () {

                var propid = $("#propid").val();
                var ip = $("#ip").val();

                $.ajax({
                    type: "post",
                    url: "ajax_want.php",
                    data: {propid: propid, ip: ip},
                    success: function (msg) {
                        if (msg == 1)
                        {
                            //$("#showfavdiv").html('<a href="javascript:void(0);" class="btn btn-default btn-block ccd"><i class="ion-heart"></i></a>');
                            $("#showfavdiv").html('<a href="javascript:void(0);" id="unfav_'+propid+'" class="btn btn-default btn-block ccd btn-fav">Remove favorite</a>');
                        }

                    }

                });

            });

            $(document).on('click', ".ccd", function () {

                var propid = $("#propid").val();
                var ip = $("#ip").val();

                $.ajax({
                    type: "post",
                    url: "ajax_want.php",
                    data: {propid: propid, ip: ip},
                    success: function (msg) {
                        if (msg == 0)
                        {
                            //$("#showfavdiv").html('<a href="javascript:void(0);"  class="btn btn-default btn-block cc"><i class="ion-ios-heart-outline"></i></a>');
                            $("#showfavdiv").html('<a href="javascript:void(0);" id="fav_'+propid+'" class="btn btn-default btn-block cc btn-fav">Add to the favorite</a>');
                        }

                    }

                });

            });

            $('.search-menu-icon_details_page').click(function () {
                $('.l-main-menu').slideToggle();
            });


//            $(document).ready(function () {
//                var demo = function (data) {
//                    fx.rates = data.rates
//                    var rate = fx(1).from("USD").to("GBP")
//                    console.log("£1 = $" + rate.toFixed(4))
//                }
//
//                $.getJSON("//api.fixer.io/latest", demo)
//            });


// function changelan()
// {
// var language = document.getElementById("sel1").value;
// var lang=language;
// // console.log(language);
//     $.ajax
//     ({
//         type: "POST",
//         url: "http://104.131.83.218/team4/roomarate/ajax_lang.php",
//         data: {language:lang},
//         cache: false,
//         success: function(html)
//         {
//         location.reload();
//         }
//     });
// }

function changelan(language) {
    var lang=language;
     console.log(language);
    $.ajax
    ({
        type: "POST",
        //url: "http://104.131.83.218/team4/roomarate/ajax_lang.php",
        url: "<?php echo SITE_URL; ?>ajax_lang.php",
        data: {language:lang},
        cache: false,
        success: function(html) {
            location.reload();
        }
    });
}

function changeCur()
{
var currency = document.getElementById("curChange").value;
var curr = currency;
// console.log(language);
    $.ajax
    ({
        type: "POST",
        //url: "http://104.131.83.218/team4/roomarate/ajax_currency.php",
        url: "<?php echo SITE_URL; ?>ajax_currency.php",
        data: {currency:curr},
        cache: false,
        success: function(html)
        {
        location.reload();
        }
    });
}
$(document).ready(function(){
    $("#currencyList li a").click(function(){
        var txt = $(this).text();
        $("#currencyBtn em").text(txt);
    });

    $('.dropdown-toggle').dropdown();

    $(".changeCur").click(function(){

        var curr = $(this).data('id');
        console.log(curr);
        $.ajax
        ({
        type: "POST",
                //url: "http://104.131.83.218/team4/roomarate/ajax_currency.php",
                url: "<?php echo SITE_URL; ?>ajax_currency.php",
                data: {currency:curr},
                cache: false,
                success: function(html)
                {
                location.reload();
                }
        });

    });

    $(".slide").hover(function(){
        $(this).toggleClass("border-class");
    });

    var check_in    = $("#hiddenCheckin").val();
    var check_out   = $("#hiddenCheckout").val();

    if(check_in!='' && check_out!=''){
        var alldata = $('#submit_review').serialize();

        $.ajax({
            type: "post",
            url: "ajax_check_date.php",
            data: alldata,
            success: function (msg) {
                // var data = $.parseJSON(msg);
                if (msg.trim() == 000)
                {
                    $("#submit").attr("disabled", false);
                    $("#showAlert").hide();
                    $("#pricediv").show("slow");
                }

                if(msg.trim() == '100')
                {
                    $("#dateMsg").text('Minimum 1 month booking');
                    $("#submit").attr("disabled", true);
                    $("#showAlert").show();
                    $("#pricediv").hide("slow");
                }

                if(msg.trim() == '010')
                {
                    var maximum_stay_month=$('#maximum_stay_month').val();
                    if(maximum_stay_month==60)
                    {
                        var msg=" Maximum 2 months booking";
                    }
                    else
                    {
                        var msg=" Maximum 3 months booking";
                    }

                    $("#dateMsg").text(msg);
                    $("#submit").attr("disabled", true);
                    $("#showAlert").show();
                    $("#pricediv").hide("slow");
                }

                if(msg.trim() == '001')
                {
                    $("#dateMsg").text('This Date Range is Booked');
                    $("#submit").attr("disabled", true);
                    $("#showAlert").show();
                    $("#pricediv").hide("slow");
                }
            }
        })
    }
})


$(function() {

    // $(".bxslider").slick({
    //   variableWidth: true,
    //   arrows: false,
    //   dots: true
    //
    // });

    $('.item').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false

    });
     $('.center').on('init', function(event, slick){
       console.log('slider was initialized');

    });
    $(".center").slick({
    // autoplay: true,
    // autoplaySpeed: 5000,
    dots: false,
    lazyLoad: 'ondemand',
    infinite: true,
    centerPadding: '60px',
    centerMode: true,
    variableWidth: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    focusOnSelect: true
  })

});
$(".learncontent").click(function(){
                $(this).hide();
                $(".learntext").show();
                $('.lesscontent').show();
            });

            $(".lesscontent").click(function(){
                $(this).hide();
                $(".learntext").hide();
                $('.learncontent').show();
            });


            $('.features-banner-slider').slick({
              dots: true,
              arrows: false,
              infinite: true,
              speed: 300,
              slidesToShow: 1,
              adaptiveHeight: true
            });
