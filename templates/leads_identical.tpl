{*
2011-01-28  Normaneil Macutay <normanm@remotestaff.com.au>

*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff {$leads_info.fname|escape} {$leads_info.lname|escape} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/example.css">

<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>


</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_identical.php?id={$leads_id}&lead_status={$lead_status}" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />

{php}include("header.php"){/php}

{if $agent_section eq True}
	{php}include("BP_header.php"){/php}
{/if}

{if $admin_section eq True}
	{php}include("admin_header_menu.php"){/php}
{/if}

<table width="100%" cellpadding=0 cellspacing=0 border=0 >
<tr>
<td width="173" valign="top" >

{if $agent_section eq True}
	{php}include("agentleftnav.php"){/php}
{/if}

{if $admin_section eq True}
	{php}include("adminleftnav.php"){/php}
{/if}

</td>
<td valign="top" style="padding:5px;">

<div class="leads_orig_hdr"><a href="leads_information.php?id={$leads_info.id}&lead_status={$leads_info.status}">{$leads_info.fname|capitalize} {$leads_info.lname|capitalize}</a></div>
<div id="leads_orig_info">
	<p>Leads ID : {$leads_id}</p>
	<p style="border-bottom:#CCCCCC dashed 1px; width:450px; margin-bottom:10px; padding-bottom:5px;">Email : {$leads_info.email} <br />
	<span style="font-size:10px; color:#FF0000;"><input type="radio" name="email_use" value="primary" /> use as Primary Email  <input type="radio" name="email_use" value="alternate" /> use as Alternative Email </span>
</p>
	
	
	{if $identical_leads_count neq 0}
	<p><input type="checkbox" name="merge_{$leads_id}" value="status"  />Status : {$leads_info.status}</p>
	<p><input type="checkbox" name="merge_{$leads_id}" value="officenumber"  />Office Number : {$leads_info.officenumber}</p>
	<p><input type="checkbox" name="merge_{$leads_id}" value="mobile"  />Mobile Number : {$leads_info.mobile}</p>
	<p>
	<input type="hidden" id="merge_fields_{$leads_id}" />
	<input type="button" value="Merge" onclick="MergeLeadsInfo()" /><input type="button" value="Separate" onclick="SeparateLead()" /></p>
	{else}
	<p>Status : {$leads_info.status}</p>
	<p>Office Number : {$leads_info.officenumber}</p>
	<p>Mobile Number : {$leads_info.mobile}</p>
	{/if}
</div>


<strong style="color:#FF0000;">{$leads_info.fname|upper} {$leads_info.lname|upper}</strong> <strong> IS IDENTICAL TO :</strong>
<p>Select any information you want to merge then click on the Merge button.<br />
<strong>NOTE</strong> : The identical lead will be removed. </p>
<table width="40%"  cellpadding="2" cellspacing="5">

{foreach from=$identical_leads item=identical_leads name=identical_leads}
<tr bgcolor="{cycle values=#eeeeee,#d0d0d0}">
<td valign="top" >
<div><input type="radio" name="identical_id" value="{$identical_leads.id}"  /> <a href="leads_information.php?id={$identical_leads.existing_leads_id}&lead_status={$identical_leads.status}">{$identical_leads.existing_leads_id} {$identical_leads.fname|capitalize}  {$identical_leads.lname|capitalize}</a> <span style="float:right; margin-right:10px;">[ {$identical_leads.status} ]</span></div>

<input type="hidden" id="identical_leads_id_{$identical_leads.id}" value="{$identical_leads.existing_leads_id}" />
<input type="hidden" id="identical_lead_status_{$identical_leads.id}" value="{$identical_leads.status}" />
<table width="100%" cellpadding="3" cellspacing="0">

<tr >
<td width="21%">Email</td>
<td width="73%">: {$identical_leads.email}</td>
</tr>

<tr >
<td >Office Phone</td>
<td >: {$identical_leads.officenumber}</td>

</tr>


<tr >
<td >Mobile Phone</td>
<td >: {$identical_leads.mobile}</td>

</tr>

</table>
</td>
</tr>
{foreachelse}

<tr><td colspan="3" >No Identical leads fullname to be shown.. 
</td></tr>


{/foreach}
</table>


</td>
</tr>
</table>
{php}include("footer.php"){/php}
</form>
</body>
</html>
