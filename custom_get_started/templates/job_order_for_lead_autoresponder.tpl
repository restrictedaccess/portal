<div style='font-family: "lucida grande",tahoma,verdana,arial,sans-serif; font-size: 12px;'>

<div style="margin-bottom:20px; padding-left: 15px; padding-right: 15px;">
<img src="https://remotestaff.com.au/remotestaff_2015/img/rs-logo.png">
<p style="font-size: 18px; color: #777; margin: 0px 5px 10px;">Relationships You Can Rely On</p>
</div>

<p>Hi {$lead.fname}, </p>
<p>Below is the summary of your request and the contact person all throughout the </p>
<p>Recruitment and Hiring process</p>

<p>&nbsp;</p>
<p><strong>CUSTOM RECRUITMENT ORDER</strong></p>
{if $lead.admin_fname and $lead.admin_lname}<p>Hiring Coordinator: {$lead.admin_fname} {$lead.admin_lname} </p> {/if} 
<p>Order Date : {$ATZ|date_format:"%B %e, %Y %I:%M:%S %p"}</p>
<!-- removed link on job spec form -->
{*<p>Job Specification Form  : <a href='http://{$site}/portal/ShowRecruitmentServiceOrder.php?order_id={$leads_invoice_id}'>http://{$site}/portal/ShowRecruitmentServiceOrder.php?order_id={$leads_invoice_id}</a></p>*}
<p>&nbsp;</p>
<p>Regards , <br />
RemoteStaff <br />
<!--Australian Toll Free Number : {$contact_numbers.aus_toll_number} <br /> --> <!-- 1300733430 -->
International Clients : <br />
USA Phone:  {$contact_numbers.usa_company_number}  <br /> <!-- +1(415) 376 1472 -->
AUS Phone:  {$contact_numbers.aus_company_number}  <br /> <!-- +61 (02) 9099 8668 -->
</p>
</div>		 
		 
