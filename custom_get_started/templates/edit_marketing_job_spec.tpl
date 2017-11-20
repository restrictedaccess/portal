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
		<link rel="stylesheet" href="css/index.css" type="text/css"/>
		<!-- /include files -->
		<title> Job Specification Form - {$gs_jtd.selected_job_title} </title>

		<script type="text/javascript" src="js/edit_marketing.js"></script>
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
		<!-- main form -->
		<form method="POST" id="main-form" action="/portal/custom_get_started/update_marketing_js.php">
			<input type="hidden" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}"/>
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Requirements and Skills
						</div>
						
						<table class="table table-bordered" id="skills-requirements-div">
							<thead>
								<tr>
									<th width="50%">Requirement and Skills</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'requirement'}
								<tr>
									<td>
									<input class="form-control" type="text" name="requirement[]" value="{$gs_cred.description}"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="requirement_ratings[]">
										{foreach from=$option_ratings item=rating}
										{if $rating eq $gs_cred.rating}
										<option value="{$rating}" selected="">{$rating}</option>
										{else}
										<option value="{$rating}">{$rating}</option>
										{/if}

										{/foreach}
									</select></td>
									<td>
										<button class="delete-creds btn btn-xs btn-danger">Delete</button>
									</td>

								</tr>
								{/if}

								{if $gs_cred.box eq 'requirement_others'}
								<tr>
									<td>
									<input type="text"  class="form-control" name="requirement_others[]" value="{$gs_cred.description}"/>
									</td>
									<td>
									<select  class="form-control" name="requirement_others_ratings[]">
										{foreach from=$option_ratings item=rating}
										{if $rating eq $gs_cred.rating}
										<option value="{$rating}" selected="">{$rating}</option>
										{else}
										<option value="{$rating}">{$rating}</option>
										{/if}

										{/foreach}
									</select></td>
									<td>
										<button class="delete-creds btn btn-xs btn-danger">Delete</button>
									</td>

								</tr>
								{/if}
								{/foreach}
							</tbody>

						</table>
						<div class="panel-body">
							<button class="add-skills-requirements btn btn-default btn-xs">
								Add Skills/Requirements
							</button>
						</div>
					</div>
				</div>
			</div>
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					
					{if $telemarketer_flag}
						<p>Type of Campaign ? 
							<select name="campaign_type">
								{foreach from=$campaign_types item=campaign_type}
									{if $campaign_type eq $selected_campaign_type}
									<option value="{$campaign_type}" selected="selected">{$campaign_type}</option>								
									{else}
									<option value="{$campaign_type}">{$campaign_type}</option>
									{/if}
								{/foreach}
							</select>
							
							</p>
						<p>Call Type ?
							<select name="call_type">
							{foreach from=$call_types item=call_type}
								{if $call_type eq $selected_call_type}
								<option value="{$call_type}" selected="selected">{$call_type}</option>								
								{else}
								<option value="{$call_type}">{$call_type}</option>
								{/if}
							{/foreach}
							</select>
						</p>
					{/if}
					{if $marketing_assistant_flag}
						<p>Do you need your staff to be on the phone ?
							<select name="staff_phone">
							{foreach from=$yesno item=yesno_item}
								{if $yesno_item eq $selected_staff_phone}
								<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>								
								{else}
								<option value="{$yesno_item}">{$yesno_item}</option>
								{/if}
							{/foreach}
							</select>
						</p>
					{/if}
				</div>
				
			</div>
			
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
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
			
			{if $writer_flag}
				<div>
					<div class="col-lg-12 col-md-12 col-xs-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Writer Types
							</div>
							<div class="panel-body" id="writer-type-div">
								{foreach from=$gs_creds item=gs_cred}
									{if $gs_cred.box eq 'writer_type'}
										<div class="clearfix">
											<div class="col-lg-6 col-md-6 col-xs-6">
												<select name="writer_types[]" class="form-control">
													{foreach from=$writer_type_options item=writer_type_option}
														{if $gs_cred.description eq $writer_type_option}
															<option value="{$writer_type_option}" selected="selected">{$writer_type_option}</option>
														{else}
															<option value="{$writer_type_option}">{$writer_type_option}</option>														
														{/if}
													{/foreach}
												</select>
											</div>
											<div class="col-lg-4 col-md-4 col-xs-4">
												<button class="btn btn-danger btn-xs delete-creds">delete</button>
											</div>
										</div>
									{/if}
								{/foreach}
							</div>
							<div class="panel-footer">
								<button class="add-writer-type btn btn-default btn-xs">
									Add Writer Type
								</button>
							</div>
						</div>
					</div>
				</div>
			{/if}
			
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
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
					<div class="panel panel-primary">
						<div class="panel-heading">
							Comments/Special Instruction
						</div>
						<div class="panel-body">
							<textarea name="comments" rows="2" style="width:100%" placeholder="Comments/Special Instruction">{$comments}</textarea>
						</div>
					</div>
				</div>
			</div>
			{if $telemarketer_flag}
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Additional Information
						</div>
						<div class="panel-body">
							<ol>
								<li>
									Is this an existing campaign ?
									<select name="q1">
										{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $q1}
										<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
										<option value="{$yesno_item}">{$yesno_item}</option>
										{/if}
										{/foreach}
									</select>

									<br/>
									Do you have someone onshore or offshore calling out for you ?
									<select name="q2">
										{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $q2}
										<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
										<option value="{$yesno_item}">{$yesno_item}</option>
										{/if}
										{/foreach}
									</select>
								</li>
								<li>
									Will you provide the lead or do you expect your telemarketer to do lead generation as well?
									<input type="text" name="lead_generation" value="{$lead_generation}" style="line-height: 12px"/>
								</li>
								<li>
									Is the telemarketer going to call your client database ?
									<select name="q3">
										{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $q3}
										<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
										<option value="{$yesno_item}">{$yesno_item}</option>
										{/if}
										{/foreach}
									</select>

								</li>
								<li>
									What is the goal at the end of each call ?
									<select name="q4">
										{foreach from=$q4_items item=q4_item}
										{if $q4_item eq $q4}
										<option value="{$q4_item}" selected="selected">{$q4_item}</option>
										{else}
										<option value="{$q4_item}">{$q4_item}</option>
										{/if}
										{/foreach}
									</select>
								</li>
								<li>
									How many contacts do you expect your telemarketer to make in 4 hours (part time) ? in 8 hours (full time) ?
									<input type="text" name="telemarketer_hrs" value="{$telemarketer_hrs}" style="line-height: 12px"/>
								</li>

							</ol>
						</div>
					</div>
				</div>
			</div>
			{/if}
			
			<div align="center">
				<button class="btn btn-default back-js"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
				<button class="btn btn-primary" type="submit">Update Job Specification Form</button>
				
			</div>
		</form>
		<!-- /main form -->

		<script type="text/x-handlebars-template" id="requirement-row">
			<tr>
			<td><input class="form-control" type="text" name="requirement[]" placeholder="Enter Requirement/Skills"/></td>
			<td>
			<select  class="form-control col-lg-6 col-md-6" name="requirement_ratings[]">
			{foreach from=$option_ratings item=rating}
			<option value="{$rating}">{$rating}</option>
			{/foreach}
			</select>
			</td>
			<td>
				<button class="delete-creds btn btn-xs btn-danger">Delete</button>
			</td>

			</tr>
		</script>

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
		<script type="text/x-handlesbars-template" id="writer-row">
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<select name="writer_types[]" class="form-control">
						{foreach from=$writer_type_options item=writer_type_option}
								<option value="{$writer_type_option}">{$writer_type_option}</option>														
						{/foreach}
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4">
					<button class="btn btn-danger btn-xs delete-creds">delete</button>
				</div>
			</div>
		</script>
	</body>

</html>
