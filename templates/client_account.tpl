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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<!--<script src="./leads_information/media/js/mmenu.js" type="text/javascript"></script>
<script src="./leads_information/media/js/menuItems.js" type="text/javascript"></script>-->

</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_information.php?id={$leads_id}&lead_status={$lead_status}">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />

<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="quote" id="quote" value="">
<input type="hidden" name="service_agreement" id="service_agreement" value="">
<input type="hidden" name="setup_fee" id="setup_fee" value="">



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

<table width="100%"  cellpadding=0 cellspacing=0 border=0 id="lid" >
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

<td width="1001" valign="top">
{php}include("leads_information/top-tab.php"){/php}
<div style="height:20px;">&nbsp;</div>
<div style="padding:5px;">


<span class="toggle-btn" onclick="toggle('staff')">SHOW / HIDE</span>
<h2>Staff</h2>
<div class="hiresteps">
<div id="staff">
<table  width="100%" cellpadding="3" cellspacing="0">
<tr bgcolor="#333333" >
<td width="3%" style="color:#FFFFFF">#</td>
<td width="3%" >&nbsp;</td>
<td width="20%" style="color:#FFFFFF">Name</td>
<td width="27%" style="color:#FFFFFF">Hire Date</td>
<td width="27%" style="color:#FFFFFF">Designation</td>
<td width="20%" style="color:#FFFFFF">Work Schedule (client time zone)</td>
</tr>

	{section name=j loop=$staff}
		<tr  bgcolor="{cycle values='#EEEEEE,#CCFFCC'}">
		   <td >{$smarty.section.j.iteration} )</td>
		   <td ><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$staff[j].userid}',800,500);" ><img src="http://{$host}/portal/tools/staff_image.php?w=64&id={$staff[j].userid}" /></span></td>
		   <td ><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$staff[j].userid}',800,500);" ><b>{$staff[j].fname} {$staff[j].lname}</b></span></td>
		   <td >{$staff[j].starting_date|date_format:"%A, %B %e, %Y"}</td>
		   <td >{$staff[j].job_designation}<br />
		     Charge out rate : 
		   {if $staff[j].currency_rate eq 'POUND'}
		   	   GBP  �{$staff[j].client_price|number_format:2:".":","}
		   {else}   
		   		{$staff[j].currency_rate}  ${$staff[j].client_price|number_format:2:".":","}
		   {/if}
</td>
<td>{$staff[j].client_start_work_hour_str} => {$staff[j].client_timezone}</td>
		</tr>
	{sectionelse}
	<tr><td colspan="5" align="center"><br><b>no staff members to be shown </b></td></tr>
	{/section}

	</table>

</div>
</div>



<span class="toggle-btn" onclick="toggle('previous_staff')">SHOW / HIDE</span>
<h2>Previous Staff</h2>

<div class="hiresteps">
<div id="previous_staff">
<table  width="100%" cellpadding="3" cellspacing="0">
<tr bgcolor="#333333" >
<td width="3%" style="color:#FFFFFF">#</td>
<td width="3%" >&nbsp;</td>
<td width="20%" style="color:#FFFFFF">Name</td>
<td width="27%" style="color:#FFFFFF">Hire Date</td>
<td width="27%" style="color:#FFFFFF">Designation</td>
<td width="20%" style="color:#FFFFFF">Work Schedule (client time zone)</td>
</tr>
	{section name=j loop=$previous_staff}
		<tr  bgcolor="{cycle values='#EEEEEE,#CCFFCC'}">
		   <td >{$smarty.section.j.iteration} )</td>
		   <td><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$previous_staff[j].userid}',800,500);" ><img src="http://{$host}/portal/tools/staff_image.php?w=64&id={$previous_staff[j].userid}" /></span></td>
		   <td ><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$previous_staff[j].userid}',800,500);" ><b>{$previous_staff[j].fname} {$previous_staff[j].lname}</b></span></td>
		   <td ><em>From</em> <span style="margin-left:5px; margin-right:5px;">{$previous_staff[j].starting_date|date_format:"%b. %e, %Y"}</span> <em>to</em> <span style="color:#FF0000; margin-left:5px;"> 
{if $previous_staff[j].status eq 'resigned'}
{$previous_staff[j].resignation_date|date_format:"%b. %e, %Y"}
{/if}
{if $previous_staff[j].status eq 'terminated'}
{$previous_staff[j].date_terminated|date_format:"%b. %e, %Y"}
{/if}
{if $previous_staff[j].status eq 'deleted'}
  {if $previous_staff[j].date_terminated}
  	{$previous_staff[j].date_terminated|date_format:"%b. %e, %Y"}
  {else}
  	{$previous_staff[j].end_date|date_format:"%b. %e, %Y"}
  {/if}
{/if}



</span><br />
<strong>{$previous_staff[j].status|lower}</strong>
{if $previous_staff[j].reason}
<div style=" font-style:italic; color:#666666; font-size:10px;"><strong style="float:left; margin-right:5px;">{$previous_staff[j].status|upper} :</strong> {$previous_staff[j].reason}</div>
{/if}
</td>
		   <td >{$previous_staff[j].job_designation}<br />Charge out rate : 
		   {if $previous_staff[j].currency_rate eq 'POUND'}
		   	   GBP  �{$previous_staff[j].client_price|number_format:2:".":","}
		   {else}   
		   		{$previous_staff[j].currency_rate}  ${$previous_staff[j].client_price|number_format:2:".":","}
		   {/if}
</td>
<td>{$staff[j].client_start_work_hour_str} => {$staff[j].client_timezone}</td>
		</tr>
	{sectionelse}
	<tr><td colspan="5" align="center"><br><b>no previous_staff members to be shown </b></td></tr>
	{/section}
	</table>

</div>
</div>

<span class="toggle-btn" onclick="toggle('suspended_staff')">SHOW / HIDE</span>
<h2>Suspended Staffs</h2>
<div class="hiresteps">
<div id="suspended_staff">
<table  width="100%" cellpadding="3" cellspacing="0">
<tr bgcolor="#333333" >
<td width="3%" style="color:#FFFFFF">#</td>
<td width="3%" >&nbsp;</td>
<td width="20%" style="color:#FFFFFF">Name</td>
<td width="27%" style="color:#FFFFFF">Hire Date</td>
<td width="27%" style="color:#FFFFFF">Designation</td>
<td width="20%" style="color:#FFFFFF">Work Schedule (client time zone)</td>
</tr>

	{section name=j loop=$suspended_staff}
		<tr  bgcolor="{cycle values='#EEEEEE,#CCFFCC'}">
		   <td >{$smarty.section.j.iteration} )</td>
		   <td ><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$suspended_staff[j].userid}',800,500);" ><img src="http://{$host}/portal/tools/staff_image.php?w=64&id={$suspended_staff[j].userid}" /></span></td>
		   <td ><span style="cursor:pointer; color:#0000FF;" onclick="javascript:popup_win('./recruiter/staff_information.php?userid={$suspended_staff[j].userid}',800,500);" ><b>{$suspended_staff[j].fname} {$suspended_staff[j].lname}</b></span></td>
		   <td >{$suspended_staff[j].starting_date|date_format:"%A, %B %e, %Y"}</td>
		   <td >{$suspended_staff[j].job_designation}<br />
		     Charge out rate : 
		   {if $suspended_staff[j].currency_rate eq 'POUND'}
		   	   GBP  �{$suspended_staff[j].client_price|number_format:2:".":","}
		   {else}   
		   		{$suspended_staff[j].currency_rate}  ${$suspended_staff[j].client_price|number_format:2:".":","}
		   {/if}
</td>
<td>{$suspended_staff[j].client_start_work_hour_str} => {$suspended_staff[j].client_timezone}</td>
		</tr>
	{sectionelse}
	<tr><td colspan="5" align="center"><br><b>no suspended staff members to be shown </b></td></tr>
	{/section}

	</table>

</div>
</div>


</div>
</td>
</tr>
</table>
{php}include("footer.php"){/php}
</form>
</body>
</html>
