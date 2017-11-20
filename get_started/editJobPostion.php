<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$timezone_identifiers = DateTimeZone::listIdentifiers();

$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
//gs_job_titles_details_id, gs_job_role_selection_id, jr_list_id, jr_cat_id, selected_job_title, level, no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work, form_filled_up, date_filled_up, work_weekend, comments, comment_by_id, comment_by_type, comment_date
$sql = $db->select()
	->from('gs_job_titles_details')
	->where('gs_job_titles_details_id = ?' , $gs_job_titles_details_id);
$result = $db->fetchRow($sql);	

//print_r($result);
$jr_list_id = $result['jr_list_id'];
$selected_job_title = $result['selected_job_title'];	
$level = $result['level'];
$no_of_staff_needed = $result['no_of_staff_needed'];
$work_status = $result['work_status'];
$working_timezone = $result['working_timezone'];
$start_work = $result['start_work'];
$finish_work = $result['finish_work'];


//jr_list_id, jr_cat_id, jr_name, jr_currency, jr_entry_price, jr_mid_price, jr_expert_price, jr_status
$query = $db->select()	
	->from('job_role_cat_list' ,array('jr_list_id', 'jr_name'))
	->where('jr_status != ?' , 'removed')
	->group('jr_name');
//echo $query;	
$jr_names = $db->fetchAll($query);	

foreach($jr_names as $jr_name){
	if($selected_job_title == $jr_name['jr_name']){
		$jobPositionOptions .="<option selected value= ".$jr_name['jr_list_id'].">".$jr_name['jr_name']."</option>";
	}else{
		$jobPositionOptions .="<option value= ".$jr_name['jr_list_id'].">".$jr_name['jr_name']."</option>";
	}
}	

//level
$level_array = array("entry" , "mid" , "expert");
for($i=0; $i<count($level_array); $i++){
	if($level == $level_array[$i]){
		$level_Options .= "<option selected value= ".$level_array[$i].">".strtoupper($level_array[$i])."</option>";
	}else{
		$level_Options .= "<option value= ".$level_array[$i].">".strtoupper($level_array[$i])."</option>";
	}
}


//work status
$work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr break","Part-Time 4hrs ");
$work_statusArray = array("Full-Time","Part-Time");
for($i=0;$i<count($work_statusArray);$i++){
	if($work_status == $work_statusArray[$i]){
		$work_status_Options.="<option selected value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}else{
		$work_status_Options.="<option value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}	
}

//working timezone
for ($i=0; $i < count($timezone_identifiers); $i++) {
	if($timezone_identifiers[$i] == $working_timezone){
		$timezones_Options.="<option selected value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}else{
		$timezones_Options.="<option value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}
}	



//working hours

$timeNum = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");
$timeArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 noon","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");
for($i=0; $i<count($timeNum); $i++)
{
	if($timeNum[$i] == $start_work){
		$start_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	
	if($timeNum[$i] == $finish_work)
	{
		$finish_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
}	




//configure the amount to be displayed
//SELECT * FROM job_role_cat_list j;

$query = $db->select()
	->from('job_role_cat_list')
	->where('jr_list_id = ?' ,$jr_list_id);
//echo $query;	
$resulta = $db->fetchRow($query);	
$currency = $resulta['jr_currency'];
//echo $currency;
$jr_status = $resulta['jr_status'];
$jr_list_id = $resulta['jr_list_id'];
$jr_cat_id = $resulta['jr_cat_id'];

$jr_entry_price = $resulta['jr_entry_price'];
$jr_mid_price = $resulta['jr_mid_price'];
$jr_expert_price = $resulta['jr_expert_price'];

$sql2 = $db->select()
	->from('currency_lookup')
	->where('code = ?' , $currency);
$money = $db->fetchRow($sql2);	
$currency_lookup_id = $money['id'];
$currency = $money['code'];
$currency_symbol = $money['sign'];

if($jr_status == "system"){
		if($work_status== "Part-Time"){
			//55% of the original price
			$jr_entry_price = number_format(($jr_entry_price * .55),2,'.',','); 
			$jr_mid_price = number_format(($jr_mid_price * .55),2,'.',','); 
			$jr_expert_price = number_format(($jr_expert_price * .55),2,'.',','); 
				
			$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/4),2,".",","); 
			$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/4),2,".",","); 
			$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/4),2,".",","); 
			
			
			$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
			$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
			$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );
			
		}else{
			
			$hr_entry_price = number_format((((($jr_entry_price * 12)/52)/5)/8),2,".",","); 
			$hr_mid_price = number_format((((($jr_mid_price * 12)/52)/5)/8),2,".",","); 
			$hr_expert_price = number_format((((($jr_expert_price * 12)/52)/5)/8),2,".",","); 
			
			$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_entry_price,$currency_symbol,$jr_entry_price );
			$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_mid_price,$currency_symbol,$jr_mid_price );
			$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency,$currency_symbol,$hr_expert_price,$currency_symbol,$jr_expert_price );
			
			
		}
}else{
	$entry_price_str = "-";
	$mid_price_str = "-";
	$expert_price_str = "-";
}		



if($level == "entry"){
	$amount_str = $entry_price_str;
}else if($level == "mid"){
	$amount_str = $mid_price_str;
}else{
	$amount_str = $expert_price_str;
}
//echo $work_status."<br>";
//echo $level;
$smarty->assign('jr_list_id', $jr_list_id);
$smarty->assign('jr_cat_id', $jr_cat_id);

$smarty->assign('jobPositionOptions', $jobPositionOptions);
$smarty->assign('no_of_staff_needed', $no_of_staff_needed);
$smarty->assign('level_Options', $level_Options);
$smarty->assign('work_status_Options', $work_status_Options);
$smarty->assign('timezones_Options', $timezones_Options);
$smarty->assign('start_hours_Options', $start_hours_Options);
$smarty->assign('finish_hours_Options', $finish_hours_Options);
$smarty->assign('amount_str', $amount_str);
$smarty->assign('currency', $currency);

$smarty->assign('result',$result);
$smarty->assign('gs_job_titles_details_id', $gs_job_titles_details_id);


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');
$smarty->display('editJobPostion.tpl');
?>