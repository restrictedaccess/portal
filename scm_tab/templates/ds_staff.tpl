<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <admin_status>{$admin_status}</admin_status>
    <staffs>
        {section name=j loop=$staff}
            <staff userid="{$staff[j].userid}" 
                    lname="{$staff[j].lname|escape}"
                    fname="{$staff[j].fname|escape}"
                    email="{$staff[j].email|escape}"
                    skype_id="{$staff[j].skype_id|escape}"
                    image="{$staff[j].image}"
                    last_snapshot_date="{$staff[j].last_snapshot_time|date_format:"%Y-%m-%d"}"
                    last_snapshot_time="{$staff[j].last_snapshot_time|date_format:"%r"}"
                    last_machine_reported_date="{$staff[j].last_machine_reported_time|date_format:"%Y-%m-%d"}"
                    last_machine_reported_time="{$staff[j].last_machine_reported_time|date_format:"%r"}"
                    last_activity_note_date="{$staff[j].last_activity_note_time|date_format:"%Y-%m-%d"}"
                    last_activity_note_time="{$staff[j].last_activity_note_time|date_format:"%r"}"
                    subcontractors_id="{$staff[j].subcontractors_id}"
                    leads_id="{$staff[j].leads_id}"
                    leads_name="{$staff[j].leads_name|escape}"
                    status="{$staff[j].status}"
                />
        {/section}
    </staffs>
</response>
