<?php
include '../conf/zend_smarty_conf.php';
require_once "../recruiter/reports/GetJobPosting.php";
require_once "../recruiter/reports/GetJobPostingCounters.php";
$counters = new GetJobPostingCounters($db);
$fifteenDaysCounts = $counters->getOpenOrder15daysCounts();
$todayOpenDaysCounts = $counters->getTodayOpenCountersDashboard();
//delete all entries from the summary table
$db->getConnection()->exec("TRUNCATE job_orders_count");
$db->insert("job_orders_count", array("service_type"=>"ASL", "summary_type"=>"LAST 15 DAYS", "count"=>$fifteenDaysCounts["asl"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"CUSTOM", "summary_type"=>"LAST 15 DAYS", "count"=>$fifteenDaysCounts["custom"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"BACK ORDER", "summary_type"=>"LAST 15 DAYS", "count"=>$fifteenDaysCounts["backorder"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"REPLACEMENT", "summary_type"=>"LAST 15 DAYS", "count"=>$fifteenDaysCounts["replacement"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"INHOUSE", "summary_type"=>"LAST 15 DAYS", "count"=>$fifteenDaysCounts["inhouse"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"ASL", "summary_type"=>"OPEN ORDERS", "count"=>$todayOpenDaysCounts["asl"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"CUSTOM", "summary_type"=>"OPEN ORDERS", "count"=>$todayOpenDaysCounts["custom"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"BACK ORDER", "summary_type"=>"OPEN ORDERS", "count"=>$todayOpenDaysCounts["backorder"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"REPLACEMENT", "summary_type"=>"OPEN ORDERS", "count"=>$todayOpenDaysCounts["replacement"], "date_summary"=>date("Y-m-d H:i:s")));
$db->insert("job_orders_count", array("service_type"=>"INHOUSE", "summary_type"=>"OPEN ORDERS", "count"=>$todayOpenDaysCounts["inhouse"], "date_summary"=>date("Y-m-d H:i:s")));
