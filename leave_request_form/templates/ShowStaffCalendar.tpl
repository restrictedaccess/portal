<div style="clear:both;"></div>
<input type="hidden" name="userid" id="userid" value="{$userid}" />
<input type="hidden" name="comment_by_type" id="comment_by_type" value="{$comment_by_type}" />
<input type="hidden" name="date" id="date" />
<input type="hidden" name="leave_request_id" id="leave_request_id" value="{$leave_request.id}" />


<div style="padding:10px;">

<p><strong style="color:#FF0000;">LEAVE REQUEST #{$leave_request.id}</strong> <br />
<strong>Date Requested</strong> : {$leave_request.date_requested|date_format:"%A, %B %e, %Y %H:%M:%S %p"}</p>

<p><strong><u>Staff</u></strong> :  
 <img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id={$staff.userid}' border='0' align='texttop'  /> #{$staff.userid} {$staff.fname} {$staff.lname}</p>

<p><strong><u>Leave Type</u></strong> : {$leave_request.leave_type}</p>
<p><strong><u>Leave Duration</u></strong> : {$leave_request.leave_duration}</p>
<p><strong><u>Client</u></strong> : #{$leave_request.leads_id} {$leave_request.fname} {$leave_request.lname}</p>


<div><strong><u>Date of Leave</u></strong> : </div>

<table width="100%">
<tr>
<td valign="top" width="59%">
<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
{section name=j loop=$leave_request_dates}

{if $comment_by_type eq 'personal'}
		{if $leave_request_dates[j].status eq 'pending' || $leave_request_dates[j].status eq 'approved'}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" name="dates" value="{$leave_request_dates[j].id}" onclick="GetDateId()" /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			
			</tr>
		{else}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" disabled="disabled" style=" visibility:hidden; background:#CCCCCC;"  /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			</tr>
		{/if}
{/if}        
{if $comment_by_type eq 'leads'}
		{if $leave_request_dates[j].status eq 'pending'}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" name="dates" value="{$leave_request_dates[j].id}" onclick="GetDateId()" /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			
			</tr>
		{else}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" disabled="disabled" style="visibility:hidden; background:#CCCCCC;"  /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			</tr>
		{/if}
{/if}

{if $comment_by_type eq 'client_managers'}
		{if $leave_request_dates[j].status eq 'pending'}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" name="dates" value="{$leave_request_dates[j].id}" onclick="GetDateId()" /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			
			</tr>
		{else}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" disabled="disabled" style="visibility:hidden; background:#CCCCCC;"  /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			</tr>
		{/if}
{/if}

{if $comment_by_type eq 'admin'}
			<tr bgcolor="#FFFFFF">
			<td width="3%"><input type="checkbox" name="dates" value="{$leave_request_dates[j].id}" onclick="GetDateId()" {if $leave_request_dates[j].status neq 'pending'} checked="checked" {/if} /></td>
			<td width="51%">{$leave_request_dates[j].date_of_leave|date_format:"%B %e, %Y => %A"}</td>
			<td width="46%">- <em>{$leave_request_dates[j].status}</em></td>
			</tr>
{/if}



{/section}
</table>
</td>
<td valign="top" width="41%">
<div style="display:block; width:150px;  position:absolute; ">{$calendar}</div>
</td>
</tr>
</table>


<p><strong><u>Reason For Leave</u></strong> : </p>
<div style=" width:450px;">
<p><img src="/portal/leads_information/media/images/quote.png" /><em>{$reason_for_leave|regex_replace:"/[\r\t\n]/":"<br>"}</em> <img src="/portal/leads_information/media/images/quote-end.png" /></p>
</div>



{if $leave_request_history_ctr neq 0}
<strong><u>Comments</u></strong>
<div style="background:#FFFFCC; width:450px; display:block; padding:2px; color:#000000; font-size:11px;">
{$leave_request_history_str}
</div>
{/if}


<div style=" width:450px; padding:2px; background:#EEEEEE;">
<strong>Comment</strong><br />
<textarea id="notes" name="notes"  style="width:445px; height:50px;"></textarea>
<br />

{if $comment_by_type eq 'personal'}
	<input type="button" id="cancel_btn" value="Cancel" onclick="ApproveDenyCancelRequest('cancelled')" />
	<input type="button" id="cancel_all_btn" value="Cancel All" onclick="ApproveDenyCancelAllRequest('cancelled')" />
	<input type="button" value="Close" onclick="ShowStaffAllRequestedLeave()" />
{else}
	<input type="button" id="approve_btn" value="Approve" onclick="ApproveDenyCancelRequest('approved')" />
	<input type="button" id="approve_all_btn" value="Approve All" onclick="ApproveDenyCancelAllRequest('approved')" />
	<input type="button" id="deny_btn" value="Deny" onclick="ApproveDenyCancelRequest('denied')" />
	<input type="button" id="deny_all_btn" value="Deny All" onclick="ApproveDenyCancelAllRequest('denied')" />
	<input type="button" value="Close" onclick="location.href='leave_request_management.php'" />
	<input type="button" id="cancel_btn" value="Cancel" onclick="ApproveDenyCancelRequest('cancelled')" />
{/if}

</div>
</div>