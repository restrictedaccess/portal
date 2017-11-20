<table id="leave_request_form" width="60%" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" style="margin-left:20px;" >

<tr bgcolor="#FFFFFF">
<td width="33%" valign="top">Client(s)</td>
<td width="67%" valign="top">{$leads_options}</td>
</tr>


<tr bgcolor="#FFFFFF">
<td>Leave Type</td>
<td><select name="leave_type" id="leave_type"  style="width:150px;">
{$leave_type_Options}
</select> </td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Date of Leave or Absence</td>
<td>

From : <input type="text" readonly name="start_date_of_leave" style="width:70px; cursor:pointer;"  id="start_date_of_leave" value="{$date_of_leave}" onChange="CheckInputDate('start_date_of_leave')"> <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector"  /> To : <input type="text" readonly name="end_date_of_leave" style="width:70px; cursor:pointer;"  id="end_date_of_leave" value="{$date_of_leave}" onChange="CheckInputDate('end_date_of_leave')"> <img align="absmiddle" src="images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector"  />
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Leave Duration</td>
<td><select name="leave_duration" id="leave_duration"  style="width:150px;">
{$leave_duration_Options}
</select></td>
</tr>


<tr bgcolor="#FFFFFF">
<td valign="top">Reason for Leave</td>
<td valign="top"><textarea name="reason_for_leave" rows="7" style="width:98%;" id="reason_for_leave"></textarea></td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top" colspan="2"><input type="button" id="submit_btn" name="save" value="Submit" onclick="SubmitRequest()" /> <input type="button"  onclick="ShowStaffAllRequestedLeave()" value="Close" /></td>
</tr>



</table>
