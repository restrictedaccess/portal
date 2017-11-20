<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Skills Tests Result - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Tests Result</h2>
						<p class="label label-info">Report of your test and its score.</p>
						
						<h4>Test Taken</h4>
						<table id="applicant_skill_list" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Test Name</th>
									<th>Date Taken</th>
									<th>Score</th>
									<th>Result</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								{if $test_taken|@count > 0}	
									{section name=idx loop=$test_taken}
									<tr>
									<td>{$smarty.section.idx.index+1}</td>
									<td>{$test_taken[idx].assessment_title}</td>
									<td>{$test_taken[idx].test_date}</td>
									<td>{$test_taken[idx].result_score}</td>
									<td>{$test_taken[idx].result_pct}{if $test_taken[idx].assessment_typing == 1 } WPM{else}%{/if}</td>
									<td><a href='{$test_taken[idx].result_url}' target='_blank'>Result details</a></td>
									</tr>
									{/section}
								
								{/if}
							</tbody>
						</table>
									
						
						
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>