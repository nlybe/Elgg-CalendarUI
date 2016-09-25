<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use DateTime;
use DateTimeZone;
use CalendarOptions;

$result = array( 'error' => false );

if (!elgg_is_active_plugin('events_api')) {
    $result['error'] = true;
    $result['error_message'] = elgg_echo('calendar_ui:form:event:no_events_api');
}
else {   

    $user = elgg_get_logged_in_user_entity();

    $guid = get_input('guid');
    $event = get_entity($guid);

    $container_guid = get_input('container_guid');
    $container = get_entity($container_guid);
    if (!$container) {
        $container = $user;
    }

    if (!$container->canWriteToContainer($user->guid, 'object', Event::SUBTYPE)) {
        register_error(elgg_echo('events:error:container_permissions'));
        forward(REFERER);
    }

    if (!get_input('title')) {
        register_error(elgg_echo('events:error:empty_title'));
        forward(REFERER);
    }

    $calendar_guid = get_input('calendar');
    $calendar = get_entity($calendar_guid);

    if (!$calendar instanceof Calendar) {
        $calendar = Calendar::getPublicCalendar($user);
    }

    $editing = true;
    if (!$event instanceof Event) {
        $event = new Event();
        $event->owner_guid = $user->guid;
        $event->container_guid = $calendar->guid;

        $editing = false;
    }

    $title = strip_tags(get_input('title', elgg_echo('events:edit:title:placeholder')));
    $location = get_input('location');
    $description = nl2br(get_input('description'));
    $start_date = get_input('start_date');
    $end_date = get_input('end_date', $start_date);
    $timezone = get_input('timezone', CalendarOptions::getActiveTimezone());
    $start_time = get_input('start_time', '12:00am');
    //$start_time_ts = strtotime($start_time);
    $end_time = get_input('end_time', date('g:ia', $start_time + Util::SECONDS_IN_AN_HOUR));
    $repeat = get_input('repeat', false);
    $repeat_end_after = get_input('repeat_end_after');
    $repeat_end_on = get_input('repeat_end_on');
    $repeat_frequency = get_input('repeat_frequency');
    $repeat_end_type = get_input('repeat_end_type');
    $all_day = get_input('all_day');
    $no_details = get_input('no_details');
    
    /* not sure if needed
    if ($all_day == 'true') {
        $start_time = '12:00am';
        $end_time = '11:59pm';
    }*/
    
    // sanity check - events must have a start date, and an end date, and they must end after they start
    $dt = new DateTime(null, new DateTimeZone($timezone));
    // error_log($start_date.' - '.$start_time);    
    $start_timestamp = $dt->modify("$start_date $start_time")->getTimestamp();
    $start_timestamp_iso = $dt->format('c');

    $end_timestamp = $dt->modify("$end_date $end_time")->getTimestamp();
    $end_timestamp_iso = $dt->format('c');

    if ($start_timestamp === false || $end_timestamp === false) {
        // something was the wrong format
        register_error(elgg_echo('events:error:start_end_date:invalid_format'));
        forward(REFERER);
    }

    if ($end_timestamp < $start_timestamp) {
        register_error(elgg_echo('events:error:start_end_date'));
        forward(REFERER);
    }

    // lets attempt to create the event
    $event->title = $title;
    $event->description = $description;
    $event->location = $location;
    $event->access_id = get_input('access_id', get_default_access());
    $event->comments_on = get_input('comments_on', 'On');
    
    $event->start_date = $start_date;
    $event->end_date = $end_date;
    $event->start_time = $start_time;
    $event->end_time = $end_time;
    $event->timezone = $timezone;

    $event->start_timestamp = $start_timestamp;
    $event->end_timestamp = $end_timestamp;
    $event->start_timestamp_iso = $start_timestamp_iso;
    $event->end_timestamp_iso = $end_timestamp_iso;
    $event->end_delta = $end_timestamp - $start_timestamp; // how long the event is in seconds
    $event->all_day = ($all_day=='on' || $all_day==1)? 1 : 0 ;
    $event->no_details = ($no_details=='on' || $no_details==1)? 1 : 0 ;

    /* // disabled at the moment 
    // repeating data
    $event->repeat = ($repeat) ? 1 : 0;
    $event->repeat_end_after = (int) $repeat_end_after; // number of occurrances
    $event->repeat_end_on = $repeat_end_on; // date YYYY-MM-DD that it ends on
    $event->repeat_frequency = ($repeat) ? $repeat_frequency : Util::FREQUENCY_ONCE; // string identifying the repeating frequency
    $event->repeat_end_type = ($repeat) ? $repeat_end_type : Util::REPEAT_END_ONE_TIME; // how to determine how to end the repeat (never | occurrances | date)

    unset($event->repeat_monthly_by);
    unset($event->repeat_weekly_days);

    switch ($event->repeat_frequency) {
        case Util::FREQUENCY_WEEKLY :
            $repeat_weekly_days = get_input('repeat_weekly_days');
            $repeat_weekly_days = (is_array($repeat_weekly_days)) ? $repeat_weekly_days : date('D', $event->getStartTimestamp());
            $event->repeat_weekly_days = $repeat_weekly_days;
            break;

        case Util::FREQUENCY_MONTHLY :
            $repeat_monthly_by = get_input('repeat_monthly_by', Util::REPEAT_MONTHLY_BY_DATE);
            $event->repeat_monthly_by = $repeat_monthly_by;
            break;
    }

    $event->repeat_end_timestamp = $event->calculateRepeatEndTimestamp();
    */



    if (!$event->save()) {
        $result['error'] = true;
        $result['error_message'] = elgg_echo('calendar_ui:form:event:failed');
    }
    else {
        $result['guid'] = $event->getGUID();
        $result['all_day'] = $event->all_day;
        $result['no_details'] = $event->no_details;
        $result['timezone'] = $event->timezone;
        $result['start_timestamp_iso'] = CalendarOptions::parseDateTime($event->start_timestamp_iso, CalendarOptions::getActiveTimezone());
        $result['end_timestamp_iso'] = CalendarOptions::parseDateTime($event->end_timestamp_iso, CalendarOptions::getActiveTimezone());
    }
}

if (elgg_is_xhr()) {
    echo json_encode($result);
    exit;
}
else {
    if ($result['error']) {
        register_error($result['error_message']); 
    }
    else {
        system_message(elgg_echo('calendar_ui:form:event:success'));
    }
    forward($event->getURL());
}

