<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Your Resume - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/personal_info.js"></script>
		<link rel="stylesheet" href="/portal/jobseeker/css/resume.css"/>
	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<div class="well">
							<div class="row-fluid">
								<div class="span9">
									<div class="row-fluid">
										<h3>{$user.lname}, {$user.fname} {$user.middle_name}</h3>
										<p>
											<small><em><strong>Updated:</strong> {$user.datelastupdated} <strong>Date Applied:</strong>{$user.dateapplied}</em></small>
										</p>
										<p class="compressed">
											<small>{$user.address1} {$user.address2}</small>
										</p>
										<p class="compressed">
											<small>{$user.city} {$user.postcode}, {$user.state}, {$user.country}</small>
										</p>
										<p class="compressed">
											<small><strong>Email: </strong><a href="mailto:{$user.email}">{$user.email}</a> <strong>Mobile: </strong>{$user.handphone_country_code} - {$user.handphone_no}</small>
										</p>

									</div>
									<div class="row-fluid first_group">
										<legend>
											Resume Summary
										</legend>
										<div class="span12">
											<small>
												<div class="row-fluid">
													<div class="span4">
														<strong>Current Job Title</strong>
													</div>
													<div class="span8">
														{$user.currentjob.latest_job_title}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Current Status</strong>
													</div>
													<div class="span8">
														{$user.currentjob.current_status}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Availability</strong>
													</div>
													<div class="span8">
														{$user.currentjob.available_status}
													</div>
												</div>
												
												
												<div class="row-fluid">
													<div class="span4">
														<strong>Highest Education</strong>
													</div>
													<div class="span8">
														{$user.education.educationallevel}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Expected Salary</strong>
													</div>
													<div class="span8">
														{$user.currentjob.expected_salary} {$user.currentjob.salary_currency}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Position First Choice</strong>
													</div>
													<div class="span8">
														{$user.currentjob.position_first_choice}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Position Second Choice</strong>
													</div>
													<div class="span8">
														{$user.currentjob.position_second_choice}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Position Third Choice</strong>
													</div>
													<div class="span8">
														{$user.currentjob.position_third_choice}
													</div>
												</div>
												
												 </small>

										</div>

									</div>
									<div class="row-fluid first_group">
										<legend>
											Personal Information
										</legend>
										<div class="span12">
											<small>
												<div class="row-fluid">
													<div class="span4">
														<strong>Nickname</strong>
													</div>
													<div class="span8">
														{$user.nick_name}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Gender</strong>
													</div>
													<div class="span8">
														{$user.gender}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Date of Birth</strong>
													</div>
													<div class="span8">
														{$user.birth_date}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Marital Status</strong>
													</div>
													<div class="span8">
														{$user.marital_status}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Number of Kids(if any)</strong>
													</div>
													<div class="span8">
														{if $user.no_of_kids eq "" || $user.no_of_kids eq 0}
														N/A
														{else}
														{$user.no_of_kids}
														{/if}
													</div>
												</div> {if $user.gender eq "Female"}
												<div class="row-fluid">
													<div class="span4">
														<strong>Pregnant</strong>
													</div>
													<div class="span8">
														{$user.pregnant}

													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Date of Delivery</strong>
													</div>
													<div class="span8">
														{if $user.no_of_kids eq "" || $user.no_of_kids eq 0}
														N/A
														{else}
														{$user.no_of_kids}
														{/if}
													</div>
												</div> {/if}
												<div class="row-fluid">
													<div class="span4">
														<strong>Nationality</strong>
													</div>
													<div class="span8">
														{$user.nationality}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Permanent Residence</strong>
													</div>
													<div class="span8">
														{$user.permanent_residence}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Pending Visa Application</strong>
													</div>
													<div class="span8">
														{$user.pending_visa_application}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Has Active Visa in US, Australia, UK, Dubai?</strong>
													</div>
													<div class="span8">
														{$user.active_visa}
													</div>
												</div> </small>

										</div>

									</div>
									<div class="row-fluid first_group">
										<legend>
											Contact Information
										</legend>
										<div class="span12">
											<small>
												<div class="row-fluid">
													<div class="span4">
														<strong>Alternative Email</strong>
													</div>
													<div class="span8">
														{$user.alt_email}
													</div>

												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Mobile Number</strong>
													</div>
													<div class="span8">
														{$user.handphone_country_code} - {$user.handphone_no}
													</div>

												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Telephone Number</strong>
													</div>
													<div class="span8">
														{$user.tel_area_code} - {$user.tel_no}
													</div>

												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Address</strong>
													</div>
													<div class="span8">
														<p class="compressed">
															{$user.address1} {$user.address2}
														</p>
														<p class="compressed">
															{$user.city} {$user.postcode}, {$user.state}, {$user.country}
														</p>
													</div>

												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>MSN ID</strong>
													</div>
													<div class="span8">
														{$user.msn_id}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Yahoo Messenger ID</strong>
													</div>
													<div class="span8">
														{$user.yahoo_id}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Facebook / Twitter Account</strong>
													</div>
													<div class="span8">
														{$user.icq_id}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Linked In Account</strong>
													</div>
													<div class="span8">
														{$user.linked_in}
													</div>
												</div>
												<div class="row-fluid">
													<div class="row-fluid">
														<div class="span4">
															<strong>Skype ID</strong>
														</div>
														<div class="span8">
															{$user.skype_id}
														</div>
													</div>
												</div> </small>
										</div>
									</div>
									<div class="row-fluid first_group">
										<legend>
											Working at Home Capabilities
										</legend>
										<div class="span12">
											<small>
												<div class="row-fluid">
													<div class="span4">
														<strong>Have worked from Home</strong>
													</div>
													<div class="span8">
														{$user.work_from_home_before}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Has baby in house</strong>
													</div>
													<div class="span8">
														{$user.has_baby}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>If yes, the main caregiver is</strong>
													</div>
													<div class="span8">
														{$user.main_caregiver}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Reason to work at Home</strong>
													</div>
													<div class="span8">
														{$user.reason_to_wfh}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Working duration with Remotestaff</strong>
													</div>
													<div class="span8">
														{$user.timespan}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Working Environment</strong>
													</div>
													<div class="span8">
														{$user.home_working_environment}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Internet Connection</strong>
													</div>
													<div class="span8">
														{$user.isp}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Other Internet Connection</strong>
													</div>
													<div class="span8">
														{$user.internet_connection_others}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Other Plan and Package</strong>
													</div>
													<div class="span8">
														{$user.internet_connection}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>What is possible and what is not possible about {$pronoun} internet connection from home?</strong>
													</div>
													<div class="span8">
														{$user.internet_consequences}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Speed Test Result Link</strong>
													</div>
													<div class="span8">
														{$user.speed_test}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Computer Hardware/s</strong>
													</div>
													<div class="span8">
														{$user.hardwares}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Noise Level</strong>
													</div>
													<div class="span8">
														{$user.noise}
													</div>
												</div> </small>
										</div>

									</div>
									<div class="row-fluid first_group">
										<legend>
											Highest Qualification
										</legend>
										<div class="span12">
											<small>
												<div class="row-fluid">
													<div class="span4">
														<strong>Level</strong>
													</div>
													<div class="span8">
														{$user.education.educationallevel}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Field of Study</strong>
													</div>
													<div class="span8">
														{$user.education.fieldstudy}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Major</strong>
													</div>
													<div class="span8">
														{$user.education.major}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Institute / University</strong>
													</div>
													<div class="span8">
														{$user.education.college_name}
													</div>
												</div>
												<div class="row-fluid">
													<div class="span4">
														<strong>Located In</strong>
													</div>
													<div class="span3">
														{$user.education.college_country}
													</div>
													<div class="span2">
														<strong>Graduation Date:</strong>

													</div>
													<div class="span3">
														{$user.education.graduation}
													</div>

												</div> 
												<div class="row-fluid">
													<div class="span4">
														<strong>Grade</strong>
													</div>
													<div class="span3">
														{$user.education.grade}
													</div>
													<div class="span2">
														<strong>GPA:</strong>

													</div>
													<div class="span3">
														{$user.education.gpascore}
													</div>

												</div> 
												<div class="row-fluid">
													<div class="span4">
														<strong>Training and Seminars</strong>
													</div>
													<div class="span8">
														{$user.education.trainings_seminars}
													</div>
													
												</div> 
																								
												
												</small>
										</div>
									</div>
									
									<div class="row-fluid first_group">
										<legend>
											Employment Background
										</legend>
										<div class="span12">
											<small>
												{foreach from=$user.jobs item=job name=joblist}
													<div class="row-fluid">
														<div class="span4">
															{$smarty.foreach.joblist.iteration}. <strong>Company</strong>
														</div>
														<div class="span8">
															{$job.companyname}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Position/Title</strong>
														</div>
														<div class="span8">
															{$job.position}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Employment Period</strong>
														</div>
														<div class="span8">
															{$job.monthfrom} {$job.yearfrom} to {$job.monthto} {$job.yearto}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Duties/Responsibilities</strong>
														</div>
														<div class="span8">
															{$job.duties} 
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Work Setup</strong>
														</div>
														<div class="span8">
															{$job.job_industry.work_setup_type} 
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Industry</strong>
														</div>
														<div class="span8">
															{$job.job_industry.industry} 
														</div>
													</div>
													{if $job.job_industry.industry_id eq 10}
														<div class="row-fluid">
															<div class="span4">
																&nbsp;&nbsp;&nbsp;<strong>Campaign</strong>
															</div>
															<div class="span8">
																{$job.job_industry.campaign} 
															</div>
														</div>
													{/if} 
													
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Starting Salary Grade</strong>
														</div>
														<div class="span8">
															{$job.salary_grade.starting_grade} 
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Ending Salary Grade</strong>
														</div>
														<div class="span8">
															{$job.salary_grade.ending_grade} 
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Benefits</strong>
														</div>
														<div class="span8">
															{$job.salary_grade.benefits} 
														</div>
													</div>
													
													
												{/foreach}
											</small>
										</div>
									</div>
									<div class="row-fluid first_group">
										<legend>
											Character Reference
										</legend>
										<div class="span12">
											<small>
												{foreach from=$user.character_references item=character_reference name=character_reference_list}
													<div class="row-fluid">
														<div class="span4">
															{$smarty.foreach.character_reference_list.iteration}. <strong>Name</strong>
														</div>
														<div class="span8">
															{$character_reference.name}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Contact Details</strong>
														</div>
														<div class="span8">
															{$character_reference.contact_details}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Contact Number</strong>
														</div>
														<div class="span8">
															{$character_reference.contact_number}
														</div>
													</div>
													<div class="row-fluid">
														<div class="span4">
															&nbsp;&nbsp;&nbsp;<strong>Email Address</strong>
														</div>
														<div class="span8">
															{$character_reference.email_address}
														</div>
													</div>
													
													
												{/foreach}
											</small>
										</div>
									</div>
									
									<div class="row-fluid first_group">
										<legend>
											Languages
										</legend>
										<div class="pull-right">
											<strong><small>Proficiency (0 - Poor to 10 - Excellent)</small></strong>
										</div>
										<div class="span12">
											<small>
												<table class="table">
													<thead>
														<tr>
															<th>#</th>
															<th>Language</th>
															<th>Spoken</th>
															<th>Written</th>
														</tr>
													</thead>
													<tbody>
														{foreach from=$user.languages item=language name=language_list}
															<tr>
																<td>{$smarty.foreach.language_list.iteration}</td>
																<td>{$language.language}</td>
																<td>{$language.spoken}</td>
																<td>{$language.written}</td>
															</tr>
														{/foreach}
													</tbody>
												</table>
											</small>
										</div>
									</div>
									
									<div class="row-fluid first_group">
										<legend>
											Skills
										</legend>
										<div class="span12">
											<small>
												<table class="table">
													<thead>
														<tr>
															<th>#</th>
															<th>Skill Name</th>
															<th>Years of Experience</th>
															<th>Proficiency</th>
														</tr>
													</thead>
													<tbody>
														{foreach from=$user.skills item=skill name=skill_list}
															<tr>
																<td>{$smarty.foreach.skill_list.iteration}</td>
																<td>{$skill.skill}</td>
																<td>{$skill.experience}</td>
																<td>{$skill.proficiency}</td>
															</tr>
														{/foreach}
													</tbody>
												</table>
											</small>
										</div>
									</div>
									
									
								</div>
								
								
								
								
								<div class="span3">
									<div class="row-fluid">
										{if $user.image neq "" AND $user.image neq NULL}
										<img src="/portal/{$user.image}" class="img-polaroid"/>
										{else}
										<img src="images/bigicon-staff.png" class="img-polaroid"/>
										{/if}
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>

			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>
