<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}

if($_SESSION['admin_id']!="43") {
    die("You are not allowed to access this page. For Anne Only :)");
}  

$sql = "SELECT id, client_id, 
STATUS , created_by_id, date_created, work_details
FROM workflow
WHERE  `client_id` =11
AND  `status` in  ('new' , 'finished')
AND  `staff_name_search_str` LIKE  '%Anne Charise%'
ORDER BY  `workflow`.`id` DESC ";

$wf = $db_query_only->fetchAll($sql);
//echo "<pre>";
//print_r($applicants);
//echo "</pre>";
foreach($wf as $wf){
	$data[]=array(
		'id' => $bg['id'],
		'created_by_id' => $wf['created_by_id'],
		'date_created' => $wf['date_created'],
		'work_details' => $wf['work_details'],
		'STATUS' => $wf['STATUS'],
	);
}

$smarty->assign('row_results',count($wf));
$smarty->assign('wf' , $data);
$smarty->display('devs_wf.tpl');
?>