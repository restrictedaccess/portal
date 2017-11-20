<?php
include './conf/zend_smarty_conf.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if($_SESSION['userid']==""){
	header("location:index.php");
	exit;
}

//get all client of staff
$sql = "SELECT leads_id FROM subcontractors WHERE status IN ('ACTIVE', 'suspended') AND userid=".$_SESSION['userid'];
//echo $sql;
$clients = $db->fetchAll($sql);

$client_csros=array();
foreach($clients as $client_id){
	$sql= $db->select()
		->from('leads', 'csro_id')
		->where('id=?', $client_id);
	$csro_id = $db->fetchOne($sql);	
	$client_csros[]=$csro_id;	
}


$sql = "SELECT admin_id, admin_fname, admin_email, extension_number, local_number, skype_id, work_schedule FROM admin a WHERE csro='Y' AND status NOT IN('PENDING','REMOVED') ORDER BY admin_fname ASC;";
$csros = $db->fetchAll($sql);



$query="SELECT * FROM personal WHERE userid=".$_SESSION['userid'];
$result = $db->fetchRow($query);
$name = $result['fname']." ".$result['lname'];

$smarty->assign('client_csros', $client_csros);
$smarty->assign('csros', $csros);
$smarty->assign('name', $name);
$smarty->display('admin_contact_details.tpl')
?>