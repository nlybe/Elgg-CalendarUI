<?php
/**
 * Elgg Calendar UI plugin
 * @package calendar_ui
 */

namespace Events\API;
use Events\API\Util;

$user = elgg_extract('user', $vars, '');
$calendar = elgg_extract('calendar', $vars, '');
$business_hours = elgg_extract('business_hours', $vars, '');
$business_hours = json_decode($business_hours, true);

 elgg_view('input/button', array(
    'value' => elgg_echo('calendar_ui:calendar:business_hours:add_more'),
    'class' => 'elgg-button elgg-button-action add_field_button',
    'id' => 'add_more',
)).' '.elgg_view_icon('plus');

echo elgg_format_element('button', [
        'class'=>'elgg-button elgg-button-action add_field_button',
        'id' => 'add_more',
    ], 
    elgg_echo('calendar_ui:calendar:business_hours:add_more', array(elgg_view_icon('plus')))
);

// keys for days have been assigned according fullcalendar
$days = array(
    0 => elgg_echo('events:wd:'.Util::SUNDAY),
    1 => elgg_echo('events:wd:'.Util::MONDAY),
    2 => elgg_echo('events:wd:'.Util::TUESDAY),
    3 => elgg_echo('events:wd:'.Util::WEDNESDAY),
    4 => elgg_echo('events:wd:'.Util::THURSDAY),
    5 => elgg_echo('events:wd:'.Util::FRIDAY),
    6 => elgg_echo('events:wd:'.Util::SATURDAY),
);

$time = array();
for ($i=0; $i<=23; $i++) {
    $tmp = ($i<10?'0'.$i:$i);
    $time[$tmp.':00'] = $tmp.':00';
    $time[$tmp.':30'] = $tmp.':30';
}

// build a table cell for remove button
$remove_btn = elgg_format_element('a', ['href' => '#', 'class' => 'remove_field', 'title' => elgg_echo('calendar_ui:calendar:business_hours:remove_line')], elgg_view_icon('times'));
$remove_btn = elgg_format_element('div', ['class'=>'divTableCell'], $remove_btn);

$existed_entries = '';
if ($business_hours) {
    foreach ($business_hours as $k => $v) {
        //echo $v['dow'].' - '.$v['start'].' - '.$v['end'].'<br />' ;

        $line_entry = elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
            'name' => 'days[]',
            'options_values' => $days,
            'value' => $v['dow'],
        ))); 

        $line_entry .= elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
            'name' => 'time_from[]',
            'options_values' => $time,
            'value' => $v['start'],
        ))); 

        $line_entry .= elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
            'name' => 'time_to[]',
            'options_values' => $time,
            'value' => $v['end'],
        )));  

        $line_entry .= $remove_btn;
        $existed_entries .= elgg_format_element('div', ['class'=>'divTableRow'], $line_entry); 
    }
}

$new_entry = elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
    'name' => 'days[]',
    'options_values' => $days,
    'value' => '',
))); 

$new_entry .= elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
    'name' => 'time_from[]',
    'options_values' => $time,
    'value' => '',
))); 

$new_entry .= elgg_format_element('div', ['class'=>'divTableCell'], elgg_view_input('dropdown', array(
    'name' => 'time_to[]',
    'options_values' => $time,
    'value' => '',
)));

$new_entry .= $remove_btn;

$new_entry = elgg_format_element('div', ['class'=>'divTableRow'], $new_entry); 
        
?>

<div class="divTable">
    <div class="divTableHeading">
        <div class="divTableRow">
            <div class="divTableHead"><?php echo elgg_echo('calendar_ui:calendar:business_hours:day') ?></div>
            <div class="divTableHead"><?php echo elgg_echo('calendar_ui:calendar:business_hours:start') ?></div>
            <div class="divTableHead"><?php echo elgg_echo('calendar_ui:calendar:business_hours:end') ?></div>
            <div class="divTableHead">&nbsp;</div>
        </div>
    </div>
    <div class="divTableBody">
        <?php 
            if ($existed_entries)
                echo $existed_entries; 
            else
                echo $new_entry; 
        ?>
    </div>
</div>

<?php
$footer .= elgg_view_input('hidden', array(
    'id' => 'calendar_guid',
    'name' => 'calendar_guid',
    'value' => $calendar->getGUID(),
));
$footer .= elgg_view_input('submit', array('style' => 'float: right;', 'value' => elgg_echo('save')));
echo elgg_format_element('div', ['class'=>'elgg-foot'], $footer);
?>

<script language="javascript">
    $(document).ready(function() {
        var max_fields      = 20; //maximum input boxes allowed
        var wrapper         = $(".divTableBody"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                var last_line = $(".divTableRow:last").clone();
console.log(last_line);                
                x++; //text box increment
                //$(wrapper).append('<?php echo $new_entry; ?>'); // OBS
                $(wrapper).append(last_line); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
        })
    });    
</script>    

