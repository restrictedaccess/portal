<?php
include '../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty();

//new
//get all regulat clients
$regular_clients = array();
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors_temp s JOIN leads l ON l.id = s.leads_id  WHERE s.temp_status = 'new' AND s.prepaid='no' GROUP BY leads_id ORDER BY l.fname;";
$reg_clients = $db->fetchAll($sql);
foreach($reg_clients as $client){
    //get subcontracted staffs
    $sql = "SELECT s.id , s.userid,  DATE_FORMAT(s.starting_date , '%D %b %Y %r')AS starting_date , CONCAT(p.fname,' ',p.lname )AS staff_name FROM subcontractors_temp s LEFT JOIN personal p ON p.userid = s.userid WHERE s.temp_status = 'new' AND s.prepaid='no' AND s.leads_id =". $client['leads_id']. " ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
    $data = array(
	    'leads_id' => $client['leads_id'],
		'client_name' => sprintf('%s %s', $client['fname'], $client['lname']),
		'staffs' => $staffs
	);
	array_push($regular_clients, $data);
}

//get all prepaid clients
$prepaid_clients = array();
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors_temp s JOIN leads l ON l.id = s.leads_id  WHERE s.temp_status = 'new' AND s.prepaid='yes' GROUP BY leads_id ORDER BY l.fname;";
$pre_clients = $db->fetchAll($sql);
foreach($pre_clients as $client){
    //get subcontracted staffs
    $sql = "SELECT s.id , s.userid,  DATE_FORMAT(s.starting_date , '%D %b %Y %r')AS starting_date , CONCAT(p.fname,' ',p.lname )AS staff_name, s.starting_date FROM subcontractors_temp s LEFT JOIN personal p ON p.userid = s.userid WHERE s.temp_status = 'new' AND s.prepaid='yes' AND s.leads_id =". $client['leads_id']. " ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
	$client_staffs = array();
	$counter=0;
	$count=0;
	$paid=0;
	$enabled_button = False;
	$starting_date_empty = 0;
	foreach($staffs as $staff){
	    $status ='';
		$sql = "SELECT COUNT(d.id)AS counter, s.status FROM subcontractors_invoice_setup_details d JOIN subcontractors_invoice_setup s ON s.id = d.subcontractors_invoice_setup_id WHERE d.subcontractors_id =".$staff['id']." GROUP BY d.subcontractors_id";
	    //echo $sql."<br>";
	    $invoice = $db->fetchRow($sql);
		
	    if($invoice['counter'] > 0){
	        $count++;    
	    }
		
		if($invoice['status'] == 'paid'){
	        $paid++;    
	    }
		
		$data= array(
		    'id' => $staff['id'],
			'userid' => $staff['userid'],
			'starting_date' => $staff['starting_date'],
			'staff_name' => $staff['staff_name'],
			'counter' => $invoice['counter'],
			'status' => $invoice['status'] 
		);
		
		array_push($client_staffs, $data);
	}
	
	if($count == count($staffs)){
	    $enabled_button = True;
	}
    $data = array(
	    'leads_id' => $client['leads_id'],
		'client_name' => sprintf('%s %s', $client['fname'], $client['lname']),
		'staffs' => $client_staffs,
		'no_of_staff' => count($staffs),
		'no_invoiced_staff' => $count,
		'no_of_paid_staff' => $paid
	);
	array_push($prepaid_clients, $data);
}




//edited/updated
$updated_prepaid_contracts = array();
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors_temp s JOIN leads l ON l.id = s.leads_id  WHERE s.temp_status = 'updated' AND s.prepaid='yes' GROUP BY leads_id ORDER BY l.fname;";
//echo $sql;
$clients = $db->fetchAll($sql);
foreach($clients as $client){
    //get subcontracted staffs
    $sql = "SELECT s.id , s.userid,  DATE_FORMAT(s.starting_date , '%D %b %Y %r')AS starting_date , CONCAT(p.fname,' ',p.lname )AS staff_name FROM subcontractors_temp s LEFT JOIN personal p ON p.userid = s.userid WHERE s.temp_status = 'updated' AND s.prepaid='yes' AND s.leads_id =". $client['leads_id']. " ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
    $data = array(
	    'leads_id' => $client['leads_id'],
		'client_name' => sprintf('%s %s', $client['fname'], $client['lname']),
		'staffs' => $staffs
	);
	array_push($updated_prepaid_contracts, $data);
}

$updated_regular_contracts = array();
$sql = "SELECT s.leads_id, l.fname, l.lname FROM subcontractors_temp s JOIN leads l ON l.id = s.leads_id  WHERE s.temp_status = 'updated' AND s.prepaid='no' GROUP BY leads_id ORDER BY l.fname;";
//echo $sql;
$clients = $db->fetchAll($sql);
foreach($clients as $client){
    //get subcontracted staffs
    $sql = "SELECT s.id , s.userid,  DATE_FORMAT(s.starting_date , '%D %b %Y %r')AS starting_date , CONCAT(p.fname,' ',p.lname )AS staff_name FROM subcontractors_temp s LEFT JOIN personal p ON p.userid = s.userid WHERE s.temp_status = 'updated' AND s.prepaid='no' AND s.leads_id =". $client['leads_id']. " ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
    $data = array(
	    'leads_id' => $client['leads_id'],
		'client_name' => sprintf('%s %s', $client['fname'], $client['lname']),
		'staffs' => $staffs
	);
	array_push($updated_regular_contracts, $data);
}


$smarty->assign('regular_clients',$regular_clients);
$smarty->assign('prepaid_clients', $prepaid_clients);

$smarty->assign('updated_prepaid_contracts', $updated_prepaid_contracts);
$smarty->assign('updated_regular_contracts', $updated_regular_contracts);

$smarty->display('showAllStaffContractList.tpl');
?>