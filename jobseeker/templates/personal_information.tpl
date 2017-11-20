<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update your Personal Information - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/personal_info.js"></script>
		{literal}
			<style type="text/css">
				input.error, select.error, label.error{
					color: #b94a48 !important;
					border-color: #b94a48 !important;
				}
			</style>
		{/literal}
	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Update Jobseeker account</h2>
						<p class="label label-info">Fill in this section to give employers a snapshot of your profile.</p>
						<form class="well form-horizontal" method="POST" id="register-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully updated your personal information.
							</div>
							<legend>
								Personal Information
							</legend>
							{$form->userid->renderViewHelper()}

							<div class="control-group">
								<label class="control-label">First Name</label>
								<div class="controls">
									{$form->fname->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Last Name</label>
								<div class="controls">
									{$form->lname->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Middle Name</label>
								<div class="controls">
									{$form->middle_name->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Nick Name</label>
								<div class="controls">
									{$form->nick_name->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Date of Birth</label>
								<div class="controls form-inline">
									{$form->bmonth->renderViewHelper()}
									{$form->bday->renderViewHelper()}
									{$form->byear->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Identification</label>
								<div class="controls form-inline">
									{$form->auth_no_type_id->renderViewHelper()}
									{$form->msia_new_ic_no->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Gender</label>
								<div class="controls">
									{$form->gender->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Marital Status</label>
								<div class="controls">
									{$form->marital_status->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">No. of kids</label>
								<div class="controls">
									{$form->no_of_kids->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pregnant</label>
								<div class="controls">
									{$form->pregnant->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">If yes, Expected Date of Delivery</label>
								<div class="controls form-inline">
									{$form->dmonth->renderViewHelper()}
									{$form->dday->renderViewHelper()}
									{$form->dyear->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Nationality</label>
								<div class="controls">
									{$form->nationality->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Permanent Residence</label>
								<div class="controls">
									{$form->permanent_residence->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pending Visa Application</label>
								<div class="controls">
									{$form->pending_visa_application->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Has active visa for US, UK, Austrialia, Dubai</label>
								<div class="controls">
									{$form->active_visa->renderViewHelper()}
								</div>
							</div>

							<legend>
								Login Details
							</legend>
							<div class="control-group">
								<label class="control-label">Personal Email</label>
								<div class="controls">
									{$form->email->renderViewHelper()}
								</div>
							</div>

							<legend>
								Contact Information
							</legend>
							<div class="control-group">
								<label class="control-label">Alternative Email</label>
								<div class="controls">
									{$form->alt_email->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Mobile Number</label>
								<div class="controls form-inline">
									{$form->handphone_country_code->renderViewHelper()}
									{$form->handphone_no->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Telephone Number</label>
								<div class="controls form-inline">
									{$form->tel_area_code->renderViewHelper()}
									{$form->tel_no->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Address</label>
								<div class="controls">
									{$form->address1->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Address 2</label>
								<div class="controls">
									{$form->address2->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Postal Code</label>
								<div class="controls controls-row">
									{$form->postcode->renderViewHelper()}

								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Country</label>
								<div class="controls">
									{$form->country_id->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">State/Region</label>
								<div class="controls" id="state_container">
									{$form->state->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">City</label>
								<div class="controls">
									{$form->city->renderViewHelper()}
								</div>
							</div>
							<legend>
								Online Contact Information
							</legend>
							<div class="control-group">
								<label class="control-label">MSN ID</label>
								<div class="controls controls-row">
									{$form->msn_id->renderViewHelper()}

								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Yahoo ID</label>
								<div class="controls">
									{$form->yahoo_id->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Facebook / Twitter Account</label>
								<div class="controls" id="state_container">
									{$form->icq_id->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Linked In Account</label>
								<div class="controls" id="state_container">
									{$form->linked_in->renderViewHelper()}
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Personal Skype ID</label>
								<div class="controls">
									{$form->skype_id->renderViewHelper()}
								</div>
							</div>
							<legend>Others</legend>
							<div class="control-group">
								<label class="control-label">How did you hear about us?</label>
								<div class="controls">
									{$form->external_source->renderViewHelper()}
								</div>
							</div>
							<div class="control-group" id="external_source_others_div" style="display:none">
								<label class="control-label">Please Specify</label>
								<div class="controls">
									{$form->external_source_others->renderViewHelper()}
								</div>
							</div>
							<button class="btn btn-primary">
								Update Profile
							</button>

						</form>
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>
