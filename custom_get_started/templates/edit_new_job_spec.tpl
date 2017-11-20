<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<!-- include files -->
		<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
		<link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
		<link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />
		<link rel="stylesheet" href="/portal/recruiter/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="/portal/custom_get_started/css/job_spec_admin.css" type="text/css"/>
		
		
		<script type="text/javascript" src="/portal/custom_get_started/js/jquery-1.7.2.min.js"></script>
		<script src="/portal/custom_get_started/js/bootstrap/js/bootstrap.min.js"></script>
		<script src="/portal/custom_get_started/js/jquery.ba-bbq.min.js" type="text/javascript"></script>

		<script type="text/javascript" src="/portal/custom_get_started/js/modernzr.js"></script>
		<script type="text/javascript" src="/portal/sms/js/ui/minified/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/sms/css/jquery-ui.min.css">
		<script type="text/javascript" src="/portal/custom_get_started/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/custom_get_started/js/handlebars.js"></script>
		
		<script type="text/javascript" src="/portal/custom_get_started/js/edit_new_js.js"></script>
		<link rel="stylesheet" href="css/index.css" type="text/css"/>
		<!-- /include files -->
		<title> Job Specification Form - {$gs_jtd.selected_job_title} </title>
	</head>
	<body>
		<div class="col-lg-12">
			<img src="/remotestaff_2015/img/rs-logo.png">
			<p style="font-size: 18px; color: #777; margin: 0px 5px 10px;">Relationships You Can Rely On</p>
		</div>
		<div class="col-lg-12" align="center">
			<div class="page-header">
				<h3><strong>{$gs_jtd.selected_job_title} - {$gs_jtd.level} Level</strong></h3>
			</div>
		</div>
		<div>
			<!-- main form -->
			<form method="POST" id="main-form" action="/portal/custom_get_started/update_new_js.php">
			<input type="hidden" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}"/>
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Required Skills
						</div>
						<div class="panel-body">
							<div>
								<div class="col-lg-1 col-md-1 col-xs-1">
									<strong>Display Skills</strong>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-6">
									<strong>Required Skills</strong>
								</div>
								<div class="col-lg-5 col-md-5 col-xs-5">
									<strong>Ratings</strong>
								</div>						
							</div>
							<div id="required-skill-div">
                            
							{foreach from=$required_skills item=required_skill}
								{assign var="found" value=false}
								{assign var="ratings" value=0}
								
								{foreach from=$gs_creds item=gs_cred}
									{if $gs_cred.box eq 'skills' and $gs_cred.description eq $required_skill.id}
										{assign var="found" value=true}
										{assign var="ratings" value=$gs_cred.rating}
										
									{/if}
								{/foreach}
								<div style="margin-bottom:5px;clear: both;overflow:hidden">
									<div class="col-lg-1 col-md-1 col-xs-1">
										{if $found}
											<input type="checkbox" name="skills[]" value="{$required_skill.id}" checked="checked"/>
										{else}
											<input type="checkbox" name="skills[]" value="{$required_skill.id}"/>
										{/if}
										<input type="hidden" name="skill-items[]" value="{$required_skill.id}"/>
									</div>
									<div class="col-lg-6 col-md-6 col-xs-6">
										{$required_skill.value}
									</div>		
									<div class="col-lg-5 col-md-5 col-xs-5">
										<select name="ratings[]" class="form-control">
											{foreach from=$ratings_skills item=rating_skill}
												{if $ratings eq $rating_skill.value}
													<option value="{$rating_skill.value}" selected>{$rating_skill.label}</option>
												{else}
													<option value="{$rating_skill.value}">{$rating_skill.label}</option>
												
												{/if}
											{/foreach}
										</select>
									</div>
								</div>
							{/foreach}
							</div>
						</div>
						<div class="panel-footer">
						    <button class="btn btn-default add-skill-task" data-type="skill" data-sub_category_id="{$gs_jtd.sub_category_id}" data-gs_job_titles_details_id="{$gs_jtd.gs_job_titles_details_id}">Add Skill</button>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Required Tasks
						</div>
						
						<div class="panel-body">
							<div>
								<div class="col-lg-1 col-md-1 col-xs-1">
									<strong>Display Task</strong>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-6">
									<strong>Required Task</strong>
								</div>
								<div class="col-lg-5 col-md-5 col-xs-5">
									<strong>Ratings</strong>
								</div>						
							</div>
							<div id="required-task-div">
                            {foreach from=$required_tasks item=required_task}
                                {assign var="found" value=false}
                                {assign var="ratings" value=0}
                                
                                {foreach from=$gs_creds item=gs_cred}
                                    {if $gs_cred.box eq 'tasks' and $gs_cred.description eq $required_task.id}
                                        {assign var="found" value=true}
                                        {assign var="ratings" value=$gs_cred.rating}
                                        
                                    {/if}
                                {/foreach}
                                <div style="margin-bottom:5px;clear: both;overflow:hidden">
                                    <div class="col-lg-1 col-md-1 col-xs-1">
                                        {if $found}
                                            <input type="checkbox" name="tasks[]" value="{$required_task.id}" checked="checked"/>
                                        {else}
                                            <input type="checkbox" name="tasks[]" value="{$required_task.id}"/>
                                        {/if}
                                        <input type="hidden" name="task-items[]" value="{$required_task.id}"/>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-6">
                                        {$required_task.value}
                                    </div>      
                                    <div class="col-lg-5 col-md-5 col-xs-5">
                                        <select name="ratings-tasks[]" class="form-control">
                                            {foreach from=$ratings_tasks item=ratings_task}
                                                {if $ratings eq $ratings_task}
                                                    <option value="{$ratings_task}" selected>{$ratings_task}</option>
                                                {else}
                                                    <option value="{$ratings_task}">{$ratings_task}</option>
                                                
                                                {/if}
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            {/foreach}							    
							</div>

						</div>
						<div class="panel-footer">
                            <button class="btn btn-default add-skill-task" data-type="task" data-sub_category_id="{$gs_jtd.sub_category_id}" data-gs_job_titles_details_id="{$gs_jtd.gs_job_titles_details_id}">Add Task</button>
                        </div>
					</div>
				</div>
			</div>
			
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Duties and Responsibilities
						</div>
						<div class="panel-body" id="responsibilities-div">
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'responsibility'}
							
									<div>
										<div class="col-lg-11 col-md-11">
											<textarea name="responsibility[]" rows="2" style="width:100%">{$gs_cred.description}</textarea>						
										</div>
										<div class="col-lg-1 col-md-1">
											<button class="delete-creds btn btn-xs btn-danger">Delete</button>	
										</div>
									</div>
								{/if}
							{/foreach}

						</div>
						<div class="panel-footer">
							<button class="add-duties btn btn-default btn-xs">
								Add Duties and Responsibilities
							</button>

						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Other desirable/preferred skills, personal attributes and knowledge
						</div>
						<div class="panel-body" id="preferred-skill-div">
							{foreach from=$gs_creds item=gs_cred}
							{if $gs_cred.box eq 'other_skills'}
									<div>
										<div class="col-lg-11 col-md-11">
											<textarea name="other_skills[]" rows="2" style="width:100%">{$gs_cred.description}</textarea>
											
										</div>
										<div class="col-lg-1 col-md-1">
											<button class="delete-creds btn btn-xs btn-danger">Delete</button>	
										</div>
									</div>
										
									{/if}
								{/foreach}

						</div>
						<div class="panel-footer">
							<button class="add-other-preferred-skills btn btn-default btn-xs">
								Add Other Preferred Skills etc.
							</button>

						</div>
					</div>
				</div>
			</div>
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Other Relevant Job Order Information
						</div>
					</div>
					<div class="panel-body">
						<p>Will you provide training to the staff?
								<select name="staff_provide_training">
									<option value="">-</option>
									{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $staff_provide_training}
											<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
											<option value="{$yesno_item}">{$yesno_item}</option>										
										{/if}
									{/foreach}
								</select>
						</p>
						<p>Will the staff need to make calls?
								<select name="staff_make_calls">
									<option value="">-</option>
									{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $staff_make_calls}
											<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
											<option value="{$yesno_item}">{$yesno_item}</option>										
										{/if}
									{/foreach}
								</select>
						</p>
						<p>Is this the first you are hiring a staff for this position?
							
								<select name="staff_first_time">
									<option value="">-</option>
									{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $staff_first_time}
											<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
											<option value="{$yesno_item}">{$yesno_item}</option>										
										{/if}
									{/foreach}
								</select>
						</p>
						<p>
							Will the staff report directly to you?

								<select name="staff_report_directly">
									<option value="">-</option>
									{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $staff_report_directly}
											<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
											<option value="{$yesno_item}">{$yesno_item}</option>										
										{/if}
									{/foreach}
								</select>
						</p>
					</div>
				</div>
			</div>
			
			
			
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary ">
						<div class="panel-heading">
							Special Instruction
						</div>
						<div class="panel-body">
							
							<textarea name="special_instruction" rows="6" style="width:100%">{$special_instruction}</textarea>
							
						</div>
					</div>
				</div>
			</div>
			
			<div align="center">
				<button class="btn btn-default back-js"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
				<button class="btn btn-primary" type="submit">Update Job Specification Form</button>
				
			</div>
			</form>
			
		{include file="add_skill_task_modal.tpl"}
	    {literal}
		<script type="text/x-handlebars-template" id="skill-row">
			<div style="margin-bottom:5px;clear: both;overflow:hidden">
                <div class="col-lg-1 col-md-1 col-xs-1">
                    
                    <input type="checkbox" name="skills[]" value="{{id}}"/>
                    
                    <input type="hidden" name="skill-items[]" value="{{id}}"/>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6">
                    {{value}}
                </div>      
                <div class="col-lg-5 col-md-5 col-xs-5">
                    <select name="ratings[]" class="form-control">
                        {{#each items}}
                            <option value="{{this.i}}">{{this.label}}</option>
                        {{/each}}
                    </select>
                </div>
            </div>
		</script>
		{/literal}
		{literal}
		<script type="text/x-handlebars-template" id="task-row">
			<div style="margin-bottom:5px;clear: both;overflow:hidden">
                <div class="col-lg-1 col-md-1 col-xs-1">
                   <input type="checkbox" name="tasks[]" value="{{id}}"/>
                   <input type="hidden" name="task-items[]" value="{{id}}"/> 
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6">
                    {{value}}
                </div>      
                <div class="col-lg-5 col-md-5 col-xs-5">
                    <select name="ratings-tasks[]" class="form-control">
                        {{#each items}}
                            <option value="{{this}}">{{this}}</option>
                        {{/each}}
                    </select>
                </div>
            </div>
		</script>
		{/literal}
		<script type="text/x-handlebars-template" id="responsibility-row">
			<div>
				<div class="col-lg-11 col-md-11">
					<textarea name="responsibility[]" rows="2" style="width:100%" placeholder="Enter Duties and Responsibilities"></textarea>
				</div>
				<div class="col-lg-1 col-md-1">
					<button class="delete-creds btn btn-xs btn-danger">Delete</button>	
				</div>
			</div>
		</script>

		<script type="text/x-handlebars-template" id="preferred-skill-row">
			<div>
				<div class="col-lg-11 col-md-11">
					<textarea name="other_skills[]" rows="2" style="width:100%" placeholder="Enter Other desirable/preferred skills"></textarea>
				</div>
				<div class="col-lg-1 col-md-1">
					<button class="delete-creds btn btn-xs btn-danger">Delete</button>	
				</div>
			</div>
		</script>
	</body>
</html>
