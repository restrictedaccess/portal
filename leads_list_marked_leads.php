<?php
//makes the marked leads place on the very top of the list
//echo $view_leads_setting;
include 'asl_order_checker.php';
//echo "lead_status => ".$lead_status."<br>view_leads_setting =>".$view_leads_setting."<br>";
if($lead_status == "All"){
    if($view_leads_setting !="" and $view_leads_setting !='all'){
	    //echo "query 1";
		$query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes') AND business_partner_id =".$view_leads_setting." ORDER BY timestamp DESC;";
	}else{
	    //echo "query 2";
		$query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes') ORDER BY timestamp DESC;";	
	}		
		
}else{
    if($view_leads_setting !="" and $view_leads_setting !='all'){
	    //echo "query 3";
		$query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes') AND business_partner_id =".$view_leads_setting." AND status='".$lead_status."' ORDER BY timestamp DESC;";	
	}else{
	    //echo "query 4";
		$query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes')  AND status='".$lead_status."' ORDER BY timestamp DESC;";	
	}	
}
//echo "<pre>";
//print_r($leads_with_orders);
//echo "</pre>";
//echo "<br>";
//echo $query;
$leads = $db->fetchAll($query);
foreach($leads as $lead){
    array_push($leads_with_orders, $lead['id']);
}
//echo "<pre>";
//print_r($leads_with_orders);
//echo "</pre>";
//exit;
$marked_leads = array();
$selected_leads = array_unique($leads_with_orders);
foreach($selected_leads as $selected_lead){
    $sql = $db->select()
	   ->from('leads')
	   ->where('id =?', $selected_lead);
	$lead = $db->fetchRow($sql);
	array_push($marked_leads, $lead);
}
//echo "<pre>";
//print_r($marked_leads);
//echo "</pre>";
if(count($marked_leads) > 0){
	
	$counter_marked=0;
	foreach($marked_leads as $marked_lead){
		
	    if($lead_status == "All"){
            if($view_leads_setting !="" and $view_leads_setting !="all"){
			    if($marked_lead['business_partner_id'] == $view_leads_setting){
				    $counter_marked++;
			        include 'marked_lead.php';
			    }
	        }else{
			    $counter_marked++;
		        include 'marked_lead.php';
	        }		
		
        }else{
            if($view_leads_setting !="" and $view_leads_setting !="all"){
				if($marked_lead['business_partner_id'] == $view_leads_setting and $marked_lead['status'] == $lead_status){
				    $counter_marked++;
				    include 'marked_lead.php';
				}	
	        }else{
				if($marked_lead['status'] == $lead_status){
				    $counter_marked++;
				    include 'marked_lead.php';
				}	
	        }	
        }	
		
	}
}
?>