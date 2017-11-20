{include file="header.tpl" }
{literal}
<style type="text/css">
	.error-validation{
		margin-bottom:15px;
	}
	.form-group {
		margin-bottom: 5px;
	}
</style>
{/literal}
<div class="container">
	<h1 class="intro"> Thank you for letting us help find the right person. <br> Please fill in the needed information below so we can begin.</h1>
</div>
<!-- STEP 2 WRAPPER START -->
<div class="step_2">
	<!-- STEP 2 CONTAINER START -->
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
		<form id="job_role_selection_form">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p style="font-size:11px; color:#000000;">Fields with <span class="text-danger">*</span> are required.</p>
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
							<div class="well well-small">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Select currency:<span class="text-danger">*</span></label>
											<select id="currency" name="currency" class="form-control currency-select update-price chosen" data-placeholder="Currency">
												<option value=""></option>
												<option value="AUD" {if isset($leads_country) and $leads_country eq 'AU'}selected="selected"{/if}>AUD</option>
												<option value="GBP" {if isset($leads_country) and $leads_country eq 'GB'}selected="selected"{/if}>GBP</option>
												<option value="USD" {if isset($leads_country) and $leads_country eq 'US'}selected="selected"{/if}>USD</option>
											</select>
										</div>
									</div>
								</div>
								<p style="margin-top:20px;">Please fill up the form below to describe the job position you are looking for.</p>
								<div id="job_order_list">
									{if isset($job_order_details) and count($job_order_details)}
										{foreach from=$job_order_details key=k item=job_order_detail}
											<div class="row">
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
													<div class="form-group">
														<select name="category[]" class="form-control category-select update-price chosen" data-placeholder="Category">
															<option value=""></option>
															{foreach from=$categories item=category}
																<option value="{$category.category.id}" {if $job_order_detail.category_id eq $category.category.id }selected="selected"{/if}>{$category.category.name}</option>
															{/foreach}
														</select>
													</div>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<div class="form-group">
														<select name="sub_category[]" class="form-control sub-category-select update-price chosen" data-placeholder="Subcategory">
															<option value=""></option>
															{foreach from=$subcategories[$k] item=subcategory}
																<option value="{$subcategory.sub_category_id}" {if $job_order_detail.sub_category_id eq $subcategory.sub_category_id }selected="selected"{/if}>{$subcategory.sub_category_name}</option>
															{/foreach}
														</select>
													</div>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<div class="form-group">
														<select name="level[]" class="form-control level-select update-price chosen" data-placeholder="Level">
															<option value=""></option>
															<option value="entry" {if $job_order_detail.level eq 'entry' }selected="selected"{/if}>Entry (1 - 3 years)</option>
															<option value="mid" {if $job_order_detail.level eq 'mid' }selected="selected"{/if}>Mid Level (3 - 5 years)</option>
															<option value="advanced" {if $job_order_detail.level eq 'expert' }selected="selected"{/if}>Expert (More than 5 years)</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<div class="form-group">
														<select name="work_status[]" class="form-control work-status-select update-price chosen" data-placeholder="Work time">
															<option value=""></option>
															<option value="Full-Time" {if $job_order_detail.work_status eq 'Full-Time' }selected="selected"{/if}>Full Time 9 hrs with 1 hr break</option>
															<option value="Part-Time" {if $job_order_detail.work_status eq 'Part-Time' }selected="selected"{/if}>Part Time 4 hrs</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<div class="form-group">
														<input type="text" placeholder="No. of staff" name="no_of_staff" class="form-control no_of_staff update-price-text" value="{$job_order_detail.no_of_staff_needed}"/>
													</div>
												</div>
												{if $k ne 0}<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><button class="btn btn-danger btn-sm remove-row"><i class="glyphicon glyphicon-remove"></i></button></div>{/if}
											</div>
										{/foreach}
									{else}
										<div class="row">
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="category[]" class="form-control category-select update-price chosen" data-placeholder="Category">
														<option value=""></option>
														{foreach from=$categories item=category}
															<option value="{$category.category.id}">{$category.category.name}</option>
														{/foreach}
													</select>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="sub_category[]" class="form-control sub-category-select update-price chosen" data-placeholder="Subcategory">
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="level[]" class="form-control level-select update-price chosen" data-placeholder="Level">
														<option value=""></option>
														<option value="entry">Entry (1 - 3 years)</option>
														<option value="mid">Mid Level (3 - 5 years)</option>
														<option value="advanced">Expert (More than 5 years)</option>
													</select>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<select name="work_status[]" class="form-control work-status-select update-price chosen" data-placeholder="Work time">
														<option value=""></option>
														<option value="Full-Time">Full Time 9 hrs with 1 hr break</option>
														<option value="Part-Time">Part Time 4 hrs</option>
													</select>
												</div>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												<div class="form-group">
													<input type="text" placeholder="No. of staff" name="no_of_staff" class="form-control no_of_staff update-price-text" value="1" />
												</div>
											</div>
										</div>
									{/if}
								</div>
								{if not $disable_add }
								<!-- ADD POSITION BUTTON START -->
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<button class="btn btn-primary" id="add_position" type="button" style="margin-top: 20px;"><i class="glyphicon glyphicon-plus"></i> Add Job Position</button>
									</div>
								</div>
								<!-- ADD POSITION BUTTON END -->
								{/if}
							</div>
							<p>Prices listed are monthly wages and are the best estimations of your potential montly cost.</p>
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
									{if isset($job_order_currency_details) and count($job_order_currency_details)}
										{foreach from=$job_order_currency_details key=k item=job_order_currency_detail name=job_order_currency}
											<tr>
												<td>{$smarty.foreach.job_order_currency.iteration}</td>
												<td>{$job_order_currency_detail.category_name}</td>
												<td>{$job_order_currency_detail.sub_category_name}</td>
												<td>{$job_order_currency_detail.level}</td>
												<td>{$job_order_currency_detail.no_of_staff}</td>
												{if isset($job_order_currency_detail.value) and $job_order_currency_detail.value ne '' }
													<td><strong>{$job_order_currency_detail.currency} {$job_order_currency_detail.currency_symbol} {$job_order_currency_detail.hourly_value} hourly</strong> /<br/>  {$job_order_currency_detail.currency_symbol} {$job_order_currency_detail.value} Monthly</td>
												{else}
													<td>N/A</td>
												{/if}
											</tr>
										{/foreach}
									{/if}
								</tbody>
							</table>
							<button class="btn btn-primary" id="continue-step-3" type="submit">Continue to Step 3 <i class="glyphicon glyphicon-menu-right"></i></button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- STEP 3 NAVIGATION START -->
		<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
			<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-3"></i> <a href="/portal/custom_get_started/step3.php"> Please tell us more about the job roles. </a> </h3>
		</div>
		<!-- STEP 3 NAVIGATION END -->
	</div>
	<!-- STEP 2 CONTAINER END -->
</div>
<!-- STEP 2 WRAPPER END -->
<!-- HANDLEBARS CATEGORY ROW START -->
{literal}
<script type="text/x-handlebars-template" id="category_row">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">
				<select id="category-{{counter}}" name="category[]" class="form-control category-select update-price chosen" data-placeholder="Category">
					<option value=""></option>
					{/literal}
						{foreach from=$categories item=category}
							<option value="{$category.category.id}">{$category.category.name}</option>
						{/foreach}
					{literal}
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<select id="sub-category-{{counter}}" name="sub_category[]" class="form-control sub-category-select update-price requiredField-{{counter}} chosen" data-placeholder="Subcategory">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<select id="level-{{counter}}" name="level[]" class="form-control level-select update-price requiredField-{{counter}} chosen" data-placeholder="Level">
					<option value=""></option>
					<option value="entry">Entry (1 - 3 years)</option>
					<option value="mid">Mid Level (3 - 5 years)</option>
					<option value="advanced">Expert (More than 5 years)</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<select id="work-status-{{counter}}" name="work_status[]" class="form-control work-status-select update-price requiredField-{{counter}} chosen" data-placeholder="Work time">
					<option value=""></option>
					<option value="Full-Time">Full Time 9 hrs with 1 hr break</option>
					<option value="Part-Time">Part Time 4 hrs</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<input type="text" placeholder="No. of staff" id="no-of-staff-{{counter}}" name="no_of_staff" class="form-control no_of_staff update-price-text requiredField-{{counter}}" value="1"/>
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
{include file="footer.tpl" }
