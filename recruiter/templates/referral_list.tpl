<!DOCTYPE html>
<html ng-app id="ng-app">
	<head>
		{include file="new_include.tpl"}
		<title>Referral List - Remote Staff</title>
		<link rel="stylesheet" href="/portal/recruiter/css/referral_list.css"/>
		<script type="text/javascript" src="/portal/recruiter/js/referral_list.js"></script>
	</head>

	<body>
		
		{include file="new_header.tpl"}
		<div id="container" ng-controller="ReferralCtrl">
			<!-- Mini sub header -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Referral List</h3>
			<!-- /Mini sub header -->
			
			<!-- Search Form -->
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Search Filters</h3>
			  </div>
			  <div class="panel-body">
			   	<form method="GET" class="form-inline"  role="form" id="referral-filter">
			   		<input type="hidden" name="filter_type" value="1"/>
			   		<div class="form-group col-lg-8 col-md-8">
			   			<div class="row">
			   				<div class="col-lg-2 col-md-2">
				   				<label>Date Referred</label>
				   			</div>
				   			<div class="col-lg-10 col-md-10">
				   				<input type="text" name="date_from" id="date_from" placeholder="Date Referred From">
			   					<input type="text" name="date_to" id="date_to" placeholder="Date Referred To">
				   			</div>
				   		</div>
			   			
			   		</div><br/><br/>
			   		<div class="form-group col-lg-8 col-md-8">
			   			<div class="row">
			   				<div class="col-lg-2 col-md-2">
				   				<label>Search</label>
				   			</div>
				   			<div class="col-lg-10 col-md-10">
					   			<input style="width:600px;" type="text" name="search" id="text-search" width="600" placeholder="Enter First Name, Last Name, Phone Number, Position, Email or Referee">
				   			</div>
				   		</div>
			   		</div>
			   		<br/><br/>
			   		<div class="form-group col-lg-8 col-md-8">
			   			<div class="row">
			   				<div class="col-lg-2 col-md-2">
				   				<label>Type</label>
				   			</div>
				   			<div class="col-lg-10 col-md-10">
						   		<select id="refer_type" name="type">
										<option value="">All</option>
										<option value="referred" selected="">Referred</option>
										<option value="promo_code">Promo Code</option>
										
									</select>
					   		</div>
				   		</div>
			   		</div><br/><br/>
			   		<div class="form-group">
			   			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>
			   		</div>
			  </div>
			</div>
			<div>
				<div class="pull-right" style="width:210px;">
					<select class="pager-select pull-left" style="margin-right:10px"></select>
				    <ul class="pager">
		                <li class="previous"><a href="#">&larr; Prev</a></li>
		                <li class="next"><a href="#">Next &rarr;</a></li>
		            </ul>
			    </div>	
			    <div class="pull-left">
			    	Showing <span class="page-start">0</span> - <span class="page-end">0</span> out of <span class="page-total">0</span> referrals
			    </div>			    			
			</div>

		    
		    <div id="search_result">
		    	<table class="table table-condensed table-bordered">
		    		<thead>
		    			<tr>
		    				<th>Full Name</th>
		    				<th>Position</th>
		    				<th>Email Address</th>
		    				<th>Contact Number</th>
		    				<th>Referee</th>
		    				<th>Date Referred</th>
		    				<th>Referral Status</th>
		    				<th>Status</th>
		    				<th align="center">Contacted</th>
		    				<th align="center">Convert to Jobseeker</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			
		    		</tbody>
		    	</table>
		    </div>
		    
			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}
		
		</div>
		
		{literal}
		<script id="referral-row-template" type="text/x-handlebars-template">
			<tr>
				<td>
					{{{fullname}}}
				</td>
				<td>{{position}}</td>
				<td>{{email}}</td>
				<td>{{contactnumber}}</td>
				<td><a href="/portal/recruiter/staff_information.php?userid={{referee_id}}&page_type=popup" target="_blank">{{referee}}</a></td>
				
				<td>{{date_created}}</td>
				<td>{{referral_status}}</td>
				<td>{{status}}</td>
				<td align="center">
					{{#if contacted}}
						<input type="checkbox" class="contacted" data-id="{{id}}" checked="checked"/>
					{{else}}
						<input type="checkbox" class="contacted" data-id="{{id}}"/>
					{{/if}}
				</td>
				<td align="center">
					{{#if jobseeker_id}}
						<input type="checkbox" class="convert_job_seeker" data-id="{{id}}" checked="checked">
					{{else}}
					
						<input type="checkbox" class="convert_job_seeker" data-id="{{id}}">
					{{/if}}
				</td>
			</tr>
		</script>	
		<script id="page-row-template" type="text/x-handlebars-template">
			<option value="{{this}}">{{this}}</option>
		</script>
		
		{/literal}
		
	</body>
</html>