<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$leads_id=$_REQUEST['leads_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$created_by_condition =" AND created_by = $created_by_id AND created_by_type = 'agent' ";
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$created_by_condition ="";

}else{

	die("Session expires. Please re-login.");
}


// sql condition search by leads
if($leads_id!=NULL){
	$leadsCondition=" AND leads_id = $leads_id ";
}else{
	$leadsCondition="";
}


$sql = "SELECT q.id , CONCAT(l.fname,' ',l.lname)AS leads_name ,created_by,created_by_type,q.status , q.quote_no FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.status != 'deleted'  $leadsCondition $created_by_condition  ORDER BY date_quoted DESC;";
$quotes = $db->fetchAll($sql);

$quote_list_new = array();
$quote_list_posted = array();
foreach($quotes as $q){
    $q['creator'] = getCreator($q['created_by'], $q['created_by_type']);
	if($q['status'] == 'new'){
	    array_push($quote_list_new, $q);
	}
	if($q['status'] == 'posted'){
	    array_push($quote_list_posted, $q);
	}	
}

$smarty->assign('quote_list_new', $quote_list_new);
$smarty->assign('quote_list_posted', $quote_list_posted);
$smarty->display('show_all_lead_quotes.tpl');
?>