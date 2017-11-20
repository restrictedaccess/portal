<!DOCTYPE html>
<html>
	<head>
		<title>Total Prescreened - {$recruiter_name}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
	{literal}
		<style>
			#contract_list_table td.left{
				text-align:left;
			}
			#contract_list_table td.left div.pull-left{
				margin-right:10px;
			}
		</style>
		{/literal}
	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Total Prescreened Candidates - {$recruiter_name}</h2>
		<table id='contract_list_table'>
			<thead>
				<tr>
					
						<th width="3%"></th>
						<th width='50%'>Candidate's Name</th>						
						<th width='20%'>Date Prescreened</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$candidates item=candidate name=prescreened_list}
					<tr>
						<td>{$smarty.foreach.prescreened_list.iteration}</td>
						<td class="left">
							<div class="pull-left">
								{if $candidate.image}
									<img src="https://remotestaff.com.au/portal/{$candidate.image}" height="40" width="40"/>
								{else}
									<img src="https://remotestaff.com.au/portal/images/Client.png" height="40" width="40"/>
								{/if}
							</div>
							<div class="pull-left">
								<a href="/portal/recruiter/staff_information.php?userid={$candidate.userid}&page_type=popup" target="_blank">{$candidate.fname} {$candidate.lname}</a>
								<br/>UserID: {$candidate.userid}
								<br/>Email: {$candidate.email}
																
							</div>
						</td>
						<td>{$candidate.date_created}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>

		
	</body>
</html>