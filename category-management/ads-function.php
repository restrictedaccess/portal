<?php
function check_unmarked_lead($posting_id){
    global $db;
    $AusTime = date("H:i:s"); 
    $AusDate = date("Y")."-".date("m")."-".date("d");
    $ATZ = $AusDate." ".$AusTime;
	 
	$sql = $db->select()
	    ->from('posting', 'lead_id')
	    ->where('id =?', $posting_id);
	$leads_id = $db->fetchOne($sql);
	
	
	//check if the lead has still an existing advertisement which status are not 'ARCHIVE'
	$sql = "SELECT COUNT(id)AS no_of_active_ads FROM posting p WHERE status !='ARCHIVE' AND job_order_id IS NOT NULL AND job_order_source = 'rs' AND lead_id = $leads_id;";
	$no_of_active_ads = $db->fetchOne($sql);
	
	//echo $sql;
	if($no_of_active_ads > 0){
	    //do nothing
		// leads has still an exsiting active and new ads
		$data = array('custom_recruitment_order' => 'yes', 'last_updated_date' => $ATZ);
	    $where = "id = ".$leads_id;	
	    $db->update('leads' ,  $data , $where);
					
	    //history
	    $data = array(
            'leads_id' => $leads_id, 
	        'date_change' => $ATZ, 
	        'changes' => 'System detected that there are active/new leads advertisement. Marking this lead.', 
	        'change_by_id' => $_SESSION['admin_id'], 
	        'change_by_type' => 'admin'
        );
        $db->insert('leads_info_history', $data);
	}else{
	
	    $data = array('custom_recruitment_order' => 'no', 'last_updated_date' => $ATZ);
	    $where = "id = ".$leads_id;	
	    $db->update('leads' ,  $data , $where);
					
	    //history
	    $data = array(
            'leads_id' => $leads_id, 
	        'date_change' => $ATZ, 
	        'changes' => 'System detected that there are no active/new leads advertisement. Unmarking this lead.', 
	        'change_by_id' => $_SESSION['admin_id'], 
	        'change_by_type' => 'admin'
        );
        $db->insert('leads_info_history', $data);
	
	}
	 
}
function ShowAdsHistory($id){
	global $db;
	$changes = "";
	//id, posting_id, date_change, changes, change_by_id, change_by_type
	$sql =$db->select()
		->from('posting_history')
		->where('posting_id =?' ,$id);
	$histories = $db->fetchAll($sql);
	
	if($histories >0){
		
		$changes = "<ol>";
		foreach($histories as $history){
			$changes .= "<li>";
			$changes .= "<b>".ShowCreatorName($history['change_by_id'] , $history['change_by_type'])." ".$history['date_change'] ."</b>";
			$changes .= "<ul>";
			$changes .= "<li>".$history['changes']."</li>";
			$changes .= "</ul>";	
			$changes .= "</li><br>";
		}
		$changes .= "</ol>";
		
		return $changes;
	}	
		
		
}


function AddPostingHistoryChanges($data , $posting_id, $change_by_id , $change_by_type){

	global $db;
	$AusTime = date("H:i:s"); 
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$ATZ = $AusDate." ".$AusTime;
	
	//id, agent_id, created_by_type, lead_id, category_id, job_order_id, job_order_source, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status, heading, show_status
	
	$query = "SELECT * FROM posting WHERE id = $posting_id;";
	$result = $db->fetchRow($query);
	$difference = array_diff_assoc($data,$result);
	//print_r($difference);exit;
	if($difference > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("%s => from %s to %s <br>", FieldNameDesc($array_key), FieldValueDesc($array_key , $result[$array_key])  , FieldValueDesc($array_key , $difference[$array_key]) );
		}

		//add leads info history changes
		//echo $history_changes;exit;
		if($history_changes){
			$changes = array('posting_id' => $posting_id,
						 'date_change' => $ATZ, 
						 'changes' => $history_changes, 
						 'change_by_id' => $change_by_id, 
						 'change_by_type' => $change_by_type);
			$db->insert('posting_history', $changes);
		}			 
		//print_r($changes);
	}

}

function FieldValueDesc($field_name , $value){
	global $db;
	// column to be consider: lead_id, category_id
	
	if($field_name == 'lead_id'){
		$sql = $db->select()
			 ->from('leads')
			 ->where('id = ?', $value);
		$result = $db->fetchRow($sql);	 
		return "#".$result['id']." ".$result['fname']." ".$result['lname'];
	}else if($field_name == 'category_id'){
		$sql = $db->select()
			->from('job_category' , 'category_name')
			->where('category_id =?' , $value);
		$category_name = $db->fetchOne($sql);
		return 	$category_name;
	}else{
		return $value;
	}
	
	

}
function FieldNameDesc($field_name){
	
	$FieldNameDesc = array(
		'lead_id' => 'CLIENT', 
		'category_id' => 'CATEGORY', 
		'date_created' => 'DATE CREATED', 
		'outsourcing_model' => 'OUTSOURCING MODEL', 
		'companyname' => 'COMPANY NAME', 
		'jobposition' => 'JOB TITLE POSITION', 
		'jobvacancy_no' => 'VACANCY', 
		'status' => 'STATUS', 
		'heading' => 'HEADING', 
		'show_status' => 'SHOW STATUS'
	);
	return $FieldNameDesc[$field_name];
	
	
}

function ShowCreatorName($id , $type){
	global $db;
	
	//'admin','agent','leads'
	if($id){
			if($type == "admin"){
				$sql = $db->select()
					 ->from('admin')
					 ->where('admin_id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Admin  ".$result['admin_fname'];
					 
			}else if($type == "leads"){
				$sql = $db->select()
					 ->from('leads')
					 ->where('id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Client  ".$result['fname'];
					 
			}else{
				$type = strtoupper($type);
				$sql = $db->select()
					 ->from('agent')
					 ->where('agent_no = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Business Developer  ".$result['fname'];
					 
			}
			
	}
	
}



?>