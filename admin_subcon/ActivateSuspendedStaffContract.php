<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $admin_id);
$admin = $db->fetchRow($sql);
$admin_email = $admin['admin_email'];	
$admin_name = sprintf('%s %s', $admin['admin_fname'], $admin['admin_lname']);

$subcontractors_id = $_REQUEST['subcontractors_id'];
$admin_notes = $_REQUEST['admin_notes'];

if($subcontractors_id == ""){
    die("Subcontractors.id is missing");
}

$sql= $db->select()
    ->from(array('s' => 'subcontractors'))
	->join(array('p' => 'personal'), 'p.userid = s.userid', Array('staff_email' => 'email', 'staff_fname' => 'fname', 'staff_lname' => 'lname'))
	->join(array('l' => 'leads'), 'l.id = s.leads_id', Array('client_email' => 'email', 'client_fname' => 'fname', 'client_lname' => 'lname'))
	->where('s.id =?', $subcontractors_id);
$subcon =$db->fetchRow($sql);	


$data = array('status' => 'ACTIVE');
$where = "id = ".$subcontractors_id;
$db->update('subcontractors', $data , $where);

//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "Activated suspended staff contract. Status set to ACTIVE.";
$data = array (
		'subcontractors_id' => $subcontractors_id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $admin_id ,
		'changes_status' => 'updated',
		'note' => $admin_notes
		);
$db->insert('subcontractors_history', $data);
//print_r($data);



$details =  "<h3>ACTIVATED STAFF CONTRACT </h3>
			<p>Status : Suspended to ACTIVE </p>
			<p>Staff : ".sprintf('#%s %s %s', $subcon['userid'], $subcon['staff_fname'], $subcon['staff_lname'])."</p>
			<p>Job Designation : ".$subcon['job_designation']."</p>
			<p>Working : ".$subcon['work_status']."</p>
			<p>Client : ".sprintf('#%s %s %s', $subcon['leads_id'],$subcon['client_fname'],$subcon['client_lname'])."</p>
			<p>Approved by : ".sprintf('%s %s', $admin['admin_fname'], $admin['admin_lname'])."</p>";
			

if(! TEST){
	$subject = "STAFF ".$staff_name." CONTRACT ACTIVATED";
}else{
	$subject = "TEST STAFF ".$staff_name." CONTRACT ACTIVATED";
}


//send mail to admin
$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($details);
$mail->setFrom($admin_email, $admin_name);
$mail->setSubject($subject);
$mail->addTo('devs@remotestaff.com.au', 'devs');
$mail->send($transport);
			

/*
//send email to staff
$smarty->assign('subcon',$subcon);
$body = $smarty->fetch('staff_activation_autoresponder.tpl');

$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $admin_name);

if(! TEST){
	//admin email
	$to = $subcon['staff_email'];
	$fullname = sprintf('%s %s', $subcon['staff_fname'], $subcon['staff_lname']);
}else{
	$to = 'devs@remotestaff.com.au'; //replace devs@remotestaff.com.au
	$fullname = "Remotestaff Developers";
}

$mail->setSubject($subject);
$mail->addTo('devs@remotestaff.com.au', 'devs');
$mail->send($transport);


//send email to client
$smarty->assign('subcon',$subcon);
$body = $smarty->fetch('client_staff_activation_autoresponder.tpl');

$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $admin_name);

if(! TEST){
	//admin email
	$to = $subcon['client_email'];
	$fullname = sprintf('%s %s', $subcon['client_fname'],$subcon['client_lname']);
}else{
	$to = 'devs@remotestaff.com.au'; //replace devs@remotestaff.com.au
	$fullname = "Remotestaff Developers";
}

$mail->setSubject($subject);
$mail->addTo('devs@remotestaff.com.au', 'devs');
$mail->send($transport);
*/

echo $details;
?>