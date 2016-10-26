<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 *
 * All widgets declarations
 */


/**
 * Inits the various widgets
 * @return void
 */
function calendar_ui_widgets_init() {
    // add user or site calendar
    elgg_register_widget_type('calendar', elgg_echo('calendar_ui:calendar:widget'), elgg_echo('calendar_ui:calendar:widget:description'), array("profile", "dashboard"), false);
    
}