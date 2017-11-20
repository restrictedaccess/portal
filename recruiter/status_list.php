<?php

include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
error_reporting(-1);
$status = $_GET['status'];

$smarty = new Smarty;

$select="SELECT lname,fname
	from personal 
	WHERE userid = ".$_GET['userid']; 
$applicant = $db->fetchRow($select);

if($status == 'shortlisted'){
	$select="SELECT tsh.userid,fname,lname,jobposition,date_listed,admin_fname,admin_lname 
		FROM tb_shortlist_history as tsh 
		join posting as p on p.id=tsh.position join leads as l on p.lead_id = l.id 
		left join recruiter_staff as rs on rs.userid=tsh.userid
		left join admin as a on rs.admin_id = a.admin_id 
		WHERE tsh.userid = ".$_GET['userid'];
		
	$list = $db->fetchAll($select); 
}
if($status == 'endorsed'){
	$select="SELECT teh.userid,client_name,jobposition,jsc.sub_category_name,date(date_endoesed) as date_listed,fname,lname,admin_fname,admin_lname
		FROM tb_endorsement_history as teh
		left join posting as p on p.id=teh.position
		left join job_sub_category as jsc on jsc.sub_category_id=teh.job_category
		join leads as l on teh.client_name = l.id
		left join admin as a on teh.admin_id = a.admin_id
		WHERE teh.userid = ".$_GET['userid'];
	$list = $db->fetchAll($select); 
}



$smarty->assign('status', $status);
$smarty->assign('applicant', $applicant);
$smarty->assign('list', $list);
$smarty->display('status_list.tpl');


?>