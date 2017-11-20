<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Recruitment Sheet - Recruiter View</title>
		<script type="text/javascript" src="js/new_recruitment_sheet.js"></script>
	</head>

	<body>

		{include file="new_header.tpl"}
		<div id="container">
			<!-- Recruiter Home -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Recruitment Sheet - Recruiter View</h3>

			<form method="GET" class="form-inline"  role="form" id="recruitment-sheet-filter">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Advanced Search</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Individual Filters</label>
						</div>
						<div id="individual-filter" class="form-group">

						</div>
						<div class="form-group">
							<select id="individual-filter-type" name="individual-filter-type" class="form-control">
								<option value="0">-</option><option value="1">Job Title</option><option value="3">Date Ordered</option><option value="9">Date Updated</option>
							</select>
						</div>
						<div class="form-group">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Include Inhouse Staff&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="form-group">
							<select id="inhouse-staff" name="inhouse-staff" class="form-control">
								<option value="yes">Yes</option>
								<option value="no">No</option>

							</select>
						</div>
						<br/>
						<br/>
						<div class="form-group">
							<label>Enter Keyword&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="form-group" style="width:500px">
							<input style="width:100%" class="form-control" type="text" name="keyword" placeholder="Enter Tracking Code, Clients' name and/or Applicants' name" id="keyword" size="85">
						</div>
						<br/>
						<br/>
						<div class="form-group">
							<label>Recruiters&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="form-group">
							<select id="recruiters" name="recruiters" class="form-control">
								{$recruiter_options}
							</select>
						</div>
						<div class="form-group" style="margin-left:40px;">
							<label>Staffing Consultants</label>
						</div>
						<div class="form-group">
							<select id="hiring-coordinators" name="hiring-coordinators" class="form-control">
								{$hiring_coordinator_options}
							</select>
						</div>
						<br/>
						<br/>
						<div class="form-group">
							<label>Order Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="form-group">
							<select id="order_status" name="order_status" class="form-control">
								<option value="VIEW ALL">View All</option>
								<optgroup label="Assigning Status">
									{foreach from=$assigning_statuses item=assigning_status}
									<option value="{$assigning_status.value}">{$assigning_status.label}</option>
									{/foreach}
								</optgroup>
								<optgroup label="Hiring Status">
									{foreach from=$hiring_statuses item=assigning_status}
									<option value="{$assigning_status.value}">{$assigning_status.label}</option>
									{/foreach}
								</optgroup>
								<optgroup label="Decision Status">
									{foreach from=$decision_statuses item=assigning_status}
									<option value="{$assigning_status.value}">{$assigning_status.label}</option>
									{/foreach}
								</optgroup>

							</select>
						</div>

						<div class="form-group">
							<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service Type&nbsp;&nbsp;&nbsp;</label>
						</div>
						<div class="form-group">
							<select id="service_type" name="service_type" class="form-control">
								<option value="VIEW ALL">View All</option>

								<option value="CUSTOM">CUSTOM</option>
								<option value="ASL">ASL</option>
								<option value="BACK ORDER">BACK ORDER</option>
								<option value="REPLACEMENT">REPLACEMENT</option>
								<option value="INHOUSE">INHOUSE</option>

							</select>
						</div>

						<p class="note">
							<small> <span style="color:#FF0000">NOTE: </span> *Filters will only work after the initial loading of the page. Wait for the page to load then apply any filter. </small>

						</p>
					</div>
					<div class="panel-footer">
						<button class="btn btn-primary">
							Search
						</button>
					</div>
				</div>
			</form>
			<div style="overflow:hidden">

				<div class="pull-right">
					<ul class="pagination">
						<li class="disabled prev">
							<span>&laquo;</span>
						</li>
						<li class="disabled next">
							<span>&raquo;</span>
						</li>
					</ul>
				</div>
				<div class="pull-left">
					Showing <span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
				</div>

			</div>

			<div id="recruitment_sheet_body" style="position:relative">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="2%">#</th>
							<th width="10%">Job Order</th>
							<th width="10%">Position</th>
							<th width="7%">Order Status</th>
							<th width="7%">Service Type</th>
							<th width="10%">Client</th>
							<th width="10%">Staffing Consultant</th>
							<th width="7%">Recruiters</th>
							<th width="5%">Notes</th>
							<th width="7%">Attention To</th>
							<th width="10%">Date Ordered</th>
							<th width="10%">Date Updated</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

				<div id="rs-preloader" class="rs-preloader" style="background-color:#fff;display:none;height: 100%; width: 100%; opacity: 0.5; left: 0; top:0px; position:absolute;text-align:center"><img src="../images/ajax-loader.gif" id="preloader-img" style="vertical-align: middle">
				</div>
			</div>
			<div style="overflow:hidden">

				<div class="pull-right">
					<ul class="pagination">
						<li class="disabled prev">
							<span>&laquo;</span>
						</li>
						<li class="disabled next">
							<span>&raquo;</span>
						</li>
					</ul>
				</div>
				<div class="pull-left">
					Showing <span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
				</div>

			</div>

			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}

		</div>

		<div class="modal fade" id="view_history_popup">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">View History</h4>
					</div>
					<div class="modal-body" style="overflow: hidden">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary">
							Save changes
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		{literal}
		<script type="text/x-handlebars-template" id="job_order_row">
			<tr>
			<td>{{i}}</td>
			<td><strong>{{tracking_code}}</strong></td>
			<td>{{{job_title}}}</td>
			<td>{{sub_status}}</td>
			<td>{{service_type}}</td>

			<td>
			<a href="/portal/leads_information.php?id={{leads_id}}" target="_blank">{{lead_firstname}} {{lead_lastname}}</a>
			</td>
			<td>
			{{#if hc_fname}}
			{{hc_fname}} {{hc_lname}}
			{{else}}
			No SC Assigned
			{{/if}}
			</td>
			<td>
			{{#each recruiters}}
			{{recruiter.admin_fname}} {{recruiter.admin_lname}}<br/>
			{{else}}
			No Recruiter Assigned
			{{/each}}
			</td>
			<td>
			<a href="/portal/recruiter/load_comments.php?tracking_code={{tracking_code}}&bootstrap=bootstrap" class="comment_box" target="_blank">View Notes({{job_order_comments_count}})</a>
			</td>
			<td><strong>{{attention_to}}</strong></td>
			<td>{{date_filled_up}}</td>

			<td>{{date_updated_attention_to}}</td>
			<td><button class="btn btn-default need_more_candidate" {{#if lock_manual}}disabled {{/if}}data-tracking_code="{{tracking_code}}">Need More Candidate</button><br/><button class="btn btn-default skill_test" {{#if lock_manual}}disabled {{/if}} data-tracking_code="{{tracking_code}}">Skill Test</button><br/><button {{#if lock_manual}}disabled {{/if}} class="btn btn-default sc_reviewing_order" data-tracking_code="{{tracking_code}}">SC Reviewing Order</button></td>
			</tr>
		</script>
		{/literal}
	</body>
</html>