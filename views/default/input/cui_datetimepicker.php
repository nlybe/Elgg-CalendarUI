<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

elgg_require_js("calendar_ui/cui_datetimepicker");

elgg_load_css('cui_datetimepicker');

$entity = elgg_extract("entity", $vars, "");

// get datetimepicker directly from value if available
$datetime = elgg_extract("value", $vars, "");

$name = elgg_extract("name", $vars, "");
$id = elgg_extract("id", $vars, "");
$class = elgg_extract("class", $vars, "");

$defaults = array(
    'id' => $id,
    'name' => ($name?$name:'datetimepicker'), 
    'class' => $class, 
    'value' => $datetime,    
    'disabled' => false,
    'type' => 'text',
);

$vars = array_merge($defaults, $vars);

echo elgg_format_element('input', $vars);
