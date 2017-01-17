<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

elgg_require_js("calendar_ui/calendar_ui");
elgg_load_css('fullcalendar_css');
elgg_load_css('jquery_ui_css');

// generate hidden elements for using by JS
$c_elements .= elgg_format_element('span', [ 'id' => "c_action"], $vars['action']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_subtype"], $vars['subtype']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_limit"], $vars['limit']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_container_guid"], $vars['container_guid']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_calendar_guid"], $vars['calendar_guid']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_owner_guid"], $vars['owner_guid']);
$c_elements .= elgg_format_element('span', [ 'id' => "events_api_exists"], (elgg_is_active_plugin('events_api')?1:0));
$c_elements .= elgg_format_element('span', [ 'id' => "business_hours"], $vars['business_hours']);
$c_elements .= elgg_format_element('span', [ 'id' => "c_selectable"], 0);

echo elgg_format_element('div', [ 'class' => "c_elements"], $c_elements);
echo elgg_format_element('div', [ 'class' => "cui_timezone"], elgg_echo('calendar_ui:timezone', array($vars['timezone'])));
echo elgg_format_element('div', [ 'id' => "calendar"], '');

// load events_api form 
if (elgg_is_active_plugin('events_api')) {
    echo elgg_format_element('div', [ 
            'id' => 'dialog-form', 
            'class' => 'event_dialog_form', 
            'title' => elgg_echo('calendar_ui:form:title')
        ], elgg_view('forms/calendar_ui/add_event', $vars));
}


