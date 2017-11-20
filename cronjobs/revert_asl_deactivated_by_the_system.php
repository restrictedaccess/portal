<?php
ini_set("max_execution_time", 300);
include '../conf/zend_smarty_conf.php';
require('../tools/CouchDBMailbox.php');
if (isset($_GET["userid"])){
    $staff_history = $db->fetchAll("SELECT userid FROM staff_history WHERE changes LIKE '%INACTIVE - NOT INTERESTED</span> since%' AND date_change >= DATE('2014-06-01') AND userid = '{$_GET["userid"]}'");
}else{
    $staff_history = $db->fetchAll("SELECT userid FROM staff_history WHERE changes LIKE '%INACTIVE - NOT INTERESTED</span> since%' AND date_change >= DATE('2014-06-01')");    
}
foreach($staff_history as $staff_history_item){
    $userid = $staff_history_item["userid"];
    echo $staff_history_item["userid"]."<br/>";
    if (TEST){
        $categorized = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), "jsca.id")->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("userid = ?", $staff_history_item["userid"]));    
    }else{
        $categorized = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), "jsca.id")->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("userid = ?", $staff_history_item["userid"])->where("ratings = ?", 1));
    }
    
    foreach($categorized as $categorized_item){
        $history_changes = "<span style='color:#ff0000'>Displayed back</span> in the ASL List under <span style='color:#ff0000'>".$categorized_item["sub_category_name"]."</span> as per Allanaire Tapion [INCIDENT MISSING_ASL_JAN_15_2015]";          
        $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
        $db->update("job_sub_category_applicants", array("ratings"=>"0"), $db->quoteInto("id = ?", $categorized_item["id"]));
    }
}
