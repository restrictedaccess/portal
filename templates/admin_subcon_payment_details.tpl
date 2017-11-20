{*
2010-11-26  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   patch to accomodate changes on admin_header_menu.php
2010-09-07  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   add link to modify the bank account details
2010-09-06  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   add sterling bank of asia
2010-04-26  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
-   Add IRemit Sender
*}
<html>
<head>
    <title>Sub-Contractors PAYMENT DETAILS</title>
    <link rel=stylesheet type=text/css href="css/font.css">
    <link rel=stylesheet type=text/css href="adminmenu.css">
<style type="text/css">
{literal}
    #table_payment_details tr:hover {background-color: #FFFFCC;}
    th {font-weight: bold; font-size: 12; color: white; background: #888888;}
    .edit_bank_details {color: blue; cursor: pointer;}
{/literal}
</style>
</head>
<body style="margin-top:0; margin-left:0">
{php}include("header.php"){/php}
{php}include("conf/zend_smarty_conf.php"){/php}
{php}include("admin_header_menu.php"){/php}

<table width=100% cellpadding=0 cellspacing=0 border=0>
    <tr>
        <td bgcolor="#666666" height="25" colspan=2><font color='#FFFFFF'><b>Sub-Contractors PAYMENT DETAILS</b></font></td>
    </tr>
    <tr>
        <td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
            {php}include("adminleftnav.php"){/php}
        </td>
        <td width=100% valign=top>
            <a href="{php}echo $_SEVER['PHP_SELF'].'?csv=y';{/php}">EXPORT TO CSV</a><br/>
            <table id="table_payment_details">
                <th>#</th><th>Sub-Contractor's Name</th><th>Userid #</th><th>Sterling Card #</th><th>Sterling Account Holders Name</th><th>HSBC Acct #</th><th>HSBC Account Holders Name</th><th>IRemit Card #</th><th>IRemit Account Holders Name</th><th>IRemit Sender</th><th>Other Bank Name</th><th>Other Bank Branch</th><th>Other Bank Swift Address</th><th>Other Bank Account #</th><th>Other Bank Account Holders Name</th><th>Address of Beneficiary</th><th>Contact Number Beneficiary</th>
                {foreach from=$payment_details item=payment_detail name=payment_detail}
                    <tr bgcolor="{cycle values="#eeeeee,$d0d0d0}">
                        <td>{$smarty.foreach.payment_detail.iteration}</td>
                        <td class='edit_bank_details'><a href="/portal/admin_bank_account_details.php?userid={$payment_detail.userid}" target="_new" style="text-decoration: none; color: blue;">{$payment_detail.fname|escape} {$payment_detail.lname|escape}</a></td>
                        <td class='edit_bank_details'><a href="/portal/admin_bank_account_details.php?userid={$payment_detail.userid}" target="_new" style="text-decoration: none; color: blue;">{$payment_detail.userid}</a></td>
                        <td>{$payment_detail.sterling_card_number|escape}</td>
                        <td>{$payment_detail.sterling_account_holders_name|escape}</td>
                        <td>{$payment_detail.hsbc_account_number|escape}</td>
                        <td>{$payment_detail.hsbc_account_holders_name|escape}</td>
                        <td>{$payment_detail.iremit_card_number|escape}</td>
                        <td>{$payment_detail.iremit_account_holders_name|escape}</td>
                        <td>{$payment_detail.iremit_sender_lname|escape}, {$payment_detail.iremit_sender_fname|escape}</td>
                        <td>{$payment_detail.other_bank_name|escape}</td>
                        <td>{$payment_detail.other_bank_branch|escape}</td>
                        <td>{$payment_detail.other_swift_address|escape}</td>
                        <td>{$payment_detail.other_bank_account_number|escape}</td>
                        <td>{$payment_detail.other_account_holders_name|escape}</td>
                        <td>{$payment_detail.address1|escape}, {$payment_detail.address2|escape}, {$payment_detail.city|escape}, {$payment_detail.postcode|escape}</td>
                        <td>+{$payment_detail.handphone_country_code|escape} {$payment_detail.handphone_no|escape} / ({$payment_detail.tel_area_code|escape}) {$payment_detail.tel_no|escape}</td>
                    </tr>
                {/foreach}
            </table>
        </td>
    </tr>
</table>

{php}include("footer.php"){/php}
</body>
<script src="/portal/js/MochiKit.js" language="javascript"></script>
{literal}
<script language="javascript">
    var refresh_flag = false;

    function DelayRefresh() {
        refresh_flag = true;
    }

    function OnClickEditBankDetails(e) {
        refresh_flag = false;
        setTimeout("DelayRefresh()", 3000);
    }

    bank_details = getElementsByTagAndClassName('td', 'edit_bank_details');
    for (var i = 0; i<bank_details.length; i++) {
        connect(bank_details[i], 'onclick', OnClickEditBankDetails);
    }

    function RefreshPage(e) {
        if (refresh_flag) {
            window.location.reload();
        }
    }

    connect('table_payment_details', 'onmousemove', RefreshPage);
</script>
{/literal}
</html>
