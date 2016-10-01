define(function(require) {
    var options = new Object();
    options.dateOptions = {
        timepicker:false,
        format:'d-m-Y',
        todayButton:false,
        yearStart:new Date().getFullYear(),
        yearEnd:(new Date().getFullYear() + 2),
        lazyInit:true, // alliws sthn prwth emfnaish deixnei lathos hmerominia
    };
    options.dateTimeOptions = {
        timepicker:true,
        format:'d-m-Y H:i',
        todayButton:false,
        step:30,
        defaultTime:'16:00',
        minTime: '07:00',
        maxTime: '23:55',
        yearStart:new Date().getFullYear(),
        yearEnd:(new Date().getFullYear() + 2),
        lazyInit:true,
    };
    options.timeOptions = {
        datepicker:false,
        timepicker:true,
        format:'G:i',
        todayButton:false,
        lazyInit:true, // alliws sthn prwth emfnaish deixnei lathos hmerominia
        //lang:'el'
    };    
    return options;
});