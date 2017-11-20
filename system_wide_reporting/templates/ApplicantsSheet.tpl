<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Staff Attendance Sheet</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../system_wide_reporting/media/css/system_wide_reporting.css">
<script type="text/javascript" src="../js/MochiKit.js"></script>
<script language=javascript src="../system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script language=javascript src="../js/functions.js"></script>
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

</head>
<body style="margin-top:0; margin-left:0">

<form method="POST" name="form" action="ApplicantsSheet.php">

<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /> <span style="font-size:28px; font-weight:bold; margin-left:200px;">Applicants  Sheet</span>
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

<input type="submit" value="Go" /><br />
<!--<a href="ExportStaffAttendanceSheet.php?from={$from}&to={$to}" target="_blank">Export to CSV</a>-->
</div>

<h3 align="center">
{if $year_search eq 'yes'}
	Total applicants for {$year}
{else}
	Total applicants for {$from|date_format:"%B %e, %Y"} to {$to|date_format:"%B %e, %Y"}
{/if}
</h3>
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" style="font:11px tahoma;">
<tr bgcolor="#333333">
<td width="4%" style="color:#FFFFFF;">#</td>
<td width="6%" style="color:#FFFFFF;">USERID</td>
<td width="30%" style="color:#FFFFFF;">STAFF NAME</td>
<td width="37%" style="color:#FFFFFF;">EMAIL</td>
<td width="23%" style="color:#FFFFFF;">DATE</td>

</tr>
{$staff_list}
</table>
</form>

{literal}
<script>
var items = getElementsByTagAndClassName('span', 'leads_list', parent=document);
for (var item in items){
	connect(items[item], 'onclick', updateParent);
}
</script>
{/literal}

</body>
</html>