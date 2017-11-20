<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Recruiter Home - Remote Staff</title>
		<link rel="stylesheet" href="/portal/recruiter/css/recruitment_dashboard_enhanced.css"/>
		<script type="text/javascript" src="/portal/recruiter/js/recruitment_dashboard_enhanced.js"></script>
	</head>

	<body>
		
		{include file="new_header.tpl"}
		<div id="container">
			<!-- Recruiter Home -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Recruitment Sheet Dashboard</h3>
			
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Advanced Search</h3>
			  </div>
			  <div class="panel-body">
			   <form id="filter-form" class="form-inline">
						<label class="radio"><input type="radio" name="selected" value="Today" checked class="selector"/>  Today:          <button class="btn" id="today_button" style="margin-left:70px">{$dateTo}</button></label><br/>
						<label>or</label><br/>
						<label class="radio">
							<input type="radio" name="selected" value="Order Date"  class="selector"/>  Order Date From:   <input type="text" class="span2" id="date-from" name="date-from" placeholder="Date From" value="{$dateFrom}" style="margin-left:10px" disabled/> Order Date To: <input style="margin-left:1em" type="text" class="span2" id="date-to" name="date-to" placeholder="Date To" value="{$dateTo}" disabled/>&nbsp;&nbsp;Order Status:&nbsp;&nbsp;
							<select id="order-status" name="order-status" disabled>
								<option value="-1">All</option>
								<option value="0" selected>Open</option>
								<option value="1">Closed</option>
								<option value="2">Did not push through</option>
								<option value="3">On Hold</option>
								<option value="4">On Trial</option>
							</select>	
						</label><br/>
						<label>or</label><br/>
						<label class="radio">
							<input type="radio" name="selected" value="Closing Date"  class="selector"/>Closing Date From: <input style="margin-left:5px;" type="text" class="span2" id="close-date-from" name="close-date-from" placeholder="Date From" value="{$dateFrom}" disabled/> Closing Date To: <input type="text" class="span2" id="close-date-to" name="close-date-to" placeholder="Date To" value="{$dateTo}" style="margin-left:5px" disabled/>
						<div class="form-group">
							Include Inhouse Staff:&nbsp;&nbsp;&nbsp;
			   			</div>
						<select id="inhouse-staff" name="inhouse-staff">
								<option value="yes" selected>Yes</option>
								<option value="no">No</option>
							</select>	
						</label><br/><br/>
						<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i>Search</button>&nbsp;&nbsp;<button type="submit" class="btn" id="export_button"><i class="icon-share"></i>Export</button>
						<br/>
						
				</form>
			   	<p class="note">
			   		<small>
						<strong style="color:#ff0000">Note:&nbsp;</strong>The report below is for the order open for today. Use the date filter to search between order dates or closing dates.
					</small>
			   		
			   	</p>
			  </div>
			</div>
			
			
			<ul id="myTab" class="nav nav-tabs">
		      <li class="active"><a href="#staffing_consultant_tab" data-toggle="tab" data-tab="staffing_consultant_tab" class="tab-link">Staffing Consultant</a></li>
		      <li><a href="#recruiters_tab" data-toggle="tab" data-tab="recruiters_tab" class="tab-link">Recruiters</a></li>
		    </ul>
		    
		    <div id="mytab" class="tab-content">
		    	<div id="staffing_consultant_tab" class="tab-pane active">
		    		{include file="recruitment_sheet_dashboard_table.tpl"}
		    	</div>
		    	<div id="recruiters_tab" class="tab-pane">
		    		{include file="recruitment_sheet_dashboard_enhanced_table.tpl"}
		    		
		    	</div>
		    	
		    </div>
			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}
		</div>
		
		
	</body>
</html>