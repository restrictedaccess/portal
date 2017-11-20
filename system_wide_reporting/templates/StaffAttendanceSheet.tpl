<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Staff Attendance Sheet</title>
<link rel=stylesheet type=text/css href="./media/css/style.css">
<link rel=stylesheet type=text/css href="./media/css/system_wide_reporting.css">

<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

</head>
<body style="margin:0;">
<form method="POST" name="form" action="StaffAttendanceSheet.php" >
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /> 
<h1 align="center">Staff Attendance Report</h1>
<fieldset id="search_form">
<legend>Search</legend>

<div>
From : <input type="text" name="from" id="from" class="text" style=" width:72px;" value="{$from}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector"  />
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
To : <input type="text" name="to" id="to" class="text" style=" width:72px;" value="{$to}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector"  />
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
<br>
CSRO : <select name="csro" id="csro" class="select_box">
<option value="">-</option>
{$team_Options}
</select>
LOGIN TYPE : <select name="login_type" id="login_type" class="select_box">
<option value="">-</option>
{foreach from=$login_types name=login item=login}
    <option value="{$login}" {if $login_type eq $login} selected="selected" {/if}>{$login}</option>
{/foreach}
</select>
WORK STATUS : <select name="work_status" id="work_status" class="select_box">
<option value="">-</option>
{$work_status_Options}
</select>
FLEXI : <select name="flexi" id="flexi" class="select_box">
<option value="">-</option>
{foreach from=$prepaid_Options item=p name=p}
<option value="{$p}" {if $p eq $flexi} selected="selected" {/if}>{$p}</option>
{/foreach}
</select>
<br />
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
<br />
<input type="submit" value="Search" name="go" />
<input type="button" value="Export to CSV"  onclick="location.href='export_staff_attendance_sheet.php?from={$from}&to={$to}'" /> Results shown in the list below are to be exported.
</div>
</fieldset>

<br clear="all" />
<p align="center" style="font-family:'Courier New', Courier, monospace;">{$result_str}</p>

<div class='pagination'>{$paging}</div>
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#999" style="font:11px tahoma;">
<tr bgcolor="#CCCC00">
<td width="4%" >#</td>
<td width="8%" >STAFF NAME</td>
<td width="8%" >CLIENT NAME</td>
<td width="8%" >CSRO</td>
<td width="5%" >WORK STATUS</td>
<td width="3%" >FLEXI</td>
<td width="56%" >
	<table width="100%" cellpadding="0" cellspacing="0" style="font:10px tahoma;">
	<tr>
	<td width="10%" >COMPLIANCE</td>
	<td width="76%">
	<table width="100%" cellpadding="0" cellspacing="0" style="font:10px tahoma;">
	<tr>
	<td width="30%" align="center" >TIME IN</td>
	<td width="30%" align="center" >TIME OUT</td>
	<td width="13%" align="center" >MODE</td>
	<td width="12%" align="right" >HOURS</td>
	</tr>
	</table>
</td>
<td width="8%" align="right">ADJ HRS</td>
</tr>
</table>


</td>

</tr>

{foreach from=$staff_list name=staff item=staff}
    <tr bgcolor="#FFFFFF">
        <td valign="top">{if $SEARCH_ALL}{$staff.counter}{else}{$smarty.foreach.staff.iteration}{/if}</td>
        <td valign="top">{$staff.staff_name}</td>
        <td valign="top">{$staff.client_name}</td>
        <td valign="top">{$staff.csro.admin_fname} {$staff.csro.admin_lname}</td>
        <td valign="top">{$staff.work_status}</td>
		<td valign="top">{$staff.flexi}</td>
        <td align="right"  valign="top"  style="padding:0; margin:0;">
            
            <table width="100%" cellpadding="0" cellspacing="0" >
            {foreach from=$staff.logins name=login item=login}
                <tr bgcolor="{cycle values='#F2F2F2, #CCCCCC'}">
                    <td width="12%" valign="top">{$login.compliance}</td>
                    <td width="76%" valign="top" style="padding:0; margin:0;">
                        
                        <table width="100%" cellpadding="0" cellspacing="0" >
                        {foreach from=$login.timerecords name=timerecord item=timerecord}
                            <tr>
                                <td width="30%" valign="top" align="center" style="padding:0; margin:0;" >
                                {if $login.compliance eq 'no schedule' or $login.compliance eq 'absent'}
                                    {$timerecord.time_in}
                                {elseif $login.compliance eq 'not yet working'}
                                -         
                                {else}
                                    {$timerecord.time_in|date_format:"%Y-%m-%d %I:%M %p %a"}
                                {/if}
                                </td>
                                <td width="30%" valign="top"  align="center" style="padding:0; margin:0;">{$timerecord.time_out|date_format:"%Y-%m-%d %I:%M %p"}</td>
                                <td width="13%" valign="top"  align="center" style="padding:0; margin:0;">{$timerecord.mode}</td>
                                <td width="12%" valign="top"  align="right" style="padding:0; margin:0; font-family:'Courier New', Courier, monospace; font-size:12px !important;">{$timerecord.total_hrs|number_format:2:".":""}</td>
                               
                            </tr>
                        {/foreach}
                        </table>
                        
                    </td>
                    <td width="10%" align='right' valign="top">{$login.adj_hrs}</td>
                </tr>
            {/foreach}
            </table>
            
            <div class="staff_attendance_summary">
       {if $staff.total_hours_worked}     
       <p><label>Total Hours Worked :</label><span style="font-weight:bold;">{$staff.total_hours_worked|number_format:2:".":""}</span></p>
       {/if}
       {if $staff.total_adj_hrs}     
       <p><label>Total Adjusted Hours :</label><span style="font-weight:bold;">{$staff.total_adj_hrs|number_format:2:".":""}</span></p>
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
       
       {if $staff.absent}
       <p><label>Absent :</label><span>{$staff.absent}</span></p>
       {/if}
       
       {if $staff.on_leave}
       <p><label>On Leave :</label><span>{$staff.on_leave}</span></p>
       {/if}  
       
       {if $staff.no_schedule}
       <p><label>No Schedule :</label><span>{$staff.no_schedule}</span></p>
       {/if} 
           
            </div>
            
            
           
        </td>
    </tr>
{/foreach}

</table>
<div class='pagination'>{$paging}</div>
</form>
</body>
</html>