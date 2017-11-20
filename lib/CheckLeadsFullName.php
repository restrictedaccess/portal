<?php
function CheckLeadsFullName($leads_id, $fname, $lname){
        $_SESSION['leads_thesame_name_id']='';
		$AusTime = date("H:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;

		global $db;
		unset($_SESSION['leads_new_info_id']);
		unset($_SESSION['leads_thesame_name_id']);
		//global $fname;
		//global $lname;
		//if($_SESSION['leads_id']){
		//	$leads_id = $_SESSION['leads_id'];
		//}else{
		//	global $leads_id;
		//}
		
		$marked_counter = 0;
		$sql="select id  from leads where fname like '".$fname."' and lname like '".$lname."' and status not in('REMOVED', 'Inactive') and id not in(".$leads_id.")";
		$existing_leads = $db->fetchAll($sql);
		//echo "<pre>";
		//print_r($existing_leads);
		//echo "</pre>";
		
		if($existing_leads){
				foreach($existing_leads as $existing_lead){
					$data = array('leads_id' => $leads_id, 'existing_leads_id' => $existing_lead['id']);
					if($leads_id != $existing_lead['id']) {
						$marked_counter++;
						$db->insert('leads_indentical' , $data);
					}
				}
				
				
		}

		if($marked_counter > 0) {
				$_SESSION['leads_new_info_id'] = $leads_id;
				$data = array('marked' => 'yes' ,'marked_date' => $ATZ);
				$where = "id = ".$leads_id;
				$db->update('leads', $data, $where);
				$_SESSION['leads_thesame_name_id'] = $leads_id;
		}
		

}
?>