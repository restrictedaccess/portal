<?php
include './conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$leads_id=$_REQUEST['leads_id'];
if($leads_id==""){
	die("Leads ID is missing");
}

$id=$_REQUEST['id'];
if($id){
	//delete record 
	$where = "id = ".$id;	
	$db->delete('leads_remarks' ,  $where);
}

$sqlGetAllRemarks = $db->select()
	->from('leads_remarks')
	->where('leads_id =?',$leads_id)
	->order('id DESC');
$remarks = $db->fetchAll($sqlGetAllRemarks);


$sql ="SELECT * FROM leads WHERE id = $leads_id;";
$leads_info = $db->fetchRow($sql);


$smarty->assign('leads_id' , $leads_id);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('remarks' , $remarks);

$smarty->display('viewRemarks.tpl');
?>


