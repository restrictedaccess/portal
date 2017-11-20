<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$sql="SELECT SUM(hits)AS hits FROM promocodes_hits p WHERE tracking_id=".$_REQUEST['tracking_id'];
$hits = $db->fetchOne($sql);

if(!$hits){
	$hits=0;
}
echo json_encode(array("hits"=>$hits));
?>