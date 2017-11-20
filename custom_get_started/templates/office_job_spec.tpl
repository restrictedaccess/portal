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
		<div>
			<div class="col-lg-12 col-md-12 col-xs-12">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<b>Rating Scale</b>
					<ol>
						<li>
							No experience
						</li>
						<li>
							Trained, low level experience
						</li>
						<li>
							Sound knowledge, some practical experience
						</li>
						<li>
							Strong working knowledge and understanding
						</li>
						<li>
							Comprehensive understanding, knowledge and proficiency
						</li>
						<li>
							In depth expert knowledge and a high level of proficiency - able to provide specialist advice, insight or technical expertise
						</li>
					</ol>
					{if not $disabled}
					<div>
						{if $has_ad}
						<a class="btn btn-xs btn-primary" href="/portal/ads/?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}&mode=edit&source=rs"><span class="glyphicon glyphicon-edit"></span> Update Advertisement</a>
						{else}
						<a class="btn btn-xs btn-primary" href="/portal/ads/?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}&mode=create&source=rs"><span class="glyphicon glyphicon-refresh"></span> Convert into Advertisement</a>
						{/if}
						<a class="btn btn-xs btn-primary" href="/portal/custom_get_started/edit_job_spec.php?gs_job_titles_details_id={$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span> Edit Job Spec</a>
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
								<button class="btn btn-xs btn-default" id="edit_basic_jo" data-id="{$gs_jtd.gs_job_titles_details_id}"><span class="glyphicon glyphicon-edit"></span> Edit Job Order Details</button>
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
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">General</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'general'}
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
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts/Clerk</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_clerk'}
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
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts Payable</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_payable'}
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
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts Receivable</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_receivable'}
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
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounting Package</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounting_package'}
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
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Bookkeeper</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'bookkeeper'}
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
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Payroll</th>
									<th width="50%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'payroll'}
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
										<li>{$gs_cred.description}</li>
									{/if}
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Other desirable/preferred skills, personal attributes and knowledge
						</div>
						<div class="panel-body">
							<ul>
								{foreach from=$gs_creds item=gs_cred}
									{if $gs_cred.box eq 'other_skills'}
										<li>{$gs_cred.description}</li>
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
							Comments/Special Instruction
						</div>
						<div class="panel-body">
							<ul>
								{foreach from=$gs_creds item=gs_cred}
									{if $gs_cred.box eq 'special_instruction'}
										<li>{$gs_cred.description}</li>
									{/if}
									{if $gs_cred.box eq 'comments'}
										<li>{$gs_cred.description}</li>
									{/if}
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
			{include file="update_js_modal.tpl"}
	</body>
</html>
