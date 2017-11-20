{*
2010-11-15  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Business Partner Management</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./BD/media/css/BD.css">

<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./BD/media/js/draggable.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
<script type="text/javascript" src="./BD/media/js/business_developer.js"></script>

</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="{$filename}" accept-charset = "utf-8">
<input type="hidden" name="agent_no" id="agent_no" value="{$agent.agent_no}" />
<input type="hidden" name="mode" id="mode" value="{$mode}" />
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}




<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid"  >
<tr>
<td width="173" valign="top" >
	{php}include("adminleftnav.php"){/php}</td>

<td valign="top">
<h1>Business Developer Management</h1>
{if $result_msg}
<div style="margin:10px; padding:5px; font-weight:bold; background:#FFFF00; text-align:center;">{$result_msg}</div>
{/if}
<input  type="submit" name="new" value="Add New Business Partner" />
<div id="add_edit" style="display:{$display};">

<table width="100%" cellpadding="5" cellspacing="0" >

<tr>
<td valign="top" width="50%">
<table width="100%" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">

<tr bgcolor="#FFFFFF">
<td>First Name</td>
<td><input type="text" name="fname" id="fname" value="{$agent.fname}"  size="60" /></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Last Name</td>
<td><input type="text" name="lname" id="lname" value="{$agent.lname}"  size="60" /></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Email</td>
<td><input type="text" name="email" id="email" value="{$agent.email}"  size="60" /></td>
</tr>

{if $mode neq 'edit'}
<tr bgcolor="#FFFFFF">
<td>Password</td>
<td><input type="password" name="agent_password" id="agent_password" value=""  size="20" /></td>
</tr>
{/if}

<tr bgcolor="#FFFFFF">
<td>Address</td>
<td><textarea name="agent_address" id="agent_address"  style="width:360px; height:50px;">{$agent.agent_address}</textarea></td>
</tr>

<tr bgcolor="#FFFFFF">
<td>Contact Nos.</td>
<td><textarea name="agent_contact" id="agent_contact"  style="width:360px; height:50px;">{$agent.agent_contact}</textarea></td>
</tr>

<tr bgcolor="#FFFFFF">
<td >Status</td>
<td><select name="status" id="status" >
{$status_options}
</select></td>
</tr>




<tr bgcolor="#FFFFFF">
<td >Access All Leads</td>
<td><select name="access_all_leads" id="access_all_leads" >
{$access_all_leads_options}
</select></td>
</tr>

<tr bgcolor="#FFFFFF">
<td >Access Affiliates Leads</td>
<td><select name="access_aff_leads" id="access_aff_leads" >
{$access_aff_leads_options}
</select></td>
</tr>


<tr bgcolor="#FFFFFF">
<td colspan="2" align="center" >
{$btn}
<input type="button" value="Cancel" onclick="location.href='{$filename}'" /></td>
</tr>
</table></td>
<td valign="top" width="50%">{if $mode eq 'edit'} {if $ShowAgentInfoChangesHistory neq ''}<strong>History Changes</strong> <div style="display:block; height:320px; overflow-y:scroll; overflow-x:hidden; border-left:#CCCCCC solid 1px; border-top:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;">{$ShowAgentInfoChangesHistory}</div> {/if}{/if}</td>
</tr>
</table>
</div>
<div id="BD_Profile" class="draggable">here</div>
<div class="tabber">
{$bps_str}</div></td>
</tr>
</table>
{php}include("footer.php"){/php}
</form>

</body>
</html>
