<!DOCTYPE html>
<html>
	<head>
		<title>History Changes in the Job Orders</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>

	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">History Changes in the Job Orders</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
						<th width="10%">#</th>
						<th width='10%'>Tracking Code</th>
						<th width='10%'>Lead</th>
						
						<th width='35%'>History</th>
						<th width='15%'>Admin</th>
						<th width='10%'>Date</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$histories item=history name=history_list}
					<tr>
						<td>{$smarty.foreach.history_list.iteration}</td>
						<td>{$history.tracking_code}</td>
						<td>
							{if $history.lead}
								<a href='/portal/leads_information.php?id={$history.lead.id}' target='_blank'>{$history.lead.fname} {$history.lead.lname}</a>
							{/if}
						</td>
						<td>{$history.history}</td>
						<td>{$history.admin.admin_fname} {$history.admin.admin_lname}</td>
						<td>{$history.date}</td>
						
					</tr>
				{/foreach}
			</tbody>
		</table>

		
	</body>
</html>