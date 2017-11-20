{include file="header.tpl" }
<!-- STEP 4 WRAPPER START -->
<div class="step_4">
	<!-- STEP 4 CONTAINER START -->
	<div class="container"> 
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="intro">Please tell us more about these job role(s)</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<form method="POST" action="/portal/custom_get_started/register.php" id="register-form">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<p class="reqd">Optional.</p>
						</div>
					</div>
					{foreach from=$job_orders item=job_order}
					<div class="well well-small">
						<label class="control-label"><strong>{$job_order.selected_job_title}</strong></label>
						<input type="hidden" name="gs_job_titles_details_id[]" value="{$job_order.gs_job_titles_details_id}"/>
						<input type="hidden" name="gs_job_role_selection_id[]" value="{$job_order.gs_job_role_selection_id}"/>
						<div class="radio">
						  <label>
							<input type="checkbox" name="increase_demand[]"/>
							This role needed because of increase demand of your product or services
						  </label>
						</div>
						<div class="radio">
						  <label>
							<input type="checkbox" name="replacement_post[]"/>
							This role a replacement of a post someone is leaving or has already left
						  </label>
						</div>
						<div class="radio">
						  <label>
							<input type="checkbox" name="support_current[]"/>
							This role needed to add support to your current work needs
						  </label>
						</div>		
						<div class="radio">
						  <label>
							<input type="checkbox" name="experiment_role[]"/>
							This new role a test, experiment role for your company never before done
						  </label>
						</div>	
						<div class="radio">
						  <label>
							<input type="checkbox" name="meet_new[]"/>
							This new role to meet the need of new services, products or capacities in your company
						  </label>
						</div>
					</div>
					{/foreach}
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button class="btn btn-default" id="skip" type="button">Skip <i class="glyphicon glyphicon-step-forward"></i></button>
							<button class="btn btn-primary" id="continue-step-4" type="button">Continue <i class="glyphicon glyphicon-menu-right"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- STEP 4 CONTAINER END -->
</div>
<!-- STEP 4 WRAPPER END -->
{include file="footer.tpl" }
