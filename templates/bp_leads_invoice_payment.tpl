<table id="table_payment_details" style="font-size: 12px;">
    <tr bgcolor="cccccc">
        <th>#</th><th>Leads Name</th><th>Leads ID</th><th>Leads Email</th><th>Description</th><th>Invoice ID</th><th>Payment ID</th><th>Currency</th><th>Amount</th><th>Date Paid</th>
    </tr>
    {foreach from=$leads_invoice_payment item=payment_detail name=payment_detail}
        <tr bgcolor="{cycle values="#eeeeee,#d0d0d0}">
            <td align="right">{$smarty.foreach.payment_detail.iteration}</td>
            <td>{$payment_detail.leads_fname|escape} {$payment_detail.leads_lname|escape}</td>
            <td align="right">{$payment_detail.leads_id}</td>
            <td>{$payment_detail.leads_email|escape}</td>
            <td>{$payment_detail.leads_invoice_description|escape}</td>
            <td align="right"><a href="" OnClick="javascript:window.open('leads_invoice.php?id={$payment_detail.leads_invoice_id}', '_blank', 'width=680,height=480'); return false;" style="text-decoration:none; color: blue;">{$payment_detail.leads_invoice_id}</a></td>
            <td align="right">{$payment_detail.id}</td>
            <td align="right">{$payment_detail.code|escape}</td>
            <td align="right">{$payment_detail.sign}{$payment_detail.amount}</td>
            <td align="right">{$payment_detail.date|escape}</td>
        </tr>
    {/foreach}
</table>
