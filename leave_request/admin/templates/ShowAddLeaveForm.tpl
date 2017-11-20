<table id="leave_request_form" width="100%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" style="margin-left:20px;" >

<tr bgcolor="#FFFFFF">
<td width="33%" valign="top">Client(s)</td>
<td width="67%" valign="top">
<ol>
{foreach from=$leads item=lead name=lead}
	<li><input type='checkbox' checked='checked' name='lead' value={$lead.leads_id} /> {$lead.fname} {$lead.lname}</li>
{/foreach}
</ol>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Leave Type</td>
<td><select name="leave_type" id="leave_type"  style="width:150px;">
{foreach from=$leave_type_array item=l name=l}
	<option value="{$l}">{$l}</option>
{/foreach}
</select> <small style="color:#999999;">without pay</small></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Date of Leave or Absence</td>
<td>

From : <input type="text" readonly name="start_date_of_leave" style="width:85px; cursor:pointer;"  id="start_date_of_leave" value="{$date_of_leave}" onChange="CheckInputDate('start_date_of_leave')"> <img align="absmiddle" src="/portal/images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector"  /> To : <input type="text" readonly name="end_date_of_leave" style="width:85px; cursor:pointer;"  id="end_date_of_leave" value="{$date_of_leave}" > <img align="absmiddle" src="/portal/images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector"  />
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Leave Duration</td>
<td><select name="leave_duration" id="leave_duration"  style="width:150px;">
{foreach from=$duration_array item=l name=l}
	<option value="{$l}">{$l}</option>
{/foreach}
</select></td>
</tr>


<tr bgcolor="#FFFFFF">
<td valign="top">Reason for Leave</td>
<td valign="top"><textarea name="reason_for_leave" rows="7" style="width:90%;" id="reason_for_leave"></textarea></td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top" colspan="2">
<button id="add_leave_btn" class="btn btn-primary">Submit</button> <button id="cancel_btn" class="btn btn-default">Cancel</button>
</td>
</tr>



</table>
