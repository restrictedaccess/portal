<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <months>
        {foreach from=$available_months key=k item=month}
            <month desc="{$month}" value="{$k}"/>
        {/foreach}
    </months>
</response>
