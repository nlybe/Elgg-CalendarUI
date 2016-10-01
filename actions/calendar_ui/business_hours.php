<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use Events\API\Calendar;
use CalendarOptions;
 
if (!elgg_is_active_plugin('events_api')) {
    register_error(elgg_echo('calendar_ui:form:event:no_events_api'));
    forward(REFERRER);     
}

$calendar_guid = get_input('calendar_guid');
$calendar = get_entity($calendar_guid);

if (!elgg_instanceof($calendar, 'object', Calendar::SUBTYPE)) {
    register_error(elgg_echo('calendar_ui:calendar:invalid'));
    forward(REFERRER);    
}

if (!$calendar->canEdit()) {
    register_error(elgg_echo('calendar_ui:calendar:invalid_access'));
    forward(REFERRER);    
}

$days = $_POST['days'];
$time_from = $_POST['time_from'];
$time_to = $_POST['time_to'];
    
// get and delete first existing business hours
$business_hours = $calendar->getAnnotations(CalendarOptions::CALENDAR_UI_BUSINESS_HOURS);
foreach ($business_hours as $bh) {
    $bh->delete();
}

$new_bh = array();
foreach( $days as $key => $n ) {
    $from = explode(":", $time_from[$key]);
    $to = explode(":", $time_to[$key]);

    if ((intval($from[0]) < intval($to[0])) || (intval($from[0]) == intval($to[0]) && intval($from[1]) < intval($to[1]))) {
        $tmp_array = array();
        $tmp_array['dow'] = $n;
        $tmp_array['start'] = $time_from[$key];
        $tmp_array['end'] = $time_to[$key];
        array_push($new_bh, $tmp_array);
    }
}

if (count($new_bh) > 0) {
    $calendar->annotate(CalendarOptions::CALENDAR_UI_BUSINESS_HOURS, json_encode($new_bh), $calendar->access_id);
    //error_log(json_encode($all_bh));
    system_message(elgg_echo('calendar_ui:calendar:business_hours:success'));
}
else {
    register_error(elgg_echo('calendar_ui:calendar:business_hours:error'));
}

// go back to calendar
forward(REFERRER);

