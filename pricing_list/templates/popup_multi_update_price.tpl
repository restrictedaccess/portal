<div class="modal" id="price_multi_update_popup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Update Pricing</h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
		        <label for="sub_category_id">Job Position</label>
		        <select name="sub_category_id" class="form-control" id="update_sub_category_id">
		        	<option value="">Select Job Position</option>
		        	{foreach from=$categories item=category}
		        		<optgroup label="{$category.category_name}">
		        			{foreach from=$category.subcategories item=subcategory}
				        		<option value="{$subcategory.sub_category_id}">{$subcategory.sub_category_name}</option>
				        	{/foreach}
		        		</optgroup>
			        	
		        	{/foreach}
		        </select>
		    </div>
		    
		    {foreach from=$currencies item=currency}
		    	 <div class="panel panel-default">
		    	 	<input type="hidden" name="currency[]" value="{$currency}" id="update_currency"/>
		    	 	<div class="panel-heading">{$currency}</div>
		    	 	<div class="panel-body">
		    	 		<input type="text" name="entry_price[]" placeholder="Entry Level Price" id="price_entry_level_{$currency}"/>
		    	 		<input type="text" name="mid_price[]" placeholder="Mid Level Price" id="price_mid_level_{$currency}"/>
		    	 		<input type="text" name="advanced_price[]" placeholder="Expert Level Price" id="price_advanced_level_{$currency}"/>
		    	 		
		    	 		
		    	 	</div>
		    	 </div>
		    {/foreach}
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close_pop" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_multi_price">Update Price</button>
      
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
