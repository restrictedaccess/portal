<?php
include './conf/zend_smarty_conf.php';
include './admin_subcon/subcon_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;



$couch_client = new couchClient($couch_dsn, 'staff_invoice');

/*
//$couch_client->key(74);
$couch_client->startkey(Array(74, Array(2011,12,1)));
$couch_client->endkey(Array(74, Array(2011,12,31)));
//$couch_client->limit(100);
//$couch_client->include_docs(TRUE);
$response = $couch_client->getView('invoice','userid_date_paid_or_approved');
echo "<pre>";
print_r($response);
echo "</pre>";

//var_dump($response->rows);
foreach($response->rows as $row){
    echo $row->value[0];
    echo $row->value[1];
	echo $row->value[2];
}

exit;
*/

$clients=array();

//get all clients with active staff
$sql = "SELECT COUNT(s.id)AS no_staff, s.leads_id , l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' GROUP BY s.leads_id ORDER BY l.fname;";
$active_clients = $db->fetchAll($sql);
foreach($active_clients as $client){
    //echo "(".$client['no_staff'].") ".$client['fname']." ".$client['lname']."<br>";
	//get client active staff
    $sql = "SELECT s.userid, p.fname, p.lname, s.client_price, s.php_monthly, s.work_status, staff_currency_id, currency FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status ='ACTIVE' AND  s.leads_id = ".$client['leads_id']." ORDER BY p.fname;";
	//echo $sql;exit;
	$active_staffs = $db->fetchAll($sql);
	//echo "<ol>";
	$staffs=array();
	foreach($active_staffs as $staff){
	    //echo sprintf('<li>%s %s %s</li>',$staff['userid'],$staff['fname'],$staff['lname']);
		if($staff['staff_currency_id']){
		    $sql = $db->select()
		        ->from('currency_lookup')
			    ->where('id =?', $staff['staff_currency_id']);
			$currency = $db->fetchRow($sql);	
		}
		//echo $staff['userid'];
		$couch_client->startkey(Array((int)$staff['userid'], Array(2011,12,1)));
        $couch_client->endkey(Array((int)$staff['userid'], Array(2011,12,31)));	
		$response = $couch_client->getView('invoice','userid_date_paid_or_approved');

		$staff_invoice_total_amount = 0;
		$invoice =array();
		foreach($response->rows as $row){
            //echo $row->value[0];
	        //echo $row->value[1];
			//echo $row->value[2];
			//echo "<hr>";
			//$staff_invoice_total_amount = $staff_invoice_total_amount + $row->value[2];
			$data= array(
			    'invoice_id' => $row->value[0],
				'currency' => $row->value[1],
				'total_amount' => $row->value[2]    
			);
			array_push($invoice,$data);
        }
		//echo "<pre>";
		//print_r($invoice);
		//echo "</pre>";
		$data= array(
		    'userid' => $staff['userid'],
			'staff_name' => $staff['fname']." ".$staff['lname'],
			'client_price' => $staff['currency']." ".$staff['client_price'],
			'staff_monthly' => $currency['code']." ".$staff['php_monthly'],
			'work_status' => $staff['work_status'],
			'staff_invoice_amount' => '0',
			'invoice' => $invoice
		);
		array_push($staffs,$data);
	}
	//echo "</ol>";
	
	//get client december 2011 invoices
	$dec_total_amount = 0;
	$sql="SELECT invoice_number, total_amount, status, currency FROM client_invoice WHERE (status = 'posted' OR status='paid') AND leads_id =" .$client['leads_id']." AND MONTH(invoice_date)='12' AND YEAR(invoice_date) ='2011'  ORDER BY draft_date DESC;";
	$dec_invoices = $db->fetchAll($sql);
	foreach($dec_invoices as $invoice){
	     $dec_total_amount = $dec_total_amount + $invoice['total_amount'];
	}
	
	//get client january 2012 invoices
	$jan_total_amount = 0;
	$sql="SELECT invoice_number, total_amount, status, currency FROM client_invoice WHERE (status = 'posted' OR status='paid') AND leads_id =" .$client['leads_id']." AND MONTH(invoice_date)='1' AND YEAR(invoice_date) ='2012'  ORDER BY draft_date DESC;";
	$jan_invoices = $db->fetchAll($sql);
	foreach($jan_invoices as $invoice){
	     $jan_total_amount = $jan_total_amount + $invoice['total_amount'];
	}
	
	
	if($bgcolor == '#FFFFCC' ){
	    $bgcolor = '#CCFFCC';
	}else{
	    $bgcolor = '#FFFFCC';
	}
	
	$data= array(
	    'no_of_staff' => count($active_staffs),
		'leads_id' => $client['leads_id'],
		'fname' => $client['fname'],
		'lname' => $client['lname'],
		'email' => $client['email'],
		'staffs' => $staffs,
		'dec_invoices' => $dec_invoices,
		'jan_invoices' => $jan_invoices,
		'bgcolor' => $bgcolor,
		'dec_total_amount' => $dec_total_amount,
		'jan_total_amount' => $jan_total_amount
		//'staff_invoice_total_amount' => $staff_invoice_total_amount
	);
	array_push($clients,$data);
	
}

$smarty->assign('clients', $clients);
$smarty->display('invoicing_report.tpl');
?>