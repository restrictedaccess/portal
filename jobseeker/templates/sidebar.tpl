<div class="span3">
	<div class="row-fluid container-box resume-status">
		<div class="row-fluid container-box-content">
			<div class="span4 img-control">
				<div class="row-fluid">
					{if $user.image neq "" AND $user.image neq NULL}
						<img src="/portal/{$user.image}" class="img-polaroid"/>				
					{else}
						<img src="images/bigicon-staff.png" class="img-polaroid"/>
					{/if}
					
					
				</div>
				<div class="row-fluid">
					<object type="application/x-shockwave-flash" data="/audio_player/player_mp3_maxi.swf" width="110" height="30">
				        <param name="movie" value="/audio_player/player_mp3_maxi.swf">
				         <param name="FlashVars" value="mp3=/portal/{$user.voice_path}">
				         <param name="wmode" value="opaque">
				    </object>
				</div>
			</div>
			<div class="span8">
				{*<div class="row-fluid remote_ready_progress_container">*}
					{*Temporarily disabled by Josef Balisalisa*}
					{*To avoid complaints by jobseekers that they are already remote ready*}
					{*<div class="progress remote_ready_progress pull-left">*}
						{*<div class="bar" style="width: {$progress}%;"></div>*}
					{*</div>*}
					{*<div class="span1">*}
						{*{$progress}%*}
					{*</div>*}
				{*</div>*}
				{*<div class="row-fluid remote_ready_instruction">*}
					{*{if $next_progress}*}
						{*<span class="label label-info" style="margin-top:-10px;margin-bottom:1em;">Please update the following<br/> to add progress.</span><br/>*}
						{*<strong><a href="{$next_progress.link}" class="{$next_progress.cls}" style="font-size:0.7em"><i class="icon-edit"></i>{$next_progress.label}</a></strong>*}
					{*{else}*}
						{*<span class="label label-success" style="margin-top:-10px">Your jobseeker resume<br/> is now complete.</span>*}
					{*{/if}*}


				{*</div>*}

				<div class="row-fluid container-info">
					<p class="name"><strong>{$user.fname} {$user.lname}</strong></p>
					<p><strong>Latest Job Title:</strong> {$currentjob.latest_job_title}</p>
					<p><strong>Applicant ID:</strong> {$user.userid}</p>
					<p><strong>Date Applied:</strong> {$user.date_created}</p>
					<p style="margin-bottom:1em;"><strong>Last Updated:</strong> {$user.date_updated}</p>
				</div>
			</div>
		</div>
		{*<div class="row-fluid container-info">*}
			{*<p class="name"><strong>{$user.fname} {$user.lname}</strong></p>*}
			{*<p><strong>Latest Job Title:</strong> {$currentjob.latest_job_title}</p>*}
			{*<p><strong>Applicant ID:</strong> {$user.userid}</p>*}
			{*<p><strong>Date Applied:</strong> {$user.date_created}</p>*}
			{*<p style="margin-bottom:1em;"><strong>Last Updated:</strong> {$user.date_updated}</p>*}
		{*</div>*}
		<div class="row-fluid">
			<div class="span6">
				{if $will_redirect_to_new_jobseeker_v2}
					<a class="btn btn-mini span12" href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}">
						<i class="icon-user"></i> Upload Voice
					</a>
				{else}
					<button class="btn btn-mini span12" id="upload_voice" data-userid="{$user.userid}">
						<i class="icon-user"></i> Upload Voice
					</button>
				{/if}
			</div>
			<div class="span6">

				{if $will_redirect_to_new_jobseeker_v2}
					<a class="btn btn-mini span12" href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}">
						<i class="icon-picture"></i> Upload Photo
					</a>
				{else}
					<button class="btn btn-mini span12" id="upload_photo" data-userid="{$user.userid}">
						<i class="icon-picture"></i> Upload Photo
					</button>
				{/if}
			</div>
		</div>

	</div>

	<div class="row-fluid container-box">
		<ul class="nav nav-list" id="nav-list">

			<li class="{$personal_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-user"></i>Personal Information</a>
				{else}
					<a href="/portal/jobseeker/personal_information.php"><i class="icon-user"></i>Personal Information</a>
				{/if}
			</li>
			<li class="{$work_at_home_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Working at Home Capabilities</a>
				{else}
					<a href="/portal/jobseeker/working_at_home_capabilities.php"><i class="icon-headphones"></i>Working at Home Capabilities</a>
				{/if}

			</li>
			<li class="{$educational_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Educational Details</a>
				{else}
					<a href="/portal/jobseeker/educational_details.php"><i class="icon-book"></i>Educational Details</a>
				{/if}

			</li>
			<li class="{$work_experience_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Work Experience and Position Desired</a>
				{else}
					<a href="/portal/jobseeker/work_experience.php"><i class="icon-suitcase"></i>Work Experience and Position Desired</a>
				{/if}
			</li>
			<li class="{$skill_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Skill Details</a>
				{else}
					<a href="/portal/jobseeker/skills.php"><i class="icon-laptop"></i>Skill Details</a>
				{/if}

			</li>
			<li class="{$language_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Language Details</a>
				{else}
					<a href="/portal/jobseeker/languages.php"><i class="icon-globe"></i>Language Details</a>
				{/if}

			</li>
			<li  class="{$file_active}">
				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>Attach Voice Recording, Sample Work and Detailed Resume</a>
				{else}
					<a href="/portal/jobseeker/files.php"><i class="icon-facetime-video"></i>Attach Voice Recording, Sample Work and Detailed Resume</a>
				{/if}

			</li>
			<li class="{$testresult_active}">{* 6/13/13 -msl *}

				{if $will_redirect_to_new_jobseeker_v2}
					<a href="/portal/recruiter_v2/#/jobseeker/profile/{$userid}"><i class="icon-headphones"></i>&radic;&nbsp;Skills Test Result</a>
				{else}
					<a href="/portal/jobseeker/tests_result.php">&radic;&nbsp;Skills Test Result</a>
				{/if}

			</li>

		</ul>
	</div>
	<a href="#" onmouseover="showReportMenu(this, 'left', 21)" onmouseout="mclosetime()" style="margin-top:2em"><small>Bug Report</small></a>
	{*<a href="javascript:popup_win7('/portal/bugreport/index.php?/reportform/popup');" style="margin-top:2em"><small>Report a Bug</small></a>*}
</div>