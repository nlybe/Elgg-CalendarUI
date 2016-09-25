<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 * Extend user settings form with localization options suxh as timezone and locale
 */

$user = elgg_extract('user', $vars, '');
if (!elgg_instanceof($user, 'user')) {
    $user = elgg_get_page_owner_entity();
}

if ($user) {
    $title = elgg_echo('calendar_ui:settings:user:localization:title');
    
    if (CalendarOptions::isUserTimezoneEnabled()) {
        $content .= elgg_view('input/timezone', array(
            'name' => 'timezone', 
            'value' => $user->timezone,
            'label' => elgg_echo('calendar_ui:settings:user:timezone:label'),
        ));
    }

    if (CalendarOptions::isUserLocaleEnabled()) {
        $content .= elgg_view('input/locale', array(
            'name' => 'locale', 
            'value' => $user->locale, 
            'label' => elgg_echo('calendar_ui:settings:user:locale:label'),
        ));
    }
    
    if (elgg_extract('submit_btn', $vars, false)) {        
        $content .= elgg_format_element('div', ['class' => 'elgg-foot'], elgg_view('input/submit', array('value' => elgg_echo('save'))));
    }    
    
    echo elgg_view_module('info', $title, $content);
}
