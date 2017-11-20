{*
2011-10-28 <Roy Pepito>    
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff { $name } Job Advertisements Applicants</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="#"  onsubmit="return checkFields();">
<input type="hidden" name="id" id="leads_id" value="{ $leads_id }">
<input type="hidden" name="lead_status" id="lead_status" value="{ $lead_status }"/>
{if $page_type eq 'TRUE'}
	{php}include("header.php"){/php}
	
	{if $agent_section neq ''}
		{php}include("BP_header.php"){/php}
	{/if}
	
	{if $admin_section neq ''}
		{php}include("admin_header_menu.php"){/php}
	{/if}
{/if}

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
  <tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td width="220" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
{if $admin_status neq 'HR'}
	{if $page_type eq 'TRUE'}
		<td width="173" valign="top" >
		
			{if $agent_section neq ''}
				{php}include("agentleftnav.php"){/php}
			{/if}
			
			{if $admin_section neq ''}
				{php}include("adminleftnav.php"){/php}
			{/if}
		
		</td>
	{/if}
{/if}
</td>
<td width=100% valign=top >
<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr>
<td>
{php}include("leads_information/top-tab.php"){/php}
</td>
</tr>
<tr><td height="100%" colspan=2 valign="top" >
<!-- Clients Details starts here -->
<span class="toggle-btn" onClick="toggle('personal_information')">SHOW / HIDE</span>
<h2>Information</h2>
<div id="personal_information" style="display:none;">{ $leads_info }</div>
<!-- Clients Details ends here -->
</td>
</tr>
<tr><td width=100% colspan=2 valign="top">
<h2>Applicants</h2>
<div class="hiresteps"><table width=100% cellspacing=1 cellpadding=4 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
    <td width='4%' height="20" align=left><font size='1' color="#FFFFFF"><b>#</b></font></td>
    <td width='11%' align=left><b><font size='1' color="#FFFFFF">Posting Date</font></b></td>
    <td width='18%' align=left><b><font size='1' color="#FFFFFF">Company</font></b></td>
    <td width='19%' align=left><b><font size='1' color="#FFFFFF">Position</font></b></td>
    <td width='8%' align=center><b><font size='1' color="#FFFFFF">Unprocessed</font></b></td>
    <td width='8%' align=center><b><font size='1' color="#FFFFFF">Pre-Screened</font></b></td>
    <td width='7%' align=center><b><font size='1' color="#FFFFFF">Shortlisted</font></b></td>
    <td width='7%' align=center><b><font size='1' color="#FFFFFF">Inactive</font></b></td>
    <td width='6%' align=center><b><font size='1' color="#FFFFFF">Endorsed</font></b></td>
    <td width='6%' align=center><b><font size='1' color="#FFFFFF">On ASL</font></b></td>
</tr>

{ foreach from=$job_advertisement_applicants_set item=ja name=ctr}
<tr bgcolor={ $ja.bgcolor }>
	<td width='4%' height="20" align=left>{ $smarty.foreach.ctr.iteration })</td>
	<td width='11%' align=left><font size='1'>{ $ja.date_created }</font></td>
	<td width='18%' align=left><font size='1'>{ $ja.companyname }</font></td>
	<td width='19%' align=left><font size='1'><a href="./ads2.php?id={ $ja.id }" target="_blank">{ $ja.jobposition }</a></font></td>
	<td width='8%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=unprocessed', 750, 280);">{ $ja.total_number_of_unprocessed }</a></font></td>
	<td width='8%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=prescreened', 750, 280);">{ $ja.total_number_of_pre_screened }</a></font></td>
	<td width='7%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=shortlist', 750, 280);">{ $ja.total_number_of_shortlisted }</a></font></td>
	<td width='7%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=inactive', 750, 280);">{ $ja.total_number_of_inactive_staff }</a></font></td>
	<td width='6%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=endorsement', 750, 280);">{ $ja.total_number_of_endorsed }</a></font></td>
	<td width='6%' align=center><font size='1'><a href='#' onClick="javascript:popup_win('/portal/recruiter/staff_endorsed_on_posting.php?posting_id={$ja.id}&type=asl', 750, 280);">{ $ja.total_number_on_of_asl }</a></font></td>
</tr>
{ /foreach }

</table></div>
</td>
</tr>
</table>
</td>
</tr>
</table>
{if $page_type eq 'TRUE'}
	{php}include("footer.php"){/php}
{/if}

<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>
<script language=javascript src="js/functions.js"></script>
</body>
</html>