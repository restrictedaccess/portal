<div class="modal" id="price_update_popup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Pricing</h4>
      </div>
      <div class="modal-body">
   	  	<form class="form-horizontal" role="form">
   	  		<input type="hidden" name="id" id="update_price_id"/>
			<div class="form-group">
		        <label for="sub_category_id">Job Position</label>
		        <select name="sub_category_id" class="form-control"  id="update_price_sub_category_id">
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
		    <div class="form-group">
		        <label for="currency">Currency</label>
		        <select name="currency" class="form-control" id="update_currency">
		        	<option value="">Select Currency</option>
		        	<option value="AUD">AUD</option>
		        	<option value="GBP">GBP</option>
		        	<option value="USD">USD</option>
		        	
		        </select>
		    </div>
		    <div class="form-group">
		        <label for="level">Level</label>
		        <select name="level" class="form-control" id="update_level">
		        	<option value="">Select Level</option>
		        	<option value="advanced">Expert</option>
		        	<option value="mid">Mid Level</option>
		        	<option value="entry">Entry</option>
		        </select>
		    </div>
		    <div class="form-group">
		        <label for="value">Price</label>
		       <input type="text" name="value" placeholder="Enter Price" class="form-control" id="update_price"/>
		    </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close_pop" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_price_button">Update Price</button>
      
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->