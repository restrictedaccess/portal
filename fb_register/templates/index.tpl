<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Register at Remote Staff</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>
	<body>
		<form role="form" id="main_form" action="/portal/fb_register/register.php"  enctype="multipart/form-data" method="post">
					
		<div class="fb_app_container">
			<header class="header row-fluid">
				<a href="http://remotestaff.com.ph"><img src="images/rs_logo.png" alt="Remote Staff"></a>
			</header>
			<div class="row-fluid main_form" style="overflow: hidden">
				<div class="col-lg-5 register_form" style="padding-bottom:10px;">
					<h3>Application Form</h3>
					{if $error}
						<div class="form-group">
							<div class="alert alert-danger alert-dismissable">
							   {$error}
							</div>
						</div>
					{/if}
					<div class="form-group">
					    <input type="text" name="fname" class="form-control" id="idFirstName" placeholder="First Name:" value="{$user_profile.first_name}" required>
					  </div>
					  <div class="form-group">
					    <input type="text" name="lname" class="form-control" id="idLastName" placeholder="Last Name:"  value="{$user_profile.last_name}" required>
					  </div>
					  <div class="form-group">
					    <input type="text" name="number" class="form-control" id="idNumber" value="{$number}" placeholder="Mobile Number:" required>
					  </div>
					  <div class="form-group">
					    <input type="email" readonly name="email" class="form-control" id="idEmail" placeholder="Email Address:" value="{$user_profile.email}" required>
					  </div>
					  <div class="form-group">
					    <input type="password" name="password" class="form-control" id="idPassword" placeholder="Password:" required>
					  </div>
					  <div class="form-group">
					    <input type="password" name="confirm_password" class="form-control" id="idConfirmPassword" placeholder="Confirm Password:" required>
					  </div>
					  
					  <div class="form-group">
					    <input type="text" name="skype_id" class="form-control" id="idSkype" placeholder="Skype ID:" value="{$skype_id}" required>
					  </div>
					  <div class="form-group">
					  	<label>Worked From Home Before?</label><br/>
					  	{if $work_from_home_before eq "yes"}
					  	<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeYes" value="yes" checked>
						    Yes
						  </label>
						</div>
						<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeNo" value="no">
						    No
						  </label>
						</div>
						{/if}
						{if $work_from_home_before eq "no"}
						<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeYes" value="yes" >
						    Yes
						  </label>
						</div>
						<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeNo" value="no" checked>
						    No
						  </label>
						</div>
						{/if}
						{if $work_from_home_before neq "no" and $work_from_home_before neq "yes"}
						<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeYes" value="yes">
						    Yes
						  </label>
						</div>
						<div class="radio-inline">
						  <label>
						    <input type="radio" name="work_from_home_before" id="optionsWorkFromHomeNo" value="no">
						    No
						  </label>
						</div>
						{/if}
						
					  </div>
					  <div class="form-group">
					  	<select name="isp" id="isp" class="form-control">
						    <option value="" label="Select your Internet Connection" selected="selected">Select your Internet Connection</option>
						    {foreach from=$internet_connection_list item=internet_connection}
						    	{if $internet_connection eq $isp}
							    	<option value="{$internet_connection}" label="{$internet_connection}" selected>{$internet_connection}</option>
								{else}
									<option value="{$internet_connection}" label="{$internet_connection}">{$internet_connection}</option>
								{/if}						    	
						    {/foreach}
						    

						</select>
					  </div>
					  
					  <div class="form-group" id="internet_connection_other" style="display:none">
						<input type="text" name="internet_plan_others" class="form-control" id="idInternetPlanOthers" placeholder="Please specify" value="{$others}" disabled>	
					  </div>
					  
					   <div class="form-group">
					   		<input type="text" name="internet_plan" class="form-control" id="idInternetPlan" value="{$internet_plan}" placeholder="Internet Plan and Package" required>
					   </div>
					   <div class="form-group">
					   		<input type="text" name="speed_test" class="form-control" id="idSpeedTest" value="{$speed_test}" placeholder="Speed Test Link" required>
					   		<p class="help-block">Go to <a href="http://speedtest.net" target="_blank">www.speedtest.net</a> website and place what your upload &amp; download Mbps speed . </p>
					   </div>
					    <div class="form-group">
						    <label for="exampleInputFile">Attach Resume (optional)</label>
						    <input type="file" id="exampleInputFile" name="resume">
						   
						  </div>
					  <input type="hidden" name="facebook_id" value="{$user_profile.id}"/>
					  
					  
				</div>
			</div>
			<footer class="footer row-fluid">
				<button type="submit" class="register btn btn-default">Submit</button>
			</footer>
		</div>
		
		</form>
	</body>
</html>