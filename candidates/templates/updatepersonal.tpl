<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Candidate Profile</title>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/update.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>

		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
	</head>
	<body>

		<div class="container">
			<h2 class="jobseeker-header">Update Jobseeker account</h2>

			<form class="well form-horizontal" method="POST" id="register-form">
				<legend>Personal Information</legend>
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
				
				
				<legend>Login Details</legend>
				<div class="control-group">
					<label class="control-label">Personal Email</label>
					<div class="controls">
						{$form->email->renderViewHelper()}
					</div>
				</div>

				<legend>Contact Information</legend>
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
				
				<div class="control-group">
					<label class="control-label">Referred By</label>
					<div class="controls" id="referred_by">
						{$form->referred_by->renderViewHelper()}
					</div>
				</div>
				
				
				<legend>Online Contact Information</legend>
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
				
				<div id="skype_list">
					{foreach from=$skypes item=skype}
						<div class="control-group">
							<label class="control-label">Work Skype: </label>
							<div class="controls">
								<input type="hidden" name="skypes_ids[]" value="{$skype.id}"/>
								<input type="hidden" name="skypes_userids[]" value="{$skype.userid}"/>
								<input type="hidden" name="skypes_subcontractors_ids[]" value="{$skype.subcontractors_id}"/>
								<input type="text" class="span4" name="skypes_skype_ids[]" value="{$skype.skype_id}"/>
							
							</div>
						</div>		
					{/foreach}
					<div class="control-group">
						<label class="control-label">Work Skype: </label>
						<div class="controls">
							<input type="hidden" name="skypes_ids[]"/>
							<input type="hidden" name="skypes_userids[]"/>
							<input type="hidden" name="skypes_subcontractors_ids[]"/>
							<input type="text" class="span4" name="skypes_skype_ids[]"/>
						</div>
					</div>		
				</div>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls"><button class="btn btn-mini add_more_work_skype">Add more Work Skype</button></div>
				</div>
				<button class="btn btn-primary">
					Update Profile
				</button>
			
			</form>
		</div>

	</body>
</html>
