<?php
//get all marked leads
$query = "SELECT l.* FROM subcontractors s JOIN leads l ON l.id = s.leads_id  WHERE s.status = 'ACTIVE' AND (marked='yes' OR ask_question = 'yes'  OR mark_lead_for !='unmark' )  ".$search_str2." GROUP BY l.id ORDER BY timestamp $order_by ;";
//echo $query.'<br>';
$marked_leads = $db->fetchAll($query);
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


//UNMARKED LEADS
$queryCount = "SELECT COUNT(DISTINCT(s.leads_id))AS numrows FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' AND ((marked='no' OR marked IS NULL) AND ask_question = 'no' AND mark_lead_for ='unmark' ) ".$search_str2." ORDER BY timestamp $order_by;";
//echo $queryCount."<br>";
$numrows = $db->fetchOne($queryCount);
//echo $numrows."<br>";

/*
if($numrows > 0){ //filter if the bp has no leads
		$self = sprintf('./%s?lead_status=%s',basename($_SERVER['SCRIPT_FILENAME']),$lead_status);
		$maxPage = ceil($numrows/$rowsPerPage);
		if($maxPage > 1 ){
			$paging = "<select name='unmarked_list' id='unmarked_list' onchange='setPageNum2(this.value)'>";
		}else{
			$paging = "<select disabled>";
		}	
   
		for($i = 1; $i <= $maxPage; $i++){
			if ($i == $pageNum){
				$paging .= " <option selected value='".$i."'>Page $i</option> ";
			}else{
				$paging .= " <option value='".$i."'>Page $i</option> ";
			}
		}
	$paging .= "</select>";
}	
*/
// end pagination

if(isset($_REQUEST['page'])){
   $limit = " LIMIT $offset2, $rowsPerPage ";
   $counter =$offset2 ;
}else{
   $limit = " LIMIT $offset, $rowsPerPage ";
   $counter =0 ;
}


$query = "SELECT l.* FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' AND ((marked='no' OR marked IS NULL) AND ask_question = 'no' AND mark_lead_for ='unmark' ) ".$search_str2." GROUP BY s.leads_id ORDER BY timestamp $order_by $limit;"; 
//echo $query;
$leads= $db->fetchAll($query);
if(count($leads) > 0){
	//$bp_str = sprintf("<a name='%s'>#%s</a> %s %s",$agent['agent_no'], $agent['agent_no'], $agent['fname'], $agent['lname']);
	//echo $bp_str."<ol>";
	//$smarty->assign('str', $bp_str );
	$smarty->assign('paging', $paging);
	$smarty->assign('numrows',$numrows);
	$leads_list .= $smarty->fetch('leads_list_hdr.tpl');

	foreach($leads as $lead){
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
//echo "</ol>";
}
?>