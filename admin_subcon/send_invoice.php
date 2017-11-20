<?php
//exit;
include '../conf/zend_smarty_conf.php';
require_once('../lib/php-amqplib/amqp.inc');

$smarty = new Smarty();
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}



$leads_id = $_GET['leads_id'];
//echo $leads_id;

$data = array(
    'leads_id' => $leads_id, 
	'date_created' => $ATZ, 
	'admin_id' => $_SESSION['admin_id']
);
$db->insert('subcontractors_invoice_setup', $data);
$subcontractors_invoice_setup_id = $db->lastInsertId();


$sql = "SELECT s.id , s.userid, s.subcontractors_id FROM subcontractors_temp s WHERE s.temp_status = 'new' AND s.prepaid='yes' AND s.leads_id =". $leads_id;
//echo $sql;exit;
$staffs = $db->fetchAll($sql);
//echo count($staffs);exit;
$counter=0;
$new_setup =0; 
foreach($staffs as $staff){
    
	$sql = "SELECT COUNT(d.id)AS counter FROM subcontractors_invoice_setup_details d JOIN subcontractors_invoice_setup s ON s.id = d.subcontractors_invoice_setup_id WHERE d.subcontractors_id =".$staff['id']." GROUP BY d.subcontractors_id";
	//echo $sql."<br>";
	$counter = $db->fetchOne($sql);
	if($counter > 0){
	    $new_setup++;    
	}else{
	    $data = array(
	        'subcontractors_invoice_setup_id' => $subcontractors_invoice_setup_id, 
		    'subcontractors_id' => $staff['id']
	    );
	    $db->insert('subcontractors_invoice_setup_details', $data);
		$subcontractors_invoice_setup_details_id = $db->lastInsertId();
		
		

		$changes = 'Sent invoice';
		$data = array (
		    'date_change' => $ATZ, 
		    'changes' => $changes, 
		    'change_by_id' => $_SESSION['admin_id'] ,
		    'changes_status' => 'updated',
			'note' => 'awaiting payment'
	    );
		
		if($staff['subcontractors_id']){
		    $data['subcontractors_id'] = $staff['subcontractors_id'];
			$db->insert('subcontractors_history', $data);
		}else{
		    $data['subcontractors_id'] = $staff['id'];
			$db->insert('subcontractors_temp_history', $data);
		}
		
        
        
    }
}

include '../conf/invoice_rabbitmq_conf.php';
exit;
?>