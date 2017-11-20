<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BETA Subconlist Exporting</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel=stylesheet type=text/css href="../admin_subcon/admin_subcon.css">

<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />


</head>

<body>
<form name="form" method="post" action="{$script_filename}">
<p>Active Subcontractors List as of :</p>
<p>Date range : </p>
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
<input type="hidden" name="_submit_check" value="1"/>
<input type="submit" name="search"  VALUE="Search" >
<input type="submit" name="export" value="Export"  />
</form>

<ol style="font-family:'Courier New', Courier, monospace; font-size:12px;">
{foreach from=$staffs item=staff name=staff}
<li>{$staff.fname} {$staff.lname} [Client] => {$staff.client_name} [Contract Status] => { if $staff.contract_status neq 'ACTIVE'}<strong style="color:#F00;"> {$staff.contract_status}</strong> {else} {$staff.contract_status} {/if} [Starting Date] => {$staff.starting_date} {if $staff.staff_contract_finish_date} [Contract End Date] => <strong style="color:#F00;">{$staff.staff_contract_finish_date}</strong> {/if} <strong>{$staff.total_log_hour}/hrs</strong></li>
{/foreach}
</ol>
</body>
</html>