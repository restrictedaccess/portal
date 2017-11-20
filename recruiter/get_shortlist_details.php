<?php
include('../conf/zend_smarty_conf.php') ;
if ($_REQUEST["id"]){
	
	$shortlist = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("sh.id"))
								->joinLeft(array("p"=>"personal"), "sh.userid = p.userid", array("p.fname AS candidate_fname", "p.lname AS candidate_lname"))
								->joinLeft(array("pos"=>"posting"), "pos.id = sh.position", array())
								->joinLeft(array("l"=>"leads"), "l.id = pos.lead_id", array("l.fname AS lead_fname", "l.lname AS lead_lname"))
								->where("sh.id = ?", $_REQUEST["id"])
								);
								
	if ($shortlist){
		echo json_encode(array("success"=>true, "shortlist"=>$shortlist));
	}else{
		echo json_encode(array("success"=>false));
	}
	
}else{
	echo json_encode(array("success"=>false));
}
