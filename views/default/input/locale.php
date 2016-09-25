<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 * Locale input
 */

// Depending page loaded (user or site setting), load the right js file. Should find way a smarter way
$page_owner = elgg_get_page_owner_entity();
if ($page_owner instanceof \ElggUser) {
    elgg_require_js("calendar_ui/calendar_ui_user");
}
else {
    elgg_require_js("calendar_ui/calendar_ui_admin");
}
        
$value = elgg_extract('value', $vars, '');
$required = elgg_extract('required', $vars, false);
$label = elgg_extract('label', $vars, elgg_echo('calendar_ui:settings:default_locale'));
$help = elgg_extract('help', $vars, elgg_echo('calendar_ui:settings:default_locale:help'));
$input_name = elgg_extract('name', $vars, 'locale');

echo elgg_view_input('dropdown', array(
    'id' => 'locale-selector',
    'name' => $input_name,
    'value' => $value,
    'label' => $label,
    'help' => $help,
    'required' => $required,
)); 



