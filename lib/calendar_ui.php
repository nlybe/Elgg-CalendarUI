<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

/**
 * Add events form parameters
 * 
 * @param type $entity
 * @return type
 */
function calendar_ui_events_prepare_form_vars($entity = null) {
    // input names => defaults
    $values = array(
        'title' => '',
        'description' => '',
        'location' => '',
        'start_date' => '',
        'end_date' => '',
        'start_time' => '',
        'end_time' => '',
        'timezone' => '',
        'start_timestamp' => '',
        'end_timestamp' => '',
        'start_timestamp_iso' => '',
        'end_timestamp_iso' => '',
        'end_delta' => '',
        'all_day' => '',
        'no_details' => '',
        'access_id' => ACCESS_DEFAULT,
        'container_guid' => elgg_get_page_owner_guid(),
        'entity' => $entity,
        'guid' => null,
        'comments_on' => NULL,
    ); 

    if ($entity) {
        foreach (array_keys($values) as $field) {
            if (isset($entity->$field)) {
                $values[$field] = $entity->$field;
            }
        }
    }

    if (elgg_is_sticky_form('events')) {
        $sticky_values = elgg_get_sticky_values('events');
        foreach ($sticky_values as $key => $value) {
            $values[$key] = $value;
        }
    }

    elgg_clear_sticky_form('events');

    return $values;
}