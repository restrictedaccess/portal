<!-- Content begins here -->
<table width="650" border="1" cellpadding="0" cellspacing="0"
	bordercolor="a8a8a8" bgcolor="646464">
	<tbody>
		<tr>
			<td width="650">
				<table width="650" border="0" align="center" cellpadding="0"
					cellspacing="0" bgcolor="666666">
					<tbody>
						<tr>
							<td valign="top" align="center"></td>
						</tr>
					</tbody>
				</table>
				<table width="625" border="0" align="center" cellpadding="3"
					cellspacing="2" bgcolor="666666">
					<tbody>
						<tr>
							<td><div align="left">
									<font class="cName">{$user.lname}, {$user.fname}</font><br>
								</div></td>
						</tr>
					</tbody>
				</table>
				<table width="620" height="244" border="0" align="center"
					cellpadding="10" cellspacing="2" bgcolor="#FFFFFF">
					<tbody>
						<tr>
							<td valign="top" bgcolor="#FFFFFF">
								<div class="ads">
									<h3></h3>
									<p align="right">
										<i><b>Date Applied: </b>{$user.dateapplied}</i><br> <i><b>Last
												Update: </b>{$user.datelastupdated}</i>
									</p>

									<!-- image -->
									<table width="80%" style="margin-left: 10px;">
										<tbody>
											<tr>
												<td width="44%"><img border="0"
													src="../uploads/pics/{$user.userid}.jpg" width="176"
													height="200"></td>
												<td width="56%" class="subtitle" valign="top">
													<p style="margin-left: 50px; margin-top: 50px;">
														{$user.lname}, {$user.fname}<br>
														Remotestaff&nbsp;Applicant&nbsp;ID:&nbsp;{$user.userid}<br>
														{$user.currentjob.latest_job_title}
													</p>
												</td>
											</tr>
										</tbody>
									</table>

									<!-- image -->

									<!-- Personal Information -->
									<table width="100%" cellpadding="4" cellspacing="0">
										<tbody>
											<tr bgcolor="#CCCCCC">
												<td align="left" colspan="5"><b>Personal Information</b></td>
												<td align="right"><a
													href="/portal/personal/updatepersonal.php">Edit</a>
												</td>
											</tr>
											<tr align="left">
												<td width="26%" valign="top"><b>Age</b></td>
												<td width="3%" valign="top">:</td>
												<td width="25%" valign="top">{$user.age}</td>
												<td width="17%" valign="top"><b>Date of Birth</b>
												</td>
												<td width="2%" valign="top">:</td>
												<td width="17%" valign="top" style="white-space:nowrap">{$user.birth_date}</td>
											</tr>
											<tr align="left">
												<td width="26%" valign="top"><b>Nationality</b></td>
												<td width="3%" valign="top">:</td>
												<td width="25%" valign="top">{$user.nationality}</td>
												<td width="17%" valign="top"><b>Gender</b></td>
												<td width="2%" valign="top">:</td>
												<td width="17%" valign="top">{$user.gender}</td>
											</tr>
											<tr align="left">
												<td width="26%" valign="top"><b>Marital Status</b></td>
												<td width="3%" valign="top">:</td>
												<td width="25%" valign="top">{$user.marital_status}</td>
												<td width="17%" valign="top"><b>Number of Kids(if any)</b>
												</td>
												<td width="2%" valign="top">:</td>
												<td width="17%" valign="top">
												{if $user.no_of_kids eq "" || $user.no_of_kids eq 0}
													N/A
												{else}
													{$user.no_of_kids}
												{/if}
												</td>
											</tr>
											<tr align="left">
												<td width="26%"  valign="top"><b>Permanent Residence</b></td>
												<td width="3%" valign="top">:</td>
												<td width="25%" valign="top">{$user.permanent_residence}</td>
												<td width="17%" valign="top" colspan="3">&nbsp;</td>
											</tr>
											
											{if $user.gender eq "Female"}
												<tr align="left">
													<td width="26%" valign="top"><b>Pregnant</b></td>
													<td width="3%" valign="top">:</td>
													<td width="25%" valign="top">{$user.pregnant}</td>
													<td width="17%" valign="top"><b>Date of Delivery</b>
													</td>
													<td width="2%" valign="top">:</td>
													<td width="17%" valign="top" style="white-space:nowrap">
														{if $user.pregnant eq "Yes"}
															{$user.date_delivery}
														{else}
															N/A
														{/if}
													</td>
												</tr>
											{/if}
											
											<tr align="left">
												<td width="26%" valign="top"><b>Has Pending Visa Application</b></td>
												<td width="3%" valign="top">:</td>
												<td width="25%" valign="top">{$user.pending_visa_application}</td>
												<td width="17%" valign="top"><b>Has Active Visa in US, Australia, UK, Dubai?</b>
												</td>
												<td width="2%" valign="top">:</td>
												<td width="17%" valign="top">{$user.active_visa}</td>
											</tr>
											
											<tr align="left">
												<td valign="top" colspan="6">&nbsp;</td>
											</tr>
											<tr align="left" bgcolor="#CCCCCC">
												<td colspan="6"><b>Contact Information</b></td>
											</tr>
											<tr align="left">
												<td width="20%" valign="top"><b>Address</b></td>
												<td width="2%" valign="top">:</td>
												<td valign="top" colspan="4">{$user.address}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Telephone No.</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.telephone}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Mobile No.</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.mobile}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Email</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top"><a href="mailto:{$user.email}">{$user.email}</a>
												</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											
											<tr bgcolor="#CCCCCC">
												<td align="left" colspan="6"><b>Online Contact Information</b></td>
												
											</tr>
											<tr align="left">
												<td width="20%" valign="top"><b>MSN Messenger ID</b></td>
												<td width="2%" valign="top">:</td>
												<td valign="top" colspan="4">{$user.msn_id}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Yahoo Messenger ID</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.yahoo_id}</td>
											</tr>	
											
											<tr align="left">
												<td valign="top"><b>Facebook / Twitter Account:</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.icq_id}</td>
											</tr>	
											<tr>										<tr align="left">
												<td valign="top"><b>Linked In Account:</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.linked_in}</td>
											</tr>	
											<tr align="left">
												<td valign="top"><b>Skype ID:</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.skype_id}</td>
											</tr>	
											<tr align="left">
												<td valign="top" colspan="6">&nbsp;</td>
											</tr>

											<tr align="left" bgcolor="#CCCCCC">
												<td colspan="5"><b>Working at Home Capabilities</b></td>
												<td align="right"><a
													href="/portal/personal/updateworkingathomecapabilities.php">Edit</a>
												</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Have worked from Home</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.work_from_home_before}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Has baby in house</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.has_baby}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>

											<tr align="left">
												<td valign="top"><b>If yes, the main caregiver is</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.main_caregiver}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Reason to work at Home</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.reason_to_wfh}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Working duration with Remotestaff</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.timespan}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Working Environment</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.home_working_environment}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Internet Connection</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.isp}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>


											<tr align="left">
												<td valign="top"><b>Other Internet Connection</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.internet_connection_others}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr align="left">

											<tr align="left">
												<td valign="top"><b>Internet Plan & Package</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.internet_connection}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											
											
											<tr align="left">
												<td valign="top"><b>What is possible and what is not possible about {$pronoun} internet connection from home</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.internet_consequences}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>

											<tr align="left">
												<td valign="top"><b>Speed Test Result Link</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top"><a href="{$user.speed_test}"
													target="_blank">{$user.speed_test}</a></td>
												<td valign="top" colspan="3">&nbsp;</td>

											</tr>
											<tr align="left">
												<td valign="top"><b>Computer Hardware/s</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.hardwares}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											
											<tr align="left">
												<td valign="top"><b>Noise Level</b></td>
												<td valign="top">:</td>
												<td width="37%" valign="top">{$user.noise}</td>
												<td valign="top" colspan="3">&nbsp;</td>
											</tr>
											
											

											<!-- Education -->
											<tr align="left" bgcolor="#CCCCCC">
												<td colspan="5"><b>Highest Qualification</b></td>
												<td align="right"><a
													href="/portal/personal/updateeducation.php">Edit</a>
												</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Level</b></td>
												<td valign="top">:</td>
												<td valign="top">{$user.education.educationallevel}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Field of Study</b></td>
												<td valign="top">:</td>
												<td valign="top">{$user.education.fieldstudy}</td>
												<td valign="top" colspan="3"></td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Major</b></td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.education.major}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Institute / University</b>
												</td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.education.college_name}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Located In</b></td>
												<td valign="top">:</td>
												<td valign="top">{$user.education.college_country}</td>
												<td valign="top"><b>Graduation Date</b></td>
												<td valign="top">:</td>
												<td valign="top">{$user.education.graduation}</td>
											</tr>
											<tr align="left">
												<td valign="top"><b>Grade</b></td>
												<td valign="top">:</td>
												<td valign="top">{$user.education.grade}</td>
												
												{if $user.education.grade eq "Grade Point Average (GPA)"}
													<td valign="top"><b>GPA Score</b></td>
													<td valign="top">:</td>
													<td valign="top">{$user.education.gpascore}</td>
												{/if}
											</tr>
											<tr align="left">
												<td align="left" valign="top"><b>Trainings and Seminars</b>
												</td>
												<td valign="top">:</td>
												<td valign="top" colspan="4">{$user.education.trainings_seminars}</td>
											</tr>
											

											<!--- work Experience --->

											<tr align="left">
												<td valign="top" colspan="6">&nbsp;</td>
											</tr>
											<tr align="left" class="TRHeader">
												<!--- work Experience --->

											</tr>
											<tr align="left" bgcolor="#CCCCCC">
												<td align="left" valign="top" colspan="5"><strong>Employment History</strong></td>
												<td align="right"><a
													href="/portal/personal/updatecurrentjob.php">Edit</a>
												</td>
											</tr>
											<tr align="left">
												<td valign="top" colspan="6">
													<table width="100%" border="0">
														<tbody>
															{foreach from=$user.jobs item=job name=jobs}
																<tr align="left">
																	<td valign="top" width="3%">{$smarty.foreach.jobs.iteration}.</td>
																	<td valign="top" width="20%"><b>Company Name</b></td>
																	<td valign="top" width="1%">:</td>
																	<td valign="top" width="75%">{$job.companyname}</td>
																</tr>
																<tr align="left">
																	<td valign="top"></td>
																	<td valign="top"><b>Position Title</b></td>
																	<td valign="top">:</td>
																	<td valign="top">{$job.position}</td>
																</tr>
																<tr align="left">
																	<td valign="top"></td>
																	<td valign="top"><b>Employment Period</b></td>
																	<td valign="top">:</td>
																	<td valign="top">{$job.monthfrom} {$job.yearfrom} to {$job.monthto} {$job.yearto}</td>
																</tr>
																<tr class="jobs"> 
																	<td valign="top"></td>
																	<td valign="top"><b>Responsibilies /Achievements</b></td>
																	<td valign="top">:</td>
																	<td valign="top">{$job.duties}</td>
																</tr>
															{/foreach
																}
																
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Character References</b></td>
																<td valign="top">:</td>
																<td valign="top">
																	<ol style="margin-left:20px">
																		{foreach from=$user.character_references item=character_reference}
																			<li style="margin-bottom:10px;">
																				<strong>Name: </strong>{$character_reference.name}<br/>
																				<strong>Contact Details: </strong><br/>{$character_reference.contact_details}<br/>
																				<strong>Contact Number: </strong>{$character_reference.contact_number}<br/>
																				<strong>Email Address: </strong>{$character_reference.email_address}
																				
																			</li>
																			
																		{/foreach}
																	</ol>
	
																</td>
															</tr>
															<tr>
																<td valign="top" colspan="4" align="left">&nbsp;</td>
															</tr>
															
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Current Status</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.current_status}</td>
															</tr>
											
															{if $user.currentjob.available_status != ""}
															<tr>
																<td valign="top"></td>
																<td valign="top"><b>Availability Status</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.available_status}</td>
															</tr>
															{/if}
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Expected Salary</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.salary_currency} {$user.currentjob.expected_salary} {$user.currentjob.expected_salary_neg}</td>
															</tr>
															
															
															
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Position First Choice</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.position_first_choice}</td>
															</tr>
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Position Second Choice</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.position_second_choice}</td>
															</tr>
															<tr align="left">
																<td valign="top"></td>
																<td valign="top"><b>Position Third Choice</b></td>
																<td valign="top">:</td>
																<td valign="top">{$user.currentjob.position_third_choice}</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>

											<!--- languages --->
											<tr align="left" bgcolor="#CCCCCC">
												<td align="left" valign="top" colspan="5"><b>Languages</b></td>
												<td align="right"><a href="/portal/personal/updatelanguage.php">Edit</a>
												</td>
											</tr>
											<tr align="left">
												<td valign="top" colspan="6">
													<table width="100%" cellpadding="2" cellspacing="0">
														<tbody>
															<tr>
																<td valign="top">&nbsp;</td>
																<td valign="top" align="right" colspan="3"><b>Proficiency</b>
																	(0=Poor - 10=Excellent)</td>
															</tr>
															<tr>
																<td valign="top"><b>Language</b></td>
																<td valign="top" align="center"><b>Spoken</b>
																</td>
																<td valign="top" align="center"><b>Written</b>
																</td>
															</tr>
															{foreach from=$user.languages item=language name=languages}
																<tr>
																	<td valign="top">{$language.language}</td>
																	<td valign="top" align="center">{$language.spoken}</td>
																	<td valign="top" align="center">{$language.written}</td>
																</tr>
															{/foreach}
															
															
														</tbody>
													</table></td>
											</tr>
											<!-- Skills -->
											<tr>
												<td valign="top" colspan="6">&nbsp;</td>
											</tr>
											<tr bgcolor="#CCCCCC">
												<td align="left" valign="top" colspan="5"><b>Skills</b></td>
												<td align="right"><a
													href="/portal/personal/updateskills.php">Edit</a>
												</td>
											</tr>
											<tr>
												<td valign="top" colspan="6">
													<table width="100%" cellpadding="2" cellspacing="0">
														<tbody>
															<tr>
																<td width="22%" valign="top">&nbsp;</td>
																<td valign="top" align="right" colspan="3"><b>Proficiency</b>
																	(1=Beginner - 2=Intermediate - 3=Advanced)</td>
															</tr>
															<tr>
																<td align="left" valign="top"><b>Skill</b></td>
																<td align="left" width="39%" align="center" valign="top"><b>Experience</b>
																</td>
																<td align="left" width="39%" align="center" valign="top"><b>Proficiency</b>
																</td>
															</tr>
															{foreach from=$user.skills item=skill name=skills}
																<tr align="left">
																	<td valign="top">{$skill.skill}</td>
																	<td valign="top" align="center">{$skill.experience}</td>
																	<td valign="top" align="center">{$skill.proficiency}</td>
																</tr>
															{/foreach}
															
															
														</tbody>
													</table></td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>

						</tr>
					</tbody>
				</table>
				<p>&nbsp;</p></td>
		</tr>
	</tbody>
</table>
