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
		<script type="text/javascript" src="/portal/jobseeker/js/updatelanguageinfo.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						
						<form class="well form-search" method="get" action="/portal/jobseeker/jobs.php">
							Search Jobs: <input type="text" name="q" class="search-query span8" value="{$q}" placeholder="Enter job position"> <button type="submit" class="btn"><i class="icon-search"></i> Search</button>
						</form>
							
						<h2 class="jobseeker-header">Job Advertisements</h2>
												
							<table class="table table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Job Position</th>
										<th>Company</th>
										<th>Outsourcing Model</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									{foreach from=$jobs item=job name=job_list}
										<tr>
											<td>
												{$smarty.foreach.job_list.iteration}.
											</td>
											<td><a href="/portal/Ad.php?id={$job.id}" target="_blank">
												{if $job.ads_title}	
													{$job.ads_title}
												{else}
													{$job.jobposition}
												{/if}
												</a></td>
											<td>{$job.companyname}</td>
											<td>{$job.outsourcing_model}</td>
											<td>{$job.date_created}</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
							<div class="row-fluid" style="margin-bottom:1em">
								<div class="pagination">
								  <ul>
								  	{if $prev_page neq ""}
								    	<li><a href="{$prev_page}">Prev</a></li>
								    {/if}
								    {foreach from=$pagination item=page}
								    	{if $currentpage eq $page.label}
								    		<li class='active'><a href="{$page.url}">{$page.label}</a></li>
								    	{else}
								    		<li><a href="{$page.url}">{$page.label}</a></li>
								    	{/if} 
								    {/foreach}
								  	{if $next_page neq ""}
								    	<li><a href="{$next_page}">Next</a></li>
								    {/if}								    
								    
								  </ul>
								</div>
							</div>
						</div>
						
						
						
					</div>
				</div>
				
				{include file="footer.tpl"}
			</div>
		</div>
	</body>
</html>