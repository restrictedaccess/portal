<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');

$service_type = $_REQUEST["service_type"];
$userid = $_REQUEST["userid"];
$admin_id = $_REQUEST["admin_id"];


//START: insert staff history
include('../lib/staff_history.php');
staff_history($db, $userid, $admin_id, 'ADMIN', 'NO SHOW', 'INSERT', $service_type);	
//ENDED: insert staff history


//START - applicant status
$data = array(
'userid' => $userid,
'admin_id' => $admin_id,
'service_type' => $service_type,
'date' => date("Y-m-d")." ".date("H:i:s")
);
$db->insert('staff_no_show', $data);
$applicant_status_report_counter = 0;
$stat = mysql_query("SELECT id FROM staff_no_show WHERE userid='$userid'");
$ctr = mysql_num_rows($stat);
$no_show_counter = @$ctr;
echo '<a href="javascript: staff_no_show_report('.$userid.'); "><font color="#FF0000"><strong>'.@$no_show_counter.'</strong></font></a>';
//ENDED - applicant status
?>