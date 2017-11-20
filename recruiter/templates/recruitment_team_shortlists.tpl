<!DOCTYPE html>
<html>
<head>
	<title>Recruitment Team Shortlist Reports</title>
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
	<link rel=stylesheet type=text/css href="../css/font.css"/>
	<link rel=stylesheet type=text/css href="../menu.css"/>
	<link rel=stylesheet type=text/css href="../adminmenu.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css"/>
	<link rel=stylesheet type=text/css href="../category/category.css"/>
	<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css"/>
		
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_sheet.css"/>
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
	
	<script type="text/javascript" src="/portal/recruiter/js/recruitment_team_shortlist.js"></script>
	{literal}
	<style type="text/css">
		body{
			font:Arial, Helvetica, sans-serif;
		}
	</style>
	{/literal}
	
	
</head>
<body>
	{php} include("header.php") {/php}
	{php} include("recruiter_top_menu.php") {/php}
	<br/><h1 class="header" style="text-align:left">Recruitment Team Shortlist Reports</h1>
        
	<div id="filter-form-container">
		<form id="filter-form" class="well form-inline">
			<div class="row-fluid">
				<div class="span2">
					<div class="control-group">
						<label class="control-label" for="date_ordered_from"> Date Ordered From: </label>
						<div class="controls">
							<input type="text" name="date_from" id="date_ordered_from" placeholder="Date Ordered From" class="span12"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="date_ordered_to"> Date Ordered To: </label>
						<div class="controls">
							<input type="text" name="date_to" id="date_ordered_to" placeholder="Date Ordered To" class="span12" />
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="control-group">
						<label class="control-label" for="order_status"> Order Status: </label>
						<div class="controls">
							<select id="order_status" name="order_status" class="span12">{$order_status_options}</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="service_type"> Service Type: </label>
						<div class="controls">
							<select id="service_type" name="service_type" class="span12">{$service_type_options}</select>
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="control-group">
						<label class="control-label" for="shortlist_type"> Shortlist Type: </label>
						<div class="controls">
							<select id="shortlist_type" name="shortlist_type" class="span12">{$shortlist_type_options}</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="hiring-coordinators"> Hiring Manager: </label>
						<div class="controls">
							<select id="hiring-coordinators" name="hiring_coordinator" class="span12">{$hiring_coordinator_options}</select>
						</div>
					</div>
				</div>
				<div class="span6"></div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<div class="control-group">
						<label class="control-label" for="keyword"> Keyword: </label>
						<div class="controls">
							<input id="keyword" name="keyword" type="text" class="span12" placeholder="Enter client's name or tracking code of the order"/>
						</div>
					</div>
				</div>
				<div class="span2">
					<label class="control-label" for="inhouse_staff"> Include Inhouse Staff: </label>
					<div class="controls">
						<select id="inhouse_staff" name="inhouse_staff" class="span12">
							<option value="yes"> Yes </option>
							<option value="no"> No</option>
						</select>
					</div>
				</div>
				<div class="span6"></div>
			</div>
			<div class="row-fluid">
				<div class="span6" style="text-align:right;"><button type="submit" class="btn btn-primary"> <i class="icon-search icon-white"></i> Search </button></div>
				<div class="span6"></div>
			</div>		
		</form>
	</div>
	<small>
		<div class="row-fluid">
			<ul class="nav nav-tabs">
			  <li class="active"><a href="/portal/recruiter/recruitment_team_shortlists.php">Shortlist Report</a></li>
			  <li><a href="/portal/recruiter/recruitment_team_endorsements.php">Endorsement Report</a></li>
			</ul>
		</div>
		<div class="row-fluid">
			<div class="pagination pagination-small pull-right">
			  <ul>
			    <li><a href="#" class="prev disabled">Prev</a></li>
			    <li><a href="#" class="next">Next</a></li>
			  </ul>
			</div>			
			<div class="showing pull-right" style="margin-top:25px;margin-right:5px">
				<span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
			</div>
		</div>
		<div class="wrapper" style="position:relative">
			<table id="recruitment_report_list" class="table table-condensed table-striped table-bordered">
				<thead>
					<tr>
						<th width="12%"><small style="font-size:10px">Job Order</small></th>
						<th width="8%"><small style="font-size:10px">Client</small></th>
						<th width="5%"><small style="font-size:10px">Service Type</small></th>
						<th width="5%"><small style="font-size:10px">Staff Needed</small></th>
						<th width="8%"><small style="font-size:10px">Hiring Managers</small></th>
						<th width="8%"><small style="font-size:10px">Assigned Recruiters</small></th>
						
						<th><small style="font-size:8px">Shortlisted?</small></th>
						<th><small style="font-size:10px">Total</small></th>
						
						{foreach from=$recruiters item=recruiter}
							<th class="recruiter_header" data-admin_id="{$recruiter.admin_id}"><small style="font-size:10px">{$recruiter.admin_fname}</small></th>
						{/foreach}
						<th><small style="font-size:10px">Categories</small></th>
						<th><small  style="font-size:10px">HM Notes</small></th>
						
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>	
			<div id="rs-preloader" class="rs-preloader" style="display:none;height: 100%; width: 100%; opacity: 0.5; left: 0; top:0; position:absolute"><img src="../images/ajax-loader.gif" id="preloader-img" style="vertical-align: middle"></div>
		</div>
	
		<div class="row-fluid">
			<div class="pagination pagination-small pull-right">
			  <ul>
			    <li><a href="#" class="prev disabled">Prev</a></li>
			    <li><a href="#" class="next">Next</a></li>
			  </ul>
			</div>			
			
			<div class="showing pull-right" style="margin-top:25px;margin-right:5px">
				<span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
			</div>
		</div>
		
		
		
		<div class="row-fluid">
			<div class="span6">
				<h4 style="margin-top:5px;">Total Shortlist Per Recruiter</h4>
				<table class="table table-bordered table-condensed table-striped" id="total_shortlists">

					<thead>
						<tr>
							<th>Recruiter</th>
							<th>Number of Shortlist on Assigned Order </th>
							<th>Number of Shortlist on Other's Order  </th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$recruiter_shortlists item=recruiter}
							<tr>
								
								<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
								<td>{$recruiter.assigned}</td>
								<td>{$recruiter.unassigned}</td>
							</tr>
						{/foreach}
						<tr>
							<td><strong>Total</strong></td>
							<td><strong>{$shortlists.totalAssigned}</strong></td>
							<td><strong>{$shortlists.totalUnassigned}</strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</small>
	<div id="details-dialog"></div>
</body>
</html>
