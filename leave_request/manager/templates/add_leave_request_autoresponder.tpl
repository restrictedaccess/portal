<div style="margin-bottom:20px;"><img src="https://remotestaff.com.au/images/remote-staff-logo2.jpg"></div>
<div style="font-family:Verdana, Geneva, sans-serif;">

<p>Dear {$leads_info.fname} {$leads_info.lname}</p>
<p>Your Staff {$staff.fname} [{$subcon.job_designation}] is requesting for leave or absence for :</p>
<ol><strong><u>Requested Dates</u></strong>
{foreach from=$DATE_SEARCH item=d name=d}
    <li>{$d|date_format:"%B %e, %Y %A"}</li>
{/foreach}
</ol>

<p>More Details about this leave request below. </p>
<ul>
<li>Leave Request # :  {$leave_request_id}</li>
<li>Leave Type :  {$leave_type} [ {$leave_duration} ]</li>
<li>Date Requested :  {$date_requested}</li>
<li>Reason for Leave : {$reason_for_leave}</li>
</ul>

<p>&nbsp;</p>
<p>To approve or deny  this leave request, please login to <a href='https://remotestaff.com.au/portal/'>Remotestaff Portal Homepage</a> and click on Staff Leave Request Management sub tab on the lower left hand side of the page. You can also email your feedback regarding this leave request to <a href='mailto:csro@remotestaff.com.au'>CSRO@remotestaff.com.au</a> </p>
<p><strong>Note</strong> that hours not worked will be refunded and credited back to you.  Your staff can offset this hours as well by working extra, let them know if you prefer this. </p>
</div>