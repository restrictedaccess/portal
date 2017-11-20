<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$table = $_REQUEST['table'];
$status = $_REQUEST['status'];

if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
}

if($table == "client_invoice"){
	$label = "CLIENT";
	if($status == "paid"){
		$sql = "SELECT c.id, (c.leads_id)AS type_id, c.description, c.status, l.fname, l.lname, l.email , invoice_payment_due_date, invoice_number FROM client_invoice c JOIN leads l ON l.id = c. leads_id WHERE c.status = 'paid' AND invoice_date BETWEEN '".$from."' AND '".$to."';";
	}else{
		if($status == "overdue"){
			$sql = "SELECT c.id, (c.leads_id)AS type_id, c.description,c.status, l.fname, l.lname, l.email , invoice_payment_due_date, invoice_number FROM client_invoice c JOIN leads l ON l.id = c. leads_id WHERE c.status = 'posted' AND invoice_payment_due_date < '".date("Y-m-d")."' AND invoice_date BETWEEN '".$from."' AND '".$to."';";
		}else if($status == "due date today"){
			$sql = "SELECT c.id, (c.leads_id)AS type_id, c.description,c.status, l.fname, l.lname, l.email , invoice_payment_due_date, invoice_number FROM client_invoice c JOIN leads l ON l.id = c. leads_id WHERE c.status = 'posted' AND invoice_payment_due_date = '".date("Y-m-d")."' AND invoice_date BETWEEN '".$from."' AND '".$to."';";
		}else{
			$sql = "SELECT c.id, (c.leads_id)AS type_id, c.description,c.status, l.fname, l.lname, l.email , invoice_payment_due_date, invoice_number FROM client_invoice c JOIN leads l ON l.id = c. leads_id WHERE c.status = 'posted' AND invoice_payment_due_date > '".date("Y-m-d")."' AND invoice_date BETWEEN '".$from."' AND '".$to."' ;";
		}
	}
	
	
}else{
	$label = "SUBCON";
	$sql = "SELECT s.id, (s.userid)AS type_id , s.description , s.status , p.fname, p.lname , p.email FROM subcon_invoice s JOIN personal p ON p.userid = s.userid WHERE s.status = '".$status."' AND invoice_date BETWEEN '".$from."' AND '".$to."';";
	
}

//echo $sql."<br>";
$invoices = $db->fetchAll($sql);
$smarty->assign('table',$table);
$smarty->assign('invoices',$invoices);
$smarty->assign('label',$label);
$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->assign('status',$status);
$smarty->display('ViewInvoice.tpl');
