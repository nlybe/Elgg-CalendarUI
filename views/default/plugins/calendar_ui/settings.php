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

// timezone settings
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[enable_timezone]',
    'value' => ($plugin->enable_timezone?$plugin->enable_timezone:CALENDAR_UI_NO),
    'options_values' => $options_yes_no,
    'label' => elgg_echo('calendar_ui:settings:enable_timezone'),
    'help' => elgg_echo('calendar_ui:settings:enable_timezone:help'),
    'required' => false,
))); 

// locale settings
echo elgg_format_element('div', [], elgg_view('input/locale', array(
    'name' => 'params[default_locale]',
    'value' => $plugin->default_locale,
    'label' => elgg_echo('calendar_ui:settings:default_locale'),
    'help' => elgg_echo('calendar_ui:settings:default_locale:help'),
    'required' => false,
))); 

echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
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

echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
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
    "h:i a" => "01:00 am",
    "h:i A" => "01:00 AM",
);

echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[time_format]',
    'value' => ($plugin->time_format?$plugin->time_format:CalendarOptions::CALENDAR_UI_DEFAULT_TIME_FORMAT),
    'options_values' => $tformat,
    'label' => elgg_echo('calendar_ui:settings:time_format'),
    'help' => elgg_echo('calendar_ui:settings:time_format:help'),
    'required' => false,
)));

// overlapping events
echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[allow_overlap]',
    'value' => ($plugin->allow_overlap?$plugin->allow_overlap:CALENDAR_UI_YES),
    'options_values' => $options_yes_no,
    'label' => elgg_echo('calendar_ui:settings:allow_overlap'),
    'help' => elgg_echo('calendar_ui:settings:allow_overlap:help'),
    'required' => false,
))); 


// menu settings
$menu_target_values = array(
    'site_calendar' => elgg_echo('calendar_ui:settings:menu_target:site_calendar'),
    'user_calendar' => elgg_echo('calendar_ui:settings:menu_target:user_calendar'),
    'no' => elgg_echo('calendar_ui:settings:menu_target:no'),
); 

echo elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'name' => 'params[menu_target]',
    'value' => ($plugin->menu_target?$plugin->menu_target:CALENDAR_UI_DEFAULT_MENU_ITEM),
    'options_values' => $menu_target_values,
    'label' => elgg_echo('calendar_ui:settings:menu_target'),
    'help' => elgg_echo('calendar_ui:settings:menu_target:help'),
    'required' => false,
))); 

