<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/GetJobPosting.php";
$posting = new GetJobPosting($db);
if (isset($_GET["id"])){
	echo $posting->getNotes($_GET["id"], false);	
}
if (isset($_GET["merged_order_id"])){
	echo $posting->getNotesForMergeOrder($_GET["merged_order_id"], false);
}
