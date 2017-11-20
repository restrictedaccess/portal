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
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Total Shortlisted - {$recruiter_name} - {$type}{if $recruiter_type} - {$recruiter_type}{/if}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
					
						<th width="10%">#</th>
						<th width='50%'>Candidate's Name</th>
						<th width='20%'>Job Order</th>						
						<th width='20%'>Date Shortlisted</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$shortlisted item=candidate name=shortlisted_list}
					<tr>
						<td>{$smarty.foreach.shortlisted_list.iteration}</td>
						<td><a href="/portal/recruiter/staff_information.php?userid={$candidate.userid}&page_type=popup" target="_blank">{$candidate.fullname}</a></td>
						<td>{$candidate.tracking_code}</td>
						<td>{$candidate.date}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		
	</body>
</html>