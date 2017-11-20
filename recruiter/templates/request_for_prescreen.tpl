<!DOCTYPE html>
<html>
<head>
	<title>Remote Ready - Request for Prescreens</title>
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
	
	<script type="text/javascript" src="/portal/recruiter/js/request_for_prescreen.js"></script>
	
</head>
<body>
	{php} include("header.php") {/php}
	{php} include("recruiter_top_menu.php") {/php}
	<br/><h1 class="header" style="text-align:left">Remote Ready - Request for Prescreens</h1>
        
	<div id="filter-form-container">
		<form id="filter-form" class="well form-inline">
				
				<label style="margin-left:20px">Recruiter </label>
				<select name="recruiter">
					<option value="">All Recruiters</option>
					{foreach from=$recruiters item=recruiter}
						{if $selected_recruiter eq $recruiter.admin_id}
							<option value="{$recruiter.admin_id}" selected>{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
						{else}
							<option value="{$recruiter.admin_id}">{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
						{/if}
					{/foreach}
				</select>
				
				<label style="margin-left:80px;">Date Registered</label>
				<input type="text" name="date_registered_from" placeholder="Date Registered From" id="date_registered_from" value="{$date_registered_from}"/>
				<input type="text" name="date_registered_to" placeholder="Date Registered To" id="date_registered_to" value="{$date_registered_to}"/>
				
				<br/><br/>
				<label>Job Position</label>
				
				<select name="job_position">
					<option value="">All Subcategory</option>
					{foreach from=$categoriesDrop item=category}
						<optgroup label="{$category.category_name}">
							{foreach from=$category.subcategories item=subcategory}
								{if $subcategory.sub_category_id eq $job_position}
									<option value="{$subcategory.sub_category_id}" selected>{$subcategory.sub_category_name}</option>							
								{else}
									<option value="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</option>								
								{/if}

							{/foreach}
							
						</optgroup>
					{/foreach}
				</select>
				
				<label style="margin-left:124px">Keyword</label>
				<input name="keyword" type="text" value="{$keyword}"/>
				<select name="keyword_type" id="keyword_type" class="span2">
					{foreach from=$keyword_types item=type}
						{if $type.key eq $selected_keyword_type }
							<option value="{$type.key}" selected>{$type.val}</option>
						{else}
							<option value="{$type.key}">{$type.val}</option>
						{/if}
					{/foreach}
				</select>
				<br/><br/>
				
				<label style="margin-left:10px;">Availability
					</label>
				<select name="availability_status" id="availability" class="span2">
					{foreach from=$availability_status item=status}
						{if $status eq $selected_availability_status }
							<option value="{$status}" selected>{$status}</option>
						{else}
							<option value="{$status}">{$status}</option>												
						{/if}
					{/foreach}
				</select>				
				<label style="margin-left:142px">Date Updated</label>
				<input type="text" name="date_updated_from" placeholder="Date Updated From" id="date_updated_from" value="{$date_updated_from}"/>
				<input type="text" name="date_updated_to" placeholder="Date Updated To"  id="date_updated_to" value="{$date_updated_to}"/>
				
				
				<br/><br/>
				<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i>Search</button>
		</form>
	</div>
	
	<div class="container-fluid">
		
		{foreach from=$categories item=category}
			<h2 style="font-size:14px;color:white">{$category.category_name}</h2>
			{foreach from=$category.subcategories item=subcategory}
				{if $subcategory.orders}
					<div style="background:#2C66A5;padding:5px 0px;margin-top:1em;padding-left:5px;color:#fff;border:1px solid black">{$subcategory.sub_category_name}</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="20%">Applicant</th>
								<th width="20%">Skills</th>
								<th width="10%">Advertised Rates</th>
								
								<th width="15%">Lead Name</th>
								<th width="5%">Date Requested</th>
								<th width="10%">Assign Recruiter</th>
								<th width="10%">Availability Status</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$subcategory.orders item=order}
								<tr>
									<td>
										<a href="/portal/recruiter/staff_information.php?userid={$order.personal.userid}" class="launcher">{$order.personal.userid} - {$order.personal.fname} {$order.personal.lname}</a><br/> 
										{if $order.latest_job_title}
											{$order.latest_job_title}<br/>
										{/if}
										{if $order.personal.recruiter}
											<span style="color:#ff0000">{$order.personal.recruiter.admin_fname} {$order.personal.recruiter.admin_lname}</span><br/>
										{/if}
										{$order.personal.email}
										
									</td>
									<td>
										{$order.personal.skills}
									</td>
									<td>
										{$order.expected_salary} {$order.salary_currency}/month
									</td>
									<td>
										{if $order.lead.id }
										<a href="/portal/leads_information.php?id={$order.lead.id}" class="launcher">{$order.lead.id} - {$order.lead.fname} {$order.lead.lname}</a><br/> 
										{/if}
										{if $order.jobspec}
											<a href="/rs/remoteready/job_spec_form/?sub_category_id={$order.jobspec.job_sub_category_id}&order_id={$order.jobspec.remote_ready_order_id}&userid={$order.personal.userid}&mode=view" class="launcher"><img src="/portal/images/flag_red.gif"/></a>
										{/if}
									</td>
									<td>{$order.order.date_created}</td>
									<td>
										<select class="update_recruiter" data-userid="{$order.personal.userid}" data-fname="{$order.personal.fname}">
											<option value="">No Recruiter Assigned</option>
											{foreach from=$recruiters item=recruiter}
												{if $order.personal.recruiter.admin_id eq $recruiter.admin_id }
													<option value="{$recruiter.admin_id}" selected>{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
												{else}
													<option value="{$recruiter.admin_id}">{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
												{/if}
											{/foreach}										
										</select>
	
									</td>
									<td>
										<select class="update_availability_status" data-order_id="{$order.id}">
											{foreach from=$availability_status item=status}
												{if $status eq $order.availability_status }
													<option value="{$status}" selected>{$status}</option>
												{else}
													<option value="{$status}">{$status}</option>												
												{/if}
											{/foreach}
										</select>
									</td>
								</tr>
							{/foreach}
						</tbody>
						
					</table>
				{/if}
			{/foreach}
		{/foreach}
	</div>
	
</body>
</html>