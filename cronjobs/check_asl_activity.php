<?php
ini_set("max_execution_time", 300);
include '../conf/zend_smarty_conf.php';
require('../tools/CouchDBMailbox.php');
/**
 * Send ASL Email to check activity of ASL Staff
 * @param array $possible_inactives Possible ASL Staff that are inactive
 * @param int $days The day of inactivity
 */
function sendCheckASLEmail($possible_inactives, $days){
    global $db;
    
    foreach($possible_inactives as $possible_inactive){
        while(true){
                
            
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $rand_pw = '';    
            for ($p = 0; $p < 10; $p++) {
                $rand_pw .= $characters[mt_rand(0, strlen($characters))];
            }
            $mass_responder_code = sha1($rand_pw);
            $responder = $db->fetchRow($db->select()->from("personal_auto_sent_autoresponders", array("mass_responder_code"))->where("mass_responder_code = ?", $mass_responder_code));
            if (!$responder){
                //record attempt    
                $db->insert("personal_auto_sent_autoresponders", array("responded"=>0, "date_sent"=>date("Y-m-d H:i:s"), "userid"=>$possible_inactive["userid"], "type"=>"ASL_CHECK", "mass_responder_code"=>$mass_responder_code));
                //send auto responder
            
                //personal
                $personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "email"))->where("userid = ?", $possible_inactive["userid"]));     
                if ($personal){
                    $smarty = new Smarty();
                    $smarty->assign("first_name", $personal["fname"]);
                    if (TEST){
                        $smarty->assign("url", "http://test.remotestaff.com.au");
                    }else{
                        $smarty->assign("url", "http://remotestaff.com.au");
                    }
                    $smarty->assign("mass_responder_code", $mass_responder_code);
                    $smarty->assign("userid", $possible_inactive["userid"]);
                    $smarty->assign("days","30");
                    $html = $smarty->fetch("checking_asl.tpl");
                    $attachments_array = NULL;
                    $bcc_array = array();
                    $cc_array = array();
                    $sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                    $reply = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                    $from = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                    $subject = "Are you still available for a homebased job at RemoteStaff?";
                    $text = NULL;
                    if (TEST){
                        $to_array = array("devs@remotestaff.com.au");
                    }else{
                        $to_array = array($personal["email"]);          
                    }
                    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );
                    
                    $history_changes = "SYSTEM sent autoresponder <span style='color:#ff0000'>Are you still available for a homebased job at RemoteStaff?</span>";  
                    $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$possible_inactive["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
                    
                    $db->insert("applicant_history", array("history"=>strip_tags($html), "date_created"=>date("Y-m-d H:i:s"), "subject"=>$subject, "actions"=>"EMAIL", "userid"=>$possible_inactive["userid"], "created_by_type"=>"admin", "admin_id"=>159));
                    }
                }
            
                break;      
            
        }
                
    }
}

//for 30th day
if (TEST){
    if (isset($_GET["userid"])){
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid  WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference = 30 AND dateupdated_difference = 30 LIMIT 10");        
    }else{
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference = 30 AND dateupdated_difference = 30 LIMIT 10");
    }
}else{
    if (isset($_GET["userid"])){
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference = 30 AND dateupdated_difference = 30 ");
    }else{
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference = 30 AND dateupdated_difference = 30 ");
    }   
    
}


sendCheckASLEmail($possible_inactives, 30);

//for 60th day
if (TEST){
    if (isset($_GET["userid"])){
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid  WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference = 60 AND dateupdated_difference = 60 LIMIT 10");        
    }else{
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference = 60 AND dateupdated_difference = 60 LIMIT 10");
    }
}else{
    if (isset($_GET["userid"])){
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference = 60 AND dateupdated_difference = 60 ");
    }else{
        $possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference = 60 AND dateupdated_difference = 60 ");
    }   
    
}

sendCheckASLEmail($possible_inactives, 60);


if (TEST){
	if (isset($_GET["userid"])){
		$possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid  WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference >= 90 AND dateupdated_difference >= 90 LIMIT 10");		
	}else{
		$possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference >= 90 AND dateupdated_difference >= 90 LIMIT 10");
	}
}else{
	if (isset($_GET["userid"])){
		$possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 AND jsca.userid = '".addslashes($_GET["userid"])."' GROUP BY jsca.userid HAVING difference >= 90 AND dateupdated_difference >= 90 ");
	}else{
		$possible_inactives = $db->fetchAll("SELECT TIMESTAMPDIFF(DAY, CASE WHEN jsca.recategorized_date IS NULL THEN jsca.sub_category_applicants_date_created ELSE jsca.recategorized_date END, CURDATE()) AS difference, jsca.userid, TIMESTAMPDIFF(DAY, p.dateupdated, CURDATE()) AS dateupdated_difference FROM job_sub_category_applicants AS jsca LEFT JOIN personal AS p ON p.userid=jsca.userid WHERE jsca.userid NOT IN (SELECT userid FROM inactive_staff) AND jsca.ratings = 0 GROUP BY jsca.userid HAVING difference >= 90 AND dateupdated_difference >= 90 ");
	}	
	
}

foreach($possible_inactives as $possible_inactive){
    $history_changes = "Auto marked as <span style='color:#ff0000'>INACTIVE - NOT INTERESTED</span> since we did not received respond for 90 days";  
    $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$possible_inactive["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
    //query first all categorized entry saved them for reference
    $jscas = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.id"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("jsca.userid = ?", $possible_inactive["userid"])->where("jsca.ratings = 0"));
    foreach($jscas as $jsca){
        $history_changes = "<span style='color:#ff0000'>Removed</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
        $db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$possible_inactive["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
        $db->insert("personal_autohide_categorization", array("userid"=>$possible_inactive["userid"], "jsca_id"=>$jsca["id"], "date_created"=>date("Y-m-d H:i:s")));    
    }
    $db->update("job_sub_category_applicants", array("ratings"=>1), $db->quoteInto("userid = ?", $possible_inactive["userid"]));
    $db->insert("inactive_staff", array("userid"=>$possible_inactive["userid"], "admin_id"=>159, "type"=>"NOT INTERESTED", "date"=>date("Y-m-d H:i:s")));
}

sendCheckASLEmail($possible_inactives, 90);
