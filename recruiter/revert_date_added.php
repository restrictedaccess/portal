<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');
function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
$userid = $_GET["userid"];
if ($userid){
	$sql = "SELECT * FROM staff_history WHERE changes LIKE 'Date Categorized on %' AND changes LIKE '%date has been updated from%' AND userid = '".addslashes($userid)."'";
}else{
	if (TEST){	
		$sql = "SELECT * FROM staff_history WHERE changes LIKE 'Date Categorized on %' AND changes LIKE '%date has been updated from%' LIMIT 10";		
	}else{
		$sql = "SELECT * FROM staff_history WHERE changes LIKE 'Date Categorized on %'  AND changes LIKE '%date has been updated from%'";	
	}

}
$changes = $db->fetchAll($sql);
foreach($changes as $change){
	$history_changes = strip_tags($change["changes"]);
	//get the category
	$subcategory = trim(get_string_between($history_changes, "Date Categorized on ", "date has been updated from"));
	$date_string = str_replace(array("Date Categorized on ", $subcategory, " date has been updated from"), "", $history_changes);
	$dates = explode(" to ", $date_string);
	$date_from = $dates[0];
	$date_to = $dates[1];
	
	$history_changes = "Date Categorized on <span style='color:#ff0000'>".$subcategory."</span> date has been reverted to its original date <span style='color:#ff0000'>".$date_from."</span> from <span style='color:#ff0000'>".$date_to."</span>";			
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$change["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
		
	
	$jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"))
				->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))
				->where("jsc.sub_category_name = ?", $subcategory)
				->where("jsca.userid = ?", $change["userid"]));
	
	$db->update("job_sub_category_applicants", array("sub_category_applicants_date_created"=>trim($date_from), "recategorized_date"=>trim($date_to)), $db->quoteInto("id = ?", $jsca["id"]));
	
	
}
