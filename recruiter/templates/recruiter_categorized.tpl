<!DOCTYPE html>
<html ng-app id="ng-app">
	<head>
		{include file="new_include.tpl"}
		<title>Categorized - Recruiter Search - Remote Staff</title>
		<script type="text/javascript" src="/portal/recruiter/js/recruitment_categorized.js"></script>
	</head>

	<body>
		
		{include file="new_header.tpl"}
		<div id="container" ng-controller="CategorizedCtrl">
			<!-- Mini sub header -->
			<div class="pull-right" style="margin-top:25px">
				<a href="/portal/recruiter/guides_for_pay_rates.php" style="color:#FF0000">Guide for Pay Rates</a>
			</div>
			<h3>Categorized</h3>
			<!-- /Mini sub header -->
			
			<!-- Search Form -->
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Search Filters</h3>
			  </div>
			  <div class="panel-body">
			   	<form method="GET" class="form-inline"  role="form" id="recruiter-categorized-filter">
			   		<div class="row">
				   		<div class="form-group col-lg-4 col-md-4">
				   			<div class="row">
				   				<div class="col-lg-3 col-md-3">
						   			<label>Recruiters</label>		   					
				   				</div>
				   				<div class="col-lg-8 col-md-8">
				   					<select name="recruiter">
				   						<option value="">All</option>
						   				{foreach from=$recruiters item=recruiter}
						   					<option value="{$recruiter.admin_id}">{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
						   				{/foreach}
						   			</select>
				   				</div>
				   			</div>
				   			
				   		</div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
				   				<div class="col-lg-2 col-md-2">
					   				<label>Date Added on ASL</label>
					   			</div>
					   			<div class="col-lg-10 col-md-10">
					   				<input type="text" name="date_added_from" id="date_added_from" placeholder="Date Added From" value="{$start}"/>
				   					<input type="text" name="date_added_to" id="date_added_to" placeholder="Date Added To" value="{$today}"/>
					   			</div>
					   		</div>
				   			
				   		</div>			   			
			   		</div>
					<div class="spacer"></div>
					<div class="row">
				   		<div class="form-group col-lg-4 col-md-4">
				   			<div class="row">
					   			<div class="col-lg-3 col-md-3">
					   				<label>Job Position</label>
					   			</div>
					   			<div class="col-lg-8 col-md-8">
						   			<select name="sub_category_id">
						   				<option value="">Please select Job Position</option>
						   				{foreach from=$categories item=category} 
						   					<optgroup label="{$category.category.name}">
						   						{foreach from=$category.subcategories item=subcategory}
						   							<option value="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</option>
						   						{/foreach}
						   					</optgroup>
						   				{/foreach}
						   			</select>
					   			</div>
				   			</div>
				   		</div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
				   				<div class="col-lg-2 col-md-2">
				   					<label>Date Updated</label>
				   				</div>
				   				<div class="col-lg-10 col-md-10">
						   			<input type="text" name="date_updated_from" id="date_updated_from" placeholder="Date Updated From"/>
						   			<input type="text" name="date_updated_to" id="date_updated_to" placeholder="Date Updated To"/>
						   		</div>
						   	</div>
				   		</div>
			   		</div>
			   		<div class="spacer"></div>
			   		<div class="row">
			   			<div class="form-group col-lg-4 col-md-4">
				   			<div class="row">
					   			<div class="col-lg-3 col-md-3">
						   			<label>On ASL</label>
						   		</div>
						   		<div class="col-lg-8 col-md-8">						   			
						   			<select name="on_asl">
						   				<option value="">All</option>
						   				<option value="0" selected="">Yes</option>
						   				<option value="1">No</option>
						   				<option value="2">Under Consideration</option></select>
						   			</select>
				   				</div>
				   			</div>
				   		</div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
					   			<div class="col-lg-2 col-md-2">
					   				<label>Date Registered</label>
					   			</div>
					   			<div class="col-lg-10 col-md-10">
						   			<input type="text" name="date_registered_from" id="date_registered_from" placeholder="Date Registered From"/>
						   			<input type="text" name="date_registered_to" id="date_registered_to" placeholder="Date Registered To"/>
					   			</div>				   				
				   			</div>

				   		</div>
			   		</div>
			   		<div class="spacer"></div>
			   		
			   		<div class="row">
			   			<div class="form-group col-lg-4 col-md-4">
			   				<div class="row">
					   			<div class="col-lg-3 col-md-3">
				   					<label>Advertised Rates</label>
				   				</div>
				   				
				   				<div class="col-lg-8 col-md-8">
						   			<select name="advertised_rates">
						   				<option value="hourly" selected="">Hourly</option>
						   				<option value="monthly">Monthly</option>
						   			</select>
						   		</div>
						   	</div>
				   		</div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
					   			<div class="col-lg-2 col-md-2">
				   					<label>Key / Keyword Type</label>
				   				</div>
					   			<div class="col-lg-10 col-md-10">
						   			<input type="text" name="keyword" id="keyword" placeholder="Enter Keyword"/>
						   			<select name="keyword_type" id="keyword_type">
										<option value="id">ID</option>
										<option value="first_name">First Name</option>
										<option value="last_name">Last Name</option>
										<option value="email">Email</option>
										<option value="evaluation_notes">Evaluation Notes</option>
										<option value="skills">Skills</option>
										<option value="notes">Notes</option>
									</select>				   		
											
					   			</div>
				   			</div>
				   		</div>
				   		
			   		</div>
			   		
			   		<div class="spacer"></div>
			   		<div class="row">
			   			<div class="form-group col-lg-4 col-md-4">
			   				<div class="row">
					   			<div class="col-lg-3 col-md-3">
				   					<label>Work Status</label>
				   				</div>
				   				<div class="col-lg-8 col-md-8">
						   			<select name="work_availability" id="work_availability">
						   				<option value="">Select Work Status</option>
						   				<option value="Full-Time/Part-Time">Full-Time / Part-Time</option>
						   				
						   				<option value="Full-Time">Full-Time</option>
						   				<option value="Part-Time">Part-Time</option>
						   			</select>
						   		</div>
						   	</div>
					   </div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
					   			<div class="col-lg-2 col-md-2">
						   			<label>Inactive</label>				   				
					   			</div>
					   			<div class="col-lg-10 col-md-10">
						   			<select name="inactive">
						   				<option value="">Select Inactive Type</option>
						   				<option value="BLACKLISTED">BLACKLISTED</option>
						   				<option value="NO POTENTIAL">NO POTENTIAL</option>
						   				<option value="NOT INTERESTED">NOT INTERESTED</option>
						   				<option value="NOT READY">NOT READY</option>
						   			</select>				   		
					   			</div>		
				   			</div>

				   		</div>
			   		</div>

			   		
			   		<div class="spacer"></div>
			   		
			   		<div class="row">
			   			<div class="form-group col-lg-4 col-md-4">
			   				<div class="row">
					   			<div class="col-lg-3 col-md-3">
				   					<label>Timezone Availability</label>
				   				</div>
				   				<div class="col-lg-9 col-md-9">
				   					<select name="time_availability">
							   			<option value="Any">Any</option>
							   			<option value="AU">AU</option>
							   			<option value="UK">UK</option>
							   			<option value="US">US</option>
						   			</select>
				   				</div>
				   			</div>
				   			
				   		</div>
				   		
				   		<div class="form-group col-lg-8 col-md-8">
				   			
				   			<div class="row">
					   			<div class="col-lg-2 col-md-2">
				   					<label>City / Region</label>
				   				</div>
				   				<div class="col-lg-10 col-md-10">
						   			<input type="text" name="city" id="city" placeholder="Enter City"/>
						   			<select name="region">
						   				<option value="">Select Region</option>
						   				<option value="AR">Armm</option>
						   				<option value="BR">Bicol Region</option>
						   				<option value="CA">C.A.R.</option>
						   				<option value="CG">Cagayan Valley</option>
						   				<option value="CL">Central Luzon</option>
						   				<option value="CM">Central Mindanao</option>
						   				<option value="CR">Caraga</option>
						   				<option value="CV">Central Visayas</option>
						   				<option value="EV">Eastern Visayas</option>
						   				<option value="IL">Ilocos Region</option>
						   				<option value="NC">National Capital Reg</option>
						   				<option value="NM">Northern Mindanao</option>
						   				<option value="SM">Southern Mindanao</option>
						   				<option value="ST">Southern Tagalog</option>
						   				<option value="WM">Western Mindanao</option>
						   				<option value="WV">Western Visayas</option>
						   			</select>				   					
				   				</div>
							</div>
				   		</div>
			   		</div>
			   		<div class="spacer"></div>
			   		<div class="row">
			   			<div class="form-group col-lg-4 col-md-4">
				   			<label>Availability</label>
				   			<div class="row">
				   				<div class="col-lg-12 col-md-12">
					   				<label class="radio">
										<input type="radio" name="available_status" value="a" id="available_status_a">
										Can work 
					   				</label>
					   				<select name="available_notice"><option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option></select>
					   				week(s) of notice period
					   				<div class="small-spacer"></div>
					   				<br/>
					   				<label class="radio">
					   					<input type="radio" name="available_status" value="b" id="available_status_b">
					   					Can work after 
					   				</label>
					   				<input type="text" placeholder="Select Date" id="available_date" name="available_date"/>
					   				<br/>
					   				<label class="radio">
					   					<input type="radio" name="available_status" value="p">
					   					Currently Inactive in Looking for Work
					   				</label>
					   				<br/>
					   				<label class="radio">
					   					<input type="radio" name="available_status" value="Work Immediately">
					   					Work Immediately
					   				</label>
				   				</div>
				   			</div>

							
				   		</div>
				   		<div class="form-group col-lg-8 col-md-8">
				   			<div class="row">
					   			<div class="col-lg-2 col-md-2">
						   			<label>Gender / Marital Status</label>			   				
					   			</div>				   				
					   			<div class="col-lg-5 col-md-5">
							   		<select name="gender">
						   				<option value="">Select Gender</option>
						   				<option value="Male">Male</option>
						   				<option value="Female">Female</option>
						   			</select>
					   				<select name="marital_status">
					   					<option value="">Select Marital Status</option>
					   					<option value="Single">Single</option>
					   					<option value="Married">Married</option>
					   					<option value="DeFacto">DeFacto</option>
					   					<option value="Its Complicated">Its Complicated</option>
					   					<option value="Engaged">Engaged</option>
					   				</select>
						   		</div>
						   		<div class="form-group col-lg-2 col-md-2">
									<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Search</button>
						   		</div>
						   		<div class="form-group col-lg-3 col-md-3">
									<label class="checkbox">
										<input type="checkbox" name="mass_email"/>Apply Result to Mass Emailing list
									</label>
								</div>
				   			</div>
				   		</div>
				   		
			   		</div>
			   		<div class="spacer"></div>
			   		<div class="row">
			   			<div class="col-lg-12 col-md-12">
				   			<div class="pull-right">
				   				<strong id="categorized-count"></strong>
				   			</div>			   				
			   			</div>

			   		</div>
			   	</form>
			   	
			  </div>
			</div>
		    
		    
		    <div id="search_result">
		    	
		    </div>
		    
			{include file="new_footer.tpl"}
			{include file="popup_dialog_rschat.tpl"}
		
		</div>
		
		{literal}
		<script id="category-template" type="text/x-handlebars-template">
			<h3>{{category.name}}</h3>
			{{#each subcategories}}
				<div class="panel panel-info">
				  <div class="panel-heading">
				    <h3 class="panel-title">{{sub_category_name}}</h3>
				  </div>
				  <div class="panel-body">
				  	<table class="table table-bordered table-condensed table-striped">
				  		<thead>
				  			<tr>
				  				<th width="20%">Applicant</th>
				  				<th width="20%">Skills</th>
				  				<th width="10%">Work Availability</th>
				  				<th width="10%">Time Zone Availability</th>
				  				<th width="10%">Advertized Rate</th>
				  				<th width="5%">On ASL</th>
				  				<th width="5%">Shortlisted</th>
				  				<th width="5%">Endorsed</th>
				  				<th width="15%">RS Employment History</th>
				  				
				  			</tr>
				  		</thead>
				  		<tbody>
				  			{{#each applicants}}
				  			<tr>
				  				<td valign="top"><strong><a href="/portal/recruiter/staff_information.php?userid={{personal.userid}}" class="popup">#{{personal.userid}} {{personal.fname}} {{personal.lname}}</a></strong><br/><strong style="color:#ff0000">{{assigned_recruiter.admin_fname}} {{assigned_recruiter.admin_lname}}</strong><br/>{{personal.email}}<br/>{{currentjob.latest_job_title}}</td>
				  				<td valign="top">{{#list_skill skills}}{{skill}}{{/list_skill}}</td>
				  				<td valign="top">{{work_availability}}</td>
				  				<td valign="top">
				  					{{#if full_time_zones}}
				  						<strong>FT : </strong>{{#list_skill full_time_zones}}{{this}}{{/list_skill}}<br/>
				  					{{/if}}
				  					{{#if part_time_zones}}
				  						<strong>PT : </strong>{{#list_skill part_time_zones}}{{this}}{{/list_skill}}<br/>
				  					{{/if}}	
				  				</td valign="top">
				  				<td valign="top">
				  					
				  					{{#if full_time_rates}}
				  						<strong>FT Rates</strong><br/>
				  						{{#list_rates full_time_rates}}{{this}}{{/list_rates}}			  						
					  					<br/>
				  					{{/if}}
				  					{{#if part_time_rates}}
				  						<strong>PT Rates</strong><br/>
				  						{{#list_rates part_time_rates}}{{this}}{{/list_rates}}
				  					{{/if}}
				  				</td>
				  				<td valign="top">{{on_asl}}</td>
				  				<td valign="top"><a href="/portal/recruiter/status_list.php?userid={{personal.userid}}&status=shortlisted" class="popup">{{shortlist_count}}</a></td>
				  				<td valign="top"><a href="/portal/recruiter/status_list.php?userid={{personal.userid}}&status=endorsed" class="popup">{{endorsement_count}}</a></td>
				  				<td valign="top">{{#list_employment rs_employment_history}}{{this}}{{/list_employment}}</td>
				  			</tr>
				  			{{/each}}
				  		</tbody>
				  	</table>
				  </div>
				</div>
			{{/each}}
		</script>	
		{/literal}
		
	</body>
</html>