<?php
mb_internal_encoding("UTF-8");
ini_set("max_execution_time", 300);
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';

require_once "reports/JobOrderLoader.php";



$smarty = new Smarty();
$posting = new JobOrderLoader($db);
$orders = $posting->process();
$records = $orders["records"];
$orders = $orders["rows"];
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


foreach($orders as $key=>$order){
	$orders[$key]["count"] = $i;
	$orders[$key]["date_closed"] = date("Y-m-d", strtotime($order["date_closed"]));
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

for($i=1;$i<=$totalPages;$i++){
	$pages = array("page=".$i);
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		$page_param = preg_replace($regex, $pages, $params);	
		if ($_GET["page"]==$i){
			$page_items[] = "<a class='btn btn-mini disabled' href='/portal/recruiter/load_job_posting_details.php?".$page_param."'>".$i."</a>";	
		}else{
			$page_items[] = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".$page_param."'>".$i."</a>";
		}
			
	}else{
		if ($_GET["page"]==$i){
			$page_items[] = "<a class='btn btn-mini disabled' href='/portal/recruiter/load_job_posting_details.php?".$params."&page={$i}"."'>".$i."</a>";
		}else{
			$page_items[] = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".$params."&page={$i}"."'>".$i."</a>";
		}
	}

}

$smarty->assign("pages", $page_items);
if ($currentpage!=$totalPages&&$totalPages!=1&&$records>100){
	$pages = array("page=".(intval($currentpage)+1));
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		$next_page = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".preg_replace($regex, $pages, $params)."'>Next</a>";	
	}else{
		$next_page = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".($params."&page=".(intval($_GET["page"])+1))."'>Next</a>";	;
	}
}else{
	$next_page = "";
}
if ($currentpage!=1&&$totalPages!=1){
	$pages = array("page=".(intval($currentpage)-1));
	$matches = array();
	preg_match("/page=(\d+)/", $params, $matches);
	if (!empty($matches)){
		
		$prev_page = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".preg_replace($regex, $pages, $params)."'>Prev</a>";	
	}else{
		$prev_page = "<a class='btn btn-mini' href='/portal/recruiter/load_job_posting_details.php?".($params."&page=".(intval($_GET["page"])-1))."'>Prev</a>";	
	}
	
}else{
	$prev_page = "";
}

$smarty->assign("title", "Job Orders");
$smarty->assign("orders", $orders);
if (isset($_GET["closing"])){
	$smarty->assign("closing", True);
}else{
	$smarty->assign("closing", False);
}
$smarty->assign("next_page", $next_page);
$smarty->assign("prev_page", $prev_page);
$smarty->display("job_order_posting_details.tpl");
