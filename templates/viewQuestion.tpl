<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Book An Interview Question Member {$question.leads_fname} {$question.leads_lname}</title>
<script language=javascript src="js/MochiKit.js"></script>
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="./leads_information/media/js/leads_information.js"></script>
</head>
<body style="background:#ffffff;font-size:14px; font-family:Arial, Helvetica, sans-serif; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div><img src='./images/remote_staff_logo.png' width='241' height='70'></div>

<p>Member <strong>{$question.leads_fname} {$question.leads_lname}</strong> has  a question/concern about this applicant.</p>
<p>Date : {$question.date_created|date_format:"%B %e, %Y %I:%M:%S %p"}</p>
<table  width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" style="font-size:14px; font-family:Arial, Helvetica, sans-serif;">
    <tr style="background:url(./images/staffbox-hdr-bg.png)repeat-x scroll left top transparent;">
    <td width='25%' valign='top' align="center" style="font-weight:bold; color:#FFFFFF;">Applicant</td>
    <td width='75%' valign='top' align="center" style="font-weight:bold; color:#FFFFFF;">Question</td>
    </tr>


    <tr bgcolor="#FFFFFF">
	<td align="center">
	<img src='http://remotestaff.com.au/available-staff-image.php?w=79&h=80&id={$question.userid}' border='0' align='texttop' />
	<div style="font-size:10px; text-transform:capitalize;">{$question.staff_fname} {$question.staff_lname|substr:0:1}.</div>
	</td>
	<td valign="top" style="line-height:18px; font-style:italic;">{$question.question|regex_replace:"/[\r\t\n]/":"<br>"}</td>
	</tr>
</table>
<p>
{if $question.status eq 'unread'}
<input type="button" value="Confirm" onclick="UpdateQuestionStatus('read', {$question.id})"  />
{else}
<input type="button" value="Marked as Unread" onclick="UpdateQuestionStatus('unread', {$question.id})"  />
{/if}
<input type="button" value="Close" onclick="window.close()" />
</p>
<hr />
<ol>
{foreach from=$histories item=history name=history}
<li>{$history.change_by} => {$history.changes} <span style="margin-left:10px; font-size:10px; color:#999999;">{$history.date_changed|date_format:"%B %e, %Y %I:%M:%S %p"}</span></li>
{/foreach}
</ol>
</body>
</html>