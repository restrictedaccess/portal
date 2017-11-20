{*
2011-03-03  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Business Developer {$agent.fname} {$agent.lname}</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="BD/media/css/BD.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type='text/javascript' language='JavaScript' src='js/functions.js'></script>
<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<script type="text/javascript" src="js/agenthome-roy-code.js"></script>
<script type="text/javascript" src="./BD/media/js/business_developer_summary_report.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />
{* added by msl 10/24/11 *}
<link rel=stylesheet type=text/css href="css/overlay.css">
	
</head>
<body style="margin-top:0; margin-left:0">
	<div id="overlay"> <div> <p>You will be logged in to RemoteStaff Chat.</p>
	<input type='button' name='submit' value='&nbsp; OK &nbsp;' onclick='alertchat(1);' /></div> </div>
	
<form method="POST" name="form" action="agentHome.php">

{php}include("header.php"){/php}

{php}include("BP_header.php"){/php}


<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
{php} include ('agentleftnav.php'){/php}
</td>
<td width=100% valign=top >
<!-- Contents Here -->
{php} include ('agentHome-appointments.php'){/php}
<div style="padding:10px;">
<div style="float:left">
<strong>Date Selection</strong>
<div>
<img src="images/resultset_previous.png" title="previous date" onclick="ShowBDSummaryReport('previous')" style="cursor:pointer;" align="texttop" /> Previous 
<img src="images/date.png" title="current date" onclick="ShowBDSummaryReport('current')" style="cursor:pointer;" align="texttop" />  Next
<img src="images/resultset_next.png" title="next date" onclick="ShowBDSummaryReport('next')" style="cursor:pointer;" align="texttop" /> 

<input type="text" name="event_date" id="event_date" class="text" style=" width:72px;" readonly onchange="ShowBDSummaryReport('event_date')" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
{literal}
<script type="text/javascript">
	Calendar.setup({
		inputField     :    "event_date",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	function alertchat(clicked) {
			el = document.getElementById("overlay");
			//el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
			el.style.display = (!el.style.display || el.style.display == "none") ? "block" : "none";
			if (clicked == 1) {
				popup_win8('./rschat.php?portal=1&email={/literal}{$emailaddr}&hash={$hash}{literal}',800,600);
			}
		}
	{/literal}
	{* added by msl - 24/10/11 *}
	{if $session_exists == 1}window.onload=alertchat(0);{/if}{literal}
		
</script>
{/literal}
</div>
</div>

<div style="float:left; margin-left:250px;">
<strong>Year / Month Selection</strong>
<div>

<select name="year" id="year" style="width:200px;" onchange="ShowMonthlyYearlyBDSummaryReport()">
{$yearoptions}
</select>

<select name="month" id="month" style="width:200px;" onchange="ShowMonthlyYearlyBDSummaryReport()">
<option value="">Select a month</option>
{$monthoptions}
</select>


</div>
</div>

<br clear="all" />

</div>
<hr />
<div id="summary" style="padding:10px;"><input type="hidden" name="current_date" id="current_date" value="{$current_date}"></div>

</td>
</tr>
</table>
{php} include ('footer.php'){/php}
{literal}
<script type="text/javascript">
ShowBDSummaryReport('current');
</script>
{/literal}

</form>	
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<div id="support_sound_alert"></div>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
</body>
</html>
