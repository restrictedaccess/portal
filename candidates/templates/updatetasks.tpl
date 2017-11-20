<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Tasks</title>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/updatetasks.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>

		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
	</head>
	<body>

		<div class="container">
			<h2 class="jobseeker-header">Update Task Preference</h2>
			<p>Enter New Task Preference</p>
			<form class="well form-horizontal" method="POST" id="task-form">
				<legend>Add Task</legend>
				<input type="hidden" name="userid" value="{$userid}"/>
				<div class="control-group">
					<label class="control-label">Job Position</label>
					<div class="controls">
						<select name="job_position" id="job_position">
							{$categories}
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Task</label>
					<div class="controls">
						<select name="task_id" disabled="disabled" id="task_id">
							<option value="">Select Task</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Ratings</label>
					<div class="controls">
						<select name="ratings">
							<option value="">Select Ratings</option>
							{foreach from=$ratings_option item=rating}
								<option value="{$rating}">{$rating}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<button id="save_add_more_task" class="btn btn-primary">
					Save and add more task
				</button>
			
			</form>
			
			
			<h4>Applicant's Saved Tasks</h4>
			{foreach from=$sub_categories item=subcategory_task}
			<table width="100%" cellpadding="5" cellspacing="5"  class="table table-striped table-hover">
				<tr><td style='color:#003366;font-weight:bold;text-align:left;' colspan='4'>Tasks for : {$subcategory_task.sub_category_name}</td></tr>
				<tr>
					<td class="td_info td_la" width="60%">Task</td>
					<td class="td_info td_la" width="30%">Rate</td>
					<td width="10%"></td>
				</tr>
				{foreach from=$subcategory_task.tasks item=task}
					<tr>
						<td class="td_info" width="60%">{$task.task_desc}</td>
						<td class="td_info" width="30%">
							<select class="rating-update span2" data-id="{$task.id}" data-userid="{$userid}" data-task_id="{$task.task_id}">
								<option value="">Select Ratings</option>
									{foreach from=$ratings_option item=rating}
										{if $rating eq $task.ratings}
											<option value="{$rating}" selected="">{$rating}</option>
										{else}
											<option value="{$rating}">{$rating}</option>
										{/if}
									{/foreach}
							</select>
						</td>
						<td width="10%">
							<button class="btn btn-danger btn-xs delete-task" data-id="{$task.id}">Delete</button>
						</td>
					</tr>
				{/foreach}
			</table>
			{/foreach}
			
			
		</div>


		

	</body>
</html>
