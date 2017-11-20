{foreach from=$contact_nos item=contact_no name=contact_no}
    <li id="li_list_{$contact_no.id}">
        <input type="text" value="{$contact_no.contact_no}" name="contact_no[]" id="contact_no_{$contact_no.id}" /> 
        <input type="text" value="{$contact_no.description}" name="description[]" id="description_{$contact_no.id}" /> 
        <button class="btn update_btn" id="update_btn_{$contact_no.id}" onClick="update_contact_no({$contact_no.id})">update</button>
        <button class="btn" id="delete_btn_{$contact_no.id}" onClick="delete_contact_no({$contact_no.id})" >delete</button>
    </li>
{/foreach}
