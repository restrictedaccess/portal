<?php
include_once '../conf/zend_smarty_conf.php';
session_start();
require_once "reports/LoadOrderProcess.php";
require_once "reports/GetJobPosting.php";
if (isset($_GET["order_id"])){
	$row = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $_GET["order_id"]));
	
	if ($row){
		$items[] = $row;
		$process = new LoadOrderProcess($db);
		$posting = new GetJobPosting($db);
		$orders = $process->loadChainOrder($row["link_order_id"]);
		foreach($orders as $order){
			$items[] = $order;
		}
		foreach($items as $key=>$order){
			$items[$key] = $posting->getOrder(array("order_id"=>$order["gs_job_titles_details_id"]), "custom");
		}
		
		$row = $posting->getOrder(array("order_id"=>$row["gs_job_titles_details_id"]), "custom");
		$smarty = new Smarty();
		$smarty->assign("currentOrder", $row);
		$smarty->assign("orders", $items);
		$smarty->display("load_order.tpl");
	}else{
		echo "Invalid order id";
	}
}else{
	echo "Invalid order id";
}