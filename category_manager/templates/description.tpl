<form id="transfer_category_form" method="post" role="form">
	{if $type eq "category"}
		<input type="hidden" name="id" id="description_id" value="{$desc.category_id}"/>
	{else}
		<input type="hidden" name="id" id="description_id" value="{$desc.sub_category_id}"/>
	{/if}
	<input type="hidden" name="type" id="description_type" value="{$type}"/>
	<div class="form-group">
	    <label for="description_description" class="sr-only">Description</label>
	  	<textarea name="description" class="form-control" id="description_description" rows="10">{$desc.description}</textarea>
	</div>	
	<div class="form-group">
		<button class="pull-right btn btn-primary" type="submit">Save Description</button>
	</div>
</form>
