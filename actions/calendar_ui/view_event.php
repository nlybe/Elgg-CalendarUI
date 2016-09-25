<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

$guid = get_input('guid');
$entity = get_entity($guid);

$vars = array(
    'entity' => $entity, 
    'full_view' => false
);

$content = elgg_view('object/event', $vars);

$result = array(
    'error' => false,
    'content' => $content,
);

echo json_encode($result);
exit;
