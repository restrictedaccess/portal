<?php
foreach($filter_staffs as $staff){
    //echo "<pre>";
    //echo $staff['userid']."<br>";
    $det = new DateTime($staff['starting_date']);
	$starting_date = $det->format("F j, Y");
	$starting_date_str = $det->format("Y-m-d");
	$staff_starting_date_last_date = $det->format("t");
	//echo $staff['contract_status']."<br>";
	if($staff['contract_status'] == 'resigned'){
		$date = new DateTime($staff['resignation_date']);
		$comparing_date = $date->format('Y-m-d');
		$staff_contract_finish_date = $date->format('F j, Y');
	}else if($staff['contract_status'] == 'terminated'){
		$date = new DateTime($staff['date_terminated']);
		$comparing_date = $date->format('Y-m-d');
		$staff_contract_finish_date = $date->format('F j, Y');
	}else if($staff['contract_status'] == 'suspended'){	
	    //get the start date of suspension
		$sql = "SELECT date_change FROM subcontractors_history WHERE subcontractors_id =".$staff['id']." AND changes_status =  'suspended' ORDER BY date_change DESC LIMIT 1";
		//echo $sql."<br>";
		$date_suspended = $db->fetchOne($sql);
		$date = new DateTime($date_suspended);
		$date_suspended = $date->format('Y-m-d');
		$staff['date_suspended'] = $date->format('F j, Y');
		$staff['number_of_days_suspended'] = NumOfDays(date('Y-m-d'),$date_suspended);
		$comparing_date = date('Y-m-d');
	}else{
	    $comparing_date = date('Y-m-d');
		$staff_contract_finish_date = "";
	}
	
	
	$compare_date = create_dateDiff($comparing_date ,$starting_date_str);
	//print_r($compare_date);
	//echo "<pre>";
	$staff['duration'] = dateDiff($comparing_date,$starting_date_str);
	$staff['staff_contract_finish_date'] = $staff_contract_finish_date;
	$staff['number_of_days'] = NumOfDays($comparing_date,$starting_date_str);
	$staff['reffered_by'] = RefferedBy($staff['userid']);
	
	//csro
	if($staff['csro_id']){
		$sql = $db->select()
		    ->from('admin', array('admin_fname', 'admin_lname'))
			->where('admin_id=?', $staff['csro_id']);
		$staff['csro'] = $db->fetchRow($sql);	
	}
	//hiring manager	
	if($staff['hiring_coordinator_id']){
		$sql = $db->select()
		    ->from('admin', array('admin_fname', 'admin_lname'))
			->where('admin_id=?', $staff['hiring_coordinator_id']);
		$staff['hm'] = $db->fetchRow($sql);	
	}
	
	
	if($_POST['contract_age_option'] !=""){
		// 1 Week (7 days from the start date of contract)
		if($contract_age_option == 0){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 0 and $compare_date['day'] <= 7){
			   array_push($staffs,$staff);
		   }
		}
		
		//2 Weeks Up
		if($contract_age_option == 1){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 0 and $compare_date['day'] > 7 and $compare_date['day'] < $staff_starting_date_last_date){
			   array_push($staffs,$staff);
		   }
		}
		
		//1 Month (1 month from start date of contract)
		if($contract_age_option == 2){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 1 and $compare_date['day'] ==0){
			   array_push($staffs,$staff);
		   }
		}
		
		//1.5 Month (1 months and 2 weeks from start date of contract)
		if($contract_age_option == 3){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 1 and $compare_date['day'] > 0 and $compare_date['day'] < $staff_starting_date_last_date){
			   array_push($staffs,$staff);
		   }
		}
		
		//2 Months (2 months from start date of contract)
		if($contract_age_option == 4){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 2 and $compare_date['day'] == 0){
			   array_push($staffs,$staff);
		   }
		}
		
		
		//2.5 Months
		if($contract_age_option == 5){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 2 and $compare_date['day'] > 0 and $compare_date['day'] < $staff_starting_date_last_date){
			   array_push($staffs,$staff);
		   }
		}
		
		//3 Months
		if($contract_age_option == 6){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 3 and $compare_date['day'] == 0){
			   array_push($staffs,$staff);
		   }
		}
		
		//3.5 Months
		if($contract_age_option == 7){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 3 and $compare_date['day'] > 0 and $compare_date['day'] < $staff_starting_date_last_date){
			   array_push($staffs,$staff);
		   }
		}
		
		
		//4 Months
		if($contract_age_option == 8){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 4 and $compare_date['day'] == 0){
			   array_push($staffs,$staff);
		   }
		}
		
		//4 Months Up (Contract between 4 months and 6 Months
		if($contract_age_option == 9){
		   if($compare_date['year'] == 0 and $compare_date['month'] >= 4 and $compare_date['month'] <= 5 and $compare_date['day'] > 0 and $compare_date['day'] < $staff_starting_date_last_date){
			   array_push($staffs,$staff);
		   }
		}
		
		
		//6 Months (6 months old)
		if($contract_age_option == 10){
		   if($compare_date['year'] == 0 and $compare_date['month'] == 6 and $compare_date['day'] == 0){
			   array_push($staffs,$staff);
		   }
		}
		
		
		//6 Months Up (Contract between 6 months and 1 year)
		if($contract_age_option == 11){
		   if($compare_date['year'] == 0 and $compare_date['month'] >= 6 ){
			   array_push($staffs,$staff);
		   }
		}
		
		
		//12 Months
		if($contract_age_option == 12){
		   if($compare_date['year'] == 1 and $compare_date['month'] == 0 and $compare_date['day'] == 0){
			   array_push($staffs,$staff);
		   }
		}
		
		//12 Months UP (Contract 12 months old and Up)
		if($contract_age_option == 13){
		   if($compare_date['year'] >= 1 and $compare_date['month'] >= 0 ){
			   array_push($staffs,$staff);
		   }
		}
	
	}else{
	
	//if ($contract_age_option == ""){
	    array_push($staffs,$staff);
	}
	
}
//echo "<pre>";
//print_r($staffs);
//echo "</pre>";
//exit;
?>
