<table class="table table-striped table-bordered">
	<caption>{$caption}</caption>
	<thead>
		<tr>
			<th>Recruiter</th>
			<th>Custom</th>
			<th>ASL</th>
			<th>Project Based</th>
			<th>Trial</th>
			<th>Back Order</th>
			<th>Replacement</th>
			<th>Inhouse</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		
		{foreach from=$recruiters item=recruiter}
			<tr>
				<td>{$recruiter.admin_fname} {$recruiter.admin_lname}</td>
				<td id="custom_{$recruiter.admin_id}">0</td>
				<td id="asl_{$recruiter.admin_id}">0</td>
				<td id="projectbased_{$recruiter.admin_id}">0</td>
				<td id="trial_{$recruiter.admin_id}">0</td>
				<td id="backorder_{$recruiter.admin_id}">0</td>
				<td id="replacement_{$recruiter.admin_id}">0</td>
				<td id="inhouse_{$recruiter.admin_id}">0</td>
				<td id="total_{$recruiter.admin_id}">0</td>
			</tr>
		{/foreach}
		<tr>
			<td>Past Recruiter</td>
			<td id="custom_Resigned">0</td>
			<td id="asl_Resigned">0</td>
			<td id="projectbased_Resigned">0</td>
			<td id="trial_Resigned">0</td>
			<td id="backorder_Resigned">0</td>
			<td id="replacement_Resigned">0</td>
			<td id="inhouse_Resigned">0</td>
			<td id="total_Resigned">0</td>
			
			
		</tr>
		<tr>
			<td></td>
			<td id="total_custom">0</td>
			<td id="total_asl">0</td>
			<td id="total_projectbased">0</td>
			<td id="total_trial">0</td>
			<td id="total_backorder">0</td>
			<td id="total_replacement">0</td>
			<td id="total_inhouse">0</td>
			<td id="total_total">0</td>
			
		</tr>
	</tbody>
</table>	