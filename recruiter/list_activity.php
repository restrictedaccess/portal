<?php
mb_internal_encoding("UTF-8");
ini_set("max_execution_time", 300);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';

require_once "reports/RecruitmentActivityLister.php";

$type = $_GET["type"];
$recruiter_id = $_GET["recruiter_id"];

$smarty = new Smarty();
$lister = new RecruitmentActivityLister($db);

//get admin info
if ($recruiter_id!="All"){
	$admin = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("a.admin_fname", "a.admin_lname"))->where("admin_id = ?", $recruiter_id));
}

if ($type=="email"){
	$activities = $lister->getEmailCount($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Emails";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Emails";
	}
}else if ($type=="initial_call"){
	$activities = $lister->getHistory($recruiter_id, "CALL");
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Initial Call";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Initial Call";
	}
}else if ($type=="face_to_face"){
	$activities = $lister->getHistory($recruiter_id, "MEETING FACE TO FACE");
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Face to Face";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Face to Face";
	}
}else if ($type=="evaluated"){
	$activities = $lister->getHistory($recruiter_id, "NOTES");
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Evaluated";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Evaluated";
	}
}else if ($type=="opened_resume"){
	$activities = $lister->getViewedResume($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Viewed Resume";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Viewed Resume";
	}
}else if ($type=="created_resume"){
	$activities = $lister->getCreatedResume($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Created Resume";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Created Resume";
	}
}else if ($type=="sms_sent"){
	$activities = $lister->getSMSSent($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - SMS Sent";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - SMS Sent";
	}
}else if ($type=="assigned"){
	$activities = $lister->getAssignedCandidates($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Assigned";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Assigned";
	}
}else if ($type=="evaluation_comments"){
	$activities = $lister->getEvaluationComments($recruiter_id);
	if ($recruiter_id=="recruiter"||$recruiter_id=="rec_support"){
		$title = "Recruitment Activity - All - Evaluation Comments";
	}else{
		$title = "Recruitment Activity - ".$admin["admin_fname"]." ".$admin["admin_lname"]." - Evaluation Comments";
	}
}


$records = $lister->getCount();

if (isset($_GET["page"])){
	$currentpage = $_GET["page"];
}else{
	$currentpage = 1;
}
if ($records==0){
	$i = 0;
}else{
	$i = (($currentpage-1)*100)+1;
}
$smarty->assign("page_start", $i);
if ($records<=$i+99){
	$smarty->assign("page_end", $records);
}else{
	$smarty->assign("page_end", $i+99);
}


foreach($activities as $key=>$activity){
	$activities[$key]["count"] = $i;
	
	if ($recruiter_id=="All"){
		//get admin info
		if ($activity["userid"]){
			$assigned_recruiter = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"), array())->joinLeft(array("a"=>"admin"), "rs.admin_id = a.admin_id", array("a.admin_fname", "a.admin_lname"))->where("rs.userid = ?", $activity["userid"]));
			$activities[$key]["assigned_recruiter"] = $assigned_recruiter["admin_fname"]." ".$assigned_recruiter["admin_lname"];			
		}

	}
	$i++;
}
$totalPages = ceil($records/100);
$smarty->assign("total_records", $records);
$page_items = array();
$regex = array('/page=(\d+)/');
if (!isset($_GET["page"])){
	$params = $_SERVER["QUERY_STRING"]."&page=1";	
}else{
	$params = $_SERVER["QUERY_STRING"];
}

if ($totalPages>10){
	$pagination_links_num = 10;
	$pagination_links_num_half = $pagination_links_num / 2;
}else{
	$pagination_links_num = $totalPages;
	$pagination_links_num_half = $pagination_links_num / 2;
}

if(($currentpage >= $pagination_links_num) && ($currentpage <= ($totalPages - $pagination_links_num_half))){
	$start = $currentpage - $pagination_links_num_half + 1;
	$end = $currentpage;
	for ($i=$currentpage;$i<$currentpage+$pagination_links_num_half;$i++){
		if ($i==$totalPages){
			break;
		}
		$end++;
	}
	//$end = $page + $pagination_links_num_half ;
}
else{
	if($currentpage < $pagination_links_num){
		$start = 1;
		$end = $pagination_links_num;
	}
	else{
		$start = $totalPages - $pagination_links_num;
		$end = $totalPages;
	}
}

if ($start==0){
	$start = 1;
}

for($i=$start;$i<=$end;$i++){
	$pages = array("page=".$i);
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		$page_param = preg_replace($regex, $pages, $params);	
		if ($_GET["page"]==$i){
			$page_items[] = "<a class='btn btn-mini disabled' href='/portal/recruiter/list_activity.php?".$page_param."'>".$i."</a>";	
		}else{
			$page_items[] = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".$page_param."'>".$i."</a>";
		}
			
	}else{
		if ($_GET["page"]==$i){
			$page_items[] = "<a class='btn btn-mini disabled' href='/portal/recruiter/list_activity.php?".$params."&page={$i}"."'>".$i."</a>";
		}else{
			$page_items[] = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".$params."&page={$i}"."'>".$i."</a>";
		}
	}

}

$smarty->assign("pages", $page_items);
if ($currentpage!=$totalPages&&$totalPages!=1&&$records>100){
	$pages = array("page=".(intval($currentpage)+1));
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		$next_page = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".preg_replace($regex, $pages, $params)."'>Next</a>";	
	}else{
		$next_page = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".($params."&page=".(intval($_GET["page"])+1))."'>Next</a>";	;
	}
}else{
	$next_page = "";
}
if ($currentpage!=1&&$totalPages!=1){
	$pages = array("page=".(intval($currentpage)-1));
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		
		$prev_page = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".preg_replace($regex, $pages, $params)."'>Prev</a>";	
	}else{
		$prev_page = "<a class='btn btn-mini' href='/portal/recruiter/list_activity.php?".($params."&page=".(intval($_GET["page"])-1))."'>Prev</a>";	
	}
	
}else{
	$prev_page = "";
}
$smarty->assign("recruiter_id", $recruiter_id);
$smarty->assign("title", $title);
$smarty->assign("activities", $activities);
if (isset($_GET["closing"])){
	$smarty->assign("closing", True);
}else{
	$smarty->assign("closing", False);
}
$smarty->assign("type", $type);
$smarty->assign("next_page", $next_page);
$smarty->assign("prev_page", $prev_page);
$smarty->display("recruitment_activity.tpl");
