<!DOCTYPE html>
<html>
	<head>
		<title>Total Endorsements - {$recruiter_name}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
	{literal}
		<style>
			#contract_list_table td.left, #contract_list_table th.left{
				text-align:left;
			}
			#contract_list_table td.left div.pull-left{
				margin-right:10px;
			}
		</style>
		{/literal}
	</head>
	<body>
		<h2 style="font-size:15px;text-align: center;font-weight: bolder">Total Endorsed Candidates - {$recruiter_name}</h2>
		<small>
					<table id='contract_list_table'>
			<thead>
				<tr>
					
						<th width="3%"></th>
						<th width='40%' class="left">Candidate's Name</th>		
						<th width='35%' class="left">Client</th>
						<th width='15%' class="left">Date Endorsed</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$candidates item=candidate name=endorsement_list}
					<tr>
						<td valign="top">{$smarty.foreach.endorsement_list.iteration}</td>
						<td class="left" valign="top">
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
						
						<td valign="top" class="left">
							{foreach from=$candidate.endorsements item=endorsement}
								<p><a href='/portal/leads_information.php?id={$endorsement.lead_id}' target="_blank">{$endorsement.lead_firstname} {$endorsement.lead_lastname}</a>  {if $endorsement.rejected}<span style="color:#FF0000">[rejected]</span>{/if}</p>
							{/foreach}
						</td>
						<td valign="top" class="left">
							{foreach from=$candidate.endorsements item=endorsement}
								<p>{$endorsement.date_endorsed}</p>	
							{/foreach}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
		</small>


		
	</body>
</html>