<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Running Late Sheet</title>
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
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /> <span style="font-size:28px; font-weight:bold; margin-left:200px;">&nbsp;</span>
<div  style="padding:20px; float:right; text-align:right;">
Date : <input type="text" name="from" id="from" class="text" style=" width:72px;" value="{$from}" readonly  > <img align="absmiddle" src="../images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
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

<div id="running_late_legend">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="55%" valign="top"><p><label style="background:green;">Present</label> : Staff who logged in on time  (within 5 minutes before to 5 minutes after their Daily contract hours).</p>
<p><label style="background:red;">Late</label> : Staff who is 6 minutes (+) late and working.</p>
<p><label style="background:yellow;">Running Late</label> : Not logged in and is running late (6 minutes later than contract hours).</p>
<p><label style="background:#999;">Absent</label> : 2 hours running late and still not logged in .</p>
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

<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#999" style="font:10px tahoma;">
  <tr bgcolor="#CCCC00">
    <td width="2%" >#</td>
    <td width="15%" >STAFF NAME</td>
    <td width="14%" >CLIENT NAME</td>
    <td width="15%" align="center" >WORKING STATUS</td>
    <td width="6%" align="center" >PRESENT</td>
    <td width="6%" align="center" >LATE</td>
    <td width="7%" align="center" >RUNNING LATE</td>
    <td width="6%" align="center" >ABSENT</td>
    <td width="9%" align="center" >10 MINUTES CHECK</td>
    <td width="14%" align="center" >NO SCHEDULE TO WORK YET</td>
    <td width="6%" align="center" >EXTRA DAY</td>
  </tr>

{foreach from=$staff_list name=staff item=staff}
    <tr bgcolor="#FFFFFF">
        <td valign="top">{$smarty.foreach.staff.iteration}</td>
        <td valign="top">{$staff.staff_name}</td>
        <td valign="top">{$staff.client_name}</td>
        <td valign="top">{$staff.working_status} <span style="float:right; font-size:10px;">{$staff.expected_login_time}</span></td>
        <td align="center" {if $staff.compliance eq 'on time'} bgcolor="green" {/if} {if $staff.compliance eq 'flexi'} bgcolor="#00FFCC" {/if} valign="top">{if $staff.compliance eq 'on time'} {$staff.time_in} {/if} {if $staff.compliance eq 'flexi'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'late'} bgcolor="red" {/if} valign="top">{if $staff.compliance eq 'late'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'running late'} bgcolor="yellow" {/if} valign="top">{if $staff.compliance eq 'running late'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'absent'} bgcolor="#999999" {/if} valign="top">{if $staff.compliance eq 'absent'}no login time{/if}</td>
        <td align="center" {if $staff.compliance eq '10 minutes'} bgcolor="orange" {/if} valign="top">{if $staff.compliance eq '10 minutes'} {$staff.time_in} {/if}</td>
        <td align="center" {if $staff.compliance eq 'not yet working'} bgcolor="#0066Ff" {/if} valign="top">{if $staff.compliance eq 'not yet working'} {$staff.expected_login_time} {/if}</td>
        <td align="center" {if $staff.compliance eq 'extra day'} bgcolor="#FF00FF" {/if} valign="top">{if $staff.compliance eq 'extra day'} {$staff.time_in} {/if}</td>
    </tr>
{/foreach}

</table>
</form>
</body>
</html>