<div style="margin-bottom:20px;"><img src="https://remotestaff.com.au/images/remote-staff-logo2.jpg"></div>
<div style="font-family:Verdana, Geneva, sans-serif;">

<p>Dear {$client.fname} {$client.lname}, </p>
<p>Staff {$staff.fname} {$staff.lname} is {if $leave_type eq 'Absent'}Absent{else}on leave.{/if} :



<p><b><u>Details</u></b></p>
<ul>
<li>Leave Type :  {$leave_type} [ {$leave_duration} ]</li>
<li>Reason : {$reason_for_leave}</li>
<li>Dates:
	<ol>
    {foreach from=$DATE_SEARCH item=d name=d}
    	<li>{$d|date_format:"%B %e, %Y %A"}</li>
	{/foreach}
    </ol>
</li>
</ul>


 
<hr />
NOTE :
{$response_note}
</div>

