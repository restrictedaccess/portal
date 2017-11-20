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
		if ($admin){
			echo "ORGANIZER;CN=\"Remote Staff({$admin["admin_fname"]} {$admin["admin_lname"]})\":mailto:".$admin["admin_email"]."\r\n";
		}else{
			echo "ORGANIZER;CN=Remote Staff:mailto:hiringmanagers@remotestaff.com.au\r\n";
		}
	
		echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-example.com\n";
		
		echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n";
		
		$datestart = strtotime($appointment["date_start"]." ".$appointment["start_hour"].":".$appointment["start_minute"].":00");
		$datestart = date("Ymd", $datestart)."T".date("His", $datestart);
		echo "DTSTART:{$datestart}\n";
		if ($appointment["is_allday"]=="no"){
			$dateend = strtotime($appointment["date_end"]." ".$appointment["end_hour"].":".$appointment["end_minute"].":00");	
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
		
		$description = str_replace("\r\n", "\\n", strip_tags($appointment["description"]));
		echo "DESCRIPTION: {$description}\n";
		echo "END:VEVENT\n";
		echo "END:VCALENDAR\n";			
	}

}



