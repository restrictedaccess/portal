<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$client = $_REQUEST['client'];

$AusDate = date("Y")."-".date("m")."-".date("d");

if($client > 0){
	$condition = " AND leads_id =" .$client ;
}else{
	$condition ="";
}

if($month>0){
	$month_condition = " AND MONTH(invoice_date) = $month";
}else{
	$month_condition = "";
}

if($year >0){
	$year_condition=" AND YEAR(invoice_date) = $year";
}else{
	$year_condition="";
}


$sql="SELECT id, description, status FROM client_invoice WHERE status = 'draft' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$draft_invoices = $db->fetchAll($sql);


$sql="SELECT id, description, status FROM client_invoice WHERE status = 'posted' AND invoice_payment_due_date > '$AusDate' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$posted_invoices = $db->fetchAll($sql);


$sql="SELECT id, description, status FROM client_invoice WHERE status = 'posted' AND invoice_payment_due_date <= '$AusDate' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
//echo $sql;
$overdue_invoices = $db->fetchAll($sql);

$sql="SELECT id, description, status FROM client_invoice WHERE status = 'paid' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$paid_invoices = $db->fetchAll($sql);

//deleted
$sql="SELECT id, description, status FROM client_invoice WHERE status = 'deleted' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$deleted_invoices = $db->fetchAll($sql);



$smarty->assign('draft_invoices',$draft_invoices);
$smarty->assign('posted_invoices',$posted_invoices);
$smarty->assign('overdue_invoices',$overdue_invoices);
$smarty->assign('paid_invoices',$paid_invoices);
$smarty->assign('deleted_invoices',$deleted_invoices);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('ShowAllClientInvoiceList.tpl');