<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<link href="/portal/jobseeker/js/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js/sms_sender.js"></script>
		<link href="css/sms_sender.css" type="text/css" rel="stylesheet"/>
		<title>SMS Sender - {$candidate.fname} {$candidate.lname}</title>
	</head>
	<body>
		<div class="container main_container" style="width:600px">
			<div class="alert alert-info">
 				Please ensure that the mobile number follows the format 09xxxxxxxxx or 9xxxxxxxxx to be able to send message to this candidate.
			</div>
			<form class="form-horizontal" method="POST" id="sms_messenger">
				<input type="hidden" name="userid" value="{$candidate.userid}"/>
				<input type="hidden" name="admin_id" value="{$admin_id}"/>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Mobile Number</label>
					<div class="controls">
						<input type="text" readonly="readonly" id="inputMobile" name="mobile_number" placeholder="Mobile Number" value="{$candidate.handphone_no}">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Message</label>
					<div class="controls">
						<textarea id="message" name="message" placeholder="Text Message" rows="3" style="width:400px;height:100px;"></textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
					<button type="submit" class="btn">Send Message</button>
					</div>
				</div>
			</form>	
		</div>
		
	</body>
</html>