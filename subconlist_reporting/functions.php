<?php
function LeadsHistory($leads_id, $from, $to){
	global $db;
	if($from!="" and $to!=""){
	    $condition = " AND date_change BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59' ";
	}
	$HISTORIES=array();
	$sql = "SELECT * FROM leads_info_history l WHERE leads_id=".$leads_id." AND changes LIKE '%csro_id%' $condition;";
	//return $sql;
	$histories = $db->fetchAll($sql);
	foreach($histories as $history){
		$data=array(
		    'changes_made_by' => HistoryMaker($history['change_by_id'], $history['change_by_type']),
			'date_change' => $history['date_change'],
			'csro_changes' => ExtractCSRO($history['changes']),
		);
		$HISTORIES[]=$data;
	}
	return $HISTORIES;
}

function HistoryMaker($id, $type){
	global $db;
	//ENUM('admin','client','bp','aff')
	if($type == 'admin'){
		$sql=$db->select()
		   ->from('admin')
		   ->where('admin_id =?', $id);
		$admin=$db->fetchRow($sql);
		return sprintf('Admin %s %s', $admin['admin_fname'], $admin['admin_lname']);
	}
	
	if($type == 'bp'){
		$sql=$db->select()
		   ->from('agent')
		   ->where('agent_no =?', $id);
		$agent=$db->fetchRow($sql);
		return sprintf('BP %s %s', $agent['fname'], $agent['lname']);
	}
	
	if($type == 'client'){
		$sql=$db->select()
		   ->from('leads')
		   ->where('id =?', $id);
		$lead=$db->fetchRow($sql);
		return sprintf('Client %s %s', $lead['fname'], $lead['lname']);
	}
	
	if($type == 'aff'){
		$sql=$db->select()
		   ->from('agent')
		   ->where('agent_no =?', $id);
		$agent=$db->fetchRow($sql);
		return sprintf('AFF %s %s', $agent['fname'], $agent['lname']);
	}
	
}
function ExtractCSRO($string){
	global $db;
    $string_a = substr($string , strpos($string,'csro_id')) ;
    $string_b = substr($string_a , strpos($string_a,'csro_id'), strpos($string_a,'<')) ;
    $string_c = substr($string_b , 10 );
    $csro = explode('to',trim($string_c));
	
	$from_str="From NULL ";
	$to_str="To NULL";
	if($csro[0]!=""){
		$sql=$db->select()
		   ->from('admin')
		   ->where('admin_id =?', $csro[0]);
		$admin=$db->fetchRow($sql);
		$from_str = sprintf('From %s %s' ,$admin['admin_fname'], $admin['admin_lname']);
	}
	
	if($csro[1]!=""){
		$sql=$db->select()
		   ->from('admin')
		   ->where('admin_id =?', $csro[1]);
		$admin=$db->fetchRow($sql);
		$to_str = sprintf('To %s %s' ,$admin['admin_fname'], $admin['admin_lname']);
	}
	
	return $from_str." ".$to_str;
}
?>