<!DOCTYPE html>
<html>
<head>
	<title>jQuery Fullcalendar Integration with example</title>
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel="stylesheet"  media="print" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>

</head>
<body>

<div id="calendar"></div>

<script type="text/javascript">	

$(document).ready(function(){

        var calendar = $("#calendar").fullCalendar({  
            header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},

			navLinks: true, 
			editable: true,
			eventLimit: true, 
            events: [
		        {
		            title  : 'event1',
		            start  : '2017-04-01'
		        },
		        {
		            title  : 'event2',
		            start  : '2018-09-08',
		            end    : '2018-09-15'
		        },
		        {
		            title  : 'event3',
		            start  : '2017-04-09T12:30:00',
		            allDay : false // will make the time show
		        }
    		],  // request to load current events
           
        });
        
     });

</script>
</body>
</html>