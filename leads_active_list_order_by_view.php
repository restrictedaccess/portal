<?php
if($order_by == 'DESC'){
	$leads_list .= "<tr bgcolor='#333333'>";
	$leads_list .= "<td width='80%' colspan='6' valign='top' style='padding:5px;color:white;'>";
	$leads_list .= "<div><b>THE LIST IS IN CURRENT TO OLD VIEW [DESCENDING]</b></div>";
	$leads_list .= "</td>";
	$leads_list .= "</tr>";
}

if($order_by == 'ASC'){
	$leads_list .= "<tr bgcolor='#333333'>";
	$leads_list .= "<td width='80%' colspan='6' valign='top' style='padding:5px;color:white;'>";
	$leads_list .= "<div><b>THE LIST IS IN OLD TO CURRENT VIEW [ASCENDING]</b></div>";
	$leads_list .= "</td>";
	$leads_list .= "</tr>";
}

include 'leads_list_marked_leads.php';


$query = "SELECT  l.* FROM clients c JOIN leads l ON l.id = c.leads_id WHERE $status_Search $search_options  ORDER BY l.timestamp $order_by $limit ";
//$query = "SELECT * FROM leads l WHERE $status_Search $search_options  ORDER BY timestamp $order_by $limit ";
//echo $query."<br>";exit;
$leads = $db->fetchAll($query);
$leads_owner ="";	
		
		
foreach($leads as $lead){
			$leads_owner ="";
			
			//$timestamp = $lead['timestamp'];
			$det = new DateTime($lead['timestamp']);
			$timestamp = $det->format("F j, Y");
			
			$lead_name= $lead['fname']." ".$lead['lname'];
			if($lead_name == " ")$lead_name = "Unknown";
			$company_position= $lead['company_position'];
			$company_name= $lead['company_name'];
			$email= $lead['email'];

			$rate= $lead['rating'];
			$officenumber = $lead['officenumber']; 
			$mobile = $lead['mobile'];
			
			$agent_affiliate_id = $lead['agent_id']; 
			$business_partner_id= $lead['business_partner_id']; 
			
			
			
			
			$counter++;
			$star="";
			
			$add_remark="<p><textarea style='width:300px; height:100px;' name='remarks' id='remarks_".$lead['id']."'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick=javascript:saveNote(".$lead['id'].");>
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick=javascript:toggle('note_form_".$lead['id']."');>";
			 
			 for($x=1; $x<=$rate;$x++){
				$star.="<img src='images/star.png' align='top'>";
			 }

			if($officenumber != "") $officenumber = "Office no. : ". $officenumber;
			if($mobile != "") $mobile = " Mobile no. : ". $mobile;
			
			
			//domain registered
			$sql = $db->select()
				->from('leads_location_lookup' , 'location')
				->where('id =?',$lead['registered_domain']);
			$registered_domain = $db->fetchOne($sql);
			
		    //BOOK INTERVIEW QUESTION CHECK
			$bookQuestion = CheckBookInterviewQuestion($lead['id']);
			
			
			$bgcolor='#FFFFFF';
				
						
			$lead_no_of_orders = CheckLeadsOrderInASL($lead['id']);
			if($lead['marked'] != 'yes' and $lead['ask_question'] != 'yes' and $lead_no_of_orders ==0 ){
				if(CheckLeadsStaff($lead['id'])){
					$leads_list .= "<tr bgcolor='$bgcolor' >";
					$leads_list .= "<td width='3%' valign='top' >".$counter."</td>";
					$leads_list .= "<td width='4%' valign='top' align='center' ><div class='lead_id'>".$lead['id']."</div><span class='lead_status'>".$lead['status']."</span></td>";
					$leads_list .= "<td width='1%' valign='top' align='center' >";
						$leads_list .= "<a href='AddUpdateLeads.php?leads_id=".$lead['id']."&lead_status=".$lead['status']."&url=$url'><img src='images/b_edit.png' border='0'></a><br />";
						if (in_array($lead['status'], array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'Interview Bookings' , 'custom recruitment' , 'Contacted Lead')) == true) { 
								$leads_list .= "<input type='checkbox' onClick='check_val()' name='users' value='".$lead['id']."' >";		
						}
					$leads_list .= "<input type='radio' onClick='ViewLeadsProfile(".$lead['id'].")' name='view_leads' >";
					$leads_list .= "</td>";	
					
					$leads_list .= "<td width='40%' valign='top' >";
					$leads_list .= "<table width='100%' cellpadding='0' cellspacing ='0'>";
					$leads_list .= "<tr>";
					$leads_list .= "<td valign='top' width='55%'>";
					$leads_list .= "<div class='leads_name'><a href='leads_information.php?id=".$lead['id']."&lead_status=".$lead['status']."'><b>".$lead_name."</b></a> ".$star."</div>";	
						$leads_list .= "<div class='email'>".$lead['email']."</div>";
						$leads_list .= "<div>".$lead['tracking_no']."</div>";
						$leads_list .= "<div>".$officenumber."</div>";
						$leads_list .= "<div>".$mobile."</div>";
						$leads_list .= "<div>".$lead['company_name']."</div>";
						$leads_list .= "<div>".$lead['leads_country']." ".$lead['state']." ".$lead['leads_ip']."</div>";
						$leads_list .= "<div>".$leads_owner."</div>";
					$leads_list .= "</td>";
					$leads_list .= "<td valign='top' width='45%' class='identical'>";
					    if($_SESSION['admin_id']){
					        $leads_list .="<span style='float:right;'>".$bookQuestion."</span>";
						}
					    $leads_list .= LeadsOf($agent_affiliate_id, $business_partner_id);
					$leads_list .= "</td>";
					$leads_list .= "</tr>";
					$leads_list .= "</table>";	
					$leads_list .= "</td>";
						
						$leads_list .= "<td width='18%' valign='top'>";	
							$leads_list .= "<div align='center' >";
								$leads_list .= "<div class='timestamp'>".$timestamp."</div>";
								$leads_list .= "<div class='registered_in'>".$registered_in_lookup[$lead['registered_in']]."</div>";
								$leads_list .= "<div class='registered_domain'>".$registered_domain."</div>";
							$leads_list .= "</div>";
							$leads_list .= "<div style='color:#000000;padding-left:10px;padding-top:5px;'>";
								$leads_list .=ShowLeadsOrder($lead['id']);
							$leads_list .= "</div>";
						$leads_list .= "</td>";		
						
						
						$leads_list .= "<td width='38%' valign='top'>";
							$leads_list .="<div align='right' ><a href=\"javascript: toggle('note_form_".$lead['id']."');\">Temporary Note</a></div>";
							$leads_list .="<div id='note_form_".$lead['id']."' class='add_notes_form'>$add_remark</div>";
							$leads_list .="<div id='".$lead['id']."_latest_notes'>";
								
								$sqlGetAllRemarks = $db->select()
									->from('leads_remarks')
									->where('leads_id =?',$lead['id'])
									->order('id DESC')
									->limit(1);
								$remark = $db->fetchRow($sqlGetAllRemarks); 	
								if($remark['id']){
									$det = new DateTime($remark['remark_created_on']);
									$remark_created_on = $det->format("m/j/Y "); 	
									$leads_list .= "<a href=\"javascript:popup_win('./viewRemarks.php?leads_id=".$lead['id']."',600,600);\">".$remark_created_on." ".$remark['remark_creted_by']." ".substr(rtrim(ltrim($remark['remarks'])),0,65)."</a>"; 	
								}
								
							$leads_list .="</div>";
							
							$leads_list .="<div>".GetAllLeadsActiveStaff($lead['id'])."</div>";
							$leads_list .="<div class='steps_list_section'>";
									$leads_list .= getStepsTaken2($lead['id']);
							$leads_list .="</div>";
							
							
						$leads_list .= "</td>";	
						
					$leads_list .= "</tr>";
			}
		}		
					
}

?>