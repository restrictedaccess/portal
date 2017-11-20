<?php
include '../conf/zend_smarty_conf.php';
include './functions.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);	

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

if($from !="" and $to ==""){
	$to=date('Y-m-d');
}



if($_REQUEST['leads_id']){
	$conditions .= " AND s.leads_id = '".$_REQUEST['leads_id']. "'";
}


$CLIENTS=array();
$sql = "SELECT l.id, l.fname, l.lname,  l.email,  a.admin_id, a.admin_fname, a.admin_lname FROM leads l LEFT JOIN admin a ON a.admin_id = l.csro_id WHERE l.id =".$_REQUEST['leads_id'];

$client = $db->fetchRow($sql);

$sql = "SELECT s.id, s.userid, s.starting_date, (s.status)AS contract_status, s.date_terminated, s.resignation_date, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE ( s.status<>'deleted' ) AND s.leads_id=".$_REQUEST['leads_id']." ORDER BY p.fname;";
$subcons = $db->fetchAll($sql);
$CLIENT=array(
    'client' => $client,
	'subcons' => $subcons,
	'histories' => LeadsHistory($_REQUEST['leads_id'], $from, $to),
);
//echo "<pre>";
//print_r($CLIENTS);
//echo "</pre>";
$smarty->assign('client', $CLIENT);
$smarty->display('client_csro_name_changed_history.tpl');
?>