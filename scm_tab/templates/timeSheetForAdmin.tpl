{if $show_month_list}
<div id="time_sheet">
    <div id="available_months">Select Month : 
        <select id="month_list">
            {section name=j loop=$month_options}
            <option value="{$month_options[j].date}">{$month_options[j].desc}</option>
            {/section}
        </select>
    </div>
    <div id="dtr_time_sheet">
{/if}
        <div id="time_sheet_headers">
            <div class="time_sheet_headers">
                <div class="dtr_col_day_of_week">Day of Week</div>
                <div class="dtr_col_time">Time In</div>
                <div class="dtr_col_time">Time Out</div>
                <div class="dtr_col_client">Client</div>
                <div class="dtr_col_total_hours_header">Total Hrs</div>
                <div class="dtr_col_total_hours_header">Lunch Hrs</div>
                <div class="dtr_col_time">Start Lunch</div>
                <div class="dtr_col_time">Fin Lunch</div>
                <div class="dtr_col_regular_hours_header">Regular Hrs</div>
                <div class="dtr_col_notes">Notes</div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            {section name=j loop=$time_records}
            {strip}
                <div class="dtr_rows {if $time_records[j].day_of|truncate:3:"" == 'Sat' || $time_records[j].day_of|truncate:3:"" == 'Sun' }
                        bg_color_weekends
                    {else}
                        {cycle values="bg_color_row_1, bg_color_row_2"}
                    {/if} 
                ">

                   <div class="dtr_col_day_of_week">{$time_records[j].day_of}</div>
                    <div class="dtr_col_time">
                        <div class="dtr_col_time_ph">{$time_records[j].time_in_ph}</div>
                        <div class="dtr_col_time_au">{$time_records[j].time_in_au}</div>
                    </div>
                    <div class="dtr_col_time">
                        <div class="dtr_col_time_ph">{$time_records[j].time_out_ph}</div>
                        <div class="dtr_col_time_au">{$time_records[j].time_out_au}</div>
                    </div>
                    <div class="dtr_col_client" title="{$time_records[j].client|escape}">{$time_records[j].client|escape}</div>
                    <div class="dtr_col_total_hours">{$time_records[j].total_hours|number_format:2:".":","}</div>
                    <div class="dtr_col_total_hours">{$time_records[j].total_lunch_hours|number_format:2:".":","}</div>
                    <div class="dtr_col_time">
                        <div class="dtr_col_time_ph">{$time_records[j].start_lunch_ph}</div>
                        <div class="dtr_col_time_au">{$time_records[j].start_lunch_au}</div>
                    </div>
                    <div class="dtr_col_time">
                        <div class="dtr_col_time_ph">{$time_records[j].finish_lunch_ph}</div>
                        <div class="dtr_col_time_au">{$time_records[j].finish_lunch_au}</div>
                    </div>
                    <div class="dtr_col_regular_hours">{$time_records[j].working_hours|number_format:2:".":","}</div>
                    <div class="dtr_notes">
                        <button blank="{$time_records[j].blank}" date="{$time_records[j].date}" record_id="{$time_records[j].record_id}" day_of="{$time_records[j].notes_day_of_week}" class="button_add_notes">Add</button>
                        <span blank="{$time_records[j].blank}" record_id="{$time_records[j].record_id}" day_of="{$time_records[j].day_of_notes}" class="span_add_notes" id="span_add_notes_{$time_records[j].record_id}">{$time_records[j].timerecord_notes|escape}</span>
                    </div>

                    <div class="clear"></div>
                </div>

            <div class="invisible div_notes" id="notes_{$time_records[j].record_id}">Loading....</div>
            <div class="clear"></div>

            {/strip}
            {/section}
        </div>
{if $show_month_list}
    </div>
</div>
{/if}
