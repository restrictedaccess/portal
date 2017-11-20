<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Update your Working at Home Capabilities - Remotestaff</title>
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
		<script type="text/javascript" src="/portal/jobseeker/js/work_at_home.js"></script>
	
	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Work at Home Capabilities</h2>
						<p class="label label-info">Fill in this section to give employers a snapshot of your profile.</p>
						<form class="well form-horizontal" method="POST" id="register-form" action="/portal/jobseeker/update_working_at_home_capabilities.php">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully updated your working at home capabilities.
							</div>
							{$form->userid->renderViewHelper()}

							<div class="control-group">
								<label class="control-label">Have you worked from home before?</label>
								<div class="controls">
									{$form->work_from_home_before->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">If you have worked from home, how long has it been?</label>
								<div class="controls">
									{$form->start_worked_from_home_year->renderViewHelper()} {$form->start_worked_from_home_month->renderViewHelper()} 
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">Do you have a baby in the house?</label>
								<div class="controls">
									{$form->has_baby->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">If yes, Who is the main caregiver?</label>
								<div class="controls">
									{$form->main_caregiver->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Why do you want to work from home?</label>
								<div class="controls">
									{$form->reason_to_wfh->renderViewHelper()}
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">How long do you see yourself working for RemoteStaff ?</label>
								<div class="controls">
									{$form->timespan->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Home Working Environment:</label>
								<div class="controls">
									{$form->home_working_environment->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Internet Connection:</label>
								<div class="controls">
									{$form->isp->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Others <small>(state whether wireless or wired)</small>:</label>
								<div class="controls">
									{$form->internet_connection_others->renderViewHelper()}
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Internet Plan & Package:</label>
								<div class="controls">
									{$form->internet_connection->renderViewHelper()}
								</div>
							</div>
							
							
							<div class="control-group" style="padding-left:40px">
								Go to <a href="http://www.speedtest.net" target="_blank">www.speedtest.net</a> website and place what your upload & download Mbps speed .
								<br/><br/>
								<img src="/portal/images/speedtest.jpg" width="400" height="264" border="1"/>
							</div>
							
							<div class="control-group">
								<label class="control-label">Speed Test Result Link:</label>
								<div class="controls">
									{$form->speed_test->renderViewHelper()}
								</div>
							</div>
							<div class="control-group" style="padding-left:40px">
								<small><span class="label label-important">Please Note:</span> To make working from home a sustainable career your internet becomes your lifeline. <br/>As a possible remote staff contractor you will need 1.0mbps download with 0.35mbps upload on a DSL broadband connection,<br/> WIFI connection is not acceptable because its not stable enough.</small>
							</div>
							
							<div class="control-group">
								<label class="control-label">What is possible and what is not possible about your internet connection from home?</label>
								<div class="controls">
									{$form->internet_consequences->renderViewHelper()}
								</div>
							</div>
							<legend>Resource Checklist</legend>
							<div class="control-group form-inline">
								<label class="checkbox inline">
									{$form->desktop_computer->renderViewHelper()} Desktop 
								</label>
								{$form->desktop_os->renderViewHelper()} {$form->desktop_processor->renderViewHelper()} Processor {$form->desktop_ram->renderViewHelper()} RAM
									
							</div>
							<div class="control-group inline">
								<label class="checkbox inline">
									{$form->loptop_computer->renderViewHelper()} Laptop
								</label>
							    {$form->loptop_os->renderViewHelper()} {$form->loptop_processor->renderViewHelper()} Processor {$form->loptop_ram->renderViewHelper()} RAM
									
							</div>
							<div class="control-group">
								<label class="control-label">Headset:</label>
								<div class="controls">
									{$form->headset->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">High Performance Headphones:</label>
								<div class="controls">
									{$form->headphone->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Printer:</label>
								<div class="controls">
									{$form->printer->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Scanner:</label>
								<div class="controls">
									{$form->scanner->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Tablet:</label>
								<div class="controls">
									{$form->tablet->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pen Tablet:</label>
								<div class="controls">
									{$form->pen_tablet->renderViewHelper()} <small>Brand and Model</small>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">How do you rate the noise level at your home location ?</label>
								<div class="controls">
									{$form->noise_level->renderViewHelper()}
								</div>
							</div>
							
							
							
							
							
							<button class="btn btn-primary">
								Update Work at Home Capabilities
							</button>

						</form>
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>
