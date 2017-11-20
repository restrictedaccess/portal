<?php
include('../conf/zend_smarty_conf.php') ;
if ($_REQUEST["interview_id"]){
	$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array())->joinInner(array("p"=>"personal"), "p.userid = tbr.applicant_id", array(new Zend_Db_Expr("CONCAT(p.fname, ' ',p.lname) AS staff")))
		->joinInner(array("l"=>"leads"), "l.id=tbr.leads_id", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client_name")));
	$sql->where("tbr.id = ?", $_REQUEST["interview_id"]);
	$row = $db->fetchRow($sql);
	if ($row){
		echo json_encode(array("success"=>true, "row"=>$row));	
	}
		
}else{
	echo json_encode(array("success"=>false));
}
