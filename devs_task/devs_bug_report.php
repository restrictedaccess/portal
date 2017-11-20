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

$sql = "SELECT br.id, br.report_title, br.assignto, br.assignto_ref, br.STATUS , br.resolution, br.creation_date, bn.note_content 
FROM bug_reports as br
left join bugreport_notes as bn on br.id = bn.report_id
WHERE br.STATUS IN ( 'new',  'assigned') AND br.resolution in ( 'open')  
ORDER BY  br.creation_date DESC";
$bg = $db_query_only->fetchAll($sql);
//echo "<pre>";
//print_r($applicants);
//echo "</pre>";
foreach($bg as $bg){
	$data[]=array(
		'id' => $bg['id'],
		'report_title' => $bg['report_title'],
		'assignto_ref' => $bg['assignto_ref'],
		'assignto' => $bg['assignto'],
		'STATUS' => $bg['STATUS'],
		'note_content' => $bg['note_content'],
		'resolution' => $bg['resolution'],
		'creation_date' => $bg['creation_date']
	);
}

$smarty->assign('row_results',count($bg));
$smarty->assign('bg' , $data);
$smarty->display('devs_bug_report.tpl');
?>