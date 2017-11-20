<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Staff Attendance Sheet</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../admin_subcon/admin_subcon.css">

<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

</head>
<body style="margin:0;">
<form method="POST" name="form" action="{$script_filename}">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /> <span style="font-size:28px; font-weight:bold; margin-left:200px;">Staff Attendance Sheet</span>
<div  style="padding:20px; float:right; text-align:right;">
From : <input type="text" name="from" id="from" class="text" style=" width:72px;" value="{$from}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
{literal}
<script type="text/javascript">
	Calendar.setup({
		inputField     :    "from",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});                     
</script>
{/literal}
To : <input type="text" name="to" id="to" class="text" style=" width:72px;" value="{$to}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
{literal}
<script type="text/javascript">
	Calendar.setup({
		inputField     :    "to",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd2",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});                     
</script>
{/literal}

CSRO : <select name="csro" id="csro" class="select_box">
<option value="">-</option>
{$team_Options}
</select>

STAFFS : <select name="userid" id="userid" class="select_box">
<option value="">-</option>
{foreach from=$active_staffs name=active_staff item=active_staff}
    <option value="{$active_staff.userid}" {if $userid eq $active_staff.userid} selected="selected" {/if}>{$active_staff.fname|capitalize} {$active_staff.lname|capitalize}</option>
{/foreach}
</select>

CLIENTS : <select name="leads_id" id="leads_id" class="select_box">
<option value="">-</option>
{foreach from=$active_clients name=active_client item=active_client}
    <option value="{$active_client.leads_id}" {if $leads_id eq $active_client.leads_id} selected="selected" {/if}>{$active_client.fname|capitalize} {$active_client.lname|capitalize}</option>
{/foreach}
</select>

<input type="submit" value="Go" /><br />
<a href="ExportStaffAttendanceSheet.php?from={$from}&to={$to}&csro={$csro}&userid={$userid}&leads_id={$leads_id}" target="_blank">Export to CSV</a>
</div>
<br clear="all" />
<div class='pagination' style="background:#FFF !important;"><ul>{$paging}</ul> {$numrows}</div>
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#999" style="font:11px tahoma;">
<tr bgcolor="#CCCC00">
<td width="4%" >#</td>
<td width="13%" >STAFF NAME</td>
<td width="13%" >CLIENT NAME</td>
<td width="15%" align="center" >WORKING HOURS</td>

<td width="55%" >
<table width="100%" cellpadding="0" cellspacing="0" style="font:10px tahoma;">
<tr>
<td width="10%" >COMPLIANCE</td>
<td width="90%">
<table width="100%" cellpadding="0" cellspacing="0" style="font:10px tahoma;">
<tr>
<td width="37%" align="center" >TIME IN</td>
<td width="38%" align="center" >TIME OUT</td>
<td width="13%" align="center" >MODE</td>
<td width="12%" align="right" >HOURS</td>
</tr>
</table>

</td>
</tr>
</table>


</td>

</tr>


{foreach from=$staff_list name=staff item=staff}
    <tr bgcolor="#FFFFFF">
        <td valign="top">{$smarty.foreach.staff.iteration}</td>
        <td valign="top">{$staff.staff_name}</td>
        <td valign="top">{$staff.client_name}</td>
        <td align="center" valign="top">{$staff.working_hours}</td>
        
        <td align="right"  style="padding:0; margin:0;">
            
            <table width="100%" cellpadding="0" cellspacing="0" >
            {foreach from=$staff.logins name=login item=login}
                <tr bgcolor="{cycle values='#F2F2F2, #CCCCCC'}">
                    <td width="12%" valign="top">{$login.compliance} {$login.staff_working_hour}</td>
                    <td width="88%" valign="top" style="padding:0; margin:0;">
                        
                        <table width="100%" cellpadding="0" cellspacing="0" >
                        {foreach from=$staff.timerecords name=timerecord item=timerecord}
                            {if $timerecord.time_in|date_format:"%Y-%m-%d" eq $login.time_in|date_format:"%Y-%m-%d"}
                            <tr>
                                <td width="37%" align="center">{$timerecord.time_in}</td>
                                <td width="38%" align="center">{$timerecord.time_out}</td>
                                <td width="13%" align="center">{$timerecord.mode}</td>
                                <td width="12%"  align="right">{$timerecord.total_hrs|number_format:2:".":""}</td>
                            </tr>
                            {/if}
                        {/foreach}
                        </table>
                        
                    </td>
                </tr>
                <!--<tr><td colspan="2"><hr /></td></tr>-->
            {/foreach}
            </table>
            
            <div class="staff_attendance_summary">
       {if $staff.total_hours_worked}     
       <p><label>Total Hours :</label><span>{$staff.total_hours_worked}</span></p>
       {/if}
       {if $staff.extra_day}
       <p><label>Extra Day :</label><span>{$staff.extra_day}</span></p>
       {/if}
       {if $staff.early_login}
       <p><label>Early Login :</label><span>{$staff.early_login}</span></p>
       {/if} 
       
       {if $staff.flexi_count}
       <p><label>Flexi :</label><span>{$staff.flexi_count}</span></p>
       {/if}
       
       {if $staff.present}
       <p><label>Present :</label><span>{$staff.present}</span></p>
       {/if}
       {if $staff.late}
       <p><label>Late :</label><span>{$staff.late}</span></p>
       {/if}   
            <!--
            {if $staff.total_hours_worked}
            <div style="font-weight:bold; margin-top:5px; padding-top:5px;">Total Hours : <span style="color:#F00;">{$staff.total_hours_worked|number_format:2:".":""}</span></div>
            {/if}
            
            {if $staff.flexi_count}
            Flexi : <strong>{$staff.flexi_count}</strong> <br />
            {/if}
            {if $staff.extra_day}
            Extra Day : <strong>{$staff.extra_day}</strong> <br />
            {/if}
            {if $staff.early_login}
            Early Login : <strong>{$staff.early_login}</strong> <br />
            {/if}
            {if $staff.present}
            Present : <strong>{$staff.present}</strong> <br />
            {/if}
            {if $staff.late}
            Late : <strong>{$staff.late}</strong> <br />
            {/if}
            -->
            
            </div>
            
            
           
        </td>
    </tr>
{/foreach}

</table>
</form>
</body>
</html>