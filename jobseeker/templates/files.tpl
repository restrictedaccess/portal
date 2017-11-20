<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Jobseeker Portal - Remotestaff</title>
		<meta name="description" content="" />
		<meta name="author" content="Remotestaff Inc." />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		{include file="includes.tpl"}
		<link rel="stylesheet" href="/portal/jobseeker/js/fileuploader.css"/>
		<script type="text/javascript" src="/portal/jobseeker/js/fileuploader.min.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/utils.js"></script>
		<script type="text/javascript" src="/portal/jobseeker/js/files.js"></script>
		
	</head>

	<body>
		<div class="container-fluid">
			{include file="header.tpl"}
			<div class="row-fluid" id="main-content">
				{include file="sidebar_no_box.tpl"}
				<div class="span9" id="main-content-body">
					<div class="container">
						<h2 class="jobseeker-header">File Manager</h2>
						
						<form class="well">
							<legend>Voice</legend>
							<div class="row-fluid">
								<div class="span6">
									<div class="row-fluid">
										{if $full_path}
											<object type="application/x-shockwave-flash" data="/audio_player/player_flv_maxi.swf" width="200" height="50">
									            <param name="movie" value="/audio_player/player_flv_maxi.swf" />
												<param name="allowScriptAccess" value="always" />
									            <param name="FlashVars" value="flv={$user.voice_path}" />
									            <param name="wmode" value="opaque"/>
											</object>
										{else}
											<object type="application/x-shockwave-flash" data="/audio_player/player_mp3_maxi.swf" width="200" height="50">
										        <param name="movie" value="/audio_player/player_mp3_maxi.swf">
										        <param name="FlashVars" value="mp3=/portal/{$user.voice_path}">
										        <param name="allowScriptAccess" value="always" />
										        <param name="wmode" value="opaque"/>
										    </object>	
										{/if}	
									
									</div>
								</div>
								<div class="span6">
									<strong>Voice</strong>
									<p>Voice recording should be:<br/>
										Size: Equal or less than 5000kb in size<br/>
										Format: WAV, Mpeg, WMA, MP3<br/>
										Length: Should be equal or less than 3 minutes<br/>
										Content: Quick voice resume. Introduction and summary of experience</p>
									<div class="row-fluid">
										<div id="voice_recording_uploader"></div>
    									<a id="voice_select_button" class="btn" href="#">Select Voice Recording</a><br/>
    									
									</div>
									<div class="row-fluid">
										<button id="upload_voice" class="btn btn-primary">Upload Voice Recording</button> or <button id="record_voice" class="btn btn-primary">Record your voice</button>
									</div>
								</div>
							</div>
						</form>
						<form class="well">
							<legend>Files</legend>
							<div class="row-fluid">
								<div class="span6">
									<strong>Files Uploaded</strong>
									<table class="table table-condensed">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="35%">Filename</th>
												<th width="40%">File Type</th>
												<th width="20%">&nbsp;</th>
												
											</tr>
										</thead>
										<tbody>
											{foreach from=$files item=file name=file_list}
												<tr>
													<td>{$smarty.foreach.file_list.iteration}.</td>
													<td><a href="/portal/applicants_files/{$file.name}">{$file.name}</a></td>
													<td>{$file.file_description}</td>
													<td><a href="/portal/jobseeker/delete_file.php?id={$file.id}" class="delete_file">Delete</a></td>
													
												</tr>
											{/foreach}
										</tbody>
									</table>
									
									
								</div>
								<div class="span6">
									<strong>Files</strong>
									<p>File Type (doc, pdf or image format - Upload limit per file is 5 MB)</p>
									<div class="row-fluid">
										<select class="span6" name="file_description" id="file_description">
											<option value="Resume">Resume</option>
											<option value="Sample Work">Sample Work</option>
											<option value="Other">Other</option>
											
										</select>
									</div>
									<div class="row-fluid">
										<div id="file_uploader"></div>
    									<a id="file_select_button" class="btn" href="#">Select File</a><br/>
    									
									</div>
									<div class="row-fluid">
										<button id="upload_file" class="btn btn-primary">Upload File</button>
									</div>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
			{include file="footer.tpl"}
		</div>
		{include file="voice_recorder.tpl"}
	</body>
</html>