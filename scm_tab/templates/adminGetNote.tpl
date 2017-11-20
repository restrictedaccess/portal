{strip}
<div class='time_record_notes {cycle values="bg_color_note_1, bg_color_note_2"}'>
{section name=j loop=$time_record_notes}
    <div class="time_record_left_floater">
        <div class="time_record_notes_name">{$time_record_notes[j].first_name|escape} :</div>
        <div class="time_record_notes_note">{$time_record_notes[j].note|escape}</div>
    </div>
    <div class="clear"></div>
{/section}
</div>
<div class="clear"></div>
{/strip}
