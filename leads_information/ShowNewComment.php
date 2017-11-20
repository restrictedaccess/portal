<?php
include '../conf/zend_smarty_conf.php';
include ('./AdminBPActionHistoryToLeads.php');
include ('./GetAdminBPNotes.php');

$smarty = new Smarty();

$invoice_id = $_REQUEST['invoice_id'];

if($invoice_id == "" or $invoice_id == NULL){
	echo "Invoice ID is Missing";
	exit;
}


$notes = GetAdminBPNotes($invoice_id);
echo $notes;
?>

