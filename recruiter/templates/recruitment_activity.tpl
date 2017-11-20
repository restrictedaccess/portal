<!DOCTYPE html>
<html>
	<head>
		<title>{$title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
		{literal}
		<style type="text/css">
			a[data-state=closed]{
				height:1.2em;display:inline-block;overflow:hidden;
			}
			a[data-state=open]{
				height:auto;display:inline-block;overflow:visible;
			}
			
		</style>
		{/literal}
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
			Showing {$page_start} - {$page_end} of {$total_records} candidates
		</div>
		{if $recruiter_id eq "All"}
			<table id='contract_list_table'>
				<thead>
					<tr>
							{if $type neq 'evaluated' and $type neq 'initial_call' and $type neq 'face_to_face'}
								<th width="4%">#</th>
								<th width='20%'>Candidate's Name</th>
								<th width='20%'>Recruiter Assigned</th>
								<th width='20%'>Date Time</th>
								{if $type neq 'assigned'}
								<th width='20%'>Admin</th>
								{else}
								<th width='20%'>Assigned By</th>
								{/if}	
							{elseif $type eq 'evaluated'}	
								<th width="4%">#</th>
								<th width='20%'>Candidate's Name</th>
								<th width='20%'>Recruiter Assigned</th>
								<th width='20%'>Date Time</th>
								{if $type neq 'assigned'}
								<th width='20%'>Admin</th>
								{else}
								<th width='20%'>Assigned By</th>
								{/if}	
								<th width='40%'>Notes</th>
							{else}
								<th width="4%">#</th>
								<th width='20%'>Candidate's Name</th>
								<th width='20%'>Recruiter Assigned</th>
								<th width='20%'>Date Time</th>
								<th width='20%'>Admin</th>
								<th width='40%'>Notes</th>
							{/if}
							
							
							
					</tr>
				</thead>
				<tbody>
					{foreach from=$activities item=activity}
						<tr>
							{if $type neq 'evaluated' and $type neq 'initial_call' and $type neq 'face_to_face'}
							<td>{$activity.count}</td>
							<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
							<td>{$activity.assigned_recruiter}</td>
							<td>{$activity.admin.admin_fname} {$activity.admin.admin_lname}</td>
							<td>{$activity.date}</td>
							{elseif $type eq 'evaluated'}
							<td>{$activity.count}</td>
							<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
							<td>{$activity.assigned_recruiter}</td>
							<td>{$activity.date}</td>
							<td>{$activity.admin.admin_fname} {$activity.admin.admin_lname}</td>
							
							<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup#all_report" class='resume_launcher' data-id="{$activity.id}" data-state="closed">View Notes</a></td>
							
							{else}
							<td>{$activity.count}</td>
							<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
							<td>{$activity.assigned_recruiter}</td>
							<td>{$activity.admin.admin_fname} {$activity.admin.admin_lname}</td>
							<td>{$activity.date}</td>
							<td><a href="#" class='activity_loader' style="height:1em" data-id="{$activity.id}" data-state="closed" data-history="{$activity.history}">{$activity.history}</a></td>
							{/if}
						</tr>
					{/foreach}
				</tbody>
			</table>
		{else}
			<table id='contract_list_table'>
				<thead>
					<tr>
						{if $type neq 'evaluated' and $type neq 'initial_call' and $type neq 'face_to_face'}
							<th width="4%">#</th>
							<th width='25%'>Candidate's Name</th>
							{if $type eq 'assigned'}
								<th width='25%'>Date Time</th>
								<th width='25%'>Assigned By</th>
							{else}
								<th width='40%'>Date Time</th>
							{/if}
						{else}
							<th width="4%">#</th>
							<th width='25%'>Candidate's Name</th>
							<th width='25%'>Date Time</th>
							<th width='40%'>Notes</th>
							
						{/if}
					</tr>
				</thead>
				<tbody>
					{foreach from=$activities item=activity}
						<tr>
							{if $type neq 'evaluated' and $type neq 'initial_call' and $type neq 'face_to_face'}
								<td>{$activity.count}</td>
								<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
								
								<td>{$activity.date}</td>
								{if $type eq 'assigned'}
									<td>{$activity.admin.admin_fname} {$activity.admin.admin_lname}</td>
								{/if}
							{elseif $type eq 'evaluated'}
								<td>{$activity.count}</td>
								<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
								<td>{$activity.date}</td>
								<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup#all_report" class='resume_launcher' data-id="{$activity.id}" data-state="closed">View Notes</a></td>
								
							{else}
								<td>{$activity.count}</td>
								<td><a href="/portal/recruiter/staff_information.php?userid={$activity.userid}&page_type=popup" target="_blank">{$activity.fname} {$activity.lname}</a></td>
								
								<td>{$activity.date}</td>
								<td><a href="#" class='activity_loader' data-id="{$activity.id}" data-state="closed" data-history="{$activity.history}">{$activity.history}</a></td>
								
							{/if}
						</tr>
					{/foreach}
				</tbody>
			</table>
		{/if}
		<script type="text/javascript" src="/portal/js/jquery.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/list_activity.js"></script>
		
	</body>
</html>