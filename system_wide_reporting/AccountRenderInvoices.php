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

if(!$from){
	$from = date("Y-m-d");
}

if(!$to){
	$to = $from;
}

include 'FirstInvoice.php';

$client_invoice_paid=0;
$client_invoice_posted=0;
$client_invoice_due_date_today =0;
$client_invoice_overdue=0;
//$sql = "SELECT DISTINCT(status)as status , count(id)as count FROM client_invoice c WHERE invoice_date BETWEEN '".$from."' AND '".$to."' group by status;";
$sql = "SELECT id, status,invoice_payment_due_date FROM client_invoice c WHERE invoice_date BETWEEN '".$from."' AND '".$to."';";
//echo $sql;
$invoices_status = $db->fetchAll($sql);
foreach($invoices_status as $invoice_status){
	
	if($invoice_status['status'] == 'paid'){
		$client_invoice_paid++;
		
	}else if($invoice_status['status'] == 'posted'){
	
		if($invoice_status['invoice_payment_due_date']){
			if(date("Y-m-d") < $invoice_status['invoice_payment_due_date']){
				$client_invoice_posted++;
			}else if (date("Y-m-d") == $invoice_status['invoice_payment_due_date']){
				$client_invoice_due_date_today++;
				//echo $invoice_status['id']."<br>";
			}else{
				$client_invoice_overdue++;
			}
		}	
	}
}

$det = new DateTime($from);
$from_str = $det->format("F j, Y");
$from_year = $det->format("Y");

$det = new DateTime($to);
$to_str = $det->format("F j, Y");
$to_year = $det->format("Y");


//client invoice
//echo $from_year." ".$to_year;
for($year=2008 ; $year <= date("Y");$year++){
	//echo $year."<br>";
	
		$sql = "SELECT DISTINCT(status)as status , count(id)as count FROM client_invoice c WHERE YEAR(invoice_date) = '".$year."' group by status;";
		$yearly_invoices_status = $db->fetchAll($sql);
		if(count($yearly_invoices_status)>0){
			$year_report_str .="<div class='line'>";
			$year_report_str .="<b>".$year."</b>";
			$year_report_str .="<ul>";
				foreach($yearly_invoices_status as $yearly){
					$year_report_str .="<li>".$yearly['status']." : ".$yearly['count']."</li>";
				}
			$year_report_str .="</ul>";
			$year_report_str .="</div>";
		}
		
		$sql = "SELECT DISTINCT(status)as status , count(id)as count FROM subcon_invoice WHERE YEAR(invoice_date) = '".$year."' group by status;";
 		$subcon_yearly_invoices_status = $db->fetchAll($sql);
		if(count($subcon_yearly_invoices_status)>0){
			$subcon_year_report_str .="<div class='line'>";
			$subcon_year_report_str .="<b>".$year."</b>";
			$subcon_year_report_str .="<ul>";
				foreach($subcon_yearly_invoices_status as $yearly){
					$subcon_year_report_str .="<li>".$yearly['status']." : ".$yearly['count']."</li>";
				}
			$subcon_year_report_str .="</ul>";
			$subcon_year_report_str .="</div>";
		}
	
}
//client invoice  
//invoice_payment_due_date
$sql = "SELECT COUNT(id)as count FROM client_invoice c WHERE status = 'posted' AND invoice_payment_due_date < '".date("Y-m-d")."'  group by status";
//echo $sql;
$overdue_client_invoice_count = $db->fetchOne($sql);

//staff invoice
$sql = "SELECT DISTINCT(status)as status , count(id)as count FROM subcon_invoice WHERE invoice_date BETWEEN '".$from."' AND '".$to."' group by status;";
//echo $sql;
$subcon_invoices_status = $db->fetchAll($sql);


$smarty->assign('client_invoice_paid',$client_invoice_paid);
$smarty->assign('client_invoice_posted',$client_invoice_posted);
$smarty->assign('client_invoice_due_date_today',$client_invoice_due_date_today);
$smarty->assign('client_invoice_overdue',$client_invoice_overdue);


$smarty->assign('subcon_invoices_status' , $subcon_invoices_status);
$smarty->assign('overdue_client_invoice_count',$overdue_client_invoice_count);
$smarty->assign('year_report_str',$year_report_str);
$smarty->assign('subcon_year_report_str',$subcon_year_report_str);
//$smarty->assign('invoices_status',$invoices_status);
$smarty->assign('from_str',$from_str);
$smarty->assign('to_str',$to_str);
$smarty->assign('from',$from);
$smarty->assign('to',$to);
$smarty->display('AccountRenderInvoices.tpl');
?>