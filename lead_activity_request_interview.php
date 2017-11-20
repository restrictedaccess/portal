<?php
#ROY PEPITO: Asl request interview reporting - 2010-11-25

$sql = "SELECT * FROM tb_request_for_interview WHERE leads_id=".$leads_id." order by date_interview desc;";
$req = $db->fetchAll($sql);	
if(count($req) > 0)
{
	
	foreach($req as $request)
	{
	
		//request status and payment status
		switch ($request['status']) 
		{
			case "ACTIVE":
				$stat = "New";
				break;
			case "ARCHIVED":
				$stat = "Archived";
				break;
			case "ON-HOLD":
				$stat = "On Hold";
				break;															
			case "HIRED":
				$stat = "Hired";
				break;															
			case "REJECTED":
				$stat = "Rejected";
				break;		
			case "CONFIRMED":
				$stat = "Confirmed/In Process";	
				break;		
			case "YET TO CONFIRM":
				$stat = "Client contacted, no confirmed date";
				break;		
			case "DONE":
				$stat = "Interviewed; waiting for feedback";
				break;
			case "RE-SCHEDULED":
				$stat = "Confirmed/Re-Booked";
				break;	
			case "CANCELLED":
				$stat = "Cancelled";
				break;	
			default: 
				$stat = $request['status'];
				break;																																														
		}
		//$status_report = "<table>";
		//$status_report .= "<tr><td valign=top><strong>-</strong></td><td>".$stat."</td></tr>";
		$status_report = "<strong>-</strong>".$stat;
		if(isset($request['payment_status']))
		{
			//$status_report .= "<tr><td valign=top><strong>-</strong></td><td>".$request['payment_status']."</td></tr>";
			$status_report .= "<br /><strong>-</strong>".$request['payment_status'];
		}
		//$status_report .= "</table>";		
		//ended
		
		
		
		//get booking source
		$booking_source = "";
		$query = $db->select()
		->from('request_for_interview_portal')
		->where('request_for_interview_id= ?', $request['id']);
		$fac = 	$db->fetchRow($query);
		$source_agent_id = $fac['agent_id']; 
		$source_admin_id = $fac['admin_id']; 
		if($source_admin_id <> 0 && $source_admin_id <> "")
		{
			$query = $db->select()
			->from('admin')
			->where('admin_id= ?', $source_admin_id);
			$a = $db->fetchRow($query);
			$booking_source = $a['admin_fname']." ".$a['admin_lname']; 
		}
		elseif($source_agent_id && 0 || $source_admin_id <> "")
		{
			$query = $db->select()
			->from('agent')
			->where('agent_no= ?', $source_agent_id);
			$a = $db->fetchRow($query);
			$booking_source = $a['fname']." ".$a['lname']; 			
		}
		if($booking_source <> "")
		{
			$booking_source = " - ".$booking_source;
		}
		//ended
		
		
		
		//get asl appointment schedule
		$query = $db->select()
		->from('tb_app_appointment')
		->where('request_for_interview_id= ?', $request['id']);
		//->where('status= ?', 'active')
		$ap = $db->fetchRow($query);
			
			$id = $ap["id"];
			$facilitator_id = $ap["user_id"];
			$date_start = $ap["date_start"];
			$start_hour = $ap["start_hour"];
			$start_minute = $ap["start_minute"]; if($start_minute < 10) $start_minute = "0".$start_minute;
			$time_zone = $ap["time_zone"];
			$subject = $ap["subject"];
			$description = $ap["description"];
			$date_start = $ap["date_start"];
			if($start_hour >= 12) $type = "PM"; else $type = "AM";
			if($start_hour > 12) $display_hour = $start_hour - 12;			
			
			//calendar facilitator & calendar appointment schedule
			if(isset($facilitator_id))
			{
				$q = $db->select()
				->from('admin')
				->where('admin_id= ?', $facilitator_id);
				$fac = 	$db->fetchRow($q);
				$facilitator_name = $fac['admin_fname']." ".$fac['admin_lname'];			
				//ended
				
					//time conversion	
					$client_schedule = $date_start." ".$start_hour.":".$start_minute.":00 ".$type;
					$ref_date = $date_start." ".$start_hour.":".$start_minute.":00";
					$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
					date_default_timezone_set($time_zone);
					$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
									
					$destination_date = clone $date;
					$destination_date->setTimezone('Asia/Manila');
					$ph_schedule = $destination_date;
									
					$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
					$destination_date = clone $date;
					$destination_date->setTimezone('Australia/Sydney');
					$au_schedule = $destination_date;
					//ended		
				
				$facilitator_and_schedule = '	
				'.$facilitator_name.'<br />
				<font size="1">
				<font color=#FF0000>'.$time_zone.'('.$client_schedule.')</font><br />
				</font>
				<table>
					<tr>
						<td><img src=\'images/flags/Philippines.png\' width=20></td>
						<td>'.$ph_schedule.'</td>
					</tr><tr>
						<td><img src=\'images/flags/Australia.png\' width=20></td>
						<td>'.$au_schedule.'</td>
					</tr>
				</table>				
				';
			}
			else
			{
				$facilitator_and_schedule = "None";
			}
		//ended
		
		
		//applicant
		$query = $db->select()
		->from('personal' ,'fname')
		->where('userid= ?' ,$request['applicant_id']);
		$staff_name	= $db->fetchOne($query);			
		//ended
		
		
			//check the session_id if existing in `request_for_interview_job_order`
			$request_for_interview_job_order_id ="";
			$job_order_flag ="";
			$applicant_job_order_id ="";
			$sql = $db->select()
				->from('request_for_interview_job_order' , 'id')
				->where('lead_id =?' ,$request['leads_id'])
				->where('session_id =?' ,$request['session_id']);
			$request_for_interview_job_order_id = $db->fetchOne($sql);
			if($request_for_interview_job_order_id){
					//id, request_for_interview_job_order_id, no_of_applicant, proposed_start_date, duration_status, jr_cat_id, category_id, sub_category_id, date_created, form_filled_up, date_filled_up
					$sql= $db->select()
						->from('request_for_interview_job_order_position')
						->where('request_for_interview_job_order_id =?' , $request_for_interview_job_order_id);
					$job_positions = $db->fetchAll($sql);
					foreach($job_positions as $job_position){
						//id, request_for_interview_job_order_position_id, userid, work_status, working_timezone, start_work, finish_work, app_working_details_filled_up, app_working_details_date_filled_up
						$sql = $db->select()
							->from('request_for_interview_job_order_applicants' , 'id')
							->where('request_for_interview_job_order_position_id =?' , $job_position['id'])
							->where('userid =?' , $request['applicant_id']);
						$applicant_job_order_id = $db->fetchOne($sql);
						if($applicant_job_order_id){
							$jr_cat_id = $job_position['jr_cat_id'];
							break;
						}	
					}
				
			}
		
		if($applicant_job_order_id){
			$asl_jo_str ="";			
			//removed jo flag as per maam rica
			//$asl_jo_str =  "<span style='float:right;'><a href=javascript:popup_win('../asl/ShowJobSpecAppWorkingDetails.php?id=$request_for_interview_job_order_id&jr_cat_id=$jr_cat_id&applicant_id=$applicant_job_order_id&view=True',820,600);><img src='images/flag_red.gif' border='0'></a></span>";
		}else{
			$asl_jo_str ="";
		}
		
		//echo "session_id ".$request['session_id'];
		//check if the leads_id is existing in the leads_new_info table
	
		$sql = $db->select()
			->from('leads_new_info' , 'id')
			->where('leads_id =?' , $leads_id);
		//echo $sql;	
		$leads_new_info_id = $db->fetchOne($sql);	
		if($leads_new_info_id){
			$sql = $db->select()
				->from('leads_transactions')
				->where('leads_id =?' ,$leads_id)
				->where('leads_new_info_id =?', $leads_new_info_id)	
				->where('reference_column_name =?' , 'session_id')
				->where('reference_no =?',$request['session_id']);
			$asl_orders = $db->fetchAll($sql);
		}
				
		if(count($asl_orders)>0){
				$interview_result2.="<tr bgcolor='#FFFFFF'>";
				//request # & voucher #	
				if($merge_order_flag == True){
					$interview_result2 .="<td align='left'><font color=#FF0000>".$request['booking_type']." / ".$request['service_type']."</font><small style='color:#999999;display:block;test-align:center;'>merged order</small></td>"; 
				}else{
					$interview_result2 .="<td align='left'><font color=#FF0000>".$request['booking_type']." / ".$request['service_type']."</font></td>";
				}
				//date added & request schedule	
				$interview_result2 .="<td align='left'>".$request['date_added']."<br />".$request['date_interview']."<em>(".$request['time'].")</em></td>"; 
				
				if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL)
				{
					//applicant		
					$interview_result2 .="<td align='left'>".$asl_jo_str."<a href=\"javascript:popup_win('../admin-staff-resume.php?userid=".$request['applicant_id']."' , 700 , 800)\">".$staff_name."</a></td>"; 
				}
				else
				{
					//applicant	
					$update_path = str_replace('www.','',$resume_path);
					$interview_result2 .="<td align='left'>".$asl_jo_str."<a href=\"javascript:popup_win('".$update_path."staff_information.php?userid=".$request['applicant_id']."&page_type=popup' , 700 , 800)\">".$staff_name."</a></td>"; 
				}
				
				//facilitator & calendar schedule
				$interview_result2 .="<td align='left'>".$facilitator_and_schedule."</td>"; 
				//asl request status & payment status
				$interview_result2 .="<td align='left'>".$status_report.$booking_source."</td>"; 
				$interview_result2.="</tr>";
		}else{
		
				$interview_request.="<tr bgcolor='#FFFFFF'>";
				//request # & voucher #	
				if($merge_order_flag == True){
					$interview_request .="<td align='left'><font color=#FF0000>".$request['booking_type']." / ".$request['service_type']."</font><small style='color:#999999;display:block;test-align:center;'>merged order</small></td>"; 
				}else{
					$interview_request .="<td align='left'><br /><font color=#FF0000>".$request['booking_type']." / ".$request['service_type']."</font></td>"; 
				}
				//date added & request schedule	
				$interview_request .="<td align='left'>".$request['date_added']."<br />".$request['date_interview']."<em>(".$request['time'].")</em></td>"; 

				//applicant		
				if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL)
				{
					$interview_request .="<td align='left'>".$asl_jo_str."<a href=\"javascript:popup_win('../admin-staff-resume.php?userid=".$request['applicant_id']."' , 700 , 800)\">".$staff_name."</a></td>";					
				}
				else
				{
					$update_path = str_replace('www.','',$resume_path);
					$interview_request .="<td align='left'>".$asl_jo_str."<a href=\"javascript:popup_win('".$update_path."staff_information.php?userid=".$request['applicant_id']."&page_type=popup' , 700 , 800)\">".$staff_name."</a></td>"; 				    
				}
				
				//facilitator & calendar schedule
				$interview_request .="<td align='left'>".$facilitator_and_schedule."</td>"; 
				//asl request status & payment status
				$interview_request .="<td align='left'>".$status_report.$booking_source."</td>"; 
				$interview_request.="</tr>";
		}	

		
	}
}
?>