<img alt="upArrow" style="position: relative;  left: 30px;" src="./autosuggest/arrow.png">
<div style="background:#000000; color:#FFFFFF; padding:5px;">
{section name=j loop=$job_positions}
<div><input type="checkbox" name="category_ids" value="{$job_positions[j].category_id}" onclick="check_position()" /> {$job_positions[j].category_name}</div>
{/section}
<input type="hidden" id="category_ids" />
<input type="button"  value="Add" onclick="AddPosition()" />
</div>