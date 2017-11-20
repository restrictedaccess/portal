<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff {$leads_info.fname|escape} {$leads_info.lname|escape} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_invoice_setting.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}#A" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />
<input type="hidden" name="cc_emails" id="cc_emails"  />
{if $page_type eq 'TRUE'}
	{php}include("header.php"){/php}
	
	{if $agent_section eq True}
		{php}include("BP_header.php"){/php}
	{/if}
	
	{if $admin_section eq True}
		{php}include("admin_header_menu.php"){/php}
	{/if}
{/if}

<h1>{$leads_info.fname|escape} {$leads_info.lname|escape} <span class="leads_id">#{$leads_id}</span></h1>

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
{if $admin_status neq 'HR'}
	{if $page_type eq 'TRUE'}
		<td width="173" valign="top" >
		
			{if $agent_section eq True}
				{php}include("agentleftnav.php"){/php}
			{/if}
			
			{if $admin_section eq True}
				{php}include("adminleftnav.php"){/php}
			{/if}
		
		</td>
	{/if}
{/if}
<td valign="top">
{php}include("leads_information/top-tab.php"){/php}
<div align="center" style="font-weight:bold; padding:10px; font-size:14px; margin-top:20px;">Case List </div>
<div id="cases_leads">

<hr />
<iframe id='casesframe' name='casesframe' frameborder='0' src='/portal/ticketmgmt/ticket.php?/index/open/&leads_id={$leads_id}'
	scrolling="auto" style='width:100%;height:500px;float:left;'></iframe>

</div>

</td>
</tr>
</table>
{if $page_type eq 'TRUE'}
	{php}include("footer.php"){/php}
{/if}

</form>
</body>
</html>
