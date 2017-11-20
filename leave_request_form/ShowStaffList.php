<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['client_id']){
	$leads_id = $_SESSION['client_id'];
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$leads_id);
	$lead = $db->fetchRow($sql);
	$smarty->assign('client_section',True);
	
}else if($_SESSION['admin_id']){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$smarty->assign('admin_section',True);	

}else if($_SESSION['manager_id'] != ""){
	$sql = $db->select()
	    ->from('client_managers')
		->where('id=?', $_SESSION['manager_id']);
	$manager = $db->fetchRow($sql);
	$subcons=array();
	if($manager['view_staff'] == 'specific'){
		$sql = $db->select()
		    ->from('client_managers_specific_staffs')
			->where('client_manager_id=?', $_SESSION['manager_id']);
		//echo $sql;	
		$subcontractors=$db->fetchAll($sql);
		foreach($subcontractors as $subcon){
			array_push($subcons, $subcon['subcontractor_id']);
		}
	}
	$leads_id = $manager['leads_id'];
	$sql=$db->select()
		->from('leads')
		->where('id = ?' ,$leads_id);
	$lead = $db->fetchRow($sql);
	$smarty->assign('client_section',True);
	
	$smarty->assign('subcons', $subcons);
	$smarty->assign('manager', $manager);

}else{
	//header("location:index.php");
	die("Session Expires. Please re-login");
}





$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];

$search =$_REQUEST['search'];

if(!$search){
	$search = "FALSE";
}else{
	
	$det = new DateTime($year."-".$month."-".$day);
	$timestamp = $det->format("Y-m-d");
	
}



if($leads_id){
	// If the user is a client parse all staff working in this client who filed a Leave 
	// ->where('date_of_leave =?' , $timestamp)
	
	//pending
	if($timestamp){
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'pending')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$pending_leave_requests = $db->fetchAll($sql);
			
			//approved
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'approved')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$approved_leave_requests = $db->fetchAll($sql);
			
			//denied
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'denied')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$denied_leave_requests = $db->fetchAll($sql);
			
			//cancelled
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'cancelled')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$cancelled_leave_requests = $db->fetchAll($sql);
			
			//absent
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'absent')
				->where('date_of_leave =?' , $timestamp)	
				->group('r.id');
			//echo $sql;	
			$absent_leave_requests = $db->fetchAll($sql);
	}else{
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'pending')
				->group('r.id');
			//echo $sql;	
			$pending_leave_requests = $db->fetchAll($sql);
			
			//approved
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'approved')
				->group('r.id');
			//echo $sql;	
			$approved_leave_requests = $db->fetchAll($sql);
			
			//denied
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'denied')
				->group('r.id');
			//echo $sql;	
			$denied_leave_requests = $db->fetchAll($sql);
			
			//cancelled
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'cancelled')
				->group('r.id');
			//echo $sql;	
			$cancelled_leave_requests = $db->fetchAll($sql);
			
			//absent
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('r.leads_id = ?' , $leads_id)
				->where('d.status =?' ,'absent')
				->group('r.id');
			//echo $sql;	
			$absent_leave_requests = $db->fetchAll($sql);
	}	
}

if($_SESSION['admin_id']){
	// If the user is an Admin parse all staff who filed a leave
	//pending
	if($timestamp){
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'pending')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$pending_leave_requests = $db->fetchAll($sql);
			
			//approved
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'approved')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$approved_leave_requests = $db->fetchAll($sql);
			
			//denied
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'denied')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$denied_leave_requests = $db->fetchAll($sql);
			
			//cancelled
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'cancelled')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$cancelled_leave_requests = $db->fetchAll($sql);
			
			//absent
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'absent')
				->where('date_of_leave =?' , $timestamp)
				->group('r.id');
			//echo $sql;	
			$absent_leave_requests = $db->fetchAll($sql);
 	}else{
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'pending')
				
				->group('r.id');
			//echo $sql;	
			$pending_leave_requests = $db->fetchAll($sql);
			
			//approved
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'approved')
				->group('r.id');
			//echo $sql;	
			$approved_leave_requests = $db->fetchAll($sql);
			
			//denied
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'denied')
				->group('r.id');
			//echo $sql;	
			$denied_leave_requests = $db->fetchAll($sql);
			
			//cancelled
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'cancelled')
				->group('r.id');
			//echo $sql;	
			$cancelled_leave_requests = $db->fetchAll($sql);
			
			//absent
			$sql = $db->select()
				->from(array('r' => 'leave_request') , Array('id' ,'leave_type'))
				->join(array('p' => 'personal') , 'p.userid = r.userid' , Array('fname' , 'lname'))
				->join(array('d' => 'leave_request_dates') , 'd.leave_request_id = r.id' , Array('leave_request_id', 'date_of_leave', 'status'))
				->join(array('s' => 'subcontractors') , 's.userid = r.userid' , Array('subcon_id' => 'id', 'working_status' => 'status'))
				//->where('s.status =?', 'ACTIVE')
				->where('d.status =?' ,'absent')
				->group('r.id');
			//echo $sql;	
			$absent_leave_requests = $db->fetchAll($sql);
	}
}
//print_r($leave_request);
$smarty->assign('pending_leave_requests',$pending_leave_requests);
$smarty->assign('approved_leave_requests',$approved_leave_requests);
$smarty->assign('denied_leave_requests',$denied_leave_requests);
$smarty->assign('cancelled_leave_requests',$cancelled_leave_requests);
$smarty->assign('absent_leave_requests',$absent_leave_requests);

//$smarty->display('ShowStaffList.tpl');
$smarty->display('ShowStaffRequestedLeaveToClient.tpl');
?>