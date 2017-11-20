<?php
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

//Recruiter who are in FULL-CONTROL status
$recruiters_full_control = array(81);

//$navs = array('hiring coordinators', 'head recruiters', 'recruiters', 'csro');
function GetAdminName($admin_id){
    global $db;
	$sql = $db->select()
	    ->from('admin')
		->where('admin_id =?', $admin_id);
	$admin = $db->fetchRow($sql);
	return $admin['admin_fname']." ".$admin['admin_lname'];	
}

function compareData($data , $team_id){
	global $db;
	$history_changes ="";
	//PARSE DATA IN THE subcontractors  
    $query = "SELECT team, team_description FROM recruitment_team WHERE id = $team_id;";
    $result = $db->fetchRow($query);

	$difference = array_diff_assoc($data,$result);
	if($difference > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("<li>%s from %s to %s</li>", getFullColumnName($array_key), $result[$array_key] , $difference[$array_key]);
		}
	}
	return $history_changes;
}

function GetOriginalTeamMembers($team_id, $member_position, $new_ids){  
    global $db;
	
	if(is_array($new_ids)){
	    $compare_ids = $new_ids;
	}else{
	    $compare_ids = array();
		array_push($compare_ids, $new_ids);
	}	
	
	$sql = "SELECT * FROM  recruitment_team_member WHERE member_position = '".$member_position."' AND team_id=".$team_id;
	//return $sql;
	$results = $db->fetchAll($sql);
	$original_member_admin_ids = array();
	if(count($results) > 0){
	    $msg = "";
	    foreach($results as $result){
		    array_push($original_member_admin_ids, $result['admin_id']);
		}
		
		
	    //removing members
		foreach($original_member_admin_ids as $admin_id){
		    if(!in_array($admin_id, $compare_ids)){
                //$data = array('member_status' => 'removed');
                $where = "team_id =".$team_id." AND admin_id=".$admin_id." AND member_position = '".$member_position."'";
                //$db->update('recruitment_team_member', $data, $where);
				$db->delete('recruitment_team_member',$where);
				$msg .= sprintf('<li>Removed %s => %s</li>' , ucwords($member_position) , ucwords(GetAdminName($admin_id)));
			
			    if($member_position == 'recruiter'){
				    $sql = $db->select()
					     ->from('recruitment_team_member' , 'admin_id')
						 ->where('member_position =?', 'head recruiter')
						 ->where('team_id =?', $team_id);
					$head_recruiter_id = $db->fetchOne($sql);
                    
					$data = array('head_recruiter_id' => NULL);
					$where = "admin_id =".$admin_id;
					$db->update('admin' , $data , $where);
					
					//TODO 
					//history for unassigning recruiter to head recruiter.
					$msg .= sprintf('<li>Unassigned Recruiter %s from Head Recruiter %s</li>' , ucwords(GetAdminName($admin_id)), ucwords(GetAdminName($head_recruiter_id)));
				}
				
				
			
			}
		}
		
		//adding new members
        foreach($compare_ids as $new_admin_id){
		    if(!in_array($new_admin_id, $original_member_admin_ids)){
				$data =array(
					'team_id' => $team_id,
					'admin_id' => $new_admin_id,
					'member_position' => $member_position,
					'team_member_created_by_id' => $_SESSION['admin_id'],
					'team_member_date_created' => date('Y-m-d H:i:s')
				);
				$db->insert('recruitment_team_member', $data);
				$msg .= sprintf('<li>Added %s => %s</li>' , ucwords($member_position) , ucwords(GetAdminName($new_admin_id)));
			
			    if($member_position == 'recruiter'){
				    $sql = $db->select()
					     ->from('recruitment_team_member' , 'admin_id')
						 ->where('member_position =?', 'head recruiter')
						 ->where('team_id =?', $team_id);
					$head_recruiter_id = $db->fetchOne($sql);
                    
					$data = array('head_recruiter_id' => $head_recruiter_id);
					$where = "admin_id =".$new_admin_id;
					$db->update('admin' , $data , $where);
					
					$msg .= sprintf('<li>Assigned Recruiter %s to Head Recruiter %s</li>' , ucwords(GetAdminName($new_admin_id)), ucwords(GetAdminName($head_recruiter_id)));
				}
				
				if($member_position == 'head recruiter'){
				    $sql = $db->select()
					    ->from('recruitment_team_member')
						->where('member_position =?', 'recruiter')
						->where('team_id =?', $team_id);
					$recruiters = $db->fetchAll($sql);
                    foreach($recruiters as $recruiter){
					    $data = array('head_recruiter_id' => $new_admin_id);
					    $where = "admin_id =".$recruiter['admin_id'];
					    $db->update('admin' , $data , $where); 

                        $msg .= sprintf('<li>Assigned Recruiter %s to Head Recruiter %s</li>' , ucwords(GetAdminName($recruiter['admin_id'])), ucwords(GetAdminName($new_admin_id)));						
                    }					
				}
			
			}
        }		
	}
	return $msg;
}



function getFullColumnName($field){
	$field_name = array("team" , "team_description");
	
	$field_description = array("Team Name" , "Team Description");
	
	for($i=0;$i<count($field_name);$i++){
		if($field == $field_name[$i]){
			return $field_description[$i];
			break;
		}
	}
	
}
?>