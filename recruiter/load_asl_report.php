<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterASLReports.php";
if (TEST){
	$counter = new RecruiterASLReports($db);
}else{
	$counter = new RecruiterASLReports($db_query_only);
}
echo json_encode($counter->getList());
