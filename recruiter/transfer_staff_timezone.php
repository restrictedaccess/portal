<?php
ini_set("max_execution_time", 3000);
include('../conf/zend_smarty_conf.php');
$db->getConnection()->exec("TRUNCATE staff_selected_timezones");
$page = 1;
$rows = 5000;
while(true){
	$timezones = $db->fetchAll($db->select()->from("staff_timezone")->limitPage($page, $rows));
	if (!empty($timezones)){
		foreach($timezones as $timezone){
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
		$page++;
	}else{
		break;
		
	}

}
