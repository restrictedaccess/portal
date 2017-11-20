<?php
include('../conf/zend_smarty_conf.php') ;
include '../config.php';
include '../conf.php';
include '../function.php';
include '../time.php';
if(isset($_SESSION['admin_id']))
{
	$u_id = $_REQUEST["userid"];
	$admin_id = $_SESSION['admin_id'];
	$pull_time_rate = $_REQUEST['pull_time_rate'];
	$part_time_rate = $_REQUEST['part_time_rate'];
	$date = date('Y-m-d');
	
		if($pull_time_rate == "" || $pull_time_rate == NULL)
		{
			$pull_time_rate = 318;
		}
		if($part_time_rate == "" || $part_time_rate == NULL)
		{
			$part_time_rate = 317;
		}
	$userid = $u_id;
	$q_amount = $db->fetchRow($db->select()->from("staff_rate")->where("userid = ?", $u_id));
	$data = array(
		"userid"=>$userid,
		"part_time_product_id"=>$part_time_rate,
		"product_id"=>$pull_time_rate,
		"admin_id"=>$admin_id,
		"date_updated"=>$date
	);
	$changeByType = $_SESSION["status"];
	if ($changeByType=="FULL-CONTROL"){
		$changeByType = "ADMIN";
	}
	if ($q_amount){
		
		$db->update("staff_rate", $data, $db->quoteInto("userid = ?", $userid));
		
		if ($q_amount["part_time_product_id"]!=$part_time_rate){
			$old_part_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $q_amount["part_time_product_id"]));
			$new_part_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $part_time_rate));
			$history_changes = "Updated Part Time Staff Rate from <span style='color:#ff0000'>".$old_part_time_rate."</span> to <span style='color:#ff0000'>".$new_part_time_rate."</span>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		}
		if ($q_amount["product_id"]!=$pull_time_rate){
			$old_full_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $q_amount["product_id"]));
			$new_full_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $pull_time_rate));
			$history_changes = "Updated Full Time Staff Rate from <span style='color:#ff0000'>".$old_full_time_rate."</span> to <span style='color:#ff0000'>".$new_full_time_rate."</span>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		}
		
	}else{
		$new_part_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $part_time_rate));
		$history_changes = "Added Part Time Staff Rate <span style='color:#ff0000'>".$new_part_time_rate."</span>";
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
		$new_full_time_rate = $db->fetchOne($db->select()->from("products", "code")->where("id = ?", $pull_time_rate));
		$history_changes = "Added Full Time Staff Rate <span style='color:#ff0000'>".$new_full_time_rate."</span>";
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
		$db->insert("staff_rate", $data);
	}
	
	$db->update("personal", array("dateupdated"=>$date), $db->quoteInto("userid = ?", $userid));
	
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$u_id);		
	}else{
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$u_id);
	}
	
}	