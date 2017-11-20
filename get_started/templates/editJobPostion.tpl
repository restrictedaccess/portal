<div id="editJobPositionForm2" >
<div align="right"><a href="javascript:toggle('div_edit_job_position_form2')" style="text-decoration:none;">[ x ]</a></div>
<input type="hidden" id="jr_currency" value="{$currency}" />
<input type="hidden" id="gs_job_titles_details_id" value="{$gs_job_titles_details_id}" />
<input type="hidden" id="gs_job_role_selection_id" name="gs_job_role_selection_id" value="{$result.gs_job_role_selection_id}" />
<input type="hidden" id="jr_list_id" name="jr_list_id" value="{$result.jr_list_id}" />
<input type="hidden" id="jr_cat_id" name="jr_cat_id" value="{$result.jr_cat_id}"  />

<div id="update_result">
<table width="500" height="340" align="center" cellpadding="5" cellspacing="1" bgcolor="gray">

<tr bgcolor="#FFFFFF">
<td>Job Position</td>
<td><select id="selected_job_title" disabled="disabled" onchange="showAmount2();">{$jobPositionOptions}</select>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Qty.</td>
<td><input type="text" id="no_of_staff_needed" value="{$no_of_staff_needed}" size="5" maxlength="3"  />
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Level</td>
<td><select id="level" onchange="showAmount2();">{$level_Options}</select>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Working Status</td>
<td><select id="work_status1" onchange="showAmount2();">{$work_status_Options}</select>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Amount</td>
<td><div id="amount_str">{$amount_str}<input type="hidden" id="jr_list_id" value="{$jr_list_id}" /><input type="hidden" id="jr_cat_id" value="{$jr_cat_id}" /></div></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Working Timezone</td>
<td><select id="working_timezone">{$timezones_Options}</select>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Working Start Time</td>
<td><select name="client_start_work_hour1" id="client_start_work_hour1" onchange="configureTimeSettings(1 , 'plus')"  >{$start_hours_Options}</select>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Working Finish Time</td>
<td><select name="client_finish_work_hour1" id="client_finish_work_hour1" onchange="configureTimeSettings(1 , 'minus')"  >{$finish_hours_Options}</select>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td colspan="2">
<input type="button"  value="Update List" class="button" onclick="updateOrderListPortal()" />
<input type="button" value="Cancel" onclick="javascript:toggle('div_edit_job_position_form2')" class="button"/></td>
</tr>


</table>
</div>

</div>
