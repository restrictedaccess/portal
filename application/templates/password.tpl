<!DOCTYPE html>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
		
		{include file="includes.tpl"}
		<title>Validate your Email Address - Remote Staff</title>
		<script src="js/password.js" type="text/javascript"></script>
		
	</head>
	<body>
		<div id="fb-root"></div>
		{include file="header.tpl"}
		
		{php}include("inc/nav.php"){/php}  
		
		
		
		<div id="box" class="container" style="width:915px;">
			
			<div class="row main_container">
				<h3 style="clear: both">Set your password</h3>
				<form id="password_form" class="well form-horizontal" method="POST" action="/portal/application/set_password.php">
					
					<p><span class="label label-info">Note: </span> Hi {$fname}, please set your jobseeker account password then click on Save Changes to continue your registration.</p>
					<div class="control-group">
					    <label class="control-label" for="inputEmail">Password</label>
					    <div class="controls">
					      <input type="password" id="inputPassword" placeholder="Password" name="password">
					      
					    </div>
					 </div>
					<div class="control-group">
					    <label class="control-label" for="inputEmail">Repeat Password</label>
					    <div class="controls">
					      <input type="password" id="inputConfirmPassword" placeholder="Repeat Password" name="confirm_password">
					      
					    </div>
					 </div>
					  
					  <div class="control-group">
					    <label class="control-label" for="inputEmail"></label>
					    <div class="controls">
					    	<button class="btn">Save Changes</button>
					    </div>
					 </div>
					 
					 
					 
		
					 
				</form>
			</div>
			
		</div>
		{php}include("inc/footer.php"){/php}  
	</body>
</html>