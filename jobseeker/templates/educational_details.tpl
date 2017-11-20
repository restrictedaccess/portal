<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update your Educational Details - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<link rel="stylesheet" href="/portal/jobseeker/js/fileuploader.css"/>
		<script type="text/javascript" src="/portal/jobseeker/js/fileuploader.min.js"></script>
		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>

		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/updateeducation.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Educational Details</h2>
						<p class="label label-info">
							Fill in this section to give employers a snapshot of your profile.
						</p>
						<form class="well form-horizontal" method="POST" id="register-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully updated your educational details.
							</div>
							<legend>
								Trainings and Seminars
							</legend>
							{$form->userid->renderViewHelper()}
							<div class="control-group">
								<label class="control-label">Trainings and Seminars</label>
								<div class="controls">
									{$form->trainings_seminars->renderViewHelper()}
								</div>
							</div>
							<legend>
								Highest Academic Qualification
							</legend>

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
									<label>If GPA, please enter score:</label>
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
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>
