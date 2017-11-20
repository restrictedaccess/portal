<?php
include('conf/zend_smarty_conf_root.php');

$status = $_REQUEST["status"];
$userid = $_REQUEST["userid"];
$admin_id = $_REQUEST["admin_id"];

//START - applicant status
$data = array(
'personal_id' => $userid,
'admin_id' => $admin_id,
'status' => $status,
'date' => date("Y-m-d")
);
$db->insert('applicant_status', $data);

$applicant_status_report = "";
$counter = 1;
$q ="SELECT ap.status, ap.date, a.admin_fname, a.admin_lname FROM applicant_status ap, admin a WHERE a.admin_id = ap.admin_id AND ap.personal_id = '$userid' AND a.admin_id='$admin_id';";
$result = $db->fetchAll($q);
foreach($result as $r)
{
	$applicant_status_report = $applicant_status_report.$counter.") ".$r['status']."&nbsp;<font size=1><em>(".$r['admin_fname']." ".$r['admin_lname']."-".$r['date'].")</em></font><br />";
	$counter++;
}

echo $applicant_status_report;
//ENDED - applicant status
?>