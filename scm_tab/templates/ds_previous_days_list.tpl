<?xml version="1.0" encoding="ISO-8859-1"?>
<response>
    <status>{$status|escape}</status>
    <message>{$message|escape}</message>
    <days>
        {section name=j loop=$days}
            <day desc="{$days[j][0]}" 
                    date="{$days[j][1]}"
                />
        {/section}
    </days>
</response>
