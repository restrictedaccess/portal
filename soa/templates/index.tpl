<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title>Statement of Account</title>

<!-- Le styles -->
<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../site_media/subcontractors/css/style.css" rel="stylesheet">
<link href="../site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="../site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../site_media/workflow_v2/js/modernzr.js"></script>    
<script type="text/javascript" src="../site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>
<!--    
<link rel="stylesheet" type="text/css" href="../site_media/meeting_calendar/js/fileuploader.css"/>
<script type="text/javascript" src="../site_media/meeting_calendar/js/fileuploader.min.js"></script>
-->


<link href="../site_media/client_portal/css/cupertino/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
<link href="./media/css/MonthPicker.2.1.css" media="all" rel="stylesheet" type="text/css" />
<link href="./media/css/style.css" media="all" rel="stylesheet" type="text/css" />

<script src="../site_media/client_portal/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="./media/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="./media/MonthPicker.2.1.min.js" type="text/javascript"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="../site_media/workflow_v2/js/html5shiv.js"></script>
<![endif]-->

<!-- Fav and touch icons -->
<link rel="shortcut icon" href="../favicon.ico">
</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#"><img src="../site_media/workflow_v2/img/rs-logo-no-bg-small.png" ></a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right list_of_subcons"><a href="./">Statement Of Account</a></p>
                <ul id="nav" class="nav">
                    <li><a href="../adminHome.php">Admin Home</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
<div class="container-fluid">
<p>Client : 
<select id="leads_id" name="leads_id" class="input input-xxlarge">
	<option value=""></option>
    {foreach from=$clients name=client item=client}
        <option value="{$client.leads_id}">{$client.fname} {$client.lname} => [{$client.email}]</option>
    {/foreach}
</select>
Date : 
<input id="date_str" type="text" placeHolder="mm/yyyy" readonly /><br>
<button id="generate_btn" class="btn btn-primary">Generate</button>
</p>
<hr>

<div id="results"></div>

</div>

<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2013 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>

{literal}

<script>
jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);		
		jQuery('#date_str').MonthPicker({ ShowIcon: false });
	});
	
	jQuery('#generate_btn').click(function() {
		GenerateSOA();
	});
});

</script>
<script src="./media/js/soa.js" type="text/javascript"></script>
{/literal}

</body>
</html>