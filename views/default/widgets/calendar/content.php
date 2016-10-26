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

    $user = elgg_get_page_owner_entity();

    // if valid user asked, display his public calendar
    if ($user instanceof \ElggUser) {
        if (CalendarOptions::isUserCalendarEnabled($user->username)) {
            $calendar = Calendar::getPublicCalendar($user);
            if ($calendar instanceof Calendar) {
                $title = $calendar->getDisplayName();
                
                // set values to be used on events submit
                $owner_guid = $user->getGUID();
                $container_guid = $calendar->getGUID();                
            }
            else {
                $title = elgg_echo('calendar_ui:user:title', array($user->name));
            }
            
            $view_full_url = elgg_normalize_url('calendar/'.$user->username);
        }
    }
    else { // if not vald user or any user asked, display site calendar
        $site = elgg_get_site_entity();
        $calendar = Calendar::getPublicCalendar($site);
        if ($calendar instanceof Calendar) {
            $title = $calendar->getDisplayName();
            
            // set values to be used on events submit
            $owner_guid = $site->getGUID();
            $container_guid = $calendar->getGUID();    
            
            $view_full_url = elgg_normalize_url('calendar');
        }
        else {
            $title = elgg_echo('calendar_ui:site');
        }   
    }
    
    if (isset($calendar)) { 
        // set new widget title according the stat category selected
        $new_title = $vars['entity']->set('widget_manager_custom_title', $title);
        
        
        $view_full_btn = elgg_view('output/url', array(
            'text' => elgg_echo('calendar_ui:calendar:widget:view_full'),
            'href' => $view_full_url,
            'is_trusted' => true,
            'class' => 'elgg-button elgg-button-action edit_business_hours_btn',
        ));

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

        $content = elgg_view('calendar_ui/calendar', $vars);
        if (isset($view_full_btn)) {
            $content .= $view_full_btn;
        }
        echo $content;  
    }
    else {
        echo elgg_format_element('div', [], elgg_echo('calendar_ui:calendar:widget:not_available'));
    }
}
else {
     echo elgg_format_element('div', [], elgg_echo('calendar_ui:calendar:widget:events:not_enabled'));
}




