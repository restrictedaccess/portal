<h3 align="center" class="invoice_items_hdr" style="height:29px; line-height:29px; color:#FFFFFF;">{$method|capitalize} Invoice Item</h3>
<div style="padding:5px;">
<p><label>Start Date :</label><input type="text" name="start_date" id="start_date" value="{$invoice_item.start_date}" class="text" readonly="true">&nbsp;
<img align="absmiddle" src="images/calendar_ico.png" id="cal_start_date" style="cursor: pointer; "  /> <small>(optional)</small>
</p>
<p><label>End Date :</label><input type="text" name="end_date" id="end_date" value="{$invoice_item.end_date}" class="text" readonly="true">&nbsp;
<img align="absmiddle" src="images/calendar_ico.png" id="cal_end_date" style="cursor: pointer; "  /> <small>(optional)</small>
</p>
<p><label>Description :</label><input type="text" name="description" id="description" value="{$invoice_item.decription}" class="text" style=" width:330px;"></p>
<p><label>Amount :</label><input type="text" name="amount" id="amount" value="{$invoice_item.amount}" class="text"></p>
<p>{if $method eq 'add'}<input type="button" value="Add" id="save_invoice_item" invoice_id="{$id}" />{else} <input type="button" value="Update" id="update_invoice_item" invoice_id="{$id}" item_id="{$invoice_item.id}" /> {/if}&nbsp;<input type="button" value="Close" onclick="fade('edit_div');" /></p>
</div>