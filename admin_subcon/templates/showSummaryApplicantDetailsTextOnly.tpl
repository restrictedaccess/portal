<div>
<img src="http://www.remotestaff.com.au/portal/tools/staff_image2.php?w=138&h=180&id={$userid}" style="float:left; margin-right:10px;" />
<strong>#{$userid} {$name}</strong><br />
{$email}<br />
{$job_designation}<br />
Client : #{$lead.id} {$lead.fname} {$lead.lname}<br />
Prepaid : {$prepaid}<br />
Prepaid Start Date : {$prepaid_start_date}<br />
Staff Monthly Salary : {$staff_currency} {$staff_monthly|number_format:"2, ',', '.'"}<br />
Client Monthly Price : {$currency} {$client_price|number_format:"2, ',', '.'"}
<br clear="all" />
</div>