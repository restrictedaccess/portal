<?php
$STAFF_CURRENCY = Array('PHP', 'INR');
$CLIENT_CURRENCY = Array('AUD', 'USD', 'GBP');
$STAFF_COUNTRY = Array('Philippines', 'India');
$STAFF_TIMEZONE = Array('Asia/Manila', 'Asia/Kolkata');

$FULLTIME_MARGINS = Array('AUD' => 460, 'USD' => 355, 'GBP' => 275);
$PARTTIME_MARGINS = Array('AUD' => 275, 'USD' => 210, 'GBP' => 165);


//New margin rate if Staff Salary is below 20k
$NEW_FULLTIME_MARGINS = Array('AUD' => 370, 'USD' => 285, 'GBP' => 220);
//$NEW_PARTTIME_MARGINS = Array('AUD' => 150, 'USD' => 150, 'GBP' => 91.5);

//New margin part-time rate if Staff Salary is below 14k
$NEW_PARTTIME_MARGINS_FOR_14k_BELOW = Array('AUD' => 230, 'USD' => 180, 'GBP' => 135);


function leads_endorsed_interviewed_candidates($leads_id){
    global $db;
	$data = array();
    $applicants = array();
	
	
	$sql = "SELECT DISTINCT(applicant_id)AS userid, p.fname, p.lname FROM tb_request_for_interview t JOIN personal p ON p.userid = t.applicant_id WHERE leads_id = ".$leads_id."   ORDER BY p.fname;";
    $interviewed = $db->fetchAll($sql);
    foreach($interviewed as $applicant){
        $data = array(
	        'userid' => $applicant['userid'],
		    'fname' => strtolower($applicant['fname']),
		    'lname' => strtolower($applicant['lname'])
	    );
	    array_push($applicants, $data);
    }


    $sql = "SELECT DISTINCT(t.userid)AS userid, p.fname, p.lname FROM tb_endorsement_history t JOIN personal p ON p.userid = t.userid WHERE client_name = ".$leads_id." ORDER BY p.fname;";
    $endorsed = $db->fetchAll($sql);
    foreach($endorsed as $applicant){
        $data = array(
	        'userid' => $applicant['userid'],
		    'fname' => strtolower($applicant['fname']),
		    'lname' => strtolower($applicant['lname'])
	    );
	    array_push($applicants, $data);
    }

    $applicants = super_unique($applicants);
    usort($applicants, "cmp");
    return $applicants;
}

function super_unique($array){
    //removing the thesame data
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
    foreach ($result as $key => $value){
        if ( is_array($value) ){
            $result[$key] = super_unique($value);
        }
    }
    return $result;
}

function cmp($a, $b){
    //sorting the array by applicant fname field
	return strcmp($a["fname"], $b["fname"]);
}


function get_rand_id()
{
            $finish_time_hour = "";
  $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $lenght = 44; 
        (string) $keygen = '';
        for($i=0;$i<=$lenght;$i++){
            $keygen .= $chars[rand(0,37)]; 
        }
  return $keygen;
} 

function CheckRan($ran){
    global $db;
	$query = "SELECT * FROM quote WHERE ran = '$ran';";
	$result =  $db->fetchAll($query);
	if (count($result) >0 )
	{
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
}

function getCreator($by , $by_type)
{
    global $db;
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$row = $db->fetchRow($query);
		$name = sprintf('BP %s %s',  $row['fname'], $row['lname']);
		
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$row = $db->fetchRow($query);
		$name = sprintf('Admin %s %s', $row['admin_fname'], $row['admin_lname']);
	}
	else{
		$name="";
	}
	return $name;
	
}

function getCreatorEmail($by , $by_type)
{
    global $db;
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$row = $db->fetchRow($query);
		$name = $row['email'];
		
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$row = $db->fetchRow($query);
		$name = $row['admin_email'];
	}
	else{
		$name="";
	}
	return $name;
	
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

function ConvertTime($original_timezone, $converted_timezone , $start_time){
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
        return $start_hour;
    }
}

function ConvertTime2($original_timezone, $converted_timezone , $start_time){
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
            $start_hour = $time->format('H:i');
        }
		//$start_hour = str_replace(":30",".5",$start_hour);
		$start_hour = str_replace(":00","",$start_hour);
        return $start_hour;
    }
}
?>