<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();


$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];
$invoice_id = $_REQUEST['invoice_id'];
//get the notes/comments
function getName($created_by_id, $created_by_type){
	global $db;
	
	if($created_by_id != ""){
			if($created_by_type == 'admin'){
				$sql = $db->select()
					->from('admin' , 'admin_fname')
					->where('admin_id = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'Admin '.$name;
			}
			
			else if($created_by_type == 'bp'){
				$sql = $db->select()
					->from('agent' , 'fname')
					->where('agent_no = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'BP '.$name;
			}
			
			else if($created_by_type == 'leads'){
				$sql = $db->select()
					->from('leads' , 'fname')
					->where('id = ?' , $created_by_id);
				$name = $db->fetchOne($sql);	
				return 'Lead '.$name;
			}
			
			else{
				return 'Anonymous';
			}
	}
}

$sql = $db->select()
	->from('gs_admin_notes')
	->where('invoice_id = ?' , $invoice_id)
	->where('gs_job_role_selection_id = ?' , $gs_job_role_selection_id);
//echo $sql;	
$notes = $db->fetchAll($sql);
$messages = array();
foreach($notes as $note){
	$data = array('name' => getName($note['created_by_id'] , $note['created_by_type']) , 'notes' => $note['notes'] , 'date_created' => $note['date_created']);
	array_push($messages ,$data);
}

$smarty->assign("messages", $messages);	
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");

$smarty->display('showComments.tpl');

?>
