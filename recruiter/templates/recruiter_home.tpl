<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Recruiter Home - Remote Staff</title>
		<script type="text/javascript" src="js/recruiter_home.js"></script>
	</head>

	<body>
		
		{include file="new_header.tpl"}
		<div id="container">
			<!-- Recruiter Home -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Recruiter Home Page</h3>
			
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Advanced Search</h3>
			  </div>
			  <div class="panel-body">
			   	<form method="GET" class="form-inline"  role="form" id="recruiter-home-filter">
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
		      <li class="active"><a href="#candidate_status" data-toggle="tab">Candidate Status</a></li>
		      <li><a href="#interview_requests" data-toggle="tab">Interview Requests</a></li>
		      <li><a href="/portal/recruiter/recruitment_contract_dashboard.php" class="link" data-toggle="tab">Hired Staffs</a></li>
		      <li><a href="/portal/recruiter/recruitment_contract_dashboard.php" class="link" data-toggle="tab">Drop Outs</a></li>
		    </ul>
		    
		    <div id="myTabContent" class="tab-content">
		    	<div id="candidate_status" class="tab-pane active">
		    		<table id="candidate_status_table" class="table table-condensed table-striped">
		    			<thead>
		    				<tr>
		    					<th width="5%">#</th>
		    					<th width="20%">Recruiter</th>
		    					<th>TNC</th>
		    					<th>Unprocessed</th>
		    					<th>Pre-screened</th>
		    					<th>Inactive</th>
		    					<th>Shortlisted</th>
		    					<th>Endorsed</th>
		    					<th>Categorized</th>
		    					<th>Candidate Status Total</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				{foreach from=$recruiters item=recruiter name=recruiter_candidate_status}
		    					<tr>
		    						<td>{$smarty.foreach.recruiter_candidate_status.iteration}</td>
		    						<td><strong>{$recruiter.admin_fname} {$recruiter.admin_lname}</strong></td>
		    						<td class="tnc_{$recruiter.admin_id}">0</td>
		    						<td class="unprocessed_{$recruiter.admin_id}">0</td>
		    						<td class="prescreened_{$recruiter.admin_id}">0</td>
		    						<td class="inactive_{$recruiter.admin_id}">0</td>
		    						<td class="shortlisted_{$recruiter.admin_id}">0</td>
		    						<td class="endorsed_{$recruiter.admin_id}">0</td>
		    						<td class="categorized_{$recruiter.admin_id}">0</td>
		    						<td class="candidate_status_total_{$recruiter.admin_id}">0</td>
		    					</tr>
		    				{/foreach}
		    			</tbody>
		    			<tfoot>
		    				<tr>
		    					<td><strong>Total</strong></td>
		    					<td>&nbsp;</td>
		    					<td class="total_tnc">0</td>
		    					<td class="total_unprocessed">0</td>
		    					<td class="total_prescreened">0</td>
		    					<td class="total_inactive">0</td>
		    					<td class="total_shortlisted">0</td>
		    					<td class="total_endorsed">0</td>
		    					<td class="total_categorized">0</td>
		    					<td class="total_candidate_status">0</td>
		    					
		    				</tr>
		    			</tfoot>
		    		</table>
		    	</div>
		    	<div id="interview_requests" class="tab-pane">
		    		<table id="interview_requests_table" class="table table-condensed table-striped">
		    			<thead>
		    				<tr>
		    					<th width="5%">#</th>
		    					<th width="20%">Recruiter</th>
		    					<th>TNC</th>
		    					
		    					<th>ASL</th>
		    					<th>CUSTOM</th>
		    					<th>Interview Total</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				{foreach from=$recruiters item=recruiter name=recruiter_candidate_status}
		    					<tr>
		    						<td>{$smarty.foreach.recruiter_candidate_status.iteration}</td>
		    						<td><strong>{$recruiter.admin_fname} {$recruiter.admin_lname}</strong></td>
		    						<td class="tnc_{$recruiter.admin_id}">0</td>
		    						<td class="interview_asl_{$recruiter.admin_id}">0</td>
		    						<td class="interview_custom_{$recruiter.admin_id}">0</td>
		    						<td class="interview_total_{$recruiter.admin_id}">0</td>
		    					</tr>
		    				{/foreach}
		    			</tbody>
		    			<tfoot>
		    				<tr>
		    					<td><strong>Total</strong></td>
		    					<td>&nbsp;</td>
		    					<td class="total_tnc">0</td>
		    					<td class="interview_asl_total">0</td>
	    						<td class="interview_custom_total">0</td>
	    						<td class="interview_total">0</td>
		    				</tr>
		    			</tfoot>
		    		</table>
		    		
		    	</div>
		    	<div id="hired_staffs" class="tab-pane"></div>
		    	<div id="drop_outs" class="tab-pane"></div>
		    	
		    </div>
		    
		    
			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}
		
		</div>
		
		
	</body>
</html>