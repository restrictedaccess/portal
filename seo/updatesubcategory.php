<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false));
	die;
}
if (!empty($_POST)){
	$row = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $_POST["sub_category_id"]));
	if (!$row){
		$db->insert("job_sub_category", $_POST);
	}else{
		//query old url 
		$row = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $_POST["sub_category_id"]));
		if ($row){
			if (isset($row["url"])&&$row["url"]!=""){
				$row2 = $db->fetchRow($db->select()->from("job_sub_category_url_change_logs")->where("url = ?", $row["url"]));
				if (!$row2){
					$db->insert("job_sub_category_url_change_logs", array("sub_category_id"=>$_POST["sub_category_id"], "url"=>$row["url"], "date_created"=>date("Y-m-d H:i:s")));	
				}	
			}else{
				$db->insert("job_sub_category_url_change_logs", array("sub_category_id"=>$_POST["sub_category_id"], "url"=>$_POST["url"], "date_created"=>date("Y-m-d H:i:s")));	
			}
		}
		$db->update("job_sub_category", $_POST, $db->quoteInto("sub_category_id = ?", $_POST["sub_category_id"]));
		
		
		//query all job categorized
		$jscas = $db->fetchAll($db->select()->from("job_sub_category_applicants")->where("sub_category_id = ?", $_POST["sub_category_id"]));
		foreach($jscas as $jsca){
			if ($jsca["category_id"]!=$_POST["category_id"]){
				//category
				$oldCategory = $db->fetchRow($db->select()->from("job_category")->where("category_id = ?", $jsca["category_id"]));
				$newCategory = $db->fetchRow($db->select()->from("job_category")->where("category_id = ?", $_POST["category_id"]));
				
				$changeByType = "admin";
				$history_changes = "changed categorized entry's category from <span style='color:#ff0000'>".$oldCategory["category_name"]."</span> to <span style='color:#ff0000'>".$newCategory["category_name"]."</span>";
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
				$db->update("job_sub_category_applicants", array("category_id"=>$_POST["category_id"]), $db->quoteInto("id = ?", $jsca["id"]));					
			}
			
			
			
		}
		
		
	}
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
