<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/JobOrderRecruitmentLoader.php";
$loader = new JobOrderRecruitmentLoader($db);
function cmp2($a, $b)
{
    return strcmp($b['db_timestamp'], $a['db_timestamp']);
}
//get input

$smarty = new Smarty();
if (!isset($_GET["service_type"])){
	$recruiter_id = $_GET["recruiter_id"];
	$team = $_REQUEST["team"];
    $team_liz = array(185, 213, 140, 231, 238, 100);
    $team_pau = array(125, 153, 192, 212, 209, 201);
	$type = $_GET["type"];
	if ($recruiter_id=="All"){
	    
		$recruiters = $loader->getShortlistedOpenOrder();
		$shortlisted = array();
		foreach($recruiters as $recruiter){
		    if ($team=="liz"&&!in_array($recruiter["admin_id"],$team_liz)){
                continue;
            }else if ($team=="pau"&&!in_array($recruiter["admin_id"],$team_pau)){
                continue;
            }else if ($team=="other"&&(in_array($recruiter["admin_id"], $team_liz)||in_array($recruiter["admin_id"], $team_pau))){
                continue;
            }
            
			$candidates =  $recruiter[$type];
			foreach($candidates as $candidate){
				$shortlisted[] = $candidate;
			}
		}
		if ($team=="liz"){
            $recruiter_name = "CUSTOM TEAM A - Liz";
        }else if ($team=="pau"){
            $recruiter_name = "CUSTOM TEAM B - Paulo";
        }else{
            $recruiter_name = "Talent Acquisition / Recruitment Support";
        }
	}else{
		$recruiter = $loader->getShortlistedOpenOrderRecruiter($recruiter_id);
		$shortlisted = $recruiter[$type];
		
		$recruiter_name = $recruiter["admin_fname"]." ".$recruiter["admin_lname"];
	}
	foreach($shortlisted as $key=>$candidate){
		$shortlisted[$key]["db_timestamp"] = strtotime($candidate["date"]);
	}
	
	usort($shortlisted, 'cmp2');
	$smarty->assign("shortlisted", $shortlisted);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->assign("team", $team);
	
	if ($type=="assigned"){
		$smarty->assign("type", "Assigned");
	}else{
		$smarty->assign("type", "Unassigned");
	}
	$smarty->assign("total_shortlist", count($shortlisted));	
}else{
	$service_type = $_GET["service_type"];
	$shortlisted = $loader->getShortlistedOpenOrderServiceType($service_type);
	foreach($shortlisted as $key=>$candidate){
		$shortlisted[$key]["db_timestamp"] = strtotime($candidate["date"]);
	}
	
	usort($shortlisted, 'cmp2');
	$smarty->assign("shortlisted", $shortlisted);
	$smarty->assign("recruiter_name", "ALL Recruiters");
	$smarty->assign("type", $service_type);
	$smarty->assign("total_shortlist", count($shortlisted));
}

$smarty->display("recruitment_shortlisted_details.tpl");
