<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Create Candidate Profile</title>
		<link rel="stylesheet" href="/portal/recruiter/css/style.css"/>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/ui.jqgrid.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css"/>
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/rsgrid.css"/>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/index.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/staff_public_functions.js"></script>
		<script language=javascript src="../js/functions.js"></script>
		<link rel=stylesheet type=text/css href="../css/font.css"/>
		<link rel=stylesheet type=text/css href="../menu.css"/>
		<link rel=stylesheet type=text/css href="../adminmenu.css"/>
		<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css"/>
		<link rel=stylesheet type=text/css href="../category/category.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
		{literal}
			<style type="text/css">
				input.error, select.error,label.error{
					color: #b94a48 !important;
					border-color: #b94a48 !important;
				}
			</style>
		{/literal}
	</head>
	<body>	
		{if $popup eq false }
			{php} include("../recruiter/header.php") {/php}
			{php} include("../recruiter/recruiter_top_menu.php") {/php}
		{/if}
		<!--START: left nav.-->
		<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
			<tr>
				<td valign="top" style="border-right: #006699 2px solid;">
				<div id='applicationsleftnav'>
					<table>
						<tr>
							<td background="/portal/recruiter/images/open_left_menu_bg.gif" class="navigator"><a href="javascript: applicationsleftnav_show(); "><img src="/portal/recruiter/images/open_left_menu.gif" border="0" /></a></td>

						</tr>
					</table>
				</div></td>
				<td valign="top" width="100%" class="content"><!--ENDED: left nav.-->
					<div class="container">
						<h2 class="jobseeker-header">Fill up a Jobseeker account</h2>
	
						<form class="well form-horizontal" method="POST" id="register-form">
							<legend>Personal Details</legend>
							
							{$form->referral_id->renderViewHelper()}
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
								<label class="control-label">Birthday</label>
								<div class="controls form-inline">
									{$form->bmonth->renderViewHelper()}
									{$form->bday->renderViewHelper()}
									{$form->byear->renderViewHelper()}
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
								Create jobseeker account
							</button>
	
					</div> </form> 
				</td>
			</tr>
		</table>
		<!--START: left nav. container -->
		<div ID='applicationsleftnav_container' STYLE='POSITION: Absolute; RIGHT: 50px; TOP: 5px; width: 200px; VISIBILITY: HIDDEN'>
		<table width="100%">
			<tr>
				<td align="right" background="images/close_left_menu_bg.gif">
		        	<a href="javascript: applicationsleftnav_hide(); "><img src="images/close_left_menu.gif" border="0" /></a>
				</td>
			</tr>
		</table>
		
		{php} include("../recruiter/applicationsleftnav.php") {/php}
		
		</div>
		{if $popup eq false }
			<!--ENDED: left nav. container -->
			{php} include("../recruiter/footer.php") {/php}
		{/if}
	</body>
</html>
