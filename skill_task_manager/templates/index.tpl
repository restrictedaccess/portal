<!DOCTYPE html>
<html>
	<head>
		{include file="new_include.tpl"}
		<title>Skill Task Management - Remote Staff</title>
		
		<link rel="stylesheet" href="css/skill_test_manager.css"/>
		<script type="text/javascript" src="js/typeahead.bundle.min.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>

	<body>

		{include file="new_header.tpl"}

		<div class="row-fluid" style="padding-top:60px;">
			<div class="col-lg-3 col-md-3">
				{foreach from=$categories item=category}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><a href="#" class="category_loader" data-category_id="{$category.category_id}">{$category.category_name}</a></h3>
					</div>

					<div class="panel-body">
						<ul>
							{foreach from=$category.subcategories item=subcategory}
							<li>
								<a href="#" class="subcategory_loader" data-sub_category_id="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</a>
							</li>
							{/foreach}
						</ul>
					</div>
				</div>
				{/foreach}
			</div>
			<div class="col-lg-9 col-md-9">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Task List for <span class="category_name"></span></h3>
					</div>
					 <!-- Table -->
				    <table class="table">
				 		<thead>
				 			<tr>
				 				<th width="60%">Task Name</th>
				 				<th width="20%">Display on Website</th>
				 				<th></th>
				 			</tr>
				 		</thead>
				 		<tbody id="task-list-body">
				 			
				 		</tbody>
				    </table>
					<div class="panel-footer">
						<form method="POST" class="add-task">
							<input type="hidden" name="type" value="task"/>
							<input type="hidden" name="sub_category_id" class="sub_category_id"/>
							<div class="input-group">

								<input name="value" id="btn-input" type="text" class="form-control input-sm" placeholder="Enter Task Name Here">
								<span class="input-group-btn">
									<button class="btn btn-warning btn-sm" id="btn-chat">
										Add
									</button> </span>

							</div>

						</form>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Skill List for <span class="category_name"></span></h3>
					</div>
					 <!-- Table -->
				    <table class="table">
				 		<thead>
				 			<tr>
				 				<th width="20%">Skill Name</th>
				 				<th></th>
				 			</tr>
				 		</thead>
				 		<tbody id="skill-list-body">
				 			
				 		</tbody>
				    </table>
					<div class="panel-footer">
						<form method="POST" class="add-task">
							<div class="input-group">
								<input type="hidden" name="type" value="skill"/>
								<input type="hidden" name="sub_category_id" class="sub_category_id"/>
								<input name="value" type="text" class="form-control input-sm skill-item" placeholder="Enter Skill Name Here">
								<span class="input-group-btn">
									<button class="btn btn-warning btn-sm" id="btn-chat">
										Add
									</button> </span>

							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
		<div style="clear: both"></div>
		{include file="new_footer.tpl"}
		{include file="popup_dialog_rschat.tpl"}
		{include file="popup_edit_task.tpl"}
		
		{literal}
		<script id="task-item" type="text/x-handlebars-template">
			<tr>
				<td>{{value}}</td>
				<td>{{display_website}}</td>
				<td><button data-id="{{id}}" class="edit-task-launcher">Edit</button><button data-id="{{id}}" class="delete-task-launcher" data-sub_category_id="{{sub_category_id}}" disabled="disabled">Delete</button></td>
			</tr>
		</script>
		{/literal}
	</body>
</html>