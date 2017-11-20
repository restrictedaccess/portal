<!DOCTYPE html>
<html>
	<head>
		<title>Recruiter Job Order Summary</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

		<script type="text/javascript" src="/portal/recruiter/js/recruiter_job_order_summary_view.js"></script>
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

		<div class="container-fluid" style="clear:both;margin-top:5px;">
			<div class="row-fluid">
				<h3 style="text-align: left;text-transform:none">Recruiter Job Order Summary</h3>
			</div>
			<small>
				<div class="row-fluid" style="padding-top:20px;">
					<div class="span6">
						<h4 style="margin-top:5px;">Total Open Orders</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th>Hiring Manager</th>
									<th>Total Open Orders</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$open_orders item=hiringManager}
								<tr>
									{if $hiringManager.admin}
									<td>{$hiringManager.admin.admin_fname} {$hiringManager.admin.admin_lname}</td>
									<td><a href="/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=0&hiring_coordinator={$hiringManager.admin.admin_id}&order_status=0" class="popup">{$hiringManager.total_open}</a></td>
								
									{else}
									<td>No Hiring Manager</td>
									<td><a href="/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=0&hiring_coordinator=nohm&order_status=0" class="popup">{$hiringManager.total_open}</a></td>
								
									{/if}
								</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href="/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=0&hiring_coordinator=&order_status=0" class="popup">{$summary.totalOpenOrderSum}</a></strong></td>

								</tr>
							</tbody>
						</table>
					</div>

				</div>
				<div class="row-fluid" style="padding-top:10px;">
					<div class="span6">
						<h4 style="margin-top:5px;">Percentage Value of Open Order Per Service Type</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th>Service Type</th>
									<th>Percentage</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Custom</td>
									<td>{$summary.totalPercentageCustom} %</td>
								</tr>
								<tr>
									<td>ASL</td>
									<td>{$summary.totalPercentageASL} %</td>
								</tr>
								<tr>
									<td>Back Order</td>
									<td>{$summary.totalPercentageBackOrder} %</td>
								</tr>
								<tr>
									<td>Replacement</td>
									<td>{$summary.totalPercentageReplacement} %</td>
								</tr>
								<tr>
									<td>Inhouse</td>
									<td>{$summary.totalPercentageInhouse} %</td>
								</tr>
								<tr>
									<td><strong>Total</strong></td>
									<td><strong>100%</td>

								</tr>
							</tbody>
						</table>
					</div>
					<div class="span6">
						<h4 style="margin-top:5px;">Number of Open Order Per Service Type</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th>Service Type</th>
									<th>Number of Open Orders</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Custom</td>
									<td><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=1&hiring_coordinator=&order_status=0' class="popup">{$summary.totalCustom}</a></td>
								</tr>
								<tr>
									<td>ASL</td>
									<td><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=2&hiring_coordinator=&order_status=0' class="popup">{$summary.totalASL}</a></td>
								</tr>
								<tr>
									<td>Back Order</td>
									<td><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=3&hiring_coordinator=&order_status=0' class="popup">{$summary.totalBackOrder}</a></td>
								</tr>
								<tr>
									<td>Replacement</td>
									<td><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=4&hiring_coordinator=&order_status=0' class="popup">{$summary.totalReplacement}</a></td>
								</tr>
								<tr>
									<td>Inhouse</td>
									<td><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=5&hiring_coordinator=&order_status=0' class="popup">{$summary.totalInhouse}</a></td>
								</tr>
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/load_job_posting_details.php?filter_type=3&today=1&service_type=0&hiring_coordinator=&order_status=0' class="popup">{$summary.totalOpenOrderSum}</a></td>

								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row-fluid" style="padding-top:10px;">
					<div class="span6">
						<h4 style="margin-top:5px;">Total Open Order Assigned Per Recruiter (CUSTOM TEAM A - Liz)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Count</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$assignedOpenOrderLiz item=recruiter}
									<tr>
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id={$recruiter.admin_id}' class="popup">{$recruiter.open_orders}</a></td>
										
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id=ALL&team=liz' class="popup">{$assignedOpenOrderTeamLiz}</a></strong></td>
								</tr>
							</tbody>
						</table>
						
						<h4 style="margin-top:5px;">Total Open Order Assigned Per Recruiter (CUSTOM TEAM B - Paulo)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Count</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$assignedOpenOrderPau item=recruiter}
									<tr>
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id={$recruiter.admin_id}' class="popup">{$recruiter.open_orders}</a></td>
										
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id=ALL&team=pau' class="popup">{$assignedOpenOrderTeamPau}</a></strong></td>
								</tr>
							</tbody>
						</table>
						
						<h4 style="margin-top:5px;">Total Open Order Assigned Per Recruiter (Talent Acquisition/Recruitment Support)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Count</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$assignedOpenOrderOthers item=recruiter}
									<tr>
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id={$recruiter.admin_id}' class="popup">{$recruiter.open_orders}</a></td>
										
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/list_open_order_recruiter.php?recruiter_id=ALL&team=other' class="popup">{$assignedOpenOrderTeamOthers}</a></strong></td>
								</tr>
							</tbody>
						</table>
						
					</div>
					<div class="span6">
						<h4 style="margin-top:5px;">Total Shortlist Per Recruiter (CUSTOM TEAM A - Liz)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Number of Shortlist on Assigned Order </th>
									<th>Number of Shortlist on Other's Order  </th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$shortlist_liz item=recruiter}
									<tr>
										
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=assigned' class="popup">{$recruiter.assigned}</a></td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=unassigned' class="popup">{$recruiter.unassigned}</a></td>
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=assigned&team=liz' class="popup">{$totalassigned_liz}</a></strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=unassigned&team=liz' class="popup">{$totalunassigned_liz}</a></strong></td>
								</tr>
							</tbody>
						</table>
						<h4 style="margin-top:5px;">Total Shortlist Per Recruiter (CUSTOM TEAM B - Paulo)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Number of Shortlist on Assigned Order </th>
									<th>Number of Shortlist on Other's Order  </th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$shortlist_pau item=recruiter}
									<tr>
										
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=assigned' class="popup">{$recruiter.assigned}</a></td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=unassigned' class="popup">{$recruiter.unassigned}</a></td>
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=assigned&team=pau' class="popup">{$totalassigned_pau}</a></strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=unassigned&team=pau' class="popup">{$totalunassigned_pau}</a></strong></td>
								</tr>
							</tbody>
						</table>
						<h4 style="margin-top:5px;">Total Shortlist Per Recruiter (Talent Acquisition/Recruitment Support)</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th width="20%">Recruiter</th>
									<th>Number of Shortlist on Assigned Order </th>
									<th>Number of Shortlist on Other's Order  </th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$shortlist_other item=recruiter}
									<tr>
										<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=assigned' class="popup">{$recruiter.assigned}</a></td>
										<td><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id={$recruiter.admin_id}&type=unassigned' class="popup">{$recruiter.unassigned}</a></td>
									</tr>
								{/foreach}
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=assigned&team=other' class="popup">{$totalassigned_others}</a></strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?recruiter_id=All&type=unassigned&team=other' class="popup">{$totalunassigned_others}</a></strong></td>
								</tr>
							</tbody>
						</table>
						
					</div>
					
				</div>
				
				<div class="row-fluid" style="padding-top:10px;">
					<div class="span6">
						<h4 style="margin-top:5px;">Percentage of Orders with Shortlist Per Service Type</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th>Service Type</th>
									<th>Percentage</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Custom</td>
									<td>{$shortlists.totalPercentageCustom} %</td>
								</tr>
								<tr>
									<td>ASL</td>
									<td>{$shortlists.totalPercentageASL} %</td>
								</tr>
								<tr>
									<td>Back Order</td>
									<td>{$shortlists.totalPercentageBackOrder} %</td>
								</tr>
								<tr>
									<td>Replacement</td>
									<td>{$shortlists.totalPercentageReplacement} %</td>
								</tr>
								<tr>
									<td>Inhouse</td>
									<td>{$shortlists.totalPercentageInhouse} %</td>
								</tr>
								<tr>
									<td><strong>Total</strong></td>
									<td><strong>100%</td>

								</tr>
							</tbody>
						</table>
					</div>
					<div class="span6">
						<h4 style="margin-top:5px;">Number of Shortlist Per Service Type</h4>
						<table class="table table-bordered table-condensed table-striped">

							<thead>
								<tr>
									<th>Service Type</th>
									<th>Total Number of Shortlists</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Custom</td>
									<td><a href='/portal/recruiter/load_shortlist_details.php?service_type=CUSTOM' class="popup">{$shortlists.totalShortlistCustom}</a></td>
								</tr>
								<tr>
									<td>ASL</td>
									<td><a href='/portal/recruiter/load_shortlist_details.php?service_type=ASL' class="popup">{$shortlists.totalShortlistASL}</a></td>
								</tr>
								<tr>
									<td>Back Order</td>
									<td><a href='/portal/recruiter/load_shortlist_details.php?service_type=BACK ORDER' class="popup">{$shortlists.totalShortlistBackOrder}</a></td>
								</tr>
								<tr>
									<td>Replacement</td>
									<td><a href='/portal/recruiter/load_shortlist_details.php?service_type=REPLACEMENT' class="popup">{$shortlists.totalShortlistReplacement}</a></td>
								</tr>
								<tr>
									<td>Inhouse</td>
									<td><a href='/portal/recruiter/load_shortlist_details.php?service_type=INHOUSE' class="popup">{$shortlists.totalShortlistInhouse}</a></td>
								</tr>
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><a href='/portal/recruiter/load_shortlist_details.php?service_type=ALL' class="popup">{$shortlists.totalShortlist}</a></td>

								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				
				
				
				 </small>

		</div>
	</body>
</html>