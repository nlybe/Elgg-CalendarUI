<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 * All hooks are here
 */
 
/**
 * Format and return the URL for calendars and events
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of entity
 */
function calendar_ui_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];

    if (elgg_instanceof($entity, 'object', 'calendar')) {
        if ($entity->isPublicCalendar()) {
            $container = get_entity($entity->container_guid);
            
            if ($container instanceof \ElggUser) {
                return elgg_normalize_url("calendar/{$container->username}");
            }
        }
        
        $friendly_title = elgg_get_friendly_title($entity->title);
        return elgg_normalize_url("calendar/{$entity->getGUID()}/{$friendly_title}");
    }
    else if (elgg_instanceof($entity, 'object', 'event')) {
        $friendly_title = elgg_get_friendly_title($entity->title);
        return elgg_normalize_url("events/view/{$entity->getGUID()}/{$friendly_title}");        
    }
}

/**
 * Save localization options like timezone and locale in user settings
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return boolean
 */
function calendar_ui_add_localization_in_user_setting($hook, $type, $return, $params) {
    $user_guid = get_input('guid');

    if ($user_guid) {
        $user = get_user($user_guid);
    } else {
        $user = elgg_get_logged_in_user_entity();
    }
    
    if ($user) {
        if (CalendarOptions::isUserTimezoneEnabled()) {
            $timezone = get_input('timezone');
            if (strcmp($timezone, $user->timezone) != 0) {
                $user->timezone = $timezone;
            }
        }
        
        if (CalendarOptions::isUserLocaleEnabled()) {
            $locale = get_input('locale');
            if (strcmp($locale, $user->locale) != 0) {
                $user->locale = $locale;
            }
        }        
        
        if ($user->save()) {
            system_message(elgg_echo('calendar_ui:settings:user:localization:success'));
            return true;
        } else {
            register_error(elgg_echo('calendar_ui:settings:user:localization:fail'));
        }        
    }
    else {
        register_error(elgg_echo('calendar_ui:settings:user:localization:fail'));
    }
    
    return false;
}
