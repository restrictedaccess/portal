<script type="text/javascript" src="/portal/bugreport/pullmenu.js"></script>
<nav id="main_bar" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/portal/recruiter/recruiter_home.php" style="padding-top:0;padding-bottom:0"><img src="/portal/jobseeker/images/remote-staff-logo.png" alt="Remote Staff Home"/></a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li><a href="/portal/recruiter/recruiter_home.php">Home</a></li>
				{if $admin_status eq "FULL-CONTROL"}
					<li><a href="/portal/adminHome.php">Admin</a></li>
				{/if}
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Recruiter Search <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/portal/recruiter/recruiter_search.php">View All</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED">Unprocessed</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY">Remote Ready</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED">Prescreened</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=INACTIVE">Inactive</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED">Shortlisted</a></li>
					<li><a href="/portal/recruiter/recruiter_search.php?staff_status=ENDORSED">Endorsed</a></li>
					<li><a href="/portal/recruiter/recruiter_staff_manager.php?on_asl=0">Categorized</a></li>

				</ul>
			</li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Reporting<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/portal/recruiter/advertised_list.php">Advertisement</a></li>
					<li><a href="/portal/recruiter/request_for_interview.php">Interview Bookings</a></li>
					<li><a href="/portal/recruiter/request_for_prescreen.php">Request for Pre-Screen</a></li>
					<li><a href="/portal/recruiter/recruiter_job_orders_view_summary.php">Job Order Summary</a></li>
					<li><a href="/portal/recruiter/recruitment_sheet.php">Recruitment Sheet</a></li>
					<li><a href="/portal/recruiter/recruitment_sheet_dashboard.php">Recruitment Dashboard</a></li>
					<li><a href="/portal/recruiter/recruitment_team_shortlists.php">Recruitment Team Shortlists</a></li>
					<li><a href="/portal/recruiter/recruitment_contract_dashboard.php">Recruiter's New Hires</a></li>
					<li><a href="/portal/recruiter/recruiter_test_reports.php">Test Takers</a></li>
					<li><a href="/portal/recruiter/referrals.php">Refer a Friend</a></li>
					<li><a href="/portal/sms/">SMS Logs</a></li>
				</ul>
			</li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Tool<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/portal/candidates/index.php">Create Job Seeker Account</a></li>
					<li><a href="/portal/test_admin/">Generate Test Session</a></li>
					<li><a href="/portal/recruiter/staff_mass_emailing.php">Staff Mass Emailing</a></li>
					<li><a href="javascript: open_calendar(); ">Meeting Calendar</a></li>
					<li><a href="/portal/recruiter/category-management.php">Category Management</a></li>
					<li><a href="/portal/pricing_list/">Job Order Pricing</a></li>
					<li><a href="/portal/skill_task_manager/">Skill and Task Management</a></li>
					<!-- <li><a href="/portal/recruiter/request_for_interview_voucher.php">Voucher Manager</a></li> -->
					<li><a href="/portal/recruiter/send_email_resume.php">Send Email Resume</a></li>
					
				</ul>
			</li>
			<li><a href="/adhoc/django/requested_time_slots_management/" target="_blank">Trial</a></li>
			<!-- <li><a href="/portal/django/subcontractors/subcons/active" target="_blank">List of Subcons</a></li> -->
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Bug Report<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/portal/bugreport/index.php?/reportform/popup" target="_blank">Report a Bug</a></li>
					<li><a href="/portal/bugreport/?/view_myreport" target="_blank">My Bug Report</a></li>
				</ul>
			</li>
		</ul>
		
		<form action="/portal/recruiter_search/recruiter_search.php" method="GET" class="navbar-form navbar-left">
			<div class="form-group">
			<input type="text" class="form-control" placeholder="Search Candidate, Job Order, Leads" name="q" style="width:282px;">
			</div>
				<button class="btn btn-primary" type="submit">Search</button>			
		</form>
		
		<ul class="nav navbar-nav navbar-right">
			<li><a href="#"></a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{$admin.admin_fname} {$admin.admin_lname} <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/portal/rschat.php?portal=1&email={$session_email}&hash={$hash_code}" class="chat_launch">Chat</a></li>
					<li><a href="/portal/bubblehelp/bhelp.php?/create_page/&curl={$help_path}" target="_blank">Help Page</a></li>
					<li><a href="https://dokuwiki.remotestaff.com.au/dokuwiki/doku.php?sectok=14dcf38ef2a8ae387a13d1ca4e620a59&u=user&p=RemotE&do=login&id=start" target="_blank">Wiki</a></li>
					<li><a href="/portal/aclog/" target="_blank">Activity Logger</a></li>
					<li><a href="/portal/logout.php">Logout</a></li>
					
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</nav>
