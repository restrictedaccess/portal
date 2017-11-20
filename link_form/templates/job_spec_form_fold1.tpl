<div class="job-spec-container">
	<div class="col-lg-2 col-md-2"></div>
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

		<div class="panel-body">

			<div class="header-body">
				<!--<div class="img-container"><img class="job-spec-logo" src="/portal/link_form/img/rs-logo.png"></div>
				<div class="job-spec-img-title">
					Relationships You Can Rely On
				</div> -->
				<div class="ribbon jo-spec-form">
					<h1>Job Description Form</h1>
				</div>
				<div class="content">
					<div>
						{*<h3><strong>Job Description Form</strong></h3>*}
						<p class="header-desc">
							Please complete this job description form to assist Remote Staff recruiters in sourcing the right candidates.
						</p>
					</div>

					<!--Client name / Email Address -->
					<form id="register-form" method="post" action="job_specification_form.php" role="form" data-toggle="validator">

						<input type="hidden" name="registered_in" value="new_job_specification_form">
			            <input type="hidden" name="section" value="1">
			            <input type="hidden" name="registered_url" value = "{$site}"> 
			            <input type="hidden" name="url_referer" value = "{$url_referer}">
						<input type="hidden" name="auth_token" id="auth_token" value="{$auth_token}" >

			            <input type="hidden" name="leads_country" id="leads_country" value="{$location.leads_country}" >
			            <input type="hidden" name="leads_ip" id="leads_ip" value="{$location.leads_ip}" >            
			            <input type="hidden" name="registered_domain" id="registered_domain" value="{$location.location_id}" >
			            <input type="hidden" name="location_id" id="location_id" value="{$location.location_id}" >
			            <input type="hidden" name="tracking_no" id="tracking_no" value="{$tracking_no}" >
			             <input type="hidden" name="is_registered_user" id="is_registered_user" value="{$is_thankyou_page}" >

						<div class="form-group">
							{*
							<div>
								*}
								{*<strong>Name of Contact: <span style="color:red;">*</span></strong>*}
								{*
							</div>
							*}
							<div class="control">
								
								<input type="text" name="cname" id="cname" class="form-control custom-text" placeholder="Name:" {if $is_thankyou_page} value="{$registered_name}" {/if} >
								
								<input type="hidden" name="hashcode_field" id="hashcode_field" />
							</div>
						</div>
						<div class="form-group">
							{*
							<div>
								*}
								{*<strong>Email Address: <span style="color:red;">*</span></strong>*}
								{*
							</div>
							*}
							<div class="control">

								<input type="text" name="eaddress" id="eaddress" class="form-control custom-text" placeholder="Email Address: " {if $is_thankyou_page} value="{$registered_email}" {/if}>

							</div>
						</div>

						<div class="form-group">
							{*
							<div>
								*}
								{*<strong>Contact Number: <span style="color:red;">*</span></strong>*}
								{*
							</div>
							*}
							<div class="control">

								<input type="text" name="contactnumber" id="contactnumber" class="form-control custom-text" placeholder="Contact Number: " {if $is_thankyou_page} value="{$registered_number}" {/if}>

							</div>

						</div>

						<div class="form-group desktop-box">
							{*
							<div>
								*}
								{*<strong>Company Name or Website: <span style="color:red; padding:5px;">*</span><span style="font-size:12px; color:red;">(If no website put in company name)</span></strong>*}
								{*
							</div>
							*}
							<div class="control">
								<input type="text" name="companywebsite" id="companywebsite" class="form-control custom-text" placeholder="Company Name or Website: (If no website put in company name)">
							</div>
						</div>

						<!--/Client name / Email Address -->

						<!--Have you used off shore staff before?-->
						<div class="form-group">
							<div>
								<strong><span style="color:red;">*</span>Have you used offshore staff before? </strong>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_have_you_used" class="radio_have_you_used" value="Yes">
									Yes</label>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_have_you_used" class="radio_have_you_used" value="No" >
									No</label>
							</div>
						</div>

						<div class="form-group">
							<div class= "control">
								<select type="text" name="expected_terms" id="expected_terms" class="form-control chosen custom-text" placeholder="Expected terms of agreement" required="required">
									<option value="">Expected terms of agreement (Select from the list)</option>
									<option value="Ongoing">Ongoing</option>
									<option value="3 months">3 months</option>
									<option value="6 months">6 months</option>
									<option value="12 months">12 months</option>
								</select>
							</div>
						</div>

						<div id = "have_you_message" style="color:red;font-size: 12px;"></div>
						<!--/Have you used off shore staff before?-->

						<!--Staff Job Title -->

						<div class="form-group">
							{*<label for="staff-job-title"><strong>Job Title</strong> <span style="color:red;padding:5px;">*</span><strong><span style="font-size:12px; color:red;">(Select from the list)</span></strong></label>*}
							<div class= "control">
								<select list='job_categ' type="text" name="staffjobtitle" id="staffjobtitle" class="form-control chosen custom-text" placeholder="Job Title (Select from the list.)">
								<datalist id='job_categ'>
									<option value="">Job Title (Select from the list)</option>
									{foreach from=$job_cat item=job_cat}
									<option value="{$job_cat}">{$job_cat}</option>
									{/foreach}
								</datalist>
								</select>
							</div>
						</div>

						<!--/Staff Job Title -->

						<!--Job Type -->
						<div class="form-group">
							<div>
								<strong><span style="color:red;">*</span>Job Type </strong>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_job_type" id="radio_full_time_job_type" value="Full Time">
									Full-Time (minimum 40 hours per week)</label>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_job_type" id="radio_part_time_job_type" value="Part Time">
									Part-Time (minimum 20 hours per week)</label>
							</div>
						</div>
						<div id = "job_type_message" style="color:red;font-size: 12px;"></div>
						<!--/Job Type -->

						<!--Location of Remote Worker -->
						<div class="form-group">
							<div>
								<strong><span style="color:red;">*</span>Location of remote worker </strong>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_location" id="radio_location_home" value="Home Based">
									Home-Based</label>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_location" id="radio_location_office" value="Office Based" >
									Office-Based</label>
							</div>
						</div>
						<div id = "location_message" style="color:red;font-size: 12px;"></div>
						<!--/Location of Remote Worker -->

						<!--Numbers of staff required  -->

						<div class="form-group">
							{*<label for="nos-staff-required" style="padding:0px" ><strong><span style="color:red;">*</span>Numbers of staff required: </strong></label>*}
							<input type="text" class="form-control custom-text" name="numberstaffrequired" id="numberstaffrequired" placeholder="Number of staff required: ">
						</div>

						<!--/Numbers of staff required  -->
						<div class="row desktop-box">
							<!--Shift times and Time Zone -->
							<div class = "col-lg-12">
								<div class="form-group">
									<label class="dropdown-inline"  for="time-zone" style="padding:0px"><strong><span style="color:red;">*</span>Timezone</strong></label>
									<br />
									<div class= "control">
										<select list='timezones' type="text" name="timezone" id="timezone" class="form-control chosen custom-text" placeholder="Please select Timezone">
										<datalist id='timezones'>
											<option>Please Select Timezone</option>
											{foreach from=$timezones item=timezone}
											<option value="{$timezone}">{$timezone}</option>
											{/foreach}
										</datalist>
										</select>
									</div>
								</div>
							</div>
						</div>
						<!--
						<div class ="col-lg-3">
						<div class="form-group">
						<label class="dropdown-inline" for="shift_time_start" style="padding:0px"><strong>Shift Time Start <span style="color:red;">*</span></strong></label>
						<select id="shift_time_start" name="shift_time_start" class="form-control chosen" data-placeholder="Start Time">
						<option value=""></option>
						{foreach from=$shift_times item=shift_time} <option value="{$shift_time.label}">{$shift_time.label}</option>
						{/foreach}
						</select>
						</div>

						</div>
						<div class ="col-lg-3">
						<div class="form-group">
						<label class="dropdown-inline"  for="shift_time_end" style="padding:0px"><strong>Shift Time End <span style="color:red;">*</span></strong></label>
						<select id="shift_time_end" name="shift_time_end" class="form-control chosen" data-placeholder="End Time">
						<option value=""></option>
						{foreach from=$shift_times item=shift_time} <option value="{$shift_time.label}">{$shift_time.label}</option>
						{/foreach}
						</select>
						</div>
						</div>
						</div>

						Shift times and Time Zone -->

						<!--Rate Range -->

						<div class="form-group">
							<label for="rate-range" style="padding:0px"><strong><span style="color:red;">*</span>Budget </strong></label>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_budget" id="radio_budget_1" value="$5-$20">
									$5-$20</label>
							</div>

							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_budget" id="radio_budget_2" value="Open Budget" >
									Open Budget</label>
							</div>

						</div>

						<div class="form-group" id='openBudgetField'>
							<label for="open-budget" style="padding:0px" ><strong><span style="color:red;">*</span>Specify budget </strong></label>
							<input type="text" class="form-control custom-text" name="openbudgetfield" id="openbudgetfield" >
						</div>

						<div id = "budget_message" style="color:red;font-size: 12px;"></div>
						<!--/Rate Range-->

						<!--Years of Experience -->

						<div class="form-group">
							<label for="years-of-experience" style="padding:0px"><strong><span style="color:red;">*</span>Level of Expertise </strong></label>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_expertise" id="radio_expertise_1" value="Jr.Level(1-2 Years)">
									Jr. Level (1-2 Years)</label>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_expertise" id="radio_expertise_2" value="Mid Level(3-4 Years)" >
									Mid-Level (3-4 Years)</label>
							</div>
							<div class="radio">
								<label class="radio-inline">
									<input type="radio" name="radio_expertise" id="radio_expertise_3" value="Sr.Level(5 and Up Years)" >
									Sr. Level (5 and Up Years)</label>
							</div>
						</div>
						<div id = "expertise_message" style="color:red;font-size: 12px;"></div>
						<!--/Years of Experience-->

						<!--Required Skills -->
						<div class="form-group desktop-box">
							<label for="required-skills" style="padding:0px"><strong><span style="color:red;">*</span>Top 3 Required Skills - These skills represent the skills that will be required to be used most of the time (say 80%)</strong></label>
							<textarea class="form-control custom-text" name="requiredskills" id="requiredskills" rows="5" ></textarea>
						</div>
						<!--/Required Skills-->
						<!--second tier Skills -->
						<div class="form-group desktop-box">
							<label for="required-skills" style="padding:0px"><strong><span style="color:red;">*</span>Second Tier Skills - These skills are those that may be good to have to address some additional activities some of the time (say 20%)</strong></label>
							<textarea class="form-control custom-text" name="secondtierskills" id="secondtierskills" rows="5" ></textarea>
						</div>
						<!--/Required Skills-->

						<!--Tasks to done -->

						<div class="form-group desktop-box">
							<label for="task-to-done" style="padding:0px"><strong><span style="color:red;">*</span>Top 3 Tasks - Identified tasks that require the use of the 'Top 3 Required Skills'</strong></label>
							<textarea class="form-control custom-text" name="requiredtasks" id="requiredtasks" rows="5" ></textarea>
						</div>
						<!--/Tasks to done-->
						
						<!--second tier to done -->

						<div class="form-group desktop-box">
							<label for="task-to-done" style="padding:0px"><strong><span style="color:red;">*</span>Second Tier Tasks - Identified tasks that require the use of the 'Second Tier Skills'</strong></label>
							<textarea class="form-control custom-text" name="secondtiertasks" id="secondtiertasks" rows="5" ></textarea>
						</div>
						<!--/Tasks to done-->

						<!--Personal Soft Skills -->

						<div class="form-group desktop-box">
							<label for="skills" style="padding:0px"><strong><span style="color:red;">*</span>Personal Soft Skills: </strong></label>
							<textarea class="form-control custom-text" name="personalskills" id="personalskills"rows="5"></textarea>
						</div>
						<!--/Personal Soft Skills-->

						<!--Education or Industry Experience -->

						<div class="form-group desktop-box">
							<label for="education" style="padding:0px" ><strong><span style="color:red;">*</span>Education or Industry Experience: </strong></label>
							<textarea class="form-control custom-text" name="education" id="education"rows="5"></textarea>
						</div>
						<!--/Education or Industry Experience-->

						<!--Additional Comments -->
						<div class="form-group">
							<label for="additional-comments" style="padding:0px"><strong>Additional Comments</strong></label>
							<textarea class="form-control custom-text" name="additional_comments" id="additionalcomments"rows="5"></textarea>
						</div>
						<!--/Additional Comments-->
						<br>
						<center><div class="panel panel-info">
								{*<div class="panel-heading">CAPTCHA</div>*}
								<div>
									<label class="text-muted" style="font-size: 12px;color:#14697d;padding: 12px;text-align: justify;line-height: 1.5;"><span style="color:red;">*</span>Show us you're not a robot. Enter the number on the screen.</label>

									{*captcha*}
									<br>
									<center><div class = "text-center" style="margin-bottom: 15px;">
											<input type="hidden" value={$rv2} name="rv2" id="rv2">
											<div>
												{$images} <input class="form-control custom-text" type="text" value="" name="pass3" id="pass3"  style="width:80px;display:initial !important;" maxlength="5" required="required">
											</div>
										</div></center>
								</div>
							</div></center>



						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg job-spec-submit" id ="job_spec_form">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Submit
							</button>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
	<div class= "col-lg-2 col-md-2"></div>
</div>

<div id="blackOut" style="display:none;"></div>
<div id="prompt"></div>