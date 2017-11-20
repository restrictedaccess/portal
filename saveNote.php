<?php
include('conf/zend_smarty_conf_root.php');
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	//$session_name = $agent['fname']." ".$agent['lname'];
	$session_name = $agent['fname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'BP';
	
	
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	//$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_name = $admin['admin_fname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'ADMIN';


		

}else{
	die("Session Id is missing");
}

$leads_id = $_REQUEST['leads_id'];
$remarks = $_REQUEST['note'];

$remark_created_by = $created_by_type." : ".$session_name;

$data = array('leads_id' => $leads_id, 
			  'remark_creted_by' => $remark_created_by, 
			  'created_by_id' => $created_by_id, 
			  'remark_created_on' => $ATZ,
 			  'remarks' => $remarks
			  );
$db->insert('leads_remarks', $data);

$det = new DateTime($ATZ);
$remark_created_on = $det->format("m/j/Y "); 	
echo "<a href=\"javascript:popup_win('./viewRemarks.php?leads_id=".$leads_id."',600,600);\">".$remark_created_on." ".$remark_created_by." ".substr(rtrim(ltrim($remarks)),0,60)."</a>";

//echo "<a href=\"javascript:popup_win('./viewRemarks.php?leads_id=".$leads_id."',600,600);\">".substr(rtrim(ltrim($remarks)),0,60)."</a>"; 	
?>