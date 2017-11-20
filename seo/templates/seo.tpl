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
		<script src="/portal/seo/js/index.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/recruiter/js/bootstrap/css/bootstrap-responsive.min.css"/>
	
		<title>Search Engine Optimization Content Management</title>
	</head>
	<body>
		{php} include("../recruiter/header.php") {/php}
		{php} include("../recruiter/recruiter_top_menu.php") {/php}
		
		<div class="container-fluid" id="main-body">
			
			<div class="row-fluid">
				<h1>Search Engine Optimization Content Management</h1>
				<table class="table">
					<thead>
						<tr>
							<th>
								Category Name
							</th>
							<th>
								Singular Name
							</th>
							
							<th>
								URL
							</th>
							<th>
								Titles / Meta Titles
							</th>
							<th width="20%">
								Meta Description
							</th>
							<th width="20%">
								Meta Keywords
							</th>
							<th>
								Status
							</th>
							<th width="15%">
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
								<td id="category_name_{$jc.category_id}">
									{$jc.category_name}
								</td>
								<td id="category_singular_name_{$jc.category_id}">
									{$jc.singular_name}
								</td>
								<td id="category_url_{$jc.category_id}">
									{$jc.url}
								</td>
								<td id="category_title_{$jc.category_id}">
									{$jc.title}
								</td>
								<td id="category_meta_description_{$jc.category_id}">
									{$jc.meta_description}
								</td>
								<td id="category_keywords_{$jc.category_id}">
									{$jc.keywords}
								</td>
								<td id="category_status_{$jc.category_id}">
									{$jc.status}
								</td>
								<td id="category_sub_categories_{$jc.category_id}">
									<ul>
										
										{foreach from=$jc.job_sub_categories item=jsc}
											{if $jsc.sub_category_name neq ""}
												<li><a href="#" class="edit_subcategory" data-id="{$jsc.sub_category_id}">{$jsc.sub_category_name} ({$jsc.count})</a></li>
											{/if}
										{/foreach}
									</ul>
								</td>
								<td id="category_action_{$jc.category_id}">
									<a href="#" data-id="{$jc.category_id}" class="edit_category">Edit Category</a>
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
		    <h3 id="category_dialog_header">Update Sub Category</h3>
		  </div>
		  <div class="modal-body">
		  	<form method="POST" class="form-horizontal" id="update_subcategory">
		  		<input type="hidden" name="sub_category_id" id="update_subcategory_id">
		  		<div class="control-group">
				    <label class="control-label" for="update_subcategory_category_name">Sub Category Name</label>
				    <div class="controls">
				      <input type="text" name="sub_category_name" id="update_subcategory_category_name" placeholder="Sub Category Name">
				      
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_category_name">Singular Name</label>
				    <div class="controls">
				      <input type="text" name="singular_name" id="update_subcategory_singular_name" placeholder="Singular Name">
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
				    	<input type="text" name="title" id="update_subcategory_title" placeholder="Title/Meta Title">
					    <br/><small><span class="category_count">69</span> characters remaining.</small>
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_url">Page Header</label>
				    <div class="controls">
				      <input type="text" name="page_header" id="update_subcategory_page_header" placeholder="Page Header">
				    </div>
			   </div>
			   <div class="control-group">
                    <label class="control-label" for="update_category_description">Page Description</label>
                    <div class="controls">
                      <textarea id="update_subcategory_page_description" name="page_description" placeholder="Page Description" rows="10"></textarea>
                    </div>
               </div>
               
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_keywords">Meta Keywords</label>
				    <div class="controls">
				      <textarea id="update_subcategory_keywords" name="keywords" placeholder="Meta Keywords" rows="10"></textarea>
				    </div>
			   </div>
			    <div class="control-group">
				    <label class="control-label" for="update_subcategory_description">Meta Description</label>
				    <div class="controls">
				      <textarea id="update_subcategory_description" name="meta_description" placeholder="Meta Description" rows="10"></textarea>
				    	<br/><small><span class="description_count">160</span> characters remaining.</small>
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_subcategory_status">Job Category</label>
				    <div class="controls">
				    	 <select id="update_subcategory_category_id" name="category_id">
						   {foreach from=$job_categories item=jc}
						   		<option value="{$jc.category_id}">{$jc.category_name}</option>
						   {/foreach}
			   			</select>
			   
			   		</div>
			   
		  		</div>
		  		<div class="control-group">
				    <label class="control-label" for="update_subcategory_status">Status</label>
				    <div class="controls">
				      <select id="update_subcategory_status" name="status">
				      	<option value="new">New</option>
				      	<option value="posted">Posted</option>
				      </select>
				    </div>
			   </div>
		  	</form>
		</div>
		 <div class="modal-footer">
		    <a href="#" class="btn" id="close_subcategory">Close</a>
		    <a href="#" class="btn btn-primary" id="save_subcategory">Save changes</a>
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
				      <input type="text" name="category_name" id="update_category_category_name" placeholder="Category Name">
    				</div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_singular_name">Singular Name</label>
				    <div class="controls">
				      <input type="text" name="singular_name" id="update_category_singular_name" placeholder="Singular Name">
				    </div>
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="update_category_url">URL label</label>
				    <div class="controls">
				      <input type="text" name="url" id="update_category_url" placeholder="URL">
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_url">Page Header</label>
				    <div class="controls">
				      <input type="text" name="page_header" id="update_category_page_header" placeholder="Page Header">
				    </div>
			   </div>
			    <div class="control-group">
                    <label class="control-label" for="update_category_description">Page Description</label>
                    <div class="controls">
                      <textarea id="update_category_page_description" name="page_description" placeholder="Page Description" rows="10"></textarea>
                    </div>
               </div>
			   <div class="control-group">
                    <label class="control-label" for="update_category_description">Meta Description</label>
                    <div class="controls">
                      <textarea id="update_category_description" name="meta_description" placeholder="Meta Description" rows="10"></textarea>
                      <br/><small><span class="description_count">160</span> characters remaining.</small>
                    </div>
               </div>
               
			   <div class="control-group">
				    <label class="control-label" for="update_category_title">Title/Meta Title</label>
				    <div class="controls">
				      <input type="text" name="title" id="update_category_title" placeholder="Title/Meta Title">
					  <br/><small><span class="category_count">69</span> characters remaining.</small>
				    </div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="update_category_keywords">Meta Keywords</label>
				    <div class="controls">
				      <textarea id="update_category_keywords" name="keywords" placeholder="Meta Keywords" rows="10"></textarea>
				    </div>
			   </div>
			    <div class="control-group">
				    <label class="control-label" for="update_category_description">Meta Description</label>
				    <div class="controls">
				      <textarea id="update_category_description" name="meta_description" placeholder="Meta Description" rows="10"></textarea>
				      <br/><small><span class="description_count">160</span> characters remaining.</small>
				    </div>
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="update_category_status">Status</label>
				    <div class="controls">
				      <select id="update_category_status" name="status">
				      	<option value="new">New</option>
				      	<option value="posted">Posted</option>
				      </select>
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