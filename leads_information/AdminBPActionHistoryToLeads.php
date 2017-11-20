<?php
function BPActionHistoryToLeads($leads_id , $mode){
		global $db;
		
		if($leads_id == "" or $leads_id == NULL){
			return "Leads Action History cannot be shown. Leads ID is Missing";
			exit();
		}
		
		//let us know who's the current user
		if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
			$session_id = $_SESSION['agent_no'];
			$session_by_type = 'agent';
		}
		if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
			$session_id = $_SESSION['admin_id'];
			$session_by_type = 'admin';
		}

		
		$sql="SELECT id, history,DATE_FORMAT(date_created,'%M %d, %Y')AS date_created, DATE_FORMAT(date_created,'%h:%i %p ')AS time_created,agent_no,created_by_type , actions ,subject FROM history WHERE leads_id = $leads_id AND created_by_type = 'agent' ORDER BY id DESC;";
		//return $sql;
		
		$results = $db->fetchAll($sql);
		
		foreach($results as $result){
	
				$id = $result['id'];
				$history = $result['history'];
				$date_created = $result['date_created'];
				$created_by = $result['agent_no'];
				$created_by_type = $result['created_by_type'];
				$actions = $result['actions'];
				$subject = $result['subject'];
				
				if($actions == "MAIL") $actions = "NOTES";
				if($bgcolor == "#FFFFFF"){
					$bgcolor = "#EEEEEE";
				}else{
					$bgcolor = "#FFFFFF";
				}
				
				if($actions == "CSR"){
					$history = "CLick to view Client Staff Relations message";
				}
				
				$edit = "edit";
				$delete = "delete";
				$e_d = "inactive";
				if($result['created_by_type'] == $session_by_type){
					if($result['agent_no'] == $session_id){
						//he can edit and delete his own notes
						if($actions != "EMAIL" and $actions != "CSR"){
							$edit = "<a href=\"javascript:EditHistory($id , 'update');\">edit</a>";
							$delete ="<a href=\"javascript:EditHistory($id , 'delete');\">delete</a>";
							$e_d = "";
						}
					}
				}
				
				
				$query = $db->select()
					->from('leads_transactions', 'id')
					->where('reference_table =?' , 'history')
					->where('reference_no =?' , $id);
				$id_check = $db->fetchOne($query);	
				
				if($id_check){
					$string2.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div><a href=javascript:popup_win('./viewHistory.php?id=$id',500,400);>".substr(stripslashes(trim($history)),0,100)."</a></div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>$edit | $delete</td>
							 </tr>";
				}else{
					$string.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div><a href=javascript:popup_win('./viewHistory.php?id=$id',500,400);>".substr(stripslashes(trim($history)),0,100)."</a></div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>$edit | $delete</td>
							 </tr>";
				}		 
			
			
		}
		if($mode == 'regular'){
			return $string;
		}else{
			return $string2;
		}
		
	
}

//
function AdminActionHistoryToLeads($leads_id , $mode){
		global $db;
		
		if($leads_id == "" or $leads_id == NULL){
			return "Leads Action History cannot be shown. Leads ID is Missing";
			exit();
		}
		
		//let us know who's the current user
		if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
			$session_id = $_SESSION['agent_no'];
			$session_by_type = 'agent';
		}
		if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
			$session_id = $_SESSION['admin_id'];
			$session_by_type = 'admin';
		}

		
		$sql="SELECT id, history,DATE_FORMAT(date_created,'%M %d, %Y')AS date_created, DATE_FORMAT(date_created,'%h:%i %p ')AS time_created,agent_no,created_by_type , actions ,subject FROM history WHERE leads_id = $leads_id AND created_by_type = 'admin' ORDER BY id DESC;";
		//return $sql;
		
		$results = $db->fetchAll($sql);
		
		foreach($results as $result){
	
				$id = $result['id'];
				$history = $result['history'];
				$history = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $history);
				
				
				$date_created = $result['date_created'];
				$created_by = $result['agent_no'];
				$created_by_type = $result['created_by_type'];
				$actions = $result['actions'];
				$subject = $result['subject'];
				
				if($actions == "MAIL") $actions = "NOTES";
				if($bgcolor == "#FFFFFF"){
					$bgcolor = "#EEEEEE";
				}else{
					$bgcolor = "#FFFFFF";
				}
				
				if($actions == "CSR"){
					$history = "CLick to view Client Staff Relations message";
				}
				
				$edit = "edit";
				$delete = "delete";
				$e_d = "inactive";
				if($result['created_by_type'] == $session_by_type){
					if($result['agent_no'] == $session_id){
						//he can edit and delete his own notes
						if($actions != "EMAIL" and $actions != "CSR"){
							$edit = "<a href=\"javascript:EditHistory($id , 'update');\">edit</a>";
							$delete ="<a href=\"javascript:EditHistory($id , 'delete');\">delete</a>";
							$e_d = "";
						}
					}
				}
				
				$query = $db->select()
					->from('leads_transactions', 'id')
					->where('reference_table =?' , 'history')
					->where('reference_no =?' , $id);
				$id_check = $db->fetchOne($query);	
				$history = stripslashes(trim(strip_tags($history)));
				$history = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $history);
				$history = substr($history,0,100);				
				if($id_check){
					
					
					$string2.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div><a href=javascript:popup_win('./viewHistory.php?id=$id',500,400);>".$history."</a></div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>$edit | $delete</td>
							 </tr>";
				}else{
					$string.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div><a href=javascript:popup_win('./viewHistory.php?id=$id',500,400);>".$history."</a></div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>$edit | $delete</td>
							 </tr>";
				}		 
			
			
		}
		if($mode == 'regular'){
			return $string;
		}else{
			return $string2;
		}
		
	
}



//
function AdminBPActionHistoryToLeads($leads_id , $mode){
		global $db;
		
		if($leads_id == "" or $leads_id == NULL){
			return "Leads Action History cannot be shown. Leads ID is Missing";
			exit();
		}
		
		//let us know who's the current user
		if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
			$session_id = $_SESSION['agent_no'];
			$session_by_type = 'agent';
		}
		if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
			$session_id = $_SESSION['admin_id'];
			$session_by_type = 'admin';
		}

		
		$sql="SELECT id, history,DATE_FORMAT(date_created,'%M %d, %Y')AS date_created, DATE_FORMAT(date_created,'%h:%i %p ')AS time_created,agent_no,created_by_type , actions ,subject FROM history WHERE leads_id = $leads_id ORDER BY id DESC;";
		
		$results = $db->fetchAll($sql);
		
		foreach($results as $result){
	
				$id = $result['id'];
				$history = $result['history'];
				$history = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $history);
				
				
				$date_created = $result['date_created'];
				$created_by = $result['agent_no'];
				$created_by_type = $result['created_by_type'];
				$actions = $result['actions'];
				$subject = $result['subject'];
				
				$subject = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $subject);
				
				
				if($actions == "MAIL") $actions = "NOTES";
				if($bgcolor == "#FFFFFF"){
					$bgcolor = "#EEEEEE";
				}else{
					$bgcolor = "#FFFFFF";
				}
				
				if($actions == "CSR"){
					$history = "CLick to view Client Staff Relations message";
				}
				
				$edit = "edit";
				$delete = "delete"; 
				$e_d = "inactive";
				if($result['created_by_type'] == $session_by_type){
					if($result['agent_no'] == $session_id){
						//he can edit and delete his own notes
						if($actions != "EMAIL" and $actions != "CSR"){
							$edit = "<a href=\"javascript:EditHistory($id , 'update');\">edit</a>";
							$delete ="<a href=\"javascript:EditHistory($id , 'delete');\">delete</a>";
							$e_d = "";
						}
					}
				}
				
				
				$query = $db->select()
					->from('leads_transactions', 'id')
					->where('reference_table =?' , 'history')
					->where('reference_no =?' , $id);
				$id_check = $db->fetchOne($query);	
				
				if($id_check){
					$string2.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div>__CONTENT__</div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>__EDIT__</td>
							 </tr>";
				}else{
					$string.="<tr bgcolor='$bgcolor'>
								<td align='center' class='act_td'>".$result['date_created']."</td>
								<td align='center' class='act_td'>".$result['time_created']."</td>
								<td align='center' class='act_td'>".$actions."</td>
						<td class='act_td'><div>__CONTENT__</div></td>
								<td align='center' class='act_td'>".getCreator($created_by , $created_by_type)."</td>
								<td align='center' class='act_td $e_d'>__EDIT__</td>
							 </tr>";
				}
				
				
				if( $actions == 'FEEDBACK') {
						$content = $history;
						$edit = "<span style='color:#ccc;font-weight:normal'>edit | delete</span>";
				} else {
						$content = "<a href=javascript:popup_win('./viewHistory.php?id=".$id."',500,400);>".substr(stripslashes(trim(strip_tags($history))),0,100); //."</a>";
						
						$edit = $edit.' | '.$delete;
				}
				
				if( $id_check) {
						$string2 = str_replace("__CONTENT__", $content, $string2);
						$string2 = str_replace("__EDIT__", $edit, $string2);
				} else {
						$string = str_replace("__CONTENT__", $content, $string);
						$string = str_replace("__EDIT__", $edit, $string);
				}
			
		}
		if($mode == 'regular'){
			return $string;
		}else{
			return $string2;
		}
	
}



function getCreator($created_by , $created_by_type )
{
	global $db;
	
	//return $created_by ." ". $created_by_type;
	if($created_by != ""){
			if($created_by_type == 'agent')
			{
				$query = $db->select()
					->from('agent')
					->where('agent_no = ?' ,$created_by);
				$name = $db->fetchRow($query);	
				return $name['work_status']." : ".$name['fname']." ".$name['lname'];
				
			}else if($created_by_type == 'admin'){
				$query = $db->select()
					->from('admin' , 'admin_fname')
					->where('admin_id = ?' ,$created_by);
				$name = $db->fetchOne($query);	
				return " Admin : ".$name;
				
			}else if($created_by_type == 'leads'){
			
				$query = $db->select()
					->from('leads' , 'fname')
					->where('id = ?' ,$created_by);
				$name = $db->fetchOne($query);	
				return " Lead : ".$name;
			}else if($created_by_type == 'lead'){
			
				$query = $db->select()
					->from('leads' , 'fname')
					->where('id = ?' ,$created_by);
				$name = $db->fetchOne($query);	
				return " Lead : ".$name;	
			}
			else{
				$name="";
				return $name;
			}
	}
	
	
}

