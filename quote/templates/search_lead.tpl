<p><strong>Search Result</strong></p>
<ol>
{foreach from=$leads item= l name=l}
<li><input type="radio" name="leads" class="leads_selection" value="{$l.id}" /><span style="text-transform:capitalize;">#{$l.id} {$l.fname} {$l.lname}</span> {$l.email}</li>
{foreachelse}
<li><input type="radio" name="leads" class="leads_selection" disabled="disabled"  />No records found...</li>
{/foreach}
</ol>

<p><input type="button" id="close_btn" value="Close" /></p>