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


$jr_cat_id = $_REQUEST['jr_cat_id'];
$jr_name = trim($_REQUEST['jr_name']);

//SELECT * FROM job_role_cat_list j;
//jr_list_id, jr_cat_id, jr_name, jr_currency, jr_entry_price, jr_mid_price, jr_expert_price, jr_status
$sql = $db->select()
	->from('job_role_cat_list' ,'jr_list_id')
	->where('jr_status = ?' , 'system' )
	->where('jr_name = ?' ,$jr_name);
	
$jr_list_id = $db->fetchOne($sql);	
	
if($jr_list_id > 0){
	echo $jr_list_id;
	exit();
}else{

	//get all currencies
	$sql2 = $db->select()
		->from('currency_lookup','code');
	$currencies = $db->fetchAll($sql2);

	foreach($currencies as $currency){
		$code = $currency['code'];
		if($code != "PHP"){
			$data = array('jr_cat_id' => $jr_cat_id, 'jr_name' => $jr_name , 'jr_currency' => $code );
			$db->insert('job_role_cat_list',$data);	
			$new_jr_list_id = $db->lastInsertId();
			
			//Add history
			$history = "New Job Position ".$jr_name." added successfully for currency ".$code; 
			$data = array('jr_list_id' => $new_jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
			$db->insert('job_role_cat_list_history' , $data);

		}
	}
	echo $jr_name;
	
	
	
	
}
/*
//$smarty->assign('currencies',$currencies);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('addJobTitle.tpl');
*/
?>