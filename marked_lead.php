<?php
            
			if($counter_marked == 1){
			    $leads_list .= "<tr bgcolor='#333333'>";
	$leads_list .= "<td width='80%' colspan='6' valign='top' style='padding:5px;color:white;'>";
	$leads_list .= "<div><b>MARKED LEADS</b><img src='images/star.png' ></div>";
	$leads_list .= "</td></tr>";
			
			}
			$leads_owner ="";
			
			//$timestamp = $marked_lead['timestamp'];
			$det = new DateTime($marked_lead['timestamp']);
			$timestamp = $det->format("F j, Y");
			
			$lead_name= $marked_lead['fname']." ".$marked_lead['lname'];
			if($lead_name == " ")$lead_name = "Unknown";
			$company_position= $marked_lead['company_position'];
			$company_name= $marked_lead['company_name'];
			$email= $marked_lead['email'];

			$rate= $marked_lead['rating'];
			$officenumber = $marked_lead['officenumber']; 
			$mobile = $marked_lead['mobile'];
			
			$agent_affiliate_id = $marked_lead['agent_id']; 
			$business_partner_id= $marked_lead['business_partner_id']; 
			
			if($agent_affiliate_id != $business_partner_id and $agent_affiliate_id !="" and $business_partner_id !=""){
				//check the $agent_affiliate_id if work_status = AFF
				$sql = $db->select()
					->from('agent' , 'work_status')
					->where('agent_no =?' ,$agent_affiliate_id);
				$work_status = $db->fetchOne($sql);	
				
				//if($work_status == "BP"){
					$sql = $db->select()
						->from('agent' , Array('fname','lname'))
						->where('agent_no =?' ,$business_partner_id);
					$bpname = $db->fetchRow($sql);	
					$leads_owner = "<span class=\"leads_owner\">NOTE : Serviced by Business Partner " . $bpname['fname']." ".$bpname['lname'] ."</span>";
				//}
				
			}
			$leads_owner = checkLeadsOwner(getBPId($agent_affiliate_id), $business_partner_id);
			
			
			
			
			$counter++;
			$star="";
			
			$add_remark="<p><textarea style='width:300px; height:100px;' name='remarks' id='remarks_".$marked_lead['id']."'></textarea></p>
<input type='button' name='save_remark' value='Save' class='add_note' onClick=javascript:saveNote(".$marked_lead['id'].");>
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick=javascript:toggle('note_form_".$marked_lead['id']."');>";
			 
			 for($x=1; $x<=$rate;$x++){
				$star.="<img src='images/star.png' align='top'>";
			 }

			if($officenumber != "") $officenumber = "Office no. : ". $officenumber;
			if($mobile != "") $mobile = " Mobile no. : ". $mobile;
			
			
			//domain registered
			$sql = $db->select()
				->from('leads_location_lookup' , 'location')
				->where('id =?',$marked_lead['registered_domain']);
			$registered_domain = $db->fetchOne($sql);
			
			//BOOK INTERVIEW QUESTION CHECK
			$bookQuestion = CheckBookInterviewQuestion($marked_lead['id']);
			
			$bgcolor='#FFFF99';
		//checked if the lead id is existing in the leads_new_info_id
			$queryLeadsNewInfo = $db->select()
					->from('leads_new_info' )
					->where('leads_id =?' , $marked_lead['id']);
			$leads_new_info = $db->fetchRow($queryLeadsNewInfo);
			$leads_new_info_id = $leads_new_info['id'];		
			if($leads_new_info_id){
				$marked = "<img src='images/star.png' title='Registered again in the system' >";
				$det = new DateTime($leads_new_info['timestamp']);
				$timestamp = $det->format("F j, Y").$marked;
			}else{
				$marked = "&nbsp;";
			}
			
			
			//checked if the lead is existing in leads_indentical table
			//id, leads_id, existing_leads_id
			$queryIdentical = $db->select()
					->from(array('i' => 'leads_indentical') , array('existing_leads_id'))
					->join(array('l' => 'leads') , 'l.id = i.existing_leads_id' , array('fname' , 'lname' , 'email' , 'status'))
					->where('i.leads_id =?' , $marked_lead['id']);
			//echo $queryIdentical;		
			$identical_leads = $db->fetchAll($queryIdentical);		
			if(count($identical_leads) > 0){
				$identical = "<div>Identical Name to : ";
				foreach($identical_leads as $identical_lead){
					$identical .="<br><a href='leads_information.php?id=".$identical_lead['existing_leads_id']."&lead_status=".$identical_lead['status']."&url=$url'>#".$identical_lead['existing_leads_id']." ".$identical_lead['fname']." ".$identical_lead['lname']." [".$identical_lead['status']."]</a>";
				}
				$identical .= "</div>";
			}else{
				$identical = "&nbsp;";
			}
			
					$leads_list .= "<tr bgcolor='$bgcolor' >";
					$leads_list .= "<td width='3%' valign='top' >".$counter."</td>";
					$leads_list .= "<td width='4%' valign='top' align='center' ><div class='lead_id'>".$marked_lead['id']."</div><span class='lead_status'>".$marked_lead['status']."</span></td>";
					$leads_list .= "<td width='1%' valign='top' align='center' >";
						$leads_list .= "<a href='AddUpdateLeads.php?leads_id=".$marked_lead['id']."&lead_status=".$marked_lead['status']."&url=$url'><img src='images/b_edit.png' border='0'></a><br />";
						if (in_array($marked_lead['status'], array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'Interview Bookings' , 'custom recruitment' , 'Contacted Lead')) == true) { 
								$leads_list .= "<input type='checkbox' onClick='check_val()' name='users' value='".$marked_lead['id']."' >";		
						}
					//$leads_list .=$marked;
					$leads_list .= "</td>";	
					
					$leads_list .= "<td width='35%' valign='top' >";
					$leads_list .= "<table width='100%' cellpadding='0' cellspacing ='0'>";
					$leads_list .= "<tr>";
					$leads_list .= "<td valign='top' width='49%'>";
					    
					$leads_list .= "<div class='leads_name'><a href='leads_information.php?id=".$marked_lead['id']."&lead_status=".$marked_lead['status']."'><b>".$lead_name."</b></a> ".$star."</div>";	
						$leads_list .= "<div class='email'>".$marked_lead['email']."</div>";
						$leads_list .= "<div>".$marked_lead['tracking_no']."</div>";
						$leads_list .= "<div>".$officenumber."</div>";
						$leads_list .= "<div>".$mobile."</div>";
						$leads_list .= "<div>".$marked_lead['company_name']."</div>";
						$leads_list .= "<div>".$marked_lead['leads_country']." ".$marked_lead['leads_ip']."</div>";
						$leads_list .= "<div>".$leads_owner."</div>";
					$leads_list .= "</td>";
					$leads_list .= "<td valign='top' width='49%' class='identical'><span style='float:right;'>".$bookQuestion."</span>".$identical."</td>";
					$leads_list .= "<td valign='top' width='2%'>".$marked."</td>";
					$leads_list .= "</tr>";
					$leads_list .= "</table>";	
					$leads_list .= "</td>";
						
						$leads_list .= "<td width='18%' valign='top'>";
						    	
							$leads_list .= "<div align='center' >";
								$leads_list .= "<div class='timestamp'>".$timestamp."</div>";
								$leads_list .= "<div class='registered_in'>".$registered_in_lookup[$marked_lead['registered_in']]."</div>";
								$leads_list .= "<div class='registered_domain'>".$registered_domain."</div>";
							$leads_list .= "</div>";
							$leads_list .= "<div style='color:#000000;padding-left:10px;padding-top:5px;'>";
								$leads_list .=ShowLeadsOrder($marked_lead['id']);
							$leads_list .= "</div>";
						$leads_list .= "</td>";	
						
						
						$leads_list .= "<td width='38%' valign='top'>";
							$leads_list .="<div align='right' ><a href=\"javascript: toggle('note_form_".$marked_lead['id']."');\">Temporary Note</a></div>";
							$leads_list .="<div id='note_form_".$marked_lead['id']."' class='add_notes_form'>$add_remark</div>";
							$leads_list .="<div id='".$marked_lead['id']."_latest_notes'>";
								
								$sqlGetAllRemarks = $db->select()
									->from('leads_remarks')
									->where('leads_id =?',$marked_lead['id'])
									->order('id DESC')
									->limit(1);
								$remark = $db->fetchRow($sqlGetAllRemarks); 	
								if($remark['id']){
									$det = new DateTime($remark['remark_created_on']);
									$remark_created_on = $det->format("m/j/Y "); 	
									$leads_list .= "<a href=\"javascript:popup_win('./viewRemarks.php?leads_id=".$marked_lead['id']."',600,600);\">".$remark_created_on." ".$remark['remark_creted_by']." ".substr(rtrim(ltrim($remark['remarks'])),0,65)."</a>"; 	
								}
								
							$leads_list .="</div>";
							
							$leads_list .="<div>".GetAllLeadsActiveStaff($marked_lead['id'])."</div>";
							$leads_list .="<div class='steps_list_section'>";
									$leads_list .= getStepsTaken2($marked_lead['id']);
							$leads_list .="</div>";
							
							
						$leads_list .= "</td>";	
						
					$leads_list .= "</tr>";
?>