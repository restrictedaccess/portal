<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
include '../lib/CountryStates.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'bp';
	$merged_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
	$merged_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];
$leads_country = $_REQUEST['leads_country'];
$mode = $_REQUEST['mode'];

if($mode == 'default'){
	$sql = $db->select()
		->from('leads' , 'state')
		->where('id =?' , $leads_id);
	$state = $db->fetchOne($sql);
}else{
}


//if (in_array($leads_country, array('Australia' , 'United States' , 'United Kingdom')) == true) {
//	//select box
//}else{
//	//input text
//}

$state_list = GetCountryStatesList($leads_country);
if(count($state_list) > 0){
	for ($i = 0; $i < count($state_list); $i++) {
		if($state == $state_list[$i]){
			$stateoptions .= "<option selected value='".$state_list[$i]."'>".$state_list[$i]."</option>\n";
		}else{
			$stateoptions .= "<option value='".$state_list[$i]."'>".$state_list[$i]."</option>\n";
		}
	}
}

$smarty->assign('state',$state);
$smarty->assign('state_list_count',count($state_list));
$smarty->assign('stateoptions',$stateoptions);
$smarty->display('GetLeadsCountryState.tpl');
?>
