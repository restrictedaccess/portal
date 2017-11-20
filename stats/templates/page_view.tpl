<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Recruiter Home - Remote Staff</title>
		<link rel="stylesheet" href="js/visualize.jQuery.css"/>
		<script type="text/javascript" src="js/visualize.jQuery.js"></script>
		<script type="text/javascript" src="js/page_view.js"></script>
		
	</head>

	<body>
		
		{include file="new_header.tpl"}
		<div id="container">
			<!-- Recruiter Home -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Client Portal - Page Views and Activities</h3>
			
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Search</h3>
			  </div>
			  <div class="panel-body">
			   	<form method="GET" class="form-inline"  role="form" id="page-view-filter">
			   		<div class="form-group">
			   			<label>Client Name</label>
			   		</div>
			   		<div class="form-group">
					   <input type="text" value="" class="form-control" name="client_name" id="client_name" placeholder="Enter Client Name"/>
					</div>
			   		<div class="form-group">
			   			<label>Date Between</label>
			   		</div>
			   		<div class="form-group">
					   <input type="text" value="{$date_from}" class="form-control" name="date_from" id="date_from" placeholder="Select Date From"/>
					</div>
					<div class="form-group">
					 <input type="text" value="{$date_to}" class="form-control" name="date_to" id="date_to" placeholder="Select Date To"/>
					</div>   
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>
			   		</div>
			   	</form>
			   	<p class="note">
			   		<small>
					   	<span style="color:#FF0000">NOTE: </span>The report below is for the dates above. It is defaulted to show you reports between the first day of the current month and today. Update the dates above to view reports for other dates.		   			
			   		</small>
			   		
			   	</p>
			  </div>
			</div>
			
			
			<ul id="myTab" class="nav nav-tabs">
		      <li><a href="#page-view-activities" data-toggle="tab">Page View Activities</a></li>
		    </ul>
		    
		    <div id="myTabContent" class="tab-content">
		    	<div id="page-view-activities" class="tab-pane active">
		    		<table id="page-view-activities-table" class="table table-bordered table-condensed">
		    			<thead>
		    				<tr>
		    					<th width="15%">Client Name</th>
		    					<th width="15%">Page</th>
		    					<th width="15%">Total Stay on the Page</th>
		    					<th width="15%">Frequency</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				
		    			</tbody>
		    		</table>
		    	</div>
		    	
		    </div>
		    
		    
			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}
		
		</div>
		{literal}
		<script id="activity-template" type="text/x-handlebars-template">
			{{#each page_views.result}}
			<tr>
				<td><a href="/portal/leads_information.php?id={{../id}}" target="_blank">{{../fname}} {{../lname}}</a></td>
				<td>{{_id}}</td>
				<td>{{formatted_total_stay}}</td>
				<td>{{total_visit_times}}</td>
				
			</tr>
			{{/each}}
		</script>
		
		<script id="chart-template" type="text/x-handlebars-template">
			<table class="charts">
				<caption>Activity Chart of {{fname}} {{lname}}</caption>
				<thead>
					<tr>
						<th></th>
						<th>Activity</th>							
					</tr>
				</thead>
				<tbody>
					{{#each page_views.result}}
					<tr>
						
							<th>{{_id}}</th>
							<td>{{total_stay_time}}</td>
							
					</tr>
					{{/each}}	
				</tbody>				
			</table>
		</script>
		{/literal}
	</body>
</html>