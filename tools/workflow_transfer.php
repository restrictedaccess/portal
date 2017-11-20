<?php
include('../conf/zend_smarty_conf.php');


//id, client_id, userid, date_start, date_finished, date_created, work_details, notes, percentage, priority, status, created_by_id, created_by_type, unread, last_opened, last_updated
$PRIORITIES = array('none', 'trivial', 'minor', 'major', 'critical', 'blocker');
$sql = "SELECT * FROM workflow;";
$workflows = $db->fetchAll($sql);
foreach($workflows as $w){

     //insert set the owner/s of this task
	 $data = array(
	     'workflow_id' => $w['id'], 
		 'owner_id' => $w['userid'], 
		 'owner_type' => 'personal', 
		 'date_added' => date("Y-m-d H:i:s")
	 );
	 $db->insert('workflow_owner', $data);
	 
	 //update set the creator
	 $sql = $db->select()
	     ->from('personal', Array('fname', 'lname'))
		 ->where('userid =?', $w['userid']);
	 $staff_name = $db->fetchRow($sql);	  
	 
     $data = array(
	     'created_by_id' => $w['client_id'],
		 'created_by_type' => 'leads',
		 'staff_name_search_str' => $staff_name['fname'].' '.$staff_name['lname'],
		 'priority_search_str' => $PRIORITIES[$w['priority']]
	 );
	 
	 $db->update('workflow', $data, 'id='.$w['id']);
	 
	 $result .= sprintf('<li>Task #%s updated</li>', $w['id']);
	 
}	

echo "<ol>".$result."</ol>";
?>