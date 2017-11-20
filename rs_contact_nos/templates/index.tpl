<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Remote Staff Contact Numbers Management</title>

<link href="/portal/site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/portal/site_media/subcontractors/css/style.css" rel="stylesheet">
<link href="/portal/site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="/portal/site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script  src="/portal/site_media/workflow_v2/js/modernzr.js"></script>    
<script  src="/portal/site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/portal/site_media/workflow_v2/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="shortcut icon" href="/portal/favicon.ico">
<link href="./media/css/style.css" rel="stylesheet">

    
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
            <a class="brand" href="#"><img src="/portal/site_media/workflow_v2/img/rs-logo-no-bg-small.png" ></a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right list_of_subcons"><a href="./">RS Contact Nos. Management</a></p>
                <ul id="nav" class="nav">
                    <li><a href="/portal/adminHome.php">Admin Home</a></li>
                    <li><a href="#" id="add_contact_link">Add Contact No.</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
<h4 align="center" >Remote Staff Contact Numbers Management</h4>
<div align="center" style="margin-top:20px;">
	<div id="nos_list" class="contact_no_type_box"></div>   
 </div>  	

</div>

<p>&nbsp;</p>

<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2013 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <h4>Contact Number</h4>
    </div>
    <div class="modal-body" id="modal_body">
        <div class="divDialogElements">
            <div id="contract_result" class="contact_no_type_box"></div>
        </div>
    </div>
    <div class="modal-footer">
    	<button type="button" id="add_update_btn" class="btn btn-primary" ></button>
        <button type="button" id="close_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
</body>
<script type="text/javascript" src="./media/js/rs_contact_nos.js"></script>
</html>