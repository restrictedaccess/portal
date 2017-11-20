{*
    2009-08-17 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
        Added time stamp
*}
<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <time_record_notes>
        {foreach from=$time_record_notes_final key=k item=time_record_note}
            <time_record_note
                name="{$time_record_note.name}"
                note="{$time_record_note.note|escape}" 
                time_stamp="{$time_record_note.time_stamp|escape}" 
                />
        {/foreach}
    </time_record_notes>
</response>
