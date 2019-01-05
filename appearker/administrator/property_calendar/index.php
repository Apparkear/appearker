<?php
//	include the calendar file
$the_file = "ac-includes/cal.inc.php";
if (!file_exists($the_file))
    die("<b>" . $the_file . "</b> not found");
else
    require_once($the_file);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AjaxAvailabilityCalendar.com - <?php echo AC_TITLE; ?></title>
        <link rel="stylesheet" href="http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-contents/themes/default/css/avail-calendar.css">
    </head>
    <body>
        <div id="cal_wrapper">
            <div id="cal_controls">
                <div id="cal_prev" title="<?php echo $lang["prev_X_months"]; ?>"><img src="http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-contents/themes/default/images/icon_prev.gif" class="cal_button"></div>
                <div id="cal_next" title="<?php echo $lang["next_X_months"]; ?>"><img src="http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-contents/themes/default/images/icon_next.gif" class="cal_button"></div>

                <!-- optional calendar change options -->
                <!--                <div id="cal_admin">
                                    <form method="get">
                                        <select name="id_item" class="select" onchange="this.form.submit();">
                <?php echo sel_list_items($_REQUEST["id_item"]); ?>
                                        </select>
                                        <select name="lang" class="select" onchange="this.form.submit();">
                <?php echo $list_languages_web; ?>
                                        </select>
                                    </form>
                                </div>-->
                <!-- end options -->
            </div>
            <div id="the_months">
                <?php echo $calendar_months; ?>
            </div>
            <div id="key_wrapper">
                <?php echo $calendar_states; ?>
                <div id="footer_data" style="clear:both;">
                    <?php echo $lang["last_update"] . ': ' . get_cal_update_date(ID_ITEM); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            //	define vars
            var url_ajax_cal = 'http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-includes/ajax/calendar.ajax.php'; // ajax file for loading calendar via ajax
            var img_loading_day = 'http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-contents/themes/default/images/ajax-loader-day.gif'; // animated gif for loading	
            var img_loading_month = 'http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-contents/themes/default/images/ajax-loader-month.gif'; // animated gif for loading	
            //	don't change these values
            var id_item = '<?php echo ID_ITEM; ?>'; // id of item to be modified (via ajax)
            var lang = '<?php echo AC_LANG; ?>'; // language
            var months_to_show = <?php echo AC_NUM_MONTHS; ?>; // number of months to show
            var clickable_past = '<?php echo AC_ACTIVE_PAST_DATES; ?>'; // previous dates
        </script>
        <script type="text/javascript" src="http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-includes/js/mootools-core-1.3.2-full-compat-yc.js"></script>
        <script type="text/javascript" src="http://team3.nationalitsolution.co.in/vacation/property_calendar/ac-includes/js/mootools-cal-public.js"></script>
    </body>
</html>