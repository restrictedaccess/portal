<input id="job_role_id" name="job_role_id" type="hidden" value="{if isset($job_role_details)}{$job_role_details.details.gs_job_role_selection_id}{/if}">
{foreach from=$job_role_details.job_orders key=k item=job_order}
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="form-group">
				<select name="category[{$job_order.job_order_id}]" class="form-control category-select update-price chosen-without-search" data-placeholder="Category">
					<option value=""></option>
					{foreach from=$categories key=id item=category}
						<option value="{$id}" {if $job_order.category_id eq $id }selected="selected"{/if}>{$category}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<select name="sub_category[{$job_order.job_order_id}]" class="form-control sub-category-select update-price chosen-without-search" data-placeholder="Subcategory">
					<option value=""></option>
					{foreach from=$job_role_details.job_orders_sub_category[$k].subcategories key=id item=subcategory}
						<option value="{$id}" {if $job_order.sub_category_id eq $id}selected="selected"{/if}>{$subcategory}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">
				<select name="level[{$job_order.job_order_id}]" class="form-control level-select update-price chosen-without-search" data-placeholder="Level">
					<option value=""></option>
					<option value="entry" {if $job_order.level eq 'entry' }selected="selected"{/if}>Entry (1 - 3 years)</option>
					<option value="mid" {if $job_order.level eq 'mid' }selected="selected"{/if}>Mid Level (3 - 5 years)</option>
					<option value="advanced" {if $job_order.level eq 'expert' }selected="selected"{/if}>Expert (More than 5 years)</option>
				</select>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">	
				<select name="work_status[{$job_order.job_order_id}]" class="form-control work-status-select update-price chosen-without-search" data-placeholder="Work time">
					<option value=""></option>
					<option value="Full-Time" {if $job_order.work_status eq 'Full-Time' }selected="selected"{/if}>Full Time 9 hrs with 1 hr break</option>
					<option value="Part-Time" {if $job_order.work_status eq 'Part-Time' }selected="selected"{/if}>Part Time 4 hrs</option>
				</select>
			</div>
		</div>	
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
			<div class="form-group">			
				<input type="text"  name="no_of_staff[{$job_order.job_order_id}]" class="form-control no_of_staff update-price-text" placeholder="No. of staff needed" value="{$job_order.no_of_staff_needed}" />
			</div>
		</div>
		{if $k ne 0}<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><button class="btn btn-danger btn-sm remove-row" type="button"><i class="glyphicon glyphicon-remove"></i></button></div>{/if}
	</div>
{/foreach}
