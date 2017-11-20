<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Your Applications - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/application.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Applications</h2>
						<div class="alert alert-info">
							<ul>
								<li>
									<strong>Unprocessed</strong> - your resume has not yet been evaluated
								</li>
								<li>
									<strong>Pre-screened</strong> - your resume has been evaluated
								</li>
								<li>
									<strong>Shortlisted</strong> - your resume has been re-evaluated and you will be contacted for an interview soon
								</li>
								<li>
									<strong>Endorsed</strong> - you have been endorsed for the job position
								</li>
								<li>
									<strong>Interview Set</strong> -  you are now invited to an interview
								</li>
								<li>
									<strong>Hired</strong> - you have been hired for the job position
								</li>
								<li>
									<strong>Rejected</strong> - your application was unsuccessful
								</li>
							</ul>
						</div>
						
						<h4>List of Jobs that you Applied and your current Application Status</h4>
						
						{if $remaining_application == 10}
							<div class="alert alert-info">
								You have not applied to any job advertisements. 
							</div>
						{else}
							{if $remaining_application == 0}
							<div class="alert">
								You have reached the maximum allowable application for our job posting. If you want to continue applying, please withdraw some of your applications or email <a href="mailto:recruitment@remotestaff.com.au">recruitment@remotestaff.com.au</a> to be considered for the position you desired.
							</div>
							{/if}
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Job Position</th>
										<th>Company</th>
										<th>Status</th>
										<th>Date Applied</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$applications item=application name=application_list}
										<tr>
											<td>
												{$smarty.foreach.application_list.iteration}.
											</td>
											<td><a href="/portal/Ad.php?id={$application.posting_id}" target="_blank">
												{if $application.ads_title}	
													{$application.ads_title}
												{else}
													{$application.jobposition}
												{/if}	
												</a></td>
											<td>{$application.companyname}</td>
											<td>{$application.status}</td>
											<td>{$application.date_apply}</td>
											<td>
											{if $application.status neq 'Job Advertisement Closed'}
												<a href="/portal/jobseeker/withdraw_application.php?id={$application.application_id}" class="withdraw_job_application btn btn-danger btn-mini">Withdraw Application</a>										
											{else}
												&nbsp;
											{/if}
											</td>	
										</tr>
									{/foreach}
								</tbody>
							</table>
							{/if}
							<div class="row-fluid" style="margin-bottom:1em">
								<a class="btn pull-left btn-success" href="/portal/jobseeker/jobs.php">Search and Apply for Jobs</a>
								<span class="pull-right"><strong>Job Application Left:</strong> {$remaining_application} out of 10</span>
							</div>
						</div>
						
						
						
					</div>
				</div>
				
				{include file="footer.tpl"}
			</div>
		</div>
	</body>
</html>