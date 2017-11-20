{*
2010-01-11  Normaneil Macutay <normanm@remotestaff.com.au>
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Remotestaff #{$staff.userid} {$staff.fname} {$staff.lname} </title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="./media/css/leave_request.css">
<script type="text/javascript" src="../js/MochiKit.js"></script>
<script type="text/javascript" src="media/js/leave_request_form.js"></script>
</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div><img src="../images/remote-staff-logo.jpg" /></div>
<table width="100%" bgcolor="#CCCCCC" cellpadding="2" cellspacing="1">


<tr bgcolor="#FFFFFF">
<td width="32%"><strong>Full Name</strong></td>
<td width="68%">#{$staff.userid} {$staff.fname} {$staff.lname}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Email</strong></td>
<td>{$staff.email}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Request ID</strong></td>
<td>{$leave_request.id}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Status</strong></td>
<td><b>
				{if $leave_request.leave_status eq 'pending'}
					<span style="background:#FFFF00;">Pending</span>
				{/if}	
				{if $leave_request.leave_status  eq 'approved'}	
					<span style="background:#00FF00;">Approved</span>
				{/if}	
				{if $leave_request.leave_status eq 'denied'}	
					<span style="background:#FF0000;">Denied</span>
				{/if}
</b>
</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Leave Type</strong></td>
<td>{$leave_request.leave_type}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Date of Leave or Absence</strong></td>
<td>{$leave_request.date_of_leave|date_format:"%A, %B %e, %Y"}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top"><strong>Reason for Leave</strong></td>
<td valign="top">{$leave_request.reason_for_leave|regex_replace:"/[\r\t\n]/":"<br>"}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td valign="top">&nbsp;</td>
<td valign="top">&nbsp;</td>
</tr>

<tr bgcolor="#FFFFFF">
<td><strong>Date Filed</strong></td>
<td>{$leave_request.date_requested|date_format:"%A, %B %e, %Y %H:%M:%S %p"}</td>
</tr>

<tr bgcolor="#FFFFFF">
<td width="32%"><strong>Requested to Client</strong></td>
<td width="68%">#{$lead.id} {$lead.fname} {$lead.lname} [ {$lead.email} ]</td>
</tr>

{if $comment_by_type neq 'staff'}
		{if $leave_request.leave_status eq 'pending'}
		
		<tr bgcolor="#FFFFCC">
		<td colspan="2">
		<strong>Note</strong>
		<div align="center">
		<textarea name="response_note" id="response_note" style="width:95%; overflow-y:scroll;"  rows="5"></textarea><br />
		<input type="button" id="approved_btn" value="Approve" onclick="UpdateStaffLeaveRequest({$leave_request.id} , 'approved')" /> <input type="button" id="denied_btn" value="Deny" onclick="UpdateStaffLeaveRequest({$leave_request.id} , 'denied')" /> <span id="update_result"></span>
		</div>
		</td>
		</tr>
		{else}
		<tr bgcolor="#FFFFCC">
		<td colspan="2">
		<strong>Note</strong>
		<div class="response_note">
			<div>{$leave_request.response_note|regex_replace:"/[\r\t\n]/":"<br>"}</div>
			{if $response_by}<div style="color:#999999; font-weight:bold;">- {$leave_request.leave_status|capitalize} by {$response_by|capitalize} {$leave_request.response_date|date_format:"%A, %B %e, %Y %H:%M:%S %p"}</div>{/if}
		</div>
		</td>
		</tr>

		
		{/if}

{else}
<!-- Staff view-->
<tr bgcolor="#FFFFCC">
<td colspan="2">
<strong>Note</strong>
		<div class="response_note">
			<div>{$leave_request.response_note|regex_replace:"/[\r\t\n]/":"<br>"}</div>
			{if $response_by}<div style="color:#999999; font-weight:bold;">- {$leave_request.leave_status|capitalize} by {$response_by|capitalize} {$leave_request.response_date|date_format:"%A, %B %e, %Y %H:%M:%S %p"}</div>{/if}
		</div>
</td>
</tr>

{/if}	


</table>
</body>
</html>
