<!DOCTYPE html>
<html>
	<head>
		<title>{$title}</title>

		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>

	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">{$title}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
					<th>#</th>
					<th width='20%'>Staff Name</th>
					<th width='20%'>Client's Name</th>
					<th width='20%'>Service Type</th>
					<th width='30%'>Length of Contract / Status</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$contracts item=contract_item}
					<tr>
						<td>{$contract_item.count}</td>
						<td><div class='staff-name'><a href='/portal/recruiter/staff_information.php?userid={$contract_item.staff.userid}'>{$contract_item.staff.fname} {$contract_item.staff.lname}</a></div></td>
						<td><div class='staff-name'><a href='/portal/leads_information.php?id={$contract_item.lead.id}'>{$contract_item.lead.fname} {$contract_item.lead.lname}</a></div></td>
						<td><div class='staff-name'>{$contract_item.service_type}</div></td>
						<td>
							<div class="status">
								{if $contract_item.end_label eq "" }
									{$contract_item.start_date}<br/>
								{else}
									{$contract_item.start_date} - {$contract_item.end_date}<br/>
								{/if}
								{$contract_item.contract_length} days<br/>
								<strong style='color:#ff0000'>{$contract_item.status}</strong>
							</div>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</body>
</html>