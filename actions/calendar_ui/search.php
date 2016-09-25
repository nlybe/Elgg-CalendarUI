<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

// get variables
$c_subtype = get_input("c_subtype");
$c_limit = (int) get_input('c_limit', 0);
$c_container_guid = get_input("c_container_guid");
$c_owner_guid = get_input("c_owner_guid");
$c_start_dt = get_input("c_start_dt");
$c_end_dt = get_input("c_end_dt");
$timezone = get_input("timezone");

$start_timestamp = strtotime($c_start_dt);
$end_timestamp = strtotime($c_end_dt);

$options = array(
    'type' => 'object',
    'subtype' => $c_subtype,
    'limit' => $c_limit,
    'container_guid' => $c_container_guid,
    'metadata_name_value_pairs' => array(
        array('name' => 'start_timestamp','value' => $start_timestamp, 'operand' => '>='),
        array('name' => 'start_timestamp','value' => $end_timestamp, 'operand' => '<='),
    ),
);
$entities = elgg_get_entities_from_metadata($options);

$event_objects = array();
if ($entities) {
    foreach ($entities as $e) {
        $object_x = array();
        $object_x['guid'] = $e->getGUID();
        $object_x['title'] = $e->title;
        $object_x['start_date'] = $e->start_date;
        $object_x['start_time'] = $e->start_time;
        $object_x['end_date'] = $e->end_date;
        $object_x['end_time'] = $e->end_time;
        $object_x['timezone'] = $e->timezone;
        $object_x['start_timestamp_iso'] = CalendarOptions::parseDateTime($e->start_timestamp_iso, $timezone);
        $object_x['end_timestamp_iso'] = CalendarOptions::parseDateTime($e->end_timestamp_iso, $timezone);
        $object_x['all_day'] = $e->all_day;
        $object_x['no_details'] = $e->no_details;
        array_push($event_objects, $object_x);  
    }
} 

$result = array(
    'error' => false,
    'event_objects' => json_encode($event_objects),
);

// release variables
unset($entities);
unset($event_objects);

echo json_encode($result);
exit;
