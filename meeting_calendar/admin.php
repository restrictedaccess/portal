<?php
include('../conf/zend_smarty_conf.php');

$appointment_id = $_REQUEST["appointment_id"];
if ($appointment_id){
	$appointment = $db->fetchRow($db->select()->from(array("tba"=>"tb_app_appointment"))->where("id = ?", $appointment_id));
	
	if ($appointment){
		$admin = $db->fetchRow($db->select()->from(array("a"=>"admin"))->where("a.admin_id = ?", $appointment["user_id"]));
		
		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename=calendar.ics");
		echo "BEGIN:VCALENDAR\n";
		echo "VERSION:2.0\n";
		echo "PRODID:-//Remote Staff//NONSGML Remote Staff//EN\n";
		echo "METHOD:REQUEST\n";
		echo "BEGIN:VEVENT\n";
		echo "ORGANIZER;CN=Remote Staff:mailto:noreply@remotestaff.com.au\r\n";
	
		echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-example.com\n";
		
		echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n";
		
		$datestart = $appointment["date_start"]." ".$appointment["start_hour"].":".$appointment["start_minute"].":00";
		if ($appointment["time_zone"]){
			$date = new DateTime($datestart,new DateTimeZone($appointment["time_zone"]));
			$date->setTimezone(new DateTimeZone("Asia/Manila"));
			$datestart = strtotime($date->format("F d, Y h:i A"));
			$datestart = date("Ymd", $datestart)."T".date("His", $datestart);
		}else{
			$date = new DateTime($datestart,new DateTimeZone("Asia/Manila"));
			$date->setTimezone(new DateTimeZone("Asia/Manila"));
			$datestart = strtotime($date->format("F d, Y h:i A"));
			$datestart = date("Ymd", $datestart)."T".date("His", $datestart);
		}
		
		
		if ($appointment["client_id"]){
			$lead = $db->fetchRow($db->select()->from(array("l"=>"leads"), array("fname", "lname", "email"))->where("l.id = ?", $appointment["client_id"]));
			echo "ATTENDEE;ROLE=REQ-PARTICIPANT;CN={$lead["fname"]} {$lead["lname"]}(client):MAILTO:{$lead["email"]}\n";
		}
		
		if ($appointment["leads_id"]){
			$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname", "email"))->where("p.userid = ?", $appointment["leads_id"]));
			echo "ATTENDEE;ROLE=REQ-PARTICIPANT;CN={$personal["fname"]} {$personal["lname"]}(candidate):MAILTO:{$personal["email"]}\n";
		}
		
				
		
		echo "DTSTART:{$datestart}\n";
		if ($appointment["is_allday"]=="no"){
			$dateend = $appointment["date_end"]." ".$appointment["end_hour"].":".$appointment["end_minute"].":00";	
			if ($appointment["time_zone"]){
				$date = new DateTime($dateend,new DateTimeZone($appointment["time_zone"]));
				$date->setTimezone(new DateTimeZone("Asia/Manila"));
				$dateend = strtotime($date->format("F d, Y h:i A"));
			}else{
				$date = new DateTime($dateend,new DateTimeZone("Asia/Manila"));
				$date->setTimezone(new DateTimeZone("Asia/Manila"));
				$dateend = strtotime($date->format("F d, Y h:i A"));
			}
			$dateend = date("Ymd", $dateend)."T".date("His", $dateend);
			echo "DTEND:{$dateend}\n";
		}
		if ($appointment["location"]&&trim($appointment["location"])!=""){
			echo "LOCATION:{$appointment["location"]}\n";
		}else{
			if ($appointment["appointment_type"]=="skype"){
				echo "LOCATION:Online meeting via skype \n";
			}else if ($appointment["appointment_type"]=="rschat"){
				echo "LOCATION:Online meeting via Remote Staff Chat \n";
			}else if ($appointment["appointment_type"]=="others"||$appointment["appointment_type"]=="other"){
				echo "LOCATION:Online meeting \n";
			}
		}
		echo "SUMMARY:{$appointment["subject"]}\n";
		$description = "";
		if ($appointment["description"]){
			$description .= "Message to Client\r\n";
			$description .= strip_tags($appointment["description"])."\r\n";  
		}
		if ($appointment["description_applicant"]){
			$description .= "Message to Applicant\r\n";
			$description .= strip_tags($appointment["description_applicant"]);  
		}
		$description = str_replace("\r\n", "\\n", $description);
		echo "DESCRIPTION:{$description}\n";
		echo "END:VEVENT\n";
		echo "END:VCALENDAR\n";			
	}

}



