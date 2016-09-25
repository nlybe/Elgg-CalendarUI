define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    require('jquery-ui');
    require('cui_fullcalendar_js');
    require('cui_locale_all');
       
    // get plugin settings
    var cui_settings = require("calendar_ui/settings");
    var locale = cui_settings['user_locale'];
  
    $(document).ready(function() {
        var c_action = $('#c_action').html();
        var c_subtype = $('#c_subtype').html();
        var c_limit = $('#c_limit').html();
        var c_calendar_guid = $('#c_calendar_guid').html();
        var c_owner_guid = $('#c_owner_guid').html();
        var events_api_exists = $('#events_api_exists').html();
        var timezone = cui_settings['active_timezone'];
        
        var selectable = false;
        if (elgg.get_page_owner_guid() == elgg.get_logged_in_user_guid() || elgg.is_admin_logged_in()) {
            selectable = true;
        }  

        $('#calendar').fullCalendar({
            //theme: true,
            timezone: timezone,
            locale: locale,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultView: 'agendaWeek',
            navLinks: true, // can click day/week names to navigate views
            selectable: selectable,
            selectConstraint: 'businessHours',
            eventConstraint: 'businessHours',
            selectHelper: true,
            select: function(start, end) {
                if (events_api_exists==1) { // only if events_api plugin is enabled
                    if (elgg.is_logged_in() && selectable) {
                        if (!isRenderedEvent(start,end)) {  // check if selected dates overlap with existed events    
                            // set values on form according date/time selected
                            $('#start_date').val(start.format('YYYY-MM-DD'));
                            $('#start_time').val(start.format('h:mma'));
                            $('#end_date').val(end.format('YYYY-MM-DD'));
                            $('#end_time').val(end.format('h:mma'));

                            var dialog = $( "#dialog-form" ).dialog({
                                autoOpen: false,
                                height: 500,
                                width: 600,
                                modal: true,
                                buttons: {
                                    Cancel: function() {
                                        dialog.dialog( "close" );
                                    },
                                    "Create event": createEvent
                                },
                                close: function() {
                                    // initialize form
                                    $('#title').val("");
                                    $('#location').val("");
                                    $('#description').val("");
                                    $('#all_day').attr('checked', false);
                                    $('#no_details').attr('checked', false);
                                }
                            });
                            dialog.dialog( "open" );

                            function createEvent() {
                                var eventData;
                                var title = $( "#title" ).val();
                                if (title) {
                                    var all_day = 0;
                                    if ($('#all_day').is(":checked"))
                                        all_day = 1;

                                    var no_details = 0;
                                    if ($('#no_details').is(":checked"))
                                        no_details = 1;                                

                                    elgg.action('calendar_ui/add_event', {
                                        data: {
                                            title: $('#title').val(),
                                            start_date: $('#start_date').val(),
                                            start_time: $('#start_time').val(),
                                            end_date: $('#end_date').val(),
                                            end_time: $('#end_time').val(),
                                            all_day: all_day,
                                            no_details: no_details,
                                            location: $('#location').val(),
                                            timezone: $('#timezone option:selected').val(),    //dropdown list
                                            description: $('#description').val(),
                                            comments_on: $('#comments_on').val(),
                                            access_id: $('#access_id').val(),
                                            container_guid: $('#container_guid').val(),
                                            calendar: $('#calendar_guid').val(),
                                            owner_guid: $('#owner_guid').val()
                                        },
                                        success: function(result) {
                                            if (result.error) {
                                                elgg.register_error(result.error_message);
                                            } 
                                            else {
                                                elgg.system_message(elgg.echo('calendar_ui:form:event:success'));

                                                // finally add it to the calendar
                                                eventData = {
                                                    guid: result.guid,
                                                    title: title,
                                                    start: result.start_timestamp_iso,
                                                    end: result.end_timestamp_iso,
                                                    durationEditable: false,
                                                    url: elgg.normalize_url(),
                                                    overlap: false,
                                                    allDay: result.all_day==1?1:0
                                                };
                                                $('#calendar').fullCalendar('renderEvent', eventData, true);                                  
                                            }
                                        },
                                        error: function() {
                                            elgg.register_error(elgg.echo('calendar_ui:form:event:failed'));
                                        }
                                    });                                
                                }
                                else {
                                    elgg.register_error(elgg.echo('calendar_ui:form:event:title_empty'));
                                }
                                $('#calendar').fullCalendar('unselect');
                                dialog.dialog( "close" );
                            }                        
                        }
                        else {
                            elgg.register_error(elgg.echo('calendar_ui:events:overlapping:error'));
                        }                        
                    }
                }
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            eventOverlap: false,
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [ 0, 1, 2, 3, 4, 5, 6 ], // Monday - Thursday
                start: '06:00', 
                end: '24:00' 
                // set multiple business hours --> http://stackoverflow.com/questions/30977505/how-to-add-multiple-business-hours-in-fullcalendar
            },            
            events: function(start, end, timezone, callback) {
                // Calculate dates to search according calendar view. Default is 3 months
                var date = $('#calendar').fullCalendar('getDate')._d;
                var firstDay = new Date(date.getFullYear(), date.getMonth() -1 , 1);
                var lastDay = new Date(date.getFullYear(), date.getMonth() + 2, 0);

                if (c_action) {
                    elgg.action(c_action, {
                        data: {
                            c_subtype: c_subtype,
                            c_limit: c_limit,
                            c_container_guid: c_calendar_guid,
                            c_owner_guid: c_owner_guid,
                            c_start_dt: firstDay,
                            c_end_dt: lastDay,
                            timezone: timezone,
                        },
                        success: function(result) {
                            var events = [];
                            var result_x = result.event_objects;
                            $.each($.parseJSON(result_x), function (item, value) {
                                
                                // if no_tails is true, do not show to other users
                                var no_details_r = '';  // temporarily set background
                                if (value.no_details==1 && !selectable) {
                                    no_details_r = 'background';
                                }

                                events.push({
                                    guid: value.guid,
                                    title: value.title,
                                    start: value.start_timestamp_iso,
                                    end: value.end_timestamp_iso,
                                    //color: '#ff9f89',
                                    editable: false,
                                    url: elgg.normalize_url(),
                                    e_start: value.start_date,
                                    allDay: value.all_day==1?1:0,
                                    rendering: no_details_r
                                });
                            }); 
                            callback(events);
                        }
                    });
                }
            },
            eventClick: function(event) {
                console.log('11');
                if (events_api_exists==1) { // only if events_api plugin is enabled
                    if (event.url) {
                        var lightbox = require('elgg/lightbox');
                        lightbox.open({
                           html: '<div id="event_view"></div>',
                           onClosed: function() {}
                        });
                        lightbox.resize({
                            width: '600px',
                            height: '400px'
                        });

                        // load event view 
                        elgg.action('calendar_ui/view_event', {
                             data: {
                                 guid: event.guid
                             },
                             success: function(result) {
                                 var content_x = result.content;
                                 $('#event_view').html(content_x);
                             }
                        });
                        return false;
                    }
                }
            },
            eventRender: function(event, el) {
                // render the timezone offset below the event title
                if (event.start.hasZone()) {
                    el.find('.fc-title').after(
                        $('<div class="tzo"/>').text(event.start.format('Z'))
                    );
                }
            }
        });
        
        $(".fc-today-button").click(function() {
            $("calendar").fullCalendar({
                eventAfterAllRender: function(){
                    $("#button").click();
                }
            });
        });  
        
        /**
         * Detects if selected dates overlap with existed events
         * 
         * @param {type} start
         * @param {type} end
         * @returns {Boolean}
         */
        var isRenderedEvent = function(start,end){
            console.log(cui_settings['allow_overlap']);
            return $("#calendar").fullCalendar('clientEvents', function (event) {
                //return (event.rendering === "background" && //Add more conditions here if you only want to check against certain events
                return (!cui_settings['allow_overlap'] && //Add more conditions here if you only want to check against certain events
                    (
                        ((start.isAfter(event.start) || start.isSame(event.start,'minute')) && start.isBefore(event.end)) ||
                        (end.isAfter(event.start) && (end.isBefore(event.end) || end.isSame(event.end,'minute'))) ||
                        (start.isBefore(event.start) && end.isAfter(event.end)) ||
                        (event.allDay === 1 && (start.day() === event.start.day()) && (start.month() === event.start.month()) && (start.year() === event.start.year())) ||
                        (event.allDay === 1 && (end.day() === event.start.day()) && (end.month() === event.start.month()) && (end.year() === event.start.year()))
                    )
                );
            }).length > 0;
        }; 
        
    });
    
});
