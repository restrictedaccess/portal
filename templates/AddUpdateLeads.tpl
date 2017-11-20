{*
2010-08-17  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

<title>Remotestaff {$leads_info.fname} {$leads_info.lname} Leads Information Sheet</title>

<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">

<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>

<script language=javascript src="./js/functions.js"></script>

<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

</head>

<body style="margin-top:0; margin-left:0">

<form name="form" method="post" enctype="multipart/form-data" action="AddUpdateLeads.php?{$query_string}" accept-charset = "utf-8">

<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />

<input type="hidden" name="leads_id" id="leads_id" value="{$leads_info.id}" />

<input type="hidden" name="mode" id="mode" value="{$mode}" />




{if $page_type eq 'TRUE'}
	{php}include("header.php"){/php}
	{if $agent_section eq True}
		{php}include("BP_header.php"){/php}
	{/if}
	{if $admin_section eq True}
		{php}include("admin_header_menu.php"){/php}
	{/if}
{/if}




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

{if $email_invalid eq True}

<div style="background:#FFFF00; font-weight:bold; text-align:center; padding:5px;">Invalid Primary Email</div>

{/if}



{if $sec_email_invalid eq True}

<div style="background:#FFFF00; font-weight:bold; text-align:center; padding:5px;">Invalid Secondary Person Email</div>

{/if}



{if $email_exist eq True}

<div style="background:#FFFF00; font-weight:bold; text-align:center;padding:5px;">Email Already Exist</div>

{/if}



{if $action_result neq ''}

<div style="background:#FFFF00; font-weight:bold; text-align:center;padding:5px;">{$action_result}</div>

{/if}





{if $leads_id neq ''}

<h1>{$leads_info.fname|escape} {$leads_info.lname|escape} <span class="leads_id">#{$leads_id}</span></h1>

{else}

<div style="height:20px;">&nbsp;</div>

{/if}



<h2>Information</h2>

<div class="hiresteps">

<div id="personal_information">{include file="AddUpdateLeadsForm.tpl"}</div>

<input type="hidden" name="_submit_check" value="1"/>

<p><input type="button" id="add_update_submit_btn" value="{$mode}"  onclick="return CheckAddUpdateLeadsEmail()" />

{if $leads_id}

<input type="button" value="Back" onClick="self.location='leads_information.php?id={$leads_info.id}&lead_status={$leads_info.status}&page_type={$page_type}'"/>
{/if}


</p>

</div>

<span class="toggle-btn" onclick="toggle('history')">SHOW / HIDE</span>

<h2>History</h2>

<div class="hiresteps">

<div id="history">

<table width="100%" cellpadding="0" cellspacing="1">

<tr>

<td height="66" valign="top">

<div style="color:#000000;">{$showLeadsInfoChangesHistory}</div></td>

</tr></table>

</div>

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

