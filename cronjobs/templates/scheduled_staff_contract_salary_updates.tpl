<div style="font-family:'Courier New', Courier, monospace;">
<strong>Executed Scheduled Staff Contract Salary Updates.</strong>
<ul>
    <li>Subcon Id : {$sched.subcontractors_id}</li>
    <li>Client : {$client.fname} {$client.lname}</li>
    <li>Staff : {$staff.fname} {$staff.lname} - {$subcon.job_designation}</li>
    <li>Scheduled by : {$created_by.admin_fname} {$created_by.admin_lname} on <em>{$sched.date_added}</em></li>
</ul>


{ if $recipients }
<hr />
Recipients. For Debugging purpose.
<ol>
{foreach from=$recipients item=recipient name=recipient}
<li>{$recipient}</li>
{/foreach}
</ol>
{ /if }
</div>