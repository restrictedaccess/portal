<?php
include('../conf/zend_smarty_conf.php');
include ('AdminBPActionHistoryToLeads.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

//check the user

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
	
	$admin_id = $_SESSION['admin_id'];
	$admin_status=$_SESSION['status'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	

}else{
	die("You cannot view this page");
}


$leads_id = $_REQUEST['leads_id'];
if(!$leads_id){
	die("Lead ID is misssing.");
}


//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		

header("Location:../leads_information.php?id=".$leads_id."&lead_status=".$leads_info['status']."&page_type=FALSE");
exit;	
//LEADS ALTERNATE EMAILS
$sql = $db->select()
	->from('leads_alternate_emails')
	->where('leads_id =?' , $leads_id);
$alternate_emails = $db->fetchAll($sql);	

//LEADS RATINGS
$rating = $leads_info['rating'];
if($rating == "") $rating =0;
//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
}


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
									<td width='100%' style='padding-left:15px;'>- ".$position['category_name']."</td>
									
									</tr>";
			}
	}
		

}

if($leads_info['csro_id']){
	$sql = $db->select()
		->from('admin')
		->where('admin_id =?' , $leads_info['csro_id']);
	$csro_officer = $db->fetchRow($sql);
}




$smarty->assign('csro_officer',$csro_officer);
$smarty->assign('job_positions',$job_positions);
$smarty->assign('starOptions' , $starOptions);
$smarty->assign('alternate_emails' , $alternate_emails);
$smarty->assign('leads_info' , $leads_info);
$smarty->display('index.tpl');
?>