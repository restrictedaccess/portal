<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="/portal/recruiter/js/jquery-1.7.2.min.js"></script>
	
		<link rel=stylesheet type=text/css href="../css/font.css">
		<link rel=stylesheet type=text/css href="../menu.css">
		<link rel=stylesheet type=text/css href="../adminmenu.css">
		<link rel="stylesheet" type="text/css" href="../leads_information/media/css/example.css">
		<link rel="stylesheet" type="text/css" href="../category/category.css">
		
		<link rel="stylesheet" type="text/css" href="../leads_information/media/css/leads_information.css">
		
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/css/ui.jqgrid.css">
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/css/themes/rs/jquery-ui-1.8.18.custom.css">
		<script type="text/javascript" src="/portal/recruiter/js/jquery-ui-1.8.19.custom.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/portal/recruiter/js/bootstrap/js/bootstrap-tab.js"></script>
		<link rel="stylesheet" href="/portal/seo/js/fileuploader.css"/>
		
		<link rel="stylesheet" href="/portal/seo/css/index.css"/>
		
		
		<script src="/portal/seo/js/skills.js" type="text/javascript"></script>
		<script type="text/javascript" src="/portal/seo/js/fileuploader.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/seo/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/seo/css/bootstrap-responsive.min.css"/>
	
		<title>Search Engine Optimization - Skill Management</title>
	</head>
	<body>
		{php} include("../recruiter/header.php") {/php}
		{php} include("../recruiter/recruiter_top_menu.php") {/php}
		
		<div class="container-fluid" id="main-body">
			
			<div class="row-fluid">
				
				<div class="span2">
					<ul class="nav nav-pills nav-stacked">
						<li class="active">
							<a href="#">Defined Skills</a>
						</li>
						<!--
						<li>
							<a href="#">User Defined Skills </a>
						</li>
						-->
					</ul>
				</div>
				<div class="span10">
					<h1 style="font-size:1.2em;margin-bottom:0.5em">Search Engine Optimization - Skill Management</h1>
					<div class="row-fluid">
						<div class="span12">
							<button class="btn btn-primary" id="add_skill"><i class="icon-plus icon-white"></i>Add Skill</button>
							<button class="btn" id="upload_skill_select">Select CSV file</button>
							<button class="btn" id="upload_skill_button"><i class="icon-plus"></i>Upload CSV file</button>
							<div class="inline" style="margin:1em 0 1em 0" id="upload_skill"></div>
						</div>
					</div>
					<div class="row-fluid">
						<div class="pull-left span8">
							<form class="form form-inline">
								<select name="show_letter" class="span2">
									{foreach from=$letters item=letter}
										{if $letter eq $show_letter}
											<option value="{$letter}" selected>{$letter}</option>
										{else}
											<option value="{$letter}">{$letter}</option>
										{/if}
									{/foreach}
								</select>	
								<input name="keyword" class="span6" value="{$keyword}" placeholder="Enter Skill Name"/>
								<button class="btn btn-mini"><i class="icon-search"></i> Search</button>
							</form>
							
						</div>
						<div class="pull-right">
							<div class="pagination">
								<ul>
									<li class="{$prev_page_disabled}"><a href="/portal/seo/skills.php?page={$prev_page_item}{$params}">«</a></li>
									{foreach from=$pages item=page_item}
										{if $page_item eq $page}
											<li class="active">
												<a href="/portal/seo/skills.php?page={$page_item}{$params}">{$page_item}</a>
											</li>					
										{else}
											<li>
												<a href="/portal/seo/skills.php?page={$page_item}{$params}">{$page_item}</a>
											</li>			
										{/if}			
									{/foreach}
									<li class="{$next_page_disabled}"><a href="/portal/seo/skills.php?page={$next_page_item}{$params}">»</a></li>
								</ul>
							</div>
						</div>
					</div>
					
					<table class="table">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Skill Name
								</th>
								<th>
									URL
								</th>
								
								<th>
									Actions
								</th>
							</tr>
							
						</thead>
						<tbody id="categories">
							{foreach from=$defined_skills item=defined_skill name=skill_list}
								{if $defined_skill.url }
									<tr class="success">
										<td>
											{$smarty.foreach.skill_list.iteration}
										</td>
										<td id="skill_name_{$defined_skill.id}">
											{$defined_skill.skill_name}
										</td>
										<td>
											{$defined_skill.url}
										</td>
										<td>
											<a href="/portal/seo/edit_skill.php?id={$defined_skill.id}" class="edit_skill" data-id="{$defined_skill.id}">Edit</a> | <a href="/portal/seo/delete_skill.php?id={$defined_skill.id}" class="delete_skill">Delete</a> 
										</td>
									</tr>
								{else}
									<tr>
										<td>
											{$smarty.foreach.skill_list.iteration}
										</td>
										<td id="skill_name_{$defined_skill.id}">
											{$defined_skill.skill_name}
										</td>
										<td>
											{$defined_skill.url}
										</td>
										<td>
											<a href="/portal/seo/edit_skill.php?id={$defined_skill.id}" class="edit_skill" data-id="{$defined_skill.id}">Edit</a> | <a href="/portal/seo/delete_skill.php?id={$defined_skill.id}" class="delete_skill">Delete</a> 
										</td>
									</tr>
								{/if}
								
							{/foreach}
						</tbody>
					</table>
					<div class="pull-right">
						<div class="pagination">
							<ul>
								<li class="{$prev_page_disabled}"><a href="/portal/seo/skills.php?page={$prev_page_item}">«</a></li>
								{foreach from=$pages item=page_item}
									{if $page_item eq $page}
										<li class="active">
											<a href="/portal/seo/skills.php?page={$page_item}">{$page_item}</a>
										</li>					
									{else}
										<li>
											<a href="/portal/seo/skills.php?page={$page_item}">{$page_item}</a>
										</li>			
									{/if}			
								{/foreach}
								<li class="{$next_page_disabled}"><a href="/portal/seo/skills.php?page={$next_page_item}">»</a></li>
							</ul>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<div class="modal hide fade" id="update_skill">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 id="skill_dialog_header">Add New Skill</h3>
		  </div>
		  <div class="modal-body">
		  	<form method="POST" class="form-horizontal" id="update_skill_form">
		  		<input type="hidden" name="id" id="skill_id">
		  		<div class="control-group">
				    <label class="control-label" for="skill_name">Skill Name</label>
				    <div class="controls">
				      <input type="text" name="skill_name" id="skill_name" placeholder="Skill Name">
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="url">URL</label>
				    <div class="controls">
				      <input type="text" name="url" id="url" placeholder="URL">
				    </div>
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="meta_title_add">Meta Title</label>
				    <div class="controls">
				      <input type="text" name="meta_title" id="meta_title_add" placeholder="Meta Title">
					    <br/><small><span class="title_count">69</span> characters remaining.</small>
				    </div>
				    
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="meta_description_add">Meta Description</label>
				    <div class="controls">
				    	<textarea name="meta_description" id="meta_description_add" placeholder="Meta Description" rows="10"></textarea>
				    	<br/><small><span class="description_count">160</span> characters remaining.</small>
				    
				    </div>
			   </div>
			 
			   <div class="control-group">
				    <label class="control-label" for="meta_keywords_add">Meta Keywords</label>
				    <div class="controls">
				    	<textarea name="meta_keywords" id="meta_keywords_add" placeholder="Meta Keywords" rows="10"></textarea>
				    </div>
				    
			   </div>

			   
			   
			   <div id="skill_other_term_list">
				   <div class="control-group">
					    <label class="control-label" for="skill_name">Other term 1</label>
					    <div class="controls">
					      <input type="text" name="name[]" placeholder="Other term 1">
					      <button class="btn btn-danger remove_skill">Remove</button>
					    </div>
				   </div>	
			   </div>
			   <div class="control-group">
			   		<label class="control-label"></label>
			   		<div class="controls">
			   			<button class="skills add_other_skill btn">Add Other term/s</button>
			   		</div>
			   </div>
			   
		  	</form>
		  	
		  	
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn" id="close_skill_modal">Close</a>
		    <a href="#" class="btn btn-primary" id="save_new_skills">Save changes</a>
		  </div>
		</div>
		{php} include("../recruiter/footer.php") {/php}
	</body>
</html>