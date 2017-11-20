<?php
//  2010-01-19  Michael Lacanilao <mike.lacanilao@remotestaff.com.au>

require_once("conf/zend_smarty_conf_root.php");
require_once('./lib/misc_functions.php');

$admin_id = getVar("admin_id");
$admin_status = getVar("admin_status");

$userid = getVar("userid");

if($_SESSION['admin_id']=="") {
        header("location:index.php");
}

if ($userid) {
$sql = $db->select()
            ->distinct()
            ->from(array('s' => 'subcontractors'), 'userid')
            ->joinLeft(array('p' => 'personal'), 's.userid = p.userid', array('lname', 'fname'))
            ->joinLeft(array('i' => 'subcon_bank_iremit_sterling_visa'), 's.userid = i.userid', array('iremit_card_number' => 'card_number', 'iremit_account_holders_name' =>'account_holders_name'))
            ->joinLeft(array('h' => 'subcon_bank_hsbc_remotestaff'), 's.userid = h.userid', array('hsbc_account_number' => 'account_number', 'hsbc_account_holders_name' => 'account_holders_name'))
            ->joinLeft(array('o' => 'subcon_bank_others'), 's.userid = o.userid', array('other_bank_name' => 'bank_name', 'other_bank_branch' => 'bank_branch', 'other_swift_address' => 'swift_address', 'other_bank_account_number' => 'bank_account_number', 'other_account_holders_name' => 'account_holders_name'))
            ->where('s.status = "ACTIVE" AND s.userid='.$userid);

$payment_details = $db->fetchAll($sql);
}

?>
<html>
<head>
<title>RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<style type="text/css">
#table_payment_details tr {padding:18px;}
#table_payment_details tr:hover {background-color: #FFFFCC;}
#table_payment_details td {border:1px solid #888;}
th {font-weight: bold; font-size: 12; text-align:right;padding-right:2px;font-family:sans-serif;padding:4px;};
</style>
</head>
<body bgcolor="#ffffff" topmargin="1" leftmargin="10" marginheight="10" marginwidth="10">
        <div style='font: bold 10pt verdana;background:#ccc;margin-bottom:4px;'>BANK DETAILS <span style='font-size:8pt;'>(<?php echo $payment_details[0]['fname']. ' '. $payment_details[0]['lname'];?>)</span></div>
        <div style='border:#f2cb40 solid 1px;width:450px;'>
        <table id="table_payment_details">
                <tr><th>HSBC Acct #:</th><td><?php echo $payment_details[0]['hsbc_account_number'];?></td></tr>
                <tr><th>HSBC Account Holders Name:</th><td> <?php echo $payment_details[0]['hsbc_account_holders_name'];?></td></tr>
                <tr><th>IRemit Card #:</th><td> <?php echo $payment_details[0]['iremit_card_number'];?></td></tr>
                <tr><th>IRemit Account Holders Name:</th><td> <?php echo $payment_details[0]['iremit_account_holders_name'];?></td></tr>
                <tr><th>Other Bank Name:</th><td> <?php echo $payment_details[0]['other_bank_name'];?></td></tr>
                <tr><th>Other Bank Branch:</th><td> <?php echo $payment_details[0]['other_bank_branch'];?></td></tr>
                <tr><th>Other Bank Swift Address:</th><td> <?php echo $payment_details[0]['other_swift_address'];?></td></tr>
                <tr><th>Other Bank Account #:</th><td> <?php echo $payment_details[0]['other_bank_account_number'];?></td></tr>
                <tr><th>Other Bank Account Holders Name:s</th><td> <?php echo $payment_details[0]['other_account_holders_name'];?></td></tr>
                
                
            </table>
        </div>
</body>
</html>
