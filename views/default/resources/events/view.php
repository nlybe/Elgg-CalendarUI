<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 */

//get entity
$entity_guid = elgg_extract('guid', $vars, '');
$entity = get_entity($entity_guid);

if (!$entity) {
    register_error(elgg_echo('noaccess'));
    forward(REFERRER);
}

$calendar = get_entity($entity->container_guid);
$owner = get_entity($calendar->owner_guid);
if ($owner instanceof \ElggUser) {
    elgg_push_breadcrumb($calendar->getDisplayName(), "calendar/$owner->username");
}

$title = $entity->title; 
elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, array('full_view' => true));
if ($entity->comments_on != 'Off') {
    $content .= elgg_view_comments($entity);
}     

$sidebar = '';

$body = elgg_view_layout('content', array(
    'content' => $content,
    'title' => $title,
    'filter' => '',
    'sidebar' => $sidebar,
));
echo elgg_view_page($title, $body);



