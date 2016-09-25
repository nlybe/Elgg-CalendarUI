<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

use CalendarOptions;

$title = elgg_extract('title', $vars, '');
$description = elgg_extract('description', $vars, '');
$location = elgg_extract('location', $vars, '');
$start_date = elgg_extract('start_date', $vars, '');
$end_date = elgg_extract('end_date', $vars, '');
$start_time = elgg_extract('start_time', $vars, '');
$end_time = elgg_extract('end_time', $vars, '');
$timezone = elgg_extract('timezone', $vars, '');
$start_timestamp = elgg_extract('start_timestamp', $vars, '');
$end_timestamp = elgg_extract('end_timestamp', $vars, '');
$start_timestamp_iso = elgg_extract('start_timestamp_iso', $vars, '');
$end_timestamp_iso = elgg_extract('end_timestamp_iso', $vars, '');
$end_delta = elgg_extract('end_delta', $vars, '');
$all_day = elgg_extract('all_day', $vars, '');
$no_details = elgg_extract('no_details', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
    $container_guid = $vars['container_guid'];
}
$guid = elgg_extract('guid', $vars, null);

if ($description) {
    $description = str_replace('<br />','',$description);
}

$dialog_form = elgg_format_element('div', [ 'class' => 'validateTips'], elgg_echo('calendar_ui:form:required'));

$dialog_form .= elgg_view_input('text', array(
    'id' => 'title',
    'name' => 'title',
    'class' => 'text ui-widget-content ui-corner-all',
    'label' => elgg_echo('calendar_ui:form:event:title'),
    'value' => $title,
    'help' => '',
    'required' => true,
));

$dialog_form .= elgg_view_input('checkbox', array(
    'id' => 'all_day',
    'name' => 'all_day',
    'class' => 'text ui-widget-content ui-corner-all',
    'label' => elgg_echo('calendar_ui:form:event:all_day'),
    'checked' => ($all_day == 1) ? true : false,
    'help' => '',
));

$dialog_form .= elgg_view_input('checkbox', array(
    'id' => 'no_details',
    'name' => 'no_details',
    'class' => 'text ui-widget-content ui-corner-all',
    'label' => elgg_echo('calendar_ui:form:event:no_details'),
    'checked' => ($no_details == 1) ? true : false,
    'help' => elgg_echo('calendar_ui:form:event:no_details:help'),
));

// show datetime picker only when editing an event
if ($guid) {
    $dialog_form_sdt = elgg_format_element('label', ['class' => 'elgg-field-label', 'for' => 'start_datetime'], elgg_echo('calendar_ui:form:event:start_datetime'));       
    $dialog_form_sdt .= elgg_view('input/cui_datetimepicker', array(
        'id' => 'start_datetime',
        'name' => 'start_datetime',
        'entity' => $vars['entity'],
        'value' => date('Y-m-d G:i', $start_timestamp),
    ));
    $dialog_form .= elgg_format_element('div', ['class' => 'elgg-field'], $dialog_form_sdt);

    $dialog_form_edt = elgg_format_element('label', ['class' => 'elgg-field-label', 'for' => 'end_datetime'], elgg_echo('calendar_ui:form:event:end_datetime'));       
    $dialog_form_edt .= elgg_view('input/cui_datetimepicker', array(
        'id' => 'end_datetime',
        'name' => 'end_datetime',
        'entity' => $vars['entity'],
        'value' => date('Y-m-d G:i', $end_timestamp),
    ));
    $dialog_form .= elgg_format_element('div', ['class' => 'elgg-field'], $dialog_form_edt);
}

if (CalendarOptions::isUserTimezoneEnabled()) {
    if (!$timezone) {
        $timezone = CalendarOptions::getActiveTimezone();
    }

    //$dialog_form_edt = elgg_format_element('label', ['class' => 'elgg-field-label', 'for' => 'timezone'], elgg_echo('calendar_ui:form:event:timezone'));       
    $dialog_form_edt .= elgg_view('input/timezone', array(
        'id' => 'timezone',
        'name' => 'timezone',
        'entity' => $vars['entity'],
        'value' => $timezone,
    ));
    $dialog_form .= elgg_format_element('div', ['class' => 'elgg-field'], $dialog_form_edt);
}

$dialog_form .= elgg_view_input('text', array(
    'id' => 'location',
    'name' => 'location',
    'class' => 'text ui-widget-content ui-corner-all',
    'label' => elgg_echo('calendar_ui:form:event:location'),
    'value' => $location,
    'help' => '',
));

$dialog_form .= elgg_view_input('plaintext', array(
    'id' => 'description',
    'name' => 'description',
    'class' => 'text ui-widget-content ui-corner-all',
    'label' => elgg_echo('calendar_ui:form:event:description'),
    'value' => $description,
    'help' => '',
));

$dialog_form .= elgg_format_element('div', [], elgg_view_input('dropdown', array(
    'id' => 'comments_on',
    'name' => 'comments_on',
    'value' => elgg_extract('comments_on', $vars, ''),
    'options_values' => array('On' => elgg_echo('on'), 'Off' => elgg_echo('off')),
    'label' => elgg_echo('comments'),
)));

$dialog_form .= elgg_format_element('div', [], elgg_view_input('access', array(
    'id' => 'access_id',
    'name' => 'access_id',
    'value' => $access_id,
    'label' => elgg_echo('access'),
)));

if ($guid) {
    $dialog_form_footer .= elgg_view_input('hidden', array(
        'id' => 'guid',
        'name' => 'guid',
        'value' => $guid,
    ));
}
    
$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'start_date',
    'name' => 'start_date',
    'value' => $start_date,
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'start_time',
    'name' => 'start_time',
    'value' => $start_time,
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'end_date',
    'name' => 'end_date',
    'value' => $end_date,
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'end_time',
    'name' => 'end_time',
    'value' => $end_time,
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'container_guid',
    'name' => 'container_guid',
    'value' => $container_guid,
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'calendar_guid',
    'name' => 'calendar_guid',
    'value' => $vars['calendar_guid'],
));

$dialog_form_footer .= elgg_view_input('hidden', array(
    'id' => 'owner_guid',
    'name' => 'owner_guid',
    'value' => $vars['owner_guid'],
));

if ($guid) {
    $dialog_form_footer .= elgg_view('input/submit', array('value' => elgg_echo('save')));
}
else {  // new event, form opened from calendar in dialog box
    // Allow form submission with keyboard without duplicating the dialog button
    $dialog_form_footer .= elgg_view_input('submit', array(
        'tabindex' => '-1',
        'style' => 'position:absolute; top:-1000px',
    ));
}

$dialog_form_footer = elgg_format_element('div', ['class'=>'elgg-foot'], $dialog_form_footer);

$dialog_form = elgg_format_element('fieldset', [], $dialog_form.$dialog_form_footer);
echo $dialog_form;


 
