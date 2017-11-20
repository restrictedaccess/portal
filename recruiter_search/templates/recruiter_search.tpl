<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Recruiter Home - Remote Staff</title>
		<link rel="stylesheet" href="/portal/recruiter_search/css/recruiter_search.css"/>
		<link href="/portal/assets/css/loading.css" media="screen" rel="stylesheet" type="text/css" >
		
		<link href="/portal/assets/inspinia/font-awesome/css/font-awesome.css" media="screen" rel="stylesheet" type="text/css">
		
	</head>

	<body>
		{include file="new_header.tpl"}
		<div id="container">
			<!-- Recruiter Home Search -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Recruiter Full Search Page</h3>
			<div class="indented">
				<div class="row">
					<div class="col-xs-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								Search
							</div>
							<div class="panel-body" style="overflow:hidden">
								<form id="search-form" method="post">
									<div class="col-lg-2"></div>
									<div class="col-lg-8">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Search Candidate, Job Order" name="q" value="{$q}" id="search-text-box">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit">
														Search
													</button> </span>
											</div>
										</div>
									</div>
									<div class="col-lg-2"></div>
								</form>
							</div>
						</div>

						<!-- /** navigation header **/ -->

						<ul id="searchtab" class="nav nav-tabs">
							<li class="active">
								<a href="#candidate_info" data-toggle="tab">Candidates &nbsp; <span class="badge" id="candidates_badge"> 0 </span></a>
							</li>
							<li>
								<a href="#resume_info" data-toggle="tab">Resume &nbsp; <span class="badge" id="resume_badge"> 0 </span></a>
							</li>
							<li>
								<a href="#job_order_info" data-toggle="tab">Job Order &nbsp; <span class="badge" id="job_order_badge"> 0 </span></a>
							</li>
							<li>
								<a href="#leads_info" data-toggle="tab">Leads &nbsp; <span class="badge" id="leads_badge"> 0 </span></a>
							</li>
						</ul>

						<div id="searchtabcontent" class="tab-content" style="position:relative">
							<!-- /** navigation for candidates **/ -->
							<div id="candidate_info" class="tab-pane active">
								<!-- /** Loading state **/ -->
								<!-- /** pagination for candidates - upper **/ -->
								
										
										
								<div style="overflow:hidden">

									<div class="pull-right">
                                        <ul class="candidates-pagination pagination-sm"></ul>
									</div>	
									<div class="pull-left">
										Results <span class="candidates_start_count">0</span> - <span class="candidates_end_count">0</span> out of <span class="candidates_total_records">0</span> records
										
										<!--DOWNLOAD CSV CANDIDATES-->
										{if ($admin.admin_id eq 100) OR ($admin.admin_id eq 256) OR ($admin.admin_id eq 277) OR ($admin.admin_id eq 315) OR ($admin.admin_id eq 314) OR ($admin.admin_id eq 43) OR ($admin.admin_id eq 143) OR ($admin.admin_id eq 180)}
											<div id="input_download_csv" class="input-group" style="margin-bottom: 20%;display:none;">
												<button id="download_csv_candidates" class="download_csv_btn btn btn-primary">Export</button>
											</div>
										{/if}
									</div>
									
								</div>
									
								<!-- /** handlebars template **/ -->
								<div class="candidate_info_list">
									<div class="form-group" id="candidate_result_list"></div>
								</div>
								<!-- /** pagination for candidates - lower **/ -->
								<div style="overflow:hidden">

									<div class="pull-right">
                                        <ul class="candidates-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="candidates_start_count">0</span> - <span class="candidates_end_count">0</span> out of <span class="candidates_total_records">0</span> records
									</div>
								</div>
							</div>
							
							<!-- /** navigation for candidates **/ -->
							<div id="resume_info" class="tab-pane">
								<!-- /** Loading state **/ -->
								<!-- /** pagination for candidates - upper **/ -->
								<div style="overflow:hidden">

									<div class="pull-right">
										 <ul class="resumes-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="resume_start_count">0</span> - <span class="resume_end_count">0</span> out of <span class="resume_total_records">0</span> records
									</div>
								</div>
								<!-- /** handlebars template **/ -->
								<div class="resume_info_list">
									<div class="form-group" id="resume_result_list"></div>
								</div>
								<!-- /** pagination for candidates - lower **/ -->
								<div style="overflow:hidden">

									<div class="pull-right">
										<ul class="resumes-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="resume_start_count">0</span> - <span class="resume_end_count">0</span> out of <span class="resume_total_records">0</span> records
									</div>
								</div>
							</div>
							
							<!-- /** navigation for job_order **/ -->
							<div id="job_order_info" class="tab-pane">
								<!-- /** Loading state **/ -->
								<!-- /** pagination for job_order - upper **/ -->
								<div style="overflow:hidden">
									<div class="pull-right">
										<ul class="job-orders-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="job_orders_start_count">0</span> - <span class="job_orders_end_count">0</span> out of <span class="job_orders_total_records">0</span> records
									</div>
								</div>
								<!-- /** handlebars template **/ -->
								<div class="job_orders_info_list">
									<div class="form-group" id="job_orders_result_list"></div>
								</div>
								<!-- /** pagination for job_order - lower  **/ -->
								<div style="overflow:hidden">
									<div class="pull-right">
										<ul class="job-orders-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="job_orders_start_count">0</span> - <span class="job_orders_end_count">0</span> out of <span class="job_orders_total_records">0</span> records
									</div>
								</div>
							</div>
							<div id="leads_info" class="tab-pane">
								
								<!-- /** pagination for job_order - upper **/ -->
								<div style="overflow:hidden">
									<div class="pull-right">
										<ul class="leads-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="leads_start_count">0</span> - <span class="leads_end_count">0</span> out of <span class="leads_total_records">0</span> records
									</div>
								</div>
								<!-- /** handlebars template **/ -->
								<div class="leads_info_list">
									<div class="form-group" id="leads_result_list"></div>
								</div>
								<!-- /** pagination for job_order - lower  **/ -->
								<div style="overflow:hidden">
									<div class="pull-right">
										<ul class="leads-pagination pagination-sm"></ul>
									</div>
									<div class="pull-left">
										Results <span class="leads_start_count">0</span> - <span class="leads_end_count">0</span> out of <span class="leads_total_records">0</span> records
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="BASE_URL" value="{$base_url_api}"/>
		</div>
		{include file="new_footer.tpl"}
		{include file="popup_dialog_rschat.tpl"}
		</div>
		
		{literal}
		<!-- template for candidates -->
		<script type="text/x-handlebars-template" id="candidate-row-template">
			<div>
			<div class="candidates_profile">
			<label for="candidates_name">
			<span style="font-weight:bold;cursor:pointer;color:#158cba;" onclick="window.open('/portal/recruiter/staff_information.php?userid={{candidate.userid}}&page_type=popup','Staff Information {{candidate.userid}}',
			'menubar=no,width=1000,height=500,toolbar=no,scrollbars=yes')">
			#{{candidate.userid}} - {{candidate.fname}} {{candidate.lname}}</span>
			</label>
			</div>
			<div>
			<label for="candidates_status">
			{{#if candidate.inactive}}
			Status: <span style="color:red;font-weight: bolder">{{staff_status}}</span></br>
			{{else}}
			Status: <span style="color:blue;font-weight: bolder">{{staff_status}}</span></br>
			{{/if}}
			</label>
			</div>
			<div><label for ="assigned_recruiter">
				Recruiter Assigned: <span style="color:#2E2EFE;">{{candidate.admin_fname}} {{candidate.admin_lname}}</span>
			</label>
			<div>
			<label for="current_job_title" >
			Current Job Title: <span style="color:blue;">{{candidate.position}}</span>
			</div>
			<div class="highlighted_result">
			<label for="highlighted_result">Highlighted Result: </label>
			<div class="panel panel-body">
			{{{highlighted_result}}}
			</div>
			</div>
			</div>
		</script>
		<!-- /template for candidates -->
		
		<!-- template for resumes -->
		<script type="text/x-handlebars-template" id="resumes-row-template">
			<div>
			<div class="candidates_profile">
			<label for="candidates_name">
			<span style="font-weight:bold;cursor:pointer;color:#158cba;" onclick="window.open('/portal/recruiter/staff_information.php?userid={{candidate.userid}}&page_type=popup','Staff Information {{candidate.userid}}',
			'menubar=no,width=1000,height=500,toolbar=no,scrollbars=yes')">
			#{{candidate.userid}} - {{candidate.fname}} {{candidate.lname}} - </span> 
			<span>
			{{#if candidate.inactive}}
			<span style="color:red;font-weight: bolder">{{candidate.staff_status}}</span></br>
			{{else}}
			<span style="color:blue;font-weight: bolder">{{candidate.staff_status}}</span></br>
			{{/if}}
			</span>
			</label>
			</div>
			<div><label for ="assigned_recruiter">
				Recruiter Assigned: <span style="color:#2E2EFE;">{{candidate.admin_fname}} {{candidate.admin_lname}}</span>
			</label>
			</div>
			<div>
			<label for ="resume_download">
				Resume Download Link: <a href="https://remotestaff.com.au/portal/applicants_files/{{file.name}}">{{file.name}}</a>
			</label>
			</div>
			<!-- <label for="candidates_status">
			{{#if candidate.inactive}}
			Status: <span style="color:red;font-weight: bolder">{{staff_status}}</span></br>
			{{else}}
			Status: <span style="color:blue;font-weight: bolder">{{staff_status}}</span></br>
			{{/if}}
			</label> -->
			<div class="highlighted_result">
			<label for="highlighted_result">Highlighted Result: </label>
			<div class="panel panel-body">
			{{{highlighted_result}}}
			</div>
			</div>
			</div>
		</script>
		<!-- /template for resumes -->
		
		<!-- template for job orders -->
		<script type="text/x-handlesbars-template" id="job-orders-row-template">
			<div>
			<div class="job-orders_details">
			<label for="job-orders_info">
			#{{job_order.tracking_code}} -
			<a href="{{job_order.links.job_specification_link_export}}">{{job_order.job_title}}</a> -
			<a href ="/portal/leads_information.php?id={{job_order.leads_id}}" target="_blank">{{job_order.client}}</a>

			</label>
			</div>
			<div class="highlighted_result">
			<label for="highlighted_result">Highlighted Result: </label>
			<div class="panel panel-body">
			{{{highlighted_result}}}
			</div>
			</div>
			</div>
		</script>
		<!-- /template for job orders -->
		
		
		<!-- template for leads -->
		<script type="text/x-handlesbars-template" id="leads-row-template">
			<div>
			<div class="leads_details">
			<label for="leads_info">
			<a href ="/portal/leads_information.php?id={{lead.id}}" target="_blank">#{{lead.id}} - {{lead.fname}} {{lead.lname}}</a>
			</label>
			</div>
			<div class="highlighted_result">
			<label for="highlighted_result">Highlighted Result: </label>
			<div class="panel panel-body">
			{{{highlighted_result}}}
			</div>
			</div>
			</div>
		</script>
	
		<!-- /template for leads -->
		{/literal}
		<script type="text/javascript" src="/portal/assets/js/jquery.twbsPagination.js"></script>
		<script type="text/javascript" src="/portal/recruiter_search/js/recruiter_search.js"></script>
		<script type="text/javascript" src="/portal/assets/js/isloading.js"></script>
		
	</body>

</html>

