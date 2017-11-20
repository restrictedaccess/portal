<?php
include('../conf/zend_smarty_conf.php');


//id, client_id, userid, date_start, date_finished, date_created, work_details, notes, percentage, status, subcon_reply, priority, client_reply, old_status


$sql = "SELECT * FROM workflow;";
$workflows = $db->fetchAll($sql);
foreach($workflows as $w){

     if($w['status'] == 'NEW'){
	     $status = 'new';
	 }else if($w['status'] == 'DONE'){
	     $status = 'finished';
	 }else{
	     $status = 'archived';
	 }
     $data = array('status' => $status);
	 $db->update('workflow', $data, 'id='.$w['id']);
	 
	 $result .= sprintf('<li>Task #%s updated</li>', $w['id']);
	 
}	

echo "<ol>".$result."</ol>";
?>