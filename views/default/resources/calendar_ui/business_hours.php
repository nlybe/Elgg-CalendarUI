<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use Events\API\Calendar;
use CalendarOptions;

$calendar_guid = elgg_extract('calendar_guid', $vars, '');
$calendar = get_entity($calendar_guid);

$error_msg = '';
if (!elgg_instanceof($calendar, 'object', Calendar::SUBTYPE)) {
    $error_msg = elgg_echo('calendar_ui:calendar:invalid');
}

if (!$calendar->canEdit()) {
    $error_msg = elgg_echo('calendar_ui:calendar:invalid_access');
}

if (!empty($error_msg)) {
    echo '<h3>'.$error_msg.'</h3>';
}
else {
    $title = elgg_format_element('h3', [], elgg_echo('calendar_ui:calendar:business_hours:title'));
    $title = elgg_format_element('div', ['class' => 'elgg-head'], $title);
    
    $vars['calendar'] = $calendar;
    $business_hours = $calendar->getAnnotations(CalendarOptions::CALENDAR_UI_BUSINESS_HOURS);
    if ($business_hours) {
        $vars['business_hours'] = $business_hours[0]->value;
    }     

    $form_vars = array('name' => 'business_hours', 'enctype' => 'multipart/form-data');
    $content = elgg_view_form('calendar_ui/business_hours', $form_vars, $vars);

    $content = elgg_format_element('div', ['style' => 'width:500px;height:350px;overflow-y: auto'], $content);
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-info'], $title.$content); 
}