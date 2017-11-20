<h3 align="center" class="invoice_items_hdr" style="height:29px; line-height:29px; color:#FFFFFF;">Blank Invoice</h3>
<div id="invoice_form" style="padding:5px; border:#0000FF solid 1px;">
<p><label>Choose a Client :</label>
	<select name="leads_id" id="leads_id" class="text">
		<option value="0">--Choose Client--</option>
		{foreach from=$clients item=client name=client}
		<option value="{$client.leads_id}">{$client.fname} {$client.lname} - {$client.email}</option>
		{/foreach}
	</select>
</p>
<p><label>Description :</label><input type="text" name="description" id="description" class="text" style="width:440px;" /></p>
<p><label>Choose Currency Rate</label>
<select name="currency" id="currency" class="text">
{foreach from=$currencies item=currency name=currency}
		<option value="{$currency.code}">{$currency.sign} - {$currency.code} - {$currency.currency|capitalize}</option>
{/foreach}
</select> 
</p>
<p><label>Invoice Month :</label><select name="invoice_month" id="invoice_month" class="text">
{$monthoptions}
</select></p>
<p><label>Invoice Year :</label><select name="invoice_year" id="invoice_year" class="text" >
{$yearoptions}
</select></p>

<p><input type="button" name="create" id="create_black_invoice_btn" value="Create" />&nbsp;
<input type="button" name="cancel" id="cancel" onclick="hideInvoiceForm();" value="Cancel"  />
</p>
</div>

<div id="blank_invoice_result"></div>