<?php
ini_set("max_execution_time", 300);
include ('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');
if (TEST){
    $sql = $db -> select() -> from(array("tbr" => "tb_request_for_interview")) -> where("DATEDIFF(CURDATE(), DATE(CASE WHEN date_updated IS NOT NULL THEN date_updated ELSE date_added END)) > 30") -> where("status NOT IN ('ARCHIVED', 'REJECTED', 'HIRED', 'ON TRIAL', 'CANCELLED')")->limit(30);
    if (isset($_GET["userid"])){
        $sql->where("applicant_id = ?", $_GET["userid"]);
    }
    if (isset($_GET["leads_id"])){
        $sql->where("leads_id = ?", $_GET["leads_id"]);
    }    
    $interview_bookings = $db -> fetchAll($sql);
}else{
    $interview_bookings = $db -> fetchAll($db -> select() -> from(array("tbr" => "tb_request_for_interview")) -> where("DATEDIFF(CURDATE(), DATE(CASE WHEN date_updated IS NOT NULL THEN date_updated ELSE date_added END)) > 30") -> where("status NOT IN ('ARCHIVED', 'REJECTED', 'HIRED', 'ON TRIAL', 'CANCELLED')"));
    
}

foreach ($interview_bookings as $interview_booking) {
    $client = $db -> fetchRow($db -> select() -> from("leads", array("id", "fname", "lname", "agent_id")) -> where("id = ?", $interview_booking["leads_id"]));
    $lead = $client;
    $applicant = $db -> fetchRow($db -> select() -> from("personal", array("userid", "fname", "lname")) -> where("userid = ?", $interview_booking["applicant_id"]));
    $admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_email"))->where("admin_id = ?", 235));
    
    
    $history_changes = "SYSTEM marked status of Interview to <span style='color:#ff0000'>Archived</span> for Client <span style='color:#ff0000'>#{$lead["id"]} - {$lead["fname"]} {$lead["lname"]}</span>";  
    $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$applicant["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
    
    $history_changes = "SYSTEM marked status of Interview to <span style='color:#ff0000'>Archived</span> to Staff <span style='color:#ff0000'>#{$applicant["userid"]} - {$applicant["fname"]} {$applicant["lname"]}</span>";  
    $db->insert("leads_info_history", array("changes"=>$history_changes, "leads_id"=>$lead["id"], "change_by_type"=>"admin", "date_change"=>date("Y-m-d H:i:s"), "change_by_id"=>159));
    
    
    $smarty = new Smarty();
    $smarty -> assign("applicant", $applicant);
    $smarty -> assign("client", $client);
    $smarty->assign("interview", $interview_booking);
    $smarty->assign("admin", $admin);
    $html = $smarty -> fetch("archive_interview.tpl");
    
    
    $attachments_array = NULL;
    $bcc_array = array();
    $cc_array = array();
    $sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
    $reply = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
    $from = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
    $subject = "Interview MARKED as ARCHIVED";
    $text = NULL;
    if (TEST){
        $to_array = array("devs@remotestaff.com.au");
    }else{
        $to_array = array($admin["admin_email"]);          
    }
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );
    
    $db -> update("tb_request_for_interview", array("status" => "ARCHIVED"), $db -> quoteInto("id = ?", $interview_booking["id"]));
}
