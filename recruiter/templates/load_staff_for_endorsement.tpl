<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Endorse to Client</title>
		{include file="new_include.tpl"}
		<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css"/>
		<link rel="stylesheet" href="/portal/recruiter/css/style.css"/>
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.10.1.custom.min.js"></script>
		<script type="text/javascript" src="/portal/recruiter/js/load_staff_for_endorsement.js"></script>
	</head>
	<body>
		<div class="container">
		    
			<h3 class="to-be-endorsed">Selected to be Endorsed Staff</h3>
			{$list}
			<button id="endorse-staff" class="btn btn-primary btn-sm">
				Click to Endorsed to Client
			</button>
		</div>
	</body>
</html>