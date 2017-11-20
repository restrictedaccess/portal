<table>
    <tr>
        <td align="right">Contact No. </td>
        <td><input type="text" value="{$contact_no.contact_no}" name="contact_no" id="contact_no" /></td>
    </tr>
    <tr>
        <td align="right">Description </td>
        <td><input type="text" value="{$contact_no.description}" name="description" id="description" /></td>
    </tr>
    <tr>
        <td align="right">Site {$contact_no.site}</td>
        <td><select name="site" id="site">
        {foreach from=$sites key=k item=v}
        	<option { if $contact_no.site eq $k} selected="selected" {/if} value="{$k}">{$v}</option>
        {/foreach}
        </select>
        </td>
    </tr>
    
    <tr>
        <td align="right">Type </td>
        <td><select name="type" id="type">
            {foreach from=$types item=type name=type}
                <option { if $contact_no.type eq $type} selected="selected" {/if} value="{$type}">{$type|capitalize}</option>
            {/foreach}
        </select>
        </td>
    </tr>
    
</table>