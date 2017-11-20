<?php
include('../conf/zend_smarty_conf.php');
include '../BD/lib/AddAgentHistoryChanges.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if(!$_SESSION['agent_no']){
	die("Session Id is missing");
}
	
$column_name = $_REQUEST['column_name'];
$column_value = $_REQUEST['column_value'];
$mode = $_REQUEST['mode'];

if($column_name == 'business_developer_id'){
	$column_field = 'view_leads_setting';
}

if($column_name == 'order_by'){
	$column_field = 'leads_order_by_setting';
}

//echo $_SESSION['agent_no']." <br>".$column_name."<br>".$column_value."<br>".$mode;


if($mode == 'save'){
	if($column_value == ""){
		$column_value = NULL;
	}
	$data = array($column_field => $column_value);
}else{
	$column_value = NULL;
	$data = array($column_field => $column_value);
}

AddAgentHistoryChanges($data , $_SESSION['agent_no'], $_SESSION['agent_no'] , 'agent');
$where = "agent_no = ".$_SESSION['agent_no'];
//print_r($data);
$db->update('agent' , $data , $where);
echo $mode." setting";
?>