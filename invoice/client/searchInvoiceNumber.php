<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$keyword=$_REQUEST['invoice_no_str'];
$search = strtoupper(preg_replace('/\s+/', '|', trim($keyword))); 
# create a MySQL REGEXP for the search: 
//$regexp = "REGEXP '^.*($search).*\$'"; 
$regexp = "LIKE '$search'";
$keyword_search = " AND (
                c.invoice_number $regexp 
				) ";

$sql="SELECT id, description, status FROM client_invoice c WHERE status = 'draft' $keyword_search ORDER BY draft_date DESC;";
//echo $sql;exit;
$draft_invoices = $db->fetchAll($sql);


$sql="SELECT id, description, status FROM client_invoice c WHERE status = 'posted' AND invoice_payment_due_date > '$AusDate' $keyword_search ORDER BY draft_date DESC;";
$posted_invoices = $db->fetchAll($sql);


$sql="SELECT id, description, status FROM client_invoice c WHERE status = 'posted' AND invoice_payment_due_date <= '$AusDate' $keyword_search ORDER BY draft_date DESC;";
//echo $sql;
$overdue_invoices = $db->fetchAll($sql);

$sql="SELECT id, description, status FROM client_invoice c WHERE status = 'paid' $keyword_search ORDER BY draft_date DESC;";
$paid_invoices = $db->fetchAll($sql);

$smarty->assign('draft_invoices',$draft_invoices);
$smarty->assign('posted_invoices',$posted_invoices);
$smarty->assign('overdue_invoices',$overdue_invoices);
$smarty->assign('paid_invoices',$paid_invoices);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('ShowAllClientInvoiceList.tpl');