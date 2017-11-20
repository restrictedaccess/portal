{include file="header.tpl" }
{literal}
	<style type="text/css">
		form#job_role_selection_form .form-group {
			margin-bottom: 5px;
		}
		.help-block {
			margin-top: 0px;
		}
	</style>
{/literal}
{if isset($leads_details) }
	<script type="text/javascript">
		var leads_address_country_id = {if isset($leads_details.leads_address_country_id)}'{$leads_details.leads_address_country_id}'{else}''{/if};
		var leads_address_state_id = {if isset($leads_details.leads_address_state_id)}'{$leads_details.leads_address_state_id}'{else}''{/if};
		var leads_address_city_id = {if isset($leads_details.leads_address_city_id)}'{$leads_details.leads_address_city_id}'{else}''{/if};
	</script>
{/if}
<!-- INTRO START -->
<div class="container">
	<h1 class="text-center" style="margin: 40px 0px 0px;"> Job Order Preview </h1>
</div>
<!-- INTRO END -->

<!-- JOB ORDER PREVIEW START -->
<div class="job_order_preview">

	<!-- JOB ORDER PREVIEW CONTAINER START -->
	<div class="container">
		
		<!-- ACCORDION START -->
		<div id="accordion" role="tablist" aria-multiselectable="true">

			<!-- STEP 1 NAVIGATION START --> 
			<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
				<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-1"></i> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#stepOne" aria-expanded="true" aria-controls="stepOne"> About You </a> </h3>
			</div>
			<!-- STEP 1 NAVIGATION END -->
			
			{ if $edit_step_1 }
			
				<!-- STEP 1 PANEL START -->
				<div id="stepOne" class="panel-collapse collapse in" role="tabpanel">

					<!-- STEP 1 FORM START -->
					<form id="update-step-one">
						<input id="leads_id" name="leads_id" type="hidden" value="{if isset($leads_details)}{$leads_details.leads_id}{/if}" />
						<div class="row">
							<div class="col-lg-7 col-lg-offset-1 col-md-7 col-md-offset-1 col-sm-12 col-xs-12">
							
								<!-- REMOTE STAFFING START -->
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<h4 style="font-weight:500; color: #333;">Have you tried outsourcing or remote staffing before?</h4>
											<label class="radio-inline">
												<input type="radio" name="tried_staffing" value="Yes" {if isset($leads_details) and $leads_details.leads_company_tried_staffing == 'Yes'}checked="checked"{/if}> Yes
											</label>
											<label class="radio-inline">
												<input type="radio" name="tried_staffing" value="No" {if isset($leads_details) and $leads_details.leads_company_tried_staffing == 'No'}checked="checked"{/if}> No
											</label>
										</div>
									</div>
								</div>
								<!-- REMOTE STAFFING END -->
								
								<p style="font-size:11px; color:#000000;">"Fields with <span class="text-danger">*</span> are required fields."</p>
								
								<!-- NAME START -->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="first_name">First name:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="{if isset($leads_details)}{$leads_details.leads_profile_firstname}{/if}" {if isset($leads_details)}readonly="readonly"{/if} >
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="last_name">Last name:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="{if isset($leads_details)}{$leads_details.leads_profile_lastname}{/if}" {if isset($leads_details)}readonly="readonly"{/if} />
										</div>
									</div>
								</div>
								<!-- NAME END -->
								
								<!-- COMPANY NAME START -->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="company_name">Company name:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company name" value="{if isset($leads_details)}{$leads_details.leads_company_name}{/if}" />
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="company_position">Position in the company:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="company_position" placeholder="Position in the company" value="{if isset($leads_details)}{$leads_details.leads_company_position}{/if}" />
										</div>
									</div>
								</div>
								<!-- COMPANY NAME END -->
								
								<!-- COMPANY CONTACT START-->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="company_phone">Company phone:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="company_phone" placeholder="Company phone" value="{if isset($leads_details)}{$leads_details.leads_company_office_no}{/if}" />
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="mobile_phone">Mobile phone:<span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="mobile_phone" placeholder="Mobile phone" value="{if isset($leads_details)}{$leads_details.leads_profile_mobile_no}{/if}" />
										</div>
									</div>
								</div>
								<!-- COMPANY CONTACT END-->
								
								<!-- EMAIL ADDRESS START -->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="email_address_text">Email address:<span class="text-danger">*</span></label> 
											<input id="email_address_text" type="text" class="form-control" name="email_address" placeholder="Email address" value="{if isset($leads_details)}{$leads_details.leads_profile_primary_email_address}{/if}" {if isset($leads_details)}readonly="readonly"{/if} />
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="alt_email">Alternate email</label>
											<input type="text" class="form-control" id="alt_email" name="alt_email" placeholder="Alternate email" value="{if isset($leads_details)}{$leads_details.leads_profile_secondary_email_address}{/if}" />
										</div>
									</div>
								</div>
								<!-- EMAIL ADDRESS END -->

								<!-- ADDRESS START -->
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Address:</label>
											<input type="text" name="leads_address" id="leads_address" placeholder="Address" class="form-control" value="{if isset($leads_details)}{$leads_details.leads_address}{/if}">
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="row">
											<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
												<div class="form-group">
													<label>Country:</label>
													<select id="leads_country" name="leads_country" class="form-control chosen" data-placeholder="Country">
														<option value=""></option>
														{foreach from=$countries key=id item=country}
															<option value="{$id}">{$country}</option>
														{/foreach}
													</select>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<label>State:</label>
													<select id="leads_state" name="leads_state" class="form-control chosen" data-placeholder="State">
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<label>City:</label>
													<select id="leads_city" name="leads_city" class="form-control chosen" data-placeholder="City">
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<label>Zip code:</label>
													<input type="text" id="leads_zip_code" name="leads_zip_code" class="form-control" value="{if isset($leads_details) and $leads_details.leads_address_zip_code neq 0 }{$leads_details.leads_address_zip_code}{/if}" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- ADDRESS END -->
								
								<!-- COMPANY REVENUE START -->
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group">
											<label for="existing_team_size">Existing team size:</label>
											<select id="existing_team_size" name="existing_team_size" class="form-control chosen" data-placeholder="Existing team size">
												<option value=""></option>
												<option value="self-employed" {if isset($leads_details) and $leads_details.leads_company_size eq "self-employed"}selected="selected"{/if}>Self-employed</option>
												<option value="1-3" {if isset($leads_details) and $leads_details.leads_company_size eq "1-3"}selected="selected"{/if}>1-3</option>
												<option value="4-9" {if isset($leads_details) and $leads_details.leads_company_size eq "4-9"}selected="selected"{/if}>4-9</option>
												<option value="10-19" {if isset($leads_details) and $leads_details.leads_company_size eq "10-19"}selected="selected"{/if}>10-19</option>
												<option value="20-29" {if isset($leads_details) and $leads_details.leads_company_size eq "20-29"}selected="selected"{/if}>20-29</option>
												<option value="30-49" {if isset($leads_details) and $leads_details.leads_company_size eq "30-49"}selected="selected"{/if}>30-49</option>
												<option value="50-99" {if isset($leads_details) and $leads_details.leads_company_size eq "50-99"}selected="selected"{/if}>50-99</option>
												<option value="100-200" {if isset($leads_details) and $leads_details.leads_company_size eq "100-200"}selected="selected"{/if}>100-200</option>
												<option value="201-500" {if isset($leads_details) and $leads_details.leads_company_size eq "201-500"}selected="selected"{/if}>201-500</option>
												<option value="500+" {if isset($leads_details) and $leads_details.leads_company_size eq "500+"}selected="selected"{/if}>500+</option> 
											</select>
										</div>
									</div>
								</div>
								<!-- COMPANY REVENUE END -->
								
								<!-- COMPANY DESCRIPTION START -->
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label for="company_description">Company description:</label>
											<p><i><small class="text-muted">Tell us more about you. <br> The more information you provide the easier we can match candidates based on your business needs.</small></i></p>
											<textarea class="form-control" name="company_description" placeholder="Company description" rows="5" cols="30">{if isset($leads_details)}{$leads_details.leads_company_description}{/if}</textarea>
										</div>
									</div>
								</div>
								<!-- COMPANY DESCRIPTION END -->

								<button id="update_step_one_btn" type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-floppy-saved"></i> Update Step 1 </button>

							</div>
						</div>
					</form>
					<!-- STEP 1 FORM END -->
					
				</div>
				<!-- STEP 1 PANEL END -->
			
			{/if}
			
			<!-- STEP 2 NAVIGATION START -->
			<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
				<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-2"></i> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#stepTwo" aria-expanded="true" aria-controls="stepTwo"> What are you looking for? </a> </h3>
			</div>
			<!-- STEP 2 NAVIGATION END -->
			
			<!-- STEP 2 PANEL START -->
			<div id="stepTwo" class="panel-collapse collapse in" role="tabpanel">
			
				<!-- STEP 2 FORM START -->
				<form id="job_role_selection_form">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<p style="font-size:11px; color:#000000;">"Fields with <span class="text-danger">*</span> are required fields."</p>
							
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="well well-small">
										<div class="row">
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<label>Select currency:<span class="text-danger">*</span></label>
													<select id="currency" name="currency" class="form-control currency-select update-price chosen-without-search" data-placeholder="Currency">
														<option value=""></option>
														<option value="AUD" {if isset($job_role_details) and $job_role_details.details.currency eq 'AUD'}selected="selected"{/if}>AUD</option>
														<option value="GBP" {if isset($job_role_details) and $job_role_details.details.currency eq 'GBP'}selected="selected"{/if}>GBP</option>
														<option value="USD" {if isset($job_role_details) and $job_role_details.details.currency eq 'USD'}selected="selected"{/if}>USD</option>
													</select>
												</div>
											</div>
										</div>
										
										<p style="margin-top:20px;">Please fill up the form below to describe the job position you are looking for.</p>
										
										<!-- JOB ROLE LIST START-->
										<div id="job_role_list">
											{include file="job_roles.tpl" }
										</div>
										<!-- JOB ROLE LIST END--> 
										
										{ if $add_position }
										<!-- ADD POSITION BUTTON START -->
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<button class="btn btn-primary add-row" type="button" style="margin-top: 20px;"><i class="glyphicon glyphicon-plus"></i> Add Job Position</button>
											</div>
										</div>
										<!-- ADD POSITION BUTTON END -->
										{ /if }
										
									</div>
									<p>Prices listed are monthly wage and are best estimations that could ranges as much as $180 in some positions.</p>
									<table class="table table-bordered table-striped" id="pricing_table">
										<thead>
											<tr>
												<th class="text-center" width="5%">#</th>
												<th width="15%">Category</th>
												<th width="25%">Job Position</th>
												<th width="10%">Level</th>
												<th width="20%">No. of Staff Required</th>
												<th width="20%">Rates</th>
											</tr>
										</thead>
										<tbody>
											{foreach from=$job_role_details.job_orders_rate key=k item=job_order_rate name=job_orders_rate}
												<tr>
													<td>{$smarty.foreach.job_orders_rate.iteration}</td>
													<td>{$job_order_rate.category_name}</td>
													<td>{$job_order_rate.sub_category_name}</td>
													<td>{$job_order_rate.level}</td>
													<td>{$job_order_rate.no_of_staff_needed}</td>
													{if isset($job_order_rate.rate.value) and $job_order_rate.rate.value ne '' }
														<td><strong>{$job_order_rate.rate.currency} {$job_order_rate.rate.sign} {$job_order_rate.rate.hourly} hourly</strong> /<br/>  {$job_order_rate.rate.sign} {$job_order_rate.rate.monthly} monthly</td>
													{else}
														<td>N/A</td>
													{/if}
												</tr>
											{/foreach}
										</tbody>
									</table>
									<button id="update_step_two_btn" type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-floppy-saved"></i> Update Step 2 </button>
								</div>
							</div>
						</div>
					</div>
				</form> 
				<!-- STEP 2 FORM END -->

			</div>
			<!-- STEP 2 PANEL END -->

			<!-- STEP 3 NAVIGATION START -->
			<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
				<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-3"></i> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#stepThree" aria-expanded="true" aria-controls="stepThree"> Please tell us more about the job roles. </a> </h3>
			</div>
			<!-- STEP 3 NAVIGATION END -->
			
			<!-- STEP 3 PANEL START --> 
			<div id="stepThree" class="panel-collapse collapse in" role="tabpanel">
				
				<p style="font-size:11px; color:#000000;">"Fields with <span class="text-danger">*</span> are required fields."</p>
				
				<!-- STEP 3 CONTAINER START -->
				<div class="row">
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
						<!-- JOB ORDER LIST START-->
						<div id="job_order_list">
							{include file="job_orders.tpl" }
						</div>
						<!-- JOB ORDER LIST END-->
						
					</div>
					
				</div>
				<!-- STEP 3 CONTAINER END -->
				
			</div>
			<!-- STEP 3 PANEL END -->
		
		</div>
		<!-- ACCORDION END -->
		
	</div>
	<!-- JOB ORDER PREVIEW CONTAINER END -->
		
</div>
<!-- JOB ORDER PREVIEW END -->

<!-- HANDLEBARS CATEGORY ROW START -->
{literal}
<script type="text/x-handlebars-template" id="category_row">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">
				<select name="new_category[]" class="form-control category-select update-price chosen-without-search" data-placeholder="Category">
					<option value=""></option>
					{/literal}
						{foreach from=$categories key=id item=category}
							<option value="{$id}">{$category}</option>
						{/foreach}
					{literal}
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">			
				<select name="new_sub_category[]" class="form-control sub-category-select update-price chosen-without-search" data-placeholder="Subcategory">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">						
				<select name="new_level[]" class="form-control level-select update-price chosen-without-search" data-placeholder="Level">
					<option value=""></option>
					<option value="entry">Entry (1 - 3 years)</option>
					<option value="mid">Mid Level (3 - 5 years)</option>
					<option value="advanced">Expert (More than 5 years)</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">	
				<select name="new_work_status[]" class="form-control work-status-select update-price chosen-without-search" data-placeholder="Work time">
					<option value=""></option>
					<option value="Full-Time">Full Time 9 hrs with 1 hr break</option>
					<option value="Part-Time">Part Time 4 hrs</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<input type="text"  name="new_no_of_staff[]" class="form-control no_of_staff update-price-text" placeholder="No. of staff needed" value="1" />
			</div>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
			<button class="btn btn-danger btn-sm remove-row" type="button"><i class="glyphicon glyphicon-remove"></i></button>
		</div>
	</div>
</script>
{/literal}
<!-- HANDLEBARS CATEGORY ROW END -->	
<!-- HANDLEBARS PRICING TAB ROW START -->	
{literal}
	<script type="text/x-handlebars-template" id="pricing_table_row"> 
		<tr>
			<td class="text-center" style="vertical-align:middle">{{i}}</td>
			<td style="vertical-align:middle">{{category_name}}</td>
			<td style="vertical-align:middle">{{sub_category_name}}</td>
			<td style="vertical-align:middle">{{level}}</td>
			<td style="vertical-align:middle">{{no_of_staff}}</td>
			{{#if value}}
				<td><strong>{{currency}} {{currency_symbol}} {{hourly_value}} hourly</strong> /<br/>  {{currency_symbol}} {{value}} Monthly</td>
			{{else}}
				<td>N/A</td>
			{{/if}}
		</tr>
	</script>
{/literal}
<!-- HANDLEBARS PRICING TAB ROW END -->
<!-- HANDLEBARS REPONSIBILITY ROW START -->
{literal}
	<script type="text/x-handlebars-template" id="responsibility-row">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<textarea name="responsibility[{{job_order_id}}][]" rows="2" class="form-control" placeholder="Other duties and responsibilities"></textarea>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
				</div>
			</div>
		</div>
	</script>
{/literal}
<!-- HANDLEBARS REPONSIBILITY ROW END -->
<!-- HANDLEBARS OTHER SKILLS ROW START -->
{literal}
	<script type="text/x-handlebars-template" id="other-skills-row">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<textarea name="other_skills[{{job_order_id}}][]" rows="2" class="form-control" placeholder="Other desirable/preferred skills, personal attributes and knowledge"></textarea>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<button class="btn btn-danger btn-mini delete-creds"><i class="glyphicon glyphicon-remove"></i> Delete</button>
				</div>
			</div>
		</div>
	</script>
{/literal}
<!-- HANDLEBARS OTHER SKILLS ROW END -->

<!-- MODAL START -->
{include file="skills_modal.tpl"}
{include file="tasks_modal.tpl"}
<!-- MODAL END -->

{include file="footer.tpl" }
