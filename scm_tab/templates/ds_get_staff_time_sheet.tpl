{*
2009-09-02 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   filtered carriage return/line feeds
2009-08-11 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   Add status for admin who could force a logout
*}
<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <admin_status adjust_time_sheet="{$adjust_time_sheet}" force_logout="{$force_logout}"/>
    <time_records>
        {foreach from=$time_records_final key=k item=time_record}
            <time_record 
                record_id="{$time_record.id}"
                day_of_week="{$time_record.day_of_week|date_format:"%a %d/%y"}" 
                day="{$time_record.day_of_week|date_format:"%a"}" 
                of_week="{$time_record.day_of_week|date_format:"%d"}" 
                date="{$time_record.day_of_week|date_format:"%Y-%m-%d"}" 
                {if (($time_record.day_of_week|date_format:"%a" eq "Sat") or ($time_record.day_of_week|date_format:"%a" eq "Sun"))}
                    bullet_color="#8D8D8D"
                {/if}
                start="{$time_record.time_in|date_format:"%H:%M"}" 
                end="{$time_record.time_out|date_format:"%H:%M"}" 
                client="{$time_record.fname|escape} {$time_record.lname|escape} - {$time_record.company_name|escape}"
                total_lunch_hrs="{$time_record.total_lunch_hrs}"
                computed_total_hrs="{$time_record.computed_total_hrs}"
                adjusted_total_hrs="{$time_record.adjusted_total_hrs}"
                start_lunch="{$time_record.time_in_lunch|date_format:"%H:%M"}" 
                end_lunch="{$time_record.time_out_lunch|date_format:"%H:%M"}" 
                regular_hrs="{$time_record.regular_hrs}" 
                notes="{$time_record.notes|escape|replace:"\n":" "|replace:"\r":" "}" 
                />
        {/foreach}
    </time_records>
</response>
