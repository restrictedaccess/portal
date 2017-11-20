<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="/portal/fb_register/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/portal/fb_register/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../sms/js/ui/minified/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/index.js"></script>

		<link rel="stylesheet" href="/portal/fb_register/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../sms/css/jquery-ui.min.css">

		<link rel="stylesheet" href="../sms/css/index.css"/>
		<title>Category Manager - Remote Staff</title>
	</head>

	<body>

		<nav id="main_bar" class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/portal/recruiter/RecruiterHome.php" style="padding-top:0;padding-bottom:0"><img src="/portal/jobseeker/images/remote-staff-logo.png" alt="Remote Staff Home"/></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="/portal/recruiter/RecruiterHome.php">Home</a>
					</li>
					{if $admin_status eq "FULL-CONTROL"}
					<li>
						<a href="/portal/adminHome.php">Admin</a>
					</li>
					{/if}
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Recruiter Search <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="/portal/recruiter/recruiter_search.php">View All</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=UNPROCESSED">Unprocessed</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=REMOTEREADY">Remote Ready</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=PRESCREENED">Prescreened</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=INACTIVE">Inactive</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=SHORTLISTED">Shortlisted</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_search.php?staff_status=ENDORSED">Endorsed</a>
							</li>
							<li>
								<a href="/portal/recruiter/recruiter_staff_manager.php?on_asl=0">Categorized</a>
							</li>

						</ul>
					</li>
					<li>
						<a href="/portal/recruiter/recruiter_test_reports.php">Test Takers</a>
					</li>
					<li>
						<a href="#">Trial</a>
					</li>
					<li>
						<a href="/portal/subconlist.php">List of Subcons</a>
					</li>

				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#"></a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$admin.admin_fname} {$admin.admin_lname} <b class="caret"></b></a>
						<ul class="dropdown-menu">

							<li>
								<a href="/portal/logout.php">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
		<div class="container-fluid">
			
			<div class="row-fluid">
				<div class="col-lg-12">
					<div class="panel panel-primary clearfix">
						<div class="panel-heading">
							<h3 class="panel-title">Search ASL Candidates</h3>
						</div>

						<div class="panel-body">
							<form role="form" class="form-inline" id="search_form">
								
								<input type="hidden" name="category_id" id="search_category_id"/>
								<input type="hidden" name="sub_category_id" id="search_sub_category_id"/>
								
								<div class="form-group">
									<label class="sr-only" for="search_display">Displayed?</label>
									<select name="ratings" id="search_display" class="form-control">
										<option value="">All Categorized</option>
										<option value="0">Displayed</option>
										<option value="1">Not Displayed</option>
									</select>
								</div>
								<div class="form-group">
									<label class="sr-only" for="search_keyword">Keyword</label>
									<input type="search" name="keyword" placeholder="Enter Keyword" class="form-control" style="width:300px;"/>
								</div>
								<div class="form-group">
									<label class="sr-only" for="search_keyword_type">Keyword Type</label>
									<select name="keyword_type" id="search_keyword_type" class="form-control">
										<option value="userid">UserID</option>
										<option value="name">Candidate Name</option>
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-primary" id="search_job_category">
										<i class="glyphicon glyphicon-search"></i> Search in this Job Category
									</button>
									<button class="btn btn-primary" id="search_all">
										<i class="glyphicon glyphicon-search"></i> Search All
									</button>
									
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
			<div class="row-fluid">
				<div class="col-lg-3">

					{foreach from=$categories item=category}
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><a href="#" class="category_loader" data-category_id="{$category.category_id}">{$category.category_name}</a></h3>
						</div>

						<div class="panel-body">
							<ul>
								{foreach from=$category.subcategories item=subcategory}
								<li>
									<a href="#" class="subcategory_loader" data-sub_category_id="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</a>
								</li>
								{/foreach}
							</ul>
						</div>
					</div>
					{/foreach}
				</div>

				<div class="col-lg-9">
					<div class="panel panel-primary clearfix">
						<div class="panel-heading">
							<h3 class="panel-title" id="category_manager_header">Loading...</h3>
						</div>

						<div class="panel-body">
							<div class="edit_information row-fluid">

								<div class="row-fluid">
									<div class="pull-right">
										<button class="btn btn-default" id="edit_description">
											<i class="glyphicon glyphicon-pencil"></i>
										</button>
									</div>
								</div>

								<div class="panel panel-default">
									<div class="panel-heading">
										Description
									</div>
									<div class="panel-body" id="panel_description">

									</div>
								</div>

							</div>
						</div>

						<div class="row-fluid">
							
							<div class="col-lg-6">
								Showing <strong class="start_count"></strong> - <strong class="end_count"></strong> out of <strong class="total_count"></strong> categorized candidates.
							</div>
							
							<div class="col-lg-6">
								<div class="pull-right" style="margin-top:-10px">
									<ul class="pager">
									  <li><a href="#" class="prev disabled">&larr; Previous</a></li>
									  <li><a href="#" class="next">Next &rarr;</a></li>
									</ul>
								</div>							
							</div>
	
						</div>
						<table class="table" id="candidate_table">
							<thead>
								<tr>
									<th class="col-lg-1">#</th>
									<th class="col-lg-4">Candidate</th>
									<th class="col-lg-2">Category</th>
									<th class="col-lg-2">Sub Category</th>
									<th class="col-lg-1">Displayed?</th>
									<th class="col-lg-2">Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						
						<div class="row-fluid">
							
							<div class="col-lg-6">
								Showing <strong class="start_count"></strong> - <strong class="end_count"></strong> out of <strong class="total_count"></strong> categorized candidates.
							</div>
							
							<div class="col-lg-6">
								<div class="pull-right" style="margin-top:-10px">
									<ul class="pager">
									  <li><a href="#" class="prev disabled">&larr; Previous</a></li>
									  <li><a href="#" class="next">Next &rarr;</a></li>
									</ul>
								</div>							
							</div>
	
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="modal fade" id="transfer_category_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Transfer Category</h4>
					</div>
					<div class="modal-body">
						<form id="transfer_category_form" method="post" class="form-inline" role="form">
							<input type="hidden" name="id" id="transfer_id"/>
							<div class="form-group">
								<label for="transfer_category_id">Select Category</label>
								<select name="sub_category_id" id="transfer_category_id" class="form-control">

									{foreach from=$categories item=category}
									<optgroup label="{$category.category_name}">
										{foreach from=$category.subcategories item=subcategory}
										<option value="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</option>
										{/foreach}
									</optgroup>
									{/foreach}
								</select>
							</div>

						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary" id="transfer_category_button">
							Save changes
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</body>
</html>