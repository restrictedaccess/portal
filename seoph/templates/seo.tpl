<!DOCTYPE html>
<html>
	<head>
		
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
		<link rel="stylesheet" href="/portal/seo/css/index.css"/>
		<script src="/portal/seoph/js/index.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
	
		<title>Search Engine Optimization Content Management</title>
	</head>
	<body>
		{php} include("../recruiter/header.php") {/php}
		{php} include("../recruiter/recruiter_top_menu.php") {/php}
		
		<div class="container-fluid" id="main-body">
			
			<div class="row-fluid">
				<h1>Search Engine Optimization for .PH Content Management</h1>
				<table class="table">
					<thead>
						<tr>
							<th>
								Category Name
							</th>
							
							<th>
								URL
							</th>
							<th>
								Titles / Meta Titles
							</th>
							<th>
								Meta Description
							</th>
							<th>
								Meta Keywords
							</th>
							<th>
								Sub Categories
							</th>
							<th>
								Actions
							</th>
						</tr>
						
					</thead>
					<tbody id="categories">
						{foreach from=$job_categories item=jc}
							<tr>
								<td id="category_name_{$jc.jr_cat_id}">
									{$jc.cat_name}
								</td>
							
								<td id="category_url_{$jc.jr_cat_id}">
									{$jc.url}
								</td>
								<td id="category_title_{$jc.jr_cat_id}">
									{$jc.meta_title}
								</td>
								<td id="category_meta_description_{$jc.jr_cat_id}">
									{$jc.meta_description}
								</td>
								<td id="category_keywords_{$jc.category_id}">
									{$jc.meta_keyword}
								</td>
								<td id="category_sub_categories_{$jc.jr_cat_id}">
									<ul>
										
										{foreach from=$jc.job_categories item=jsc}
											{if $jsc.category_name neq ""}
												<li><a href="#" class="edit_category" data-id="{$jsc.category_id}">{$jsc.category_name}</a></li>
											{/if}
										{/foreach}
									</ul>
								</td>
								<td id="category_action_{$jc.jr_cat_id}">
									<a href="#" data-id="{$jc.jr_cat_id}" class="edit_jr_category">Edit Category</a>
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</div>
			
		</div>
		
		<div class="modal hide fade" id="update_subcategory_modal">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 id="category_dialog_header">Update Job Role Category</h3>
		  </div>
		  <div class="modal-body">
		  	<form method="POST" class="form-horizontal" id="update_subcategory">
		  		<input type="hidden" name="jr_cat_id" id="update_jrcategory_id">
		  		<div class="control-group">
				    <label class="control-label" for="update_subcategory_category_name">Category Name</label>
				    <div class="controls">
				      <input type="text" name="cat_name" id="update_subcategory_category_name" placeholder="Sub Category Name" readonly="true">
				      
				    </div>
			   </div>
			  
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_url">URL label</label>
				    <div class="controls">
				      <input type="text" name="url" id="update_subcategory_url" placeholder="URL">
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_title">Title/Meta Title</label>
				    <div class="controls">
				    	<input type="text" name="meta_title" id="update_subcategory_title" placeholder="Title/Meta Title">
					    <br/><small><span class="category_count">69</span> characters remaining.</small>
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_keywords">Meta Keywords</label>
				    <div class="controls">
				      <textarea id="update_subcategory_keywords" name="meta_keyword" placeholder="Meta Keywords" rows="10"></textarea>
				    </div>
			   </div>
			    <div class="control-group">
				    <label class="control-label" for="update_subcategory_description">Meta Description</label>
				    <div class="controls">
				      <textarea id="update_subcategory_description" name="meta_description" placeholder="Meta Description" rows="10"></textarea>
				    	<br/><small><span class="description_count">160</span> characters remaining.</small>
				    </div>
			   </div>
		  	</form>
		</div>
		 <div class="modal-footer">
		    <a href="#" class="btn" id="close_subcategory">Close</a>
		    <a href="#" class="btn btn-primary" id="save_jrcategory">Save changes</a>
		  </div>
		</div>
		
		
		<div class="modal hide fade" id="update_category_modal">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 id="category_dialog_header">Update Category</h3>
		  </div>
		  <div class="modal-body">
		  	<form method="POST" class="form-horizontal" id="update_category">
		  		<input type="hidden" name="category_id" id="update_category_id">
		  		<div class="control-group">
				    <label class="control-label" for="update_category_category_name">Category Name</label>
				    <div class="controls">
				      <input type="text" name="category_name" id="update_category_category_name" placeholder="Category Name" readonly="true">
    				</div>
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="update_category_url">URL label</label>
				    <div class="controls">
				      <input type="text" name="url" id="update_category_url" placeholder="URL">
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_title">Title/Meta Title</label>
				    <div class="controls">
				      <input type="text" name="meta_title" id="update_category_title" placeholder="Title/Meta Title">
					  <br/><small><span class="category_count">69</span> characters remaining.</small>
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_keywords">Meta Keywords</label>
				    <div class="controls">
				      <textarea id="update_category_keywords" name="meta_keyword" placeholder="Meta Keywords" rows="10"></textarea>
				    </div>
			   </div>
			    <div class="control-group">
				    <label class="control-label" for="update_category_description">Meta Description</label>
				    <div class="controls">
				      <textarea id="update_category_description" name="meta_description" placeholder="Meta Description" rows="10"></textarea>
				      <br/><small><span class="description_count">160</span> characters remaining.</small>
				    </div>
			   </div>
			 
			   
			   
		  		
		  	</form>
		  	
		  	
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn" id="close_category">Close</a>
		    <a href="#" class="btn btn-primary" id="save_category">Save changes</a>
		  </div>
		</div>
	</body>
</html>