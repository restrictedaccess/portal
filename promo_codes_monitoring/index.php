<?php
include '../conf/zend_smarty_conf.php';

if($_SESSION['admin_id']){
    $session_data = sprintf('admin_id=%s', $_SESSION['admin_id']);	
}else if($_SESSION['agent_no']){
    $session_data = sprintf('manager_id=%s', $_SESSION['manager_id']);	
}else{
    header("location:../");
    exit;
}
//echo $session_data;
//exit;

$smarty = new Smarty();

$sql="SELECT count(t.id), t.tracking_createdby, a.fname, a.lname, a.work_status FROM tracking t JOIN agent a ON a.agent_no=t.tracking_createdby
WHERE t.tracking_createdby IS NOT NULL
GROUP BY t.tracking_createdby ORDER BY a.fname;";
//echo $sql;
$creators = $db->fetchAll($sql);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$tracking_createdby = $_POST['tracking_createdby'];
	if($tracking_createdby){
		$sql="SELECT id, tracking_no, tracking_desc, tracking_created, points FROM tracking WHERE tracking_createdby =".$tracking_createdby;
		//echo $sql."<br>";
		$codes = $db->fetchAll($sql);
		$smarty->assign('codes', $codes);
	}
}

/*
$promotional_codes=array();
foreach($creators as $creator){
    if($creator['tracking_createdby'] !=""){
		$sql="SELECT id, tracking_no, tracking_desc, tracking_created, points FROM tracking WHERE tracking_createdby =".$creator['tracking_createdby'];
		//echo $sql."<br>";
		$codes = $db->fetchAll($sql);
	}
    
	
	$data=array(
		'agent' => $creator,
		'codes' => $codes
	);
	$promotional_codes[]=$data;
}
*/

//print_r($promotional_codes);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->assign('creators', $creators);
$smarty->assign('tracking_createdby', $tracking_createdby);
$smarty->display('index.tpl');
?>