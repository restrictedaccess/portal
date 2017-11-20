<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BETA Subconlist Exporting</title>
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
<p>Active Subcontractors List as of :</p>
<p>Date range : 
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
<br />

<table>
	<tr>
    	<td align="right">Active Clients :</td>
        <td>
        <select class="filter"  id="active_client_filter" name="active_client_filter" rel="active_client" >
        	<option value="all">All</option>
            <option value="none">None</option>
            <option value="leads_id">Selected Lead</option>
        </select>
        <select id="active_client" name="lead"  >
        <option value=""></option>
        {foreach from=$clients name=client item=client}
            <option value="{$client.leads_id}">{$client.fname} {$client.lname} => {$client.leads_id}</option>
        {/foreach}
        </select>

</td>
    </tr>
    
    <tr>
    	<td align="right">Inactive Clients :</td>
        <td>
        <select class="filter"  id="inactive_client_filter" name="inactive_client_filter" rel="inactive_client" >
        	<option value="all">All</option>
            <option value="none">None</option>
            <option value="leads_id">Selected Lead</option>
        </select>
        
        <select  id="inactive_client" name="lead" >
        <option value=""></option>
        {foreach from=$inactive_clients name=client item=client}
            <option value="{$client.leads_id}">{$client.fname} {$client.lname} => {$client.leads_id}</option>
        {/foreach}
        </select>
		</td>
    </tr>
   <tr>
   <td align="right">CSRO :</td>
        <td>        
        <select id="csro_id" >
        <option value=""></option>
        {foreach from=$csros name=csro item=csro}
            <option value="{$csro.admin_id}">{$csro.admin_fname} {$csro.admin_lname}</option>
        {/foreach}
        </select>
		</td>
   </tr> 
   <tr><td align="right">Filter :</td><td><input type="radio" name="client_type" value="all" checked="checked" /> Both Old and New Clients <input type="radio" name="client_type" value="old" /> Old Clients only <input type="radio" name="client_type" value="new" /> New Clients only </td></tr>
    
</table>


<input type="hidden" name="leads_id" id="leads_id"/>
<input type="hidden" name="_submit_check" value="1"/>
<input type="button" id="search_btn" name="search"  VALUE="Search" >
</form>

<div id="results"></div>
{literal}
<script>
connect('search_btn', 'onclick', GenerateCouchDocId);
//connect('active_client', 'onchange', CheckClientFilter);
//connect('inactive_client', 'onchange', CheckClientFilter);
var items = document.getElementsByName('lead')
for (var item in items){
     //connect(items[item], 'onchange', check_leads_val);
	 $(items[item]).disabled=true;
}


var items = document.getElementsByClassName('filter')
for (var item in items){
     connect(items[item], 'onchange', CheckFilter);
	 connect(items[item], 'onchange', CheckCSRO);
}


</script>
{/literal}
</body>
</html>