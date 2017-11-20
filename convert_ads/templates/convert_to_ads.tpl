<!DOCTYPE html>


<html lang="en">
	<head>
		
		<!-- META DATA START -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- META DATA END -->

		<!-- JAVASCRIPT START -->
		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/assets/js/jquery.isloading.min.js"></script>
		<script type="text/javascript" src="/portal/assets/js/handlebars.js"></script>
		<script type="text/javascript" src="/portal/assets/js/function.js"></script>
		<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
		{literal}
		<script type="text/javascript">
			tinymce.init({
				selector:'#heading',
				menubar : "file edit",
				toolbar: "bold italic underline alignleft aligncenter alignright alignjustify",
				setup: function (editor) {
					editor.on('change', function () {
						tinymce.triggerSave();
					});
				},
				convert_fonts_to_spans: false,
				invalid_elements: "span,font,table",
				extended_valid_elements : "span[!class]",
				plugins: "paste",
				paste_as_text: true,
				paste_webkit_styles: "ul, ol, li",
				paste_retain_style_properties: "ul, ol, li",
				force_br_newlines : true,
				force_p_newlines : false,
				forced_root_block : '' // Needed for 3.x
			});
		</script>
		{/literal}
		<script type="text/javascript">
			var BASE_API_URL = '{$BASE_API_URL}';
		</script>
		<!-- JAVASCRIPT END -->

		<!-- CSS START -->
		<link rel="stylesheet" type="text/css" href="/portal/assets/css/chosen.min.css">
		<link rel="stylesheet" type="text/css" href="/portal/jobseeker/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/portal/convert_ads/css/convert_to_ads.css" />
		{literal}
		<style type="text/css">
			.isloading-wrapper.isloading-right{margin-left:10px;}
			.isloading-overlay{position:relative;text-align:center;}.isloading-overlay .isloading-wrapper{background:#FFFFFF;-webkit-border-radius:7px;-webkit-background-clip:padding-box;-moz-border-radius:7px;-moz-background-clip:padding;border-radius:7px;background-clip:padding-box;display:inline-block;margin:0 auto;padding:10px 20px;top:10%;z-index:9000;}
		</style>
		{/literal}
		<!-- CSS END -->
		
	</head>
	<title> Remotestaff Inc | Convert to Ads </title>
	<body>

		<!-- FORM START -->
		<form id="ads-form" method="post" class="form-horizontal ads_form" role="form" enctype="multipart/form-data">
			
			<!-- HIDDEN START -->
			<input type="hidden" name="change_by_id" value="{$change_by_id}">
			<input type="hidden" name="change_by_type" value="{$change_by_type}">
			<input type="hidden" name="job_order_id" value="{$job_spec.gs_job_titles_details_id}">
			<!-- HIDDEN END -->
			
			<!-- CONTAINER START -->
			<div class="container">

				<!-- REMOTESTAFF LOGO START -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-lg-sm-12 col-xs-12">
					<img src ="/portal/images/remote-staff-logo.jpg" class="img-responsive">
				</div>
				</div>
				<!-- REMOTESTAFF LOGO END -->
				
				<!-- JOB ADS CATEGORY START-->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
						<div class="page-header text-center">
							<label id="job_ads_category" name="jobs_spec_title" ><span>{$job_spec.selected_job_title}</span></label>
						</div>
					</div>
				</div>
				<!-- JOB ADS CATEGORY END-->
				
				<!-- JOB ADS INFORMATION START -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
								<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Job Ads Information</h6>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
								<!-- FORM GROUP AD TITLE START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Leadsname" class="control-label"><strong>Ad Title:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<input type="text" id="ad_title" placeholder="Ad Title" class="form-control" name="ads_title" value="{if isset($posting) and !empty($posting.ads_title)}{$posting.ads_title}{else}{$posting.jobposition}{/if}" style="width:100%;">
									</div>
								</div>
								<!-- FORM GROUP AD TITLE END -->
								<!-- FORM GROUP LEADS NAME START-->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label class="control-label"><strong>Leads:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<label class="control-label">{$lead.id} - {$lead.fname} {$lead.lname} ({$lead.email})</label>
									</div>
								</div>
								<!-- FORM GROUP LEADS NAME END-->
								<!-- FORM GROUP CATEGORY START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Category" class="control-label"><strong>Category:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control" id="sub_category_id" name="sub_category_id" data-placeholder="Please select category">
											{foreach from=$categories item=category}
												<option value=""></option>
												<optgroup label="{$category.category_name}">
													{foreach from=$category.subcategories item=subcategory_item}
														{if $posting}
															{if $posting.sub_category_id eq $subcategory_item.sub_category_id}
																<option value="{$subcategory_item.sub_category_id}" selected="selected">{$subcategory_item.sub_category_name}</option>
															{else}
																<option value="{$subcategory_item.sub_category_id}">{$subcategory_item.sub_category_name}</option>
															{/if}
														{else}
															<option value="{$subcategory_item.sub_category_id}">{$subcategory_item.sub_category_name}</option>
														{/if}
													{/foreach}
												</optgroup>
											{/foreach}
										</select>
									</div>
								</div>
								<!-- FORM GROUP CATEGORY END -->
								<!-- FORM GROUP IT START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Outsourcingmodel" class="control-label"> <strong>Classification:</strong> </label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control chosen" id="classification" name="classification" data-placeholder="Please select classification">
											<option value=""></option>
											<option value="it" {if $posting.classification == 'it' } selected="selected" {/if}>I.T.</option>
											<option value="non it" {if $posting.classification == 'non it' } selected="selected" {/if}>Non I.T.</option>
										</select>
									</div>
								</div>
								<!-- FORM GROUP IT END -->
								<!-- FORM GROUP OUTSOURCING MODEL DROPDOWN START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Outsourcingmodel" class="control-label"> <strong>Outsourcing Model:</strong> </label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control chosen" id="sourcing_model" name="outsourcing_model" data-placeholder="Please select outsourcing model">
											<option value=""></option>
											{foreach from=$outsourcing_model item=outsourcing_model_item}
												{if $posting}
													{if $posting.outsourcing_model eq $outsourcing_model_item}
														<option value="{$outsourcing_model_item}" selected="selected">{$outsourcing_model_item}</option>
													{else}
														<option value="{$outsourcing_model_item}">{$outsourcing_model_item}</option>
													{/if}
												{else}
													<option value="{$outsourcing_model_item}">{$outsourcing_model_item}</option>
												{/if}
											{/foreach}
										</select>
									</div>
								</div>
								<!-- FORM GROUP OUTSOURCING MODEL DROPDOWN END -->
								<!-- FORM GROUP COMPANY START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Company" class="control-label"> <strong>Company:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control chosen" id="company" name="company" data-placeholder="Please select company">
											<option value=""></option>
											{foreach from=$company item=company_item}
												{if $posting}
													{if $posting.companyname eq $company_item}
														<option value="{$company_item}" selected="selected">{$company_item}</option>
													{else}
														<option value="{$company_item}">{$company_item}</option>
													{/if}
												{else}
													<option value="{$company_item}">{$company_item}</option>
												{/if}
											{/foreach}

										</select>
									</div>
								</div>
								<!-- FORM GROUP COMPANY END -->
								<!-- FORM GROUP HEADING TEXT AREA START-->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Heading" class="control-label"> <strong>Heading:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<textarea id="heading" name="heading" rows="8" cols="80">{$posting.heading}</textarea>
									</div>
								</div>
								<!-- FORM GROUP HEADING TEXT AREA END-->
								<!-- FORM GROUP STATUS START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Status" class="control-label" name="status"> <strong>Status:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control chosen" id="status" name="status" data-placeholder="Please select status">
											<option value=""></option>
											{foreach from=$status item=stat}
												{if $posting}
													{if $posting.status eq $stat}
														<option value="{$stat}" selected="selected">{$stat}</option>
													{else}
														<option value="{$stat}">{$stat}</option>
													{/if}
												{else}
													<option value="{$stat}" {if $stat == 'NEW' } selected="selected" {/if}>{$stat}</option>
												{/if}
											{/foreach}
										</select>
									</div>
								</div>
								<!-- FORM GROUP STATUS END -->
								<!-- FORM GROUP SHOW STATUS START -->
								<div class="form-group">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 labels">
										<label for="Show Status" class="control-label" name="show_status"> <strong>Show Status:</strong></label>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
										<select class="form-control chosen" id="show_status" name="show_status" data-placeholder="Please select show status">
											<option value=""></option>
											{foreach from=$show_status item=show_status_item}
												{if $posting}
													{if $posting.show_status eq $show_status_item}
														<option value="{$show_status_item}" selected="selected">{$show_status_item}</option>
													{else}
														<option value="{$show_status_item}">{$show_status_item}</option>
													{/if}
												{else}
													<option value="{$show_status_item}" {if $show_status_item == 'NO' } selected="selected" {/if}>{$show_status_item}</option>
												{/if}
											{/foreach}
										</select>
									</div>
								</div>
								<!-- FORM GROUP SHOW STATUS END -->
							</div>
						</div>
					</div>
				</div>
				<!-- JOB ADS INFORMATION END -->
				
				<hr>
				
				<!-- NOTE START -->
				<div class="alert alert-info text-center" role="alert">
				  <strong>Note:</strong> All Requirement and Responsibility list item can be drag.
				</div>
				<!-- NOTE START -->
				
				<div class="row">
					
					<!-- REQUIREMENTS LIST START-->
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
										<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Requirements</h6>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
										<a id="add_requirement_btn" href="#" class="btn btn-default"> 
											<i class="glyphicon glyphicon-plus"></i> Add Requirement
										</a>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ul id="requirements_sort" class="list-unstyled requirements droptrue" style="padding:5px; background:#cccccc; margin: 0px;">
											{if (isset($requirements) and count($requirements))}
												{foreach from=$requirements item=requirement key=j}
													<li class="ui-state-default">
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
																<div class="input-group">
																
																<!-- HIDDEN REQUIREMENTS -->
																<input type="hidden" name="{if $requirement.id != '' }requirements_sequence[{$requirement.id}]{else}new_requirements_sequence[{$j}]{/if}" value="{$j}" class="requirements_sequence">
																<input type="hidden" name="{if $requirement.id != '' }requirements_type[{$requirement.id}]{else}new_requirements_type[{$j}]{/if}" value="{$requirement.type}" class="requirements_type">
																<input type="hidden" name="{if $requirement.id != '' }requirements_gsc[{$requirement.id}]{else}new_requirements_gsc[{$j}]{/if}" value="{$requirement.gs_job_titles_credentials_id}">
																
																<!-- REQUIREMENTS CHECKBOX -->
																<input type="checkbox" class="requirements_checkbox" name="{if $requirement.id != '' }requirements_checkbox[{$requirement.id}]{else}new_requirements_checkbox[{$j}]{/if}" value="1" {if $requirement.is_selected == 1}checked="checked"{/if} style="display: none;" />
																
																<span class="input-group-addon">
																	<i class="glyphicon glyphicon-move"></i>
																</span>
																
																<input type="text" class="form-control requirements" value="{$requirement.description}" name="{if $requirement.id != '' }requirements[{$requirement.id}]{else}new_requirements[{$j}]{/if}">
																<span class="input-group-btn">
																	<a class="btn btn-danger remove_requirement" href="#">
																		<i class="glyphicon glyphicon-remove"></i>
																	</a>
																</span>
															</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
																<select name="{if $requirement.id != '' }requirements_rating[{$requirement.id}]{else}new_requirements_rating[{$j}]{/if}" class="form-control chosen requirement_rating" data-placeholder="Please select rating">
																	<option value=""></option>
																	{foreach from=$ratings item=rating key=j}
																		<option value="{$j}" {if $requirement.rating == $j} selected="selected" {/if}>{$rating}</option>
																	{/foreach}
																</select>
															</div>
														</div>
													</li>
												{/foreach}
											{/if}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- REQUIREMENTS LIST END-->
					
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						
						<div class="row">
							<!-- REQUIREMENTS MUST TO HAVE START -->
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
												<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Requirement: Must have</h6>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<ul id="requirements_must_to_have_sort" class="list-unstyled requirements droptrue" style="padding:5px; background:#cccccc; margin: 0px;">
											{if (isset($requirements_must_to_have) and count($requirements_must_to_have))}
												{foreach from=$requirements_must_to_have item=requirement_must_to_have key=j}
													<li class="ui-state-default">
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
																<div class="input-group">
																	
																	<!-- HIDDEN REQUIREMENTS -->
																	<input type="hidden" name="{if $requirement_must_to_have.id != '' }requirements_sequence[{$requirement_must_to_have.id}]{else}new_requirements_sequence[{$j}]{/if}" value="{$j}" class="requirements_sequence">
																	<input type="hidden" name="{if $requirement_must_to_have.id != '' }requirements_type[{$requirement_must_to_have.id}]{else}new_requirements_type[{$j}]{/if}" value="{$requirement_must_to_have.type}" class="requirements_type">
																	<input type="hidden" name="{if $requirement_must_to_have.id != '' }requirements_gsc[{$requirement_must_to_have.id}]{else}new_requirements_gsc[{$j}]{/if}" value="{$requirement_must_to_have.gs_job_titles_credentials_id}">
																	
																	<!-- REQUIREMENTS MUST TO HAVE CHECKBOX -->
																	<input type="checkbox" class="requirements_checkbox" name="{if $requirement_must_to_have.id != '' }requirements_checkbox[{$requirement_must_to_have.id}]{else}new_requirements_checkbox[{$j}]{/if}" value="1" {if $requirement_must_to_have.is_selected == 1}checked="checked"{/if} style="display: none;" />
																	
																	<span class="input-group-addon">
																		<i class="glyphicon glyphicon-move"></i>
																	</span>
																	
																	<input type="text" class="form-control requirements" value="{$requirement_must_to_have.requirement}" name="{if $requirement_must_to_have.id != '' }requirements[{$requirement_must_to_have.id}]{else}new_requirements[{$j}]{/if}">
																	<span class="input-group-btn">
																		<a class="btn btn-danger remove_requirement" href="#">
																			<i class="glyphicon glyphicon-remove"></i>
																		</a>
																	</span>
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
																<select name="{if $requirement_must_to_have.id != '' }requirements_rating[{$requirement_must_to_have.id}]{else}new_requirements_rating[{$j}]{/if}" class="form-control chosen requirement_rating" data-placeholder="Please select rating">
																	<option value=""></option>
																	{foreach from=$ratings item=rating key=j}
																		<option value="{$j}" {if $requirement_must_to_have.rating == $j} selected="selected" {/if}>{$rating}</option>
																	{/foreach}
																</select>
															</div>
														</div>
													</li>
												{/foreach}
											{/if}
										</ul>
									</div>
								</div>
							</div>
							<!-- REQUIREMENTS MUST TO HAVE END -->
						</div>
						
						<div class="row">
							<!-- REQUIREMENTS GOOD TO HAVE START -->
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
												<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Requirement: Good to have</h6>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<ul id="requirements_good_to_have_sort" class="list-unstyled requirements droptrue" style="padding:5px; background:#cccccc; margin: 0px;">
											{if (isset($requirements_good_to_have) and count($requirements_good_to_have))}
												{foreach from=$requirements_good_to_have item=requirement_good_to_have key=j}
													<li class="ui-state-default">
														<div class="row">
															<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
																<div class="input-group">
																	
																	<!-- HIDDEN REQUIREMENTS -->
																	<input type="hidden" name="{if $requirement_good_to_have.id != '' }requirements_sequence[{$requirement_good_to_have.id}]{else}new_requirements_sequence[{$j}]{/if}" value="{$j}" class="requirements_sequence">
																	<input type="hidden" name="{if $requirement_good_to_have.id != '' }requirements_type[{$requirement_good_to_have.id}]{else}new_requirements_type[{$j}]{/if}" value="{$requirement_good_to_have.type}" class="requirements_type">
																	<input type="hidden" name="{if $requirement_good_to_have.id != '' }requirements_gsc[{$requirement_good_to_have.id}]{else}new_requirements_gsc[{$j}]{/if}" value="{$requirement_good_to_have.gs_job_titles_credentials_id}">
																	
																	<!-- REQUIREMENTS GOOD TO HAVE CHECKBOX -->
																	<input type="checkbox" class="requirements_checkbox" name="{if $requirement_good_to_have.id != '' }requirements_checkbox[{$requirement_good_to_have.id}]{else}new_requirements_checkbox[{$j}]{/if}" value="1" {if $requirement_good_to_have.is_selected == 1}checked="checked"{/if} style="display: none;" />
																	
																	<span class="input-group-addon">
																		<i class="glyphicon glyphicon-move"></i>
																	</span>
																	
																	<input type="text" class="form-control requirements" value="{$requirement_good_to_have.requirement}" name="{if $requirement_good_to_have.id != '' }requirements[{$requirement_good_to_have.id}]{else}new_requirements[{$j}]{/if}">
																	<span class="input-group-btn">
																		<a class="btn btn-danger remove_requirement" href="#">
																			<i class="glyphicon glyphicon-remove"></i>
																		</a>
																	</span>
																</div>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
																<select name="{if $requirement_good_to_have.id != '' }requirements_rating[{$requirement_good_to_have.id}]{else}new_requirements_rating[{$j}]{/if}" class="form-control chosen requirement_rating" data-placeholder="Please select rating">
																	<option value=""></option>
																	{foreach from=$ratings item=rating key=j}
																		<option value="{$j}" {if $requirement_good_to_have.rating == $j} selected="selected" {/if}>{$rating}</option>
																	{/foreach}
																</select>
															</div>
														</div>
													</li>
												{/foreach}
											{/if}
										</ul>
									</div>
								</div>
							</div>
							<!-- REQUIREMENTS GOOD TO HAVE END -->
						</div>
					</div>
					
				</div>

				<hr>
				
				<div class="row">
					
					<!-- RESPONSIBILITIES LIST START -->
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
										<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Responsibilities</h6>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
										<a id="add_responsibility_btn" href="#" class="btn btn-default"> 
											<i class="glyphicon glyphicon-plus"></i> Add Responsibility
										</a>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ul id="responsibilities_sort" class="list-unstyled responsibilities droptrue" style="padding:5px; background:#cccccc; margin: 0px;">
											{if (isset($responsibilities) and count($responsibilities))}
												{foreach from=$responsibilities item=responsibility key=j}
													<li class="ui-state-default">
														<div class="row">
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<div class="input-group">
																	<input type="hidden" name="{if $responsibility.id != '' }responsibilities_sequence[{$responsibility.id}]{else}new_responsibilities_sequence[{$j}]{/if}" value="{$j}" class="responsibilities_sequence">
																	<input type="hidden" name="{if $responsibility.id != '' }responsibilities_gsc[{$responsibility.id}]{else}new_responsibilities_gsc[{$j}]{/if}" value="{$responsibility.gs_job_titles_credentials_id}">
																	<input type="checkbox" class="responsibilities_checkbox" name="{if $responsibility.id != '' }responsibilities_checkbox[{$responsibility.id}]{else}new_responsibilities_checkbox[{$j}]{/if}" value="1" {if $responsibility.is_selected == 1}checked="checked"{/if} style="display: none;" />
																	<span class="input-group-addon">
																		<i class="glyphicon glyphicon-move"></i>
																	</span>
																	<input type="text" class="form-control responsibilities" value="{$responsibility.description}" name="{if $responsibility.id != '' }responsibilities[{$responsibility.id}]{else}new_responsibilities[{$j}]{/if}">
																	<span class="input-group-btn">
																		<a class="btn btn-danger remove_responsibility" href="#">
																			<i class="glyphicon glyphicon-remove"></i>
																		</a>
																	</span>
																</div>
															</div>
														</div>
													</li>
												{/foreach}
											{/if}
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- RESPONSIBILITIES LIST END-->
					
				</div>
				
				<hr>
				
				<!--
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
										<h6 style="color: #ffffff;font-weight:700; font-size:14px;">Special Instruction</h6>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<textarea id="special_instruction" name="special_instruction" style="width:100%; height: 100px;">{$special_instruction}</textarea>
							</div>
						</div>
					</div>
				</div>
				-->
				
				<!-- HISTORY PANEL START -->
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="headingOne">
						  <h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							  History
							</a>
						  </h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										{ if isset( $histories ) and count( $histories ) }
											<table class="table table-striped table-bordered table-hover table-condensed" style="margin: 0px;"> 
												<thead>
													<tr>
														<th class="text-center col-lg-2"> User </th>
														<th class="text-center col-lg-1"> User Type </th>
														<th class="text-center col-lg-7"> Description of Changes </th>
														<th class="text-center col-lg-2"> Date </th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td colspan="5">
															<div style="width:100%; height:270px; overflow-x:hidden; overflow-y:auto;">
																<table class="table table-striped table-bordered table-hover table-condensed">
																	<tbody>
																		{foreach from=$histories item=history}
																			<tr>
																				<td class="text-center col-lg-2"> { $history.user } </td>
																				<td class="text-center col-lg-1"> { $history.user_type } </td>
																				<td class="col-lg-7" style="word-wrap: break-word;min-width: 160px;max-width: 160px;"> { $history.description_of_changes } </td>
																				<td class="text-center col-lg-2"> { $history.date_change } </td>
																			</tr>
																		{/foreach}
																	</tbody>
																</table>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										{ else }
											<div class="alert alert-danger" role="alert" style="margin: 0px;">
												<h6 class="text-center" style="color: #ffffff; font-size:14px;font-weight: 700;"> No History </h6>
											</div>
										{ /if }
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- HISTORY PANEL END -->

				<!-- CONVERT TO ADS BUTTONS START  -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
						<div style="margin: 0px 0px 20px;">
							<a class="btn btn-default btn-back" href="/portal/custom_get_started/job_spec.php?gs_job_titles_details_id={$job_spec.gs_job_titles_details_id}"> <i class="glyphicon glyphicon-arrow-left"></i> BACK</a>
							<input type="hidden" id="action" name="action" value="update">
							{if $allow_convert_to_ads}
								<button id="convert_to_ads" class="btn btn-warning" type="button"> CONVERT JOB ADS <i class="glyphicon glyphicon-refresh"></i> </button>
							{/if}
							<button class="btn btn-primary" type="submit"> UPDATE JOB ADS <i class="glyphicon glyphicon-pencil"></i> </button>
							{if $allow_convert_to_ads}
								<a class="btn btn-success" href="/portal/convert_ads/ads.php?job_order_id={$job_spec.gs_job_titles_details_id}" target="_blank"> PREVIEW JOB ADS <i class="glyphicon glyphicon-eye-open"></i> </a>
							{/if}
						</div>
					</div>
				</div>
				<!-- CONVERT TO ADS BUTTONS END  -->
					
			</div>
			<!-- CONTAINER END -->
			
		</form>
		<!-- FORM END -->
		
		<script type="text/javascript" src="/portal/assets/js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="/portal/convert_ads/js/convert_to_ads.js"></script>
		{literal}
		<style type="text/css">
			.chosen-container-single .chosen-single{
				height: 35px;
				line-height: 35px;
			}
			.chosen-container-single .chosen-single div b {
				margin-top:5px;
			}
			.chosen-container-single .chosen-single abbr {
			  top: 11px;
			  right: 25px;
			}
		</style>
		<script type="text/javascript">
			$('#sub_category_id').chosen({
				width:"100%",
				no_results_text:"Oops, nothing found!",
				allow_single_deselect:true
			});
			$('.chosen').chosen({
				width:"100%",
				no_results_text:"Oops, nothing found!",
				allow_single_deselect:true,
				disable_search:true
			});
		</script>
		{/literal}
		
		{literal}
		<script id="new_requirement_template" type="text/x-handlebars-template">
			<li class="ui-state-default">
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<div class="input-group">
							<input type="hidden" name="new_requirements_sequence[{{sequence}}]" value="{{requirement_sequence}}" class="requirements_sequence">
							<input type="hidden" name="new_requirements_type[{{sequence}}]" value="" class="requirements_type">
							<input type="hidden" name="new_requirements_gsc[{{sequence}}]" value="">
							<input type="checkbox" class="requirements_checkbox" name="new_requirements_checkbox[{{sequence}}]" value="1" checked="checked" style="display: none;" />
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-move"></i>
							</span>
							<input type="text" class="form-control requirements" value="" name="new_requirements[{{sequence}}]">
							<span class="input-group-btn">
								<a class="btn btn-danger remove_responsibility" href="#">
									<i class="glyphicon glyphicon-remove"></i>
								</a>
							</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<select name="new_requirements_rating[{{sequence}}]" class="form-control chosen requirement_rating" data-placeholder="Please select rating">
							<option value=""></option>
					{/literal}
							{foreach from=$ratings item=rating key=j}
								<option value="{$j}">{$rating}</option>
							{/foreach}
					{literal}
						</select>
					</div>
				</div>
			</li>
		</script>
		{/literal}
		
		{literal}
		<script id="new_responsibility_template" type="text/x-handlebars-template">
			<li class="ui-state-default">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="input-group">
							<input type="hidden" name="new_responsibilities_sequence[{{sequence}}]" value="{{responsibility_sequence}}" class="responsibilities_sequence">
							<input type="hidden" name="new_responsibilities_gsc[{{sequence}}]" value="">
							<input type="checkbox" class="responsibilities_checkbox" name="new_responsibilities_checkbox[{{sequence}}]" value="1" checked="checked" style="display: none;" />
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-move"></i>
							</span>
							<input type="text" class="form-control responsibilities" value="" name="new_responsibilities[{{sequence}}]">
							<span class="input-group-btn">
								<a class="btn btn-danger remove_responsibility" href="#">
									<i class="glyphicon glyphicon-remove"></i>
								</a>
							</span>
						</div>
					</div>
				</div>
			</li>
		</script>
		{/literal}
		
	</body>
</html>
