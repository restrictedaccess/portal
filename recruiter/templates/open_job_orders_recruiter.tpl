<!DOCTYPE html>
<html>
	<head>
		<title>Assigned Open Job Orders - {$recruiter_name}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>

	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Assigned Open Job Orders - {$recruiter_name} {if $recruiter_type} - {$recruiter_type}{/if}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
						<th width="10%">#</th>
						<th width='20%'>Tracking Code</th>
						<th width='15%'>Client</th>
						<th width='15%'>Job Title</th>
						<th width='20%'>Date Ordered</th>
				</tr>
			</thead>
			<tbody>
				
				{foreach from=$orders item=order name=order_list}
					<tr>
						<td>{$smarty.foreach.order_list.iteration}</td>
						<td>{$order.tracking_code}</td>
						<td><a href='/portal/leads_information.php?id={$order.leads_id}' target="_blank">{$order.client}</a>
						<td>{$order.job_title}</td>
						<td>{$order.date_filled_up}</td>							
					</tr>

				{/foreach}
			</tbody>
		</table>

		
	</body>
</html>