{*
2010-07-10  Normaneil Macutay <normanm@remotestaff.com.au>

2010-10-20	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Steps Taken
	
2010-11-03	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Message from Leads Tab in the Communication Records , because it is still not finish
	
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
<script language=javascript src="./js/appointment-callendar.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css">

</head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_information2.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}#A" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />
<input type="hidden" name="leads_new_info_id" id="leads_new_info_id" value="{$leads_new_info.id}" />
<input type="hidden" name="leads_new_info_status" id="leads_new_info_status" value="{$leads_new_info.status}" />
<input type="hidden" id="merge_fields_{$leads_id}" />
<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="quote" id="quote" value="">
<input type="hidden" name="service_agreement" id="service_agreement" value="">
<input type="hidden" name="setup_fee" id="setup_fee" value="">
<input type="hidden" name="booking_method" id="booking_method" value="{$book_lead_method}">
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

<h1>{$leads_new_info.fname|escape} {$leads_new_info.lname|escape} <span class="leads_id">#{$leads_id}</span></h1>

<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
<td width="173" valign="top" >
{if $page_type eq 'TRUE'}
	{if $agent_section eq True}
		{php}include("agentleftnav.php"){/php}
	{/if}
	
	{if $admin_section eq True}
		{php}include("adminleftnav.php"){/php}
	{/if}
{/if}
</td>

<td valign="top">
{php}include("leads_information/top-tab.php"){/php}
<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff style="border:#CCCCCC solid 1px;">
	<tr>
		<td valign="middle" onClick="javascript: window.location='calendar/popup_calendar.php?back_link=1&id={$leads_id}'; " colspan=3 onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">
			<a href="calendar/popup_calendar.php?back_link=1&id={$leads_id}&url={$url}" target="_self"><img src='images/001_44.png' alt='Calendar' align='texttop' border='0'></a><strong>&nbsp;&nbsp;Add New Appointment</strong>
		</td>
	</tr>
</table>
<div style="height:20px;">&nbsp;</div>
<div style="padding:10px;">


{if $separate_mess}
	<div style="background:#FFFF00; padding:3px; text-align:center; font-weight:bold;">{$separate_mess}</div>
{/if}
<a name="P">&nbsp;</a>

<div id="per_info">
	<h2><a href="leads_information.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}">Information 1</a></h2>
	<h2 class="inf_select">Information 2</a></h2>
	<br clear="all" />
</div>
<div id="personal_information">
{if $mode eq 'view'}
	{include file="leads_new_info.tpl"}
{else}
	{include file="leads_new_info_edit.tpl"}
{/if}
</div>




<div style="height:20px;">&nbsp;</div>

{if $mess_sent eq True}
<div class="mess_sent" align="center">Message Sent</div>
{/if}

{if $update_history eq True}
<div class="mess_sent" align="center">Updated Successfully</div>
{/if}

{if $delete_history eq True}
<div class="mess_sent" align="center">Removed Successfully</div>
{/if}

<span class="toggle-btn" onclick="toggle('action_records')">SHOW / HIDE</span>
<h2><a name="A">Communications Records</a></h2>
<div class="hiresteps">
<div id="action_records">
<div id="action-options">
<table width=100% border=0 cellspacing=1 cellpadding=2>

  <tr>

  <td width="22%">

  <input type="radio" name="action" value="EMAIL" onclick ="showHideActions('EMAIL');"> Email

  <a href="sendemail.php?id={$leads_id}">

  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">  </a>  </td>

  <td width="21%">

  <input type="radio" name="action" value="CALL" onclick ="showHideActions('CALL');"> Call 

  <img src="images/icon-telephone.jpg" alt="Call">  </td>

  <td width="21%">

  <input type="radio" name="action" value="MAIL" onclick ="showHideActions('MAIL');"> Notes

  <img src="images/textfile16.png" alt="Notes" >  </td>

  <td width="36%">

  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHideActions('MEETING FACE TO FACE');"> Meeting face to face

  <img src="images/icon-person.jpg" alt="Meet personally">  </td>
  </tr>
  </table>
<div id="action_record"></div>
</div>
<div id="action_history">
<div id='history_edit_div' class='history_edit_div'></div>

<div class="tabber">

<div class="tabbertab tabbertabdefault">
	<h2>Message From lead</h2>
<table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="14%" align='center' class="act_tb_hdr">Date</td>
<td width="10%" align='center' class="act_tb_hdr">Time</td>
<td width="9%" align='center' class="act_tb_hdr">Type</td>
<td width="40%" class="act_tb_hdr">Content</td>
<td width="18%" align='center' class="act_tb_hdr">User</td>
<td width="9%" class="act_tb_hdr">&nbsp;</td>
</tr>

	
	{include file="leads_message_temp.tpl"}
	
	</table>
</div>
	  
<div class="tabbertab">
	  <h2>Business Developer</h2>
	  	  	  <table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="14%" align='center' class="act_tb_hdr">Date</td>
<td width="10%" align='center' class="act_tb_hdr">Time</td>
<td width="9%" align='center' class="act_tb_hdr">Type</td>
<td width="40%" class="act_tb_hdr">Content</td>
<td width="18%" align='center' class="act_tb_hdr">User</td>
<td width="9%" class="act_tb_hdr">&nbsp;</td>
</tr>
{$bp_action_history}
</table>

	
 </div>
 
 <div class="tabbertab">
	  <h2>Admin</h2>
	  	  <table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="14%" align='center' class="act_tb_hdr">Date</td>
<td width="10%" align='center' class="act_tb_hdr">Time</td>
<td width="9%" align='center' class="act_tb_hdr">Type</td>
<td width="40%" class="act_tb_hdr">Content</td>
<td width="18%" align='center' class="act_tb_hdr">User</td>
<td width="9%" class="act_tb_hdr">&nbsp;</td>
</tr>
{$admin_action_history}
</table>


     </div>
	 	  
     <div class="tabbertab">
	  <h2>View All</h2>
	  <table width="100%" cellpadding="2" cellspacing="1" style="background:#CCCCCC;">
<tr >
<td width="14%" align='center' class="act_tb_hdr">Date</td>
<td width="10%" align='center' class="act_tb_hdr">Time</td>
<td width="9%" align='center' class="act_tb_hdr">Type</td>
<td width="40%" class="act_tb_hdr">Content</td>
<td width="18%" align='center' class="act_tb_hdr">User</td>
<td width="9%" class="act_tb_hdr">&nbsp;</td>
</tr>
{include file="leads_message_temp.tpl"}
{$action_history}
</table>

     </div>


</div>

{if $admin_section eq True}
<div class="tabber">
	  <div class="tabbertab">
	  <h2>Book An Interview Questions</h2>
	  <div id="question_div">{$question}</div>
      </div>
</div>	  
{/if}  



</div>
</div>
</div>

<div style="height:20px; ">&nbsp;</div>
<span class="toggle-btn" onclick="toggle('lead_activity')">SHOW / HIDE</span>
<h2>Lead Activity</h2>
<div class="hiresteps">
<div id="comment_div"></div>
<div id="comment_div2"></div>
	<div id="lead_activity">
		<table width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td width="50%" valign="top">
				<div class="la_box">
					<div class="la_hdr">Interview Orders</div>
					<div class="la_content">
					<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
					<tr bgcolor='#90ac24'  >
					<td width="15%" align='center'><strong>Service Type</strong></td>
					<td width="19%" align='center'><strong>Booking Date / Interview Date</strong></td>
					<td width="17%" align='center'><strong>Candidate</strong></td>
					<!--
					<td colspan="2" width="55%">
						<table width="100%">
						<tr>
						<td width="30%" align='center'><strong>Applicant Name</strong></td>
						<td width="25%" align='center'><strong>Recruitment Status</strong></td>
						</tr>
						</table>
					</td>-->
					<td width="27%" align='center'><strong>Facilitator / Calendar Schedule</strong></td>
					<td width="22%" align='center'><strong>Request Status / Payment Status</strong></td>
					</tr>
					{$interview_result2}
					</table>
					
					</div>
				</div>
				
				</td>
				<td width="50%" valign="top">
				<div class="la_box">
					<div class="la_hdr">Recruitment Orders</div>
					<div class="la_content">
					<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
					<tr bgcolor='#90ac24'  >
					<td width="20%" align='center'><strong>Order Date</strong></td>
					<td width="10%" align='center'><strong>Invoice ID</strong></td>
					<td width="15%" align='center'><strong>Payment Status</strong></td>
					<td colspan="2" width="55%" valign="top">
						<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
						<td width="64%" align='center'><strong>Job Position</strong></td>
						<td width="36%" align='center'><strong>Position Status</strong></td>
						</tr>
						</table>
					</td>
					</tr>
					{$recruitment_result2}
					</table>
					</div>
				</div>
				</td>
			</tr>	
			<tr>
				<td width="50%" valign="top">
					<div class="la_box">
						<div class="la_hdr">Request to Screen List</div>
						<div class="la_content">
						<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
						<tr bgcolor='#90ac24'  >
	                    	<td width="20%" align='center'><strong>Date</strong></td>
							<td width="43%" align='center'><strong>Applicant</strong></td>
							<td width="37%" align='center'><strong>Job Position</strong></td>
						</tr>
	                    
	                    {foreach from=$request_screen_list2 item=list name=list}
	                    <tr bgcolor="{cycle values="#FFFFCC,#FFFFEE"}">
	                        <td>{$list.date_created|date_format}</td>
	                        <td><a href="./recruiter/staff_information.php?userid={$list.userid}" target="_blank">{$list.fname} {$list.lname}</a></td>
	                        <td>{$list.sub_category_name}</td>                 
	                    </tr>
	                	{/foreach}
	                    
	                    
	                    
	
						
						</table>
						</div>
					</div>
				</td>
				<td width="50%">&nbsp;</td>
			</tr>
		</table>	
	</div>


</div>










<span class="toggle-btn" onclick="toggle('history')">SHOW / HIDE</span>
<h2>History</h2>
<div class="hiresteps">
<div id="history">
<table width="100%" cellpadding="0" cellspacing="1">
<tr>
<td height="66" valign="top">
{$showLeadsInfoChangesHistory}</td>
</tr></table>
</div>
</div>

</div>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
<DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV>
<div id="support_sound_alert"></div>
<!-- ROY'S CODE -------------------><!-- ALARM BOX -->
</td>
</tr>
</table>
{if $page_type eq 'TRUE'}
	{php}include("footer.php"){/php}
{/if}
</form>
{ $upload_status }
</body>
</html>
