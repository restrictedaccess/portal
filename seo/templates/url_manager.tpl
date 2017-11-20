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
		
		
		<script src="/portal/seo/js/url_manager.js" type="text/javascript"></script>
		<script type="text/javascript" src="/portal/seo/js/fileuploader.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/seo/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="/portal/seo/css/bootstrap-responsive.min.css"/>
	
		<title>Search Engine Optimization - URL Manager</title>
	</head>
	<body>
		{php} include("../recruiter/header.php") {/php}
		{php} include("../recruiter/recruiter_top_menu.php") {/php}
		
		<div class="container-fluid" id="main-body">
			
			<div class="row-fluid">
				
				<div class="span2">
					
				</div>
				<div class="span10">
					<h1 style="font-size:1.2em;margin-bottom:0.5em">Search Engine Optimization - URL Manager</h1>
					<div class="row-fluid">
						<div class="span12">
							<button class="btn btn-primary" id="add_redirect"><i class="icon-plus icon-white"></i>Add Redirect</button>
						</div>
					</div>
					
					<table class="table">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Category URL
								</th>
								<th>
									Subcategory URL
								</th>
								
								<th>
									Redirect
								</th>
								<th></th>
							</tr>
							
						</thead>
						<tbody id="url_redirects">
							{foreach from=$redirects item=redirect name=redirect_list}
								<tr>
									<td>{$smarty.foreach.redirect_list.iteration}</td>
									<td>{$redirect.category_url}</td>
									<td>{$redirect.sub_category_url}</td>
									<td>{$redirect.redirects}</td>
									<td><button class="btn-danger btn delete_redirect" data-id="{$redirect.id}">Delete</button></td>
								</tr>
							{/foreach}
						</tbody>
					</table>
					<div class="pull-right">
						<div class="pagination">
							<ul>
								<li class="{$prev_page_disabled}"><a href="/portal/seo/url_manager.php?page={$prev_page_item}">&laquo;</a></li>
								{foreach from=$pages item=page_item}
									{if $page_item eq $page}
										<li class="active">
											<a href="/portal/seo/url_manager.php?page={$page_item}">{$page_item}</a>
										</li>					
									{else}
										<li>
											<a href="/portal/seo/url_manager.php?page={$page_item}">{$page_item}</a>
										</li>			
									{/if}			
								{/foreach}
								<li class="{$next_page_disabled}"><a href="/portal/seo/url_manager.php?page={$next_page_item}">&raquo;</a></li>
							</ul>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		
		
		<div class="modal hide fade" id="add_redirect_modal">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 id="category_dialog_header">Add Redirect</h3>
		  </div>
		  <div class="modal-body">
		  	<form method="POST" class="form-horizontal" id="add_redirect_form">
		  		<div class="control-group">
				    <label class="control-label" for="add_category_url">Category URL</label>
				    <div class="controls">
				      <input type="text" name="category_url" id="add_category_url" placeholder="Category URL">
    				</div>
			   </div>
			   <div class="control-group">
				    <label class="control-label" for="add_sub_category_url">Subcategory URL</label>
				    <div class="controls">
				      <input type="text" name="sub_category_url" id="add_sub_category_url" placeholder="Sub Category URL">
				    </div>
			   </div>
			   
			   <div class="control-group">
				    <label class="control-label" for="update_redirects">Redirects</label>
				    <div class="controls">
				      <input type="text" name="redirects" id="add_redirects" placeholder="Redirects">
				    </div>
			   </div>
		  		
		  	</form>
		  	
		  	
		  </div>
		  <div class="modal-footer">
		    <a href="#" class="btn" data-dismiss="modal" id="close_modal">Close</a>
		    <a href="#" class="btn btn-primary" id="save_redirect">Save changes</a>
		  </div>
		</div>

		{php} include("../recruiter/footer.php") {/php}
	</body>
</html>