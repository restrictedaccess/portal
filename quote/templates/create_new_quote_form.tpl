<div align="center">
<input type="text" name="str" id="str" />
<select name="search_by" id="search_by">
<option value="keyword">Keyword</option>
<option value="id">ID</option>
<option value="fname">First Name</option>
<option value="lname">Last Name</option>
<option value="email">Email</option>
<input type="button" value="Search" id="search_lead_btn" />
</select>
</div>


<div id="create_new_quote">
{if $lead}
<p><strong>Lead Information</strong></p>
<p style="text-transform:capitalize;"><label>Name :</label> <input type="hidden" name="id" id="id" value="{$lead.id}" />#{$lead.id} {$lead.fname} {$lead.lname}</p>
<p><label>Email :</label> {$lead.email}</p>
<!--
<p><label>Currency :</label> <select name="currency" id="currency">
{foreach from=$currencies name=c item=c}
    <option value="{$c}">{$c}</option>
{/foreach}
</select>
</p>
-->
<p><input type="button" id="generate_btn" value="Generate Quote" /> <input type="button" id="close_btn" value="Close" /></p>
{/if}
</div>