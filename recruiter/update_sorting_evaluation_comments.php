<?php
include('../conf/zend_smarty_conf.php');
$items = $_REQUEST["items"];
if (!empty($items)){
	foreach($items as $item){
		echo "UPDATE evaluation_comments SET ordering=".$item["ordering"]." WHERE id=".$item["id"]."\n";
		$db->query("UPDATE evaluation_comments SET ordering=".$item["ordering"]." WHERE id=".$item["id"]);
	}	
}
