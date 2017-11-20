<?php
function CheckLeadIdentical($leads_id, $url){
    global $db;
    $identical_str="";
    //id, leads_id, existing_leads_id
	$queryIdentical = $db->select()
		->from(array('i' => 'leads_indentical') , array('existing_leads_id'))
		->join(array('l' => 'leads') , 'l.id = i.existing_leads_id' , array('fname' , 'lname' , 'email' , 'status'))
		->where('i.leads_id =?' , $leads_id);
			//echo $queryIdentical;		
	$identical_leads = $db->fetchAll($queryIdentical);		
	if(count($identical_leads) > 0){
	    $identical_str = "<div>Identical Name to : ";
		foreach($identical_leads as $identical_lead){
			$identical_str .="<br><a href='../leads_information.php?id=".$identical_lead['existing_leads_id']."&lead_status=".$identical_lead['status']."&url=$url'>#".$identical_lead['existing_leads_id']." ".$identical_lead['fname']." ".$identical_lead['lname']." [".$identical_lead['status']."]</a>";
		}
		$identical_str .= "</div>";
	}

    return $identical_str;
} 
function CheckBookInterviewQuestion($leads_id){
    global $db;
	$booking_question_query = "SELECT COUNT(id)AS booking_question_count FROM booking_lead_questions b WHERE leads_id = ".$leads_id." AND status = 'unread';";
	$result_booking_question_count = $db->fetchOne($booking_question_query);
	
	if($result_booking_question_count > 0){
	    $str = "<img src='./images/question_flag.png' width='30' height='40' title='has unread book an interview question'>";
	}
	
	return $str;
}

function CheckAgentActiveLeads($agent_id){
	global $db;
	/*
	$sql = $db->select()
		->from('leads' , Array('id'))
		->where('agent_id =?' , $agent_id)
		->where('status =?' , 'Client');
	*/
	$sql = "SELECT id FROM leads WHERE agent_id = $agent_id AND status = 'Client'  AND (marked is NULL OR marked != 'yes');";	
		
		
	$leads = $db->fetchAll($sql);
	$ctr = 0;
	foreach($leads as $lead){
		if(CheckLeadsStaff($lead['id'])){
			$ctr++;
		}
	}
	
	return $ctr;	
}

function CheckAgentInActiveLeads($agent_id){
	global $db;
	$sql = $db->select()
		->from('leads' , Array('id'))
		->where('agent_id =?' , $agent_id)
		->where('status =?' , 'Client');
	$leads = $db->fetchAll($sql);
	$ctr = 0;
	foreach($leads as $lead){
		if(!CheckLeadsStaff($lead['id'])){
			$ctr++;
		}
	}
	
	return $ctr;	
}

function CheckLeadsStaff($leads_id){
	//check the leads if it has an existing staff in the subcontractors table returns true else false
	global $db;
	$sql = $db->select()
		->from('subcontractors')
		->where('leads_id =?' ,$leads_id)
		->where('status =?' , 'ACTIVE');
	$leads_staff = $db->fetchAll($sql);	
	if(count($leads_staff) > 0){
		return True;
	}else{
		return False;
	}
	
}
function LeadsOf($agent_id , $business_partner_id){
	global $db;

	if($business_partner_id){
			$sql = $db->select()
						->from('agent' , Array('fname','lname'))
						->where('agent_no =?' ,$business_partner_id);
			$bpname = $db->fetchRow($sql);
			if($agent_id){
				$sql = $db->select()
							->from('agent' , Array('fname','lname'))
							->where('agent_no =?' ,$agent_id);
				$affname = $db->fetchRow($sql);
			}
		if($agent_id == $business_partner_id){
			$leads_owner = "<div>Business Developer " . $bpname['fname']." ".$bpname['lname']."</div>";
		}else{
			$leads_owner = "<div>Affiliate " . $affname['fname']." ".$affname['lname']."</div><div>Business Developer " . $bpname['fname']." ".$bpname['lname']."</div>";
			//$leads_owner .= "<div>Business Developer " . $bpname['fname']." ".$bpname['lname']."</div>";
		}
		
		return $leads_owner;
	}else{
		$leads_owner = "<span class=\"leads_owner\">Please Update leads information. No Service by Business Developer detected.</span>";
		return $leads_owner;
	}
	//return $agent_id ." / ". $business_partner_id;
}
function getBPId($agent_id){
	global $db;
	$sql = $db->select()
		->from('agent' , 'work_status')
		->where('agent_no =?' ,$agent_id);
	$work_status = $db->fetchOne($sql);	
	
	if($work_status == "AFF"){
		$sql = $db->select()
			->from('agent_affiliates' , 'business_partner_id')
			->where('affiliate_id =?' ,$agent_id);
		$business_partner_id = $db->fetchOne($sql);	
		return $business_partner_id;
	}else{
		return $agent_id; 
	}
}

function checkLeadsOwner($agent_id,$business_partner_id){
	global $db;
	if($business_partner_id != ""){
		if($agent_id != $business_partner_id){
			$sql = $db->select()
				->from('agent' , Array('fname','lname'))
				->where('agent_no =?' ,$business_partner_id);
			$bpname = $db->fetchRow($sql);	
			$leads_owner = "<span class=\"leads_owner\">NOTE : Serviced by Business Developer " . $bpname['fname']." ".$bpname['lname'] ."</span>";
			return $leads_owner;
		}
	}else{
		$leads_owner = "<span class=\"leads_owner\">Please Update leads information. No Service by Business Developer detected.</span>";
		return $leads_owner;
	}
	
}


function checkAgentIdForAdmin($agent_id){
	global $db;
	if($agent_id){
		$sql = $db->select()
			->from('agent')
			->where('agent_no = ?' , $agent_id);
		$agent = $db->fetchRow($sql); 
		if($agent['work_status'] == "BP"){
			return "<div class='agent1'>Business Partner : ".$agent['fname']." ".$agent['lname']."</div>"; 
		}else{
			$sqlBP="SELECT CONCAT(a.fname,' ',a.lname)AS bp_name ,a.email FROM agent_affiliates f 
					JOIN agent a ON a.agent_no = f.business_partner_id 
					WHERE f.affiliate_id = $agent_id;";
			$bp = $db->fetchRow($sqlBP); 
			
			$aff_name = "<div class='agent1'>Affiliate : ".$agent['fname']." ".$agent['lname']."</div>";
			$aff_name .="<div class='agent2'>Business Partner : ".$bp['bp_name']."</div>";
			return $aff_name;		
		}
		
		
			
		return $agent_id;
	}else{
		return "Unknown";
	}
}


function GetAllRemarks($leads_id){
	global $db;
	//id, leads_id, remark_creted_by, created_by_id, remark_created_on, remarks
	if($leads_id){
		$sqlGetAllRemarks = $db->select()
			->from('leads_remarks')
			->where('leads_id =?',$leads_id)
			->order('id DESC');
		$remarks = $db->fetchAll($sqlGetAllRemarks);
		
		$remark_str = "<table width='100%'>";
		foreach($remarks as $remark){
			
		}
		$remark_str = "</table>";
	}
}						
function GetAllLeadsActiveStaff($leads_id){
	global $db;
	$status = 'ACTIVE';
	if($leads_id){
		
		$sql = $db->select()
			->from('subcontractors')
			->where('leads_id =?', $leads_id)
			->where('status =?', $status);
		$result = $db->fetchAll($sql);	
		if(count($result) > 0){
			return count($result)." <img src='../images/groupofusers16.png' align='absmiddle' border='0' > <a href=\"javascript:popup_win('../viewClientStaff.php?id=".$leads_id."',600,600);\">Active Staff Member(s)</a>";
		} 
	}
}


function getStepsTaken2($leads_id){
	global $db;
	
	//Custom Recruitment
	$sql = $db->select()
	    ->from('gs_job_role_selection')
	    ->where('leads_id =?', $leads_id);
	$c_recruitment_orders = $db->fetchAll($sql);
	foreach ($c_recruitment_orders as $c_order){
	    $sql = $db->select()
		    ->from('gs_job_titles_details')
			->where('gs_job_role_selection_id =?', $c_order['gs_job_role_selection_id'] );
		$c_recruitment_job_positions = $db->fetchAll($sql);
		if(count($c_recruitment_job_positions) > 0){
		    $steps_taken.= "<div>";
			$steps_taken.= sprintf("<strong>Custom Recruitment Order #%s</strong>",$c_order['gs_job_role_selection_id']);
		    $steps_taken.="<ol>";
			foreach($c_recruitment_job_positions as $position){
			    $steps_taken.=sprintf("<li><a href=javascript:popup_win('../get_started/job_spec.php?gs_job_titles_details_id=".$position['gs_job_titles_details_id']."&jr_cat_id=".$position['jr_cat_id']."&jr_list_id=".$position['jr_list_id']."&gs_job_role_selection_id=".$c_order['gs_job_role_selection_id']."',950,600)>%s</a></li>", $position['selected_job_title']);
			}
			$steps_taken.="</ol>";
			$steps_taken.= "</div>";
		}	
	}	
    //$steps_taken = $sql;
	
	//Check if the leads is given by quote and set-up fee invoice
	//Quote 
	//$sqlQuote="SELECT id, DATE(date_posted)AS date_posted , ran FROM quote q WHERE leads_id = $leads_id AND status = 'posted';";
	$sqlQuote = "SELECT DISTINCT(q.id)AS quote_id, DATE_FORMAT(date_posted,'%D %b %y %h:%i %p')AS date_posted , ran , CONCAT(d.work_status ,' ' ,d.work_position , ' : ')AS description   , d.currency , d.quoted_price FROM quote q LEFT JOIN quote_details d ON d.quote_id =  q.id WHERE leads_id = $leads_id AND status = 'posted'";
	//echo $sqlQuote;
	$result = $db->fetchAll($sqlQuote);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<b>$ctr Quote(s)</b>";
		foreach($result as $result){
			if($result['currency']=="AUD"){
				$currency = "\$ AUD ";
			}
			if($result['currency']=="USD"){
				$currency = "\$ USD ";
			}
			if($result['currency']=="POUND"){
				$currency = "£ UK ";
			}
			
			//$steps_taken.= $result['currency']."<br>";
			$ran = $result['ran'];
			$steps_taken.= "<div style='margin-bottom:3px;'><a style='color:green;' href='../pdf_report/quote/?ran=$ran' target='_blank'> - ".$result['date_posted']." quote given ".$result['description']." ".$currency.$result['quoted_price']."</a></div>";
		}
		$steps_taken.= "</div>";
	}
	
	//service agreement
	/*
	service_agreement_id, quote_id, leads_id, created_by, created_by_type, date_created, status, date_posted, posted_by, posted_by_type, ran
	*/
	$sqlServiceAgreement = "SELECT service_agreement_id , DATE(date_posted)AS date_posted , DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , ran  FROM service_agreement s WHERE leads_id = $leads_id AND status = 'posted';";
	$result = $db->fetchAll($sqlServiceAgreement);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<div style=' margin-bottom:3px;'><b>".$ctr." Service Agreement given</b></div>";
		$initial_date = $result[0]['date_posted'];
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['date_posted'] == $initial_date ) {
				$steps_taken.= "<a  style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
			}
			if($row['date_posted'] != $initial_date ) {
				$steps_taken.= $row['date_posted']."<br>";
				$steps_taken.= "<a style = 'color:#663300;' href='../pdf_report/service_agreement/?ran=$ran' target='_blank' class=''>- ".$row['time_posted']." Service Agreement # ".$row['service_agreement_id']."</a><br>";
				$initial_date = $row['date_posted'];
			}
			
			
		}
		$steps_taken.= "</div>";
	}
	
	// Set-Up Fee
	$sqlSetUpFeeInvoice ="SELECT DISTINCT(s.id)AS id , s.status , DATE(post_date)AS post_date , DATE_FORMAT(post_date,'%h:%i %p')AS time_posted, DATE_FORMAT(paid_date,'%D %b %y %h:%i %p')AS paid_date , ran , invoice_number   FROM set_up_fee_invoice s WHERE leads_id = $leads_id AND s.status!='draft';";
	//$steps_taken.= $sqlSetUpFeeInvoice; 
	
	$result = $db->fetchAll($sqlSetUpFeeInvoice);
	$ctr = count($result);
	if($ctr>0){
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$steps_taken.= "<b>$ctr Set-up Fee Tax Invoice(s)</b><br>";
		$initial_date = $result[0]['post_date'];
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row){
			$ran = $row['ran'];
			if($row['status'] == "paid"){
				$paid_status = " <img src='../images/action_check.gif' align='absmiddle' border=0 /> Paid . ( ".$row['paid_date']. " )";
			}else{
				$paid_status = "";
			}
			
			if($row['post_date'] == $initial_date ) {
				$steps_taken.= " <a style='color:#6600FF;' href='../pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
			}
			if($row['post_date'] != $initial_date ) {
				$steps_taken.= $row['post_date']."<br>";
				$steps_taken.= " <a style='color:#6600FF;' href='../pdf_report/spf/?ran=$ran' target='_blank'> - ".$row['time_posted']." # ".$row['invoice_number']." Set-up Fee Invoice ".$paid_status."</a><br>";
				$initial_date = $row['post_date'];
			}
			
			
		}
		
		$steps_taken.= "</div>";
	}
	


	
	
	
	// Check if given Job Order form
	//job_order_id, leads_id, created_by_id, created_by_type, date_created, status, date_posted, response_by_id, response_by_type, form_filled_up, date_filled_up, ran
	$sqlJobOrderForm="SELECT DISTINCT(job_order_id),DATE(date_posted)AS posted_date,DATE_FORMAT(date_posted,'%h:%i %p')AS time_posted , DATE_FORMAT(date_filled_up,'%D %b %y %h:%i %p')AS date_filled_up,form_filled_up, ran
	  FROM job_order j WHERE leads_id = $leads_id AND j.status = 'posted';";
	  //$steps_taken.= $sqlJobOrderForm;
	$result = $db->fetchAll($sqlJobOrderForm);
	$form_filled_up = 0;
	
	if(count($result) > 0) {
		$steps_taken.= "<div style='margin-bottom:8px;'>";
		$initial_date = $result[0]['posted_date'];
		$steps_taken.= "<div style='margin-bottom:3px;'><b>".count($result). " Job Specification Form given</b></div>";
		$steps_taken.= $initial_date."<br>";
		foreach($result as $row) {
			
			if($row['form_filled_up'] == "yes") {
				$ran = $row['ran'];
				$date_filled_up = " (<img src='../images/action_check.gif' align='absmiddle' /><a class='link15' href='../pdf_report/job_order_form/?ran=$ran' target='_blank' class=''>#".$row['job_order_id']." Job Specification Form filled up ".$row['date_filled_up']."</a> )";	
			}else{
				$date_filled_up="";
				$ran ="";
				
			}
			if($row['posted_date'] == $initial_date ) {
				$steps_taken.= " - ".$row['time_posted'].$date_filled_up."<br>";
			}
			if($row['posted_date'] != $initial_date ) {
				$steps_taken.= "<b>".$row['posted_date']."</b>";
				$steps_taken.= " - ".$row['time_posted'].$date_filled_up."<br>";
				$initial_date = $row['posted_date'];
			}
			
		}
		
		$steps_taken.= "</div>";
		
	}
	
	return $steps_taken;
}

?>