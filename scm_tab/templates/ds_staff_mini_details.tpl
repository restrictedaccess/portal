<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <staff userid="{$staff.userid}" 
            lname="{$staff.lname}"
            fname="{$staff.fname}"
            email="{$staff.email}"
            skype_id="{$staff.skype_id}"
            image="{$staff.image}"
            last_snapshot_date="{$staff.last_snapshot_time|date_format:"%Y-%m-%d"}"
            last_snapshot_time="{$staff.last_snapshot_time|date_format:"%r"}"
            last_machine_reported_date="{$staff.last_machine_reported_time|date_format:"%Y-%m-%d"}"
            last_machine_reported_time="{$staff.last_machine_reported_time|date_format:"%r"}"
            last_activity_note_date="{$staff.last_activity_note_time|date_format:"%Y-%m-%d"}"
            last_activity_note_time="{$staff.last_activity_note_time|date_format:"%r"}"
            subcontractors_id="{$staff.subcontractors_id}"
            leads_id="{$staff.leads_id}"
            leads_name="{$staff.leads_name}"
            status="{$staff.status}"
        />
</response>
