<?php
ini_set("max_execution_time",0);
require_once('../conf/zend_smarty_conf.php');

$page = 1;
$limit = 1000;
while(true){
	$offset = ($page-1)*$limit;
//	$sql = $db->select()->from(array("rrce"=>"remote_ready_criteria_entries"), array("rrce.id", "rrce.userid"))->joinLeft(array("rrc"=>"remote_ready_criteria"), "rrce.remote_ready_criteria_id = rrc.id", array("rrc.points AS points"))->where("rrce.added = 0");
	$sql = $sql->__toString();
	$sql .= " LIMIT ".$limit." OFFSET ".$offset;
	$entries = $db->fetchAll($sql);
	if (count($entries)>0){
//		foreach($entries as $entry){
//			$sum = $db->fetchRow($db->select()->from(array("rrcesp"=>"remote_ready_criteria_entry_sum_points"))->where("rrcesp.userid = ?", $entry["userid"]));
//			if ($sum){
//				$db->update("remote_ready_criteria_entry_sum_points", array("points"=>intval($entry["points"])+intval($sum["points"])), $db->quoteInto("id = ?", $sum["id"]));
//			}else{
//				$data = array("userid"=>$entry["userid"], "points"=>$entry["points"], "date_updated"=>date("Y-m-d H:i:s"));
//				$db->insert("remote_ready_criteria_entry_sum_points", $data);
//			}
//			$db->update("remote_ready_criteria_entries", array("added"=>1), $db->quoteInto("id = ?", $entry["id"]));
//		}
			
	}else{
		break;
	}
	
	$page++;
}
