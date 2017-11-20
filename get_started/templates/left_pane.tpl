<label>INCOMPLETE</label>
<div>
<ul>
{section name=j loop=$incomplete_orders}
	{strip}
		<li>
		<a href="javascript:showIncompleteOrder({$incomplete_orders[j].gs_job_role_selection_id});">
			<span>{$incomplete_orders[j].fname} {$incomplete_orders[j].lname}</span>
			<span>#{$incomplete_orders[j].gs_job_role_selection_id}Recruitment Service Order</span>
			<span>{$incomplete_orders[j].date_created}</span>
		</a>
		</li>
	{/strip}
{/section}
</ul>
</div>
<label>OPEN</label>
<div>
<ul>
{section name=j loop=$open_orders}
	{strip}
		<li>
		<a href="javascript:showOrder({$open_orders[j].id});">
			<span>{$open_orders[j].fname} {$open_orders[j].lname}</span>
			<span>#{$open_orders[j].id} {$open_orders[j].description}</span>
			<span>{$open_orders[j].date_created}</span>
		</a>
		</li>
	{/strip}
{/section}
</ul>
</div>


<label>PAID</label>
<div>
<ul>
{section name=j loop=$paid_orders}
	{strip}
		<li>
		<a href="javascript:showOrder({$paid_orders[j].id});">
			<span>{$paid_orders[j].fname} {$paid_orders[j].lname}</span>
			<span>#{$paid_orders[j].id} {$paid_orders[j].description}</span>
			<span>{$paid_orders[j].date_created}</span>
		</a>
		</li>
	{/strip}
{/section}
</ul>
</div>


<label>PAST DUE</label>
<div>
<ul>
{section name=j loop=$past_due_orders}
	{strip}
		<li>
		<a href="javascript:showOrder({$past_due_orders[j].id});">
			<span>{$past_due_orders[j].fname} {$past_due_orders[j].lname}</span>
			<span>#{$past_due_orders[j].id} {$past_due_orders[j].description}</span>
			<span>{$past_due_orders[j].date_created}</span>
		</a>
		</li>
	{/strip}
{/section}
</ul>
</div>

<label>CANCELLED</label>
<div>
<ul>
{section name=j loop=$cancelled_orders}
	{strip}
		<li>
		<a href="javascript:showOrder({$cancelled_orders[j].id});">
			<span>{$cancelled_orders[j].fname} {$cancelled_orders[j].lname}</span>
			<span>#{$cancelled_orders[j].id} {$cancelled_orders[j].description}</span>
			<span>{$cancelled_orders[j].date_created}</span>
		</a>
		</li>
	{/strip}
{/section}
</ul>
</div>




