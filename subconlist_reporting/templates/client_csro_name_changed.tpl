<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Client and CSRO Name Changed</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">

<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<script type="text/javascript" src="./media/js/subconlist_reporting.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />


</head>

<body>
<form name="form" method="post" action="{$script_filename}">
<p>Client and CSRO Name Changed :</p>
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


Clients : <select  id="leads_id" >
<option value="">Please select a client</option>
{foreach from=$clients name=client item=client}
    <option value="{$client.leads_id}">{$client.fname} {$client.lname} => {$client.leads_id}</option>
{/foreach}
</select>

<input type="button" id="search_client_btn" name="search"  VALUE="Search" >
</form>

<div id="results"></div>
{literal}
<script>
connect('search_client_btn', 'onclick', GetClientHistory);
//connect('active_client', 'onchange', CheckClientFilter);
//connect('inactive_client', 'onchange', CheckClientFilter);
</script>
{/literal}
</body>
</html>