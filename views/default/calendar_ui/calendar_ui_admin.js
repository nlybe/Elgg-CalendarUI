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

        // initialize profile types box
        toggleRrofileTypes();
        
        $('#enable_user_calendar').change(function() {
            toggleRrofileTypes();      
        });        
    });
    
    function toggleRrofileTypes() {
        if($("#enable_user_calendar").is(':checked')) {
            $( ".cui_profile_types_list input" ).prop( "disabled", false );
            $('.cui_profile_types_list fieldset').css('background','#fff')
        }
        else {
            $( ".cui_profile_types_list input" ).prop( "disabled", true );
            $('.cui_profile_types_list fieldset').css('background','#eaeaea')
        }        
    }
    
});
