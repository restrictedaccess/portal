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
		<link rel="stylesheet" href="/portal/jobseeker/js/fileuploader.css"/>
		<script type="text/javascript" src="/portal/jobseeker/js/fileuploader.min.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/updatelanguages.js"></script>

	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}

				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">Update Languages</h2>
						<p class="label label-info">Enter the languages you know and how well you speak and write using these languages.</p>
						<form class="well form-horizontal" method="POST" id="language-form">
							<div class="alert alert-success" style="display:none;">
								<strong>Well done!</strong> You have successfully added a language.
							</div>
							<legend>Add Language</legend>
							{$form->userid->renderViewHelper()}
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
								Save and add more language
							</button>
			
						</form>
						<h4>My Languages</h4>
						<table id="applicant_language_list" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										#
									</th>
									<th>
										Language
									</th>
									<th>
										Spoken
									</th>
									<th>
										Written
									</th>
									<th>
										&nbsp;
									</th>
								</tr>
							</thead>
							<tbody>
								{ foreach from=$languages item=language name=language_list}
									<tr>
										<td>
											{$smarty.foreach.language_list.iteration}
										</td>
										<td>
											{$language.language}
										</td>
										<td>
											{$language.spoken}
											
										</td>
										<td>
											{$language.written}
										</td>
										
										<td>
											<a href="/portal/jobseeker/edit_language.php?id={$language.id}" class="edit_skill">Edit</a> | <a href="/portal/jobseeker/delete_language.php?id={$language.id}"  class="delete_skill">Delete</a>
										</td>
										
									</tr>
								{ /foreach }
							</tbody>
						</table>
									
						
						
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
	</body>
</html>