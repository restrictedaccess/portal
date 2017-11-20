{*
2010-12-01  Normaneil Macutay <normanm@remotestaff.com.au>

	
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
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">

</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_merge_order.php?id={$leads_id}&lead_status={$lead_status}" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />

{php}include("header.php"){/php}

{if $agent_section eq True}
	{php}include("BP_header.php"){/php}
{/if}

{if $admin_section eq True}
	{php}include("admin_header_menu.php"){/php}
{/if}


<h1>{$leads_info.fname|escape} {$leads_info.lname|escape} <span class="leads_id">#{$leads_id}</span></h1>

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<td width="173" valign="top" >

{if $agent_section eq True}
	{php}include("agentleftnav.php"){/php}
{/if}

{if $admin_section eq True}
	{php}include("adminleftnav.php"){/php}
{/if}

</td>

<td valign="top">
{if $msg}
<div style="margin:10px; background:#FFFF00; font-weight:bold; text-align:center; padding:5px;">{$msg}</div>
{/if}
<div>Transfer all orders of <strong>{$leads_info.fname|escape} {$leads_info.lname|escape}</strong> {$leads_info.email} to : </div>
<ol>
{section name=j loop=$identical_leads}
{if $identical_leads[j].status eq 'Inactive'}
	{* display nothing *}
{elseif $identical_leads[j].status eq 'REMOVED'}
	{* display nothing *}
{else}
<li><input type="radio" name="leads"   value="{$identical_leads[j].existing_leads_id}" /> #{$identical_leads[j].existing_leads_id} {$identical_leads[j].fname} {$identical_leads[j].lname} {$identical_leads[j].email} [{$identical_leads[j].status}]</li>

{/if}

{sectionelse}
No identical name found
{/section}
</ol>
<div style="margin-top:20px;"><input type="submit" name="transfer" value="Transfer" /> <input type="button" value="Cancel" onclick="location.href='leads_information.php?id={$leads_id}&lead_status={$lead_status}'" /></div>
</td>
</tr>
</table>
{php}include("footer.php"){/php}
</form>

</body>
</html>
