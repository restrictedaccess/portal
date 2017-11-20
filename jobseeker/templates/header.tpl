<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<a class="brand" href="/portal/jobseeker/" style="padding-right:10px;!important"><img src="images/rs-logo.png" alt="Remotestaff"/></a>
		<ul class="nav" style="margin-left:90px">
			<li class="{$home_active}">
				<a href="/portal/jobseeker/">Home</a>
			</li>
			<li class="{$resume_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}">My Resume</a>
				{else}
					<a href="/portal/jobseeker/resume.php">My Resume</a>
				{/if}
			</li>
			<li>{* 2013-06-13 -msl *}
				<a href="javascript:popup_win7('/portal/skills_test/',970,600);">Skills Tests</a>
			</li>
			<li class="{$application_active}">
				<a href="/portal/jobseeker/applications.php">Applications</a>
			</li>
			<li class="{$jobs_active}">
				<a href="/portal/jobseeker/jobs.php">Search Jobs</a>
			</li>
			
			{* 2013-03-25 - hide test as per rica
			<li class="{$take_test_active}">
				<a href="/portal/applicant_test.php">Take a Test</a>
			</li>*}
			<li class="{$referfriend_active}">
				<a href="/portal/jobseeker/refer_a_friend.php">Refer a Friend</a>
			</li>
			<li class="{$promo_active}">
				<a href="/portal/jobseeker/promo_codes.php">Promo Codes</a>
			</li>
			{* 2013-06-13 - hide test as per rica
			<li class="{$bug_active}">
				<a href="javascript:popup_win7('/portal/bugreport/index.php?/view_myreport',950,600);" class="link12b">My Bug Report</a>
			</li>*}
			
			<li class="{$rs_chat_active}">
				<a href="javascript:popup_win7('/portal/rschat.php?portal=1&email={$user.email}&hash={$hash}', 800, 600)">RS Chat</a>
			</li>
		</ul>
		<ul class="nav pull-right">
			<li id="fat-menu" class="dropdown">
				<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">{$user.fname} {$user.lname} <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
					<li>
						<a tabindex="-1" href="/portal/logout.php">Logout</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>