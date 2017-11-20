<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accounts Collections Report</title>

<link href="/portal/site_media/workflow_v2/js/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/portal/site_media/subcontractors/css/style.css" rel="stylesheet">
<link href="/portal/site_media/workflow_v2/js/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<script src="/portal/site_media/workflow_v2/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
<script  src="/portal/site_media/workflow_v2/js/modernzr.js"></script>    
<script  src="/portal/site_media/workflow_v2/js/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/portal/site_media/workflow_v2/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="shortcut icon" href="/portal/favicon.ico">

<link rel="stylesheet" type="text/css" href="/portal/leave_request_form/media/css/antique.css" />
<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/portal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="/portal/css/gold/gold.css" />

<link href="/portal/accounts/media/css/style.css" rel="stylesheet">


<script src="/portal/js/handlebars-v3.0.3.js"></script>
<!--
<link href="/portal/site_media/client_portal/css/cupertino/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
<link href="/portal/soa/media/css/MonthPicker.2.1.css" media="all" rel="stylesheet" type="text/css" />

<script src="/portal/site_media/client_portal/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/portal/soa/media/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="/portal/soa/media/MonthPicker.2.1.min.js" type="text/javascript"></script>
-->
    
</head>

<body>
<input type="hidden" id="API_URL" name="API_URL" value="{$API_URL}" />	
{include file="nav.tpl"}
<div class="container-fluid">
	<h4 align="center" >Collections Report</h4>
	
	
	<form name="form" id="search_form" method="post" style="margin-bottom:10px;">
		
	    From : <input id="date_from" name="date_from" type="text" placeHolder="mm/yyyy" value="{$start_date}" readonly />  
	    To : <input id="date_to" name="date_to" type="text"  placeHolder="mm/yyyy" value="{$end_date}" readonly />
	    
	    <!--
	    Month/Year : <input id="search_date" name="search_date" type="text" value="" placeHolder="mm/yyyy" readonly />
	    -->
		<br />
		<button class="btn btn-primary" id="generate-btn">Generate</button> 
	</form>


	<div id="result-container">
		
		<table width="100%" class="table table-condensed table-striped table-bordered">
			<thead>
				<th width="5%">Client Id</th>
				<th width="5%">DBS</th>
				<th width="10%">Name</th>
				<th width="10%">Invoice</th>
				<th width="5%">Status</th>
				<th width="8%">Date</th>
				<th width="5%" >Currency</th>
				<th width="10%">Amount</th>
				<th>Items</th>
			</thead>
			<tbody></tbody>			
		</table>
				
	</div>
	
</div>
<p>&nbsp;</p>

<footer>
	<span class="pull-left"> &copy; Remotestaff Inc. 2013 </span>
	<span class="pull-right"> Admin {$admin.admin_fname} {$admin.admin_lname} </span>
    <br clear="all" />
</footer>

</body>
<script type="text/javascript" src="/portal/accounts/media/js/collections_report.js"></script>
{literal}
<script id="entry-template" type="text/x-handlebars-template">

	{{#each this}}	
	<tr>
		<td>{{client_id}}</td>
		<td>{{days_before_suspension}}</td>
		<td>{{client_name}}</td>
		<td>{{invoice_id}}</td>
		<td>{{status}}</td>
		<td>{{date_order}}</td>
		<td>{{currency}}</td>
		<td>{{amount}}</td>
		<td>
			<ol>			
				{{#each items}}
					<li>
						<ul>
    						{{#each this}}
    							<li> {{@key}}: {{this}}</li>
    						{{/each}}
    					</ul>
    				</li>	 
				{{/each}}
			</ol> 
		</td>
	</tr>
	{{/each}}
  
</script>
{/literal}
</html>