<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

if (!elgg_is_active_plugin('profile_manager')) {
    echo elgg_echo('calendar_ui:form:event:no_profile_manager');
    return;
}

$plugin = elgg_extract('plugin', $vars, elgg_get_plugin_from_id('calendar_ui'));

$entities = elgg_get_entities([
    'type' => 'object',
    'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
    'limit' => false,
    'owner_guid' => elgg_get_site_entity()->getGUID(),
    'no_results' => elgg_echo('profile_manager:profile_types:list:no_types'),
]);

if ($entities) {
    foreach ($entities as $e) {
        $name = 'profile_type_' . $e->getGUID();
        $field_name = 'params['.$name.']';
        $list .= elgg_view_input('checkbox', array(
            'name' => $field_name,
            'label' => $e->metadata_name,
            'checked' => ($plugin->$name || !isset($plugin->$name) ? true : false),
            'required' => false,
        ));        
    }
} 

$legent = elgg_format_element('legend', [], elgg_echo('calendar_ui:settings:enable_user_calendar:pm_intro'));
$list = elgg_format_element('fieldset', [], $legent.$list);
echo elgg_format_element('div', ['class' => 'cui_profile_types_list'], $list);

