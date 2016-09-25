define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    require('jquery-ui');
    require('cui_fullcalendar_js');
    require('cui_locale_all');
      
    // get plugin settings
    var cui_settings = require("calendar_ui/settings");
    
    $(document).ready(function() {
        // build the locale selector's options
        $.each($.fullCalendar.locales, function(localeCode) {
            $('#locale-selector').append(
                $('<option/>')
                .attr('value', localeCode)
                .prop('selected', localeCode === cui_settings['default_locale'])
                .text(localeCode)
            );
        });        
        
    });
    
});
