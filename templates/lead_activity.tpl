{*
2010-07-10  Normaneil Macutay <normanm@remotestaff.com.au>

*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Remotestaff {$leads_info.fname} {$leads_info.lname} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>
</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_information.php?id={$leads_id}&lead_status={$lead_status}">
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

<table width="100%"  cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<td width="240" valign="top" >
{if $agent_section eq True}
	{php}include("agentleftnav.php"){/php}
{/if}

{if $admin_section eq True}
	{php}include("adminleftnav.php"){/php}
{/if}


</td>

<td width="1001" valign="top">
{php}include("leads_information/top-tab.php"){/php}

<div style="">
	
	<div style="height:20px;">&nbsp;</div>
	<span class="toggle-btn" onclick="toggle('personal_information')">SHOW / HIDE</span>
	<h2>Information</h2>
	<div class="hiresteps">
<div id="personal_information" style="display:none;">
{include file="leads_info.tpl"}
</div>

</div>

	<span class="toggle-btn" onclick="toggle('recruitment-order')">SHOW / HIDE</span>
	<h2>Recuitment Orders</h2>
	<div class="hiresteps">
		<div id="recruitment-order">
			<div id="comment_div">Hello World</div>
		    <table width="100%" cellspacing="1">
                <tr bgcolor="#90ac24">
                    <td width="28%" align="center"><strong>Service Request</strong></td>
                    <td width="29%" align="center"><strong>Job Title</strong></td>
                    <td width="6%" align="center"><strong>Invoice ID</strong></td>
                    <td width="10%" align="center"><strong>Payment Status</strong></td>
                    <td width="27%" align="center"><strong>View Note Last Added</strong></td>
                </tr>
		        {$recruitment_result}
		        </table>
		</div>
	</div>
	
	<span class="toggle-btn" onclick="toggle('interview-order')">SHOW / HIDE</span>
	<h2>Interview Orders</h2>
	<div class="hiresteps">
		<div id="interview-order">
			
		    <table width="100%" cellspacing="1">
                <tr bgcolor="#90ac24">
                    <td width="28%" align="center"><strong>Service Request</strong></td>
                    <td width="29%" align="center"><strong>Name</strong></td>
                    <td width="6%" align="center"><strong>Invoice ID</strong></td>
                    <td width="10%" align="center"><strong>Payment Status</strong></td>
                    <td width="27%" align="center"><strong>View Note Last Added</strong></td>
                </tr>
		        {$interview_result}
		        </table>
		</div>
	</div>
	
	
	<span class="toggle-btn" onclick="toggle('phone-order')">SHOW / HIDE</span>
	<h2>Phone Orders</h2>
	<div class="hiresteps">
		<div id="phone-order" style="background:#FFFFFF;">
				{$phone_orders}
		</div>
	</div>
	
	<span class="toggle-btn" onclick="toggle('emails_sent')">SHOW / HIDE</span>
	<h2>Emails Sent</h2>
	<div class="hiresteps">
		<div id="emails_sent">
		<div id="comment_div2">Hello World</div>
		 <table width="100%" cellspacing="1">
                <tr bgcolor="#90ac24">
                    
                    <td width="27%" align="center"><strong>Email of Recipient</strong></td>
                    <td width="28%" align="center"><strong>Name of Job Seeker Sent</strong></td>
                    <td width="14%" align="center"><strong>Date Sent</strong></td>
                    <td width="31%" align="center"><strong>Note by BP or Admin</strong></td>
                </tr>
		        {$sent_result}
		        </table>
		</div>
	</div>
</div></td>
</tr>
</table>
{php}include("footer.php"){/php}
</form>
</body>
</html>
