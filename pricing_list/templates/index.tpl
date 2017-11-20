<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Job Order Pricing List Management - Remote Staff</title>
		
		<link rel="stylesheet" href="css/index.css"/>
		<script type="text/javascript" src="js/typeahead.bundle.min.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>

	<body>

		{include file="new_header.tpl"}

		<div class="row-fluid" style="padding-top:60px;">
			<div class="col-lg-12 col-md-12">
				<form class="price_select_form">
					<div style="margin-bottom:20px;margin-top:10px">
						<select name="category_id" id="category_id" style="width:200px">
							<option value="">Select Category</option>
							{foreach from=$categories item=category}
								<option value="{$category.category_id}">{$category.category_name}</option>
							{/foreach}
						</select>
						<select name="sub_category_id" id="sub_category_id" style="width:200px">
							<option value="">Select Job Position</option>
						</select>
						
					</div>
				
					<div>
						<button id="search_price" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-search"></i> Search</button>
						<button id="add_new_price" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus"></i> Add New Price</button>
					</div>
				</form>
				
				<div style="margin-top:30px;margin-bottom:10px">
					Select Currency: 
					<select name="change_currency" id="change_currency">
						<option value="AUD">AUD</option>
						<option value="GBP">GBP</option>
						<option value="USD">USD</option>
						
					</select>
				</div>
				<div id="pricing-div"></div>
				<div class="panel panel-info">
					<div class="panel-heading">
						History
					</div>
					<div class="panel-body" id="history_list">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="70%">History</th>
									<th width="20%">Admin</th>
									<th width="10%">Date</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div style="clear: both"></div>
		{include file="popup_add_price.tpl"}
		{include file="popup_multi_update_price.tpl"}
		{include file="new_footer.tpl"}
		
		
		{literal}
		<script type="text/x-handlebars-template" id="pricing-category">
			<div class="panel panel-primary">
				<div class="panel-heading">
					{{category_name}}
				</div>
				<table class="table table-bordered" id="pricing_list">
					<thead>
						<tr>
							<th width="20%">
								Job Position
							</th>
							<th width="20%">
								Pricing
							</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						{{#each subcategories}}
							<tr>
								<td>{{sub_category_name}}</td>
								<td>
									{{#each prices}}
										{{value}} {{currency}} - {{level}} [<a href='/portal/pricing_list/delete_price.php?id={{id}}' class="delete_price">Delete</a>] <br/>
									{{/each}}
								</td>
								<td>
									[<a href='#' class="update_subcategory_price" data-id="{{sub_category_id}}">Update</a>]
								</td>
							</tr>
						{{/each}}
					</tbody>
				</table>
			</div>
		</script>
		<script type="text/x-handlebars-template" id="history-row">
			<tr>
				<td>{{log}}</td>
				<td>{{admin.admin_fname}} {{admin.admin_lname}}</td>
				<td>
					{{date_updated}}
				</td>
				
			</tr>
		</script>
		{/literal}
	</body>
</html>
