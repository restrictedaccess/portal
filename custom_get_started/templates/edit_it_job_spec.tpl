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
		<script type="text/javascript" src="js/edit_it.js"></script>
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
		<form method="POST" id="main-form" action="/portal/custom_get_started/update_it_js.php">
			<input type="hidden" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}"/>
			
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">System</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'system'}
								<tr>
									<td><input class="form-control" type="text" name="system[]" value="{$gs_cred.description}" placeholder="System"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="system_ratings[]">
											{foreach from=$option_ratings item=rating}
											{if $rating eq $gs_cred.rating}
											<option value="{$rating}" selected="">{$rating}</option>
											{else}
											<option value="{$rating}">{$rating}</option>
											{/if}
	
											{/foreach}
										</select>
										
									</td>
									<td>
										<button class="delete-creds btn btn-xs btn-danger">Delete</button>
									</td>
								</tr>
								{/if}
								{/foreach}
							</tbody>

						</table>
						
						<div class="panel-footer">
							<button class="add-system btn btn-default btn-xs">
								Add System
							</button>
						</div>
					</div>	
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Database</th>
									<th width="43%">Ratings</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'database'}
								<tr>
									<td><input class="form-control" type="text" name="database[]" value="{$gs_cred.description}" placeholder="Database"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="database_ratings[]">
											{foreach from=$option_ratings item=rating}
											{if $rating eq $gs_cred.rating}
											<option value="{$rating}" selected="">{$rating}</option>
											{else}
											<option value="{$rating}">{$rating}</option>
											{/if}
	
											{/foreach}
										</select>
										
									</td>
									<td>
										<button class="delete-creds btn btn-xs btn-danger">Delete</button>
									</td>
								</tr>
								{/if}
								{/foreach}
							</tbody>

						</table>
						<div class="panel-footer">
							<button class="add-database btn btn-default btn-xs">
								Add Database
							</button>
						</div>
					</div>	
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">PC &amp; Desktop</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'pc_products'}
								<tr>
									<td><input class="form-control" type="text" name="pc_products[]" value="{$gs_cred.description}" placeholder="PC & Desktop"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="pc_products_ratings[]">
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
						<div class="panel-footer">
							<button class="add-pc_products btn btn-default btn-xs">
								Add PC & Desktop
							</button>
						</div>
					</div>	
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Platforms/Environments</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'platforms'}
								<tr>
									<td><input class="form-control" type="text" name="platforms[]" value="{$gs_cred.description}" placeholder="Platforms"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="platforms_ratings[]">
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
						<div class="panel-footer">
							<button class="add-platforms btn btn-default btn-xs">
								Add Platforms/Environment
							</button>
						</div>
					</div>	
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Programming Language</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'app_programming'}
								<tr>
									<td><input class="form-control" type="text" name="app_programming[]" value="{$gs_cred.description}" placeholder="Programming Language"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="app_programming_ratings[]">
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
						<div class="panel-footer">
							<button class="add-programming btn btn-default btn-xs">
								Add Programming Language
							</button>
						</div>
					</div>	
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Multimedia</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'multimedia'}
								<tr>
									<td><input class="form-control" type="text" name="multimedia[]" value="{$gs_cred.description}" placeholder="Multimedia"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="multimedia_ratings[]">
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
						<div class="panel-footer">
							<button class="add-multimedia btn btn-default btn-xs">
								Add Multimedia
							</button>
						</div>
					</div>	
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-primary">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Open Source Softwares</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'open_source'}
								<tr>
									<td><input class="form-control" type="text" name="open_source[]" value="{$gs_cred.description}" placeholder="Open Source Softwares"/></td>
									<td>
										<select  class="form-control col-lg-6 col-md-6" name="open_source_ratings[]">
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
						<div class="panel-footer">
							<button class="add-open_source btn btn-default btn-xs">
								Add Open Source
							</button>
						</div>
					</div>	
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
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Additional Information
						</div>
						<div class="panel-body">
							<ol>
								<li>
									Is the staff going to be working with your IT offshore team ?
									<select name="onshore">
										{foreach from=$yesno item=yesno_item}
										{if $yesno_item eq $onshore}
										<option value="{$yesno_item}" selected="selected">{$yesno_item}</option>
										{else}
										<option value="{$yesno_item}">{$yesno_item}</option>
										{/if}
										{/foreach}
									</select>
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div align="center">
				<button class="btn btn-default back-js"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
				<button class="btn btn-primary" type="submit">Update Job Specification Form</button>
				
			</div>
		</form>
		
		<script type="text/x-handlebars-template" id="system-row">
			<tr>
				<td><input class="form-control" type="text" name="system[]" placeholder="System"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="system_ratings[]">
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
		<script type="text/x-handlebars-template" id="database-row">
			<tr>
				<td><input class="form-control" type="text" name="database[]" placeholder="Database"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="database_ratings[]">
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
		<script type="text/x-handlebars-template" id="pc_products-row">
			<tr>
				<td><input class="form-control" type="text" name="pc_products[]" placeholder="PC & Desktop"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="pc_products_ratings[]">
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
		<script type="text/x-handlebars-template" id="app_programming-row">
			<tr>
				<td><input class="form-control" type="text" name="app_programming[]" placeholder="Programming Language"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="app_programming_ratings[]">
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
		<script type="text/x-handlebars-template" id="platforms-row">
			<tr>
				<td><input class="form-control" type="text" name="platforms[]" placeholder="Platforms"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="platforms_ratings[]">
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
		<script type="text/x-handlebars-template" id="multimedia-row">
			<tr>
				<td><input class="form-control" type="text" name="multimedia[]" placeholder="Multimedia"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="multimedia_ratings[]">
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
		<script type="text/x-handlebars-template" id="open_source-row">
			<tr>
				<td><input class="form-control" type="text" name="open_source[]" placeholder="Open Source Software"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="open_source_ratings[]">
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
		
	</body>
</html>
