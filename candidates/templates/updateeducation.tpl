<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Candidate's Education</title>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/updateeducation.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>

		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
	</head>
	<body>

		<div class="container">
			<h2 class="jobseeker-header">Update Educational Information</h2>

			<form class="well form-horizontal" method="POST" id="register-form">
				<legend>Trainings and Seminars</legend>
				{$form->userid->renderViewHelper()}
				<div class="control-group">
					<label class="control-label">Trainings and Seminars</label>
					<div class="controls">
						{$form->trainings_seminars->renderViewHelper()}
					</div>
				</div>
				<legend>Licence and Certifications</legend>
				{$form->userid->renderViewHelper()}
				<div class="control-group">
					<label class="control-label">Licence and Certifications</label>
					<div class="controls">
						{$form->licence_certification->renderViewHelper()}
					</div>
				</div>
				<legend>Highest Academic Qualification</legend>
				
				<div class="control-group">
					<label class="control-label">Highest Level</label>
					<div class="controls">
						{$form->educationallevel->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Field of Study</label>
					<div class="controls">
						{$form->fieldstudy->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Others / Major In: </label>
					<div class="controls">
						{$form->major->renderViewHelper()}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Grade</label>
					<div class="controls form-inline">
						{$form->grade->renderViewHelper()}
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls form-inline">
						<label class="span3">If GPA, please enter score:</label>
						{$form->gpascore->renderViewHelper()} out of 100
					</div>
				</div>
				
				

				<div class="control-group">
					<label class="control-label">Institute / University:</label>
					<div class="controls">
						{$form->college_name->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Located In: </label>
					<div class="controls ">
						{$form->college_country->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Graduation date: </label>
					<div class="controls form-inline">
						{$form->graduate_month->renderViewHelper()}
						{$form->graduate_year->renderViewHelper()} (YYYY)
						
					</div>
				</div>
				
				<button class="btn btn-primary">
					Update Education
				</button>
			
			</form>
		</div>

	</body>
</html>
