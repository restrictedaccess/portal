<?php
include('conf/zend_smarty_conf.php');

if( !empty($_SESSION['admin_id']) && empty($_SESSION['firstrun']) ){
	echo json_encode(array("success"=>true, "email"=>$_SESSION["emailaddr"]));	
}else{
	echo json_encode(array("success"=>false));
}
