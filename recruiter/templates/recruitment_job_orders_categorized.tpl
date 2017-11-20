<!DOCTYPE html>
<html>
	<head>
		<title>Job Orders - {$subcategory.sub_category_name}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>

	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Job Orders - {$subcategory.sub_category_name}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
						<th width="5%">#</th>
						<th width='20%'>Tracking Code</th>
						<th width='15%'>Client</th>
						<th width='15%'>Job Title</th>
						<th width='14%'>Date Ordered</th>
						<th width='15%'>Date Closed</th>
						<th width='10%'>Number of Days</th>
						
				</tr>
			</thead>
			<tbody>
				
				{foreach from=$job_orders item=order name=order_list}
					<tr>
						<td>{$smarty.foreach.order_list.iteration}</td>
						<td>{$order.tracking_code}</td>
						<td><a href='/portal/leads_information.php?id={$order.leads_id}' target="_blank">{$order.client}</a>
						<td>{$order.job_title}</td>
						<td>{$order.date_filled_up}</td>
						<td>{$order.date_closed}</td>
						<td>{$order.number_of_days}</td>
					</tr>

				{/foreach}
				<tr>
					<td colspan="6">&nbsp</td>
					<td>Total Days: {$total_days} days</td>
				</tr>
			</tbody>
		</table>

		
	</body>
</html>