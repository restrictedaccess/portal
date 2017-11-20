<?php
include '../conf/zend_smarty_conf.php';
require('../tools/CouchDBMailbox.php');
try{
	$retries = 0;
	
	while(true){
		try{
			if (TEST){
	            $mongo = new MongoClient(MONGODB_TEST);
	            $database = $mongo->selectDB('prod');
	        }else{
	            $mongo = new MongoClient(MONGODB_SERVER);
	            $database = $mongo->selectDB('prod');
	        }
			break;
		} catch(Exception $e){
			++$retries;
			
			if($retries >= 100){
				break;
			}
		}
	}
        
    $job_orders_collection = $database->selectCollection('job_orders');
    if (TEST){
        $cursor = $job_orders_collection->find(array("order_status"=>"Open", "deleted"=>array('$ne'=>true)));    
    }else{
        $cursor = $job_orders_collection->find(array("order_status"=>"Open", "deleted"=>array('$ne'=>true), "pass_due_order"=>array('$nin'=>array(true))));
        
    }
    
    while($cursor->hasNext()){
        $result = $cursor->getNext();
        $now = strtotime(date("Y-m-d"));
        
        if ($result["last_contact"]=="No Last Contact"){
            echo $result["tracking_code"]."<br/>";
            $job_orders_collection->update(array("tracking_code"=>$result["tracking_code"]), array('$set'=>array("pass_due_order"=>true)));      
            $lead = $db->fetchRow($db->select()->from("leads", array("fname","lname", "agent_id"))->where("id = ?", $result["leads_id"]));
            $bp = $db->fetchRow($db->select()->from("agent", array("fname", "lname", "email"))->where("agent_no = ?", $lead["agent_id"]));
            
            
            $lead = $db->fetchRow($db->select()->from("leads", array("fname","lname", "agent_id"))->where("id = ?", $result["leads_id"]));
            $bp = $db->fetchRow($db->select()->from("agent", array("fname", "lname", "email"))->where("agent_no = ?", $lead["agent_id"]));
            
            $smarty = new Smarty();
            $smarty->assign("leads_id", $result["leads_id"]);
            $smarty->assign("lead_name", $lead["fname"]." ".$lead["lname"]);
            $smarty->assign("last_contact_date", "No Last Contact");
            if ($lead["agent_id"]==2){
                $smarty->assign("bp_name", "Lance &amp; Edward");
                $admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_email"))->where("admin_id = ?", 235));
                $to_array = array("lance@remotestaff.com.au", $admin["admin_email"]);
                
            }else{
                $smarty->assign("bp_name", $bp["fname"]);               
                $to_array = array($bp["email"]);
            }
            
            
            $html = $smarty->fetch("inactive_order_no_contact.tpl");
            
            $attachments_array = NULL;
            $bcc_array = array();
            $cc_array = array();
            $sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
            $reply = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
            $from = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
            $subject = "Inactive Job Order ".$result["tracking_code"];
            $text = NULL;
            if (TEST){
                $to_array = array("devs@remotestaff.com.au");
            }
            //SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );
            
        }else{
            $last_contact = $result["last_contact"]->sec;
            $datediff = $now - $last_contact;
            $age = floor($datediff/(60*60*24))+1;
            $job_orders_collection->update(array("tracking_code"=>$result["tracking_code"]), array('$set'=>array("last_contact_age"=>$age)));
            
            if ($age>=10){
                echo $result["tracking_code"]."<br/>";
                $job_orders_collection->update(array("tracking_code"=>$result["tracking_code"]), array('$set'=>array("pass_due_order"=>true)));      
                
                $lead = $db->fetchRow($db->select()->from("leads", array("fname","lname", "agent_id"))->where("id = ?", $result["leads_id"]));
                $bp = $db->fetchRow($db->select()->from("agent", array("fname", "lname", "email"))->where("agent_no = ?", $lead["agent_id"]));
                
                $smarty = new Smarty();
                $smarty->assign("leads_id", $result["leads_id"]);
                $smarty->assign("lead_name", $lead["fname"]." ".$lead["lname"]);
                $smarty->assign("last_contact_date", date("Y-m-d", $result["last_contact"]->sec));
                if ($lead["agent_id"]==2){
                    $smarty->assign("bp_name", "Lance &amp; Edward");
                    $admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_email"))->where("admin_id = ?",235));
                    $to_array = array("lance@remotestaff.com.au", $admin["admin_email"]);
                    
                }else{
                    $smarty->assign("bp_name", $bp["fname"]);               
                    $to_array = array($bp["email"]);
                }
                
                
                $html = $smarty->fetch("inactive_order.tpl");
                
                $attachments_array = NULL;
                $bcc_array = array();
                $cc_array = array();
                $sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                $reply = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                $from = "Remote Staff Recruitment<recruitment@remotestaff.com.ph>";
                $subject = "Inactive Job Order ".$result["tracking_code"];
                $text = NULL;
                if (TEST){
                    $to_array = array("devs@remotestaff.com.au");
                }
                SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );
            }else{
                $job_orders_collection->update(array("tracking_code"=>$result["tracking_code"]), array('$set'=>array("pass_due_order"=>false)));
            }            
        }
        
        
        


    }

}catch(Exception $e){
    
}
