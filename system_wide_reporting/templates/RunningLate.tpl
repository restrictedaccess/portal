<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Running Late Sheet</title>
<link rel=stylesheet type=text/css href="./media/css/style.css">
<link rel=stylesheet type=text/css href="./media/css/system_wide_reporting.css">

<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

</head>
<body style="margin:0;">

<form method="POST" name="form" action="{$script_filename}">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /> <span style="font-size:28px; font-weight:bold; margin-left:200px;">&nbsp;</span>

<h1 align="center">Running Late Report</h1>
<fieldset id="search_form">
<legend>Search</legend>
<div >
Date : <input type="text" name="from" id="from" class="text" style=" width:72px;" value="{$from}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector"  />
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
START TIME :
<select name="start_time" id="start_time">
	<option value=""></option>
	{html_options values=$TIME  output=$TIMESTR selected=$start_time  }
</select>
FLEXI : <select name="flexi" id="flexi" class="select_box">
<option value="">-</option>
{foreach from=$FLEXI name=f item=f}
    <option value="{$f}" {if $f eq $flexi} selected="selected" {/if}>{$f}</option>
{/foreach}
</select>
CSRO : <select name="csro" id="csro" class="select_box">
<option value="">-</option>
{$team_Options}
</select>
COMPLIANCE : <select name="compliance" id="compliance" class="select_box">
<option value="">-</option>
{foreach from=$COMPLIANCE name=C item=C}
    <option value="{$C}" {if $compliance eq $C} selected="selected" {/if}>{$C|capitalize}</option>
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
<input type="submit" value="Search" />
<input type="button" value="Export to CSV"  onclick="location.href='ExportRunningLate.php?from={$from}'" />
</div>
</fieldset>
<br clear="all" />

<h2 align="center">As of : &nbsp;
{if $from eq $smarty.now|date_format:'%Y-%m-%d'}
    {$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
{else}
    {$from}    
{/if}
</h2>

<div id="running_late_legend">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="55%" valign="top">
<p><label style="background:green;">Present</label> : Staff who logged in on time  (within 5 minutes before to 5 minutes after their Daily contract hours).</p>
<p><label style="background:red;">Late</label> : Staff who is 6 minutes (+) late and working.</p>
<p><label style="background:yellow;">Running Late</label> : Not logged in and is running late (6 minutes later than contract hours).</p>
<p><label style="background:#999;">Absent</label> : 2 hours running late and still not logged in .</p>
<p><label style=" background:#CCC;">On Leave</label> : Staff on approved leave .</p>
</td>
<td width="45%" valign="top">
<p><label style="background:orange;">10 Minutes Check</label> : List of staff who needs to report to work in 10 minutes minutes time. </p>
<p><label style="background:#0066Ff;">Not Scheduled to Work Yet</label> : Staff who's not scheduled to work yet.</p> 
<p><label style="background:#FF00FF;">Extra Day</label> : Staff working outside the contract days.</p>
<p><label style="background:#00FFCC;">Flexi</label> : Staff has a Flexi Schedule.</p>

</td>
</tr>
</table>


</div>
<br clear="all" />

<div align="center"><strong>{$num_results} records found.</strong></div>
<br clear="all" />
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#999" style="font:10px tahoma;">
  <tr bgcolor="#CCCC00">
    <td width="2%" >#</td>
    <td width="14%" >STAFF NAME</td>
    <td width="13%" >CLIENT NAME</td>
    <td width="10%" >CSRO</td>
    <td width="14%" align="center" >WORKING STATUS</td>
    <td width="5%" align="center" valign="top" >PRESENT <br>({$present})</td>
    <td width="5%" align="center" valign="top"  >LATE <br>({$late})</td>
    <td width="6%" align="center" valign="top"  >RUNNING LATE <br>({$running_late})</td>
    <td width="5%" align="center" valign="top"  >ABSENT <br>({$absent})</td>
    <td width="5%" align="center" valign="top"  >10 MINUTES<br>CHECK <br>({$ten_minutes})</td>
    <td width="8%" align="center" valign="top"  >NOT SCHEDULE<br>TO WORK YET <br>({$not_yet_working})</td>
    <td width="7%" align="center" valign="top"  >EXTRA DAY <br>({$extra_day})</td>
    <td width="10%" align="center" valign="top"  >ON LEAVE <br>({$on_leave})</td>
  </tr>

{foreach from=$staff_list name=staff item=staff}
    <tr bgcolor="#FFFFFF">
        <td valign="top">{$smarty.foreach.staff.iteration}</td>
        <td valign="top"><a href="/portal/recruiter/staff_information.php?userid={$staff.userid}" target="_blank">{$staff.staff_name}</a></td>
        <td valign="top"><a href="/portal/leads_information.php?id={$staff.leads_id}" target="_blank">{$staff.client_name}</a></td>
        <td valign="top">{$staff.csro.admin_fname} {$staff.csro.admin_lname}</td>
        <td valign="top">{$staff.working_status} <span style="float:right; font-size:10px;">{$staff.expected_login_time}</span></td>
        <td align="center" {if $staff.compliance eq 'on time'} bgcolor="green" {/if} {if $staff.compliance eq 'flexi'} bgcolor="#00FFCC" {/if} valign="top">{if $staff.compliance eq 'on time'} {$staff.time_in} {/if} {if $staff.compliance eq 'flexi'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'late'} bgcolor="red" {/if} valign="top">{if $staff.compliance eq 'late'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'running late'} bgcolor="yellow" {/if} valign="top">{if $staff.compliance eq 'running late'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'absent'} bgcolor="#999999" {/if} valign="top">{if $staff.compliance eq 'absent'}no login time{/if}</td>
        <td align="center" {if $staff.compliance eq '10 minutes'} bgcolor="orange" {/if} valign="top">{if $staff.compliance eq '10 minutes'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'not yet working'} bgcolor="#0066Ff" {/if} valign="top">{if $staff.compliance eq 'not yet working'} {$staff.expected_login_time} {/if}</td>
        <td align="center" {if $staff.compliance eq 'extra day'} bgcolor="#FF00FF" {/if} valign="top">{if $staff.compliance eq 'extra day'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'on leave'} bgcolor="#ccc" {/if} valign="top">{if $staff.compliance eq 'on leave'} Approved Leave {/if}</td>
    </tr>
{/foreach}

</table>
</form>
</body>
</html>