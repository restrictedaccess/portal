{php}include("conf/zend_smarty_conf.php"){/php}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SECURE PAY/PAYPAL PAYMENTS MADE BY LEADS</title>
    <link rel="stylesheet" type="text/css" href="css/font.css">
    <link rel="stylesheet" type="text/css" href="adminmenu.css">

<style type="text/css">
{literal}
    #table_payment_details tr:hover {background-color: #FFFFCC;}
    th {font-weight: bold; font-size: 12; color: white; background: #888888;};
{/literal}
</style>
</head>
<body style="margin-top:0; margin-left:0">
{php}include("header.php"){/php}
{php}include("admin_header_menu.php"){/php}
<div style="clear: both;"></div>

<!-- overlayed element -->
<div class="apple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>

</div>

<table width=100% cellpadding=0 cellspacing=0 border=0>
    <tr>
        <td bgcolor="#666666" height="25" colspan=2><font color='#FFFFFF'><b>SECURE PAY/PAYPAL PAYMENTS MADE BY LEADS</b></font></td>
    </tr>
    <tr>
        <td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
            {php}include("adminleftnav.php"){/php}
        </td>
        <td width=100% valign=top>
            <table id="table_payment_details">
                <th>#</th><th>Leads Name</th><th>Leads ID</th><th>Leads Email</th><th>Description</th><th>Invoice ID</th><th>Payment ID</th><th>Payment Mode</th><th>Currency</th><th>Amount</th><th>Date Paid</th>
                {foreach from=$leads_invoice_payment item=payment_detail name=payment_detail}
                    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0}">
                        <td align="right">{$smarty.foreach.payment_detail.iteration}</td>
                        <td>{$payment_detail.leads_fname|escape} {$payment_detail.leads_lname|escape}</td>
                        <td align="right">{$payment_detail.leads_id}</td>
                        <td>{$payment_detail.leads_email|escape}</td>
                        <td>{$payment_detail.leads_invoice_description|escape}</td>
                        <td align="right"><a href="" OnClick="javascript:window.open('leads_invoice.php?id={$payment_detail.leads_invoice_id}', '_blank', 'width=680,height=480'); return false;" style="text-decoration:none; color: blue;">{$payment_detail.leads_invoice_id}</a></td>
                        <td align="right">{$payment_detail.id}</td>
                        <td align="right">{$payment_detail.payment_mode}</td>
                        <td align="right">{$payment_detail.code|escape}</td>
                        <td align="right">{$payment_detail.sign}{$payment_detail.amount}</td>
                        <td align="right" nowrap="nowrap">{$payment_detail.date|escape}</td>
                    </tr>
                {/foreach}
            </table>
        </td>
    </tr>
</table>


{php}include("footer.php"){/php}
</body>
</html>
