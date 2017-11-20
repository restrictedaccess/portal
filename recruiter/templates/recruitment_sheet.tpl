<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Recruitment Sheet</title>
	<link rel="stylesheet" href="/portal/recruiter/css/style.css"/>
	
	<script type="text/javascript" src="/portal/recruiter/js/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/grid.locale-en.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript">
		jQuery.jgrid.no_legacy_api = true;
		jQuery.jgrid.useJSON = true;
	</script>
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/ui.jqgrid.css">
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/themes/south-street/jquery-ui-1.8.19.custom.css">
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/rsgrid.css">
	
	<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/RsInvertedGrid.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/recruitment_sheet.js"></script>
	
	<link rel=stylesheet type=text/css href="../css/font.css">
	<link rel=stylesheet type=text/css href="../menu.css">
	<link rel=stylesheet type=text/css href="../adminmenu.css">
	<link rel=stylesheet type=text/css href="../leads_information/media/css/example.css">
	<link rel=stylesheet type=text/css href="../category/category.css">
	<link rel=stylesheet type=text/css href="../leads_information/media/css/leads_information.css">
		
	<link rel=stylesheet type=text/css href="/portal/recruiter/css/recruitment_sheet.css">
	
	
</head>
<body>
	{php} include("header.php") {/php}
	{if $status eq 'BusinessDeveloper'}
		{php}include("../BP_header.php"){/php}
	{else}
		{php}include("recruiter_top_menu.php") {/php}
	{/if}
	
	<h1 class="header">Recruitment Sheet</h1>
	<div id="accordion">
		<h3 class="control"><a href="#" id="view-history">View History</a> <a href="#" id="show-hide-filters">Show/Hide Filters</a></h3>
		<input type="hidden" id="today_date" value="{$today_date}"/>
		<input type="hidden" id="before_date" value="{$before_today}"/>
		
		<div id="filter-form">
	
			<div class="filter-form">
				<dl>
					<dt>
						Individual Filters:
					</dt>
					<dd>
						<div id="individual-filter">
							
						</div>
						<select id="individual-filter-type" name="individual-filter-type">
							{$filter_types_options}
						</select> 
					</dd>
					<dt class="clear">
					</dt>
					<dd>
						<strong>OR</strong>
					</dd>
					
					<dt class="clear">
						Search by Keyword:
					</dt>
					<dd >
						<input type="text" name="keyword" placeholder="Enter Tracking Code, Clients' name and/or Applicants' name" id="keyword" size='72'/>
					</dd>
					<dt>
						Include Inhouse Staff:
					</dt>
					<dd >
						<select id="inhouse-staff" name="inhouse-staff">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
						</select>
					</dd>
					<dt class="clear">
					</dt>
					<dd>
						<strong>AND</strong>
					</dd>
					
					<dt class="clear">
						Recruiters:
					</dt>
					<dd>
						<select id="recruiters" name="recruiters">
							{$recruiter_options}
						</select>
					</dd>
					<dt>
						Hiring Coordinators:
					</dt>
					<dd >
						<select id="hiring-coordinators" name="hiring-coordinators">
							{$hiring_coordinator_options}
						</select>
					</dd>
					<dt>
                        Business Developers:
                    </dt>
                    <dd >
                        <select id="business-developer" name="business-developer">
                            <option value="">View All</option>
                            <option value="Jankulovski">Chris Jankulovski</option>
                            <option value="Fulmizi">Walter Fulmizi</option>
                            <option value="Borromeo">PJ Borromeo</option>
                            
                        </select>
                    </dd>
                    
					
				</dl>
				
				<button id="search" type="submit" class="clear">Search</button>
				<button id="refresh" class="clear">Refresh</button>
				<br/><br/><label style="padding-left:10px"><strong style="color:#ff0000">Note:&nbsp;</strong>*Filters will only work after the initial loading of the page. Wait for the page to load then apply any filter.</label><br/><br/>
			</div>
		</div>
	</div>
	
		<div id="controls-grid">
			<div id="open-close-cancel">
				<ul>
					<li><a href="#view-all-status-div" id="view-all" class="filter-link"><span>View All</span></a></li>
					<li id="li-open"><a href="#open-div" id="open" class="filter-link"><span>Open</span></a></li>
					<li id="li-hired"><a href="#close-div" id="close" class="filter-link"><span>Hired</span></a></li>
					<li id="li-dnpt"><a href="#cancel-div" id="cancel" class="filter-link"><span>Did not push through</span></a></li>
					<li id="li-onhold"><a href="#onhold-div" id="onhold" class="filter-link"><span>On Hold</span></a></li>
					<li id="li-ontrial"><a href="#ontrial-div" id="ontrial" class="filter-link"><span>On Trial</span></a></li>
				
				</ul>
				<div id="view-all-status-div"></div>
				<div id="open-div"></div>
				<div id="close-div"></div>
				<div id="cancel-div"></div>
				<div id="onhold-div"></div>
				<div id="ontrial-div"></div>
				
			</div>
		
			<div id="service-type" class="service-type clear">
				<ul>
					<li><a href="#view-all-div" class="filter-link active">View All</a></li>
					<li><a href="#custom-div" class="filter-link">Custom</a></li>
					<li><a href="#asl-div" class="filter-link">ASL</a></li>
					<li><a href="#back-order-div" class="filter-link">Back Order</a></li>
					<li><a href="#replacement-div" class="filter-link">Replacement</a></li>
					<li><a href="#inhouse-div" class="filter-link">Inhouse</a></li>
					
				</ul>
				<div id="view-all-div"></div>
				<div id="custom-div"></div>
				<div id="asl-div"></div>
				<div id="back-order-div"></div>
				<div id="replacement-div"></div>
				<div id="inhouse-div"></div>
				
			</div>
		
			{if $role eq "FULL-CONTROL"}
			<span id="toolbar" style="overflow:hidden;font-size:9px;margin-bottom:10px;display:block">
				<button id="move-to" style="float:left;">Delete</button>
				<button id="restore-to" style="float:left;">Restore</button>
				<button id="merge-to" style="float:left;">Merge As 1 order</button>
				<button id="unmerge-to" style="float:left;">Unmerge Orders</button>
				
				<span id="view-buttons" style="float:right;">
					<input type="radio" id="displayed-button" name="repeat" checked="checked" /><label for="displayed-button">Displayed</label>
					<input type="radio" id="deleted-button" name="repeat" /><label for="deleted-button">Deleted</label>
				</span>
			</span>
			{/if}
			<div id="recruitment-sheet" class="clear">
			</div>
			<div id="pager"></div>
		</div>
	
	
	<div id="details-dialog">
	
	</div>
</body>
</html>