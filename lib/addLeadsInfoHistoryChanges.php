<?php
//include '../conf/zend_smarty_conf.php';
function addLeadsInfoHistoryChanges($data , $leads_id, $change_by_id , $change_by_type){

	global $db;
	$AusTime = date("H:i:s"); 
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$ATZ = $AusDate." ".$AusTime;
	
	try{
		$query = "SELECT * FROM leads WHERE id = $leads_id;";
		$result = $db->fetchRow($query);
		$difference = array_diff_assoc($data,$result);
		if($difference > 0){
			foreach(array_keys($difference) as $array_key){
				$history_changes .= sprintf("%s => %s to %s <br>", $array_key, $result[$array_key] , $difference[$array_key]);
			}
	
			//add leads info history changes
			//echo $history_changes;exit;
			if($history_changes){
					$changes = array('leads_id' => $leads_id ,
								 'date_change' => $ATZ, 
								 'changes' => $history_changes, 
								 'change_by_id' => $change_by_id, 
								 'change_by_type' => $change_by_type);
					$db->insert('leads_info_history', $changes);
			}			 
			//print_r($changes);
		}
	}catch(Exception $e){
		
	}

}


function showleadsInfoHistoryChanges($leads_id){
	global $db;
	
	$query = "SELECT * FROM leads_info_history WHERE leads_id = $leads_id ;";
	//id, leads_id, date_change, changes, change_by_id, change_by_type
	$changes =  $db->fetchAll($query);
	foreach($changes as $change){
		$history_changes .= sprintf("%s => %s to %s <hr>", $array_key, $result[$array_key] , $difference[$array_key]);
	}
	
	
}

function showLeadsInfoHistory($leads_id , $overflow ,$margin){
	global $db;
	//$overflow = "yes";
	$query = "SELECT id, date_change, changes , change_by_id, change_by_type FROM leads_info_history WHERE leads_id = $leads_id ORDER BY date_change DESC ;";
	$changes =  $db->fetchAll($query);
	
	if(count($changes)>0){
		$history_changes = "<div style='margin-top:10px;margin-bottom:10px; margin-left:$margin;margin-right:$margin; border:#CCCCCC solid 1px; background:#FFFFCC;'>
							<div style='background:#CCCCCC; border:#999999 outset 1px; padding:5px;'><b>Leads Information Changes History</b></div>";
		if($overflow == "yes"){
			$history_changes .= "<div style='overflow:auto; height:250px;'>";
		}					
		foreach($changes as $change){
		    $det = new DateTime($change['date_change']);
			$date_change = $det->format("l jS \of F Y h:i:s A");
			$history_changes .= "<div style='border-bottom:#CCCCCC solid 1px;padding:5px;'>
									<div><b>Changes made by ".showName($change['change_by_id'],$change['change_by_type'])." - ".$date_change."</b></div>
									<div style='margin-left:10px;'>".$change['changes']."</div>
								 </div>";
		}
		if($overflow == "true"){
			$history_changes .= "</div>";
		}
		$history_changes .="</div>";
		echo $history_changes;
	}
}

function showLeadsInfoChangesHistory($leads_id , $overflow ,$margin){
	global $db;
	//$overflow = "yes";
	$query = "SELECT id, date_change, changes , change_by_id, change_by_type FROM leads_info_history WHERE leads_id = $leads_id ORDER BY date_change DESC;";
	$changes =  $db->fetchAll($query);
	
	if(count($changes)>0){
		$history_changes = "<div style='margin-bottom:10px; border:#fff solid 1px; background:#FFFFFF;'>";
		if($overflow == "yes"){
			$history_changes .= "<div style='overflow-y:scroll;overflow-x:hidden; height:200px; '><ol>";
		}					
		foreach($changes as $change){
		
		    $det = new DateTime($change['date_change']);
			$date_change = $det->format("l jS \of F Y h:i:s A");
			
			$history_changes .= "<li>
									<div><b>Changes made by ".showName($change['change_by_id'],$change['change_by_type'])." - ".$date_change."</b></div>
									<div style='margin-left:10px;'>".$change['changes']."</div>
								 </li>";
		}
		if($overflow == "true"){
			$history_changes .= "</ol></div>";
		}
		$history_changes .="</div>";
		return $history_changes;
	}
}

function showName($id , $type){
	global $db;
	
	if($id!=""){
			if($type == "admin"){
				$sql = $db->select()
					 ->from('admin')
					 ->where('admin_id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Admin : ".$result['admin_fname'];
					 
			}else if($type == "client"){
				$sql = $db->select()
					 ->from('leads')
					 ->where('id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Lead : ".$result['fname'];
					 
			}else{
				$type = strtoupper($type);
				$sql = $db->select()
					 ->from('agent')
					 ->where('agent_no = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "$type : ".$result['fname'];
					 
			}
			
	}
	
}

/*
function getFullColumnName($field){
	$field_name = array("id", "tracking_no", "agent_id", "business_partner_id", "timestamp", "status", "call_time_preference", "remote_staff_competences", "remote_staff_needed", "remote_staff_needed_when", "remote_staff_one_home", "remote_staff_one_office", "your_questions", "lname", "fname", "company_position", "company_name", "company_address", "email", "website", "officenumber", "mobile", "company_description", "company_industry", "company_size", "outsourcing_experience", "outsourcing_experience_description", "company_turnover", "referal_program", "contacted_since", "client_since", "inactive_since", "rating", "personal_id", "date_move", "agent_from", "authenticate", "opt", "show_to_affiliate", "leads_country", "leads_ip", "contact_person", "logo_image", "company_owner", "contact", "others", "accounts", "acct_dept_name1", "acct_dept_name2", "acct_dept_contact1", "acct_dept_contact2", "acct_dept_email1", "acct_dept_email2", "supervisor_staff_name", "supervisor_job_title", "supervisor_skype", "supervisor_email", "supervisor_contact", "business_owners", "business_partners", "location_id");
	
	$field_description = array("id", "tracking_no", "agent_id", "business_partner_id", "timestamp", "status", "call_time_preference", "remote_staff_competences", "remote_staff_needed", "remote_staff_needed_when", "remote_staff_one_home", "remote_staff_one_office", "your_questions", "lname", "fname", "company_position", "company_name", "company_address", "email", "website", "officenumber", "mobile", "company_description", "company_industry", "company_size", "outsourcing_experience", "outsourcing_experience_description", "company_turnover", "referal_program", "contacted_since", "client_since", "inactive_since", "rating", "personal_id", "date_move", "agent_from", "authenticate", "opt", "show_to_affiliate", "leads_country", "leads_ip", "contact_person", "logo_image", "company_owner", "contact", "others", "accounts", "acct_dept_name1", "acct_dept_name2", "acct_dept_contact1", "acct_dept_contact2", "acct_dept_email1", "acct_dept_email2", "supervisor_staff_name", "supervisor_job_title", "supervisor_skype", "supervisor_email", "supervisor_contact", "business_owners", "business_partners", "location_id");
	
	for($i=0;$i<count($field_name);$i++){
		if($field == $field_name[$i]){
			return $field_description[$i];
			break;
		}
	}
	
}
*/

?>