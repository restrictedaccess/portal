<!DOCTYPE html>
<html>
	<head>
		<title>Recruitment ASL Reporting</title>
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
		<script type="text/javascript" src="/portal/recruiter/js/recruitment_asl_reporting.js"></script>
		{literal}
		<style type="text/css">
			body {
				font: Arial, Helvetica, sans-serif;
			}
		</style>
		{/literal}

	</head>
	<body>
		{php} include("header.php") {/php}
		{php} include("recruiter_top_menu.php") {/php}
		<input type="hidden" id="today_date" value="{$today_date}"/>
		<input type="hidden" id="before_date" value="{$before_today}"/>
		
		<div class="container-fluid" style="clear:both;margin-top:5px;">
			<div class="row-fluid">
				<h3 style="text-align: left;text-transform:none">Recruitment ASL Reporting</h3>
			</div>
			
			<form id="filter-form" class="well form-inline">
				<label>Date Ordered</label>&nbsp;&nbsp;<input type="text" name="date_from" id="date_ordered_from" placeholder="Date From"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="date_to" id="date_ordered_to" placeholder="Date To"/>
				<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i>Search</button>		
				<br/>
				<strong style="color:#ff0000">Note:&nbsp;</strong>The report below is from the first day of the current month to today. Use the filter above to change.</label>
			</form>
			<small>
				<div class="row-fluid" style="position:relative">
					<div class="alert alert-info">
						<strong>Ave.</strong> = Average Job Order (job order per month)<br/><strong>AHT</strong> = Average Handling Time(day per job order)<br/> <strong>Pool</strong> = Pool for # of Post (job order per month)
					</div>
					<table id="recruitment_asl_report_list" class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th>Positions</th>
								<th>Job Orders</th>
								
								<th>Ave.</th>
								<th>AHT</th>
								<th>Pool</th>
								<th>Total</th>
								{foreach from=$recruiters item=recruiter}
									<th class="recruiter_header" data-admin_id="{$recruiter.admin_id}"><small style="font-size:10px">{$recruiter.admin_fname}</small></th>
								{/foreach}
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					<div id="rs-preloader" class="rs-preloader" style="display:none;height: 100%; width: 100%; opacity: 0.5; left: 0; top:0; position:absolute"><img src="../images/ajax-loader.gif" id="preloader-img" style="vertical-align: middle"></div>
				</div>		
				
			</small>

		</div>
	</body>
</html>