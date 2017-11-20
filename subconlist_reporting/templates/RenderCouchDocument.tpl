<input type="button" id="export_btn" value="Export"  doc_id="{$doc_id}">
<table width="100%" cellpadding="3" cellspacing="1" bgcolor="#333333">
<tr>
    <td width="3%" style="color:#FFF; font-weight:bold;">#</td>
    <td width="20%" style="color:#FFF; font-weight:bold;">Staff Name</td>
    <td width="20%" style="color:#FFF; font-weight:bold;">Client Name</td>
    <td width="15%" align="center" style="color:#FFF; font-weight:bold;">Contract Status</td>
    <td width="11%" align="center" style="color:#FFF; font-weight:bold;">Starting Date</td>
    <td width="11%" align="center" style="color:#FFF; font-weight:bold;">End Date</td>
    <td width="10%" align="center" style="color:#FFF; font-weight:bold;">Log Hours</td>
    <td width="10%" align="center" style="color:#FFF; font-weight:bold;">Adjusted Hours</td>
</tr>
{foreach from=$staffs item=staff name=staff}
<tr bgcolor="#FFFFFF">
    <td>{$smarty.foreach.staff.iteration}</td>
    <td>{$staff.fname} {$staff.lname}</td>
    <td>{$staff.client_name}</td>
    <td align="center">{$staff.contract_status}</td>
    <td align="center">{$staff.starting_date|date_format}</td>
    <td align="center">{$staff.staff_contract_finish_date|date_format}</td>
    <td align="center">{$staff.total_log_hour}/hrs</td>
    <td align="center">{$staff.adj_hours}/hrs</td>
</tr>
{/foreach}
</table>