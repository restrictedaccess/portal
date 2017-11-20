<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');

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
$applicant_status_report_counter = 0;
$stat = mysql_query("SELECT id FROM applicant_status WHERE personal_id='$userid'");
$ctr = mysql_num_rows($stat);
$applicant_status_report_counter = @$ctr;
echo '<a href="javascript: staff_information_status_report('.$userid.'); "><font color="#FF0000"><strong>'.@$applicant_status_report_counter.'</strong></font></a>';
//ENDED - applicant status
?>