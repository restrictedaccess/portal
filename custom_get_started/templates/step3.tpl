{include file="header.tpl" }
<div class="container">
	<h1 class="intro"> Thank you for letting us help find the right person. <br> Please fill in the needed information below so we can begin.</h1>
</div>
<input type="hidden" id="client_id" value="{$client_id}"/>
<!-- STEP 3 WRAPPER START -->
<div class="step_3">
	<!-- STEP 3 CONTAINER START -->
	<div class="container">
		<!-- STEP 1 NAVIGATION START -->
		<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
			<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-1"></i> <a href="/portal/custom_get_started/"> About You </a> </h3>
		</div>
		<!-- STEP 1 NAVIGATION END -->
		<!-- STEP 2 NAVIGATION START -->
		<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
			<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-2"></i> <a href="/portal/custom_get_started/step2.php"> What are you looking for? </a> </h3>
		</div>
		<!-- STEP 2 NAVIGATION END -->
		<!-- STEP 3 NAVIGATION START -->
		<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
			<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-3"></i> <a href="/portal/custom_get_started/step3.php"> Please tell us more about the job roles. </a> </h3>
		</div>
		<!-- STEP 3 NAVIGATION END -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p style="font-size:11px;">Fields with <span class="text-danger">*</span> are required.</p>
				{if $lead}
					<!-- LEADS INFORMATION START -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="well well-small">
								<h4>Create Job Order</h4>
								<p><strong>Lead:</strong> #{$lead.id} - {$lead.fname} {$lead.lname}</p>
							</div>
						</div>
					</div>
					<!-- LEADS INFORMATION END -->
				{/if}
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul id="tabber-job-order" class="nav nav-tabs" style="border-bottom: 1px solid #ADAAAA;">
							{foreach from=$job_orders item=job_order}
							{if $job_order.selected}
								<li class="active"><a href="#job-order-{$job_order.gs_job_titles_details_id}" data-toggle="tab">{$job_order.selected_job_title}</a></li>
							{else}
								<li><a href="#job-order-{$job_order.gs_job_titles_details_id}" data-toggle="tab">{$job_order.selected_job_title}</a></li>
							{/if}
							{/foreach}
						</ul>
						<div class="tab-content" style="padding: 0px 20px;border: 1px solid #ADAAAA; border-top: transparent;">
							{foreach from=$job_orders item=job_order}
							<div class="tab-pane {if $job_order.selected}active{/if}" id="job-order-{$job_order.gs_job_titles_details_id}">
								<form class="job-order-specification" id="job-order-form-{$job_order.gs_job_titles_details_id}">
									<input type="hidden" name="gs_job_titles_details_id" value="{$job_order.gs_job_titles_details_id}"/>
									<div class="row">
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
											<!-- job order details -->
											<div class="well well-small" style="margin-top: 20px;">
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="work_status"><strong>Work status: <span class="text-danger">*</span></strong></label>
															<select id="work_status_{$job_order.gs_job_titles_details_id}" name="work_status" class="form-control chosen" disabled="disabled" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}">
																<option value="">Select Work Status</option>
																{foreach from=$working_status item=status}
																	{if $status.value eq $job_order.work_status}
																		<option value="{$status.value}" selected="selected">{$status.label}</option>
																	{else}
																		<option value="{$status.value}">{$status.label}</option>
																	{/if}
																{/foreach}
															</select>
															<input type="hidden" name="work_status" value="{$job_order.work_status}"/>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="time_zone"><strong>Preferred working timezone: <span class="text-danger">*</span></strong></label>
															<select id="working_timezone_{$job_order.gs_job_titles_details_id}" name="time_zone" class="form-control working_timezone chosen" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}">
																<option value="">Select Timezone</option>
																{foreach from=$timezones item=timezone}
																	<option value="{$timezone.timezone}">{$timezone.timezone}</option>
																{/foreach}
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="shift_time"><strong>Shift time start: <span class="text-danger">*</span></strong></label>
															<select id="shift_time_start_{$job_order.gs_job_titles_details_id}" name="shift_time" class="form-control shift_time_start chosen" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" data-placeholder="Shift time start">
																<option value=""></option>
																{foreach from=$shift_times item=shift_time}
																	<option value="{$shift_time.value}">{$shift_time.label}</option>
																{/foreach}
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="shift_time_end"><strong>Shift time end: <span class="text-danger">*</span></strong></label>
															<select id="shift_time_end_{$job_order.gs_job_titles_details_id}" name="shift_time_end" class="form-control shift_time_end chosen" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" data-placeholder="Shift time end">
																<option value=""></option>
																{foreach from=$shift_times item=shift_time}
																	<option value="{$shift_time.value}">{$shift_time.label}</option>
																{/foreach}
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="start_date"><strong>Start date: <span class="text-danger">*</span></strong></label>
															<input id="start_date_{$job_order.gs_job_titles_details_id}" name="date_start" class="form-control start_date date_start" value="" type="text" placeholder="Start date" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" />
														</div>
													</div>
												</div>
												<div class="row work-schedule-error-shift-box"></div>
											</div>
											<!-- /job order details -->
											<div>
												<button id="launch_skill_btn_{$job_order.gs_job_titles_details_id}" class="btn btn-primary launch-skill" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" data-sub_category_id={$job_order.sub_category_id}>
													<i class="glyphicon glyphicon-plus"></i> Required Skills <span class="text-danger">*</span>
												</button>
												<br/>
												<br/>
												<table id="skill-list-selected-{$job_order.gs_job_titles_details_id}" class="table table-bordered" style="display:none">
													<thead>
														<tr>
															<th width="60%">Skill</th>
															<th width="40%">Proficiency</th>
														</tr>
													</thead>
													<tbody></tbody>
												</table>
												<div id="skill-id-selected-{$job_order.gs_job_titles_details_id}" class="skill_container"></div>
												<button id="launch_task_btn_{$job_order.gs_job_titles_details_id}" class="btn btn-primary launch-task" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" data-sub_category_id={$job_order.sub_category_id}>
													<i class="glyphicon glyphicon-plus"></i> Required Tasks <span class="text-danger">*</span>
												</button>
												<br/>
												<br/>
												<table id="task-list-selected-{$job_order.gs_job_titles_details_id}" class="table table-bordered" style="display:none">
													<thead>
														<tr>
															<th width="60%">Task</th>
															<th width="40%">Ratings</th>
														</tr>
													</thead>
													<tbody></tbody>
												</table>
												<div id="task-id-selected-{$job_order.gs_job_titles_details_id}" class="task_container"></div>
											</div>
											{ if isset($admin_user) }
											<!-- duties and responsibilities -->
											<div class="well well-small" style="overflow: hidden">
												<label class="control-label"><strong>Other duties and responsibilities:</strong></label>
												<div class="responsibilities-div">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="form-group">
																<textarea name="responsibility[]" rows="2" class="form-control" placeholder="Other duties and responsibilities"></textarea>
															</div>
														</div>
													</div>
												</div>
												<div>
													<button class="btn btn-primary add-responsibility">
														<i class="glyphicon glyphicon-plus"></i> Add duties and responsibility
													</button>
												</div>
											</div>
											<!-- /duties and responsibilities -->

											<!-- other preferred skills -->
											<div class="well well-small" style="overflow: hidden">
												<label><strong>Other desirable/preferred skills, personal attributes and knowledge:</strong></label>
												<div class="other-skills-div">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="form-group">
																<textarea name="other_skills[]" rows="2" class="form-control" placeholder="Other desirable/preferred skills, personal attributes and knowledge"></textarea>
															</div>
														</div>
													</div>
												</div>
												<div>
													<button class="btn btn-primary add-other_skills">
														<i class="glyphicon glyphicon-plus"></i> Add other desirable/preferred skills
													</button>
												</div>
											</div>
											{/if}
											<!-- /other preferred skills -->
											<div class="well well-small clearfix" style="overflow: hidden">
												<div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>Will you provide training to the staff?</strong>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-inline" style="margin:5px 0px;">
															<div class="radio" style="margin-right: 10px;">
															  <label><input type="radio" value="Yes" name="staff_provide_training"/> Yes</label>
															</div>
															<div class="radio">
															  <label><input type="radio" value="No" name="staff_provide_training"/> No</label>
															</div>
														</div>
													</div>
												</div>
												<div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>Will the staff need to make calls?</strong>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-inline" style="margin:5px 0px;">
															<div class="radio" style="margin-right: 10px;">
															  <label><input type="radio" value="Yes" name="staff_make_calls"/> Yes</label>
															</div>
															<div class="radio">
															  <label><input type="radio" value="No" name="staff_make_calls"/> No</label>
															</div>
														</div>
													</div>
												</div>
												<div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>Is this your first staff hire for the job role?</strong>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-inline" style="margin:5px 0px 0px;">
															<div class="radio" style="margin-right: 10px;">
															  <label><input type="radio" value="Yes" name="staff_first_time"/> Yes</label>
															</div>
															<div class="radio">
															  <label><input type="radio" value="No" name="staff_first_time"/> No</label>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="well well-small">
												<div class="form-group">
													<label for="special_instruction"><strong>Special Instruction:</strong></label>
													<textarea class="form-control" rows="6" placeholder="Special Instruction" id="special_instruction" name="special_instruction"></textarea>
												</div>
											</div>

											<div class="well well-small">
												<label><strong>Please tell us more about the job role:</strong></label>
												<div class="radio" style="margin-top:0px;">
												  <label>
													<input type="checkbox" name="increase_demand"/>
													This role is required because of increased product or service demand.
												  </label>
												</div>
												<div class="radio">
												  <label>
													<input type="checkbox" name="replacement_post"/>
													This role will replace a post that someone is leaving or has already left.
												  </label>
												</div>
												<div class="radio">
												  <label>
													<input type="checkbox" name="support_current"/>
													This role will support current work or business requirements.
												  </label>
												</div>
												<div class="radio">
												  <label>
													<input type="checkbox" name="experiment_role"/>
													This role is an experiment to see whether or not the company needs it.
												  </label>
												</div>
												<div class="radio" style="margin-bottom:0px;">
												  <label>
													<input type="checkbox" name="meet_new"/>
													This role will help the company meet the needs of new products, services, or capacities.
												  </label>
												</div>
											</div>

										</div>
										<!-- manager information -->
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="well well-small" style="margin-top: 20px;">
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<label><strong>Will the staff report directly to you?</strong></label>
															<div class="form-inline" style="margin:5px 0px;">
																<div class="radio" style="margin-right: 10px;"><label><input type="radio" value="Yes" name="staff_report_directly" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" class="staff_report_directly"/> Yes</label></div>
																<div class="radio"><label><input type="radio" value="No"  name="staff_report_directly" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" class="staff_report_directly"/> No</label></div>
															</div>
														</div>
													</div>
												</div>
												<p>If not, please provide the following details:</p>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<h4 style="color: #333; margin:0px 0px 5px 0px;" class="text-center">Manager Information</h4>
														<hr style="margin:0px 0px 10px 0px;">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="manager_first_name"> <strong> First name</strong>: </label>
															<input type="text" placeholder="First name" id="manager_first_name_{$job_order.gs_job_titles_details_id}" name="manager_first_name" class="form-control" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" />
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="manager_last_name"> <strong> Last name</strong>: </label>
															<input type="text" placeholder="Last name" id="manager_last_name_{$job_order.gs_job_titles_details_id}" name="manager_last_name" class="form-control" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" />
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="manager_email"> <strong> Email address</strong>: </label>
															<input type="text" placeholder="Email address" id="manager_email_{$job_order.gs_job_titles_details_id}" name="manager_email" class="form-control" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" />
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group">
															<label for="manager_contact_number"> <strong> Contact number</strong>: </label>
															<input type="text" placeholder="Contact number" id="manager_contact_number_{$job_order.gs_job_titles_details_id}" name="manager_contact_number" class="form-control" data-gs_job_titles_details_id="{$job_order.gs_job_titles_details_id}" />
														</div>
													</div>
												</div>
												<div class="row manager-info-error-shift-box"></div>
											</div>
										</div>
										<!-- /manager information -->
									</div>
								</form>
							</div>
							{/foreach}
						</div>
						<div><button class="btn btn-primary" id="continue-step-3" style="margin:20px 0px 0px;"> Process Job Specification Request <i class="fa fa-cogs"></i></button></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- STEP 3 CONTAINER END -->
</div>
<!-- STEP 3 WRAPPER END -->
<script type="text/x-handlebars-template" id="responsibility-row">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<textarea name="responsibility[]" rows="2" class="form-control" placeholder="Other duties and responsibilities"></textarea>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
			</div>
		</div>
	</div>
</script>
<script type="text/x-handlebars-template" id="other-skills-row">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<textarea name="other_skills[]" rows="2" class="form-control" placeholder="Other desirable/preferred skills, personal attributes and knowledge"></textarea>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
			</div>
		</div>
	</div>
</script>
<!-- MODAL START -->
{include file="skills_modal.tpl"}
{include file="tasks_modal.tpl"}
{include file="file_uploader.tpl"}
<!-- MODAL END -->
{include file="footer.tpl" }
