<?php
class TimezoneUtility{
	public static function getTimezoneList($db=null){
		global $db;
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		$display_timezone = array();
		foreach($timezone_identifiers as $timezone){	
			if (strlen(strstr($timezone, "Africa"))){
				if ($timezone=="Africa/Johannesburg"){
					$display_timezone[] = $timezone;	
				}
			}else if (strlen(strstr($timezone,"Asia"))>0) {
				if ($timezone=="Asia/Manila"||$timezone=="Asia/Singapore"||$timezone=="Asia/Bangkok"){
					$display_timezone[] = $timezone;
				}
			}else if (strlen(strstr($timezone, "Pacific"))){
				if ($timezone=="Pacific/Honolulu"||$timezone=="Pacific/Auckland"){
					$display_timezone[] = $timezone;
				}
			}else if (strlen(strstr($timezone, "America"))){
				$display_timezone[] = $timezone;
			}else if (strlen(strstr($timezone, "Europe"))){
				$display_timezone[] = $timezone;
			}else if (strlen(strstr($timezone, "Australia"))){
				$display_timezone[] = $timezone;
			}
		}
		if ($db!=null){
			//sync to db
			foreach($display_timezone as $timezone){
				$dbTime = $db->fetchRow($db->select()->from("timezone_lookup")->where("timezone = ?", $timezone));
				if (!$dbTime){
					$db->insert("timezone_lookup", array("timezone"=>$timezone));
				}
			}
			
		}
		return $display_timezone;
	}
	
	
}