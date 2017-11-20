<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterHomeLister.php";
$rec = new RecruiterHomeLister($db_query_only);
echo json_encode($rec->getList());
