<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <null_timeout_records>
        {foreach from=$null_timeout_records key=k item=time_record}
            <time_record
                timerecord_id="{$time_record.id}"
                userid="{$time_record.userid}" 
                time_in="{$time_record.time_in}"
                mode="{$time_record.mode}"
                />
        {/foreach}
    </null_timeout_records>
</response>
