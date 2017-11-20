<!DOCTYPE html>
<html>
	<head>
		<title>{$title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>

	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">{$title}</h2>
		<div class="pull-right">
			{$prev_page}&nbsp;
			{foreach from=$pages item=page}
				{$page}&nbsp
			{/foreach}
			{$next_page}
		</div>
		<div class="pull-left">
			Showing {$page_start} - {$page_end} of {$total_records} of orders
		</div>
		<table id='contract_list_table'>
			<thead>
				<tr>
					{if $closing neq True}
						<th width="10%">#</th>
						<th width='20%'>Tracking Code</th>
						<th width='20%'>Client</th>
						
						
						<th width='20%'>Position</th>
						<th width='20%'>Job Specification Link</th>
						<th width='10%'>Order Date</th>
					{else}
						<th width="10%">#</th>
						<th width='15%'>Tracking Code</th>
						<th width='20%'>Client</th>
						
						
						<th width='15%'>Position</th>
						<th width='20%'>Job Specification Link</th>
						<th width='10%'>Order Date</th>
						<th width='10%'>Closed Date</th>
						
					{/if}
				</tr>
			</thead>
			<tbody>
				{foreach from=$orders item=order}
					
					
					{if $closing neq True}
					
						<tr>
							<td>
								{$order.count}
							</td>
							<td>
								<div class='staff-name'>{$order.tracking_code}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.client}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.job_title}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.job_specification_link}</div>
							</td>
							
							<td>
								{$order.date_filled_up}
							</td>
						</tr>
					{else}
						<tr>
							<td>
								{$order.count}
							</td>
							<td>
								<div class='staff-name'>{$order.tracking_code}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.client}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.job_title}</div>
							</td>
							<td>
								<div class='staff-name'>{$order.job_specification_link}</div>
							</td>
							
							<td>
								{$order.date_filled_up}
							</td>
							<td>
								{$order.date_closed}
							</td>
							
						</tr>
					{/if}
				{/foreach}
			</tbody>
		</table>
	</body>
</html>