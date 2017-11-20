<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Add Admin in Whitelist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">



<!-- Le styles -->
<link href="/portal//site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/portal//site_media/subcontractors/css/style.css" rel="stylesheet">
<link href="/portal//site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="/portal/site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script src="/portal/site_media/workflow_v2/js/modernzr.js"></script>    
<script src="/portal/site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>
<!--    
<link rel="stylesheet" type="text/css" href="../site_media/meeting_calendar/js/fileuploader.css"/>
<script type="text/javascript" src="../site_media/meeting_calendar/js/fileuploader.min.js"></script>
-->


<link href="/portal/whitelist/media/css/style.css" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="../site_media/workflow_v2/js/html5shiv.js"></script>
<![endif]-->

<!-- Fav and touch icons -->
<link rel="shortcut icon" href="../favicon.ico">
</head>

<body>
<input type="hidden" id="API_URL" value="{$API_URL}" />
<input type="hidden" id="admin_id" value="{$admin.admin_id}" />
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
                <p class="navbar-text pull-right list_of_subcons"><a href="/portal/whitelist/add.php">Add Admin in Whitelist</a></p>
                <ul id="nav" class="nav">
                    <li><a href="../adminHome.php">Admin Home</a></li>
					<li><a href="/portal/django/rsadmin/">Admin Users</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

    
    

    <h2 align="center">Add Admin in Whitelist</h2>
    
	<div id="results">
       
	</div>
</div>

<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2013 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>

<script src="/portal/whitelist/media/js/whitelist.js" type="text/javascript"></script>
</body>



</html>