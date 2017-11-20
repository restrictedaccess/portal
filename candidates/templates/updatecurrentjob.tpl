<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Work Experience and Position Desired</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/portal/jobseeker/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="/portal/jobseeker/css/font-awesome.min.css"/>
		
		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/summernote/summernote.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/update_current_job.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<script type="text/javascript" src="/portal/media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/updatecurrentjob.css"/>
		<link rel="stylesheet" href="/portal/jobseeker/js/summernote/summernote.css"/>
		<link rel="stylesheet" href="/portal/jobseeker/js/summernote/summernote-bs2.css"/>
	</head>
	<body>

		<div class="container">
			<form class="well form-horizontal" method="POST" id="current-job-form" action="/portal/candidates/update_current_job_process.php">
				<legend>Work Experience and Position Desired</legend>
				<input type="hidden" name="userid" value="{$userid}"/>
				<input type="hidden" name="id" value="{$currentjob.id}"/>
				
				<div class="control-group">
					<label class="control-label">Current Status</label>
					<div class="controls">
						<label class="radio">
							<input type="radio" name="freshgrad" value="2" id="freshgrad_2" { if $currentjob.freshgrad eq 2}checked="checked"{ /if }/>I am still pursuing my studies and seeking internship or part-time jobs
						</label>
						<label class="radio">
							<input type="radio" name="freshgrad" value="1" id="freshgrad_1" { if $currentjob.freshgrad eq 1}checked="checked"{ /if }/>I am a fresh graduate seeking my first job
						</label>
						<label class="radio">
							<input type="radio" name="freshgrad" value="0" id="freshgrad_0" { if $currentjob.freshgrad eq 0}checked="checked"{ /if }/>I have been working for 
							<select name="years_worked" class="span2">
								 {section name=years loop=17}
								 	{if $smarty.section.years.index eq $currentjob.years_worked }
								 		<option value="{ $smarty.section.years.index }" selected="selected">
								 			{ $smarty.section.years.index }
								 		</option>
								 	{else}
								 		<option value="{ $smarty.section.years.index }">
								 			{ $smarty.section.years.index }
								 		</option>
								 	{/if}
			                    {/section}
							</select>
							year(s) and 
								<select name="months_worked" class="span2">
				                    {section name=months loop=12}
				                        <option value="{$smarty.section.months.index}"
				                            { if $smarty.section.months.index eq $currentjob.months_worked } 
				                                selected="selected"
				                            { /if }>
				                            {$smarty.section.months.index}
				                        </option>
				                    {/section}
				                </select>
				              month(s)
							</label>
						</div>
						
						
						<div class="control-group">
							<label class="control-label">Current Job Title</label>
							<div class="controls">
								<input type="text" class="span6" name="latest_job_title" value="{ $currentjob.latest_job_title }" placeholder="Current or Latest Job Title"/>
							</div>
						</div>
						
						
						<legend>Employment History (SKIP if applicant has no working experience)</legend>
						
						{section name=company loop=10}
							<div class="control-group">
								 {if $smarty.section.company.iteration eq 1}
				                    { assign var="companyname" value="companyname"}
				                {else}
				                    { assign var="companyname" value="companyname`$smarty.section.company.iteration`"}
				                {/if}
								<label class="control-label">Company Name {$smarty.section.company.iteration}</label>
								<div class="controls">
									<input type="text" class="span6" name="{$companyname}" value="{ $currentjob.$companyname }" placeholder="Company Name"/>
								</div>
							</div>
							<div class="control-group">
								{if $smarty.section.company.iteration eq 1}
				                    { assign var="position" value="position"}
				                {else}
				                    { assign var="position" value="position`$smarty.section.company.iteration`"}
				                {/if}
								<label class="control-label">Position </label>
								<div class="controls">
									<input type="text" class="span6" name="{$position}" value="{ $currentjob.$position }" placeholder="Position"/>
								</div>
							</div>
							<div class="control-group">
								 {if $smarty.section.company.iteration eq 1}
				                    { assign var="monthfrom" value="monthfrom" }
				                    { assign var="yearfrom" value="yearfrom" }
				                    { assign var="monthto" value="monthto" }
				                    { assign var="yearto" value="yearto" }
				                {else}
				                    { assign var="monthfrom" value="monthfrom`$smarty.section.company.iteration`" }
				                    { assign var="yearfrom" value="yearfrom`$smarty.section.company.iteration`" }
				                    { assign var="monthto" value="monthto`$smarty.section.company.iteration`" }
				                    { assign var="yearto" value="yearto`$smarty.section.company.iteration`" }
				                {/if}
								<label class="control-label">Employment Period: </label>
								<div class="controls">
									<select name="{ $monthfrom }" class="span2">
					                    { foreach from=$month_array item=month}
					                        { if $month ne 'Present'}
					                            <option value="{ $month }"
					                                { if $currentjob.$monthfrom eq $month}
					                                    selected="selected"
					                                { /if }
					                            >
					                                { $month }
					                            </option>
					                        { /if }
					                    { /foreach }
					                </select>
					
					                <select name="{ $yearfrom }" class="span2">
					                    <option value=""></option>
					                    { section name=year loop=$current_year max=80 step=-1}
					                        <option value="{ $smarty.section.year.index }"
					                            { if $smarty.section.year.index eq $currentjob.$yearfrom }
					                                selected="selected"
					                            { /if }
					                        >
					                            { $smarty.section.year.index }
					                        </option>
					                    { /section }
					                </select>
					
					                <select name="{ $monthto }" class="span2">
					                    { foreach from=$month_array item=month}
					                        <option value="{ $month }"
					                            { if $currentjob.$monthto eq $month}
					                                selected="selected"
					                            { /if }
					                            { if $currentjob.$monthto|substr:0:7 eq $month|substr:0:7}
					                                selected="selected"
					                            { /if }
					                        >
					                            { $month }
					                        </option>
					                    { /foreach }
					                </select>
					
					                <select name="{ $yearto }" class="span2">
					                    <option value=""></option>
					                    <option value="Present"
					                        { if $currentjob.$yearto eq 'Present' }
					                            selected="selected"
					                        { /if }
					                    >
					                        Present
					                    </option>
					                    { section name=year loop=$current_year max=80 step=-1}
					                        <option value="{ $smarty.section.year.index }"
					                            { if $smarty.section.year.index eq $currentjob.$yearto }
					                                selected="selected"
					                            { /if }
					                        >
					                            { $smarty.section.year.index }
					                        </option>
					                    { /section }
					                </select>
								</div>
								
							</div>
							
							<div class="control-group">
								{if $smarty.section.company.iteration eq 1}
				                    { assign var="duties" value="duties" }
				                {else}
				                    { assign var="duties" value="duties`$smarty.section.company.iteration`" }
				                {/if}
								<label class="control-label">Responsibilities</label>
								
				                {strip}
								<div class="controls">
									<textarea name="{ $duties }" rows="8" class="span6"> { $currentjob.$duties }</textarea>
								</div>
								{/strip}
							</div>
							
							{foreach from=$salary_grades item=salary_grade}
								{if $smarty.section.company.iteration eq $salary_grade.index}
									{ assign var="starting_salary_grade" value=$salary_grade.starting_grade}
									{ assign var="ending_salary_grade" value=$salary_grade.ending_grade}
									{ assign var="benefits" value=$salary_grade.benefits}
								{/if}
							{/foreach}
							
							{foreach from=$previous_job_industries item=previous_job_industry}
								{if $smarty.section.company.iteration eq $previous_job_industry.index}
									{ assign var="work_setup_type" value=$previous_job_industry.work_setup_type}
									{ assign var="industry_id" value=$previous_job_industry.industry_id}
									{ assign var="campaign" value=$previous_job_industry.campaign}
									
								{/if}
							{/foreach}
							<div class="control-group">
								<label class="control-label">Work Setup: </label>
								<div class="controls">
									<select name="work_setup_type_{$smarty.section.company.iteration}">
										<option value="">Select Work Setup</option>
										{foreach from=$work_types item=work_type}
											{if $work_setup_type eq $work_type}
												<option value="{$work_type}" selected="selected">{$work_type}</option>												
											{else}
												<option value="{$work_type}">{$work_type}</option>
											{/if}
										{/foreach}
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">Industry: </label>
								<div class="controls">
									<select name="industry_id_{$smarty.section.company.iteration}" class="industry span6" data-index="{$smarty.section.company.iteration}">
										<option value="">Select Industry</option>
										{foreach from=$defined_industries item=defined_industry}
											{if $industry_id eq $defined_industry.id}
												<option value="{$defined_industry.id}" selected="selected">{$defined_industry.value}</option>												
											{else}
												<option value="{$defined_industry.id}">{$defined_industry.value}</option>
											{/if}
										{/foreach}
									</select>
								</div>
							</div>
							<div class="control-group campaign_controls" id="campaign_{$smarty.section.company.iteration}" {if $industry_id neq '10'}style="display:none"{/if}>
								<label class="control-label">Campaign: </label>
								<div class="controls">
									<input type="text" maxlength="255" name="campaign_{$smarty.section.company.iteration}" value="{$campaign}" placeholder="Campaign" class="span6"/>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">Salary Grade: </label>
								<div class="controls">
									<input type="text" value="{$starting_salary_grade}" name="starting_salary_grade_{$smarty.section.company.iteration}" placeholder="Starting Salary Grade" class="span3"/>
									<input type="text" value="{$ending_salary_grade}" name="ending_salary_grade_{$smarty.section.company.iteration}" placeholder="Ending Salary Grade" class="span3"/>
								</div>
							</div>
							<div class="control-group"  style="margin-bottom:3em;border-bottom:1px solid #e3e3e3">
								<label class="control-label">Benefits: </label>
								<div class="controls" style="padding-bottom:10px;">
									<input type="text" value="{$benefits}" name="benefits_{$smarty.section.company.iteration}" placeholder="Benefits" class="span6"/>
								</div>
							</div>
							
							
							
							{ assign var="starting_salary_grade" value=""}
							{ assign var="ending_salary_grade" value=""}
							{ assign var="benefits" value=""}
							{ assign var="work_setup_type" value=""}
							{ assign var="industry_id" value=""}
							{ assign var="campaign" value=""}
					
						{/section}
						
						
						<legend>Others</legend>
						<div class="control-group">
							<label class="control-label">Availability Status</label>
							<div class="controls">
								<label class="radio">
									<input type="radio" name="available_status" value="a" id="available_status_a" 
						            { if $currentjob.available_status eq 'a'}
						                checked="checked"
						            { /if }
						            />
									I can start work after 
									{ strip }
							            <select name="available_notice" class="span2">
							                <option value=""></option>
							                { section name=available_notice loop=12 }
							                    <option value="{ $smarty.section.available_notice.index }"
							                        { if $smarty.section.available_notice.index eq $currentjob.available_notice}
							                            selected="selected"
							                        { /if }
							                    >
							                        { $smarty.section.available_notice.index }
							                    </option>
							                { /section }
							            </select>
						            { /strip } week(s) of notice period 
								</label>
								<label class="radio">
									 <input type="radio" name="available_status" value="b" id="available_status_b" 
						            { if $currentjob.available_status eq 'b'}
						                checked="checked"
						            { /if }
						            />
									I can start work after 
									<select name="aday" class="span2">
						                <option value=""></option>
						                { section name=aday loop=31 }
						                    <option value="{ $smarty.section.aday.iteration }"
						                        { if $smarty.section.aday.iteration eq $currentjob.aday }
						                            selected="selected"
						                        { /if }
						                    >
						                        { $smarty.section.aday.iteration }
						                    </option>
						                { /section }
						            </select>
						             - 
						            <select name="amonth" class="span2">
						                <option value=""></option>
						                { section name=month loop=12 }
						                    { assign var="month_date" value="`$current_year`-`$smarty.section.month.iteration`-01"}
						                    <option value="{ $month_date|date_format:"%B" }"
						                        { if $month_date|date_format:"%B" eq $currentjob.amonth }
						                            selected="selected"
						                        { /if }
						                    >
						                        { $month_date|date_format:"%B" }
						                    </option>
						                { /section }
						            </select>
						            - 
						            <input class="span1" type=text name="ayear" size=4 maxlength=4 style='width=50px' value='{ $currentjob.ayear }'/>
						            
            						(YYYY)
								</label>
								<label class="radio">
									 <input type="radio" name="available_status" value="p" id="available_status_p" 
						            { if $currentjob.available_status eq 'p'}
						                checked="checked"
						            { /if }
						            />
						            I am not actively looking for a job now
								</label>
								<label class="radio">
									<input type="radio" name="available_status" value="Work Immediately" id="available_status_work_immediate" 
						            { if $currentjob.available_status eq 'Work Immediately'}
						                checked="checked"
						            { /if }
						            />
						            Work Immediately
								</label>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label">Expected Salary</label>
							<div class="controls">
								Expected Monthly Salary:
								<select name="salary_currency" class="span2">
					                <option value=""></option>
					                { foreach from=$currency_array item=currency }
					                    <option value="{ $currency }"
					                        { if $currentjob.salary_currency eq $currency }
					                        selected="selected"
					                        { /if }
					                    >
					                        { $currency }
					                    </option>
					                { /foreach }
					            </select>
					             <input type="text" name="expected_salary" maxlength="15" 
	                			size="16" value="{ $currentjob.expected_salary }" class="span2"/>
					            <input type="checkbox" value="Yes" name="expected_salary_neg" id="expected_salary_neg"
					                { if $currentjob.expected_salary_neg eq "Yes"}
					                    checked="checked"
					                { /if }
					            /> 
					            Negotiable
							</div>
							
				            
						</div>
						<legend>Position Desired</legend>
						<div class="control-group">
							<label class="control-label">First Choice</label>
							<div class="controls">
								<select name="position_first_choice" class="span3">
									{$position_first_choice_options}
								</select><br/>
								any experience doing this role? {$position_first_choice_exp_options}
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Second Choice</label>
							<div class="controls">
								<select name="position_second_choice" class="span3">
								{$position_second_choice_options}
								</select><br/>
								any experience doing this role? {$position_second_choice_exp_options}
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Third Choice</label>
							<div class="controls">
								<select name="position_third_choice" class="span3">
								{$position_third_choice_options}
								</select><br/>
								any experience doing this role? {$position_third_choice_exp_options}
							</div>
						</div>
						
						
						<legend>Character References</legend>
						<div id="character_references">
							{foreach from=$character_references item=character_reference name=character_reference_list}
								<div class="character_reference">
									<div class="control-group">
										{$smarty.foreach.character_reference_list.iteration}.)
										<button class="btn btn-mini remove_character_reference" style="float:right"><i class="icon-remove"></i>Delete</button>
									</div>
									<div class="control-group">
										<label class="control-label">Name</label>
										<div class="controls">
											<input type="text" class="span6" value="{$character_reference.name}" name="name[]"/>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Contact Details</label>
										<div class="controls">
											<textarea name="contact_details[]" rows="8" class="span6">{$character_reference.contact_details}</textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Contact Number</label>
										<div class="controls">
											<input type="text" class="span6" value="{$character_reference.contact_number}" name="contact_number[]"/>
										</div>
									</div>
									<div class="control-group" style="margin-bottom:3em">
										<label class="control-label">Email Address</label>
										<div class="controls">
											<input type="text" class="span6 character_email_address" value="{$character_reference.email_address}" name="email_address[]"/>
										</div>
									</div>
								</div>
								
								
							{/foreach}
						</div>
						
						<button class="btn btn-mini" id="add_new_character_reference">
							<i class="icon-plus"></i> Add New Character Reference
						</button>
						
					</div>
				
				<button class="btn btn-primary" id="save_changes_button">
					Save Changes
				</button>
			</form>
		</div>
		
	</body>
</html>