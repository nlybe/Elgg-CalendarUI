<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use Events\API\Calendar;
use DateTime;
use DateTimeZone;
use CalendarOptions;

if (elgg_is_active_plugin('events_api')) {

    $username = elgg_extract('username', $vars, '');
    $user = get_user_by_username($username);

    // if valid user asked, display his public calendar
    if ($user instanceof \ElggUser) {
        $calendar = Calendar::getPublicCalendar($user);
        if ($calendar instanceof Calendar) {
            $title = $calendar->getDisplayName();
        }
        else {
            $title = elgg_echo('calendar_ui:user:title', array($user->name));
        }

        // set values to be used on events submit
        $owner_guid = $user->getGUID();
        $container_guid = $calendar->getGUID();
    }
    else { // if not vald user or any user asked, display site calendar
        $site = elgg_get_site_entity();
        $calendar = Calendar::getPublicCalendar($site);
        if ($calendar instanceof Calendar) {
            $title = $calendar->getDisplayName();
        }
        else {
            $title = elgg_echo('calendar_ui:site');
        }    

        // set values to be used on events submit
        $owner_guid = $site->getGUID();
        $container_guid = $calendar->getGUID();
    }

    if ($calendar->canEdit()) {
        $edit_business_hours_btn = elgg_view('output/url', array(
            'text' => elgg_echo('calendar_ui:calendar:business_hours:btn'),
            'href' => elgg_normalize_url('calendar/business_hours/'.$calendar->guid),
            'is_trusted' => true,
            'class' => 'elgg-button elgg-button-submit elgg-lightbox edit_business_hours_btn',
        ));
    }
    
    $vars['action'] = 'calendar_ui/search'; // action to be used for searching entities and send to calendar
    $vars['subtype'] = 'event';             // this is optional, it can be set directly to action file as defined above
    $vars['limit'] = elgg_extract('limit', $vars, 0);
    $vars['container_guid'] = $container_guid;
    $vars['calendar_guid'] = $calendar->getGUID();
    $vars['owner_guid'] = $owner_guid;
    $vars['timezone'] = CalendarOptions::getActiveTimezone();
    
    $business_hours = $calendar->getAnnotations(CalendarOptions::CALENDAR_UI_BUSINESS_HOURS);
    if ($business_hours) {
        $vars['business_hours'] = $business_hours[0]->value;
    }    
}
else {
    $title = elgg_echo('calendar_ui:menu');
}

/* // tmp code for mass deletion of events
$options = array(
    'type' => 'object',
    'subtype' => $c_subtype,
    'limit' => $c_limit,
    'container_guid' => $c_container_guid,
    'metadata_name_value_pairs' => array(
        array('name' => 'start_timestamp','value' => $start_timestamp, 'operand' => '>='),
        array('name' => 'start_timestamp','value' => $end_timestamp, 'operand' => '<='),
    ),
);
$entities = elgg_get_entities_from_metadata($options);
foreach ($entities as $e) {
    $e->delete();
} */

if (isset($edit_business_hours_btn)) {
    $content = $edit_business_hours_btn;
}
$content .= elgg_view('calendar_ui/calendar', $vars);

$body = elgg_view_layout('one_column', array(
    'filter_context' => '',
    'content' => $content,
    'title' => $title,
));
echo elgg_view_page($title, $body);