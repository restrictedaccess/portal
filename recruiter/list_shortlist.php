<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;

if (isset($_GET["userid"])){
	$sql = $db->select()->from(array("ss"=>"tb_shortlist_history"), 
								array("ss.id AS id"))
			
			->joinInner(array("pos"=>"posting"), "pos.id = ss.position", array("pos.jobposition AS job_title", "pos.id AS posting_id", "pos.status"))
			->joinInner(array("l"=>"leads"), "pos.lead_id = l.id", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client"), "l.id AS lead_id"))
			->where("ss.userid = ?", $_GET["userid"])->order("date_listed DESC");	
	$list = $db->fetchAll($sql);
	$result = array("success"=>true, "list"=>$list);
}else{
	$result = array("success"=>false);
}
echo json_encode($result);
