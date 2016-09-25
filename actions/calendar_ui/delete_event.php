<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use Exception;

$guid = get_input('guid');
$event = get_entity($guid);

if (!$event instanceof Event || !$event->canEdit()) {
    register_error(elgg_echo('events:error:invalid:guid'));
    forward(REFERER);
}

try {
    $event->delete();
    system_message(elgg_echo('events:success:deleted'));
} catch (Exception $ex) {
    register_error($ex->getMessage());
}

// go back to calendar
forward(REFERRER);
