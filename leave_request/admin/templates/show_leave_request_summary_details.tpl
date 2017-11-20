<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leave Request List</title>

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
<h4 align="center" >Leave Request List</h4>
<form name="leave_request_summary_frm" id="leave_request_summary_frm" method="get">
	<input type="hidden" name="summary_type" id="summary_type" value="{$summary_type}">
	<input type="hidden" name="year" id="year" value="{$year}">
    <input type="hidden" id="page" name="page" value="1" />
    <input type="hidden" id="status" name="status" value="{$status}" />
    <input type="hidden" id="inhouse" name="inhouse" value="{$inhouse}" />
    <!--<button type="submit" class="btn btn-default">Search</button>-->
    
    <div align="center">
        <ul id="pagination-result-list" class="pagination"></ul>
        <div class="num_of_records"></div> 
    </div>

	<p align="center"><a href="#" class="btn btn-primary export" data-target="result-list">Export</a></p>
    <table id="leave_request_list" width="100%" class="table table-condensed table-striped table-bordered">
    	<thead style="background:#666; color:#FFF;">
        	<th>#</th>
            <th width="10%">Leave Type</th>
            <th width="17%">Staff</th>
            <th width="25%">Reason</th>
            <th width="17%">Client</th>
            <th>Date Of Leave</th>
        </thead>
    	<tbody>
	    	<tr><td>Loading...</td></tr>
        </tbody>
    </table>
    
    
    
    
</form>
</div>
<p>&nbsp;</p>
<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2013 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>

</body>
<script type="text/javascript" src="./media/js/show_leave_request_summary.js"></script>
</html>