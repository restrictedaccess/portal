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
$title_name = trim($_REQUEST['title_name']);

$data = array('jr_name' => $title_name);
$where = "jr_name = '".$jr_name."'";	
$db->update('job_role_cat_list', $data , $where);	


$sql = $db->select()
		->from('job_role_cat_list')
		->where('jr_name = ?' , $title_name);
$jr_names = $db->fetchAll($sql);
foreach($jr_names as $position){
	$jr_list_id = $position['jr_list_id']; 
	//echo $jr_list_id."<br>";
	//Add history
	$history = sprintf('%s name change to  %s for currency %s' , $jr_name , $title_name , $position['jr_currency'] );
	$data = array('jr_list_id' => $jr_list_id , 'change_by_id' => $admin_id , 'history' => $history, 'date_change' => $ATZ);
	//echo $data;
	$db->insert('job_role_cat_list_history' , $data);
}	
	
echo $title_name;		   
//echo "updated";
//print_r($where);
/*
$smarty->assign('jr_name',$jr_name);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('updateJobTitlePrices.tpl');
*/



?>