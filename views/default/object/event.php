<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);

if (!$entity) { 
    echo 'invalid event';
    return;
}

$owner = $entity->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'small');
$owner_link = elgg_view('output/url', array(
    'href' => elgg_normalize_url("profile/$owner->username"),
    'text' => $owner->name,
    'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($entity->time_created);

//only display if there are commments
if ($entity->comments_on != 'Off') {
    $comments_count = $entity->countComments();
    //only display if there are commments
    if ($comments_count != 0) {
        $text = elgg_echo("comments") . " ($comments_count)";
        $comments_link = elgg_view('output/url', array(
            'href' => $entity->getURL() . '#comments',
            'text' => $text,
            'is_trusted' => true,
        ));
    } else {
        $comments_link = '';
    }
} else {
    $comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
    'entity' => $vars['entity'],
    'handler' => 'events',
    'sort_by' => 'priority',
    'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $featured";
$timezone = CalendarOptions::getActiveTimezone();

if ($entity->all_day) {
    $dformat = CalendarOptions::getDefaultDateFormat();
    $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:all_day'));
    $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell cui_check'], elgg_view_icon('check'));
    $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box); 
    
    $s_sate = CalendarOptions::parseDateTime($entity->start_timestamp_iso, $timezone, $dformat);
    $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:start_date'));
    $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell cui_check'], $s_sate);
    $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box);
    
    $e_sate = CalendarOptions::parseDateTime($entity->end_timestamp_iso, $timezone, $dformat);
    $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:start_date'));
    $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell cui_check'], $e_sate);
    $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box);    
}
else {
    $dformat = CalendarOptions::getDateTimeFormat();
    if ($entity->start_date) {
        $s_sate = CalendarOptions::parseDateTime($entity->start_timestamp_iso, $timezone, $dformat);
        $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:start_datetime'));
        $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell'], $s_sate);
        $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box);
    }
    if ($entity->end_date) {
        $e_sate = CalendarOptions::parseDateTime($entity->end_timestamp_iso, $timezone, $dformat);
        $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:end_datetime'));
        $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell'], $e_sate);
        $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box);
    }    
}

if ($entity->location) {
    $tmp_box = elgg_format_element('div', ['class'=>'divTableCell cui_label'], elgg_echo('calendar_ui:form:event:location'));
    $tmp_box .= elgg_format_element('div', ['class'=>'divTableCell'], $entity->location);
    $content .= elgg_format_element('div', ['class'=>'divTableRow'], $tmp_box);        
}


$content = elgg_format_element('div', ['class'=>'divTableBody'], $content);
$content = elgg_format_element('div', ['class'=>'divTable'], $content);
$content = elgg_format_element('div', [ 'class' => "cui_timezone"], elgg_echo('calendar_ui:timezone', array($timezone))).$content;

if ($entity->description) {
    if ($full && !elgg_in_context('gallery')) 
        $content .= elgg_format_element('div', ['class'=>''], $entity->description);
    else
        $content .= elgg_format_element('div', ['class'=>''], elgg_get_excerpt($entity->description, 200));
} 

if ($full && !elgg_in_context('gallery')) {
    $params = array(
        'entity' => $entity,
        'title' => false,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
    );
    $params = $params + $vars;
    $summary = elgg_view('object/elements/summary', $params);

    echo elgg_view('object/elements/full', array(
        'entity' => $entity,
        'icon' => $owner_icon,
        'summary' => $summary,
        'body' => $content,
    ));
} 
else {
    //$content = $entity->all_day;
    $params = array(
        'entity' => $entity,
        'metadata' => $metadata,
        'subtitle' => $subtitle,
        'content' => $content,
    );
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);

    echo elgg_view_image_block($owner_icon, $body);
}
