<h2 align="center">#{ $client.client.id } { $client.client.fname } { $client.client.lname } - { $client.client.email }</h2>
<p align="center" style="color:#666;">CSRO : #{$client.client.admin_id} {$client.client.admin_fname}  {$client.client.admin_lname}</p>
<p>Subcontractors:</p>
<table width="70%" bgcolor="#CCCCCC" cellpadding="2" cellspacing="1" >
<tr bgcolor="#333333" >
<td style="color:#FFF;">Staff Name</td>
<td style="color:#FFF;">Status</td>
<td style="color:#FFF;">Start Date</td>
<td style="color:#FFF;">End Date</td>
</tr>
{foreach from=$client.subcons name=subcon item=subcon}
    <tr bgcolor="#FFFFFF" >
        <td >{$subcon.userid} {$subcon.fname} {$subcon.lname}</td>
        <td >{$subcon.contract_status}</td>
        <td >{$subcon.starting_date}</td>
        <td >
        {if $subcon.contract_status neq 'ACTIVE'}
            {if $subcon.contract_status eq 'terminated'}
                {$subcon.date_terminated}
            {/if}
            {if $subcon.contract_status eq 'resigned'}
                {$subcon.resignation_date}
            {/if}
        {/if}    
        </td>
    </tr>

{/foreach}
</table>

<p>CSRO Name Changes:</p>
<table width="70%" bgcolor="#CCCCCC" cellpadding="2" cellspacing="1" >
<tr bgcolor="#333333" >
<td style="color:#FFF;">CSRO Changes</td>
<td style="color:#FFF;">Made By</td>
<td style="color:#FFF;">Date</td>
</tr>
{foreach from=$client.histories name=history item=history}
    <tr bgcolor="#FFFFFF" >
        <td >{$history.csro_changes}</td>
        <td >{$history.changes_made_by}</td>
        <td >{$history.date_change}</td>
    </tr>
{/foreach}
</table>

</ol>