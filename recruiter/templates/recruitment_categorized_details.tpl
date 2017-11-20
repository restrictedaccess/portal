<!DOCTYPE html>
<html>
	<head>
		<title>Total Categorized - {$recruiter_name} - {$sub_category_name}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
		
	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Total Categorized - {$recruiter_name} - {$sub_category_name}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
					
						<th width="10%">#</th>
						<th width='50%'>Candidate's Name</th>						
						<th width='20%'>Date Categorized</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$categorized item=candidate name=categorized_list}
					<tr>
						<td valign="top">{$smarty.foreach.categorized_list.iteration}</td>
						<td align="left" valign="top" class="left"><a href="/portal/recruiter/staff_information.php?userid={$candidate.userid}&page_type=popup" target="_blank">{$candidate.fname} {$candidate.lname}</a></td>
						<td valign="top">{$candidate.date}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		
	</body>
</html>