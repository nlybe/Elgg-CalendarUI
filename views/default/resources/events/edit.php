<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;

elgg_load_library('elgg:calendar_ui');

$entity_guid = elgg_extract('guid', $vars, '');
$entity = get_entity($entity_guid);

if (!elgg_instanceof($entity, 'object', Event::SUBTYPE) || !$entity->canEdit()) {
    register_error(elgg_echo('calendar_ui:events:unknown'));
    forward(REFERRER);
}

$calendar = get_entity($entity->container_guid);
$owner = get_entity($calendar->owner_guid);
if ($owner instanceof \ElggUser) {
    elgg_push_breadcrumb($calendar->getDisplayName(), "calendar/$owner->username");
}
elgg_push_breadcrumb($entity->title, $entity->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo('calendar_ui:events:edit', array($entity->title));

$form_vars = array('name' => 'events', 'enctype' => 'multipart/form-data');
$vars = calendar_ui_events_prepare_form_vars($entity);
$content = elgg_view_form('calendar_ui/add_event', $form_vars, $vars);

$body = elgg_view_layout('content', array(
    'filter' => '',
    'content' => $content,
    'title' => $title,
));

echo elgg_view_page($title, $body);
