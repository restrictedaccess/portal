<?php
//ini_set("max_execution_time", 300);
//include '../conf/zend_smarty_conf.php';
//
//$unprocessedStaffs = $db->fetchAll($db->select()->from(array("us"=>"unprocessed_staff")));
//$db->query("TRUNCATE remote_ready_criteria_entries");
//foreach($unprocessedStaffs as $unprocessedStaff){
//	$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("image", "voice_path"))->where("p.userid = ?", $unprocessedStaff["userid"]));
//
//	$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $unprocessedStaff["userid"]));
//	$skills = $db->fetchAll($db->select()->from(array("s"=>"skills"))->where("s.userid = ?", $unprocessedStaff["userid"])->limit(5));
//	if ($personal){
//		if ($personal["image"]&&trim($personal["image"])!=""){
//			$crit = $db->fetchRow($db->select()->from(array("rrce"=>"remote_ready_criteria_entries"), array("id"))->where("userid = ?", $unprocessedStaff["userid"])->where("remote_ready_criteria_id = ?", "1"));
//			if (!$crit){
//				$db->insert("remote_ready_criteria_entries", array("userid"=>$unprocessedStaff["userid"], "remote_ready_criteria_id"=>"1", "date_created"=>date("Y-m-d H:i:s")));
//			}
//		}
//		if ($personal["voice_path"]&&trim($personal["voice_path"])!=""){
//			$crit = $db->fetchRow($db->select()->from(array("rrce"=>"remote_ready_criteria_entries"), array("id"))->where("userid = ?", $unprocessedStaff["userid"])->where("remote_ready_criteria_id = ?", "2"));
//			if (!$crit){
//				$db->insert("remote_ready_criteria_entries", array("userid"=>$unprocessedStaff["userid"], "remote_ready_criteria_id"=>"2", "date_created"=>date("Y-m-d H:i:s")));
//			}
//		}
//		$where = array();
//		$where[] = $db->quoteInto("remote_ready_criteria_id = ?", "4");
//		$where[] = $db->quoteInto("userid = ?", $unprocessedStaff["userid"]);
//		$db->delete("remote_ready_criteria_entries", $where);
//		$count = 0;
//		for($i=1;$i<=10;$i++){
//			$suffix="";
//			if ($i>1){
//				$suffix.="$i";
//			}
//			if ($currentjob["companyname".$suffix]!=""){
//				$db->insert("remote_ready_criteria_entries", array("userid"=>$unprocessedStaff["userid"],  "remote_ready_criteria_id"=>"4", "date_created"=>date("Y-m-d H:i:s")));
//				$count++;
//			}
//			if ($count==5){
//				break;
//			}
//		}
//		$where = array();
//		$where[] = $db->quoteInto("remote_ready_criteria_id = ?", "3");
//		$where[] = $db->quoteInto("userid = ?", $unprocessedStaff["userid"]);
//		$db->delete("remote_ready_criteria_entries", $where);
//		foreach($skills as $skill){
//			$db->insert("remote_ready_criteria_entries", array("userid"=>$unprocessedStaff["userid"], "remote_ready_criteria_id"=>"3", "date_created"=>date("Y-m-d H:i:s")));
//		}
//	}
//}
