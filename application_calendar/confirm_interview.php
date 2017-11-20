<?php
include_once '../conf/zend_smarty_conf.php';
$type = addslashes($_GET["type"]);
$id = addslashes($_GET["id"]);
$mail = new Zend_Mail();
$smarty = new Smarty();
if ($type=="client"){
	$lead_id = addslashes($_GET["client_id"]);
	$appointmentSql = $db->select()
						->from("tb_app_appointment", array("client_confirmed", "request_for_interview_id", "user_id"))
						->where("tb_app_appointment.client_id = ?", $lead_id)->where("tb_app_appointment.id = ?", $id);
	$request = $db->fetchRow($appointmentSql);
	if ($request){
		$data["client_confirmed"] = "Y";
		$db->update("tb_app_appointment", $data, "id = {$id}");
		
		
		//query the lead info
		$client = $db->fetchRow($db->select()->from("leads", array("lname", "fname"))->where("id = ?", $lead_id));
		$applicant = $db->fetchRow(
								$db->select()->from("tb_app_appointment", array())
								->joinInner("personal", 
											"personal.userid = tb_app_appointment.leads_id",
											 array("fname", "lname"))
								->where("tb_app_appointment.id = ?", $id));
		
		$appointment = $db->fetchRow($db->select()->from("tb_app_appointment", array("start_month", "start_day", "start_year", "start_hour", "start_minute", "time_zone"))->where("id = ?", $id));						

		$facilitator = $db->fetchRow($db->select()->from("admin", array("admin.admin_lname", "admin.admin_fname", "admin.admin_email"))
												->where("admin.admin_id = ?",$request["user_id"])
												);
		
		$time = $appointment["start_year"]."-".$appointment["start_month"]."-".$appointment["start_day"]." ".$appointment["start_hour"].":".$appointment["start_minute"];										
		$date = new DateTime($time,new DateTimeZone($appointment["time_zone"]));
		$date->setTimezone(new DateTimeZone("Asia/Manila"));
		$format = $date->format("F d, Y h:i A");																						
		$smarty->assign("schedule", $format." Manila Time");	
		$smarty->assign("name", $facilitator["admin_fname"]." ".$facilitator["admin_lname"]);
		$smarty->assign("recipient", $client["fname"]." ".$client["lname"]);
		$smarty->assign("client", $client["fname"]." ".$client["lname"]);
		$smarty->assign("applicant", $applicant["fname"]." ".$applicant["lname"]);

		$interview = $smarty->fetch("confirm_interview.tpl");
		$mail->setFrom("noreply@remotestaff.com.au");
		$mail->setBodyHtml($interview);
		$subject = "Confirmation for Interview between {$client["fname"]} {$client["lname"]} AND {$applicant["fname"]} {$applicant["lname"]}";
		if (TEST){
			$mail->setSubject("TEST $subject");
			$mail->addTo("devs@remotestaff.com.au", "devs@remotestaff.com.au");
		}else{
			$mail->setSubject($subject);		
			$mail->addTo($facilitator["admin_email"],$facilitator["admin_email"]);		
		}	
		$mail->send($transport);
		echo "Thanks for the confirmation. Please be online 5 minutes before the interview time. See you then.";
	}else{	
		echo "Invalid confirmation link";
	}
}else if ($type=="applicant"){
	$applicant_id = $_GET["applicant_id"];
	$request = $db->fetchRow($db->select()->from("tb_app_appointment", array("applicant_confirmed", "client_id", "user_id"))->where("id = ?", $id));
	if ($request){
		$data["applicant_confirmed"] = "Y";
		$db->update("tb_app_appointment", $data, "id = {$id}");
		
		$leads_id = $request["client_id"];
		$client = "";
		if ($leads_id){
			$client = $db->fetchRow($db->select()->from("leads", array("lname", "fname"))->where("id = ?", $leads_id));
		}
		$applicant = $db->fetchRow(
								$db->select()->from("tb_app_appointment", array())
								->joinInner("personal", 
											"personal.userid = tb_app_appointment.leads_id",
											 array("fname", "lname"))
								->where("tb_app_appointment.id = ?", $id));
		
		$appointment = $db->fetchRow($db->select()->from("tb_app_appointment", array("id", "start_month", "start_day", "start_year", "start_hour", "start_minute", "time_zone"))->where("id = ?", $id));						

		$facilitator = $db->fetchRow($db->select()->from("admin", array("admin.admin_lname", "admin.admin_fname", "admin.admin_email"))
												->where("admin.admin_id = ?",$request["user_id"])
												);
		
												
		$time = $appointment["start_year"]."-".$appointment["start_month"]."-".$appointment["start_day"]." ".$appointment["start_hour"].":".$appointment["start_minute"];										
		$date = new DateTime($time,new DateTimeZone($appointment["time_zone"]));
		$date->setTimezone(new DateTimeZone("Asia/Manila"));
		$format = $date->format("F d, Y h:i A");																						
		$smarty->assign("schedule", $format." Manila Time");
		$smarty->assign("name", $facilitator["admin_fname"]." ".$facilitator["admin_lname"]);
		$smarty->assign("recipient", $applicant["fname"]." ".$applicant["lname"]);
		if ($client){
			$smarty->assign("client", $client["fname"]." ".$client["lname"]);
		}else{
			$smarty->assign("client", "");
		}
		$smarty->assign("applicant", $applicant["fname"]." ".$applicant["lname"]);

		$interview = $smarty->fetch("confirm_interview.tpl");
		$mail->setFrom("noreply@remotestaff.com.au");
		$mail->setBodyHtml($interview);
		if ($client){
			$subject = "Confirmation for Interview between {$client["fname"]} {$client["lname"]} AND {$applicant["fname"]} {$applicant["lname"]}";
		}else{
			$subject = "Confirmation for Initial Interview for {$applicant["fname"]} {$applicant["lname"]}";
		}
		if (TEST){
			$mail->setSubject("TEST $subject");
			$mail->addTo("devs@remotestaff.com.au", "devs@remotestaff.com.au");
		}else{
			$mail->setSubject($subject);		
			$mail->addTo($facilitator["admin_email"],$facilitator["admin_email"]);		
		}	
		$mail->send($transport);
		
		
		echo "Thanks for the confirmation. Please be online 5 minutes before the interview time. See you then.";
	}else{	
		echo "Invalid confirmation link";
	}
}else{
	echo "Invalid confirmation link";
}