<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');

$service_type = $_REQUEST["service_type"];
$userid = $_REQUEST["userid"];
$admin_id = $_REQUEST["admin_id"];


//START: insert staff history
include('../lib/staff_history.php');
staff_history($db, $userid, $admin_id, 'ADMIN', 'STAFF RESUME UP TO DATE', 'INSERT', '');	
//ENDED: insert staff history


//START: update the date updated field on the personal table
$stat = mysql_query("UPDATE personal SET dateupdated='".date("Y-m-d")." ".date("H:i:s")."' WHERE userid='$userid'");
//ENDED: update the date updated field on the personal table


//START - applicant status
$data = array(
'userid' => $userid,
'admin_id' => $admin_id,
'date' => date("Y-m-d")." ".date("H:i:s")
);
$db->insert('staff_resume_up_to_date', $data);
$stat = mysql_query("SELECT id FROM staff_resume_up_to_date WHERE userid='$userid'");
$ctr = mysql_num_rows($stat);
$applicant_status_report_counter = $ctr;
echo '<a href="javascript: staff_resume_up_to_date_report('.$userid.'); "><font color="#FF0000"><strong>'.$applicant_status_report_counter.'</strong></font></a>';
//ENDED - applicant status
?>