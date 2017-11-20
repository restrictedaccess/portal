<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
include ('./AdminBPActionHistoryToLeads.php');
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];

/*	
$sql = $db->select()
	->from(array('i' => 'leads_inquiry') , Array('i.id'))
	->join(array('j' => 'job_category') , 'j.category_id = i.category_id' , Array('category_name'))
	->where('leads_id =?' , $leads_id);	
$job_positions = $db->fetchAll($sql);
*/

$sql = "SELECT counter , added_by_id , added_by_type, date_added FROM leads_inquiry WHERE leads_id =".$leads_id." GROUP BY counter;";
$counters = $db->fetchAll($sql);
foreach($counters as $counter){
	
	$det = new DateTime($counter['date_added']);
	//$date_added = $det->format("M. j, Y");
			
	$job_positions .= "<tr><td colspan=2><em>Added by ".getCreator($counter['added_by_id'] , $counter['added_by_type'] )." ".$date_added."</em></td></tr>";
	
	$sql = $db->select()
		->from(array('i' => 'leads_inquiry') , Array('i.id'))
		->join(array('j' => 'job_category') , 'j.category_id = i.category_id' , Array('category_name'))
		->where('leads_id =?' , $leads_id)
		->where('counter =?' , $counter['counter']);
	$positions = $db->fetchAll($sql);	
	if(count($positions)>0){
			foreach($positions as $position){
				$job_positions .="<tr>
									<td width='95%' style='padding-left:15px;'>- ".$position['category_name']."</td>
									<td width='5%'><a href='javascript:DeleteJobPosition(".$position['id'].")'>X</a></td>
									</tr>";
			}
	}
		

}


$smarty->assign('job_positions',$job_positions);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('ShowLeadInquiryPositions.tpl');	

?>