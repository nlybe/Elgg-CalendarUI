<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

$lang = array(

    'calendar_ui' => "Calendar UI",
    'calendar_ui:menu' => "Calendar",
    'calendar_ui:menu:user' => "My Calendar",
    'calendar_ui:site' => "Site Calendar",
    'calendar_ui:group' => "Group Calendar",
    'item:object:event' => "Events",
    'item:object:calendar' => "Calendars",
    'calendar_ui:timezone' => "Timezone: %s",
    'calendar_ui:calendar:site:disabled' => "Site calendar is not enabled",
    'calendar_ui:calendar:user:disabled' => "User's calendar is not enabled",
    
    // calendar
    'calendar_ui:user:title' => "%s's Calendar",
    'calendar_ui:events:calendar:display_name' => '%s\'s Calendar',
    'calendar_ui:calendar:invalid' => 'Invalid calendar',
    'calendar_ui:calendar:invalid_access' => 'Invalid access to this calendar',
        
    // create form event
    'calendar_ui:form:title' => "Create Event",
    'calendar_ui:form:required' => "All fields with asterisk are required",
    'calendar_ui:form:event:title' => "Title of Event",
    'calendar_ui:form:event:start_datetime' => "Start Date/Time",
    'calendar_ui:form:event:end_datetime' => "End Date/Time",
    'calendar_ui:form:event:location' => "Location",
    'calendar_ui:form:event:description' => "Description",
    'calendar_ui:form:event:all_day' => "All day",
    'calendar_ui:form:event:start_date' => "Start Date",
    'calendar_ui:form:event:end_date' => "End Date",
    'calendar_ui:form:event:no_details' => "Show Just Busy",
    'calendar_ui:form:event:timezone' => "Timezone",
    'calendar_ui:form:event:no_details:help' => "If checked, users will not see details but the event slot will be colored.",
    
    'calendar_ui:form:event:success' => "Event was successfully saved",
    'calendar_ui:form:event:failed' => "Error while saving event",
    'calendar_ui:form:event:title_empty' => "Title cannot be empty",
    'calendar_ui:form:event:no_events_api' => "Error: events_api plugin is not enabled",
    'calendar_ui:form:event:no_profile_manager' => "Error: profile_manager plugin is not enabled",
    'calendar_ui:events:unknown' => 'Invalid access to this event',
    'calendar_ui:events:edit' => 'Edit %s',
    'calendar_ui:events:overlapping:error' => 'Overlapping events are not allowed',
    
    // business hours
    'calendar_ui:calendar:business_hours:btn' => 'Edit Business Hours',
    'calendar_ui:calendar:business_hours:title' => 'Set business hours for your calendar',
    'calendar_ui:calendar:business_hours:add_more' => '%s Add Line',
    'calendar_ui:calendar:business_hours:add_line' => 'Add this line',
    'calendar_ui:calendar:business_hours:remove_line' => 'Remove this line',
    'calendar_ui:calendar:business_hours:success' => 'Business Hours was successfully saved',
    'calendar_ui:calendar:business_hours:error' => 'Empty or invalid days/hours',
    'calendar_ui:calendar:business_hours:day' => 'Week Day',
    'calendar_ui:calendar:business_hours:start' => 'Time Start',
    'calendar_ui:calendar:business_hours:end' => 'Time End',
    
    // user settings
    'calendar_ui:settings:user:localization:title' => "Localization Settings",
    'calendar_ui:settings:user:timezone:label' => "Time Zone",
    'calendar_ui:settings:user:timezone:select' => "Select Time Zone",
    'calendar_ui:settings:user:timezone:help' => "Depending on timezone selected you will see date/time related information to this timezone.",
    'calendar_ui:settings:user:timezone:success' => "Timezone was successfully saved",
    'calendar_ui:settings:user:timezone:fail' => "Failure on trying to save time zone",
    'calendar_ui:settings:user:locale:label' => "Locale",
    'calendar_ui:settings:user:localization:success' => "Locale was successfully saved",
    'calendar_ui:settings:user:localization:fail' => "Failure on trying to save locale",   
    
    // widgets
    'calendar_ui:calendar:widget' => "Calendar",
    'calendar_ui:calendar:widget:description' => "Display your calendar",
    'calendar_ui:calendar:widget:not_available' => "Calendar is not available",
    'calendar_ui:calendar:widget:events:not_enabled' => "Events API Plugin is not enabled",
    'calendar_ui:calendar:widget:view_full' => "View Full Calendar",
        
    // settings
    'calendar_ui:settings:yes' => "Yes",
    'calendar_ui:settings:no' => "No",
    'calendar_ui:settings:menu_target' => "Site Menu",
    'calendar_ui:settings:menu_target:no' => "No",
    'calendar_ui:settings:menu_target:site_calendar' => "Site Calendar",
    'calendar_ui:settings:menu_target:user_calendar' => "User Calendar",
    'calendar_ui:settings:menu_target:help' => "Select if want to add 'Calendar' option in site menu.<br />Choose <strong>No</strong> for not adding, <strong>Site Calendar</strong> for targeting to site's calendar or <strong>User Calendar</strong> for targeting to logged-in user's calendar.",
    'calendar_ui:settings:enable_timezone' => "Enable User Timezone",
    'calendar_ui:settings:enable_timezone:help' => "If select '<strong>No</strong>', the default timezone settings will be used, as set in settings.php. All events submitted will have this default timezone.<br />If select '<strong>Yes</strong>', users will be able to choose timezone in user's settings. Also timezone option will be available when submitting events.",
    'calendar_ui:settings:default_locale' => "Default Locale",
    'calendar_ui:settings:default_locale:label' => "Locale",
    'calendar_ui:settings:default_locale:help' => "Customize the language and localization options for the calendar.",
    'calendar_ui:settings:user_locale' => "Enable User Locale",
    'calendar_ui:settings:user_locale:help' => "If select '<strong>No</strong>', the default locale settings will be used. <br />If select '<strong>Yes</strong>', users will be able to choose locale in user's settings.",
    'calendar_ui:settings:date_format' => "Date Format",
    'calendar_ui:settings:date_format:help' => "Enter date format for displaying date. The full format (1st option) is not suggested if having all day events.",
    'calendar_ui:settings:time_format' => "Time Format",
    'calendar_ui:settings:time_format:help' => "Time date format for displaying time. It will not affect if selected as 'Date Format' the full format (1st option)",
    'calendar_ui:settings:allow_overlap' => "Allow Overlapping Events",
    'calendar_ui:settings:allow_overlap:help' => "Select <strong>No</strong> if is not allowed to create overlapping events.",
    'calendar_ui:settings:calendars' => "Enable Calendars",
    'calendar_ui:settings:enable_site_calendar' => "Site Calendar",
    'calendar_ui:settings:enable_site_calendar:help' => "Select <strong>Yes</strong> if want to enable calendar for site events.",
    'calendar_ui:settings:enable_user_calendar' => "User's Calendar",
    'calendar_ui:settings:enable_user_calendar:help' => "Select <strong>Yes</strong> if want to allow users keep their own calendar.",
    'calendar_ui:settings:enable_user_calendar:pm_intro' => "Select below the profile types for which the calendar will be enabled",
    'calendar_ui:settings:calendars:general_title' => "General Calendar Options",
);

add_translation("en", $lang);
