<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <ActivityTrackerNotes total_time_delay="{$total_time_delay}">
        {section name=j loop=$activity_tracker_notes}
            <Note id="{$activity_tracker_notes[j].id}" 
                    lname="{$activity_tracker_notes[j].lname}"
                    fname="{$activity_tracker_notes[j].fname}"
                    company_name="{$activity_tracker_notes[j].company_name}"
                    expected_time="{$activity_tracker_notes[j].expected_time}"
                    checked_in_time="{$activity_tracker_notes[j].checked_in_time}"
                    delay="{$activity_tracker_notes[j].delay}"
            >{strip}
                <![CDATA[
                    {$activity_tracker_notes[j].note}
                ]]>{/strip}
            </Note>
        {/section}
    </ActivityTrackerNotes>
</response>
