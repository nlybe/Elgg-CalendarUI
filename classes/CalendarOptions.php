<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

class CalendarOptions {

    const CALENDAR_UI_ID = 'calendar_ui';    // current plugin ID
    const CALENDAR_UI_DEFAULT_MENU_ITEM = 'site_calendar';  // default menu option
    const CALENDAR_UI_DEFAULT_LOCALE = 'en';       // default locale
    const CALENDAR_UI_DEFAULT_DATE_FORMAT = 'r';    // default date format
    const CALENDAR_UI_DEFAULT_TIME_FORMAT = 'h:i a';    // default date format
    const CALENDAR_UI_YES = 'yes';  // general purpose yes
    const CALENDAR_UI_NO = 'no';    // general purpose no
    const CALENDAR_UI_BUSINESS_HOURS = 'business_hours';    // annotation string for setting business hours on calendar
    
    /**
     * Retrieve menu item option from settings. Return default if not specified.
     * 
     * @return type
     */
    Public Static function getMenuSetting() {
        $menu_target = elgg_get_plugin_setting('menu_target', CalendarOptions::CALENDAR_UI_ID);

        if (!empty('$menu_target'))
            return $menu_target;

        return CalendarOptions::CALENDAR_UI_DEFAULT_MENU_ITEM;
    }

    /**
     * Check various site settings and return true if have to enable localization options in user's setting
     * 
     * @return type
     */
    Public Static function isUserLocalizationSettingsEnabled() {
        if (
                CalendarOptions::isUserTimezoneEnabled() ||
                CalendarOptions::isUserLocaleEnabled()
           ) {
            return true;
        }


        return false;
    }
    
    /**
     * Retrieve timezone option from settings. Return false if not specified.
     * 
     * @return type
     */
    Public Static function isUserTimezoneEnabled() {
        $enable_timezone = elgg_get_plugin_setting('enable_timezone', CalendarOptions::CALENDAR_UI_ID);

        if ($enable_timezone == CalendarOptions::CALENDAR_UI_YES) {
            return true;
        }

        return false;
    }    
    
    /**
     * Retrieve locale option from settings. Return false if not specified.
     * 
     * @return type
     */
    Public Static function isUserLocaleEnabled() {
        $user_locale = elgg_get_plugin_setting('user_locale', CalendarOptions::CALENDAR_UI_ID);

        if ($user_locale == CalendarOptions::CALENDAR_UI_YES) {
            return true;
        }

        return false;
    } 

    /**
     * Retrieve events overlapping option from settings. Return false if not specified.
     * 
     * @return type
     */
    Public Static function isEventsOverlappingEnabled() {
        $setting = elgg_get_plugin_setting('allow_overlap', CalendarOptions::CALENDAR_UI_ID);

        if ($setting == CalendarOptions::CALENDAR_UI_NO) {
            return false;
        }

        return true;
    }     
    
    /**
     * Return the current active timezone, depending setting and current user (if logged-in)
     * 
     * @return type
     */
    Public Static function getActiveTimezone() {
        
        if (CalendarOptions::isUserTimezoneEnabled()) {
            $user = elgg_get_logged_in_user_entity();
            if ($user && $user->timezone) {
                return $user->timezone;
            }                
        }
        
        return date_default_timezone_get();
    }    
    
    /**
     * Parses a string into a DateTime object, optionally forced into the given timezone.
     * If date/time format are given, the returned value will be in this format
     * 
     * @param type $string
     * @param type $timezone
     * @return \DateTime
     */
    function parseDateTime($string, $timezone= null, $dformat = '', $tformat = '') {
        $timezone = new DateTimeZone($timezone ? $timezone : CalendarOptions::getActiveTimezone());
        
        $date = new DateTime(
            $string,
            $timezone
        );
        if ($timezone) {
            // If our timezone was ignored above, force it.
            $date->setTimezone($timezone);
        }
           
        if ($dformat) {
            return $date->format($dformat);
        }
        
        // if not format is given, return the ISO 8601 date format
        return $date->format('c');
    }    
    
    /**
     * Retrieve active locale from settings
     * 
     * @return string
     */
    Public Static function getDefaultLocale() {
        $locale = elgg_get_plugin_setting('default_locale', CalendarOptions::CALENDAR_UI_ID);
        if (!$locale || empty($locale)) {
            // set a default locale to use for just in case
            $locale = CalendarOptions::CALENDAR_UI_DEFAULT_LOCALE; 
        }
        
        return $locale;
    }    
    
    /**
     * Retrieve the date format from settings
     * @return type
     */
    Public Static function getDefaultDateFormat() {
        $date_format = elgg_get_plugin_setting('date_format', CalendarOptions::CALENDAR_UI_ID);
        if (!$date_format || empty($date_format)) {
            $date_format = CalendarOptions::CALENDAR_UI_DEFAULT_DATE_FORMAT; 
        }
        
        return $date_format;
    } 
    
    /**
     * Retrieve the time format from settings
     * @return type
     */
    Public Static function getDefaultTimeFormat() {
        $time_format = elgg_get_plugin_setting('time_format', CalendarOptions::CALENDAR_UI_ID);
        if (!$time_format || empty($time_format)) {
            $time_format = CalendarOptions::CALENDAR_UI_DEFAULT_TIME_FORMAT; 
        }
        
        return $time_format;
    }     
    
    /**
     * Get active date/time format, according settings
     * 
     * @return type
     */
    Public Static function getDateTimeFormat() {
        $date_format = CalendarOptions::getDefaultDateFormat();
        
        if ($date_format === 'r') {
            // if date format is is full format (Thu, 21 Dec 2000 16:01:07 +0200), we don't have to check the time format
            return $date_format;
        }
        
        $time_format = CalendarOptions::getDefaultTimeFormat();
        
        return "{$date_format} {$time_format}";
    }        
}
