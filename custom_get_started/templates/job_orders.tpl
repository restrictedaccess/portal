<!-- JOB ORDER FORM START -->
<form id="job_order_form"> 

	<!-- TAB NAVIGATION START -->
	<ul id="tabber-job-order" class="nav nav-tabs" style="border-bottom: 1px solid #ADAAAA;">
		
		{foreach from=$job_order_details key=k item=job_order_detail}
		
				<li {if $k == 0}class="active"{/if}><a href="#job-order-{$job_order_detail.details.gs_job_titles_details_id}" data-toggle="tab">{$job_order_detail.details.selected_job_title}</a></li>
		
		{/foreach}
	
	</ul>
	<!-- TAB NAVIGATION END -->
	
	<!-- TAB CONTENT START -->
	<div class="tab-content" style="padding: 0px 20px;border: 1px solid #ADAAAA; border-top: transparent;">
		
		{foreach from=$job_order_details key=k item=job_order_detail}
			
			<!-- TAB PANE START -->
			<div class="tab-pane {if $k == 0}active{/if}" id="job-order-{$job_order_detail.details.gs_job_titles_details_id}">
				
				<input type="hidden" id="job_order_id_{$job_order_detail.details.gs_job_titles_details_id}" name="job_order_id[{$job_order_detail.details.gs_job_titles_details_id}]" value="{$job_order_detail.details.gs_job_titles_details_id}" class="job_order_id" />
				
				<!-- JOB ORDER DETAILS START -->
				<div class="row">
					
					<!-- WORK INFORMATION START -->
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						
						<div class="well well-small" style="margin-top: 20px;">
							
							<!-- WORK STATUS START -->
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="work_status"><strong>Work status: <span class="text-danger">*</span></strong></label>
										<select id="work_status_{$job_order_detail.details.gs_job_titles_details_id}" name="work_status[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control work_status chosen-without-search" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-placeholder="Work status" disabled="disabled">
											<option value=""></option>
											{foreach from=$working_status item=status}
												<option value="{$status.value}" {if $status.value eq $job_order_detail.details.work_status}selected="selected"{/if}>{$status.label}</option>
											{/foreach}
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="working_timezone"><strong>Preferred working timezone: <span class="text-danger">*</span></strong></label>
										<select id="working_timezone_{$job_order_detail.details.gs_job_titles_details_id}" name="working_timezone[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control working_timezone chosen-without-search" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-placeholder="Working timezone">
											<option value=""></option>
											{foreach from=$timezones item=timezone} 
												<option value="{$timezone.timezone}" {if $timezone.timezone eq $job_order_detail.details.working_timezone}selected="selected"{elseif !isset($job_order_detail.details.working_timezone) and $timezone.timezone eq 'Australia/Sydney' }selected="selected"{/if}>{$timezone.timezone}</option>
											{/foreach}
										</select>
									</div>
								</div>
							</div>
							<!-- WORK STATUS END -->
							
							<!-- WORK SCHEDULE START -->
							<div class="row">
								
								<!-- SHIFT TIME START START-->
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="shift_time_start"><strong>Shift time start: <span class="text-danger">*</span></strong></label>
										<select id="shift_time_start_{$job_order_detail.details.gs_job_titles_details_id}" name="shift_time_start[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control shift_time_start chosen-without-search" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-placeholder="Shift time start">
											<option value=""></option>
											{foreach from=$shift_times item=shift_time} 
												<option value="{$shift_time.value}" {if $shift_time.value eq $job_order_detail.details.start_work}selected="selected"{/if}>{$shift_time.label}</option>
											{/foreach}
										</select>
									</div>
								</div>
								<!-- SHIFT TIME START END-->
								
								<!-- SHIFT TIME END START-->
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="shift_time_end"><strong>Shift time end: <span class="text-danger">*</span></strong></label>
										<select id="shift_time_end_{$job_order_detail.details.gs_job_titles_details_id}" name="shift_time_end[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control shift_time_end chosen-without-search" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-placeholder="Shift time end">
											<option value=""></option>
											{foreach from=$shift_times item=shift_time}
												<option value="{$shift_time.value}" {if $shift_time.value eq $job_order_detail.details.finish_work}selected="selected"{/if}>{$shift_time.label}</option>
											{/foreach} 
										</select>
									</div>
								</div>
								<!-- SHIFT TIME END END-->
								
								<!-- DATE START START -->
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="start_date"><strong>Start date: <span class="text-danger">*</span></strong></label>
										<input id="start_date_{$job_order_detail.details.gs_job_titles_details_id}" name="start_date[{$job_order_detail.details.gs_job_titles_details_id}]" type="text" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" placeholder="Start date"  class="form-control start_date datepicker" value="{if $job_order_detail.details.proposed_start_date neq '0000-00-00 00:00:00' AND $job_order_detail.details.proposed_start_date neq NULL }{$job_order_detail.details.proposed_start_date|date_format:'%Y-%m-%d'}{else}{/if}" />
									</div>
								</div>
								<!-- DATE START END -->
								
							</div>
							<!-- WORK SCHEDULE END -->

						</div>
						
						<!-- SKILLS AND TASKS START -->
						<div>
							
							<!-- SKILLS START -->
							<button id="launch_skill_btn_{$job_order_detail.details.gs_job_titles_details_id}" class="btn btn-primary launch-skill" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-sub_category_id="{$job_order_detail.subcategory.sub_category_id}">
								<i class="glyphicon glyphicon-plus"></i> Required Skills <span class="text-danger">*</span>
							</button>
							<br/>
							<br/>
							
							<table id="skill-list-selected-{$job_order_detail.details.gs_job_titles_details_id}" class="table table-bordered" {if count($job_order_detail.skills) == 0}style="display:none"{/if}>
								<thead>
									<tr>
										<th width="60%">Skill</th>
										<th width="40%">Proficiency</th>
									</tr>
								</thead>
								<tbody>
									{if count($job_order_detail.skills)}
										{foreach from=$job_order_detail.skills item=skill}
											<tr>
												<td>{$skill.skill.value}</td>
												<td>
													{if $skill.rating eq 1}
														Beginner (1-3 years)
													{elseif $skill.rating eq 2}
														Intermediate (3-5 years)
													{elseif $skill.rating eq 3}
														Advanced (More than 5 years)
													{/if}
												</td>
											</tr>
										{/foreach}
									{/if}
								</tbody>
							</table>
							
							<div id="skill-id-selected-{$job_order_detail.details.gs_job_titles_details_id}" class="skill_container">
								{if count($job_order_detail.skills)}
									{foreach from=$job_order_detail.skills item=skill}
										<input type="hidden" name="skills[{$job_order_detail.details.gs_job_titles_details_id}][{$skill.skill.id}]" class="selected-skill" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{$skill.skill.id}">
										<input type="hidden" name="skills-proficiency[{$job_order_detail.details.gs_job_titles_details_id}][{$skill.skill.id}]" class="selected-skill-proficiency" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{$skill.rating}">
									{/foreach}
								{/if}
							</div>
							<!-- SKILLS END -->
							
							<!-- TASKS START -->
							<button id="launch_task_btn_{$job_order_detail.details.gs_job_titles_details_id}" class="btn btn-primary launch-task" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" data-sub_category_id="{$job_order_detail.subcategory.sub_category_id}">
								<i class="glyphicon glyphicon-plus"></i> Required Tasks <span class="text-danger">*</span>
							</button>
							<br/>
							<br/>
							
							<table id="task-list-selected-{$job_order_detail.details.gs_job_titles_details_id}" class="table table-bordered" {if count($job_order_detail.tasks) == 0} style="display:none"{/if}>
								<thead>
									<tr>
										<th width="60%">Task</th>
										<th width="40%">Ratings</th>
									</tr>
								</thead>
								<tbody>
									{if count($job_order_detail.tasks)}
										{foreach from=$job_order_detail.tasks item=task}
											<tr>
												<td>{$task.task.value}</td>
												<td>{$task.rating}/10</td>
											</tr>
										{/foreach}
									{/if}
								</tbody>
							</table>
							
							<div id="task-id-selected-{$job_order_detail.details.gs_job_titles_details_id}" class="task_container">
								{if count($job_order_detail.tasks)}
									{foreach from=$job_order_detail.tasks item=task}
										<input type="hidden" name="tasks[{$job_order_detail.details.gs_job_titles_details_id}][{$task.task.id}]" class="selected-task" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{$task.task.id}">
										<input type="hidden" name="tasks-proficiency[{$job_order_detail.details.gs_job_titles_details_id}][{$task.task.id}]" class="selected-task-proficiency" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{$task.rating}">
									{/foreach}
								{/if}
							</div>
							<!-- TASKS END -->
							
						</div>
						<!-- SKILLS AND TASKS END -->
						
						{if isset($admin_user)}
						<!-- OTHER DUTIES AND RESPONSIBILITIES START -->
						<div class="well well-small" style="overflow: hidden">
							<label class="control-label"><strong>Other duties and responsibilities:</strong></label>
							<div class="responsibilities-div">
								{if count($job_order_detail.responsibilities) }
									{foreach from=$job_order_detail.responsibilities key=k item=responsibility}
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<textarea name="responsibility[{$job_order_detail.details.gs_job_titles_details_id}][]" rows="2" class="form-control" placeholder="Other duties and responsibilities">{$responsibility.description}</textarea>
												</div>
											</div>
											{if $k ne 0}
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
												</div>
											</div>
											{/if}
										</div>
									{/foreach}
								{else}
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<textarea name="responsibility[{$job_order_detail.details.gs_job_titles_details_id}][]" rows="2" class="form-control" placeholder="Other duties and responsibilities"></textarea>
											</div>
										</div>
									</div>
								{/if}
							</div>
							<div>
								<button class="btn btn-primary add-responsibility" type="button" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}">
									<i class="glyphicon glyphicon-plus"></i> Add duties and responsibility
								</button>
							</div>
						</div>
						<!-- OTHER DUTIES AND RESPONSIBILITIES END -->
						
						<!-- OTHER SKILLS START -->
						<div class="well well-small" style="overflow: hidden">
							<label><strong>Other desirable/preferred skills, personal attributes and knowledge:</strong></label>
							<div class="other-skills-div">
								{if count($job_order_detail.other_skills) }
									{foreach from=$job_order_detail.other_skills key=k item=other_skill}
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<textarea name="other_skills[{$job_order_detail.details.gs_job_titles_details_id}][]" rows="2" class="form-control" placeholder="Other desirable/preferred skills, personal attributes and knowledge">{$other_skill.description}</textarea>
												</div>
											</div>
											{if $k ne 0}
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
												</div>
											</div>
											{/if}
										</div>
									{/foreach}
								{else}
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<textarea name="other_skills[{$job_order_detail.details.gs_job_titles_details_id}][]" rows="2" class="form-control" placeholder="Other desirable/preferred skills, personal attributes and knowledge"></textarea>
											</div>
										</div>
									</div>
								{/if} 
							</div>
							<div>
								<button class="btn btn-primary add-other_skills" type="button" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}">
									<i class="glyphicon glyphicon-plus"></i> Add other desirable/preferred skills  
								</button>
							</div>
						</div>
						<!-- OTHER SKILLS END -->
						
						{/if}
						
						<div class="well well-small clearfix" style="overflow: hidden">
							<!-- WILL YOU PROVIDE TRAINING START -->
							<div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<strong>Will you provide training to the staff?</strong>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-inline" style="margin:5px 0px;">
										<div class="radio" style="margin-right: 10px;"> <label><input type="radio" value="Yes" name="staff_provide_training[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_provide_training.description eq "Yes" }checked="checked"{/if} /> Yes</label></div>
										<div class="radio"><label><input type="radio" value="No" name="staff_provide_training[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_provide_training.description eq "No" }checked="checked"{/if} /> No</label></div>
									</div>
								</div>
							</div>
							<!-- WILL YOU PROVIDE TRAINING END -->
							
							<!-- WILL STAFF NEED TO MAKE CALLS START -->
							<div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<strong>Will the staff need to make calls?</strong>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-inline" style="margin:5px 0px;">
										<div class="radio" style="margin-right: 10px;"><label><input type="radio" value="Yes" name="staff_make_calls[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_make_calls.description eq "Yes" }checked="checked"{/if} /> Yes</label></div>
										<div class="radio"><label><input type="radio" value="No" name="staff_make_calls[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_make_calls.description eq "No" }checked="checked"{/if} /> No</label></div>
									</div>
								</div>
							</div>
							<!-- WILL STAFF NEED TO MAKE CALLS END -->
							
							<!-- FIRST TIME YOU ARE HIRING A STAFF FOR THIS POSITION START -->
							<div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<strong>Is this the first you are hiring a staff for this position?</strong>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-inline" style="margin:5px 0px;">
										<div class="radio" style="margin-right: 10px;"><label><input type="radio" value="Yes" name="staff_first_time[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_first_time.description eq "Yes" }checked="checked"{/if}/> Yes</label></div>	
										<div class="radio"><label><input type="radio" value="No" name="staff_first_time[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_first_time.description eq "No" }checked="checked"{/if}/> No</label></div>												
									</div>
								</div>
							</div>
							<!-- FIRST TIME YOU ARE HIRING A STAFF FOR THIS POSITION END -->
						
						</div>
						
						<!-- SPECIAL INSTRUCTION START -->
						<div class="well well-small">
							<div class="form-group">
								<label for="special_instruction"><strong>Special instruction:</strong></label>
								<textarea name="special_instruction[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control" rows="6" placeholder="Special instruction">{$job_order_detail.special_instruction.description}</textarea>
							</div>
						</div>
						<!-- SPECIAL INSTRUCTION END -->
						
						<!-- OPTIONAL START -->
						<div class="well well-small">
							<label><strong>Please tell us more about these job role:</strong></label>
							<div class="radio" style="margin-top:0px;">
							  <label>
								<input type="checkbox" name="increase_demand[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.other_details.increase_demand eq "Yes" }checked="checked"{/if} />
								This role needed because of increase demand of your product or services.
							  </label>
							</div>
							<div class="radio">
							  <label>
								<input type="checkbox" name="replacement_post[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.other_details.replacement_post eq "Yes" }checked="checked"{/if} />
								This role a replacement of a post someone is leaving or has already left.
							  </label>
							</div>
							<div class="radio">
							  <label>
								<input type="checkbox" name="support_current[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.other_details.support_current eq "Yes" }checked="checked"{/if} />
								This role needed to add support to your current work needs.
							  </label>
							</div>		
							<div class="radio">
							  <label>
								<input type="checkbox" name="experiment_role[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.other_details.experiment_role eq "Yes" }checked="checked"{/if} />
								This new role a test, experiment role for your company never before done.
							  </label>
							</div>	
							<div class="radio" style="margin-bottom:0px;">
							  <label>
								<input type="checkbox" name="meet_new[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.other_details.meet_new eq "Yes" }checked="checked"{/if} />
								This new role to meet the need of new services, products or capacities in your company.
							  </label>
							</div>
						</div>
						<!-- OPTIONAL END -->
						
					</div>
					<!-- WORK INFORMATION END -->
					
					<!-- MANAGER INFORMATION START -->
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						
						<div class="well well-small" style="margin-top: 20px;">
							
							<div class="row">
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="form-group">
									
										<label><strong>Will the staff report directly to you?</strong></label>
										
										<div class="form-inline" style="margin:5px 0px;">
										
											<div class="radio" style="margin:5px 0px;">
											
												<label><input type="radio" value="Yes" name="staff_report_directly[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_report_directly.description eq "Yes" }checked="checked"{/if} data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" class="staff_report_directly" /> Yes</label>
											
											</div>
											
											<div class="radio">
											
												<label><input type="radio" value="No" name="staff_report_directly[{$job_order_detail.details.gs_job_titles_details_id}]" {if $job_order_detail.staff_report_directly.description eq "No" }checked="checked"{/if} data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" class="staff_report_directly" /> No</label>
											
											</div>
											
										</div>
										
									</div>
								
								</div>
							
							</div>
							
							<p>If not, please provide the following:</p>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<h4 style="color: #333; margin:0px 0px 5px 0px;" class="text-center">Manager Information</h4>
									<hr style="margin:0px 0px 10px 0px;">
								</div>
							</div>
							
							<!-- MANAGER FULLNAME START -->
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<!-- MANAGER FIRST NAME START-->
									<div class="form-group">
										<label for="manager_first_name"> <strong> First name</strong>: </label>
										<input type="text" placeholder="First name" id="manager_first_name_{$job_order_detail.details.gs_job_titles_details_id}" name="manager_first_name[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{if $job_order_detail.staff_report_directly.description eq 'No' }{$job_order_detail.staff_report_directly.manager.firstname}{/if}" {if $job_order_detail.staff_report_directly.description eq 'Yes' }disabled="disabled"{/if}/>
									</div>
									<!-- MANAGER FIRST NAME END-->
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<!-- MANAGER LAST NAME START-->
									<div class="form-group">
										<label for="manager_last_name"> <strong> Last name</strong>: </label>
										<input type="text" placeholder="Last name" id="manager_last_name_{$job_order_detail.details.gs_job_titles_details_id}" name="manager_last_name[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{if $job_order_detail.staff_report_directly.description eq 'No' }{$job_order_detail.staff_report_directly.manager.lastname}{/if}" {if $job_order_detail.staff_report_directly.description eq 'Yes' }disabled="disabled"{/if} />
									</div>
									<!-- MANAGER LAST NAME END-->
								</div>
							</div>
							<!-- MANAGER FULLNAME START -->
							
							<!-- MANAGER EMAIL START -->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="manager_email"> <strong> Email address</strong>: </label>
										<input type="text" placeholder="Email address" id="manager_email_{$job_order_detail.details.gs_job_titles_details_id}" name="manager_email[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{if $job_order_detail.staff_report_directly.description eq 'No' }{$job_order_detail.staff_report_directly.manager.email}{/if}" {if $job_order_detail.staff_report_directly.description eq 'Yes' }disabled="disabled"{/if} />
									</div>
								</div>
							</div>
							<!-- MANAGER EMAIL END -->
							
							<!-- MANAGER CONTACT NUMBER START -->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="manager_contact_number"> <strong> Contact number</strong>: </label>
										<input type="text" placeholder="Contact number" id="manager_contact_number_{$job_order_detail.details.gs_job_titles_details_id}" name="manager_contact_number[{$job_order_detail.details.gs_job_titles_details_id}]" class="form-control" data-gs_job_titles_details_id="{$job_order_detail.details.gs_job_titles_details_id}" value="{if $job_order_detail.staff_report_directly.description eq 'No' }{$job_order_detail.staff_report_directly.manager.contact_no}{/if}" {if $job_order_detail.staff_report_directly.description eq 'Yes' }disabled="disabled"{/if} />
									</div>
								</div>
							</div>
							<!-- MANAGER CONTACT NUMBER END -->
							
						</div>
						
					</div>
					<!-- MANAGER INFORMATION END -->
					
				</div>
				<!-- JOB ORDER DETAILS END -->
				
			</div>
			<!-- TAB PANE END -->

		{/foreach}
		
	</div>
	<!-- TAB CONTENT END --> 
	
	<!-- STEP 3 BUTTON START-->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
			<button id="update_step_three_btn" type="submit" class="btn btn-primary" style="margin:20px 0px;"> <i class="glyphicon glyphicon-floppy-saved"></i> Update Step 3 </button>
			<a id="optional_step4_btn" href="/portal/custom_get_started/optional_step4.php" class="btn btn-default" style="margin:20px 0px;"> <i class="fa fa-cogs"></i> Proceed to Next Step </a>
		</div>
	</div>
	<!-- STEP 3 BUTTON END-->

</form>
<!-- JOB ORDER FORM END -->
