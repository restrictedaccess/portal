<table align="center" cellpadding="5" cellspacing="3" border="1">
<tr>
    <td>Number</td>
    <td>Site</td>
    <td>Type</td>
    <td>Description</td>
    <td>&nbsp;</td>
</tr>
{foreach from=$contact_nos item=contact_no name=contact_no}
    <tr>
    	<td>{$contact_no.contact_no}</td>
        <td>{$contact_no.site}</td>
        <td>{$contact_no.type}</td>
        <td><em>{$contact_no.description}</em></td>
        <td><button class="btn edit_btn" contact_no_id="{$contact_no.id}">edit</button>
        <button class="btn del_btn" contact_no_id="{$contact_no.id}">remove</button></td>
    </tr>
{/foreach}
</table>