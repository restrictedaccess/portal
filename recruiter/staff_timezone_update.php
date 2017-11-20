<?php
include '../config.php';
include '../conf.php';
include('../conf/zend_smarty_conf.php');

$time_zone=$_REQUEST['time_zone'];
$action=$_REQUEST['action'];
$userid=$_REQUEST['userid'];
$type=$_REQUEST['type'];
$time=$_REQUEST['time'];

if($type == "time")
{
	$ctr-$db->fetchRow("SELECT time_zone FROM staff_timezone WHERE userid='$userid' LIMIT 1");

	if ($ctr)
	{
		//mysql_query("UPDATE staff_timezone SET p_time='$time' WHERE userid='$userid'");
		$db -> update("staff_timezone", 
				array("p_time"=>$time),
				$db -> quoteInto("userid",$userid));		
	}
	else
	{
		//mysql_query("INSERT INTO staff_timezone(userid,	p_time) VALUES('$userid','$time')");
		$db -> insert("staff_timezone",
				array("userid"=>$userid,
				"p_time"=>$time));
				

	}
}
elseif($action == "check")
{
	
	$staff_timezone = $db->fetchRow($db->select()->from("staff_timezone")->where("userid = ?", $userid)->limit(1));
	if ($staff_timezone){
		if ($type=="fulltime"){
			if ($_REQUEST["time_zone"]=="ANY"){
				$db->update("staff_timezone", array("time_zone"=>"ANY"), $db->quoteInto("userid = ?", $userid));
			}else{
				$already_selected = explode(",", $staff_timezone["time_zone"]);
				$selected_items = array();
				foreach($already_selected as $item){
					if (!(trim($item)=="ANY")){
						$selected_items[] = trim($item);
					}
				}
				$selected_items[] = $_REQUEST["time_zone"];
				if (in_array("US", $selected_items)&&in_array("UK", $selected_items)&&in_array("AU", $selected_items)){
					$db->update("staff_timezone", array("time_zone"=>"ANY"), $db->quoteInto("userid = ?", $userid));
				}else{
					$db->update("staff_timezone", array("time_zone"=>implode(",", $selected_items)), $db->quoteInto("userid = ?", $userid));
				}
			}
		}else{
			if ($_REQUEST["time_zone"]=="ANY"){
				$db->update("staff_timezone", array("p_timezone"=>"ANY"), $db->quoteInto("userid = ?", $userid));
			}else{
				$already_selected = explode(",", $staff_timezone["p_timezone"]);
				$selected_items = array();
				foreach($already_selected as $item){
					if (!(trim($item)=="ANY")){
						$selected_items[] = trim($item);
					}
				}
				$selected_items[] = $_REQUEST["time_zone"];
				if (in_array("US", $selected_items)&&in_array("UK", $selected_items)&&in_array("AU", $selected_items)){
					$db->update("staff_timezone", array("p_timezone"=>"ANY"), $db->quoteInto("userid = ?", $userid));
				}else{
					$db->update("staff_timezone", array("p_timezone"=>implode(",", $selected_items)), $db->quoteInto("userid = ?", $userid));
				}
			}
		}
		
		//record into staff history
	
		$new_staff_timezone = $db->fetchRow($db->select()->from("staff_timezone")->where("userid = ?", $userid)->limit(1));
		
		$changeByType = $_SESSION["status"];
		if ($changeByType=="FULL-CONTROL"){
			$changeByType = "ADMIN";
		}
		
		if ($type=="fulltime"){
			$history_changes = "Updated <span style='color:#ff0000'>Full Time</span> timezone availability <span style='color:#ff0000'>".$new_staff_timezone["time_zone"]."</span>";		
		}else{
			$history_changes = "Updated <span style='color:#ff0000'>Part Time</span> timezone availability <span style='color:#ff0000'>".$new_staff_timezone["p_timezone"]."</span>";
		}
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
		
		
		
	}else{
		if ($type=="fulltime"){
			$db->insert("staff_timezone", array("time_zone"=>$_REQUEST["time_zone"], "userid"=>$userid, "time"=>"00:00:00"));
		}else{
			$db->insert("staff_timezone", array("p_timezone"=>$_REQUEST["time_zone"], "userid"=>$userid, "p_time"=>"00:00:00"));			
		}
		//record into staff history
	
		$new_staff_timezone = $db->fetchRow($db->select()->from("staff_timezone")->where("userid = ?", $userid)->limit(1));
		
		$changeByType = $_SESSION["status"];
		if ($changeByType=="FULL-CONTROL"){
			$changeByType = "ADMIN";
		}
		
		if ($type=="fulltime"){
			$history_changes = "Marked as available to work <span style='color:#ff0000'>Full Time</span> with timezone availability <span style='color:#ff0000'>".$new_staff_timezone["time_zone"]."</span>";		
		}else{
			$history_changes = "Marked as available to work <span style='color:#ff0000'>Part Time</span> with timezone availability <span style='color:#ff0000'>".$new_staff_timezone["p_timezone"]."</span>";
		}
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
		
	}
	
	
	
	
}
else
{
	if($type == "fulltime")
	{	
		$raw_query = "UPDATE staff_timezone SET time_zone=REPLACE(time_zone,'$time_zone','') WHERE userid='$userid'";
		$db -> query($raw_query);
	}
	else
	{
		$raw_p_query = "UPDATE staff_timezone SET p_timezone=REPLACE(p_timezone,'$time_zone','') WHERE userid='$userid'";
			$db -> query($raw_p_query);
	}
	
	//record into staff history
	$new_staff_timezone = $db->fetchRow($db->select()->from("staff_timezone")->where("userid = ?", $userid)->limit(1));
		
	$changeByType = $_SESSION["status"];
	if ($changeByType=="FULL-CONTROL"){
		$changeByType = "ADMIN";
	}
	
	if ($type=="fulltime"){
		$history_changes = "Updated <span style='color:#ff0000'>Full Time</span> timezone availability <span style='color:#ff0000'>".$new_staff_timezone["time_zone"]."</span>";		
	}else{
		$history_changes = "Updated <span style='color:#ff0000'>Part Time</span> timezone availability <span style='color:#ff0000'>".$new_staff_timezone["p_timezone"]."</span>";
	}
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
}

//resync normalized staff_selected_timezone

$db->delete("staff_selected_timezones", $db->quoteInto("userid = ?", $userid));
$timezone = $db->fetchRow($db->select()->from("staff_timezone")->where("userid = ?", $userid)->limit(1));
		
if ($time_zone){
	if ($timezone["time_zone"]){
		if (strpos(strtoupper($timezone["time_zone"]), "ANY")===false){
			$temp = explode(",", $timezone["time_zone"]);					
		}else{
			$temp = array("AU", "UK", "US");
		}
		foreach($temp as $temp_timezone){
			if (trim($temp_timezone)==""){
				continue;
			}
			$data = array("time_zone"=>$temp_timezone, "userid"=>$timezone["userid"], "time"=>$timezone["time"], "type"=>"full_time");
			$db->insert("staff_selected_timezones", $data);	
		}			
	}			
		
	if ($timezone["p_timezone"]){
		if (strpos(strtoupper($timezone["p_timezone"]), "ANY")===false){
			$temp = explode(",", $timezone["p_timezone"]);
		}else{
			$temp = array("AU", "UK", "US");
		}
		foreach($temp as $temp_timezone){
			if (trim($temp_timezone)==""){
				continue;
			}
			$data = array("time_zone"=>$temp_timezone, "userid"=>$timezone["userid"], "time"=>$timezone["p_time"], "type"=>"part_time");
			$db->insert("staff_selected_timezones", $data);	
		}			
	}
}
