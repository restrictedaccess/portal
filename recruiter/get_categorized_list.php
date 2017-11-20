<?php
include '../conf/zend_smarty_conf.php';
require_once "reports/CategorizedLoader.php";

$search = new CategorizedLoader($db);
$count = $search->getUniqueResume();
if ($count>=500){
	$search->setLimit(true);
}

echo json_encode(array("success"=>true, "result"=>$search->render(), "count"=>$count));	