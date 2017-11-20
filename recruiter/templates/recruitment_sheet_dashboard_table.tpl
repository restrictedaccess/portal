<table class="table table-striped table-bordered">
	<caption>{$caption}</caption>
	<thead>
		<tr>
			<th>
				Number
			</th>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<th>
					{$hiringCoordinator.admin_fname} {$hiringCoordinator.admin_lname}
				</th>
			{/foreach}
			
			<th>Total</th>
		</tr>
		<tr>
			<td>ASL</td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="asl-cell-{$hiringCoordinator.admin_id}">0
				</td>
			{/foreach}
			<td id="total-asl">0</td>
		</tr>
		<tr>
			<td>CUSTOM</td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="custom-cell-{$hiringCoordinator.admin_id}">0
				</td>
			{/foreach}
			<td id="total-custom">0</td>
		</tr>
		<tr>
			<td>REPLACEMENT</td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="replacement-cell-{$hiringCoordinator.admin_id}">0
				</td>
			{/foreach}
			<td id="total-replacement">0</td>
		</tr>
		<tr>
			<td>BACK ORDER</td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="backorder-cell-{$hiringCoordinator.admin_id}">0
				</td>
			{/foreach}
			<td id="total-backorder">0</td>
		</tr>
		<tr>
			<td>INHOUSE</td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="inhouse-cell-{$hiringCoordinator.admin_id}">0
				</td>
			{/foreach}
			<td id="total-inhouse">0</td>
		</tr>
		<tr>
			<td><strong>Total</strong></td>
			{foreach from=$hiringCoordinators item=hiringCoordinator}
				<td class="total-cell-{$hiringCoordinator.admin_id}">
					0
				</td>
			{/foreach}
			<td id="total-total">0</td>
		</tr>
	</thead>
	
</table>	