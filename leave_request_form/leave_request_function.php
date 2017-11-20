<?php
function get_assigned_staffs($csro_id){
	global $db;
	$csro_conditions = " AND l.csro_id = '".$csro_id. "' ";
	$sql="SELECT s.userid FROM subcontractors AS s INNER JOIN leads AS l ON l.id = s.leads_id WHERE (s.status IN ('ACTIVE', 'suspended') ".$csro_conditions." );";
	$csro_staffs = $db->fetchAll($sql);
	return $csro_staffs;
	
}
function get_client_managers_emails($leads_id, $userid){
	global $db;
	
	//get the subcon id of the staff
	$sql = $db->select()
	    ->from('subcontractors', 'id')
		->where('leads_id =?', $leads_id)
		->where('userid =?', $userid)
		->where('status =?', 'ACTIVE');
	$subcon_id = $db->fetchOne($sql);
	
	//get the client's active managers
	$sql = $db->select()
	    ->from('client_managers')
		->where('leads_id =?', $leads_id)
		->where('status =?', 'active')
		->where('manage_leave_request =?', 'Y');
	$managers = $db->fetchAll($sql);
	
	$data=array();
	$specific_id="";
	foreach($managers as $manager){
		if($manager['view_staff'] == 'specific'){
			$sql = $db->select()
			    ->from('client_managers_specific_staffs', 'id')
				->where('client_manager_id =?', $manager['id'])
				->where('subcontractor_id =?', $subcon_id);
			$specific_id = $db->fetchRow($sql);	
			if($specific_id !=""){
				if(in_array($manager['email'], $data) == false){
					array_push($data, $manager['email']);
				}
			}
		}
		
		if($manager['view_staff'] == 'all'){
			if(in_array($manager['email'], $data) == false){
				array_push($data, $manager['email']);
			}
		}		
	}
	
	return $data;
	
}
function ShowName($id , $table){
	global $db;
	if($table == 'personal'){
		$sql = $db->select()
			->from('personal' , Array('fname' ,'lname'))
			->where('userid =?' ,$id);
		$result = $db->fetchRow($sql);
		$name = "Staff ".$result['fname']." ".$result['lname'];	
	}
	
	if($table == 'admin'){
		$sql = $db->select()
			->from('admin' , Array('admin_fname' ,'admin_lname'))
			->where('admin_id =?' ,$id);
		$result = $db->fetchRow($sql);
		$name = "Admin ".$result['admin_fname']." ".$result['admin_lname'];	
	}
	
	if($table == 'leads'){
		$sql = $db->select()
			->from('leads' , Array('fname' ,'lname'))
			->where('id =?' ,$id);
		$result = $db->fetchRow($sql);
		$name = "Client ".$result['fname']." ".$result['lname'];	
	}
	
	if($table == 'client_managers'){
		$sql = $db->select()
			->from('client_managers' , Array('fname' ,'lname'))
			->where('id =?' ,$id);
		$result = $db->fetchRow($sql);
		$name = "Manager ".$result['fname']." ".$result['lname'];	
	}
	//echo $table;exit;
	return $name;
}

?>