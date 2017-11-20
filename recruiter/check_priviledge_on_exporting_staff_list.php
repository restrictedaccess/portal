<?php
include('../conf/zend_smarty_conf.php') ;
if (!isset($_SESSION["admin_id"])){
	die;
}
$admin = $db->fetchRow($db->select()->from(array("adm"=>"admin"), array("export_staff_list"))->where("adm.admin_id = ?", $_SESSION["admin_id"]));
if ($admin){
	if ($admin["export_staff_list"]=="N"){
		echo json_encode(array("notallowed"=>true));
		die;
	}else{
		echo json_encode(array("notallowed"=>false));
		die;		
	}

}else{
	echo json_encode(array("notallowed"=>true));
	die;
}
