<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;

$id = $_REQUEST["id"];
if ($id){
	$history = $db->fetchOne($db->select()->from(array("ah"=>"applicant_history"), "history")->where("id = ?", $id));
}else{
	$history = "";
}
echo json_encode(array("history"=>$history));

