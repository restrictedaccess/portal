{*
//  2013-10-14  Allanaire Tapion <allan.t@remotestaff.com.au>
//  -   quick css fix

//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
2010-07-10  Normaneil Macutay <normanm@remotestaff.com.au>

2010-10-20	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Steps Taken

2010-11-03	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Message from Leads Tab in the Communication Records , because it is still not finish

2011-01-11 Adding ASL Alert <Roy Pepito>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff {$leads_info.fname|escape} {$leads_info.lname|escape} Leads Information Sheet</title>
<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css"/>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/leads_information.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/example.css">

<link rel=stylesheet type=text/css href="menu.css">

{literal}
	<style type="text/css">
		.ui-widget{
			font-size:12px!important;
		}

	</style>
{/literal}
<!--start: roy-->
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="recruiter/js/custom_booking_leads_information.js"></script>
<!--ended: roy-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
<script language=javascript src="./js/functions.js"></script>
<script language=javascript src="./js/appointment-callendar.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>

<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
<script src="./media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>

<link rel="stylesheet" href="/portal/leads_information/media/css/clientfeedback.css">
<link rel="stylesheet" href="./media/js/tinymce/jscripts/tiny_mce/themes/simple/skins/default/ui.css"></head>
<body style="margin-top:0; margin-left:0">
<form name="form" method="post" enctype="multipart/form-data" action="leads_information.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}#A" accept-charset = "utf-8">
<input type="hidden" name="lead_status" id="lead_status" value="{$lead_status}" />
<input type="hidden" name="leads_id" id="leads_id" value="{$leads_id}" />

<input type="hidden" name="job_order" id="job_order" >
<input type="hidden" name="quote" id="quote" value="">
<input type="hidden" name="service_agreement" id="service_agreement" value="">
<input type="hidden" name="setup_fee" id="setup_fee" value="">
<input type="hidden" name="booking_method" id="booking_method" value="{$book_lead_method}">
<input type="hidden" name="API-URL" id="API-URL" value="{$API_URL}">

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
{$calendar_menu}
<div style="height:20px;">&nbsp;</div>
<div style="padding:10px;">

{if $agent_section eq True}
<span class="toggle-btn" onClick="toggle('navigation_form');">SHOW / HIDE</span>
<h2>Quick Glance</h2>
<div class="hiresteps">


	<div id="navigation_form">

	<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
	{section name=j loop=$leads_list}
	{strip}

	{if $leads_id eq $leads_list[j].id}

	<tr bgcolor="#2c66a5" >
	<td class="slect">{$smarty.section.j.iteration}</td>
	<td class="slect">{$leads_list[j].fname} {$leads_list[j].lname}</td>
	<td class="slect">{$leads_list[j].email}</td>
	<td class="slect">{$leads_list[j].company_name} {$leads_list[j].officenumber} {$leads_list[j].mobile}</td>
	</tr>

	{else}

	<tr bgcolor="#FFFFFF" onClick="javascript:location.href='leads_information.php?id={$leads_list[j].id}&lead_status={$leads_list[j].status}&page_type={$page_type}';">
	<td>{$smarty.section.j.iteration}</td>
	<td>{$leads_list[j].fname} {$leads_list[j].lname}</td>
	<td>{$leads_list[j].email}</td>
	<td>{$leads_list[j].company_name} {$leads_list[j].officenumber} {$leads_list[j].mobile}</td>
	</tr>

	{/if}

	{/strip}
	{/section}
	</table>
	</div>

</div>

<div style="height:20px;">&nbsp;</div>
{/if}

{if $leads_new_info.id}

<div id="per_info">

	<h2 class="inf_select">Information 1</h2>
	<h2><a href="leads_information2.php?id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}">Information 2</a></h2>
	<br clear="all" />
</div>

<div id="personal_information">{include file="leads_info.tpl"}</div>



{else}
<span class="toggle-btn" onClick="toggle('personal_information')">SHOW / HIDE</span>
<h2>Information</h2>
<div class="hiresteps">
<div id="personal_information">{include file="leads_info.tpl"}</div>
</div>

{/if}

<div style="height:20px;">&nbsp;</div>
{if $leads_active_staff_count neq 0}
    <div><span style="color:#FFF; background:#090; font-weight:bold; padding:5px;">{$leads_active_staff_count} Active Staff<small>(s)</small></span></div>
    <br clear="all">
{/if}
<div id="bttn_div" align="center">
{$bttn}
</div>

<div style="clear:both;"></div>
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


<div style="height:20px;">&nbsp;</div>
<span class="toggle-btn" onClick="toggle('lead_activity')">SHOW / HIDE</span>
<h2>Order Activity</h2>
<div class="hiresteps">
<div id="comment_div"></div>
<div id="comment_div2"></div>
	<div id="lead_activity">
		<table width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td valign="top">
				<div class="la_box">
					<div class="la_hdr">Job Specification Forms <small>( Fully filled Custom Recruitment form )</small> </div>
					<div id="filled_jos" class="la_content"></div>
				</div>
				</td>
				<td width="50%" valign="top">
				<div class="la_box">
					<div class="la_hdr">Requested Skill's Assessment</div>
					<div id="requested_skill_assessment" class="la_content">
						<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
							<thead>
							<tr bgcolor='#90ac24'  >
								<td width="20%" align='center'><strong>Date</strong></td>
								<td width="43%" align='center'><strong>Skill</strong></td>
								<td width="37%" align='center'><strong>Candidate</strong></td>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top">
				<div class="la_box">
					<div class="la_hdr">Endorsed Candidates</div>
					<div class="la_content">
					<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
					<tr bgcolor='#90ac24'  >
                        <th width="15%" align='center'><strong>Job Position</strong></th>
                        <th width="10%" align='center'><strong>Date Endorsed</strong></th>
                        <th width="15%" align='center'><strong>Candidate</strong></th>
                        <th width="15%" align='center'><strong>Admin</strong></th>
                        <th width="15%" align='center'><strong>Book Interview</strong></th>
                        <th width="5%" align='center'><strong>Action</strong></th>

					</tr>
					{$endorse_candidates_result}
					</table>
					</div>
                    <input type="button" class="lsb" value="Book Selected Endorse Candidates" onClick="javascript:booking('{$leads_info.email}'); " />
				</div>
				</td>
				<td valign="top">
				<div class="la_box">
					<div class="la_hdr">Request to Interview </div>
					<div class="la_content">
                    <table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
					<tr bgcolor='#90ac24'>
					<th width="15%" align='center'><strong>Booking / Service Type</strong></th>
					<th width="19%" align='center'><strong>Booking Date / Interview Date</strong></th>
					<th width="17%" align='center'><strong>Candidate</strong></th>
					<th width="27%" align='center'><strong>Facilitator / Calendar Schedule</strong></th>
					<th width="22%" align='center'><strong>Request Status / Payment Status</strong></th>
					</tr>
					{$interview_request}
					</table>
					</div>
                    <input type="button" class="lsb" value="Booking Interview on ASL/ Send Resume to this Lead" onClick="javascript:location.href='send-resume-to-leads.php?to={$leads_info.email}'" />
				</div>
				</td>
			</tr>
		</table>
	</div>


</div>

<div class="hiresteps">
<!--<div id="steps_taken">{$stepsTaken}</div>-->

	<table width="100%">
<tr>
<td width="32%" valign="top">
<span class="btn-holder" onClick="self.location='{$create_a_quote}?leads_id={$leads_id}&url={$url}'">Create</span>
<h3>Quote</h3>
<div class="attache">
<ol>
{section name=j loop=$quotes}
{strip}
		<li><input type='checkbox' name='quote_id' value='{$quotes[j].id}' onClick="getValue('quote_id')" > <a href='./pdf_report/quote/?ran={$quotes[j].ran}' target='_blank'>Quote #{$quotes[j].id}</a></li>
{/strip}
{/section}
</ol>
</div></td>
<td width="34%" valign="top">
<span class="btn-holder" onClick="self.location='/portal/django/service_agreement/lead/{$leads_id}'">Create</span>
<h3>Pending Service Agreement</h3>
<div class="attache">
<ol>
{section name=j loop=$service_agreements}
{strip}
	<li>
	<input type='checkbox' name='service_agreement_id' value='{$service_agreements[j].service_agreement_id}' onClick="getValue('service_agreement_id')" >
     <a href='./pdf_report/service_agreement/?ran={$service_agreements[j].ran}' target='_blank'>Service Agreement #{$service_agreements[j].service_agreement_id}</a>
    <small>Reference Quote #{$service_agreements[j].quote_id}</small>
   </li>
{/strip}
{/section}
</ol>
</div></td>
<td width="34%" valign="top"><h3>Accepted Service Agreement</h3>
<div id="service_agreements" class="attache">
<ol></ol>
</div></td>
</tr>
<tr>
<td valign="top"><h3>Credit Card Direct Debit</h3>
<div class="attache">
<input type="checkbox" id='credit_debit_card' name='credit_debit_card' value='{$leads_id}' >Credit Card  Direct Debit Form<br />
<input type="checkbox" id='ezi_debit_form' name='ezi_debit_form' value='{$leads_id}' >EZI Debit Form (For Australian clients only)<br />
</div>
</td>
<td valign="top"><h3>Job Specification Form</h3>
<div class="attache" style="padding:0px; overflow:hidden; height:140px;">
<div style="height:120px; display:block; overflow:auto;">
<table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:#333333 solid 1px;">
<tr>
<td width="5%" >
<input type="checkbox" id='recruitment_job_order_form' name='recruitment_job_order_form' onClick="check_val()" value="" ></td>
<td width="42%" >Custom Recruitment Form</td>
<td width="17%" ><a href="create_and_fill_custom_recruitment_order.php?leads_id={$leads_id}" class="lsb" style="padding:5px;" target="_blank">Create</a></td>

<td width="36%" valign="top"> <small style="color:#999999">Create &amp; Fill-up Job Specification Form in behalf of client</small> </td>
</tr>
</table>
<div style="font-size:11px;">{$jo_filled_forms}</div>
</div>







</div></td>
<td valign="top"><h3>Email Sent by this Lead to Recipient </h3>
  <div class="attache">
	<table width="100%" cellspacing="1" bgcolor="#CCCCCC">
		<tr bgcolor='#90ac24'  >
			<td width="25%" align='center'><strong>Recipient</strong></td>
			<td width="25%" align='center'><strong>Candidate</strong></td>
			<td width="25%" align='center'><strong>Date Sent</strong></td>
			<td width="25%" align='center'><strong>Note</strong></td>
		</tr>
  		{ $sent_result }<!--{$resumes}-->
	</table>
  </div>
</td>
</tr>
</table>
</div>

<span class="toggle-btn" onClick="toggle('action_records')">SHOW / HIDE</span>
<h2><a name="A">Communications Records</a></h2>
<div class="hiresteps">
<div id="action_records">
<div id="action-options">
<table width=100% border=0 cellspacing=1 cellpadding=2>

  <tr>

  <td width="13%">

  <input type="radio" name="action" value="EMAIL" onclick ="showHideActions('EMAIL');"> Email

  <a href="sendemail.php?id=<?php echo $leads_id;?>">

  <img border="0" src="images/email.gif" alt="Email" width="16" height="10">  </a>  </td>

  <td width="12%">

  <input type="radio" name="action" value="CALL" onclick ="showHideActions('CALL');"> Call

  <img src="images/icon-telephone.jpg" alt="Call">  </td>

  <td width="13%">

  <input type="radio" name="action" value="MAIL" onclick ="showHideActions('MAIL');"> Notes

  <img src="images/textfile16.png" alt="Notes" >  </td>

  <td width="20%">

  <input type="radio" name="action" value="MEETING FACE TO FACE" onclick ="showHideActions('MEETING FACE TO FACE');"> Meeting face to face

  <img src="images/icon-person.jpg" alt="Meet personally">  </td>

  <td width="20%">

  <input type="radio" name="action" value="CSR" onclick ="showHideActions('CSR');"> Client Staff Relations

  <img src="images/icon-person.jpg" alt="Meet personally">  </td>

  <td width="18%">
	<input type='hidden' name='leads_email' value='{$leads_info.email}'/>
	<input type='hidden' name='leads_name' value='{$leads_info.fname} {$leads_info.lname}'/>
	<input type="radio" name="action" value="Feedback" onclick ="showHideActions('Feedback');"> Client Feedback Form
	<img src="images/textfile16.png" alt="Feedback Form">
  </td>

  </tr>
  </table>
<div id="action_record"></div>
</div>
<div id="action_history">
<div id='history_edit_div' class='history_edit_div'></div>

<div class="tabber">

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
{if $leads_info.your_questions}
<tr bgcolor='#FFFFFF'>
<td align='center' class='act_td'>{$leads_info.timestamp|date_format:"%B %e, %Y"}</td>
<td align='center' class='act_td'>{$leads_info.timestamp|date_format:"%H:%M:%S %p"}</td>
<td align='center' class='act_td'>MESSAGE FROM LEAD</td>
<td class='act_td'><div>{$leads_info.your_questions|regex_replace:"/[\r\t\n]/":"<br>"}</div></td>
<td align='center' class='act_td'>{$leads_info.fname}</td>
<td align='center' class='act_td $e_d'>&nbsp;</td>
</tr>
{/if}
{include file="leads_message_regular.tpl"}
{$action_history}
</table>
</div>


<div class="tabbertab">
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
{if $leads_info.your_questions}
<tr bgcolor='#FFFFFF'>
<td align='center' class='act_td'>{$leads_info.timestamp|date_format:"%B %e, %Y"}</td>
<td align='center' class='act_td'>{$leads_info.timestamp|date_format:"%H:%M:%S %p"}</td>
<td align='center' class='act_td'>MESSAGE FROM LEAD</td>
<td class='act_td'><div>{$leads_info.your_questions|regex_replace:"/[\r\t\n]/":"<br>"}</div></td>
<td align='center' class='act_td'>{$leads_info.fname}</td>
<td align='center' class='act_td $e_d'>&nbsp;</td>
</tr>
{/if}
{include file="leads_message_regular.tpl"}
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
	<h2>Job Order Notes</h2>
	<div style="width:100%; text-align:right;">
		<i> Please select tracking code before adding note. </i>
		<select id="leads_tracking_code">
			<option value=""></option>
			{foreach from=$leads_job_orders key=k item=leads_job_order}
				<option value="{$leads_job_order}">{$leads_job_order}</option>
			{/foreach}
		</select>
		<button id="add_notes" style="margin:10px;" class="view_hm_notes"> Add Note </button>
	</div>
	<div id="job_order_notes_container">
		{include file="job_order_notes.tpl"}
	</div>
</div>

</div>

<div class="tabber">
<div class="tabbertab">
<h2>Book An Interview Questions</h2>
<div id="question_div">{$question}</div>
</div>
</div>




</div>
</div>
</div>


<span class="toggle-btn" onClick="toggle('history')">SHOW / HIDE</span>
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
<!--ASL ALARM--> <DIV ID='alarm' STYLE='POSITION: Absolute; RIGHT: 5px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'></DIV> <!--ENDED-->
</td>
</tr>
</table>
{if $page_type eq 'TRUE'}
	{php}include("footer.php"){/php}
{/if}
</form>
{ $upload_status }
<!-- add feedback -->
<div id="add-feedback-dialog" style="display: none">
	<p>Please add a feedback about the <strong>Endorsement Rejection</strong> between <strong><span id='feedback_client_name'></span></strong> and <strong><span id='feedback_staff_name'></span></strong>.</p>
	<form class="add_feedback_form">
		<input type="hidden" name="id" id="endorsement_id"/>
		<table border="0" width="100%">
			<tr>
				<td width="10%"><label>Feedback</label></td>
				<td width="90%"><textarea rows="10" name="feedback" style="width:95%"></textarea></td>
			</tr>
		</table>
	</form>
</div>
<div id="details-dialog"></div>
</body>
<script type="text/javascript" src="./leads_information/media/js/order_activity.js"></script>
</html>
