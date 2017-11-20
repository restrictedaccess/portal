<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update Skill Information - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/updateskillinfo.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Update Skill Information</h2>
						<p class="label label-info">
							Fill in this section to give employers a snapshot of your profile.
						</p>
						<form class="well form-horizontal" method="POST" id="skill-form">
							<legend>
								Update Skill Information
							</legend>
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
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>
