<?php
include('../conf/zend_smarty_conf.php') ;

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

$userid = $_REQUEST["userid"];
$type = $_REQUEST["type"];

$counter = 0;
if($type == "staff files")
{
	$q = "SELECT * FROM tb_applicant_files WHERE file_description NOT IN ('RESUME', 'SAMPLE WORK', 'MOCK CALLS', 'OTHER', 'HOME OFFICE PHOTO') AND userid='$userid'";
}
else
{
	$q = "SELECT * FROM tb_applicant_files WHERE (file_description = 'RESUME' OR file_description = 'SAMPLE WORK' OR file_description = 'MOCK CALLS' OR file_description = 'OTHER' OR file_description = 'HOME OFFICE PHOTO') AND userid='$userid'";
}

$staff_files_set = Array();
$sf = $db->fetchAll($q);	
foreach($sf as $row)
{
	$staff_files['id']=$row["id"];
	$staff_files['userid']=$row["userid"];
	$staff_files['file_description']=$row["file_description"];
	$staff_files['name']=$row["name"];
	$staff_files['permission']=$row["permission"];
	$staff_files['date_created']=$row["date_created"];
	$staff_files_set[]=$staff_files;
}

$smarty->assign('staff_files_set', $staff_files_set);
$smarty->assign('type', $type);
$smarty->assign('userid', $userid);
$smarty->assign("TEST", TEST);
$smarty->display('staff_files_uploaded.tpl');
?>