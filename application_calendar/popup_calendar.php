<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/ShowLeadsOrder.php';
include '../lib/addLeadsInfoHistoryChanges.php';

include '../config.php';
include '../conf.php';
include '/main.function.php';
//SESSION CHECKER
if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
		window.close();
	</script>
	';
	exit;
}
//ENDED


$settings = $db->fetchOne($db->select()->from("admin", array("view_admin_calendar"))->where("admin_id = ?", $_SESSION["admin_id"]));


if (isset($_GET["view_type"])){
	if ($_GET["view_type"]=="other_admin"){
		if ($_GET["selected_admin"]==""){
			$_GET["selected_admin"] = $_SESSION["admin_id"];
		}
		if ($settings=="Y"){
			$_SESSION["view_type"] = $_GET["view_type"];
			$_SESSION["selected_admin"] = $_GET["selected_admin"];
		}	
	}else{
		if ($_GET["selected_admin"]==""){
			$_GET["selected_admin"] = $_SESSION["admin_id"];
		}
		$_SESSION["selected_admin"] = $_GET["selected_admin"];
		unset($_SESSION["view_type"]);
		unset($_SESSION["selected_admin"]);
	}
}else{
	$_GET["view_type"] = $_SESSION["view_type"];
	$_GET["selected_admin"] = $_SESSION["selected_admin"];	
}


if(@isset($_GET["time_zone_update"]))
{
	mysql_query("UPDATE admin SET timezone_id='".$_GET["time_zone_update"]."' WHERE admin_id='".$_SESSION['admin_id']."'");
}

if(@isset($_GET["id"]))
{
	$l_id = @$_GET["id"];
	$_SESSION['l_id'] = $l_id;
}
elseif(@isset($_GET["userid"]))
{
	$l_id = @$_GET["userid"];
	$_SESSION['l_id'] = $l_id;
}
if(!isset($l_id))
{
	$l_id = $_SESSION['l_id'];
}


if(@isset($_GET["leads_id"]))
{
	$client_id = @$_GET["leads_id"];
	$_SESSION['c_id'] = $client_id;
}
if(!isset($client_id))
{
	$client_id = $_SESSION['c_id'];
}


if(@isset($_GET["interview_id"]))
{
	$interview_id = @$_GET["interview_id"];
	$_SESSION['interview_id'] = $interview_id;
}
if(!isset($interview_id))
{
	$interview_id = $_SESSION['interview_id'];
}
if($_GET["interview_id"] == 'ANY')
{
	$interview_id = 0;
	$_SESSION['interview_id'] = $interview_id;
}

if($_GET["is_rescheduled"] == "yes")
{
	$_SESSION["is_rescheduled"] = "yes";
}
elseif($_GET["is_rescheduled"] == "no")
{
	$_SESSION["is_rescheduled"] = "no";
}

//get default selected applicant
$get_per = mysql_query("SELECT userid, lname, fname, email FROM personal WHERE userid='$l_id' LIMIT 1");
while ($row_p = @mysql_fetch_assoc($get_per))
{
	$applicant_full_name = $row_p['fname']; //." ".$row_p['lname'];
	$applicant_email = $row_p['email'];
}
//ended


//get default selected client
$get_per = mysql_query("SELECT lname, fname, email FROM leads WHERE id='$client_id' LIMIT 1");
while ($row_p = @mysql_fetch_assoc($get_per))
{
	$client_full_name = $row_p['fname']." ".$row_p['lname'];
	$client_email = $row_p['email'];
}
//ended


//set admin timezone
$r = mysql_query("SELECT timezone_id FROM admin WHERE admin_id='".$_SESSION['admin_id']."' LIMIT 1");
$admin_timezone_id = mysql_result($r,0,"timezone_id");

$r = mysql_query("SELECT timezone FROM timezone_lookup WHERE id='$admin_timezone_id' LIMIT 1");
$admin_timezone = mysql_result($r,0,"timezone");

if($admin_timezone == "" || $admin_timezone == NULL)
{
	$admin_timezone = "Asia/Manila";
	$admin_timezone_display = "Asia/Manila";
}
switch($admin_timezone)
{
	case "PST8PDT":
		$admin_timezone_display = "America/San Francisco";
		break;
	case "NZ":
		$admin_timezone_display = "New Zealand/Wellington";
		break;
	case "NZ-CHAT":
		$admin_timezone_display = "New Zealand/Chatham_Islands";
		break;
	default:
		$admin_timezone_display = $admin_timezone;
		break;
}

date_default_timezone_set($admin_timezone); //apply timezone

//ended


//get timezone and job possition from tb_request_for_interview
$r = mysql_query("SELECT time_zone, job_sub_category_applicants_id FROM tb_request_for_interview WHERE id='$interview_id' LIMIT 1");
$default_timezone = mysql_result($r,0,"time_zone");
$job_sub_category_applicants_id = mysql_result($r,0,"job_sub_category_applicants_id");

$r = mysql_query("SELECT sub_category_id FROM job_sub_category_applicants WHERE id='$job_sub_category_applicants_id' LIMIT 1");
$sub_category_id = mysql_result($r,0,"sub_category_id");

$r = mysql_query("SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$sub_category_id' LIMIT 1");
$sub_category_name = mysql_result($r,0,"sub_category_name");

$default_timezone_display = $default_timezone;
//ended


//get admin details
if(isset($_SESSION['admin_id']))
{
	$user_id = $_SESSION['admin_id'];
	$orig_uid = $_SESSION['admin_id'];
	$_SESSION['admin_id'] = $user_id;
	$query=mysql_query("SELECT admin_fname, admin_lname, admin_email FROM admin WHERE admin_id='$orig_uid'");
	while ($row = mysql_fetch_assoc($query))
	{
		$from_name = $row['admin_fname'].' '.$row['admin_lname'];
		$from_email = $row['admin_email'];
	}
}
//ended


$page_sel = "popup";
if(@$_GET["back_link"] == 4)

{
	if(!isset($_SESSION['l_id']))
	{
		$_SESSION['back_link'] = "../application_apply_action.php?userid=".$l_id;
	}
	else
	{
		$_SESSION['back_link'] = "../application_apply_action.php?userid=".$_SESSION['l_id'];
	}
}


if(!isset($_SESSION['admin_id']))
{
	?>
<script language="javascript">
	alert("Your session is expired.");
	window.location = "../index.php";

	</script>
	<?php
	}

	//require_once("../conf/connect.php");
	include("style/button_style.php");
	include("style/text_style.php");

	//session_start();

	function get_string_day($day)
	{
	switch($day)
	{
	case "01":
	$r = "Jan";
	break;
	case "02":
	$r = "Feb";
	break;
	case "03":
	$r = "Mar";
	break;
	case "04":
	$r = "Apr";
	break;
	case "05":
	$r = "May";
	break;
	case "06":
	$r = "Jun";
	break;
	case "07":
	$r = "Jul";
	break;
	case "08":
	$r = "Aug";
	break;
	case "09":
	$r = "Sep";
	break;
	case "10":
	$r = "Oct";
	break;
	case "11":
	$r = "Nov";
	break;
	case "12":
	$r = "Dec";
	break;
	default:
	$r = "Month";
	break;
	}
	return $r;
	}

	$yearID = $_GET["yearID"];
	$monthID = $_GET["monthID"];
	$dayID = $_GET["dayID"];
	$calendar_type = @$_GET["calendar_type"];

	if(@isset($yearID)) $_SESSION['yearID'] = $yearID;
	if(@isset($monthID)) $_SESSION['monthID'] = $monthID;
	if(@isset($dayID)) $_SESSION['dayID'] = $dayID;
	$date_selected = $yearID."-".$monthID."-".$dayID;
	if(@isset($calendar_type)) $_SESSION['calendar_type'] = $calendar_type;

	if(@$_GET["action"] == "logout")
	{
	session_unset();
	session_destroy();
	header("location:index.php");
	}

	if(!isset($dayID) && !isset($monthID) && isset($yearID))
	{
	$monthID = date("m",time());
	$dayID = date("d",time());

	$type = $_GET["view_type"];

	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_GET["view_type"].'&selected_admin='.$_GET["selected_admin"].'";
	</script>
	';
	}

	if (isset($_GET["dayID"])&&isset($_GET["monthID"])&&isset($_GET["yearID"])){
		if (!checkdate($_GET["monthID"], $_GET["dayID"], $_GET["yearID"])){
			$dayID = 1;
			echo '
			<script language="javascript">
			window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_GET["view_type"].'&selected_admin='.$_GET["selected_admin"].'";
			</script>
			';
		}
	}

	if(!isset($dayID) && isset($yearID))
	{
	$dayID = date("d",time());
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_GET["view_type"].'&selected_admin='.$_GET["selected_admin"].'";
	</script>
	';
	}

	if(!isset($monthID) && isset($yearID))
	{
	$monthID = date("m",time());
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_GET["view_type"].'&selected_admin='.$_GET["selected_admin"].'";
	</script>
	';
	}

	if(!isset($dayID) && !isset($yearID))
	{
	$yearID = date("Y",time());
	$monthID = date("m",time());
	$dayID = date("d",time());
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_GET["view_type"].'&selected_admin='.$_GET["selected_admin"].'";
	</script>
	';
	}

	// FOR RSCHAT - 2010/12/09 /mike
	$hostname = $_SERVER['HTTP_HOST'];

	//NEW APPOINTMENT
	if(@isset($_POST["new"]))
	{
	$applicant_id = $_POST["leads"];
	$assign_to = $_POST["assign_to"];
	$start_month = $_POST["start_month"]; if($start_month == "") $start_month = 0;
	$start_day = $_POST["start_day"]; if($start_day == "") $start_day = 0;
	$start_year = $_POST["start_year"]; if($start_year == "") $start_year = 0;
	$end_month = $_POST["end_month"]; if($end_month == "") $end_month = 0;
	$end_day = $_POST["end_day"]; if($end_day == "") $end_day = 0;
	$end_year = $_POST["end_year"];	if($end_year == "") $end_year = 0;
	$date_start = $start_year."-".$start_month."-".$start_day;
	$date_end = $end_year."-".$end_month."-".$end_day;
	$status = "active";
	$date_added = date("Ymd");
	$subject = $_POST["subject"];
	$location = $_POST["location"];
	$type_option = @$_POST["type_option"];
	$leads_option = @$_POST["leads_option"];
	$all_day = @$_POST["all_day"];
	$any = @$_POST["any"];

	$description = $_POST["description"];
	$description2 = $_POST["description2"];

	$start_minute = $_POST["start_minute"];  if($start_minute == "") $start_minute = 0;
	$start_hour = $_POST["start_hour"];  if($start_hour == "") $start_hour = 0;
	$end_hour = $_POST["end_hour"];  if($end_hour == "") $end_hour = 0;
	$end_minute = $_POST["end_minute"];	 if($end_minute == "") $end_minute = 0;

	$time_zone = $_POST["time_zone"];

	if(@isset($type_option)) $type = $_POST["type"];

	else $type = "";

	$applicant_full_name = "";
	$applicant_email = "";
	$client_full_name = "";
	$client_email = "";

	$leads_id = $_POST["leads"];
	$get_per = mysql_query("SELECT userid, lname, fname, email FROM personal WHERE userid='$leads_id' LIMIT 1");
	while ($row_p = @mysql_fetch_assoc($get_per))
	{
	$applicant_full_name = $row_p['fname']; //." ".$row_p['lname'];
	$applicant_email = $row_p['email'];
	}

	$client_id = $_POST["client"];
	$get_per = mysql_query("SELECT lname, fname, email FROM leads WHERE id='$client_id' LIMIT 1");
	while ($row_p = @mysql_fetch_assoc($get_per))
	{
	$client_full_name = $row_p['fname']." ".$row_p['lname'];
	$client_email = $row_p['email'];
	}

	if(@isset($any))
	{
	$any = "yes";
	}
	else
	{
	$any = "no";
	}

	if(@isset($all_day))
	{
	$all_day = "yes";
	}
	else
	{
	$all_day = "no";
	}

	$counter = 0;
	$error_message = "";
	//$c = mysql_query("SELECT id FROM tb_app_appointment WHERE user_id='$assign_to' AND date_start='$date_start' AND start_hour = '$start_hour' AND start_minute >= '$start_minute' AND is_allday = 'no' LIMIT 1");
	//$num_result = mysql_num_rows($c);
	//if($num_result > 0) $counter = 1;
	//if($start_month == $monthID && $start_day == $dayID && $start_year == $yearID)
	//{
	//$c = mysql_query("SELECT id FROM tb_app_appointment WHERE user_id='$assign_to' AND date_start='$date_start' AND start_hour = '$start_hour' AND end_hour >= '$start_hour' AND end_minute >= '$start_minute' AND is_allday = 'no' AND is_any = 'no' LIMIT 1");
	//if($num_result > 0) $counter = 1;
	//}

	if($counter == "" || $counter == 0)
	{

	$description = nl2br($description);
	$description2 = nl2br($description2);

	$desc = "<strong>CLIENT: <br /><br /></strong>".$description."<br /><br /><br /><strong>CANDIDATE:<br /><br /></strong>".$description2;
	$error_message = "";
	if (!isset($interview_id)){
	$interview_id = 0;
	}
	if (!timezone){
	$time_zone = "Asia/Manila";
	}

	//START: insert new appointment
	$data = array(
	'user_id' => $assign_to,
	'leads_id' => $leads_id,
	'client_id' => $client_id,
	'date_start' => $date_start,
	'date_end' => $date_end,
	'start_month' => $start_month,
	'end_month' => $end_month,
	'start_day' => $start_day,
	'end_day' => $end_day,
	'start_year' => $start_year,
	'end_year' => $end_year,
	'start_hour' => $start_hour,
	'start_minute' => $start_minute,
	'end_hour' => $end_hour,
	'end_minute' => $end_minute,
	'subject' => $subject,
	'location' => $location,
	'appointment_type' => $type,
	'is_allday' => $all_day,
	'is_any' => $any,
	'status' => $status,
	'date_added' => $date_added,
	'request_for_interview_id' => $interview_id,
	'time_zone' => $time_zone
	);
	$db->insert('tb_app_appointment', $data);
	$appointment_id = $db->lastInsertId("tb_app_appointment");

	if (TEST){
	$base = "http://test.remotestaff.com.au";
	}else{
	$base = "http://remotestaff.com.au";
	}
	$description = str_replace("To confirm that you receive this email, click HERE", "To confirm that you receive this email, click <a href='$base/portal/application_calendar/confirm_interview.php?id={$appointment_id}&type=client&client_id={$client_id}' class='confirm-link'>HERE</a>", $description);
	$description2 = str_replace("To confirm that you receive this email, click HERE", "To confirm that you receive this email, click <a href='$base/portal/application_calendar/confirm_interview.php?id={$appointment_id}&type=applicant&applicant_id={$leads_id}' class='confirm-link'>HERE</a>", $description2);

	if (isset($_POST["initial"])){
	$initial_interview = "Y";
	}else{
	$initial_interview = "N";
	}

	if (isset($_POST["contract_signing"])){
	$contract_signing = "Y";
	}else{
	$contract_signing = "N";
	}

	if (isset($_POST["new_hire_orientation"])){
	$new_hire_orientation = "Y";
	}else{
	$new_hire_orientation = "N";
	}

	if (isset($_POST["meeting"])){
	$meeting = "Y";
	}else{
	$meeting = "N";
	}

	$db->update("tb_app_appointment", array("description"=>$description, "initial_interview"=>$initial_interview, "meeting"=>$meeting, "new_hire_orientation"=>$new_hire_orientation, "contract_signing"=>$contract_signing, "description_applicant"=>$description2), "id = {$appointment_id}");
	//ENDED: insert new appointment

	//START: update request for interview booking to confirmed
	$data = array('status' => 'CONFIRMED');
	$where = "id = ".$interview_id;
	$db->update('tb_app_appointment' , $data , $where);
	//START: update request for interview booking to confirmed

	$c = mysql_query("SELECT id FROM tb_app_appointment WHERE user_id='$user_id' AND leads_id='$leads_id' AND date_start='$date_start' AND start_hour='$start_hour' AND start_minute='$start_minute' AND date_added='$date_added' LIMIT 1");
	$appointment_id = @mysql_result($c,0,"id");
	$angent_id = $_SESSION['admin_id'];
	$type = "New Schedule Added";
	$status = "Active";
	$date_added = date("Ymd");
	mysql_query("INSERT INTO tb_app_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");
	if($_SESSION["is_rescheduled"] == "yes")
	{
	mysql_query("UPDATE tb_request_for_interview SET status='RE-SCHEDULED' WHERE id='$interview_id'");
	$orders_str = CheckLeadsOrderInASL($leads_id);
	if($orders_str > 0){
	$data = array('asl_orders' => 'yes');
	}else{
	$data = array('asl_orders' => 'no');
	}
	if ($leads_id){
	addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	$db->update('leads', $data, 'id='.$leads_id);
	}
	}

	//EMAIL SCHEDULE NOTICE
	$fullname =$row['fname']." ".$row['lname'];
	$subcontructor_email =$row['email'];

	$start_hour_type = "AM";
	$end_hour_type = "AM";
	$s_hour = $start_hour;
	$e_hour = $end_hour;
	if($start_hour >= 12 && $start_hour  <= 23)
	{
	$start_hour_type = "PM";
	switch($start_hour)
	{
	case 13:
	$s_hour = 1;
	break;
	case 14:
	$s_hour = 2;
	break;
	case 15:
	$s_hour = 3;
	break;
	case 16:
	$s_hour = 4;
	break;
	case 17:
	$s_hour = 5;
	break;
	case 18:
	$s_hour = 6;
	break;
	case 19:
	$s_hour = 7;
	break;
	case 20:
	$s_hour = 8;
	break;
	case 21:
	$s_hour = 9;
	break;
	case 22:
	$s_hour = 10;
	break;
	case 23:
	$s_hour = 11;
	break;
	case 24:
	$s_hour = 12;
	break;
	}
	}
	if($end_hour >= 12 && $end_hour  <= 23)
	{
	$end_hour_type = "PM";
	switch($end_hour)
	{
	case 13:
	$e_hour = 1;
	break;
	case 14:
	$e_hour = 2;
	break;
	case 15:
	$e_hour = 3;
	break;
	case 16:
	$e_hour = 4;
	break;
	case 17:
	$e_hour = 5;
	break;
	case 18:
	$e_hour = 6;
	break;
	case 19:
	$e_hour = 7;
	break;
	case 20:
	$e_hour = 8;
	break;
	case 21:
	$e_hour = 9;
	break;
	case 22:
	$e_hour = 10;
	break;
	case 23:
	$e_hour = 11;
	break;
	case 24:
	$e_hour = 12;
	break;
	}
	}

	/* FOR CHAT INTERVIEW SUPPORT  - 2010-09-13 /mike */

	//$rfi_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $user_email ), 2, 17 );
	//$rfi_time = strtotime($date_start); -- commented 061010

	/* commented entries - 061010 - since applicant/lead will have to login */
	// APPLICANT ENTRY
	/*$sql = "INSERT INTO user_common_request (email, resetpassword_code, resetpassword_time, ref_table, ip_address) "
	. "VALUES ('$applicant_email', '$rfi_code', '$rfi_time', '" . $appointment_id ."', 'jobseeker')";

	mysql_query($sql);*/

	// LEADS ENTRY
	/*$sql = "INSERT INTO user_common_request (email, resetpassword_code, resetpassword_time, ref_table, ip_address) "
	. "VALUES ('$client_email', '$rfi_code', '$rfi_time', '$appointment_id', 'leadrfi')";

	mysql_query($sql);*/

	/* end of chat interview support */

	//AUTORESPONDER SETUP
	if(@$_POST["autoresponder"] == "Yes")
	{

	//SEGNATURE
	$admin_id = $_SESSION['admin_id'];
	$admin_status=$_SESSION['status'];
	$site = $_SERVER['HTTP_HOST'];

	$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
	$result=mysql_query($sql);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
	$row = mysql_fetch_array ($result);
	$admin_email = $row['admin_email'];
	$name = $row['admin_fname']." ".$result['admin_lname'];
	$admin_email=$row['admin_email'];
	$signature_company = $row['signature_company'];
	$signature_notes = $row['signature_notes'];
	$signature_contact_nos = $row['signature_contact_nos'];
	$signature_websites = $row['signature_websites'];
	}

	if($signature_notes!=""){
	$signature_notes = "<p><i>$signature_notes</i></p>";
	}else{
	$signature_notes = "";
	}
	if($signature_company!=""){
	$signature_company="<br>$signature_company";
	}else{
	$signature_company="<br>RemoteStaff";
	}
	if($signature_contact_nos!=""){
	$signature_contact_nos = "<br>$signature_contact_nos";
	}else{
	$signature_contact_nos = "";
	}
	if($signature_websites!=""){
	$signature_websites = "<br>Websites : $signature_websites";
	}else{
	$signature_websites = "";
	}

	$signature_template = $signature_notes;
	$signature_template .="<a href='http://$site/$agent_code'>
	<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
	$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p><br /><br />";
	//END SEGNATURE

	//date formating
	if($date_start == "--" || $date_start == "" || $date_start == "0000-00-00" || $date_start == "0000-0-0")
	{
	//do nothing
	}
	else
	{
	$date_start = date("l, jS F Y", strtotime($date_start));
	}
	if($date_end == "--" || $date_end == "" || $date_end == "0000-00-00" || $date_end == "0000-0-0")
	{
	//do nothing
	}
	else
	{
	$date_end = date("l, jS F Y", strtotime($date_end));
	}
	//ended - date formating

	if($start_minute == "0") $start_minute = "00";
	if($date_end == "-" || $date_end == "--" || $date_end == "") $date_end = "0000-00-00";
	if($e_hour == "0" || $e_hour == "") $e_hour = "00";
	if($end_minute < 10) $end_minute = "0".$end_minute;

	if (trim($subject)==""){
	$subject ="Meeting: ".$date_start." ".$s_hour.":".$start_minute.$start_hour_type;
	}
		$facilitator_email = $db->fetchOne($db->select()->from("admin", array("admin_email"))->where("admin_id = ?", $assign_to));
	
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: ".$admin_email." \r\n"."Reply-To: ".$facilitator_email."\r\n";
	
		$h = "
		<style type=\"text/css\">
		.cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
		.cName label{ font-style:italic; font-size:8pt}
		.cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
		.jobRESH {color:#000000; size:2; font-weight:bold}
		</style>
		<style>
		<!--
		div.scroll {
		height: 300px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		}
		.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
		margin-left:0px;
		}
		.scroll label
		{
		width:90px;
		float: left;
		text-align:right;
		}
		.spanner
		{
		width: 400px;
		overflow: auto;
		padding:5px 0 5px 10px;
		margin-left:20px;
		}
		#l {
		float: left;
		width: 350px;
		text-align:left;
		padding:5px 0 5px 10px;
		}
		#l ul{
		margin-bottom: 10px;
		margin-top: 10px;
		margin-left:20px;
		}
		#r{
		float: right;
		width: 120px;
		text-align: left;
		padding:5px 0 5px 10px;
		}
		.ads{
		width:580px;
		}
		.ads h2{
		color:#990000;
		font-size: 2.5em;
		}
		.ads p{
		margin-bottom: 5px;
		margin-top: 5px;
		margin-left:30px;
		}
		.ads h3
		{
		color:#003366;
		font-size: 1.5em;
		margin-left:30px;
		}
		#comment{
		float: right;
		width: 500px;
		padding:5px 0 5px 10px;
		margin-right:20px;
		margin-top:0px;
		}
		#comment p
		{
		margin-bottom: 4px;
		margin-top: 4px;
		}
		#comment label
		{
		display: block;
		width:100px;
		float: left;
		padding-right: 10px;
		font-size:11px;
		text-align:right;
		}
		-->
		</style>
		";
	
		//APPLICANT AUTORESPONDER
		$body=$h."
		<p>".$description2."<br>".$signature_template."</p>";
		if (TEST)
		{
		$applicant_email = "devs@remotestaff.com.au";
		}
		
		
		
		include "../time.php";
		$AusTime = date("h:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		$date = $ATZ;
		$mail = new Zend_Mail();
		
		if (isset($_FILES["file_candidate"])){
			foreach($_FILES["file_candidate"]["name"] as $key=>$value){
				$tmp_name = $_FILES["file_candidate"]["tmp_name"][$key];
				$type = $_FILES["file_candidate"]['type'][$key];
				$filename = $_FILES["file_candidate"]['name'][$key];
				$size = $_FILES["file_candidate"]['size'][$key];
				if (file_exists($tmp_name)){
					// check to make sure that it is an uploaded file and not a system file
					if(is_uploaded_file($tmp_name)){
						// open the file for a binary read
						$file = fopen($tmp_name,'rb');
						// read the file content into a variable
						$data = fread($file,filesize($tmp_name));
						// close the file
						fclose($file);
						
						$at = new Zend_Mime_Part($data);
						$at->type        = $type;
						$at->disposition = Zend_Mime::DISPOSITION_INLINE;
						$at->encoding    = Zend_Mime::ENCODING_BASE64;
						$at->filename    = $filename;
						
						$mail->addAttachment($at);
					}
				}
							
			}
		}
		$mail->setBodyHtml($body);
		$mail->setSubject($subject);
		$mail->addTo($applicant_email, $applicant_email);
		$mail->addHeader("Reply-To", $facilitator_email);
		$mail->setFrom($admin_email, $admin_email);
		$mail->send($transport);
		
		if ($initial_interview=="Y"){
			$changes = "emailed candidate for <span style='color:#ff0000'>initial interview</span>";
		}else if ($meeting =="Y"){
			$changes = "emailed candidate for <span style='color:#ff0000'>meeting</span>";
		}else if ($new_hire_orientation =="Y"){
			$changes = "emailed candidate for <span style='color:#ff0000'>new hire orientation</span>";
		}else if ($contract_signing=="Y"){
			$changes = "emailed candidate for <span style='color:#ff0000'>contract signing</span>";
		}else{
			$changes = "emailed candidate for interview for <span style='color:#ff0000'>$client_full_name</span>";
		}
		if ($_SESSION["status"]=="FULL-CONTROL"){
			$status = "ADMIN";
		}else{
			$status = "HR";
		}
		$date = new DateTime($time,new DateTimeZone("America/New_York"));
		$date->setTimezone(new DateTimeZone("Asia/Manila"));
		$ATZ = $date->format("Y-m-d h:i:s");
		try{
			$data = array(
				"userid" =>$applicant_id,
				"change_by_id"=>$_SESSION["admin_id"],
				"change_by_type"=>$status,
				"changes"=>$changes,
				"date_change"=>$ATZ
				
			);
			$db->insert("staff_history", $data);	
		}catch(Exception $e){
			print_r($e->getMessage());	
			die;
		}
		//mail($applicant_email, $subject, $body, $header);
		//$from_address = $admin_email;
		//$from_name = "RemoteStaff.com.au";
		//sendZendMail($applicant_email,$subject,$body,$from_address,$from_name);
		//ENDED APPLICANT AUTORESPONDER
	
		//CLIENT AUTORESPONDER
		$body=$h."<p>".$description."<br>".$signature_template."</p>";
		if ($client_email!=""){
		if (TEST)
		{
			$client_email = "devs@remotestaff.com.au";
		}
		
		if ($initial_interview=="N"&&$meeting=="N"&&$new_hire_orientation=="N"&&$contract_signing=="N"){
			$mail = new Zend_Mail();
		
			if (isset($_FILES["file_client"])){
				foreach($_FILES["file_client"]["name"] as $key=>$value){
					$tmp_name = $_FILES["file_client"]["tmp_name"][$key];
					$type = $_FILES["file_client"]['type'][$key];
					$filename = $_FILES["file_client"]['name'][$key];
					$size = $_FILES["file_client"]['size'][$key];
					if (file_exists($tmp_name)){
						// check to make sure that it is an uploaded file and not a system file
						if(is_uploaded_file($tmp_name)){
							// open the file for a binary read
							$file = fopen($tmp_name,'rb');
							// read the file content into a variable
							$data = fread($file,filesize($tmp_name));
							// close the file
							fclose($file);
							
							$at = new Zend_Mime_Part($data);
							$at->type        = $type;
							$at->disposition = Zend_Mime::DISPOSITION_INLINE;
							$at->encoding    = Zend_Mime::ENCODING_BASE64;
							$at->filename    = $filename;
							
							$mail->addAttachment($at);
						}
					}
								
				}
			}
			$mail->setBodyHtml($body);
			$mail->setSubject($subject);
			if ($_REQUEST["cc_client"]!=""){
				$ccs = explode(",", $_REQUEST["cc_client"]);
				if (!empty($ccs)){
					if (!TEST){
						foreach($ccs as $cc){
							$mail->addCc(trim($cc));				
						}		
					}else{
						$mail->addCc("devs@remotestaff.com.au");
					}			
				
				}
			}
			
			
			$mail->addTo($client_email, $client_email);
			$mail->addHeader("Reply-To", $facilitator_email);
			$mail->setFrom($admin_email, $admin_email);
			$mail->send($transport);	
	//		mail($client_email, $subject, $body, $header);
			
					//log to history
			$data = array(
				'agent_no' => $_SESSION["admin_id"],
				'created_by_type' => "admin",
				'leads_id' =>  $client_id,
				'actions' => "EMAIL",
				'history' => $description,
				'date_created' => $ATZ
				
			);
			$db->insert('history', $data);
			$history_id = $db->lastInsertId("history");
			
			$data = array(
		         'leads_id' => $leads_id, 
			     'date_change' => $ATZ,
			     'changes' => sprintf('Communication Record Type : [ %s ] History id #%s', "EMAIL", $history_id), 
			     'change_by_id' => $_SESSION["admin_id"], 
			     'change_by_type' => "admin"
		    );
		    $db->insert('leads_info_history', $data);
		}
		
		
		

	}

	//$from_address = $admin_email;
	//$from_name = "RemoteStaff.com.au";
	//sendZendMail($client_email,$subject,$body,$from_address,$from_name);
	//ENDED CLIENT AUTORESPONDER

	}
	//END SENDING EMAIL SCHEDULE NOTICE
	}
	else
	{
	$error_message = 'exist';
	}

	$yearID = @$_GET["yearID"];
	$monthID = @$_GET["monthID"];
	$dayID = @$_GET["dayID"];

	if (isset($_POST["selected_admin"])){
	if($error_message == "")
	{

	echo '
	<script language="javascript">
	alert("Message Sent.");
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_POST["view_type"].'&selected_admin='.$_POST["selected_admin"].'";
	</script>
	';
	}
	else
	{
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'&view_type='.$_POST["view_type"].'&selected_admin='.$_POST["selected_admin"].'";
	</script>
	';
	}
	}else{
	if($error_message == "")
	{

	echo '
	<script language="javascript">
	alert("Message Sent.");
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";
	</script>
	';
	}
	else
	{
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";
	</script>
	';
	}
	}

	}
	//NEW APPOINTMENT

	//CANCEL APPOINTMENT
	if(@isset($_GET["delete_confirmed"]))
	{
	$id = $_GET["appointment_cancel"];
	mysql_query("DELETE FROM tb_app_appointment WHERE id='$id'");
	mysql_query("UPDATE tb_request_for_interview SET status='CANCELLED' WHERE id='$interview_id'");

	$orders_str = CheckLeadsOrderInASL($leads_id);
	if($orders_str > 0){
	$data = array('asl_orders' => 'yes');
	}else{
	$data = array('asl_orders' => 'no');
	}
	if  ($leads_id){
	addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	$db->update('leads', $data, 'id='.$leads_id);
	}
	$date_added = date("Ymd");
	$appointment_id = $id;
	$angent_id = $_SESSION['admin_id'];
	$type = "This schedule has been cancelled";
	$status = "Active";
	mysql_query("INSERT INTO tb_app_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";
	</script>
	';
	}
	//CANCEL APPOINTMENT

	//FINISH APPOINTMENT
	if(@isset($_GET["finish_confirmed"]))
	{
	$id = $_GET["appointment_finish"];
	mysql_query("UPDATE tb_app_appointment SET status='not active' WHERE id='$id'");
	mysql_query("UPDATE tb_request_for_interview SET status='DONE' WHERE id='$interview_id'");

	$orders_str = CheckLeadsOrderInASL($leads_id);
	if($orders_str > 0){
	$data = array('asl_orders' => 'yes');
	}else{
	$data = array('asl_orders' => 'no');
	}
	if ($leads_id){
	addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
	$db->update('leads', $data, 'id='.$leads_id);
	}
	$date_added = date("Ymd");
	$appointment_id = $id;
	$angent_id = $_SESSION['admin_id'];
	$type = "This meeting schedule has been moved to finished";
	$status = "Active";
	mysql_query("INSERT INTO tb_app_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");
	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";
	</script>
	';
	}
	//ENDED - FINISH APPOINTMENT

	//UPDATE APPOINTMENT
	if(@isset($_POST["a"]))
	{
	$start_month = @$_POST["start_month"];
	$start_day = @$_POST["start_day"];
	$start_year = @$_POST["start_year"];
	$end_month = @$_POST["end_month"];
	$end_day = @$_POST["end_day"];
	$end_year = @$_POST["end_year"];
	$date_start = $start_year."-".$start_month."-".$start_day;
	$date_end = $end_year."-".$end_month."-".$end_day;
	$status = "active";
	$date_added = date("Ymd");
	$subject = @$_POST["subject"];
	$location = @$_POST["location"];
	$type_option = @$_POST["type_option"];
	$leads_option = @$_POST["leads_option"];
	$all_day = @$_POST["all_day"];
	$any = @$_POST["any"];
	$selected_record = @$_POST["selected_record"];
	$start_minute = @$_POST["start_minute"];
	$start_hour = @$_POST["start_hour"];
	$end_hour = @$_POST["end_hour"];
	$end_minute = @$_POST["end_minute"];

	if(@isset($any))
	{
	$any = "yes";
	}
	else
	{
	$any = "no";
	}

	if(@isset($type_option)) $type = @$_POST["type"];
	else $type = "";

	if(@isset($leads_option))
	$leads_id = $_POST["leads"];
	else $leads_id = "";

	if(@isset($all_day))
	{
	$all_day = "yes";
	}
	else
	{
	$all_day = "no";
	}
	$description = $_POST["description"];

	//mysql_query("UPDATE tb_app_appointment SET date_start='$date_start', date_end='$date_end', start_hour='$start_hour', start_minute='$start_minute', end_hour='$end_hour', end_minute='$end_minute', subject='$subject', location='$location', description='$description', appointment_type='$type', is_allday='$all_day', is_any='$any' WHERE id='$selected_record'");
	mysql_query("UPDATE tb_app_appointment SET
	date_start='$date_start',
	date_end='$date_end',
	start_month='$start_month',
	end_month='$end_month',
	start_day='$start_day',
	end_day='$end_day',
	start_year='$start_year',
	end_year='$end_year',
	start_hour='$start_hour',
	start_minute='$start_minute',
	end_hour='$end_hour',
	end_minute='$end_minute',
	subject='$subject',
	location='$location',
	description='$description',
	appointment_type='$type',
	is_allday='$all_day',
	is_any='$any'
	WHERE id='$selected_record'");

	$appointment_id = $selected_record;
	$date_added = date("Ymd");
	$angent_id = $_SESSION['admin_id'];
	$type = "This schedule has been changed";
	$status = "Active";
	mysql_query("INSERT INTO tb_app_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");

	$yearID = @$_GET["yearID"];
	$monthID = @$_GET["monthID"];
	$dayID = @$_GET["dayID"];

	echo '
	<script language="javascript">
	window.location="?leads_id='.$client_id.'&id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";
	</script>
	';
	}
	//UPDATE APPOINTMENT

	$title = "Date Selected: ".$dayID."-".$monthID."-".$yearID;
?>



<HTML>
<HEAD>
<TITLE>Calendar</TITLE>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="ajax/get_schedule.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>



<script language="javascript">
	//<scrip t type="text/javascript" src="js/popup_calendar.js">< /script >
	//NOTE: this function can't be linked to popup_calendar.js because it has some php values returns from the server.
	//FROM POPUP_CALENDAR.PHP FUNCTIONS
	var client_full_name = '<?php echo $client_full_name;?>';
			var applicant_full_name = '<?php echo $applicant_full_name;?>';
			var from_name = '<?php echo $from_name;?>';
			var creator_name = '<?php echo $from_name;?>';
			var sub_category_name = '<?php echo $sub_category_name;?>';
			var admin_name_loading_counter = 1;

			function makeObject()
			{
			var x ;
			var browser = navigator.appName ;
			if(browser == 'Microsoft Internet Explorer')
			{
			x = new ActiveXObject('Microsoft.XMLHTTP')
			}
			else
			{
			x = new XMLHttpRequest()
			}
			return x ;
			}

			//SEARCH LEADS
			//var curSubMenu = '';
			var keyword;
			var SL_request = makeObject()
			function SL_query_lead()
			{
			//get_applicant_name(this.value);
			//alert(id);
			keyword = document.getElementById('key_id').value;
			if(keyword == "" || keyword == "(fname/lname/email)")
			{
			alert("Please Enter Your Keyword!");
			}
			else
			{
			SL_request.open('get', 'search-leads.php?key='+keyword)
			SL_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			SL_request.onreadystatechange = SL_active_listings
			SL_request.send(1)
			}
			}
			function SL_active_listings()
			{
			var data;
			data = SL_request.responseText
			if(SL_request.readyState == 4)
			{
			document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center>"+data+"</td></tr></table>";
			}
			else
			{
			document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='../images/ajax-loader.gif'></td></tr></table>";
			}
			}
			function SL_search_lead()
			{
			//num_selected = num;
			//if (curSubMenu!='')
			//SL_hideSubMenu();
			eval('search_div').style.visibility='visible';
			//document.getElementById('search_div').innerHTML = document.getElementById('search_box').innerHTML;
			//curSubMenu='search_div';
			}
			function SL_hideSubMenu()
			{
			eval('search_div').style.visibility='hidden';
			//document.getElementById(curSubMenu).innerHTML = "";
			//curSubMenu='';
			}
			function SL_assign(id,name)
			{
			document.getElementById('client_id').value = id;
			document.getElementById('client_id_display').value = name;
			}
			//ENDED - SEARCH LEADS

			// s t a r t   a j a x
			var request = makeObject()

			//------>
			function get_client_name(id)
			{
			request.open('get', 'get_client_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = client_name_update_values
			request.send(1)
			}
			function client_name_update_values()
			{
			var data = request.responseText
			if(request.readyState == 4)
			{
			client_full_name = data;
			client_full_name = client_full_name.replace("\n", "");
			client_full_name = client_full_name.replace("<br />", "");
			client_full_name = client_full_name.replace("   ", " ");
			document.getElementById("loading_div").innerHTML="";
			populate_autoresponder();
			}
			else
			{
			document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
			}
			// <------

			//------>
			function get_applicant_name(id)
			{
			request.open('get', 'get_applicant_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = applicant_name_update_values
			request.send(1)
			}
			function applicant_name_update_values()
			{
			var data = request.responseText
			if(request.readyState == 4)
			{
			applicant_full_name = data;
			applicant_full_name = applicant_full_name.replace("\n", "");
			applicant_full_name = applicant_full_name.replace("<br />", "");
			applicant_full_name = applicant_full_name.replace("   ", " ");
			document.getElementById("loading_div").innerHTML="";
			populate_autoresponder();
			}
			else
			{
			document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
			}
			// <------

			//------>
			function get_admin_name(id)
			{
			admin_name_loading_counter++;
			request.open('get', 'get_admin_name.php?id='+id)
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = admin_name_update_values
			request.send(1)
			}
			function admin_name_update_values()
			{
			var data = request.responseText
			if(request.readyState == 4)
			{
			from_name = data;
			from_name = from_name.replace("\n", "");
			from_name = from_name.replace("<br />", "");
			from_name = from_name.replace("   ", " ");
			document.getElementById("loading_div").innerHTML="";
			populate_autoresponder();
			}
			else
			{
			document.getElementById("loading_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
			}
			// <------

			// e n d e d

			function view_actions(id)
			{
			previewPath = "action_details.php?id="+id;
			window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
			}
			function view_all_actions(id)
			{
			previewPath = "actions_list.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
			}
			//ENDED
</script>
</HEAD>
<BODY BGCOLOR=#EEECEC LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0
	MARGINHEIGHT=0>
	<center>
		<table width="100%" border="0" bgcolor="#3E97CF" cellpadding="10"
			cellspacing="0">
			<tr>
				<div id="hostname" style="display: none">
				<?php echo $hostname ?>
				</div>
				<!--<td><input type="button" value="<<< BACK TO APPLICANT PAGE" name="new" <?php echo $button_style; ?> onClick="javascript: window.location='<?php echo $_SESSION['back_link']; ?>'; "></td>-->
				<td width="24%" align="left" valign="top" bgcolor="#3E97CF"
					colspan="3"><font color="#FFFFFF"><strong>
							<div id="timer">
								<script type="text/javascript" src="../timezones/cheatclock.php"></script>
								<br />
								<table width="100%">
									<tr>
										<td width="4%" valign="middle"><img
											src="../images/flags/Philippines.png" align="middle"
											title="Philippines/Manila" /></td>
										<td width="18%" valign="middle"><b>Manila</b> <span
											id="manila"></span></td>
										<td width="4%" valign="middle"><img
											src="../images/flags/Australia.png" align="absmiddle"
											title="Australia/Sydney" /></td>
										<td width="20%" valign="middle"><b>Sydney</b> <span
											id="sydney"></span></td>
										<td width="4%" valign="middle"><img
											src="../images/flags/usa.png" align="absmiddle"
											title="USA/San Francisco" /></td>
										<td width="26%" valign="middle"><b>San Francisco</b> <span
											id="sanfran"></span><br /> <b>New York</b> <span id="newyork"></span>
										</td>
										<td width="4%" valign="middle"><img
											src="../images/flags/uk.png" align="absmiddle"
											title="UK/London" />
										</td>
										<td width="20%"><b>London</b> <span id="london"></span>
										</td>
									</tr>
								</table>
							</div> </strong> </font></td>
			</tr>

			<tr>
				<td width="100%" align="left" valign="top" bgcolor="#FFFFFF"
					rowspan="2">
					<table width="100%" border="0" bgcolor="#666666" cellpadding="10"
						cellspacing="1">
						<tr>
							<td width="5%" align="left" valign="top" bgcolor="#3E97CF"><strong><font
									color="#ffffff">Time</font> </strong></td>
							<td width="24%" align="left" valign="top" bgcolor="#3E97CF"><table
									width="100%">
									<tr>
										<td><strong><font color="#ffffff">Appointment/Event Details</font>
										</strong></td>
										<td align="right"><strong><font color="#ffffff"><strong><?php echo $title;?>
												</strong> </font> </strong></td>
									</tr>
								</table></td>
						</tr>
						<?php
						if(@$_GET["error_message"] == "exist")
						{
							?>

						<tr>
							<td width="24%" align="left" valign="top" bgcolor="#ffffff"
								colspan="2">
								<table width="100%" border="0" bgcolor="#ffffff" cellpadding="5"
									cellspacing="1">
									<tr>
										<td><img src="iconss/warning.gif"></td>
										<td width="100%"><font color="#FF0000"><strong> <strong><font
														color='#FF0000'>Conflicts with another appointment on your
															Calendar</font> </strong> </strong> </font></td>
									</tr>
								</table>
							</td>
						</tr>
						<?php
						}
						if(@isset($_GET["appointment_cancel"]))
						{
						$id = $_GET["appointment_cancel"];
							?>
						<tr>
							<td width="24%" align="left" valign="top" bgcolor="#ffffff"
								colspan="2">
								<table width="100%" border="0" bgcolor="#ffffff" cellpadding="5"
									cellspacing="1">
									<tr>
										<td><img src="iconss/warning.gif"></td>
										<td><font color="#FF0000"><strong>Click&nbsp;yes&nbsp;to&nbsp;confirm&nbsp;deletion.</strong>
										</font></td>
										<td width="100%"><input type="button" value="Yes"
											name="delete" <?php echo $button_style;?>
											onClick="javascript: window.location='?<?php echo "appointment_cancel=" . $id . "&delete_confirmed=yes&yearID=" . $yearID . "&monthID=" . $monthID . "&dayID=" . $dayID;?>'">
											<input type="button" value="Cancel" name="cancel"
											<?php echo $button_style;?>
											onClick="javascript: window.location='?<?php echo "yearID=" . $yearID . "&monthID=" . $monthID . "&dayID=" . $dayID;?>'">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php
						}
						if(@isset($_GET["appointment_finish"]))
						{
						$id = $_GET["appointment_finish"];
							?>
						<tr>
							<td width="24%" align="left" valign="top" bgcolor="#ffffff"
								colspan="2">
								<table width="100%" border="0" bgcolor="#ffffff" cellpadding="5"
									cellspacing="1">
									<tr>
										<td><img src="iconss/warning.gif"></td>
										<td><font color="#FF0000"><strong>Click&nbsp;yes&nbsp;to&nbsp;finish&nbsp;this&nbsp;meeting.</strong>
										</font></td>
										<td width="100%"><input type="button" value="Yes"
											name="delete" <?php echo $button_style;?>
											onClick="javascript: window.location='?<?php echo "appointment_finish=" . $id . "&finish_confirmed=yes&yearID=" . $yearID . "&monthID=" . $monthID . "&dayID=" . $dayID;?>'">
											<input type="button" value="Cancel" name="cancel"
											<?php echo $button_style;?>
											onClick="javascript: window.location='?<?php echo "yearID=" . $yearID . "&monthID=" . $monthID . "&dayID=" . $dayID;?>'">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php }?>
						<!--MEETING SCHEDULE-->
						<tr>
							<td colspan="2" width="5%" align="left" valign="top"
								bgcolor="#FFFFFF"><strong><font color="#000000">Active Meeting
										Schedule</font> </strong></td>
						</tr>
						<tr>
						<?php

						if (isset($_GET["view_type"]) && $_GET["view_type"] == "other_admin") {
							if (isset($_GET["selected_admin"])) {
								$url = "today_and_otherdays_schedule.php?admin_id=" . $_GET["selected_admin"];
							} else {
								$url = "today_and_otherdays_schedule.php?admin_id=" . $_SESSION["admin_id"];
							}
						} else {
							$url = "today_and_otherdays_schedule.php";
						}
						?>

							<td colspan="2" width="5%" align="left" valign="top"
								bgcolor="#FFFFFF"><iframe id="frame" name="frame" width="100%"
									height="200" src="<?php echo $url?>" frameborder="0">Your
									browser does not support inline frames or is currently
									configured not to display inline frames.</iframe>
							</td>
						</tr>
						<!--ENDED - MEETING SCHEDULE-->

						<tr>
							<td width="5%" align="left" valign="top" bgcolor="#FFFFFF"><strong><font
									color="#000000">All Day</font> </strong></td>
							<td width="24%" align="left" valign="top" bgcolor="#D9D902">
								<table width="100%" border="0" bgcolor="#CCCCCC" cellpadding="5"
									cellspacing="1">
									<?php
									$total_appointments = 0;
									$sub_total_appointment = 1;

									if($_SESSION['interview_id'] <> "")
									{
										if (isset($_GET["view_type"])&&$_GET["view_type"]=="admin"){
											if (isset($_GET["selected_admin"])){
												$q = "SELECT id, start_hour, end_hour, subject FROM tb_app_appointment WHERE status='active' AND user_id='{$_GET["selected_admin"]}' AND date_start='$date_selected' AND is_allday='yes' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY start_hour ASC";
											}else{
												$q = "SELECT id, start_hour, end_hour, subject FROM tb_app_appointment WHERE status='active' AND user_id='$user_id' AND date_start='$date_selected' AND is_allday='yes' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY start_hour ASC";
											}
										}else{
											$q = "SELECT id, start_hour, end_hour, subject FROM tb_app_appointment WHERE status='active' AND user_id='$user_id' AND date_start='$date_selected' AND is_allday='yes' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY start_hour ASC";
										}
									}
									else
									{
										$q = "SELECT id, start_hour, end_hour, subject FROM tb_app_appointment WHERE status='active' AND user_id='$user_id' AND date_start='$date_selected' AND is_allday='yes' ORDER BY start_hour ASC";
									}
									$get_time = mysql_query($q);
									while ($row = @mysql_fetch_assoc($get_time))
									{
										?>
									<tr>
										<td width="100%" align="left" valign="top" bgcolor="#ffffff"
											onClick="javascript: document.getElementById('update_selected_record_id').value=<?php echo $row["id"];?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $row["id"];?>'; mouse_state='off'; "
											onMouseOver="javascript:this.style.background='#F4F2F2';"
											onMouseOut="javascript:this.style.background='#FFFFFF';"><?php echo $row["subject"];?>
										</td>
									</tr>
									<?php
									}
									?>
								</table>
							</td>
						</tr>

						<?php
						$type = "AM";
						$display_hr = 0;
						if($monthID < 10) $monthID = "0".$monthID;
						if($dayID < 10) $dayID = "0".$dayID;
						for($hrs = 1; $hrs <= 24; $hrs++)
						{
							$display_hr++;
							if($hrs == 13)
							{
								$display_hr = 1;
								$type = "PM";
							}
							if($hrs == 12)
							{
								$type = "PM";
							}
							if($hrs == 24)
							{
								$type = "AM";
							}
							if($hrs > 7 && $hrs < 17)
							{
								$bgcolor="#FDFDB3";
							}
							else
							{
								$bgcolor="#D9D902";
							}
							?>

						<tr>
							<td width="5%" align="center" bgcolor="#FFFFFF" valign="top">
								<table width="100%">
									<tr>
										<td valign="top"><strong><font size="2"> <?php echo $display_hr;?>
											</font> </strong>
										</td>
										<td align="center" valign="top">00&nbsp;<font size="1"><?php echo $type;?>
										</font></td>
									</tr>
								</table>
							</td>

							<?php

							$total_appointments = 0;
							$selected_time = 0;
							$sub_hrs = $hrs + 1;

							if($_SESSION['interview_id'] <> "")
							{
								if (isset($_GET["selected_admin"])){
									$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='{$_GET["selected_admin"]}' AND date_start='$date_selected' AND is_allday='no' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY start_minute ASC";					
								}else{
									$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='$user_id' AND date_start='$date_selected' AND is_allday='no' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY start_minute ASC";	
								}
								
								
								
							}
							else
							{
								if (isset($_GET["selected_admin"])){
									$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='{$_GET["selected_admin"]}' AND date_start='$date_selected' AND is_allday='no' ORDER BY start_minute ASC";					
								}else{
									$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='$user_id' AND date_start='$date_selected' AND is_allday='no' ORDER BY start_minute ASC";	
								}
							}
							$get_time = mysql_query($q);
							while ($row = @mysql_fetch_assoc($get_time))
							{
								$id = $row["id"];
								$start_hour = $row["start_hour"];

								$start_minute = $row["start_minute"]; if($start_minute < 10) $start_minute = "0".$start_minute;
								$time_zone = $row["time_zone"];
								$end_hour = $row["end_hour"];
								$end_minute = $row["end_minute"]; if($end_minute == 0) { $end_minute = "00"; }
								$subject = $row["subject"];
								$description = $row["description"];
								$date_start = $row["date_start"];
								$timezone_display = $time_zone;

								switch($time_zone)
								{
									case "America/San Francisco":
										$time_zone = "PST8PDT";
										break;
									case ($time_zone == "New_Zealand/Auckland" || $time_zone == "New_Zealand/Wellington" || $time_zone == "New_Zealand/Napier" || $time_zone == "New_Zealand/Christchurch" || $time_zone == "New_Zealand/Hamilton" || $time_zone == "New_Zealand/Dunedin" || $time_zone == "New_Zealand/Invercargill"):
										$time_zone = "NZ";
										break;
									case "New_Zealand/Chatham_Islands":
										$time_zone = "NZ-CHAT";
										break;
								}

								$calendar_date = $yearID."-".$monthID."-".$dayID;

								//time conversion - ADMIN
								$ref_date = $calendar_date." ".$hrs.":00:00";
								$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								date_default_timezone_set($admin_timezone);
								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								$destination_date = clone $date;
								$destination_date->setTimezone($admin_timezone);
								$admin_schedule_1 = $destination_date;

								$ref_date = $calendar_date." ".$hrs.":59:00";
								$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								date_default_timezone_set($admin_timezone);
								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								$destination_date = clone $date;
								$destination_date->setTimezone($admin_timezone);
								$admin_schedule_2 = $destination_date;
								//ended


								//time conversion - CLIENT
								$ref_date = $date_start." ".$start_hour.":".$start_minute.":00";
								$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								date_default_timezone_set($time_zone);
								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								$destination_date = clone $date;
								$destination_date->setTimezone($admin_timezone);
								$client_schedule = $destination_date;

								$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
								$destination_date = clone $date;
								$destination_date->setTimezone($time_zone);
								$client_display_schedule = $destination_date;
								//ended


								if(($client_schedule >= $admin_schedule_1) && ($client_schedule <= $admin_schedule_2))
								{
									if($total_appointments < 1)
									{
										?>
							<td width="100%" align="left" valign="top"
								bgcolor="<?php echo $bgcolor;?>"
								onMouseOver="javascript:this.style.background='#FFFFFF'; "
								onMouseOut="javascript:this.style.background='<?php echo $bgcolor;?>';">
								<table width="100%" border="0" bgcolor="#CCCCCC" cellpadding="1"
									cellspacing="0">
									<?php
									}
									?>
									<tr>
										<td>
											<table width="100%" border="0" bgcolor="#FFFFFF"
												cellpadding="5" cellspacing="1"
												onMouseOver="javascript:this.style.background='#CCCCCC'; "
												onMouseOut="javascript:this.style.background='#FFFFFF';">
												<tr>
													<td width="100%" align="left" valign="top"
														onClick="javascript: mouse_state='on'; document.getElementById('update_selected_record_id').value=<?php echo $id;?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $id;?>'; document.getElementById('end_minute_id').value=id_selected; date_selected='<?php echo $date_selected;?>'; m_selected=<?php echo $selected_time;?>; hr_selected=<?php echo $hrs;?>; mouse_state='off'; ">

														<table>
															<tr>
																<td colspan="2"><font size="2"> <?php echo "<b>" . $admin_timezone_display . ": </b>" . strtoupper($subject);?>
																</font>
																</td>
															</tr>
															<tr>
																<td><img src="iconss/timezone.png" width="20"></td>
																<td><font size="1"> <?php echo "<b>CLIENT SCHEDULE: </b></font>" . $client_display_schedule . " " . $timezone_display;?>
																</font>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									<?php
									$total_appointments++;
									}
									}
									if($total_appointments >= 1)
									{
								?>
								</table> <br> &nbsp;<b><a href="#"
									onClick="javascript: mouse_state='on'; date_selected='<?php echo $date_selected;?>'; m_selected=<?php echo $selected_time;?>; hr_selected=<?php echo $hrs;?>; showSubMenu('available_time');">Menu</a>
							</b>
							</td>
							<?php
							}
							if($total_appointments < 1)
							{
								?>
							<td width="100%" align="left" valign="top"
								bgcolor="<?php echo $bgcolor;?>"
								onClick="javascript: mouse_state='on'; date_selected='<?php echo $date_selected;?>'; m_selected=<?php echo $selected_time;?>; hr_selected=<?php echo $hrs;?>; showSubMenu('available_time');"
								onMouseOver="javascript:this.style.background='#FFFFFF';"
								onMouseOut="javascript:this.style.background='<?php echo $bgcolor;?>';">&nbsp;</td>
								<?php
								}
							?>
						</tr>
						<?php
						}
						date_default_timezone_set($admin_timezone);
						?>
						</tr>
					</table>
				</td>
				<td width="24%" align="left" valign="top" bgcolor="#F1F1F3"><?php 
				//check current settings
				$settings = $db->fetchOne($db->select()->from("admin", array("view_admin_calendar"))->where("admin_id = ?", $user_id));
				if ($settings=="Y"&&isset($_GET["view_type"])&&($_GET["view_type"]=="other_admin")){
					?>
					<form id="view-other-admin" method="GET">
						<table>
							<tr>
								<td colspan="2"><h3>View Other Admin's Calendar</h3></td>
							</tr>
							<tr>
								<td>Select Admin:</td>
								<td><input type="hidden" name="view_type" value="other_admin" />
									<select name="selected_admin">
									<option value="0"></option>
									<?php
									$admins = $db->fetchAll($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("status <> 'REMOVED'")->where("admin_id NOT IN(67, 134)")->order("admin_fname"));
									foreach($admins as $adm){
										if (isset($_GET["selected_admin"])&&($_GET["selected_admin"]==$adm["admin_id"])){
										?>
											<option value="<?php echo $adm["admin_id"]?>" selected>
												<?php echo $adm["admin_fname"]." ".$adm["admin_lname"]?>
											</option>
										
										<?php
											}else{
										?>
											<option value="<?php echo $adm["admin_id"]?>">
												<?php echo $adm["admin_fname"]." ".$adm["admin_lname"]?>
											</option>
										<?php
										}
										}
									?>
								</select>
								</td>
							</tr>
							<tr>
								<td colspan="2"><button>View Calendar</button></td>
							</tr>

						</table>
					</form> <?php }?>

					<table>
						<tr>
							<td><img src="iconss/timezone.png"></td>
							<td width="100%">
							
							
							
							<?php if (isset($_GET["view_type"])&&($_GET["selected_admin"])){?>
								<select onChange="javascript: window.location='?yearID=<?php echo $yearID;?>&monthID=<?php echo intval($monthID);?>&dayID=<?php echo $dayID;?>&selected_admin=<?php echo $_GET["selected_admin"]?>&view_type=<?php echo $_GET["view_type"]?>&time_zone_update='+this.value; ">
							<?php }else{?>
								<select onChange="javascript: window.location='?yearID=<?php echo $yearID;?>&monthID=<?php echo intval($monthID);?>&dayID=<?php echo $dayID;?>&time_zone_update='+this.value; ">
							<?php }?>
								<?php
								$opt = "";
								require_once "TimezoneUtility.php";
								TimezoneUtility::getTimezoneList();
								$is_executed = 0;
								echo "<strong>ADMIN TIMEZONE</strong><BR />";
								echo "";
								$queryAllTimezone = "SELECT * FROM timezone_lookup ORDER BY timezone";
								$tz_result = $db -> fetchAll($queryAllTimezone);
								foreach ($tz_result as $tz_result) {
									if ($tz_result['timezone'] == "Pacific/Chatham" || $tz_result['timezone'] == "Asia/Kolkata") {
										continue;
									}

									switch($tz_result['timezone']) {
										case "PST8PDT" :
											$admin_timezone_display = "America/San Francisco";
											break;
										case "NZ" :
											$admin_timezone_display = "New Zealand/Wellington";
											break;
										case "NZ-CHAT" :
											$admin_timezone_display = "New Zealand/Chatham_Islands";
											break;
										default :
											$admin_timezone_display = $tz_result['timezone'];
											break;
									}
									if ($admin_timezone_id == $tz_result['id']) {
										$is_executed = 1;
										echo "<OPTION VALUE='" . $tz_result['id'] . "' SELECTED>" . $admin_timezone_display . "</OPTION>";
									} else {
										echo "<OPTION VALUE='" . $tz_result['id'] . "'>" . $admin_timezone_display . "</OPTION>";
									}
								}
								if ($is_executed == 0) {
									echo "<OPTION VALUE='' SELECTED></OPTION>";
								}
								?> </select>
							</td>
						</tr>
						<tr>
							<td colspan="2"><br /> <font color="#000000"><strong>Calendar</strong>
							</font>&nbsp;(view <a href="?calendar_type=m"><u>month</u> </a>,&nbsp;<a
								href="?calendar_type=y"><u>year</u> </a>)</td>
						</tr>


					</table>
				</td>
			</tr>
			<tr>
				<td width="24%" align="left" valign="top" bgcolor="#F1F1F3"><font
					color="#000000"> <?php
					if (@$_SESSION['calendar_type'] == "y")
						require_once ("yearview.php");
					else
						require_once ("monthview.php");
					?> </font>
				</td>
			</tr>
			<tr>
				<td width="24%" align="left" valign="top" bgcolor="#F1F1F3"
					colspan="4"><font color="#000000"><strong>Total Showing: <?php echo @$counter;?>
					</strong> </font></td>
			</tr>
		</table>

		<!--ADD NEW APPOINTMENT-->
		<DIV ID='available_time'
			STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'
			onMouseOver="javascript: mouse_state='off';">
			<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1
				width="100%">
				<tr>
					<td>
						<table width=100% cellspacing=1 border=0 cellpadding=7
							bgcolor=#fefefe>
							<tr>
								<td
									onClick="javascript: populate_autoresponder(); appointment_new();"
									bgcolor=#FFFFFF
									onMouseOver="javascript:this.style.background='#3E97CF';"
									onMouseOut="javascript:this.style.background='#FFFFFF'; "><a
									href="#">Add New Appointment</a>
								</td>
							</tr>
							<tr>
								<td bgcolor=#FFFFFF>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor=#FFFFFF align="right"><a
									href="javascript: hideSubMenu();"><font size="1">Close</font> </a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</DIV>
		<!--ENDED-->


		<!--APPOINTMENT MENU-->
		<DIV ID='used_time'
			STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'
			onMouseOver="javascript: mouse_state='off';">
			<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1
				width="100%">
				<tr>
					<td>
						<table width=100% cellspacing=1 border=0 cellpadding=7
							bgcolor=#fefefe>
							<tr>
								<td onClick="javascript: timer_stat=0; view_schedule();"
									bgcolor=#FFFFFF
									onMouseOver="javascript:this.style.background='#3E97CF';"
									onMouseOut="javascript:this.style.background='#FFFFFF'; "><a
									href="#">Open</a>
								</td>
							</tr>
							<tr>
								<td
									onClick="javascript: window.location='?yearID=<?php echo $yearID;?>&monthID=<?php echo $monthID;?>&dayID=<?php echo $dayID;?>&appointment_finish='+id_selected;"
									bgcolor=#FFFFFF
									onMouseOver="javascript:this.style.background='#3E97CF';"
									onMouseOut="javascript:this.style.background='#FFFFFF'; "><a
									href="#">Finish</a>
								</td>
							</tr>
							<tr>
								<td onClick="javascript: timer_stat=0; appointment_update();"
									bgcolor=#FFFFFF
									onMouseOver="javascript:this.style.background='#3E97CF';"
									onMouseOut="javascript:this.style.background='#FFFFFF'; "><a
									href="#">Update</a>
								</td>
							</tr>
							<tr>
								<td
									onClick="javascript: window.location='?yearID=<?php echo $yearID;?>&monthID=<?php echo $monthID;?>&dayID=<?php echo $dayID;?>&appointment_cancel='+id_selected;"
									bgcolor=#FFFFFF
									onMouseOver="javascript:this.style.background='#3E97CF';"
									onMouseOut="javascript:this.style.background='#FFFFFF'; "><a
									href="#">Cancel</a>
								</td>
							</tr>
							<tr>
								<td bgcolor=#FFFFFF>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor=#FFFFFF align="right"><a
									href="javascript: hideSubMenu();"><font size="1">Close</font> </a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</DIV>
		<!--ENDED-->


		<!--<DIV onClick="javascript: mouse_state='off';" ID='new_appointment' STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> -->
		<DIV ID='new_appointment'
			STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'>
			<?php
				include ("new_appointment.php");
 ?>
		</DIV>

		<!--<DIV ID='update_appointment' onClick="javascript: mouse_state='off';" STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> -->
		<DIV ID='update_appointment'
			STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'>
			<?php
				include ("update_appointment.php");
 ?>
		</DIV>


	</center>

	<script type="text/javascript">
		function get_mouse_pointer_coordinates(e) {
			var posx = 0;
			var posy = 0;
			if(!e)
				var e = window.event;

			if(e.pageX || e.pageY) {
				posx = e.pageX;
				posy = e.pageY;
			} else if(e.clientX || e.clientY) {
				posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
				posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
			}
			if(mouse_state == 'on') {
				document.getElementById('available_time').style.left = posx;
				document.getElementById('available_time').style.top = posy;
				document.getElementById('used_time').style.left = posx;
				document.getElementById('used_time').style.top = posy;
			}
		}


		document.body.onmousemove = get_mouse_pointer_coordinates;

</script>
	<DIV ID='temp'>
	</DIV>
</BODY>
</HTML>
