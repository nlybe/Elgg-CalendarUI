<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

$plugin = elgg_get_plugin_from_id('calendar_ui');

$options_yes_no = array(
    CalendarOptions::CALENDAR_UI_YES => elgg_echo('calendar_ui:settings:yes'),
    CalendarOptions::CALENDAR_UI_NO => elgg_echo('calendar_ui:settings:no'),
);

// enable calendar for site events
$enable_calendars = elgg_format_element('div', [], elgg_view_input('checkbox', array(
    'id' => 'enable_site_calendar',
    'name' => 'params[enable_site_calendar]',
    'label' => elgg_echo('calendar_ui:settings:enable_site_calendar'),
    'checked' => ($plugin->enable_site_calendar || !isset($plugin->enable_site_calendar) ? true : false),
    'help' => elgg_echo('calendar_ui:settings:enable_site_calendar:help'),
    'required' => false,
)));

// enable calendar for users 
$enable_calendars .=  elgg_format_element('div', [], elgg_view_input('checkbox', array(
    'id' => 'enable_user_calendar',
    'name' => 'params[enable_user_calendar]',
    'label' => elgg_echo('calendar_ui:settings:enable_user_calendar'),
    'checked' => ($plugin->enable_user_calendar || !isset($plugin->enable_user_calendar) ? true : false),
    'help' => elgg_echo('calendar_ui:settings:enable_user_calendar:help'),
    'required' => false,
)));

if (elgg_is_active_plugin('profile_manager')) {
    $enable_calendars .= elgg_view('forms/profile_manager/profile_types', array('plugin' => $plugin));
}

$title = elgg_format_element('h3', [], elgg_echo('calendar_ui:settings:calendars'));
echo elgg_view_module('inline', '', $enable_calendars, ['header' => $title]);

$general_setting = '';
// timezone settings
$general_setting .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[enable_timezone]',
    'value' => ($plugin->enable_timezone?$plugin->enable_timezone:CalendarOptions::CALENDAR_UI_NO),
    'options_values' => $options_yes_no,
    'label' => elgg_echo('calendar_ui:settings:enable_timezone'),
    'help' => elgg_echo('calendar_ui:settings:enable_timezone:help'),
    'required' => false,
))); 

// locale settings
$general_setting .= elgg_format_element('div', [], elgg_view('input/locale', array(
    'name' => 'params[default_locale]',
    'value' => $plugin->default_locale,
    'label' => elgg_echo('calendar_ui:settings:default_locale'),
    'help' => elgg_echo('calendar_ui:settings:default_locale:help'),
    'required' => false,
))); 

$general_setting .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[user_locale]',
    'value' => ($plugin->user_locale?$plugin->user_locale:CalendarOptions::CALENDAR_UI_NO),
    'options_values' => $options_yes_no,
    'label' => elgg_echo('calendar_ui:settings:user_locale'),
    'help' => elgg_echo('calendar_ui:settings:user_locale:help'),
    'required' => false,
)));

// date format settings
$dformat = array(
    "r" => "Thu, 21 Dec 2020 16:01:07 +0200",
    "F j, Y" => "January 31, 2020",
    "j F, Y" => "31 January, 2020",
    "m.d.Y" => "01.31.2020",            
    "m/d/Y" => "01/31/2020",
    "d.m.Y" => "31.01.2020",
    "d/m/Y" => "31/01/2020",
    "n.d.Y" => "1.31.2020",
    "n/d/Y" => "1/31/2020",
    "d.n.Y" => "31.1.2020",
    "d/n/Y" => "31/1/2020",
    "Y.m.d" => "2020.01.31",
    "Y/m/d" => "2020/01/31",
    "Y.n.d" => "2020.1.31",
    "Y/n/d" => "2020/1/31",    
);

$general_setting .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[date_format]',
    'value' => ($plugin->date_format?$plugin->date_format:CalendarOptions::CALENDAR_UI_DEFAULT_DATE_FORMAT),
    'options_values' => $dformat,
    'label' => elgg_echo('calendar_ui:settings:date_format'),
    'help' => elgg_echo('calendar_ui:settings:date_format:help'),
    'required' => false,
)));

// date format settings
$tformat = array(
    "H:i" => "23:00",
    "h:i a" => "11:00 pm",
    "h:i A" => "11:00 PM",
);

$general_setting .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[time_format]',
    'value' => ($plugin->time_format?$plugin->time_format:CalendarOptions::CALENDAR_UI_DEFAULT_TIME_FORMAT),
    'options_values' => $tformat,
    'label' => elgg_echo('calendar_ui:settings:time_format'),
    'help' => elgg_echo('calendar_ui:settings:time_format:help'),
    'required' => false,
)));

// overlapping events
$general_setting .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[allow_overlap]',
    'value' => ($plugin->allow_overlap?$plugin->allow_overlap:CalendarOptions::CALENDAR_UI_YES),
    'options_values' => $options_yes_no,
    'label' => elgg_echo('calendar_ui:settings:allow_overlap'),
    'help' => elgg_echo('calendar_ui:settings:allow_overlap:help'),
    'required' => false,
))); 

$general_title = elgg_format_element('h3', [], elgg_echo('calendar_ui:settings:calendars:general_title'));
echo elgg_view_module('inline', '', $general_setting, ['header' => $general_title]);
