<?php
include('../conf/zend_smarty_conf.php') ;
$id = $_REQUEST["id"];
if ($id){
	$endorsement = $db->fetchRow($db->select()
			->from(array("e"=>"tb_endorsement_history"))
			->joinLeft(array("p"=>"personal"), "p.userid = e.userid", array(new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS staff_name")))
			->joinLeft(array("l"=>"leads"), "l.id = e.client_name", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client")))
			->where("e.id = ?", $id)
			
			);
	if ($endorsement){
		echo json_encode(array("success"=>true, "endorsement"=>$endorsement));	
	}else{
		echo json_encode(array("success"=>false, "error"=>"Invalid Request"));
	}
		
}else{
	echo json_encode(array("success"=>false, "error"=>"Invalid Request"));
}

				
