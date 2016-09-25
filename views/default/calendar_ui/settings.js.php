<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

//$plugin_settings = elgg_get_plugin_from_id('calendar_ui')->getAllSettings();

$settings = [
    'user_locale' => CalendarOptions::getDefaultLocale(),    // set default value, it will may change later
    'default_locale' => CalendarOptions::getDefaultLocale(),
    'active_timezone' => CalendarOptions::getActiveTimezone(),
    'allow_overlap' => CalendarOptions::isEventsOverlappingEnabled(),
    //'default_locale' => elgg_extract('unitmeas', $map_settings),
];

if (CalendarOptions::isUserLocaleEnabled()) {
    $user = elgg_get_logged_in_user_entity();
    if ($user instanceof \ElggUser) {
        if (isset($user->locale)) {
            $settings['user_locale'] = $user->locale;
        }
    }
}

?>

define(<?php echo json_encode($settings); ?>);
