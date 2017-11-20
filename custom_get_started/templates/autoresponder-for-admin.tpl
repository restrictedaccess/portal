<div style='font-family: "lucida grande",tahoma,verdana,arial,sans-serif; font-size: 11px;'>

<div style="margin-bottom:20px; padding-left: 15px; padding-right: 15px;">
<img src="https://remotestaff.com.au/remotestaff_2015/img/rs-logo.png">
<p style="font-size: 18px; color: #777; margin: 0px 5px 10px;">Relationships You Can Rely On</p>
</div>


<div style='font-family:Arial, Helvetica, sans-serif; font-size:14px'>
    <p><strong>CUSTOM RECRUITMENT ORDER</strong></p>
	<p>Lead : #{$lead.id} {$lead.fname} {$lead.lname} </p>
	<p>Email : {$lead.email}</p>
	<!-- removed link on job spec form -->
	{*<p>Order ID : <a href='http://{$site}/portal/ShowRecruitmentServiceOrder.php?qk={$qk}&order_id={$leads_invoice_id}'>{$leads_invoice_id}</a></p>*}
	<h4 class="text-center" style="margin-top:30px;"> Job Order Summary </h4>
	<table width="100%" style="margin-bottom:30px; width:100%;"> 
		<thead>
			<tr>
				<th align="center">Tracking code</th>
				<th align="center">Job position</th>
				<th align="center">Level</th>
				<th align="center">No. of staff needed</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$job_order_summary key=k item=job_order name=job_order}
				<tr>
					<td class="text-center">{$job_order.tracking_code}</td>
					<td>{$job_order.job_position}</td>
					<td class="text-center">{$job_order.level}</td>
					<td class="text-center">{$job_order.no_of_staff_needed}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
<br />
<p>Regards , <br />
RemoteStaff <br />
<!-- Australian Toll Free Number : {$contact_numbers.aus_toll_number} <br /> --> <!-- 1300733430 -->
International Clients : <br />
USA Phone: {$contact_numbers.usa_company_number}  <br /> <!-- +1(415) 376 1472 -->
AUS Phone: {$contact_numbers.aus_company_number}  <br /> <!-- +61 (02) 9099 8668 -->
</p>
</div>		 
		 
