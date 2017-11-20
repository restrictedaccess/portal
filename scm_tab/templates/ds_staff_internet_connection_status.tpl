<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <internet_connection_status total_timediff="{$total_timediff}">
        {section name=j loop=$internet_connection_log}
            <internet_connection_log id="{$internet_connection_log[j].id}" 
                    lname="{$internet_connection_log[j].lname}"
                    fname="{$internet_connection_log[j].fname}"
                    company_name="{$internet_connection_log[j].company_name}"
                    last_seen="{$internet_connection_log[j].last_seen}"
                    reported_time="{$internet_connection_log[j].reported_time}"
                    timediff="{$internet_connection_log[j].timediff}"
                />
        {/section}
    </internet_connection_status>
</response>
