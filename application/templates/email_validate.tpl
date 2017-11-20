<!DOCTYPE html>
<html xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
		
		{include file="includes.tpl"}
		<title>Validate your Email Address - Remote Staff</title>
		<script src="js/email_validate.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="fb-root"></div>
		{include file="header.tpl"}
		<div id="box" class="container">
			
			<div class="row main_container">
				<h3>Create a Remote Staff Jobseeker Account</h3>
				<p>Already have a jobseeker account? <a href="#">Login</a> </p>
				<form class="well form-horizontal">
					
					<p><span class="label label-info">Note: </span> A verification link will be send to ensure that your email address is valid.<br/>Valid email address is required to process your application as this will be your initial means of contact. </p>
					<div class="control-group">
					    <label class="control-label" for="inputEmail">Email Address</label>
					    <div class="controls">
					      <input type="text" id="inputEmail" placeholder="Email Address">
					      
					    </div>
					 </div>
					  <div class="control-group">
					    <label class="control-label" for="inputEmail"></label>
					    <div class="controls">
					    	<button class="btn">Send Verification Link</button>
					    </div>
					 </div>
					 
					 
					 
					 
					  <div class="control-group">
					    <div class="controls">
					    	or
					 	</div>
					 </div>
					 <div class="control-group">
					    
					    <div class="controls">
					    	<button class="sign_in_via_fb" id="sign_in_via_fb"></button>
					    </div>
					 </div>
					 
				</form>
			</div>
			
		</div>
		
		{include file="footer.tpl"}
		
	</body>
</html>