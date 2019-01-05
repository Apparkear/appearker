<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 


if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}

if($_SESSION['add_session'] != 2 && $_SESSION['five']==''){  
    $location = SITE_URL;
    header("Location: $location");
    
}
/******************header***************/
include("include/header.php");


$get_parking_id = $_SESSION['new_parking'];

if($get_parking_id){
    $get_details= mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$get_parking_id}"));
}
//print_r($get_details);

?>
<!--<p>Work is in progress</p>-->
<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="">Parking Place and Price</h4>
                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div" method="post" action="ajax_place_n_price.php">

                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                               <div class="col-sm-12 edit-pro-frmfield refund-page pl-0 pr-0">
                                                    <div class="custom-control custom-radio mr-sm-2">
                                                        <input type="radio" class="custom-control-input" id="customRadio1" value="1" name="is_strict" <?php if($get_details->is_strict == 1){ ?>checked<?php } ?>>
                                                        <label class="custom-control-label" for="customRadio1"><b>Strict:</b> 50% Refund up until 2 weeks prior to arrival</label>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-12 edit-pro-frmfield refund-page pl-0 pr-0">
                                                     <div class="custom-control custom-radio mr-sm-2">
                                                         <input type="radio" class="custom-control-input" id="customRadio2" value="2" name="is_strict" <?php if($get_details->is_strict == 2){ ?>checked<?php } ?>>
                                                         <label class="custom-control-label" for="customRadio2"><b>Moderate:</b> Full refund until 1 weeks prior to arrival</label>
                                                     </div>
                                                 </div>
                                             </div> 
                                             <div class="form-group row edit-pro-row">
                                                <div class="col-sm-12 edit-pro-frmfield refund-page pl-0 pr-0">
                                                     <div class="custom-control custom-radio mr-sm-2">
                                                         <input type="radio" class="custom-control-input" id="customRadio3" value="3" name="is_strict" <?php if($get_details->is_strict == 3){ ?>checked<?php } ?>>
                                                         <label class="custom-control-label" for="customRadio3"><b>Flexible:</b> Full refund until 2 days prior to arrival</label>
                                                     </div>
                                                 </div>
                                             </div> 
                                            
                                        </div>
                                    </div>
                                    

                                     <div class="row justify-content-center mt-4">
                                        <div class="col-sm-11">
                                        <p style="font-size:18px">Range of available dates</p>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="2018-06-01" id="datetimepicker5" name="available_start" value="<?php echo $get_details->available_start; ?>">
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="2018-06-01" id="datetimepicker6" name="available_end" value="<?php echo $get_details->avaliable_end; ?>">
                                                </div>
                                                </div>
                                                <div class="form-group row edit-pro-row">
                                                    <div class="col-sm-12 edit-pro-frmfield pr-0">
<!--                                                        <div>
                                                            <select id="event-type" autocomplete="off">
                                                                    <option value="">Select</option>
                                                                    <option value="FIXED-TIME">Fixed Time Event</option>
                                                                    
                                                            </select>
                                                            <input id="event-title" placeholder="Event Title" autocomplete="off" type="text">
                                                            <a id="create-event" href="https://accounts.google.com/o/oauth2/auth?scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar&amp;redirect_uri=http%3A%2F%2Fusefulangle.com%2Fdemos%2F29gauth.php&amp;response_type=code&amp;client_id=172824114602-c7i84c6qgb0g0b1j3ahck268p9flj50t.apps.googleusercontent.com&amp;access_type=online">Login &amp; Create Event</a>
                                                        </div>-->
                                                        <div class="custom-control custom-checkbox my-2 mr-sm-3">
                                                            <input type="checkbox" class="custom-control-input" id="customControlInline4" name="is_google_sync" <?php if($get_details->is_google_sync == 1){ ?>checked<?php } ?>>
                                                            <label class="custom-control-label" for="customControlInline4">Calendar Sync - Google Calendar</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>                                            
                                        </div>
                                    </div>
                                     
                                    
                                    
                                    <div class="row ml-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-3">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" style='color:#ffffff' href="rent_parking_step5.php" >Back</a>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-primary my-2 edit-pro-sv-chng" type="submit">Next</button>
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-3 hints">
                                    <img src="images/hints.png">
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
           </div>
           <div class="col-md-2">              
            </div>
       </div>
   </div>


<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>
<script>
    $(function () {
                  $( "#datetimepicker5" ).datepicker({
                     dateFormat: "yy-mm-d",
                     minDate: 0,
                     //onShow: AdjustMinTime,
                     onSelect: function(dateText, inst) {
    //alert(dateText);
                        var current_date = $.datepicker.parseDate('yy-mm-d', dateText);
                        current_date.setDate(current_date.getDate()+1);
                        //alert(current_date);
                        $('#datetimepicker6').datepicker("option", "minDate", current_date);

                      }
                  });
                  
                   $( "#datetimepicker6" ).datepicker({
                     dateFormat: "yy-mm-d",
                 });
             });
</script>
<script>

// Selected time should not be less than current time
function AdjustMinTime(ct) {
	var dtob = new Date(),
  		current_date = dtob.getDate(),
  		current_month = dtob.getMonth() + 1,
  		current_year = dtob.getFullYear();
  			
	var full_date = current_year + '-' +
					( current_month < 10 ? '0' + current_month : current_month ) + '-' + 
		  			( current_date < 10 ? '0' + current_date : current_date );

	if(ct.dateFormat('Y-m-d') == full_date)
		this.setOptions({ minTime: 0 });
	else 
		this.setOptions({ minTime: false });
}

// DateTimePicker plugin : http://xdsoft.net/jqplugins/datetimepicker/
//$("#datetimepicker5, #datetimepicker6").datepicker({ format: 'Y-m-d H:i', minDate: 0, minTime: 0, step: 5, onShow: AdjustMinTime, onSelectDate: AdjustMinTime });
//$("#event-date").datepicker({ format: 'Y-m-d', timepicker: false, minDate: 0 });

$("#event-type").on('change', function(e) {
	if($(this).val() == 'ALL-DAY') {
		$("#event-date").show();
		$("#datetimepicker5, #datetimepicker6").hide();
	}
	else {
		$("#event-date").hide(); 
		$("#datetimepicker5, #datetimepicker6").show();
	}
});

// Send an ajax request to create event
$("#create-event").on('click', function(e) {
	if($("#create-event").attr('data-in-progress') == 1)
		return;

	var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/,
		error = 0,
		parameters;

	$(".input-error").removeClass('input-error');

	if(!blank_reg_exp.test($("#event-title").val())) {
		$("#event-title").addClass('input-error');
		error = 1;
	}

	if($("#event-type").val() == 'FIXED-TIME') {
		if(!blank_reg_exp.test($("#datetimepicker5").val())) {
			$("#datetimepicker5").addClass('input-error');
			error = 1;
		}		

		if(!blank_reg_exp.test($("#datetimepicker6").val())) {
			$("#datetimepicker6").addClass('input-error');
			error = 1;
		}
	}
	else if($("#event-type").val() == 'ALL-DAY') {
		if(!blank_reg_exp.test($("#event-date").val())) {
			$("#event-date").addClass('input-error');
			error = 1;
		}	
	}

	if(error == 1)
		return false;

	if($("#event-type").val() == 'FIXED-TIME') {
		// If end time is earlier than start time, then interchange them
		if($("#datetimepicker6").datepicker('getValue') < $("#datetimepicker5").datepicker('getValue')) {
			var temp = $("#datetimepicker6").val();
			$("#datetimepicker6").val($("#datetimepicker5").val());
			$("#datetimepicker5").val(temp);
		}
	}

	// Event details
	parameters = { 	title: $("#event-title").val(), 
					event_time: {
						start_time: $("#event-type").val() == 'FIXED-TIME' ? $("#datetimepicker5").val().replace(' ', 'T') + ':00' : null,
						end_time: $("#event-type").val() == 'FIXED-TIME' ? $("#datetimepicker6").val().replace(' ', 'T') + ':00' : null,
						event_date: $("#event-type").val() == 'ALL-DAY' ? $("#event-date").val() : null
					},
					all_day: $("#event-type").val() == 'ALL-DAY' ? 1 : 0,
				};

	$("#create-event").attr('disabled', 'disabled');
	$.ajax({
        type: 'POST',
        url: 'google_ajax.php',
        data: { event_details: parameters },
        dataType: 'json',
        success: function(response) {
        	$("#create-event").removeAttr('disabled');
        	alert('Event created with ID : ' + response.event_id);
        },
        error: function(response) {
            $("#create-event").removeAttr('disabled');
            alert(response.responseJSON.message);
        }
    });
});

</script>