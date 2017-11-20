{include file="header.tpl" }

<!-- CONGRATS WRAPPER START -->
<div class="congrats">
	<!-- CONGRATS CONTAINER START -->
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
				<div style="margin: 70px 0px;">
					<h1 class="text-center" style="font-size: 40px; font-weight:700;">Your Job order is now complete, Thank you.</h1>
					<p class="text-justify">You are one step closer to finding the right Remote Staff.  We will soon begin emailing you candidate profiles based on the information you gave us. Your feedback on the candidates we show you will be vital in our finding you the right person. One of our team members will be in touch with you soon to update you on the status of your request and guide you through things.</p>
					<h4 class="text-center" style="margin-top:30px;"> Job Order Summary </h4>
					<table class="table table-striped table-bordered table-hover table-condensed" style="margin-bottom:30px;">
						<thead>
							<tr>
								<th class="text-center">Tracking code</th>
								<th class="text-center">Job position</th>
								<th class="text-center">Level</th>
								<th class="text-center">No. of staff needed</th>
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
					<p class="text-center" style="margin: 20px 0px;">Feel free to call us at <a href="tel:{$contact_numbers.aus_header_trunkline_number}">{$contact_numbers.aus_header_number}</a></p>
					<p class="text-center">We have created a Remote Staff Client account for you.  Your password has been emailed to you. <br/>You may login to check on the progress of your order and book some interviews</p>
					<p class="text-center" style="margin-top: 20px;"><a href="/portal/clientHome.php" class="btn btn-primary btn-lg">Go to Client Home</a> <a href="http://remotestaff.com.au" class="btn btn-primary btn-lg">Go Back to Homepage</a></p>
				</div>
			</div>
		</div>
	</div>
	<!-- CONGRATS CONTAINER END -->
</div>
<!-- CONGRATS WRAPPER END -->

{include file="footer.tpl" }
