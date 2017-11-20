<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/JobOrderRecruitmentLoader.php";
function cmp2($a, $b)
{
    return strcmp($b['db_timestamp'], $a['db_timestamp']);
}
$recruiter_id = $_REQUEST["recruiter_id"];
$loader = new JobOrderRecruitmentLoader($db);
$smarty = new Smarty();
if ($recruiter_id!="ALL"){
	//recruiter_name
	$admin = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("a.admin_fname", "a.admin_lname"))->where("admin_id = ?", $recruiter_id));	
	$orders = $loader->getOpenOrdersByRecruiterList($recruiter_id);
	foreach($orders as $key=>$order){
		$orders[$key]["db_timestamp"] = strtotime($order["date_filled_up_orig"]);
	}
	usort($orders, 'cmp2');
	$smarty->assign("recruiter_name", $admin["admin_fname"]." ".$admin["admin_lname"]);
}else{
	$team = $_REQUEST["team"];
    $team_liz = array(185, 213, 140, 231, 238, 100);
    $team_pau = array(125, 153, 192, 212, 209, 201);
	$recruiters = $loader->getRecruiters();
	$result = array();
	foreach($recruiters as $recruiter){
		if ($team=="liz"&&!in_array($recruiter["admin_id"],$team_liz)){
		    continue;
		}else if ($team=="pau"&&!in_array($recruiter["admin_id"],$team_pau)){
            continue;
        }else if ($team=="other"&&(in_array($recruiter["admin_id"], $team_liz)||in_array($recruiter["admin_id"], $team_pau))){
            continue;
        }
		$recruiter_id = $recruiter["admin_id"];
		$orders = $loader->getOpenOrdersByRecruiterList($recruiter_id);
		foreach($orders as $key=>$order){
			$orders[$key]["db_timestamp"] = strtotime($order["date_filled_up_orig"]);
		}
		foreach($orders as $order){
			$result[] = $order;
		}
	}
	$orders = $result;
	usort($orders, 'cmp2');
    if ($team=="liz"){
        $recruiter_name = "CUSTOM TEAM A - Liz";
    }else if ($team=="pau"){
        $recruiter_name = "CUSTOM TEAM B - Paulo";
    }else{
        $recruiter_name = "Talent Acquisition / Recruitment Support";
    }
    
    
    
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->assign("recruiter_type", strtoupper($recruiter_type));
}
$smarty->assign("orders", $orders);
$smarty->display("open_job_orders_recruiter.tpl");
	

