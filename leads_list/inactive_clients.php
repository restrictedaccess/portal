<?php
include('../conf/zend_smarty_conf.php');

//get all marked leads
$query = "SELECT  l.* FROM clients c JOIN leads l ON l.id = c.leads_id  WHERE (marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark' )  ".$search_str2." GROUP BY l.id ORDER BY timestamp $order_by ;";
//echo $query.'<br>';exit;
$leads = $db->fetchAll($query);
$marked_leads = array();
if($leads){ //check if not null
    foreach($leads as $lead){
	    if(!CheckLeadsStaff($lead['id'])){
		    //echo sprintf('%s %s<br>', $lead['id'], $lead['fname']);
			array_push($marked_leads,$lead);
		}
	}
}

if($marked_leads){
    $counter =0;
	//$smarty->assign('str', 'Marked Leads' );
	//$leads_list .= $smarty->fetch('leads_list_hdr.tpl');
    foreach($marked_leads as $lead){
	
	    $counter++;
		
		//domain registered
		$sql = $db->select()
		    ->from('leads_location_lookup' , 'location')
			->where('id =?',$lead['registered_domain']);
		$registered_domain = $db->fetchOne($sql);
			    
		$smarty->assign('registered_domain', $registered_domain);
	    $smarty->assign('counter', $counter);
		if (in_array($lead['status'], array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'asl' , 'custom recruitment' , 'Contacted Lead')) == true) { 
			$smarty->assign('show_checkbox', True);	
		}else{
		    $smarty->assign('show_checkbox', False);	
		}
		
		$sqlGetAllRemarks = $db->select()
		    ->from('leads_remarks')
			->where('leads_id =?',$lead['id'])
			->order('id DESC')
			->limit(1);
		$remark = $db->fetchRow($sqlGetAllRemarks); 	
		if($remark['id']){
			$det = new DateTime($remark['remark_created_on']);
			$remark_created_on = $det->format("m/j/Y "); 	
			$remark= "<a href=\"javascript:popup_win('../viewRemarks.php?leads_id=".$lead['id']."',600,600);\">".$remark_created_on." ".$remark['remark_creted_by']." ".substr(rtrim(ltrim($remark['remarks'])),0,65)."</a>"; 	
			
		}else{
		    $remark="";
		}
		$star="";
		if($lead['rating']){
		    for($x=1; $x<=$lead['rating'];$x++){
			    $star.="<img src='../images/star.png' align='top'>";
		    }
        }
		$smarty->assign('star', $star);
		$smarty->assign('steps_taken', getStepsTaken2($lead['id']));
		$smarty->assign('leads_active_staff',GetAllLeadsActiveStaff($lead['id']));
		$smarty->assign('remark', $remark);					
		$smarty->assign('leads_order_str', ShowLeadsOrder($lead['id']));
		//$smarty->assign('leads_custorm_order_str', ShowLeadsCustomOrder($lead['id']));
	    $smarty->assign('lead', $lead);
		
        $marked_leads_list .= $smarty->fetch('leads_list.tpl');
		//echo sprintf('%s %s<br>', $lead['id'], $lead['fname']);	
		
	}	
}
//end marked leads list


$query = "SELECT  l.* FROM clients c JOIN leads l ON l.id = c.leads_id WHERE ((marked='no' OR marked IS NULL) AND ask_question = 'no' AND mark_lead_for ='unmark' ) ".$search_str2." ORDER BY timestamp $order_by ;";
//echo $query."<br>";;
$leads = $db->fetchAll($query);
$inactive_leads = array();
if($leads){ //check if not null
	foreach($leads as $lead){
		if(!CheckLeadsStaff($lead['id'])){
			//echo sprintf('%s %s<br>', $lead['id'], $lead['fname']);
			array_push($inactive_leads,$lead);
		}
	}
}
//echo count($inactive_leads);
//check inactive leads
if(count($inactive_leads) > 0){
	//$bp_str = sprintf("<a name='%s'>#%s</a> %s %s",$bp['agent_no'], $bp['agent_no'], $bp['fname'], $bp['lname']);
	//$smarty->assign('str', $bp_str );
	//$smarty->assign('numrows',count($inactive_leads));
	//$leads_list .= $smarty->fetch('leads_list_hdr.tpl');
	$numrows = count($inactive_leads);
	//display leads
	$counter=0;
	foreach($inactive_leads as $lead){
				$counter++;
			
			
				//domain registered
				$sql = $db->select()
				   ->from('leads_location_lookup' , 'location')
				   ->where('id =?',$lead['registered_domain']);
				$registered_domain = $db->fetchOne($sql);
			
				$smarty->assign('registered_domain', $registered_domain);
				$smarty->assign('counter', $counter);
				if (in_array($lead['status'], array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'asl' , 'custom recruitment' , 'Contacted Lead')) == true) { 
					$smarty->assign('show_checkbox', True);	
				}else{
					$smarty->assign('show_checkbox', False);	
				}
			
				$sqlGetAllRemarks = $db->select()
					->from('leads_remarks')
					->where('leads_id =?',$lead['id'])
					->order('id DESC')
					->limit(1);
				$remark = $db->fetchRow($sqlGetAllRemarks); 	
				if($remark['id']){
					$det = new DateTime($remark['remark_created_on']);
					$remark_created_on = $det->format("m/j/Y "); 	
					$remark= "<a href=\"javascript:popup_win('../viewRemarks.php?leads_id=".$lead['id']."',600,600);\">".$remark_created_on." ".$remark['remark_creted_by']." ".substr(rtrim(ltrim($remark['remarks'])),0,65)."</a>"; 	
		
				}else{
					$remark="";
				}
				$star="";
				if($lead['rating']){
					for($x=1; $x<=$lead['rating'];$x++){
						$star.="<img src='../images/star.png' align='top'>";
					}
				 }
				$smarty->assign('star', $star);
				$smarty->assign('steps_taken', getStepsTaken2($lead['id']));
				$smarty->assign('leads_active_staff',GetAllLeadsActiveStaff($lead['id']));
				$smarty->assign('remark', $remark);	
				$smarty->assign('leads_order_str', ShowLeadsOrder($lead['id']));
				//$smarty->assign('leads_custorm_order_str', '&nbsp;');
				$smarty->assign('lead', $lead);
				$leads_list .= $smarty->fetch('leads_list.tpl');    
			   //echo sprintf('<li>%s %s</li>',$lead['id'],$lead['fname']);
			}
	//end display leads
	
}

?>