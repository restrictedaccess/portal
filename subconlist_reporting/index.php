<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

//die("Sorry This page is unde maintenance. Doing some updates.<br>Norman M.");

$from = date('Y-m-d') ;
$to = date('Y-m-d') ;


//get all clients with active staff
$sql = "SELECT s.leads_id , l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status IN ('ACTIVE','suspended') GROUP BY s.leads_id ORDER BY l.fname;";
$clients = $db->fetchAll($sql);

//echo "<br>";
//echo count($clients);



//get all clients with active staff
$sql = "SELECT s.leads_id FROM subcontractors s WHERE s.status IN ('terminated','resigned') GROUP BY s.leads_id;";
$inactive_clients = $db->fetchAll($sql);

$ACTIVE_CLIENTS = array();
$INACTIVE_CLIENTS = array();
$leads_id_str ="";

$CLIENTS=array();
foreach($clients as $client){
	$ACTIVE_CLIENTS[]=$client['leads_id'];
	$CLIENTS[] = $client['leads_id'];
}

foreach($inactive_clients as $client){
	
	if(!in_array($client['leads_id'],$ACTIVE_CLIENTS)){
		//$CLIENTS[] = $client['leads_id'];
		$leads_id_str .=sprintf('%s,',$client['leads_id']);
	}
}
$leads_id_str=substr($leads_id_str,0,(strlen($leads_id_str)-1));
$sql = "SELECT (id)AS leads_id , l.fname, l.lname FROM leads l WHERE id IN ($leads_id_str) ORDER BY l.fname;";
//echo $sql;exit;
$inactive_clients = $db->fetchAll($sql);

//echo "<br>";
//echo count($inactive_clients);


$sql = "SELECT admin_id, admin_fname, admin_lname FROM admin WHERE csro='Y' AND status IN('COMPLIANCE','HR','FULL-CONTROL','FINANCE-ACCT') ORDER BY admin_fname";
$csros = $db->fetchAll($sql);

$smarty->assign('csros', $csros);
$smarty->assign('CLIENT_TYPE', $CLIENT_TYPE);
$smarty->assign('clients', $clients);
$smarty->assign('inactive_clients', $inactive_clients);
$smarty->assign('from', $from);
$smarty->assign('to', $to);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('index.tpl');
?>