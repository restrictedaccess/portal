<?php
include_once '../conf/zend_smarty_conf.php';
if (!isset($couch_resume_db)){
	$couch_resume_db = "resume";
}
$couch_client = new couchClient($couch_dsn, $couch_resume_db);

$responder_type = $_GET["responder_type"];
$time = $_GET["full_time"];
$client_name = $_GET["client_name"];
$timezone = $_GET["timezone"];

if (isset($_GET["userid"])){
	
	$sql = $db->select()
	        ->from('personal', array("userid", "fname", "lname"))
	        ->where('userid = ?', $_GET["userid"]);
	$personal = $db->fetchRow($sql);	
	try {
		$resume = $couch_client->getDoc($_GET["userid"]);
		$found = true;
	}
	catch (Exception $e) {
		if ( $e->getCode() == 404) {
			$found = false;
		}
		else {
			$found = false;
		}
	}
	if ($found){
		if (TEST){
			$applicant_name = "<a href='http://test.remotestaff.com.au/available-staff-resume/{$_GET["userid"]}' target='_blank'>{$_GET["userid"]} - ".$resume->fname."</a>";	
			$applicant_full = $resume->fname." ".$resume->lname;
		}else{
			$applicant_name = "<a href='http://remotestaff.com.au/available-staff-resume/{$_GET["userid"]}' target='_blank'>{$_GET["userid"]} - ".$resume->fname."</a>";
			$applicant_full = $resume->fname." ".$resume->lname;
		}
	}else{
		if (TEST){
			$applicant_name = "<a href='http://test.remotestaff.com.au/available-staff-resume/{$_GET["userid"]}' target='_blank'>{$_GET["userid"]} - ".$personal["fname"]."</a>";	
			$applicant_full = $personal["fname"]." ".$personal["lname"];
		}else{
			$applicant_name = "<a href='http://remotestaff.com.au/available-staff-resume/{$_GET["userid"]}' target='_blank'>{$_GET["userid"]} - ".$personal["fname"]."</a>";
			$applicant_full = $personal["fname"]." ".$personal["lname"];
		}
	}
	
}else{
	$applicant_name = $_GET["applicant_name"];	
}

$now = time();
$hostname = $_SERVER["SERVER_NAME"];
$facilitator = $_GET["facilitator"];
$creator_name = $_GET["creator_name"];
$subcategory = $_GET["subcategory"];

if ($timezone){
	$date = new DateTime($time,new DateTimeZone($timezone));
	$date->setTimezone(new DateTimeZone("Asia/Manila"));
	$format = $date->format("F d, Y h:i A");
}else{
	$date = new DateTime($time,new DateTimeZone("Asia/Manila"));
	$date->setTimezone(new DateTimeZone("Asia/Manila"));
	$format = $date->format("F d, Y h:i A");
}
if ($responder_type=="skype"){
	

	
	//for client message setup
	$output1 = "Hi {$client_name},\n\n";
	$output1 .= "This is {$creator_name} from Remote Staff.\n\n";
	$output1 .= "I am writing to confirm your interview with {$applicant_name} on $time {$timezone} time.\n\n";
	$output1 .=" Please note that the interview will happen online on Skype.\n\n";
	$output1 .=  "{$facilitator} will facilitate the interview.\n\n\n";
	$output1 .= "NOTE:\n\n\n";
	$output1 .= "You will need a working headset to have a voice chat with the candidate\n\n";
	$output1 .= "You will need to download or have <a href='http://www.tkqlhce.com/db111ar-xrzEILMHIJHEGFKMLLLI'>Skype(http://www.tkqlhce.com/db111ar-xrzEILMHIJHEGFKMLLLI)</a> on your computer\n\n";
	$output1 .= "Should you have any questions about the interview please call me\n\n";
	$output1 .= "To confirm that you receive this email, click HERE";
	
	//for applicant message setup
	$output2 = "Dear {$applicant_full},\n\n";
	$output2 .= "Confirming your interview with our client as per our conversation earlier. This is for the {$subcategory} role.\n\n";
	$output2 .= "Log in to your personal Skype 15 minutes before {$format} Manila Time and we will give you further instructions from there.\n\n";
	$output2 .= "TAKE NOTE:\n\n\n";
	$output2 .= "During the interview, pay (salary) and contract details and set up SHOULD NOT be discussed with the client. If you have any questions regarding this please ask me before or after the interview.\n\n";
	$output2 .= "Failure to show up on confirmed interview schedules will be subject for an evaluation before a reschedule may be granted.\n\n";
	$output2 .= "Remotestaff also has the right to consider your application as BLACKLISTED if you fail to attend succeeding interviews, rescheduled or otherwise, that you have confirmed to.\n\n";
	$output2 .= "If something comes up that will prevent you from attending the interview, please send an advise at least an 30 mins to an hour before the interview schedule and NOT AFTER the schedule has elapsed.\n\n";
	$output2 .= "To confirm that you receive this email, click HERE";
	
}else if ($responder_type="rschat"){
	$output1 = "Hi {$client_name}\n\n";
	$output1 .= "I am writing to confirm your interview with {$applicant_name} on {$time} {$timezone}.\n\n";
	$output1 .= "Please note that the interview will happen online on our chat application.\n\n";
	$output1 .= "Please go to http://{$hostname}/portal/livechat.php?login=leadrfi&upid={$now} and log in using your Remote Staff user name and password. \n\n\n";
	$output1 .= "{$facilitator} will facilitate the interview.\n\n\n";
	$output1 .= "NOTE:\n\n";
	$output1 .= "You will need a working headset to have a voice chat with the candidate\n\n";
	$output1 .= "If for any reason you cannot come to this meeting or running late please call me on my contact details below to cancel. Cancelled interview is none refundable.\n\n";
	$output1 .= "Should you have any questions about the interview please call me\n\n";
	$output1 .= "To confirm that you receive this email, click HERE";
	
	$output2 = "Dear {$applicant_full},\n\n";
	$output2 .= "Confirming your interview with our client as per our conversation earlier. This is for the {$sub_category_name} role.\n\n";
	$output2 .= "Please go to {$hostname}/portal/livechat.php?login=jobseeker&upid={$now} and log in using your jobseeker user name and password.\n";
	$output2 .= "If you have forgotten your password please reset it <a href='http://{$hostname}/portal/forgotpass.php?user=applicant'>HERE</a>\n\n\n";
	$output2 .= "TAKE NOTE:\n\n";
	$output2 .= "During the interview, pay (salary) and contract details and set up SHOULD NOT be discussed with the client. If you have any questions regarding this please ask me before or after the interview.\n\n";
	$output2 .= "Failure to show up on confirmed interview schedules will be subject for an evaluation before a reschedule may be granted.\n\n";
	$output2 .= "Remotestaff also has the right to consider your application as BLACKLISTED if you fail to attend succeeding interviews, rescheduled or otherwise, that you have confirmed to.\n\n";
	$output2 .= "If something comes up that will prevent you from attending the interview, please send an advise at least an 30 mins to an hour before the interview schedule and NOT AFTER the schedule has elapsed.\n\n";
	$output2 .= "To confirm that you receive this email, click HERE";
	
}
echo json_encode(array("output1"=>$output1, "output2"=>$output2));
