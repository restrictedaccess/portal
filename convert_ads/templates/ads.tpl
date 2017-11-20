<!DOCTYPE  html>
<!-- html -->



<html lang="en">
	<!-- head -->
	<head>
		<!-- META DATA START -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- title -->
		<title>Remote Staff | {$posting.jobposition}</title>
		<!-- /title -->
	
		<!-- META DATA END -->
		<link rel="stylesheet" href="/portal/recruiter/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="/portal/convert_ads/css/ads.css" type="text/css"/>
	</head>
	<!-- /head -->

	<!-- body -->
	<body>
		<div class="container">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div class="row ads-body">
					<div class="header-body">
						<div class="col-lg-1">
							<img src="/portal/convert_ads/images/convert-pin1.png"/>
						</div>
						<div class="col-lg-10">
							<img src="/portal/convert_ads/images/rs-logo.png" style="width:60%;padding-top:20px;"/>
							<div class="logo-sub-header">
								Relationships You Can Rely On
							</div>
							<div class="ads-header">
								{$ads_header}
							</div>
							<div style="text-align:left">
								<div>
									<b>Work Status:</b> {$job_spec.work_status}
								</div>
								<div>
									<b>Level:</b> {$job_spec_level} Level - {$posting.jobposition}
								</div>
								<div>
									<b>Work Schedule:</b> Asia/Manila  {$ads_start_work} - {$ads_finish_work}
								</div>
								<div>
									<b>Outsourcing Model:</b> {$posting.outsourcing_model}
								</div>
								<div>
									<b>No. of Staff Needed:</b> {$posting.jobvacancy_no}
								</div>

							</div>
							<div id="heading-content">
								{$posting.heading}
							</div>
						</div>
						<div class="col-lg-1">
							<img src="/portal/convert_ads/images/convert-pin2.png"/>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="req-res-attr">
						
							<div class="req-res-attr-header">Skill(s) / Requirements:</div>
							
							<!--CHECK ANY EXISTING DATA FROM OUR CONVERTED POSTING DATA-->
							{if count($converted_posting_requirements_neutral) or count($converted_posting_requirements_must_have) or count($converted_posting_requirements_good_to_have)}
							
								<!-- CHECK ANY EXISTING DATA FROM CONVERTED MUST HAVE AND GOOD TO HAVE
								{if count($converted_posting_requirements_must_have) or count($converted_posting_requirements_good_to_have)}
							
									<!-- IF CONVERTED POSTING REQUIREMENT MUST HAVE DO EXIST -->
									{if count($converted_posting_requirements_must_have)}
										<div class="must-good-attr-header">Must have:</div>
										<ul>
											{foreach from=$converted_posting_requirements_must_have item=converted_posting_requirement_must_have}
												<li>{$converted_posting_requirement_must_have.requirement}</li>
											{/foreach}
										</ul>
									{/if}
								
									<!-- IF CONVERTED POSTING REQUIREMENT GOOD TO HAVE DO EXIST -->
									{if count($converted_posting_requirements_good_to_have)}
										<div class="must-good-attr-header">Good to have:</div>
										<ul>
											{foreach from=$converted_posting_requirements_good_to_have item=converted_posting_requirement_good_to_have}
												<li>{$converted_posting_requirement_good_to_have.requirement}</li>
											{/foreach}
										</ul>
									{/if}
									
								{else}
								
									<!-- IF CONVERTED POSTING REQUIREMENT NEUTRAL DO EXIST -->
									<ul>
										{foreach from=$converted_posting_requirements_neutral item=converted_posting_requirement_neutral}
											<li>{$converted_posting_requirement_neutral.requirement}</li>
										{/foreach}
									</ul>
								
								{/if}
								
							{else}
							
								{if count($requirements_must_to_have) and count($requirements_good_to_have)}
								
									<!-- IF POSTING REQUIREMENT MUST HAVE DO EXIST -->
									{if count($requirements_must_to_have)}
										<div class="must-good-attr-header">Must have:</div>
										<ul>
											{foreach from=$requirements_must_to_have item=requirement_must_to_have}
												<li>{$requirement_must_to_have.description}</li>
											{/foreach}
										</ul>
									{/if}
								
									<!-- IF POSTING REQUIREMENT GOOD TO HAVE DO EXIST -->
									{if count($requirements_good_to_have)}
										<div class="must-good-attr-header">Good to have:</div>
										<ul>
											{foreach from=$requirements_good_to_have item=requirement_good_to_have}
												<li>{$requirement_good_to_have.description}</li>
											{/foreach}
										</ul>
									{/if}
									
								<!-- IF REQUIREMENTS EXIST AND REQUIREMENT MUS TO HAVE AND REQUIREMENT GOOD TO HAVE DON'T EXIST -->
								{elseif count($requirements)}
									<ul>
										{foreach from=$requirements item=requirement}
											<li>{$requirement.description}</li>
										{/foreach}
									</ul>
									
								{else}
								
									<!-- IF GS CREDENTIAL REQUIREMENT UPDATED EXIST -->
									{if count($gs_credential_requirements_updated)}
										<!-- GS CREDENTIAL REQUIREMENT UPDATED -->
										<ul>
											{foreach from=$gs_credential_requirements_updated item=gs_credential_requirement_updated}
												<li>{$gs_credential_requirement_updated.description}</li>
											{/foreach}
										</ul>
									{else}
										<!-- GS CREDENTIAL REQUIREMENT NOT UPDATED -->
										<ul>
											{foreach from=$gs_credential_requirements_not_updated item=gs_credential_requirement_not_updated}
												<li>{$gs_credential_requirement_not_updated.description}</li>
											{/foreach}
										</ul>
									{/if}
									
								{/if}
							{/if}
							
							<div class="req-res-attr-header">Responsibilities:</div>
							
							<!--CONVERTED POSTING RESPONSIBILITIES-->
							{if count($converted_posting_responsibilities)}
								<ul>
									{foreach from=$converted_posting_responsibilities item=converted_posting_responsibility}
										<li>{$converted_posting_responsibility.responsibility}</li>
									{/foreach}
								</ul>
							{else}
								<!-- IF GS CREDENTIAL RESPONSIBILITIES UPDATED EXIST -->
								{if count($gs_credential_responsibilities_updated)}
									<ul>
										{foreach from=$gs_credential_responsibilities_updated item=gs_credential_responsibility_updated}
											<li>{$gs_credential_responsibility_updated.description}</li>
										{/foreach}
									</ul>
								{else}
									<ul>
										{foreach from=$gs_credential_responsibilities_not_updated item=gs_credential_responsibility_not_updated}
											<li>{$gs_credential_responsibility_not_updated.description}</li>
										{/foreach}
									</ul>
								{/if}
							{/if}
							
						</div>
					</div>
					
					{if $applicant_used eq False}
					<div class="col-lg-12 footer-body">
						<div class="col-lg-6">
							<div id="status" style="text-align:left">
								Status: {$posting.status}
							</div>
							<div id="ads_status">
								Show Status: {$posting.show_status}
							</div>
						</div>
						<div class="col-lg-6">
							<div style="text-align:right">
								Date Created: {$ads_created_date}
							</div>
							
						</div>
					</div>
					{/if}
					{if $applicant_used eq True}
					<div align="center">
						<form method = "post" id="apply-form">
							<input type="hidden" name="posting_id" id="posting_id" value="{$posting.id}" />
							<button type="submit" class="btn btn-primary btn-lg" name="apply" style="margin-top:25px;">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Apply for this position
							</button>
						</form>
					</div>
					{/if}
				</div>

			</div>
		</div>
		<div class="col-lg-2"></div>
		</div>
	</body>
	<!-- /body -->
	<!-- script -->
	<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/portal/convert_ads/js/ads.js"></script>
	<!--/script -->
</html>
<!--/html -->
