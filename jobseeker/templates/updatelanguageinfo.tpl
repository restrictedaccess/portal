<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update your Language Details - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/updatelanguageinfo.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Update Languages</h2>
						<p class="label label-info">
							Fill in this section to give employers a snapshot of your profile.
						</p>
						<form class="well form-horizontal" method="POST" id="language-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully added a language.
							</div>
							<legend>Update Language</legend>
							{$form->id->renderViewHelper()}
							{$form->userid->renderViewHelper()}
							{$form->spoken_assessment->renderViewHelper()}
							{$form->written_assessment->renderViewHelper()}
							<div class="control-group">
								<label class="control-label">Language</label>
								<div class="controls">
									{$form->language->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Spoken</label>
								<div class="controls">
									{$form->spoken->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Written</label>
								<div class="controls">
									{$form->written->renderViewHelper()}
								</div>
							</div>
							<button id="save_add_more_skill" class="btn btn-primary">
								Update Language Information
							</button>
			
						</form>
						
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>