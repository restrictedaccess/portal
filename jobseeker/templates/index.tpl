<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Jobseeker Portal - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<link rel="stylesheet" href="/portal/jobseeker/js/fileuploader.css"/>
		<script type="text/javascript" src="/portal/jobseeker/js/fileuploader.min.js"></script>
		<script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		{*<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script> - moved to includes.tpl 6/13/13*}
		<script type="text/javascript" src="/portal/jobseeker/js/index.js"></script>
		<script type="text/javascript" src="/portal/site_media/reset_password_first_function.js"></script>
		
	</head>

	<body>
		<input type="hidden" id="base_api_url" value="{$base_api_url}" />
		<input type="hidden" id="jobseeker_date_registered" value="{$user.datecreated}" />
		
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar.tpl"}
				
				<div class="span6" id="main-content-body">
					<div class="row-fluid">
						<form class="well form-search" method="get" action="/portal/jobseeker/jobs.php">
							Search Jobs: <input type="text" name="q" placeholder="Enter job position" class="search-query span8"> <button type="submit" class="btn"><i class="icon-search"></i> Search</button>
						</form>
							
					</div>
					<div class="row-fluid">
						<div class="well">
							<h4>List of Jobs that you Applied and your current Application Status</h4>
						
							{if $remaining_application == 10}
								<div class="alert alert-info">
									You have not applied to any job advertisements. 
								</div>
							{else}
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>Job Position</th>
											<th>Company</th>
											<th>Status</th>
											<th>Date Applied</th>
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
											</tr>
										{/foreach}
									</tbody>
								</table>
							{/if}
							<div class="row-fluid" style="margin-bottom:1em">
								{if $remaining_application == 10}
								{else}
									<a class="btn btn-success pull-left" href="/portal/jobseeker/applications.php">View More Applications...</a>
								{/if}
								<span class="pull-right"><strong>Job Application Left:</strong> {$remaining_application} out of 10</span>
							</div>
						</div>
						
						
						
					</div>
					
					
					<div class="row-fluid" style="background-color:#fafafa;padding:0.5em">
						<div class="well">
							<h4>Tips for a successful job application at Remotestaff</h4>
							<p>Hi {$user.fname},</p>
							<p>You are now only a few steps away from having a professionally rewarding home-based career.</p>
							<p>For your profile to be tagged as &quot;Remote Ready&quot; (ready to work), your profile must at least be 70% filled

								in. This means that your profile will be on our recruitment team's priority list for assessment.</p>
							<p>Here are the following components that we need from you together with their corresponding % points:</p>


							<ol>

								<li>
									<strong>Photo: 25%</strong>
									<p>A professional profile picture will increase your chances of being hired. Got a smartphone? Just
										follow the guidelines below.</p>
									<ul>
										<li>Do wear your best corporate attire.</li>
										<li>Utilize a white or light-colored background against a blank or clear wall.</li>
										<li>Be mindful of your lighting. Remember to highlight, not hide your face.</li>
										<li>If you have to crop, make sure you have ample border space on all sides. We have a
											cropping tool that you can use when you upload your picture.</li>
										<li>Make sure you take and upload a high-quality photo, nothing pixelated.</li>
									</ul>
								</li>
								<li>
									<strong>Voice Recording: 25%</strong>
									<p>Introduce yourself through this recording and showcase your English-speaking skill. Here's a
										template that you can use:</p>

									<p>Hi!</p>
									<p>I have been working since (year) related to (field/job role: Web Development, IT Helpdesk, Data

										Entry, Customer Service, Technical Support, Accounting, Inbound/outbound Telemarketing,

										others) with industries such as __________ (industry: automotive, outsourcing, e-commerce,

										media, advertising, marketing, IT, retail, real estate, others).</p>

									<p>I am proud to say that I am proficient in (mention all important skills/software/tools related to

										your career: Customer handling, Customer satisfaction, PHP, CSS3, HTML5, SEO, SEM, SMM,

										Magento, Joomla, .NET, Payroll, Xero, MYOB, Quickbooks, HR, Audit, Recruitment, Sourcing,

										Appointment Setting, Telemarketing, CMS, CRM, etc.).</p>
									<p>I also have basic knowledge and a background on _________ (mention other

										skills/software/tools related to your career/expertise).</p>
									<p>
										In line with this, I was awarded and/or was commended on (customer satisfaction, attendance,

										quality, top-agent, loyalty, etc. related to field or work experiences).
									</p>
									<p>On the other hand, I enjoy ____________ (Hobbies: singing, dancing, sports, shopping,

										travelling, cooking, etc.) during my free time.</p>
								</li>
								<li>
									<strong>Work Station: 20% (total)</strong>
									<ul>
										<li>Selfie with their home-office station 10%</li>
										<li>Selfie with DSL 10%</li>
									</ul>
								</li>
								<li><strong>Skills : 2% per 5 items/skills indicated</strong></li>
								<li><strong>Work Experience: 5% each</strong>
										<p><strong>*</strong>Note: Responsibilities should be detailed using a minimum of 700 characters excluding spaces
										to get 5 points)</p>
								</li>
								<li><strong>Skills Tests: 2% each</strong></li>
								<p><strong>*</strong>Note: You must get at least 65% and above per test and/or 40wpm and above on the typing
									assessment to get the points)</p>

							</ol>
							<p>
								Should you have any questions, please don’t hesitate to contact us at <a href="mailto:recruiters@remotestaff.com.ph" target="_blank">recruiters@remotestaff.com.ph</a>
							</p>
						</div>


						{*<div class="well">*}
							{*<h4>Tips for a successful job application at Remotestaff</h4>*}
							{*<p>Hi {$user.fname},</p>*}
							{*<p>You are now steps away from having a professional and rewarding career from home.</p>*}
							{*<p>Please note the following:</p>*}
							{*<ol>*}
								{*<li>*}
									{*<strong>Be as detailed as you can with your resume.</strong>This will allow the RemoteStaff recruiter to easily assess your qualification and match you to post matching your skills and background.*}
								{*</li>*}
								{*<li>*}
									{*<p><strong>Attach sample work.</strong> Attaching sample work will speed up your application process as we will be able to assess your talent, skills and sophistication at a first glance. You can attach: sample written materials/content, sample design portfolio, sample source code etc. which ever is relevant to the position you are applying for.</p>*}
									{*<p><em><strong>TELEMARKETERS: </strong>If you are applying for a telemarketing or any phone based position be sure to attach a very good voice recording introducing yourself and summary of your past work experiences. The recording should not be longer than 3 minutes.</em></p>*}
									{*<p>You can also use a spiel or a call flow you are used to as a sample work. Live recording from previous campaigns handled will also be a very good form of work sample.</p>*}
								{*</li>*}
								{*<li>*}
									{*<strong>Upload a voice introduction.</strong> Indicate your name and a quick summary of your work experiences. The voice recording should not last more than 3 minutes and should be in English. We only hire people who can communicate and understand verbal and written English. You don’t need to sound American or Australian or have any specific accent. What is important is to have a clear, easily understood voice with no noise background.*}
								{*</li>*}
								{*<li>*}
									{*<strong>Please read out current contract <a href="http://www.remotestaff.com.au/portal/contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf" target="_blank">HERE</a>.</strong> This will give you a more detailed idea on how RemoteStaff works along with our Rules and Regulations. It is important that you know this from the very beginning.*}
								{*</li>*}
							{*</ol>*}
							{*<p>*}
								{*Should you have any questions, please don’t hesitate to contact us at <a href="mailto:recruiters@remotestaff.com.ph" target="_blank">recruiters@remotestaff.com.ph</a>*}
							{*</p>*}
						{*</div>*}
					</div>
				</div>
				<div class="span3">
					<p class="text-info">We're on Facebook! To get updated with our urgent job openings via Facebook please LIKE US at <a href="https://www.facebook.com/RemoteStaffPhilippines" target="_blank">https://www.facebook.com/RemoteStaffPhilippines</a></p>
					<fb:like-box href="https://www.facebook.com/pages/Remote-Staff-wwwremotestaffcomau/186026291427516" width="361" height="600" show_faces="true" stream="false" header="false"></fb:like-box>
				</div>
			</div>
			{include file="footer.tpl"}
			{include file="photo_uploader.tpl"}
			{include file="voice_uploader.tpl"}
			
		</div>
		
		
		<div class="modal hide fade" id="reset_password_first" role="dialog">
		
			<div class="modal-dialog modal-md center-block">
		
				<div class="modal-content">
		
					<div  class="modal-header">
						<div class="row">
							<div class="span6">
								<img src="/portal/site_media/client_portal/images/rs_logo.png" alt="Remote Staff" height="43" style="margin-top:3px">
								<p class="logo-text">
									Relationships You Can Rely On
									
								</p>
							</div>
							<div class="span6">
								
							</div>
						</div>
						
						
					</div>
		
		
					<div class="modal-body">
						<div class="row-fluid">
							<div class="span12">
								<div id="reset-password-errors" class="form-group alert alert-info" style="color:#000;font-size: 16px;">
									<p>Hi {$user.fname} {$user.lname}</p>
									<br />
									<p>Please reset your password to update and secure your Remotestaff account. Click on the link below to receive the instructions via email.</p>
									
									<br />
									<p>Kind Regards,</p>
									<p>The Remote Staff Inc. Team</p>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							
							<div class="spa6 text-center">
								
								
								<form id="reset-password-first-form" method="post" action="../forgotpass.php">
									<div class="form-group">
										<input id="reset-password-first-email" type="hidden" class="form-control" name="email" placeholder="Email" required="" value="{$user.email}" />
										<input type="hidden" name="user" value="applicant" />
										<input type="hidden" name="task" value="send_email" />
									</div>
									
									<div class="form-group">
										<button type="submit" class="btn btn-lg btn-primary block full-width m-b">Send Request</button>
									</div>
									
								</form>
							</div>
							<div class="span3 text-center">
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
