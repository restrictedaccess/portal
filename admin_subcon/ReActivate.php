<?php
include '../conf/zend_smarty_conf.php';
include './admin_subcon_function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']==""){
	die("Admin id is missing");
}

$sql = $db->select()
    ->from('admin')
	->where('admin_id=?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if($admin['activate_inactive_staff_contracts'] == 'N'){
	die("You do not have the permission to reactivate staff contracts.");
}

$sql = $db->select()
    ->from(array('s' => 'subcontractors'))
	->join(array('p' => 'personal'), 'p.userid = s.userid', Array('fname', 'lname'))
	->join(array('l' => 'leads'), 'l.id = s.leads_id', Array('client_fname' => 'fname', 'client_lname' => 'lname', 'client_email' => 'email', 'csro_id'))
	->where('s.id =?', $_REQUEST['id']);
$subcon = $db->fetchRow($sql);


if($subcon['csro_id'] != ""){
	$sql = $db->select()
		->from('admin')
		->where('admin_id =?' , $subcon['csro_id']);
	$csro=$db->fetchRow($sql);
}
			
$data = array('status' => 'ACTIVE');
$history_changes = compareData($data , "subcontractors" , $_REQUEST['id']);

//reactivate contract, change the status
$where = "id = ".$_REQUEST['id'];
$db->update('subcontractors', $data , $where);


	

//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "Reactivated Staff Contract.<br>";
$changes .= "<b>Changes made : </b>.".$history_changes;
$data = array (
		'subcontractors_id' => $_REQUEST['id'], 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $_SESSION['admin_id'] ,
		'changes_status' => 'updated',
		'note' => 'Reactivated Staff Contract'
		);
$db->insert('subcontractors_history', $data);

//Send email
$body =  "<h3>REACTIVATED STAFF CONTRACT </h3>
			<p>Staff : ".$subcon['fname']." ".$subcon['lname']."</p>
			<p>Job Designation : ".$subcon['job_designation']."</p>
			<p>Working : ".$subcon['work_status']."</p>
			<p>Client : ".$subcon['client_fname']." ".$subcon['client_lname']."</p>
			<p>Reactivated by : ".$admin['admin_fname']." ".$admin['admin_lname']."</p>";

$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom($admin['admin_email'], $admin['admin_fname']." ".$admin['admin_lname']);

if(! TEST){
	$mail->setSubject(sprintf('STAFF CONTRACT REACTIVATED %s %s', $subcon['fname'], $subcon['lname']));
	$mail->addTo($admin['admin_email'], $admin['admin_fname']." ".$admin['admin_lname']);
	if($csro){
        $mail->addTo($csro['admin_email'], $csro['admin_fname']." ".$csro['admin_lname']);
	}
	$mail->addBcc('devs@remotestaff.com.au', 'devs');
    
}else{
	$mail->setSubject(sprintf('TEST STAFF CONTRACT REACTIVATED %s %s', $subcon['fname'], $subcon['lname']));
	$mail->addTo('devs@remotestaff.com.au', 'devs');
}


$mail->send($transport);

echo "ok";
?>