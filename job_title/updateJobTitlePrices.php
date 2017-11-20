<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$smarty = new Smarty();

if($_SESSION['admin_id']=="")
{
	die("Invalid Id of Admin");
}
$admin_id = $_SESSION['admin_id'];

$jr_name = $_REQUEST['jr_name'];
$currency = $_REQUEST['currency'];
$jr_list_id = $_REQUEST['jr_list_id'];


$entry_price = $_REQUEST['entry_price'];
$mid_price = $_REQUEST['mid_price'];
$expert_price = $_REQUEST['expert_price'];


if($entry_price == "") $entry_price = 0;
if($mid_price == "") $mid_price = 0;
if($expert_price == "") $expert_price = 0;

//jr_list_id, jr_cat_id, jr_name, jr_currency, jr_entry_price, jr_mid_price, jr_expert_price, jr_status
	

if($jr_list_id > 0){ 

	$sql = $db->select()
		->from('job_role_cat_list')
		->where('jr_list_id = ?' ,$jr_list_id);
	$job_position = $db->fetchRow($sql);	
	
	//update
	$data = array(
				   'jr_entry_price' => $entry_price, 
				   'jr_mid_price' => $mid_price, 
				   'jr_expert_price' => $expert_price
			   );
	$where = "jr_list_id = ".$jr_list_id;	
	$db->update('job_role_cat_list', $data , $where);	
	
	
	if($job_position['jr_entry_price'] != $entry_price){
		$history = sprintf('%s %s entry level price change from %s to %s' , $job_position['jr_name'] , $currency ,$job_position['jr_entry_price'] , $entry_price);
		//Add history
		$data = array('jr_list_id' => $jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
		$db->insert('job_role_cat_list_history' , $data);
	}
	
	if($job_position['jr_mid_price'] != $mid_price){
		$history = sprintf('%s %s mid level price change from %s to %s' , $job_position['jr_name'] , $currency , $job_position['jr_mid_price'] , $mid_price);
		//Add history
		$data = array('jr_list_id' => $jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
		$db->insert('job_role_cat_list_history' , $data);
	}
	
	if($job_position['jr_expert_price'] != $expert_price){
		$history = sprintf('%s %s expert level price change from %s to %s' , $job_position['jr_name'] , $currency , $job_position['jr_expert_price'] , $expert_price);
		//Add history
		$data = array('jr_list_id' => $jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
		$db->insert('job_role_cat_list_history' , $data);
	}
	
		   
}else{

	
	$sql = $db->select()
			->from('job_role_cat_list')
			->where('jr_name = ? ' , $jr_name)
			->group('jr_name');
	$result = $db->fetchRow($sql);		
	$jr_cat_id = $result['jr_cat_id'];
	
	
	$data = array(
				   'jr_cat_id' => $jr_cat_id, 
				   'jr_name' => $jr_name,
				   'jr_currency' => $currency,
				   'jr_entry_price' => $entry_price, 
				   'jr_mid_price' => $mid_price, 
				   'jr_expert_price' => $expert_price
			   );
	$db->insert('job_role_cat_list',$data);	
	$jr_list_id = $db->lastInsertId();
	
	
	$history = sprintf('%s level prices added for currency %s ' , $jr_name , $currency);
	//Add history
	$data = array('jr_list_id' => $jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
	$db->insert('job_role_cat_list_history' , $data);
	
}


$sql = $db->select()
			->from('job_role_cat_list')
			->where('jr_list_id = ? ' , $jr_list_id);
$result = $db->fetchRow($sql);	


$smarty->assign('jr_name',$jr_name);
$smarty->assign('jr_list_id',$jr_list_id);
$smarty->assign('currency',$currency);
$smarty->assign('result',$result);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('updateJobTitlePrices.tpl');




?>