<?php 
include('conf/zend_smarty_conf.php');
if(@$_SESSION['admin_id']!="" or @$_SESSION['agent_no']!="" or @$_SESSION['client_id']!="" or @$_SESSION['userid']!="" ){
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	$url = sprintf('rschat.php?portal=1&email=%s&hash=%s', $_SESSION['emailaddr'], $hash_code);
	header("location:$url");
	exit;
}else{
	die("Please login.");
}
		
?>
