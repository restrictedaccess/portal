<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<!-- include files -->
		<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
		<link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
		<link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />
		<link rel="stylesheet" href="/portal/recruiter/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="/portal/custom_get_started/css/job_spec_admin.css" type="text/css"/>

		<script type="text/javascript" src="/portal/custom_get_started/js/jquery-1.7.2.min.js"></script>
		<script src="/portal/custom_get_started/js/bootstrap/js/bootstrap.min.js"></script>
		<script src="/portal/custom_get_started/js/jquery.ba-bbq.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="/portal/custom_get_started/js/modernzr.js"></script>
		<script type="text/javascript" src="/portal/sms/js/ui/minified/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/sms/css/jquery-ui.min.css">
		<script type="text/javascript" src="/portal/custom_get_started/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/custom_get_started/js/handlebars.js"></script>
		<link rel="stylesheet" href="css/index.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="/portal/jobseeker/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/portal/assets/css/loading.css" type="text/css"/>
		<script type="text/javascript" src="/portal/assets/js/jquery.isloading.min.js"></script>
		<script type="text/javascript" src="/portal/assets/js/function.js"></script>
		<script type="text/javascript" src="/portal/custom_get_started/js/job_spec.js"></script>
		<!-- /include files -->
		<title> Job Specification Form - {$gs_jtd.selected_job_title} </title>
	</head>
	<body>
		<div class="col-lg-12">
			<img src="/remotestaff_2015/img/rs-logo.png">
			<p style="font-size: 18px; color: #777; margin: 0px 5px 10px;">Relationships You Can Rely On</p>
		</div>
		<div class="col-lg-12" align="center">
			<div class="page-header">
				<h3><strong>{$gs_jtd.selected_job_title} - {$gs_jtd.level} Level</strong></h3>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="col-lg-6 col-md-6 col-xs-6">
				<b>Required Skill Ratings</b>
				<ul>
					<li>
						Beginner
					</li>
					<li>
						Intermediate
					</li>
					<li>
						Advanced
					</li>
				</ul>
				<b>Required Task Ratings</b>
				<br/>
				From 1 to 10, 10 being the highest in terms of importance.
				{if not $disabled}
				<div>
					
					{if $has_ad}
						<a class="btn btn-xs btn-primary" id="edit-ad" href="/portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span>Update Advertisement</a>
					{else}
						<a class="btn btn-xs btn-primary" id="edit-ad" href="/portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span>Convert into Advertisement</a>
					{/if}
					<input type="hidden" id="gs_job_titles_details_id" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}">
					<!-- <a class="btn btn-xs btn-primary" id="edit-ad" href="/portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span> Edit Advertisement</a> -->
					<!-- <a class="btn btn-xs btn-primary" href="/portal/custom_get_started/edit_job_spec.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span> Edit Job Spec</a> -->
				</div>
				{/if}
				{if $posting}
				<div style="margin-top:10px;">
					<strong style="color:#FF0000">Advertisement Status: <u>{$posting.status}</u></strong>
				</div>
				{/if}
			</div>
			<div class="col-lg-6 col-md-6 col-xs-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Job Order Details
					</div>
					<div class="panel-body">
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Lead</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								#{$gs_jtd.lead.id} - {$gs_jtd.lead.fname} {$gs_jtd.lead.lname}
							</div>
						</div>
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>No. of Staff Needed</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$gs_jtd.no_of_staff_needed}
							</div>
						</div>
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Work Status</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$gs_jtd.work_status} {$price_detail}
							</div>
						</div>
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Work Schedule</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$gs_jtd.start_work} - {$gs_jtd.finish_work} {$gs_jtd.working_timezone}
							</div>
						</div>
						{if $job_spec.details.staff_report_directly eq 'No'}

						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Manager</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$job_spec.details.manager_first_name} {$job_spec.details.manager_last_name}
							</div>
						</div>
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Manager's Email</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$job_spec.details.manager_email}
							</div>
						</div>
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Manager's Contact Number</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								{$job_spec.details.manager_contact_number}
							</div>
						</div>
						{/if}
						{if $has_files}
						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>File Attachment</strong>
							</div>
							<div class="col-lg-8 col-md-8 col-xs-6">
								<a href="/portal/custom_get_started/get_files.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}">Click Here</a>
							</div>
						</div>
						{/if}

						<div class="clearfix">
							<div class="col-lg-4 col-md-4 col-xs-6">
								<strong>Created and Filled Up By</strong>
							</div>
							{if $gs_jrs.filled_up_by_type eq 'leads'}
							<div class="col-lg-8 col-md-8 col-xs-6">
								<span class="label label-info">Lead #{$gs_jrs.filled_up_by.id} - {$gs_jrs.filled_up_by.fname} {$gs_jrs.filled_up_by.lname} on {$gs_jtd.formatted_date_filled_up}</span>
							</div>
							{/if}
							{if $gs_jrs.filled_up_by_type eq 'admin'}
							<div class="col-lg-8 col-md-8 col-xs-6">
								<span class="label label-info">Admin #{$gs_jrs.filled_up_by.id} - {$gs_jrs.filled_up_by.fname} {$gs_jrs.filled_up_by.lname} on {$gs_jtd.formatted_date_filled_up}</span>
							</div>
							{/if}
							{if $gs_jrs.filled_up_by_type eq 'agent'}
							<div class="col-lg-8 col-md-8 col-xs-6">
								<span class="label label-info">BP #{$gs_jrs.filled_up_by.id} - {$gs_jrs.filled_up_by.fname} {$gs_jrs.filled_up_by.lname} on {$gs_jtd.formatted_date_filled_up}</span>
							</div>
							{/if}

						</div>
					</div>
					{if not $disabled}
					<div class="panel-footer">
						<button class="btn btn-xs btn-default" id="edit_basic_jo" data-id="{$gs_jtd.gs_job_titles_details_id}">
							<span class="glyphicon glyphicon-edit"></span> Edit Job Order Details
						</button>
					</div>
					{/if}
				</div>
			</div>
		</div>
		<div class="clearfix">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="page-header">
					<h4><strong>Technical and Non-Technical Requirement</strong></h4>
				</div>
			</div>
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Required Skills
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="50%">Required Skills</th>
								<th width="50%">Ratings</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'skills'}
							<tr>
								<td>{$gs_cred.description}</td>
								<td>{$gs_cred.rating}</td>

							</tr>
							{/if}
							{/foreach}
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Required Tasks
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="50%">Required Tasks</th>
								<th width="50%">Ratings</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'tasks'}
							<tr>
								<td>{$gs_cred.description}</td>
								<td>{$gs_cred.rating}</td>

							</tr>
							{/if}
							{/foreach}
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Duties and Responsibilities
					</div>
					<div class="panel-body">
						<ul>
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'responsibility'}
							<li>
								{$gs_cred.description}
							</li>
							{/if}
							{/foreach}
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Other desirable/preferred skills, personal attributes and knowledge
					</div>
					<div class="panel-body">
						<ul>
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'other_skills'}
							<li>
								{$gs_cred.description}
							</li>
							{/if}
							{/foreach}
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Other Relevant Job Order Information
					</div>
				</div>
				<div class="panel-body">
					<p>
						Will you provide training to the staff?
						{foreach from=$gs_creds item=gs_cred}
						{if $gs_cred.box eq 'staff_provide_training'}
						<strong>{$gs_cred.description}</strong>
						{/if}
						{/foreach}
					</p>
					<p>
						Will the staff need to make calls?
						{foreach from=$gs_creds item=gs_cred}
						{if $gs_cred.box eq 'staff_make_calls'}
						<strong>{$gs_cred.description}</strong>
						{/if}
						{/foreach}
					</p>
					<p>
						Is this the first you are hiring a staff for this position?
						{foreach from=$gs_creds item=gs_cred}
						{if $gs_cred.box eq 'staff_first_time'}
						<strong>{$gs_cred.description}</strong>
						{/if}
						{/foreach}
					</p>
					<p>
						Will the staff report directly to you?
						{foreach from=$gs_creds item=gs_cred}
						{if $gs_cred.box eq 'staff_report_directly'}
						<strong>{$gs_cred.description}</strong>
						{/if}
						{/foreach}
					</p>
					<p>
						<strong>If not, staff will report to:</strong>
					</p>
					<p>
						Manager: {$manager_first_name} {$manager_last_name}
					</p>
					<p>
						Email: {$manager_email}
					</p>
					<p>
						Contact number: {$manager_contact_number}
					</p>

					{if $optional_answer}
					<p>
						<strong>More about these job role(s)</strong>
					</p>
					<ul>
						{if $increase_demand eq 'checked'}
						<li>
							This role needed because of increase demand of your product or services
						</li>
						{/if}
						{if $replacement_post eq 'checked'}
						<li>
							This role a replacement of a post someone is leaving or has already left
						</li>
						{/if}
						{if $support_current eq 'checked'}
						<li>
							This role needed to add support to your current work needs
						</li>
						{/if}
						{if $experiment_role eq 'checked'}
						<li>
							This new role a test, experiment role for your company never before done
						</li>
						{/if}
						{if $meet_new eq 'checked'}
						<li>
							This new role to meet the need of new services, products or capacities in your company
						</li>{/if}

					</ul>
					{/if}
				</div>
			</div>
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Special Instruction
					</div>
					<div class="panel-body">
						<ul>
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'special_instruction'}
							<li>
								{$gs_cred.description}
							</li>
							{/if}
							{/foreach}
						</ul>
					</div>
				</div>
			</div>
		</div>

		{include file="update_js_modal.tpl"}
	</body>
</html>
