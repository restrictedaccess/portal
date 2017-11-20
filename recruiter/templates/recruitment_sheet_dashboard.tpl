<!DOCTYPE html>
<html>
<head>
	<title>Recruitment Sheet Dashboard</title>
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
	<script type="text/javascript" src="/portal/recruiter/js/recruitment_dashboard.js"></script>
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
	<br/><h1 class="header" style="text-align:left">Recruitment Dashboard</h1>
        
	<div id="filter-form-container">
		<form id="filter-form" class="well form-inline">
				<label class="radio"><input type="radio" name="selected" value="Today" checked class="selector"/>  Today:            <button class="btn" id="today_button" style="margin-left:72px">{$dateTo}</button></label><br/>
				<label>or</label><br/>
				<label class="radio">
					<input type="radio" name="selected" value="Order Date"  class="selector"/>  Order Date From:   <input type="text" class="span2" id="date-from" name="date-from" placeholder="Date From" value="{$dateFrom}" style="margin-left:10px" disabled/> Order Date To: <input style="margin-left:1em" type="text" class="span2" id="date-to" name="date-to" placeholder="Date To" value="{$dateTo}" disabled/>&nbsp;&nbsp;Order Status:&nbsp;&nbsp;
					<select id="order-status" name="order-status" disabled>
						<option value="-1">All</option>
						<option value="0" selected>Open</option>
						<option value="1">Closed</option>
						<option value="2">Did not push through</option>
						<option value="3">On Hold</option>
						<option value="4">On Trial</option>
					</select>	
				</label><br/>
				<label>or</label><br/>
				<label class="radio">
					<input type="radio" name="selected" value="Closing Date"  class="selector"/>Closing Date From: <input type="text" class="span2" id="close-date-from" name="close-date-from" placeholder="Date From" value="{$dateFrom}" disabled/> Closing Date To: <input type="text" class="span2" id="close-date-to" name="close-date-to" placeholder="Date To" value="{$dateTo}" disabled/>
				</label><br/><br/>
				<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i>Search</button>&nbsp;&nbsp;<button type="submit" class="btn" id="export_button"><i class="icon-share"></i>Export</button><br/><label>
				<br/><label>
				
				<strong style="color:#ff0000">Note:&nbsp;</strong>The report below is for the order open for today. Use the date filter to search between order dates or closing dates.</label>
		</form>
	</div>
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active"><a href="#order_status" data-type="order-status">Order Status</a></li>
	</ul>
	<div class="tab-content">
		<div id="order_status" class="tab-pane active">
			{include file="recruitment_sheet_dashboard_table.tpl"}	
		</div>
		
		
		<div id="endorsements" class="tab-pane">
			{include file="recruitment_sheet_dashboard_table.tpl"}	
		</div>
		
		<div id="interviewed" class="tab-pane">
			{include file="recruitment_sheet_dashboard_table.tpl"}	
		</div>
		
	
		<div id="cancelled" class="tab-pane">
			{include file="recruitment_sheet_dashboard_table.tpl"}	
		</div>
		
		<div id="hired" class="tab-pane">
			{include file="recruitment_sheet_dashboard_table.tpl"}	
		</div>
	</div>
	
</body>
</html>