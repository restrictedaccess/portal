<?php
foreach($staffs as $staff){
	$ctr++;
	
	if($bgcolor=="#FFFFFF"){
		$bgcolor="#CCFFCC";
	}else{
		$bgcolor="#FFFFFF";
	}
	
	
	if($staff['image']!=""){
		$image = "<img src='http://www.remotestaff.com.au/portal/tools/staff_image.php?w=48&id=".$staff['userid']."' border='0' align='texttop'  />";
	}else{
		$image = "<img src='images/ava002.jpg' border='0' align='texttop' width='48'  />";
	}
	$working_status="";
	if($staff['status']){
		$working_status = sprintf('%s<br>', $staff['status']);
	}
	$work_schedule ="";
	$starting_date = date('F j, Y', strtotime($staff['starting_date']));
	$starting_date_str = date('Y-m-d', strtotime($staff['starting_date']));
	
	//echo $starting_date;
	$contract_updated = $staff['contract_updated'];
	if($contract_updated == 'n'){ //this contract need to be updated
		//$warning = "<img src='images/warning.png' title='Staff ".$row['staff_name']." contract to Client ".$row2['client_name']." needs to be updated'>";
		$warning_str = "staff contract needs update";
	}else{
		//$warning = "<img src='images/9.gif' title='Staff ".$row['staff_name']." contract to Client ".$row2['client_name']." is updated'>";
		$warning_str ="";
	}
		     
	if($staff['work_hour']){
		$staff_start_work_hour_str = date('h:i a', strtotime($staff['work_hour']));
	}
			
	if($staff['work_hour_finish']){
		$staff_finish_work_hour_str = date('h:i a', strtotime($staff['work_hour_finish']));
	}
	
	if($staff['client_start_work_hour']){
		$client_start_work_hour_str = date('h:i a', strtotime(sprintf('%s:00:00', $staff['client_start_work_hour'])));
	}
	
	if($staff['client_finish_work_hour']){
		$client_finish_work_hour_str = date('h:i a', strtotime($staff['client_finish_work_hour']));
	}
	
			
			 
	if($staff['flexi'] == 'no'){
	     $work_schedule = sprintf('%s to %s %s', $staff_start_work_hour_str, $staff_finish_work_hour_str, $staff['staff_working_timezone']);
	}else{
	    $work_schedule = 'Flexi Schedule';
	} 
	
	$resultOptions .="<tr bgcolor='$bgcolor' class='staff_name'>";	
	$resultOptions .="<td valign='top'>".$ctr."</td>";
	$resultOptions .="<td valign='top'><a href=".$resume_page."?userid=".$staff['userid']." target='_blank'>".$image."</a><div style='float:left; display:block;'><small>SUBCON ID : ".$staff['id']."</small><br> <a href=".$resume_page."?userid=".$staff['userid']." target='_blank'><b>".$staff['fname']." ".$staff['lname']."</b></a><br>".$staff['email']."<br><strong>".$staff['job_designation']."</strong><br>".$work_schedule."</div></td>";
	$resultOptions .="<td valign='top'>";	
		
	//
	        
			
			if($starting_date_str <= date('Y-m-d')){
                $duration = sprintf("<small style='color:green;font-weight:bold;'>%s</small>", $staff['duration']);
			}else{
			    $duration = sprintf("<small style='color:green;font-weight:bold;'>%s</small>", 'Not yet started');
			}
			
			//if($staff['prepaid'] == 'yes'){
			//    $prepaid_txt = "<br>Prepaid Contract";
			//}else{
			//    $prepaid_txt = "";
			//}
			
			$csro_name="";
			if($staff['csro']){
				$csro_name = sprintf('CSRO : %s %s<br>', $staff['csro']['admin_fname'], $staff['csro']['admin_lname']);
			}
			
			$hm_name="";
			if($staff['csro']){
				$hm_name = sprintf('Hiring Manager : %s %s<br>', $staff['hm']['admin_fname'], $staff['hm']['admin_lname']);
			}
			
			$number_of_days_suspended="";
			if($staff['contract_status'] == 'suspended'){
				$working_status="";
				$number_of_days_suspended = sprintf('Date Suspended : <strong>%s</strong><br>Number of Days Suspended : <strong>%s</strong>', $staff['date_suspended'], $staff['number_of_days_suspended']);
			}
			$service_type_str="";
			if($staff['service_type']){
				$service_type_str=sprintf('<br>Service Type : %s', $staff['service_type']);
			}
			
			$staff_contract_url = sprintf('./contractForm.php?sid=%s',$staff['id']);
			$resultOptions.= "<span style='float:right;text-align:right;'>".$working_status.$csro_name.$hm_name.$number_of_days_suspended."</span><div><div style='float:left; display:block; width:350px; margin-right:2px;'><div><input type='radio' align='absmiddle' name='userid' onclick=javascript:window.open('$staff_contract_url') /> <a href='leads_information.php?id=".$staff['leads_id']."&lead_status=".$staff['leads_status']."' target='_blank'><b>".$staff['client_name']."</b></a></div><div style='margin-left:25px;'>Work Status : <span style='color:red;font-weight:bold;'>".$staff['work_status']."</span><br>Starting Date : ".$starting_date."<br>Contract Length : ".$duration."<br>".sprintf('%s-%s %s', $client_start_work_hour_str, $client_finish_work_hour_str, $staff['client_timezone']).$service_type_str."</div></div></div>";	
	//	
	
		
		
	$resultOptions .="</td>";	
	$resultOptions .="</tr>";
	
	array_push($counters,$ctr);
}	
?>