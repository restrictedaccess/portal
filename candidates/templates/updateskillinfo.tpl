<!DOCTYPE html>
<html>
	<head>
		<title>Remotestaff - Update Skills</title>

		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/portal/candidates/js/updateskillinfo.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>

		<link rel="stylesheet" type="text/css" href="/portal/candidates/css/index.css"/>
	</head>
	<body>

		<div class="container">
			<h2 class="jobseeker-header">Update Skills</h2>
			<p>Enter your top skills (e.g. Project Management, Cost Accounting, C++, Oracle8), years of experience and proficiency. Maximum 10 skills allowed. what should I enter?</p>
			<form class="well form-horizontal" method="POST" id="skill-form">
				<legend>Update Skill Information</legend>
				{$form->id->renderViewHelper()}
				{$form->userid->renderViewHelper()}
				<div class="control-group">
					<label class="control-label">Skill</label>
					<div class="controls">
						{$form->skill->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Years of Experience</label>
					<div class="controls">
						{$form->experience->renderViewHelper()}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Proficiency</label>
					<div class="controls">
						{$form->proficiency->renderViewHelper()}
					</div>
				</div>
				<button class="btn btn-primary">
					Update Skill Information
				</button>
			</form>
		</div>


		

	</body>
</html>
