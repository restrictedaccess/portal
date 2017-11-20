<table align="center" border="1" cellpadding="4" >

<thead>
    <th>Contract Id</th>
    <th>Month</th>
    <th>Staff Name</th>
    <th>Job Designation</th>
    <th>Contract Status</th>
    <th>Staff Started Date</th>
    <th>Staff End Date</th>
    <th>Client Rate</th>
    <th>Staff Rate</th>
    <th>Adjusted Hours</th>
</thead>
<tbody>
{foreach from=$staffs item=staff name=staff}
<tr>
    <td align="center"><!--{$smarty.foreach.staff.iteration}-->{$staff.id}</td>
    <td align="center">{$month|date_format:"%B %Y"}</td>
    <td>{$staff.fname} {$staff.lname}</td>
    <td align="center">{$staff.job_designation}</td>
    <td align="center">{$staff.contract_status}</td>
    <td align="center">{$staff.starting_date|date_format}</td>
    <td align="center">{if $staff.staff_contract_finish_date}{$staff.staff_contract_finish_date|date_format}{else}N/A{/if}</td>
    <td valign="top">
    {foreach from=$staff.client_rates item=rate name=rate}
        <div>{$rate.work_status} <strong>{$rate.rate}</strong> {$rate.start_date|date_format} {if $rate.end_date}- {$rate.end_date|date_format}{/if}</div>
        <!--<pre>{$rate.sql}</pre>-->
    {/foreach}
    </td>
    <td valign="top">
    {if $staff.staff_rates}
        {foreach from=$staff.staff_rates item=rate name=rate}
            <div>{$rate.work_status} <strong>{$rate.rate}</strong> {$rate.start_date|date_format}</div>
        {/foreach}
    {/if}
    </td>
    <td>{$staff.adj_hours}/hrs</td>
</tr>
{/foreach}
</tbody>
</table>