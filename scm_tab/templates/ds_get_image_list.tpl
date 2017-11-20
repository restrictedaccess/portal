<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <screenshots>
        {foreach from=$screenshots key=hour item=screenshot}
            <screenshot text="{$screenshot.post_time|date_format:"%H:%M"}" 
                value="{$screenshot.post_time|date_format:"%Y-%m-%d"}/{$userid}/{$screenshot.post_time|date_format:"%H-%M-%S"}.jpg"
                activity_note="{$screenshot.activity_note|escape}"
                />
        {/foreach}
    </screenshots>
    <quick_breaks>
        {foreach from=$breaks key=k item=break}
            <quick_break start="{$break.start|date_format:"%H:%M"}" end="{$break.end|date_format:"%H:%M"}" diff="{$break.diff|date_format:"%H:%M"}"/>
        {/foreach}
    </quick_breaks>
    <lunch_breaks>
        {foreach from=$lunch_breaks key=k item=break}
            <lunch_break start="{$break.time_in|date_format:"%H:%M"}" end="{$break.time_out|date_format:"%H:%M"}" diff="{$break.diff|date_format:"%H:%M"}"/>
        {/foreach}
    </lunch_breaks>
    <time_records>
        {foreach from=$time_records key=k item=time_record}
            <time_record start="{$time_record.time_in|date_format:"%H:%M"}" end="{$time_record.time_out|date_format:"%H:%M"}" diff="{$time_record.diff}"/>
        {/foreach}
    </time_records>
</response>
