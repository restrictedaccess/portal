<div id="leave_request_form" style=" display:block; position:absolute; background:#FFFFFF;  width:500px;">

<div style="background:#0000FF; text-align:right; vertical-align:top;"><a href="javascript:toggle('leave_request_form')" style="color:#FFFFFF; font-weight:bold;">[ X ]</a></div>
<table width="100%" bgcolor="#CCCCCC" cellpadding="2" cellspacing="1">

<tr bgcolor="#FFFFFF">
<td width="37%">Requesting to Client</td>
<td width="63%">
<select name="leads_id" id="leads_id"  style="width:250px;">
{$leads_Options}
</select>
</td>
</tr>


<tr bgcolor="#FFFFFF">
<td width="37%">Full Name</td>
<td width="63%">{$staff.fname} {$staff.lname}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Email</td>
<td>{$staff.email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Leave Type</td>
<td><select name="leave_type" id="leave_type"  style="width:150px;">
					{$leave_type_Options}
					</select> (<small>without pay</small>)</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Date of Leave or Absence</td>
<td><input type="text" readonly name="date_of_leave" style="width:150px;"  id="date_of_leave" value="{$date_of_leave}"></td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top">Reason for Leave</td>
<td valign="top"><textarea name="reason_for_leave" rows="7" style="width:90%;" id="reason_for_leave">{$reason_for_leave}</textarea></td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top" colspan="2"><input type="submit" name="save" value="Submit" /> <input type="button"  onclick="toggle('leave_request_form')" value="Close" /></td>
</tr>


</table>
</div>