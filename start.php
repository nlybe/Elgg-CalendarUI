<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */
 
require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/widgets.php');

elgg_register_event_handler('init', 'system', 'calendar_ui_init');

/**
 * calendar_ui plugin initialization functions.
 */
function calendar_ui_init() {
 	
    // register a library of helper functions
    elgg_register_library('elgg:calendar_ui', elgg_get_plugins_path() . 'calendar_ui/lib/calendar_ui.php');
    
    // register fullcalendar css files
    elgg_register_css('fullcalendar_css', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.0/fullcalendar.min.css');
    elgg_register_css('fullcalendar_print_css', '//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.0/fullcalendar.print.css');
    // register jquery ui css files    
    elgg_register_css('jquery_ui_css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    // register datetimepicker css file
    elgg_register_css('cui_datetimepicker', elgg_get_simplecache_url('calendar_ui/jquery.datetimepicker.min.css'));
        
    // register extra css
    elgg_extend_view('elgg.css', 'calendar_ui/calendar_ui.css');
    elgg_extend_view('css/admin', 'calendar_ui/calendar_ui_admin.css');
    
    elgg_define_js('cui_fullcalendar_js', array(
        'src' => "//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.0/fullcalendar.min.js", 
        'deps' => array('jquery', 'moment'),
        'exports' => 'cui_fullcalendar_js',
    ));
    
    elgg_define_js('cui_locale_all', array(
        'deps' => array('moment', 'jquery', 'jquery-ui', 'cui_fullcalendar_js'),
        'exports' => 'cui_locale_all',
    ));    
    
    elgg_define_js('jquery-mousewheel', array(
        'src' => "//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.js", 
        'deps' => array('jquery'),
        'exports' => 'jquery-mousewheel',
    ));  
    
    // register plugin settings view
    elgg_register_simplecache_view('calendar_ui/settings.js');    
    
   // add localization options in user settings
    if (CalendarOptions::isUserLocalizationSettingsEnabled()) {
        elgg_register_plugin_hook_handler('usersettings:save', 'user', 'calendar_ui_add_localization_in_user_setting');
        elgg_extend_view('forms/account/settings', 'forms/settings/localization');    
    }    
    
    // Site navigation
    if ( CalendarOptions::isSiteCalendarEnabled() ) {
        $item = new ElggMenuItem('calendar', elgg_echo('calendar_ui:menu'), 'calendar');
        elgg_register_menu_item('site', $item); 
    }
    
    // Register a page handler, so we can have nice URLs for 'calendar'
    elgg_register_page_handler('calendar', 'calendar_ui_page_handler');
    // Register a page handler, so we can have nice URLs for 'events'
    elgg_register_page_handler('events', 'calendar_ui_event_page_handler');    
    
    // Register a URL handler for calendars and events
    elgg_register_plugin_hook_handler('entity:url', 'object', 'calendar_ui_set_url');        

    // loads the widgets
    calendar_ui_widgets_init();

    // Register actions admin
    $action_path = elgg_get_plugins_path() . 'calendar_ui/actions/calendar_ui';
    elgg_register_action('calendar_ui/search', "$action_path/search.php", 'public');
    elgg_register_action('calendar_ui/add_event', "$action_path/add_event.php");
    elgg_register_action('calendar_ui/view_event', "$action_path/view_event.php", 'public');
    elgg_register_action('calendar_ui/business_hours', "$action_path/business_hours.php", 'public');    
    
    // replace delete action from events_api
    elgg_register_action('events/delete');
    elgg_register_action('events/delete', "$action_path/delete_event.php");
}

/**
 *  Dispatches calendar_ui pages.
 *
 * @param array $page
 * @return bool
 */
function calendar_ui_page_handler($page) {
    elgg_push_breadcrumb(elgg_echo('calendar_ui:site'), 'calendar');
    $resource_vars = array();
    
    switch ($page[0]) {
        case 'business_hours':
            if (elgg_is_active_plugin('events_api')) {
                $resource_vars['calendar_guid'] = elgg_extract(1, $page);
                echo elgg_view_resource('calendar_ui/business_hours', $resource_vars);
            } 
            else {
                echo elgg_echo('calendar_ui:form:event:no_events_api');
            }
            break;  
        
        default:
            $user = get_user_by_username($page[0]);
            if ($user instanceof \ElggUser) {
                elgg_set_page_owner_guid($user->getGUID());
                $resource_vars['username'] = $page[0];
                
                if ( CalendarOptions::isUserCalendarEnabled($user->username) ) {
                    echo elgg_view_resource('calendar_ui/calendar', $resource_vars);
                }
                else {
                    register_error(elgg_echo('calendar_ui:calendar:user:disabled')); 
                    forward(elgg_get_site_url());
                }
            }            
            else {
                if ( CalendarOptions::isSiteCalendarEnabled() ) {
                    // go to site calendar only if enabled in settings
                    echo elgg_view_resource('calendar_ui/calendar', $resource_vars);
                }
                else {
                    register_error(elgg_echo('calendar_ui:calendar:site:disabled')); 
                    forward(elgg_get_site_url());
                }
            }
            
            return false;
    }     
    
    return true;
}

/**
 *  Dispatches calendar_ui pages.
 *
 * @param array $page
 * @return bool
 */
function calendar_ui_event_page_handler($page) {
    elgg_push_breadcrumb(elgg_echo('calendar_ui:site'), 'calendar');
    
    $resource_vars = array();
    switch ($page[0]) {
        case "view":
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('events/view', $resource_vars);
            break;
        case "edit":
            $resource_vars['guid'] = elgg_extract(1, $page);
            echo elgg_view_resource('events/edit', $resource_vars);
            break;
            
        default:
            return false;
    }    
    return true;   
    
}

?>
