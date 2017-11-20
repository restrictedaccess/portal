<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leave Request Management</title>

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


<link rel="stylesheet" type="text/css" href="/portal/leave_request_form/media/css/antique.css" />
<link rel=stylesheet type=text/css href="./media/css/lrm.css">

    <script type="text/javascript" src="/portal/js/jscal2.js"></script> 
	<script type="text/javascript" src="/portal/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />
    
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
                <p class="navbar-text pull-right list_of_subcons"><a href="./">Leave Request Management</a></p>
                <ul id="nav" class="nav">
                    <li><a href="/portal/adminHome.php">Admin Home</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
<h4 align="center" >Staff Leave Request Management</h4>

<form name="form" id="form" method="post">
<input type="hidden" name="nodejs_api" id="nodejs_api" value="{$nodejs_api}"/>
<div>Select Staff : 
    <select name="userid" id="userid">
    	<option value="">All Staff</option>
    	{foreach from=$staffs item=staff name=staff}
        	<option {if $userid eq $staff.userid} selected{/if} value="{$staff.userid}">{$staff.fname|capitalize} {$staff.lname|capitalize}</option>
        {/foreach}
    </select>
    
    From : <input type="text" readonly name="start_date" style="width:85px; cursor:pointer;"  id="start_date" value="{$start_date}" > 
    To : <input type="text" readonly name="end_date" style="width:85px; cursor:pointer;"  id="end_date" value="{$end_date}" > 
    
    CSRO
    <select name="csro_id" id="csro_id">
    	<option value=""></option>
    	{foreach from=$csros item=csro name=csro}
        	<option {if $csro_id eq $csro.admin_id} selected{/if} value="{$csro.admin_id}">{$csro.admin_fname|capitalize} {$csro.admin_lname|capitalize}</option>
        {/foreach}
    </select>         
</div>
<div>
	<button id="search-btn">Search</button>	
	<button id="add-leave-btn" class="hide">Add Leave</button>
	
</div>
</form>

	<div id="leave_reqeust_container" class="hide"></div>
	
	
	
	<table id="leave-request-tb" class="table table-condensed table-bordered table-striped">
		<thead>
			<th width="11%">Leave Request ID</th>
			<th>Staff</th>
			<th>Client</th>
			<th>Staffing Consultant</th>
			<th>Date Requested</th>
			<th>Leave Type</th>
			<th>Date Of Leave</th>
			<th>Status</th>
		</thead>
		<tbody></tbody>
	</table>

</div>
<p>&nbsp;</p>
<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2017 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>

</body>

<div id="windowTitleDialog" class="modal  hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
    <div class="modal-header">
        <h3>Information</h3>
    </div>
    <div class="modal-body modal-lg" id="modal_body">
        <div class="divDialogElements">
            <div id="leave_request_result"></div>
            <!--<div id="add_leave_form" class="hide"></div>-->
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="close_btn" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
<script type="text/javascript" src="./media/js/lr.js"></script>
</html>