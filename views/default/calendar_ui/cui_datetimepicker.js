define(function(require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    require('jquery-mousewheel');
    require('cui_datetimepicker_js');
    
    $(document).ready(function() {

        $.datetimepicker.setLocale('en');

        $('#start_datetime').datetimepicker({
            dayOfWeekStart : 1,
            lang: 'en',
            step:30,
            onChangeDateTime:function(){
                var str = $('#start_datetime').val();
                var res = str.split(" "); 
                $('#start_date').val(res[0]);
                $('#start_time').val(formatDate($('#start_datetime').val()));
                //console.log(formatDate($('#start_datetime').val()));
            }
        });

        $('#end_datetime').datetimepicker({
            dayOfWeekStart : 1,
            lang: 'en',
            step:30,
            onChangeDateTime:function(){
                var str = $('#end_datetime').val();
                var res = str.split(" "); 
                $('#end_date').val(res[0]);
                $('#end_time').val(formatDate($('#end_datetime').val()));
            }
        });
      
    });
    
    // get time on 13:15am format for a given date
    function formatDate(date) {
        var d = new Date(date);
        var hh = d.getHours();
        var m = d.getMinutes();
        //var s = d.getSeconds();
        var dd = "am";
        var h = hh;
        if (h >= 12) {
            h = hh-12;
            dd = "pm";
        }
        if (h == 0) {
            h = 12;
        }
        m = m<10?"0"+m:m;
        //s = s<10?"0"+s:s;

        /* if you want 2 digit hours:
        h = h<10?"0"+h:h; */

        var replacement = h+":"+m;
        /* if want to add seconds
        replacement += ":"+s;  */
        replacement += dd;    

        //return date.replace(pattern,replacement);
        return replacement;
    }    
});