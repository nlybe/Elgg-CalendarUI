<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 * timezone input
 */
 
$value = elgg_extract('value', $vars, '');
$required = elgg_extract('required', $vars, '');
$input_name = elgg_extract('name', $vars, 'timezone');
$help = elgg_extract('help', $vars, elgg_echo('calendar_ui:settings:user:timezone:help'));
$label = elgg_extract('label', $vars, elgg_echo('calendar_ui:settings:user:timezone:label'));

$regions = array(
    'Africa' => DateTimeZone::AFRICA,
    'America' => DateTimeZone::AMERICA,
    'Antarctica' => DateTimeZone::ANTARCTICA,
    'Asia' => DateTimeZone::ASIA,
    'Atlantic' => DateTimeZone::ATLANTIC,
    'Europe' => DateTimeZone::EUROPE,
    'Indian' => DateTimeZone::INDIAN,
    'Pacific' => DateTimeZone::PACIFIC
);

$timezones = array();
foreach ($regions as $name => $mask)
{
    $zones = DateTimeZone::listIdentifiers($mask);
    foreach($zones as $timezone)
    {
        // Lets sample the time there right now
        $time = new DateTime(NULL, new DateTimeZone($timezone));
        // Us dumb Americans can't handle millitary time
        $ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
        // Remove region name and add a sample time
        $timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
    }
}

$input_label = elgg_format_element('label', [ 'class' => "elgg-field-label", 'for' => "timezone" ], $label);
$input_box = '<select id="timezone" name="'.$input_name.'" '.($required?" required ":'').'>';
$input_box .= '<option value="">'.elgg_echo('calendar_ui:settings:user:timezone:select') . '</option>' . "\n";
foreach($timezones as $region => $list)
{
    
    $input_box .= '<optgroup label="' . $region . '">' . "\n";
    foreach($list as $timezone => $name)
    {
        $input_box .= '<option value="' . $timezone . '" '.($value==$timezone?' selected':'').'>' . $name . '</option>' . "\n";
    }
    $input_box .= '<optgroup>' . "\n";
}
$input_box .= '</select>';

$input_help = elgg_format_element('div', [ 'class' => "elgg-field-help elgg-text-help"], $help);

echo elgg_format_element('div', [ 'class' => "elgg-field"], $input_label.$input_box.$input_help);
