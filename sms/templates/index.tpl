<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<script type="text/javascript" src="js/index.js"></script>
		<link rel="stylesheet" href="css/index.css"/>
		<title>SMS Logs - Remote Staff</title>
	</head>

	<body>
		<input type="hidden" name="admin_id" value="{$admin_id}" id="admin_id"/>
		<input type="hidden" name="admin_status" value="{$admin.status}" id="admin_status"/>
		<input type="hidden" name="base_url" value="{$base_url}" id="base_url"/>
		
		<audio controls="controls" preload="auto" id="sms_sound">
			 <source src="/portal/raffle/mp3/drum_roll.mp3" type="audio/mp3" />
			 <source src="/portal/raffle/mp3/drum_roll.ogg" type="audio/ogg" />
			 <source src="/portal/raffle/mp3/victory_sound.mp3" type="audio/mp3" />
			 <source src="/portal/raffle/mp3/victory_sound.ogg" type="audio/ogg" />
		</audio>
		{include file="new_header.tpl"}
		
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="bs-header">
					<h3>SMS Portal Logs</h3>
					
				</div>
			</div>
			<div class="row-fluid">
				<form class="form-inline well" role="form" id="filter-form">
				
				  <div class="form-group">
				    <label class="sr-only"  for="selectMode">Mode</label>
				    <select name="mode" id="selectMode" class="form-control">
				    	<option value="">All</option>
				    	<option value="send">SENT</option>
				    	<option value="reply">REPLY</option>
				  	</select>
				  </div>
				  <div class="form-group">
				    <label class="sr-only"  for="selectMode">Read</label>
				    <select name="read" id="selectRead" class="form-control">
				    	<option value="">All</option>
				    	<option value="read">READ</option>
				    	<option value="unread">UNREAD</option>
				  	</select>
				  </div>
				  <div class="form-group">
				    <label class="sr-only"  for="selectShowType">Show Type</label>
				    <select name="show_type" id="selectShowType" class="form-control">
				    	<option value="">All</option>
				    	<option value="show_only_active_subcon">Show Only Active Subcon Messages</option>
				    	<option value="show_only_nonactive_subcon">Show Recruitment Messages</option>
				  	</select>
				  </div>
				  
				  <div class="form-group">
				    <label class="sr-only" for="inputDateFrom">Date From</label>
				    <input type="text" name="date_from" id="inputDateFrom" class="form-control" placeholder="Date From" value=""  max="3000-01-01">
				  </div>
				  <div class="form-group">
				    <label class="sr-only"  for="inputDateTo">Date To</label>
				    <input type="text" name="date_to" id="inputDateTo" class="form-control" placeholder="Date To" value="" max="3000-01-01">
				  </div>
				  <div class="checkbox" style="margin-left:4px;">
				    <label>
				      <input type="checkbox" name="show_only_compliance" value="yes"> Show only Compliance
				    </label>
				  </div>
				  <br/><br/>
				  <div class="form-group">
				    <label class="sr-only"  for="selectCSRO">CSRO</label>
				    <select name="csro_id" id="selectCSRO" class="form-control">
				    	<option value="">Please Select CSRO</option>
				    	{foreach from=$csros item=csro}
				    		{if $csro_id eq $csro.admin_id}
								<option value="{$csro.admin_id}" selected>{$csro.admin_fname} {$csro.admin_lname}</option>			    		
				    		{else}
					    		<option value="{$csro.admin_id}">{$csro.admin_fname} {$csro.admin_lname}</option>
				    		{/if}
				    		
				    	{/foreach}
				    </select>
				  </div>
				  <div class="form-group">
				    <label class="sr-only"  for="selectRecruiter">Recruiter</label>
				     <select name="recruiter_id" id="selectRecruiter" class="form-control">
				    	<option value="">Please Select Recruiter</option>
				    	{foreach from=$recruiters item=recruiter}
				    		{if $recruiter_id eq $recruiter.admin_id}
					    		<option value="{$recruiter.admin_id}" selected>{$recruiter.admin_fname} {$recruiter.admin_lname}</option>			    		
				    		{else}
					    		<option value="{$recruiter.admin_id}">{$recruiter.admin_fname} {$recruiter.admin_lname}</option>
				    		
				    		{/if}
				    	{/foreach}
				    </select>
				  </div>
				  <div class="form-group">
				    <label class="sr-only"  for="inputKeyword">Keyword</label>
				    <input type="text" name="keyword" id="inputKeyword" class="form-control" placeholder="Enter Mobile Number" value="">
				  </div>
				  <div class="checkbox">
				    <label>
				      <input type="checkbox" name="show_only_not_in_system" value="yes"> Show only Mobile Numbers not in the System
				    </label>
				  </div>
				  <div class="form-group">
					  <button type="submit" class="btn btn-default">Search <i class="glyphicon glyphicon-search"></i></button>
				  </div>
				</form>
			</div>
			
			<div class="row-fluid" style="overflow: hidden">
				<div class="pull-right">
					<ul class="pagination">
					  <li><a href="#" class="prev disabled">&laquo;</a></li>
					
					  <li><a href="#" class="next">&raquo;</a></li>
					</ul>
				</div>
				<div class="pull-right">
				  	<select name="page" class="pager form-control">
				  		
				  	</select>
				</div>
				<div class="showing pull-right" style="margin-top:25px;margin-right:5px">
					<span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
				</div>
			</div>
			<div class="row-fluid" style="position:relative">
				
				<table id="sms_logs" class="table table-condensed table-hover table-bordered">
					<thead>
						<tr>
							<th width="5%" style="background-color:#d9edf7">#</th>
							<th width="10%" style="background-color:#d9edf7">Sender</th>
							<th width="10%" style="background-color:#d9edf7">Receiver</th>
							<th width="8%" style="background-color:#d9edf7">Mobile Number</th>
							<th width="10%" style="background-color:#d9edf7">Recruiter Assigned</th>
							<th width="10%" style="background-color:#d9edf7">CSRO Assigned</th>
							<th width="24%" style="background-color:#d9edf7">Message</th>
							<th width="15" style="background-color:#d9edf7">Date</th>
							<th width="8%"></th>
							
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<div id="rs-preloader" class="rs-preloader" style="display:none;height: 100%; width: 100%; opacity: 0.5; left: 0; top:0; position:absolute"><img src="../images/ajax-loader.gif" id="preloader-img" style="vertical-align: middle"></div>

			</div>
			<div class="row-fluid" style="overflow: hidden">
				<div class="pull-right">
					<ul class="pagination">
					  <li><a href="#" class="prev disabled">&laquo;</a></li>
					  <li><a href="#" class="next">&raquo;</a></li>
					</ul>
				</div>
				<div class="pull-right">
				  	<select name="page" class="pager form-control">
				  		
				  	</select>
				</div>
				<div class="showing pull-right" style="margin-top:25px;margin-right:5px">
					<span class="start_count">0</span> - <span class="end_count">0</span> out of <span class="total_records">0</span> records
				</div>
			</div>
			
			{include file="new_footer.tpl"}
		</div>
	</body>
</html>