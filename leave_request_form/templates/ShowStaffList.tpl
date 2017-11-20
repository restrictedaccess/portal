<input  type="hidden" id="a_selected"  />
<div class="status_hdr" >PENDING</div>
<div class="status_list">
<ol>
{section name=j loop=$leave_requests}
	{if $leave_requests[j].leave_status eq 'pending'}
		<li><a id="a_{$leave_requests[j].id}" href="javascript:ShowStaffCalendar({$leave_requests[j].id})"><strong>[{$leave_requests[j].id}]</strong> {$leave_requests[j].fname} {$leave_requests[j].lname}<span>{$leave_requests[j].date_of_leave|date_format:"%b. %e, %Y"}</span></a></li>
	{/if}
{/section}
</ol>
</div>
<div class="status_hdr" >ABSENT</div>
<div class="status_list">
<ol>
{section name=j loop=$leave_requests}
	{if $leave_requests[j].leave_status eq 'absent'}
			<li><a id="a_{$leave_requests[j].id}" href="javascript:ShowStaffCalendar({$leave_requests[j].id})"><strong>[{$leave_requests[j].id}]</strong> {$leave_requests[j].fname} {$leave_requests[j].lname}<span>{$leave_requests[j].date_of_leave|date_format:"%b. %e, %Y"}</span></a></li>
	{/if}
{/section}
</ol>

</div>
<div class="status_hdr" >APPROVED</div>
<div class="status_list">
<ol>
{section name=j loop=$leave_requests}
	{if $leave_requests[j].leave_status eq 'approved'}
			<li><a id="a_{$leave_requests[j].id}" href="javascript:ShowStaffCalendar({$leave_requests[j].id})"><strong>[{$leave_requests[j].id}]</strong> {$leave_requests[j].fname} {$leave_requests[j].lname}<span>{$leave_requests[j].date_of_leave|date_format:"%b. %e, %Y"}</span></a></li>
	{/if}
{/section}
</ol>

</div>
<div class="status_hdr" >DENIED</div>
<div class="status_list">
<ol>
{section name=j loop=$leave_requests}
	{if $leave_requests[j].leave_status eq 'denied'}
		<li><a id="a_{$leave_requests[j].id}" href="javascript:ShowStaffCalendar({$leave_requests[j].id})"><strong>[{$leave_requests[j].id}]</strong> {$leave_requests[j].fname} {$leave_requests[j].lname}<span>{$leave_requests[j].date_of_leave|date_format:"%b. %e, %Y"}</span></a></li>
	{/if}
{/section}
</ol>

</div>

<div class="status_hdr" >CANCELLED</div>
<div class="status_list">
<ol>
{section name=j loop=$leave_requests}
	{if $leave_requests[j].leave_status eq 'cancelled'}
		<li><a id="a_{$leave_requests[j].id}" href="javascript:ShowStaffCalendar({$leave_requests[j].id})"><strong>[{$leave_requests[j].id}]</strong> {$leave_requests[j].fname} {$leave_requests[j].lname}<span>{$leave_requests[j].date_of_leave|date_format:"%b. %e, %Y"}</span></a></li>
	{/if}
{/section}
</ol>

</div>

