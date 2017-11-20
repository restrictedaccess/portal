{include file="header.tpl" }
<div class="container">
	<h1 class="intro"> Thank you for trusting us to find you the right professional. <br> Please fill in the needed information below so we can begin.</h1>
</div>
<!-- STEP 1 WRAPPER START -->
<div class="step_1">
	<!-- STEP 1 CONTAINER START -->
	<div class="container">
		<!-- STEP 1 NAVIGATION START -->
		<div class="page-header" style="margin: 20px 0px 15px; padding-bottom: 5px;">
			<h3 style="margin:0px;" class="navigation"> <i class="steps-sprite step-1"></i> <a href="/portal/custom_get_started/"> About You </a> </h3>
		</div>
		<!-- STEP 1 NAVIGATION END -->
		<!-- STEP 1 FORM START -->
		<form id="register-form">
			<div class="row">
				<div class="col-lg-7 col-lg-offset-1 col-md-7 col-md-offset-1 col-sm-12 col-xs-12">
					<p> If you already have an account, please click <a href="#" class="login-launcher">here</a></p>
					<!-- REMOTE STAFFING START -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<h4 style="font-weight:500; color: #333;">Have you tried outsourcing or remote staffing before?</h4>
								<label class="radio-inline">
									<input type="radio" name="tried_staffing" id="remote-staffing-yes" value="Yes" {if isset($leads_details) and $leads_details.outsourcing_experience == 'Yes'}checked="checked"{/if}> Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="tried_staffing" id="remote-staffing-no" value="No" {if isset($leads_details) and $leads_details.outsourcing_experience == 'No'}checked="checked"{/if}> No
								</label>
							</div>
						</div>
					</div>
					<!-- REMOTE STAFFING END -->
					<p style="font-size:11px; color:#000000;">Fields with <span class="text-danger">*</span> are required.</p>
					<!-- NAME START -->
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="first_name">First name:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="{if isset($leads_details)}{$leads_details.fname}{/if}" {if isset($leads_details)}readonly="readonly"{/if} >
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="last_name">Last name:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" value="{if isset($leads_details)}{$leads_details.lname}{/if}" {if isset($leads_details)}readonly="readonly"{/if} />
							</div>
						</div>
					</div>
					<!-- NAME END -->
					<!-- COMPANY NAME START -->
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="company_name">Company name:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company name" value="{if isset($leads_details)}{$leads_details.company_name}{/if}" />
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="company_position">Position in the company:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="company_position" placeholder="Position in the company" value="{if isset($leads_details)}{$leads_details.company_position}{/if}" />
							</div>
						</div>
					</div>
					<!-- COMPANY NAME END -->
					<!-- COMPANY CONTACT START-->
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="company_phone">Company phone:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="company_phone" placeholder="Company phone" value="{if isset($leads_details)}{$leads_details.officenumber}{/if}" />
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="mobile_phone">Mobile phone:<span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="mobile_phone" placeholder="Mobile phone" value="{if isset($leads_details)}{$leads_details.mobile}{/if}" />
							</div>
						</div>
					</div>
					<!-- COMPANY CONTACT END-->
					<!-- EMAIL ADDRESS START -->
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="email_address_text">Email address:<span class="text-danger">*</span></label>
								<input id="email_address_text" type="text" class="form-control" name="email_address" placeholder="Email address" value="{if isset($leads_details)}{$leads_details.email}{/if}" {if isset($leads_details)}readonly="readonly"{/if} />
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="alt_email">Alternate email</label>
								<input type="text" class="form-control" id="alt_email" name="alt_email" placeholder="Alternate email" value="{if isset($leads_details)}{$leads_details.sec_email}{/if}" />
							</div>
						</div>
					</div>
					<!-- EMAIL ADDRESS END -->
					<!-- BUSINESS ADDRESS START -->
					<!--
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="business_address">Business address:<span class="text-danger">*</span></label>
								<textarea class="form-control" id="business_address" name="business_address" placeholder="Business Address" rows="5" cols="30">{if isset($leads_details)}{$leads_details.company_address}{/if}</textarea>
							</div>
						</div>
					</div>
					-->
					<!-- BUSINESS ADDRESS END -->
					<!-- ADDRESS START -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label>Address:</label>
								<input type="text" name="leads_address" id="leads_address" placeholder="Address" class="form-control" value="">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Country:</label>
										<select id="leads_country" name="leads_country" class="form-control chosen" data-placeholder="Country">
											<option value=""></option>
											{foreach from=$countries key=id item=cty}
												<option value="{$id}" {if $country.id eq $id}selected="selected"{/if}>{$cty}</option>
											{/foreach}
										</select>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>State:</label>
										<select id="leads_state" name="leads_state" class="form-control chosen" data-placeholder="State">
											<option value=""></option>
											{foreach from=$states key=id item=state}
												<option value="{$id}">{$state}</option>
											{/foreach}
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
										<input type="text" id="leads_zip_code" name="leads_zip_code" class="form-control" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ADDRESS END -->
					<!-- COMPANY REVENUE START -->
					<div class="row">
						<!--
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Company revenue:</label>
							<input type="text" name="company_revenue" placeholder="Company revenue"/>
						</div>
						-->
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<label for="existing_team_size">Existing team size:</label>
								<!--<input type="text" class="form-control" id="existing_team_size" name="existing_team_size" placeholder="Existing team size" value="{if isset($leads_details)}{$leads_details.company_size}{/if}" />-->
								<select id="existing_team_size" name="existing_team_size" class="form-control chosen" data-placeholder="Existing team size">
									<option value=""></option>
									<option value="self-employed">Self-employed</option>
									<option value="1-3">1-3</option>
									<option value="4-9">4-9</option>
									<option value="10-19">10-19</option>
									<option value="20-29">20-29</option>
									<option value="30-49">30-49</option>
									<option value="50-99">50-99</option>
									<option value="100-200">100-200</option>
									<option value="201-500">201-500</option>
									<option value="500+">500+</option>
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
								<textarea class="form-control" id="company_description" name="company_description" placeholder="Company description" rows="5" cols="30">{if isset($leads_details)}{$leads_details.company_description}{/if}</textarea>
							</div>
						</div>
					</div>
					<!-- COMPANY DESCRIPTION END -->
					<button id="continue_btn" type="submit" class="btn btn-primary"> Continue <i class="glyphicon glyphicon-menu-right"></i></button>
				</div>
			</div>
		</form>
		<!-- STEP 1 FORM END -->
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
	</div>
	<!-- STEP 1 CONTAINER END -->
</div>
<!-- STEP 1 WRAPPER END -->
<!-- MODAL START -->
{include file="login_modal.tpl"}
<!-- MODAL END -->
{include file="footer.tpl" }
