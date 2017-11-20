<?php
require('../conf/zend_smarty_conf.php');
if ($_SESSION["client_id"]){
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	echo json_encode(array("success"=>true, "client_id"=>$_SESSION["client_id"], "hashcode"=>$hash_code));
}else{
	echo json_encode(array("success"=>false));
}
