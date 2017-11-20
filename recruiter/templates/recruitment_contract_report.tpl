<!DOCTYPE html>
<html>
<head>
	<title>Recruiters' New Hires Reporting</title>
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
	<script type="text/javascript" src="/portal/recruiter/js/recruitment_contracts_dashboard.js"></script>
	
	<link rel=stylesheet type=text/css href="../css/font.css"/>
	<link rel=stylesheet type=text/css href="../menu.css"/>
	<link rel=stylesheet type=text/css href="../adminmenu.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css"/>
	<link rel=stylesheet type=text/css href="../category/category.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css"/>
	
		
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_sheet.css"/>
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_dashboard_contract.css"/>
	
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
	
</head>

<body>
	{php} include("header.php") {/php}
	{php} include("recruiter_top_menu.php") {/php}
	<br/><h1 class="header" style="text-align:left">Recruiters' New Hires Reporting</h1>
        
	<div id="filter-form-container">
		
		<form id="filter-form" class="well form-inline">
			<div class="row-fluid">
				<div class="span2">
					<div class="control-group">
						<label class="control-label" for="date_from"> Contract Start Date From: </label>
						<div class="controls">
							<input type="text" class="span12" id="date_from" name="date_from" placeholder="Date Hired From" value="{$dateFrom}"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="date_to"> To: </label>
						<div class="controls">
							<input type="text" class="span12" id="date_to" name="date_to" placeholder="Date Hired To" value="{$dateTo}"/>
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="control-group">
						<label class="control-label" for="contract_status"> Contract Status: </label>
						<div class="controls">
							<select id="contract_status" name="contract_status" class="span12">
								<option value="All">All</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="inhouse_staff"> Include Inhouse Staff: </label>
						<div class="controls">
							<select id="inhouse_staff" name="inhouse_staff" class="span12">
								<option value="yes"> Yes </option>
								<option value="no"> No</option>
							</select>
						</div>
					</div>
				</div>
				<div class="span8"></div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<div class="control-group">
						<div class="controls" style="text-align:right;">
							<button type="submit" class="btn btn-primary"> <i class="icon-search icon-white"></i> Search </button>
						</div>
					</div>
				</div>
				<div class="span8"></div>
			</div>
			<div class="row">
				<div class="span12">
					<strong style="color:#ff0000"> Note: </strong> When Active filter is used, Search Result equals Active and Suspended Staffs </label>
				</div>
			</div>
		</form>
		
	
	
	</div>
	
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#contract_status" data-type="order-status">Staff Contract Counters</a></li>
		<li><a href="/portal/recruiter/recruitment_activity_dashboard.php" data-type="order-status">Activities</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="contract_status" class="tab-pane active">
			{include file="recruitment_contract_report_table.tpl"}	
		</div>
	</div>
	
</body>
</html>
