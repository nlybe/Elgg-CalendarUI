# Elgg Calendar UI

![Elgg 2.1](https://img.shields.io/badge/Elgg-2.1-orange.svg?style=flat-square)

Elgg calendar UI integrating the JS library [FullCalendar.io](https://fullcalendar.io/).

If [events_api](https://github.com/arckinteractive/events_api) plugin is enabled, community members can manage their own calendar and events.

## Features

### Use as Events Plugin UI
The [events_api](https://github.com/arckinteractive/events_api) plugin is suggested, so the following options are available:
#### For community users
- Both site and users calendar are available
- Users can submit events directly from calendar
- Option for time zone dependant events
- Option to set an event as "background event" for other users 
- Option to set business hours of calendar 

#### For site administrators
- Enable option for users to select the own timezone 
- Set default localization
- Enable option for users to select the own localization
- Set default date/time format
- Allow or not overlapping events
- Option to enable or disable calendar for site
- Option to enable or disable calendar for users, taking in consideration profile types if [profile_manager](https://github.com/ColdTrick/profile_manager) plugin is enabled

### Use as Calendar UI API 
Calendar UI can be used as API for visualizing any date/time related entities. The following options are available:
- Elgg view for visualizing on calendar any date/time related entities
- Form input for timezone
- Form input for locale

## Future Tasks List
- [ ] Add option for submitting repeated events
- [ ] Add output view for timezone and locate
- [ ] Display localization language names on selection list (now localization id is displayed)
- [ ] Add calendar support for groups
- [ ] On event view display date according locale selected
- [ ] If other calendar locale selected than 'en', the submission is not working directly from calendar.
- [ ] Add widgets
- [ ] Add option for users to create/edit more personal calendars (as offered this option from events_api)
- [ ] Add guidelines about how to use as as Calendar UI API 
