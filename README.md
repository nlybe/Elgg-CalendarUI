# Elgg Calendar UI

![Elgg 2.2](https://img.shields.io/badge/Elgg-2.2-orange.svg?style=flat-square)

Elgg calendar UI integrating the JS library [FullCalendar.io](https://fullcalendar.io/).

If [events_api](https://github.com/arckinteractive/events_api) plugin is enabled, community members can manage their own calendar and events.

## Features

### Use as Events Plugin UI
The [events_api](https://github.com/arckinteractive/events_api) plugin is suggested, so the following options are available:
#### For community users
- Both site and users calendar
- Users can submit events directly from calendar

#### For site administrator
- Enable option for users to select the own timezone 
- Set default localization
- Enable option for users to select the own localization
- Set default date/time format
- Allow or not overlapping events

### Use as Calendar UI API 
Calendar UI can be used as API for visualizing on calendar any date/time related entities. The following options are available:
- Timezone input
- Locale input

#### List of future improvements/issues fixes
- [ ] add output for timezone and locate
- [ ] display localization language names on selection list (now localization id is displayed)
- [ ] add option for submitting repeated events
- [ ] add calendar support for groups
- [ ] option to add multi-day events from calendar
- [ ] on event view display date according locale selected
- [ ] if other calendar locale selected than 'en', the submission is not working directly from calendar. Also events are not displayed in other locale
