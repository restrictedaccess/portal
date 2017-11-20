<div id="order-information">
	<h2>Order Information</h2>

	<div id="order-details">
		<dl>
			<dt>Job Title</dt>
			<dd id="dd-job_title">{$currentOrder.job_title}</dd>
			<dt>Gap on Endorsement</dt>
			<dd id="dd-average_endorsed">{$currentOrder.average_endorsed} day/s</dd>

			<dt>Gap on Interviewed</dt>
			<dd id="dd-average_interviewed">{$currentOrder.average_interviewed}
				day/s</dd>

			<dt>Client</dt>
			<dd id="dd-client">{$currentOrder.client}</dd>
			<dt>Service Type</dt>
			<dd id="dd-service_type">{$currentOrder.service_type}</dd>
			<dt>Order Status</dt>
			<dd id="dd-order_status">{$currentOrder.order_status}</dd>
			<dt>Work Status</dt>
			<dd id="dd-work_status">{$currentOrder.work_status}</dd>
			<dt>Date Ordered</dt>
			<dd id="dd-date_filled_up">{$currentOrder.date_filled_up}</dd>
			<dt>Date When Staff is Required</dt>
			<dd id="dd-proposed_start_date">{$currentOrder.proposed_start_date}</dd>
			<dt>Order Age in Days</dt>
			<dd id="age">{$currentOrder.age}</dd>
			<dt>Work Time Zone</dt>
			<dd id="dd-working_timezone">{$currentOrder.working_timezone}</dd>
			<dt>Budget</dt>
			<dd id="dd-budget">{$currentOrder.budget}</dd>
			<dt>Recruiters</dt>
			<dd id="dd-assigned_recruiters">
				<ul>
					{foreach from=$currentOrder.assigned_recruiters item=recruiter}
					<li>{$recruiter.admin_fname} {$recruiter.admin_lname}</li>
					{/foreach}
				</ul>

			</dd>
			<dt>Hiring Coordinator</dt>
			<dd id="dd-hiringcoordinator">{$currentOrder.hc_fname}
				{$currentOrder.hc_lname}</dd>
			<dt>Business Developer</dt>
			<dd id="dd-assigned_business_developer">
				{$currentOrder.assigned_business_developer}</dd>
			<dt>Shortlisted</dt>
			<dd id="dd-shortlisted">{$currentOrder.shortlisted}</dd>
			<dt>Endorsed / ASL Interview Request</dt>
			<dd id="dd-endorsed">{$currentOrder.endorsed}</dd>

			<dt>Interviewed</dt>
			<dd id="dd-interviewed">{$currentOrder.interviewed}</dd>
			<dt>Hired</dt>
			<dd id="dd-hired">{$currentOrder.hired}</dd>
			<dt>On Trial</dt>
			<dd id="dd-ontrial">{$currentOrder.ontrial}</dd>
			<dt>Rejected</dt>
			<dd id="dd-rejected">{$currentOrder.rejected}</dd>
		</dl>
	</div>
	<div id="order-list">
		<ul class="ui-selectable">
			{foreach from=$orders item=order name=listorder} {if
			$smarty.foreach.listorder.index eq 0}
			<li class="ui-widget-content ui-selected"
				data-id="{$order.gs_job_titles_details_id}">{$order.job_title},
				{$order.client}, {$order.date_filled_up}<br />
				{$order.service_type}, {$order.order_status}</li> {else}
			<li class="ui-widget-content"
				data-id="{$order.gs_job_titles_details_id}">{$order.job_title},
				{$order.client}, {$order.date_filled_up}<br />
				{$order.service_type}, {$order.order_status}</li> {/if} {/foreach}
		</ul>

	</div>
</div>
