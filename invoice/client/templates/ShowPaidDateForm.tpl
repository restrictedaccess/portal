<h3 align="center" class="invoice_items_hdr" style="height:24px; line-height:24px; color:#FFFFFF;">Move to Paid Section</h3>
<div style="padding:20px;">
Paid Date<br />
<input type="text" name="invoice_paid_date_str" id="invoice_paid_date_str" value="{$paid_date|date_format:'%Y-%m-%d'}" class="text" readonly="true">&nbsp;
<img align="absmiddle" src="images/calendar_ico.png" id="invoice_invoice_paid_date_btn" style="cursor: pointer; "  /> <input type="button" id="update_paid_date" invoice_id="{$id}" value="Continue" /> <input type="button" value="Close"  onclick="fade('invoice_paid_date_form')" />
</div>