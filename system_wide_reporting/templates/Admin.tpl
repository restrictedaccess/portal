<table width="100%" cellpadding="1" cellspacing="5">
<tr>
<td colspan="2">

Date : <select id="month" onchange="SearchSubconQuickViewByDate(); ClearFromToFields()"><option value="">-</option>{$monthOptions}</select> <select id="year" onchange="SearchSubconQuickViewByDate();ClearFromToFields()"><option value="">-</option>{$yearoptions}</select>
<span style="margin-left:50px; color:#999999;"><em>or</em></span>
<span style="margin-left:100px;">
From : <input type="text" name="from" id="from"  style=" width:72px;" value="{$start_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />

To : <input type="text" name="to" id="to"  style=" width:72px;" value="{$end_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />


<input type="button" value="Go" onclick="SearchSubconQuickViewByFromTo(); ClearSelectMonthYear();" id="go"  />
</span>
<!--
<span style="float:right;">CSRO : <select id="csro">
	<option value="">-</option>
	{section name=j loop=$csro}
	<option value="{$csro[j].admin_id}">{$csro[j].admin_fname} {$csro[j].admin_lname}</option>
	{/section}
	</select></span>
-->	
</td>
</tr>
<tr>
<td valign="top" width="50%" ><div id="subcons_quick_view_filter_result">Loading...</div></td>
<td valign="top" width="50%"><div id="compliance_quick_view">
<p><strong>COMPLIANCE QUICK VIEW DATE TODAY {$today_date}</strong></p>
		
		<u>Staff</u>
        	<div id="rssc_working_staff"><ul>Loading...</ul></div>
			
		<div style="margin-top:20px; margin-bottom:10px;"><a href="/portal/django/system_wide_reporting/staff_attendance_sheet/" target="_blank" >Staff Attendance Sheet</a></div>
		<div style="margin-top:10px; margin-bottom:10px;"><a href="/portal/django/system_wide_reporting/running_late_beta/" target="_blank" >Running Late</a></div>
        <div style="margin-top:20px; margin-bottom:10px;"><a href="/portal/django/system_wide_reporting/staff_daily_attendance/" target="_blank" >Staff Daily Attendance</a></div>
		<u>Leave Request</u>
        <div id="leave_request_summary_container"></div>
			
		
	</div>


</td>
</tr>
</table>
