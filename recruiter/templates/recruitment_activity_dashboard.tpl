<!DOCTYPE html>
<html>
<head>
	<title>Recruitment Activity Dashboard</title>
	<link rel="stylesheet" href="/portal/recruiter/css/style.css"/>
	
	<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/grid.locale-en.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript">
		jQuery.jgrid.no_legacy_api = true;
		jQuery.jgrid.useJSON = true;
	</script>
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/ui.jqgrid.css"/>
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css"/>
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/rsgrid.css"/>
	
	<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap-tab.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/recruitment_activity_dashboard.js"></script>
	<link rel=stylesheet type=text/css href="../css/font.css"/>
	<link rel=stylesheet type=text/css href="../menu.css"/>
	<link rel=stylesheet type=text/css href="../adminmenu.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css"/>
	<link rel=stylesheet type=text/css href="../category/category.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css"/>
		
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_sheet.css"/>
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
	
	
	
</head>
<body>
	{php} include("header.php") {/php}
	{php} include("recruiter_top_menu.php") {/php}
	<br/><h1 class="header" style="text-align:left">Recruitment Activity Reports</h1>
        
	<div id="filter-form-container">
		<form id="filter-form" class="well form-inline">
				<label>Date From:</label>
				<input type="text" class="span2" id="date-from" name="date-from" placeholder="Date From" value="{$dateFrom}"/>
				<label>Date To:</label>
				<input type="text" class="span2" id="date-to" name="date-to" placeholder="Date To" value="{$dateTo}"/><br/><br/>
				<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i>Search</button>
		</form>
		
	
	
	</div>
	<ul class="nav nav-tabs" id="myTab">
	  <li><a href="/portal/recruiter/recruitment_contract_dashboard.php" data-type="order-status">Staff Contract Counters</a></li>
	  <li class="active"><a href="#order_status" data-type="order-status">Activities</a></li>
	  
	</ul>
	<div class="tab-content">
		<div id="order_status" class="tab-pane active">
			{include file="recruitment_activity_dashboard_table.tpl"}	
		</div>
	</div>
	
</body>
</html>