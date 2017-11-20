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
		
		<script type="text/javascript" src="js/edit_office.js"></script>
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
		<form method="POST" id="main-form" action="/portal/custom_get_started/update_office_js.php">
			<input type="hidden" name="gs_job_titles_details_id" value="{$gs_jtd.gs_job_titles_details_id}"/>

			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">General</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'general'}
								<tr>
									<td>
									<input class="form-control" type="text" name="general[]" value="{$gs_cred.description}" placeholder="General"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="general_ratings[]">
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
							<button class="add-general btn btn-default btn-xs">
								Add General
							</button>
						</div>
						
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">

						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts/Clerk</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_clerk'}
								<tr>
									<td>
									<input class="form-control" type="text" name="accounts_clerk[]" value="{$gs_cred.description}" placeholder="Accounts/Clerk"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="accounts_clerk_ratings[]">
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
							<button class="add-accounts_clerk btn btn-default btn-xs">
								Add Accounts/Clerk
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts Payable</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_payable'}
								<tr>
									<td>
									<input class="form-control" type="text" name="accounts_payable[]" value="{$gs_cred.description}" placeholder="Accounts Payable"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="accounts_payable_ratings[]">
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
							<button class="add-accounts_payable btn btn-default btn-xs">
								Add Accounts Payable
							</button>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">

						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounts Receivable</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounts_receivable'}
								<tr>
									<td>
									<input class="form-control" type="text" name="accounts_receivable[]" value="{$gs_cred.description}" placeholder="Accounts Receivable"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="accounts_receivable_ratings[]">
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
							<button class="add-accounts_receivable btn btn-default btn-xs">
								Add Accounts Receivable
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Accounting Package</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'accounting_package'}
								<tr>
									<td>
									<input class="form-control" type="text" name="accounting_package[]" value="{$gs_cred.description}" placeholder="Accounting Package"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="accounting_package_ratings[]">
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
							<button class="add-accounting_package btn btn-default btn-xs">
								Add Accounting Package
							</button>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">

						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Bookkeeper</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'bookkeeper'}
								<tr>
									<td>
									<input class="form-control" type="text" name="bookkeeper[]" value="{$gs_cred.description}" placeholder="Book Keeper"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="bookkeeper_ratings[]">
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
							<button class="add-bookkeeper btn btn-default btn-xs">
								Add Bookkeeper
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="col-lg-6 col-md-6 col-xs-6">
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="50%">Payroll</th>
									<th width="43%">Ratings</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$gs_creds item=gs_cred}
								{if $gs_cred.box eq 'payroll'}
								<tr>
									<td>
									<input class="form-control" type="text" name="payroll[]" value="{$gs_cred.description}" placeholder="Payroll"/>
									</td>
									<td>
									<select  class="form-control col-lg-6 col-md-6" name="payroll_ratings[]">
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
							<button class="add-payroll btn btn-default btn-xs">
								Add Payroll
							</button>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="panel panel-default">
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
					<div class="panel panel-default">
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
					<div class="panel panel-default">
						<div class="panel-heading">
							Comments/Special Instruction
						</div>
						<div class="panel-body">
							<textarea name="comments" rows="2" style="width:100%" placeholder="Comments/Special Instruction">{$comments}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div align="center">
				<button class="btn btn-default back-js"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
				<button class="btn btn-primary" type="submit">
					Update Job Specification Form
				</button>
				
			</div>
		</form>
		
		<script type="text/x-handlebars-template" id="general-row">
			<tr>
				<td><input class="form-control" type="text" name="general[]" placeholder="General"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="general_ratings[]">
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
		
		<script type="text/x-handlebars-template" id="accounts_clerk-row">
			<tr>
				<td><input class="form-control" type="text" name="accounts_clerk[]" placeholder="Accounts/Clerk"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="accounts_clerk_ratings[]">
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
		
		<script type="text/x-handlebars-template" id="accounts_payable-row">
			<tr>
				<td><input class="form-control" type="text" name="accounts_payable[]" placeholder="Accounts Payable"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="accounts_payable_ratings[]">
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
		
		<script type="text/x-handlebars-template" id="accounts_receivable-row">
			<tr>
				<td><input class="form-control" type="text" name="accounts_receivable[]" placeholder="Accounts Receivable"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="accounts_receivable_ratings[]">
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
		<script type="text/x-handlebars-template" id="accounting_package-row">
			<tr>
				<td><input class="form-control" type="text" name="accounting_package[]" placeholder="Accounting Package"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="accounting_package_ratings[]">
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
		
		<script type="text/x-handlebars-template" id="bookkeeper-row">
			<tr>
				<td><input class="form-control" type="text" name="bookkeeper[]" placeholder="Book Keeper"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="bookkeeper_ratings[]">
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
		
		<script type="text/x-handlebars-template" id="payroll-row">
			<tr>
				<td><input class="form-control" type="text" name="payroll[]" placeholder="Payroll"/></td>
				<td>
					<select  class="form-control col-lg-6 col-md-6" name="payroll_ratings[]">
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
