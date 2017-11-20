<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../function.php') ;
include('../lib/validEmail.php') ;
include('../time.php') ;
include('../AgentCurlMailSender.php') ;
include('../lib/staff_history.php');
include_once('../lib/staff_files_manager.php') ;
$sql = $db->select()->from("timezone_lookup", array("timezone AS timezone"));
$sql2 = $db->select()->distinct()->from("gs_job_titles_details", array("working_timezone AS timezone"));
$sql3 = $db->select()->union(array($sql, $sql2))->order("timezone");
$timezones = $db->fetchAll($sql3);
echo json_encode($timezones);