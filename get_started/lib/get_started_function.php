<?php
function compareData($data , $id){
	global $db;
	$history_changes ="";
	//PARSE DATA
	//no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work
	  
    $query = "SELECT * FROM gs_job_titles_details WHERE gs_job_titles_details_id = $id;";
    $result = $db->fetchRow($query);

	$difference = array_diff_assoc($data,$result);
	if($difference > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("<li>%s from <em>%s</em> to <em>%s</em></li>", $array_key, $result[$array_key] , $difference[$array_key]);
		}
	}
	return $history_changes;
}

function ShowFilledBy($id, $table, $field){
    global $db;
	if($table == 'admin'){
	    $sql = $db->select()
		    ->from('admin')
			->where('admin_id =?', $id);
		$admin = $db->fetchRow($sql);
		if($field == 'email'){
		    return $admin['admin_email'];
		}else{
		    return sprintf('Admin %s', $admin['admin_fname']);
		}		
	}
	if($table == 'agent'){
	    $sql = $db->select()
		    ->from('agent')
			->where('agent_no =?', $id);
		$agent = $db->fetchRow($sql);
		if($field == 'email'){
		    return $agent['email'];
		}else{
		    return sprintf('BD %s', $agent['fname']);
		}	
	}
	if($table == 'leads'){
	    $sql = $db->select()
		    ->from('leads')
			->where('id =?', $id);
		$lead = $db->fetchRow($sql);
		if($field == 'email'){
		    return $lead['email'];
		}else{
		    return sprintf('%s %s', $lead['fname'], $lead['lname']);
		}	
	}
}

function rand_str($length = 45, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    // Length of character list
    $chars_length = strlen($chars);

    // Start our string
    $string = $chars{rand(0, $chars_length)};
   
    // Generate random string
    for ($i = 1; $i < $length; $i++) {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        $string = $string . $r;
    }
   
    // Return the string
    return $string;
}

function formatPrice($price){
	$price = number_format($price,2,".",",");
	return $price;
	
}
function setConvertTimezones($original_timezone, $converted_timezone , $start_time, $finish_time){
	if($original_timezone!=""){
		$converted_timezone = new DateTimeZone("$converted_timezone");
		$original_timezone = new DateTimeZone($original_timezone);
		 
		$start_time_str = $start_time;
		if ($start_time_str == null) {
			$start_time_hour = "";
		}
		else {
			//INFO: Due to the client_start_work_hour field type, I had to append a :00
			$time = new DateTime($start_time_str.":00", $original_timezone);
			$time->setTimeZone($converted_timezone);
			$start_hour = $time->format('h:i a');
		}
	
		$finish_time_str = $finish_time;
		if ($finish_time_str == null) {
			$finish_time_hour = "";
		}
		else {
			//INFO: Due to the client_start_work_hour field type, I had to append a :00
			$time = new DateTime($finish_time_str.":00", $original_timezone);
			$time->setTimeZone($converted_timezone);
			$finish_hour = $time->format('h:i a');
		}
		return $start_hour." - ".$finish_hour;
	}else{
		return "00:00 - 00:00";
	}
}

function get_rand_id()
{
  $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $lenght = 100; 
        (string) $keygen = '';
        for($i=0;$i<=$lenght;$i++){
            $keygen .= $chars[rand(0,60)]; 
		}
  return $keygen;
} 
function strip_spaces($string){
	$sPattern = '/\s*/m';
	$sReplace = '';
	return preg_replace( $sPattern, $sReplace, $string );
}


?>