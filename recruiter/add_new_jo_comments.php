<?php
include('../conf/zend_smarty_conf.php') ;
if (!isset($_SESSION["admin_id"])){
	die;
}
if (isset($_REQUEST["comment"])&&trim($_REQUEST["comment"])==""){
	echo json_encode(array("success"=>false, "error"=>"Please enter a note"));
	die;
}
if (isset($_REQUEST["subject"])&&trim($_REQUEST["subject"])==""){
	echo json_encode(array("success"=>false, "error"=>"Please enter a subject"));
	die;
}
if($_SESSION['status'] <> "FULL-CONTROL"){ 
	$hm = false;
}else{
	$hm = true;
}

$data = array(
	"comment"=>$_REQUEST["comment"],
	"admin_id"=>$_SESSION["admin_id"],
	"date_created"=>date("Y-m-d H:i:s"),
	"date_updated"=>date("Y-m-d H:i:s"),
	"tracking_code"=>$_REQUEST["tracking_code"],
	"subject"=>$_REQUEST["subject"]
);
$db->insert("job_order_comments", $data);
$id = $db->lastInsertId("job_order_comments");
$comment = $db->fetchRow($db->select()->from(array("joc"=>"job_order_comments"))
							->joinInner(array("a"=>"admin"), "a.admin_id = joc.admin_id", array("a.admin_fname", "a.admin_lname"))
							->where("joc.id = ?", $id));

echo json_encode(array("success"=>true, "comment"=>$comment, "hm"=>$hm));

