<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/JobOrderCounter.php";
require_once "reports/JobOrderRecruitmentLoader.php";

if (!isset($_SESSION["admin_id"])){
	header("Location:/portal/");
	die;
}
$counter = new JobOrderCounter($db);
$loader = new JobOrderRecruitmentLoader($db);

$smarty =  new Smarty();
$open_orders = $counter->getSummaryView();
$shortlists = $loader->getShortlistedOpenOrdersRecruiters();
$smarty->assign("open_orders", $open_orders["totalOpenOrders"]);
$smarty->assign("summary", $open_orders);
$smarty->assign("shortlists", $shortlists);
$openOrderRecruiters = $loader->getOpenOrdersRecruiters();
$assignedOpenOrder = 0;

$assignedOpenOrderCustom = 0;
$assignedOpenOrderPooling = 0;
$assignedOpenOrderOther = 0;


foreach($openOrderRecruiters as $recruiter){
	if ($recruiter["recruiter_type"]=="pooling"){
		$assignedOpenOrderPooling += $recruiter["open_orders"];
	}else if ($recruiter["recruiter_type"]=="custom"){
		$assignedOpenOrderCustom += $recruiter["open_orders"];
	}else{
		$assignedOpenOrderOther += $recruiter["open_orders"];
	}
	
	$assignedOpenOrder += $recruiter["open_orders"];
}
$smarty->assign("total_assigned", $assignedOpenOrder);
$smarty->assign("total_assigned_pooling", $assignedOpenOrderPooling);
$smarty->assign("total_assigned_custom", $assignedOpenOrderCustom);
$smarty->assign("total_assigned_other", $assignedOpenOrderOther);

$smarty->assign("open_orders_recruiters", $openOrderRecruiters);
$smarty->assign("recruiter_shortlists", $shortlists["recruiter"]);


//new grouping as per liz
$team_liz = array(185, 213, 140, 231, 238, 100, 262);
$team_pau = array(125, 153, 192, 212, 209, 201);

$assignedOpenOrderTeamLiz = 0;
$assignedOpenOrderTeamPau = 0;
$assignedOpenOrderTeamOthers = 0;

$assignedOpenOrderLiz = array();
$assignedOpenOrderPau = array();
$assignedOpenOrderOthers = array();

foreach($openOrderRecruiters as $recruiter){
    if (in_array($recruiter["admin_id"], $team_liz)){
        $assignedOpenOrderTeamLiz += $recruiter["open_orders"];
        $assignedOpenOrderLiz[] = $recruiter;
    }else if (in_array($recruiter["admin_id"], $team_pau)){
        $assignedOpenOrderTeamPau += $recruiter["open_orders"];
        $assignedOpenOrderPau[] = $recruiter;
    }else{
        $assignedOpenOrderTeamOthers += $recruiter["open_orders"];
        $assignedOpenOrderOthers[] = $recruiter;
    }
}



$smarty->assign("assignedOpenOrderTeamLiz", $assignedOpenOrderTeamLiz);
$smarty->assign("assignedOpenOrderTeamPau", $assignedOpenOrderTeamPau);
$smarty->assign("assignedOpenOrderTeamOthers", $assignedOpenOrderTeamOthers);

$smarty->assign("assignedOpenOrderLiz", $assignedOpenOrderLiz);
$smarty->assign("assignedOpenOrderPau", $assignedOpenOrderPau);
$smarty->assign("assignedOpenOrderOthers", $assignedOpenOrderOthers);


$shortlist_recruiters = $shortlists["recruiter"];
$shortlist_liz = array();
$shortlist_pau = array();
$shortlist_other = array();

$totalassigned_liz = 0;
$totalassigned_pau = 0;
$totalassigned_others = 0;


$totalunassigned_liz = 0;
$totalunassigned_pau = 0;
$totalunassigned_others = 0;

foreach($shortlist_recruiters as $recruiter){
     if (in_array($recruiter["admin_id"], $team_liz)){
        $shortlist_liz[] = $recruiter;
        $totalassigned_liz += $recruiter["assigned"];
        $totalunassigned_liz += $recruiter["unassigned"];
    }else if (in_array($recruiter["admin_id"], $team_pau)){
        $shortlist_pau[] = $recruiter;
        $totalassigned_pau += $recruiter["assigned"];
        $totalunassigned_pau += $recruiter["unassigned"];
    }else{
        $shortlist_other[] = $recruiter;
        $totalassigned_others += $recruiter["assigned"];
        $totalunassigned_others += $recruiter["unassigned"];
    }
}

$smarty->assign("shortlist_liz", $shortlist_liz);
$smarty->assign("shortlist_pau", $shortlist_pau);
$smarty->assign("shortlist_other", $shortlist_other);

$smarty->assign("totalassigned_liz", $totalassigned_liz);
$smarty->assign("totalunassigned_liz", $totalunassigned_liz);

$smarty->assign("totalassigned_pau", $totalassigned_pau);
$smarty->assign("totalunassigned_pau", $totalunassigned_pau);

$smarty->assign("totalassigned_others", $totalassigned_others);
$smarty->assign("totalunassigned_others", $totalunassigned_others);

$smarty->display("recruiter_job_orders_view_summary.tpl");
