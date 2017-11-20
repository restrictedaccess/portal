<?php
function AddAgentHistoryChanges($data , $agent_no, $change_by_id , $change_by_type){

	global $db;
	$AusTime = date("H:i:s"); 
	$AusDate = date("Y")."-".date("m")."-".date("d");
	$ATZ = $AusDate." ".$AusTime;

	$query = "SELECT * FROM agent WHERE agent_no = $agent_no;";
	$result = $db->fetchRow($query);
	$difference = array_diff_assoc($data,$result);
	if($difference > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("%s => %s to %s <br>", $array_key, $result[$array_key] , $difference[$array_key]);
		}

		
		//id, agent_no, change_by_id, change_by_type, changes, date_change
		$changes = array('agent_no' => $agent_no ,
					 'date_change' => $ATZ, 
					 'changes' => $history_changes, 
					 'change_by_id' => $change_by_id, 
					 'change_by_type' => $change_by_type);
		$db->insert('agent_history', $changes);			 
		//print_r($changes);
	}

}


function ShowAgentInfoChangesHistory($agent_no){
	global $db;
	
	$query = "SELECT id, DATE_FORMAT(date_change , '%D %b %Y %r')AS date_change, changes , change_by_id, change_by_type FROM agent_history WHERE agent_no = $agent_no ;";
	$changes =  $db->fetchAll($query);
	
	if(count($changes)>0){
		
		
		$history_changes .= "<ul>";
							
		foreach($changes as $change){
			$history_changes .= "<li>
									<div><b>Changes made by ".showName($change['change_by_id'],$change['change_by_type'])." - ".$change['date_change']."</b></div>
									<div style='margin-left:10px;'>".$change['changes']."</div>
								 </li>";
		}
		
			$history_changes .= "</ul>";
		
		
		return $history_changes;
	}
}

function showName($id , $type){
	global $db;
	
	if($id){
			if($type == "admin"){
				$sql = $db->select()
					 ->from('admin')
					 ->where('admin_id = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "Admin : ".$result['admin_fname'];
					 
			}else{
				
				$sql = $db->select()
					 ->from('agent')
					 ->where('agent_no = ?', $id);
				$result = $db->fetchRow($sql);	 
				return "$type : ".$result['fname'];
					 
			}
			
	}
	
}


?>