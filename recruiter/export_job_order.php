<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php') ;
include '../config.php';
include '../conf.php';
include_once "lib/Force.php";

require_once "reports/JobOrderLoader.php";
if (!isset($_SESSION["admin_id"])){
	die;
}
function output($orders, $hiringManager, $service_type,$fp, $closing=false){
	fputcsv($fp, array($hiringManager["admin_fname"]." ".$hiringManager["admin_lname"], "Service Type: ".$service_type, "Total: ".$orders["records"]));
	fputcsv($fp, array(""));
	if ($closing){
		fputcsv($fp, array("#", "Tracking Code", "Client", "Position", "Job Specification Link", "Closed Date"));
	}else{
		fputcsv($fp, array("#", "Tracking Code", "Client", "Position", "Job Specification Link", "Order Date"));
	}
	$i = 1;
	foreach($orders["rows"] as $orderItem){	
		if ($closing){
			$row  = array("".$i, $orderItem["tracking_code"], $orderItem["client_export"], $orderItem["job_title_export"], $orderItem["job_specification_link_export"], "\"{$orderItem["date_filled_up"]}\"", "\"{$orderItem["date_closed"]}\"");
		}else{
			$row = array("".$i, $orderItem["tracking_code"], $orderItem["client_export"], $orderItem["job_title_export"], $orderItem["job_specification_link_export"], "\"{$orderItem["date_filled_up"]}\"");
		}	
		fputcsv($fp, $row);
		$i++;
	}
	fputcsv($fp, array(""));
	fputcsv($fp, array(""));
}

if (isset($_GET["today"])){
	$select = "SELECT admin_id, admin_fname, admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
	$hiringManagers = $db->fetchAll($select);
	$fp = fopen('today.csv', 'w');
	fputcsv($fp, array("Today Open Orders as of ".date("Y-m-d")));
	$posting = new JobOrderLoader($db);
	foreach($hiringManagers as $hiringManager){
		$orders = $posting->getTodayOrdersHM($hiringManager["admin_id"], 2);
		output($orders, $hiringManager, "ASL", $fp);
		$orders = $posting->getTodayOrdersHM($hiringManager["admin_id"], 1);
		output($orders, $hiringManager, "CUSTOM", $fp);
		$orders = $posting->getTodayOrdersHM($hiringManager["admin_id"], 3);
		output($orders, $hiringManager, "BACKORDER", $fp);
		$orders = $posting->getTodayOrdersHM($hiringManager["admin_id"], 4);
		output($orders, $hiringManager, "REPLACEMENT", $fp);
		$orders = $posting->getTodayOrdersHM($hiringManager["admin_id"], 5);
		output($orders, $hiringManager, "INHOUSE", $fp);
	}
	fclose($fp);
	output_file("today.csv", "today.csv", "text/csv");
	unlink("today.csv");	
}else if (isset($_GET["closing"])){
	$dateFrom = $_GET["date_from"];
	$dateTo = $_GET["date_to"];
	$select = "SELECT admin_id, admin_fname, admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
	$hiringManagers = $db->fetchAll($select);
	$fp = fopen('closing.csv', 'w');
	fputcsv($fp, array("Closed Orders between ".$dateFrom." AND ".$dateTo));
	$posting = new JobOrderLoader($db);
	foreach($hiringManagers as $hiringManager){
		$orders = $posting->getCloseOrdersHM($hiringManager["admin_id"], 2, $dateFrom, $dateTo);
		output($orders, $hiringManager, "ASL", $fp, true);
		$orders = $posting->getCloseOrdersHM($hiringManager["admin_id"], 1, $dateFrom, $dateTo);
		output($orders, $hiringManager, "CUSTOM", $fp, true);
		$orders = $posting->getCloseOrdersHM($hiringManager["admin_id"], 3, $dateFrom, $dateTo);
		output($orders, $hiringManager, "BACKORDER", $fp, true);
		$orders = $posting->getCloseOrdersHM($hiringManager["admin_id"], 4, $dateFrom, $dateTo);
		output($orders, $hiringManager, "REPLACEMENT", $fp, true);
		$orders = $posting->getCloseOrdersHM($hiringManager["admin_id"], 5, $dateFrom, $dateTo);
		output($orders, $hiringManager, "INHOUSE", $fp, true);
	}
	fclose($fp);
	output_file("closing.csv", "closing.csv", "text/csv");
	unlink("closing.csv");	
}else{
	$dateFrom = $_GET["date_from"];
	$dateTo = $_GET["date_to"];
	$order_status = $_GET["order_status"];
	$select = "SELECT admin_id, admin_fname, admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
	$hiringManagers = $db->fetchAll($select);
	$fp = fopen('order.csv', 'w');
	if ($order_status==-1){
		fputcsv($fp, array("All Orders ordered between ".$dateFrom." AND ".$dateTo));
	}else if ($order_status==0){
		fputcsv($fp, array("Open Orders ordered between ".$dateFrom." AND ".$dateTo));
	}else if ($order_status==1){
		fputcsv($fp, array("Closed Orders ordered between ".$dateFrom." AND ".$dateTo));
	}else if ($order_status==2){
		fputcsv($fp, array("Did not push Through Orders ordered between ".$dateFrom." AND ".$dateTo));
	}else if ($order_status==3){
		fputcsv($fp, array("On Hold Orders ordered between ".$dateFrom." AND ".$dateTo));
	}else if ($order_status==4){
		fputcsv($fp, array("On Trial Orders ordered between ".$dateFrom." AND ".$dateTo));
	}
	$posting = new JobOrderLoader($db);
	foreach($hiringManagers as $hiringManager){
		$orders = $posting->getOpenOrdersHM($hiringManager["admin_id"], 2, $order_status, $dateFrom, $dateTo);
		output($orders, $hiringManager, "ASL", $fp);
		$orders = $posting->getOpenOrdersHM($hiringManager["admin_id"], 1, $order_status, $dateFrom, $dateTo);
		output($orders, $hiringManager, "CUSTOM", $fp);
		$orders = $posting->getOpenOrdersHM($hiringManager["admin_id"], 3, $order_status, $dateFrom, $dateTo);
		output($orders, $hiringManager, "BACKORDER", $fp);
		$orders = $posting->getOpenOrdersHM($hiringManager["admin_id"], 4, $order_status, $dateFrom, $dateTo);
		output($orders, $hiringManager, "REPLACEMENT", $fp);
		$orders = $posting->getOpenOrdersHM($hiringManager["admin_id"], 5, $order_status, $dateFrom, $dateTo);
		output($orders, $hiringManager, "INHOUSE", $fp);
	}
	fclose($fp);
	output_file("order.csv", "order.csv", "text/csv");
	unlink("order.csv");	
}


