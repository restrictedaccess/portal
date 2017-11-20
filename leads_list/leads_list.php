<?php
include('../conf/zend_smarty_conf.php');
//get all marked leads
if ($lead_status == 'Client' and (!$_GET['filter'])){
    //echo $search_str2;
	//echo "<br>";
	//$search_str2 = " AND l.status IN('Client', 'Inactive') ";
	$query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes' OR  mark_lead_for !='unmark'  )  AND l.status IN ('Client', 'Inactive') ORDER BY timestamp $order_by ;";

}else{
    $query = "SELECT * FROM leads l WHERE (marked='yes' OR ask_question = 'yes' OR mark_lead_for !='unmark' )  ".$search_str2." ORDER BY timestamp $order_by ;";

}


//echo $query.'<br>';
//exit;
$marked_leads = $db->fetchAll($query);
if($marked_leads){
    $counter =0;
	$smarty->assign('str', 'Marked Leads' );
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
		
		//checked if the lead is existing in leads_indentical table
		$identical_str = CheckLeadIdentical($lead['id'], $url);
		$smarty->assign('identical_str', $identical_str);
		$smarty->assign('star', $star);
		$smarty->assign('steps_taken', getStepsTaken2($lead['id']));
		$smarty->assign('leads_active_staff',GetAllLeadsActiveStaff($lead['id']));
		$smarty->assign('remark', $remark);					
		$smarty->assign('leads_order_str', ShowLeadsOrder($lead['id']));
		//$smarty->assign('leads_custorm_order_str', ShowLeadsCustomOrder($lead['id']));
	    $smarty->assign('lead', $lead);
		//$smarty->assign('show_mark_btn', False);
		$smarty->assign('date_today',$date_today);
		$marked_leads_list .= $smarty->fetch('leads_list.tpl');
		//echo sprintf('%s %s<br>', $lead['id'], $lead['fname']);	
		
	}	
}



//UNMARKED LEADS


        //pagination
		$queryCount = "SELECT COUNT(id)AS numrows FROM leads l WHERE ((marked='no' OR marked IS NULL) AND ask_question = 'no' AND mark_lead_for ='unmark' ) ".$search_str2." ORDER BY timestamp $order_by;";
		//echo $queryCount."<br>";
        //exit;
		$numrows = $db->fetchOne($queryCount);
			
		
		// end pagination

        if(isset($_REQUEST['page'])){
		   $limit = " LIMIT $offset2, $rowsPerPage ";
		   $counter =$offset2 ;
		}else{
		   $limit = " LIMIT $offset, $rowsPerPage ";
		   $counter =0 ;
		} 
		
		
        $query = "SELECT * FROM leads l WHERE ((marked='no' OR marked IS NULL) AND ask_question = 'no' AND mark_lead_for ='unmark' ) ".$search_str2." ORDER BY timestamp $order_by $limit;";
        //echo $query;
		//exit;
		$leads= $db->fetchAll($query);
		if(count($leads) > 0){
		        
		        //$smarty->assign('str', "<a name='UNMARKED'>UNMARKED</a>" );
			    $smarty->assign('paging', $paging);
			    //$smarty->assign('numrows',$numrows);
    		    //$leads_list .= $smarty->fetch('leads_list_hdr.tpl');
		        $identical_str ='';
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
					$smarty->assign('identical_str', $identical_str); 
					$smarty->assign('star', $star);
				    $smarty->assign('steps_taken', getStepsTaken2($lead['id']));
				    $smarty->assign('leads_active_staff',GetAllLeadsActiveStaff($lead['id']));
		            $smarty->assign('remark', $remark);	
				    $smarty->assign('leads_order_str', ShowLeadsOrder($lead['id']));
				    $smarty->assign('lead', $lead);
					$smarty->assign('show_mark_btn', True);
					$smarty->assign('date_today',$date_today);
                    $leads_list .= $smarty->fetch('leads_list.tpl');    
                }
		    }
?>