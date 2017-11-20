<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

//START: validate session
$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}
//ENDED: validate session


//START: construct variables
$date_requested1 = $_REQUEST['date_requested1'];
$date_requested2 = $_REQUEST['date_requested2'];
$date_updated1 = $_REQUEST['date_updated1'];
$date_updated2 = $_REQUEST['date_updated2'];
$date_interview_sched1 = $_REQUEST["date_interview_sched1"];
$date_interview_sched2 = $_REQUEST["date_interview_sched2"];
$time_interview_sched1 =  $_REQUEST["time_interview_sched_1"];
$time_interview_sched2 =  $_REQUEST["time_interview_sched_2"];

$selectedRecruiter = $_REQUEST["recruiter"];
$selectedHm = $_REQUEST["hm"];

$key = $_REQUEST['key'];
$status = $_REQUEST['status']; if($status == "") { $status = "NEW"; } 
$payment_status = $_REQUEST['payment_status'];
$booking_type = $_REQUEST['booking_type'];
$payment_stat = $_REQUEST['payment_stat'];
$max = @$_REQUEST["max"];
$p = @$_REQUEST["p"];
$stat = @$_REQUEST["stat"];
$hired_visiblity = @$_REQUEST["hired_visiblity"];
$id = @$_REQUEST["id"];
$service_type = @$_REQUEST["service_type"];
if($service_type == "CUSTOM")
{
	$_SESSION['service_type_title'] = "Custom Bookings Report";	
	$_SESSION['service_type'] = " r.service_type='CUSTOM'";
}
else if ($service_type=="ASL")
{
	$_SESSION['service_type_title'] = "Request for Interview (ASL) Bookings Report ";
	$_SESSION['service_type'] = " r.service_type='ASL'";
}else{
	$_SESSION['service_type'] = "";
	$_SESSION['service_type_title'] = "Interview Bookings Report";
}
//ENDED: construct variables


//START: recruitment status update
if(isset($stat))
{
	mysqli_query($link2,"UPDATE tb_request_for_interview SET status='$stat' WHERE id='$id'");
	if($stat=='ARCHIVED' || $stat=='HIRED' || $stat=='REJECTED' || $stat=='CANCELLED')
	{
		mysqli_query($link2,"UPDATE tb_app_appointment SET status='not active' WHERE request_for_interview_id='$id'");	
	}
	if($stat=='HIRED')
	{
		$u = mysqli_query($link2,"SELECT applicant_id FROM tb_request_for_interview WHERE id='$id'");
		$uid = mysqli_result($u,0,"applicant_id");
		if($hired_visiblity == "yes")
		{
			mysqli_query($link2,"UPDATE job_sub_category_applicants SET ratings='1' WHERE ratings='0' AND userid='$uid'");
		}
	}
}
//ENDED: recruitment status update


//START: update payment status
if(isset($payment_stat))
{
	mysqli_query($link2,"UPDATE tb_request_for_interview SET payment_status='$payment_stat' WHERE id='$id'");
}
//ENDED: update payment status


//START: functions
//start: comment adjustment
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ended: comment adjustment

//start: search asl interview
function search($booking_type,$payment_status,$date_requested1,$date_requested2, $date_updated1, $date_updated2,$date_interview_sched1,$date_interview_sched2,$time_interview_sched1,$time_interview_sched2, $key,$status,$p,$maxp,$max) 
{
	
	global $db;
	
	$set = $p ;

	$a_ = $date_requested1; 
	$b_ = $date_requested2;
	$title = "Between (".$a_." and ".$b_.")";	
	
	$from = "FROM tb_request_for_interview r, leads l, voucher v ";
	$order_by = "GROUP BY r.date_updated, r.date_added ORDER BY r.date_updated DESC, r.date_added DESC LIMIT $set, $maxp";	
	
	
	
	$sql = $db->select()->from(array("r"=>"tb_request_for_interview"), 
							array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS r.id"),
								  "r.order_id",
								  "r.job_sub_category_applicants_id",
								  
								  "r.applicant_id",
								  "r.comment",
								  "r.date_interview",
								  "r.time",
							      "r.alt_time",
							      "r.alt_date_interview",
							      "r.time_zone",
								  "r.status",
								  "r.payment_status",
								  "r.date_added",
								  "r.voucher_number",
								  "r.session_id",
								  "r.booking_type",
								  "r.applicant_confirmed",
								  "r.service_type",
								  "r.date_updated", new Zend_Db_Expr("STR_TO_DATE(CONCAT(r.date_interview, ' ', UPPER(r.time)), '%Y-%m-%d %h:%i %p') AS date_interview_sched"),
								  new Zend_Db_Expr("CONVERT_TZ(STR_TO_DATE(CONCAT(r.date_interview, ' ', UPPER(r.time)), '%Y-%m-%d %h:%i %p'), r.time_zone, 'Asia/Manila') AS manila_time")))
					->joinInner(array("l"=>"leads"), "l.id = r.leads_id", array("l.id AS leads_id", "l.fname", "l.lname", "l.location_id"))
					->joinLeft(array("v"=>"voucher"), "r.voucher_number=v.code_number", array())
					->joinLeft(array("app"=>"tb_app_appointment"), "app.request_for_interview_id = r.id", array())
					;

					
	//start: date query
	if (strtoupper($a_)!="ANY"&&strtoupper($b_)!="ANY"&&trim($a_)!=""&&trim($b_)!=""){
		$sql->where("DATE_FORMAT(r.date_added,'%Y-%m-%d') BETWEEN '$a_' AND '$b_'");
	}
	//ended: date query
	
	//start:date updated query
	if (strtoupper($date_updated1)!="ANY"&&strtoupper($date_updated2)!="ANY"&&trim($date_updated1)!=""&&trim($date_updated2)!=""){
		$sql->where("DATE(r.date_updated) >= '$date_updated1' AND DATE(r.date_updated) <= '$date_updated2'");
	}
	//start: payment status query
	if (strtoupper($payment_status)!="ANY"&&$payment_status!=""){
		$sql->where("r.payment_status = ?", $payment_status);
	}
	//start: booking_type query
	if(!($booking_type == "Any" || $booking_type == "ANY" || $booking_type == "")){
		$sql->where("r.booking_type=?", $booking_type);
	}
	
	
	$selectedRecruiter = $_REQUEST["recruiter"];
	$selectedHm = $_REQUEST["hm"];
	
	if ($selectedRecruiter){
		$sql->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = r.applicant_id", array())
			->where("rs.admin_id = ?", $selectedRecruiter);
	}	
	
	if ($selectedHm){
		$sql->where("l.hiring_coordinator_id = ?", $selectedHm);
	}
	
	$admin = $_GET["admin"];
	if (isset($admin)&&($admin!="ALL")){
		$sql->where("app.user_id = ?", $admin);
	}
	

	//start: payment status query
	$status_query = "";
	if($status == "")
	{
		$sql->where("r.status='NEW' OR r.status IS NULL OR r.status='ACTIVE'");
	} 
	elseif($status <> "ANY")
	{
		$sql->where("r.status=?", $status);
	}
							      
	if (trim($key)!=""){
		$sql->joinLeft(array("p"=>"personal"), "p.userid = r.applicant_id", array())
			->where("r.leads_id='$key' OR r.applicant_id='$key' OR r.voucher_number='$key' OR l.fname LIKE '%$key%' OR l.lname LIKE '%$key%' OR CONCAT(l.fname, ' ', l.lname) LIKE '%$key%' OR p.fname LIKE '%$key%' OR p.lname LIKE '%$key%' OR CONCAT(p.fname, ' ', p.lname) LIKE '%$key%'");
			
	}
	if ($date_interview_sched1!="Any"&&$date_interview_sched2!="Any"){
		if ($date_interview_sched1&&$date_interview_sched2&&$time_interview_sched1&&$time_interview_sched2){
			if ($time_interview_sched1&&$time_interview_sched2){
				$datetime1 = $date_interview_sched1." ".$time_interview_sched1.":00";
				$datetime2 = $date_interview_sched2." ".$time_interview_sched2.":00";
				$sql->having("date_interview_sched BETWEEN '".$datetime1."' AND '".$datetime2."'");
					
			}else{
				
				$sql->having("DATE(date_interview_sched) BETWEEN DATE('".$datetime1."') AND DATE('".$datetime2."')");
				
			}
		}else{
			if ($date_interview_sched1&&$date_interview_sched2){
				$datetime1 = $date_interview_sched1." 00:00:00";
				$datetime2 = $date_interview_sched2." 00:00:00";
				$sql->having("DATE(date_interview_sched) BETWEEN DATE('".$datetime1."') AND DATE('".$datetime2."')");
				
			}
	
		}
		$sql->order(array( "r.date_added DESC", "l.fname", "manila_time ASC", "r.date_updated DESC"));
	}else{
		$sql->order(array( "r.date_added DESC","l.fname", "r.date_updated DESC"));
	}
	
	
	if ($_SESSION["service_type"]!=""){
		$sql->where($_SESSION['service_type']);
	}
	//$sql->group("manila_time");
	$sql->group(array("r.id"))
		->limitPage($set, $maxp);
	
	$result = $db->fetchAll($sql);
	
	$max =  $db->fetchOne("SELECT FOUND_ROWS()");	
	$x = 0 ;	
	foreach ($result as $r) 
	{
		$temp[$x]['title'] = $title;
		$temp[$x]['max'] = $max;
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['order_id'] = $r['order_id'];
		$temp[$x]['job_sub_category_applicants_id'] = $r['job_sub_category_applicants_id'];
		$temp[$x]['leads_id'] = $r['leads_id'];
		$temp[$x]['applicant_id'] = $r['applicant_id'];
		$temp[$x]['comment'] = $r['comment'];
		$temp[$x]['date_interview'] = $r['date_interview'];
		$temp[$x]['time'] = $r['time'];
		$temp[$x]['alt_time'] = $r['alt_time'];
		$temp[$x]['alt_date_interview'] = $r['alt_date_interview'];
		$temp[$x]['time_zone'] = $r['time_zone'];
		$temp[$x]["manila_time"] = $r["manila_time"];
		
		if (strtoupper($r["status"])=="CANCELLED"){
			$row = $db->fetchRow($db->select()->from(array("rqic"=>"request_for_interview_cancellations"), array("reason"))->where("rqic.request_for_interview_id = ?", $r["id"]));
			if ($row){
				$status = $row["reason"];
				if ($status=="STAFF NO SHOW"){
					$status = "Staff No Show";
				}else if ($status=="CLIENT NO SHOW"){
					$status = "Client No Show";
				}else if ($status=="STAFF CANCELLED"){
					$status = "Staff Cancelled";
				}else if ($status=="CLIENT CANCELLED"){
					$status = "Client Cancelled";
				}
				$temp[$x]["status"] = $status;
			}else{
				$temp[$x]['status'] = $r['status'];
			}
		}else{
			$temp[$x]['status'] = $r['status'];
		}
		
		if ($r["service_type"]=="ASL"){
			$job_category = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array())
					->joinLeft(array("jsc"=>"job_sub_category"),
						 "jsc.sub_category_id = jsca.sub_category_id", 
						 array("jsc.sub_category_id", "jsc.sub_category_name"))
					->where("jsca.id = ?", $r["job_sub_category_applicants_id"]));
			if ($job_category){
				$temp[$x]["job_sub_category"] = "<span style='font-weight:bold;color:#333'>".$job_category["sub_category_name"]."</span>";
			}else{
				$temp[$x]["job_sub_category"] = "";
			}
		}else{
			$job_category = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array())
							->joinInner(array("p"=>"posting"), "p.id = end.position", array("p.jobposition", "p.id AS posting_id"))
							->joinInner(array("gs_jtd"=>"gs_job_titles_details"), "p.job_order_id = gs_jtd.gs_job_titles_details_id", array("gs_jtd.selected_job_title"))
							->where("end.userid = ?", $r["applicant_id"])
							->where("end.client_name = ?", $r["leads_id"]));
			if ($job_category){
				$temp[$x]["job_sub_category"] = "<a href='/portal/Ad.php?id={$job_category["posting_id"]}' target='_blank' style='color:#000;font-weight:bold'>".$job_category["jobposition"]."</a>";
			}else{
				$temp[$x]["job_sub_category"] = "";
			}
		}
		
		
		
		$temp[$x]['payment_status'] = $r['payment_status'];
		$temp[$x]['booking_type'] = $r['booking_type'];
		$temp[$x]['date_added'] = $r['date_added'];
		$temp[$x]['fname'] = $r['fname'];
		$temp[$x]['lname'] = $r['lname'];
		$temp[$x]['voucher_number'] = $r['voucher_number'];
		$temp[$x]['session_id'] = $r['session_id'];
		$temp[$x]['location_id'] = $r['location_id'];
		$temp[$x]["service_type"] = $r["service_type"];
		$temp[$x]["date_updated"] = $r["date_updated"];
		$temp[$x]["notes"] = $db->fetchRow($db->select()->from(array("notes"=>"request_for_interview_notes"))->where("request_for_interview_id = ?",$r['id']));
		
		
		
		$temp[$x]["applicant_confirmed"] = $r["applicant_confirmed"];

		if($temp[$x]['voucher_number'] == "" || $temp[$x]['voucher_number'] == NULL)
		{
			$temp[$x]['date_expire'] = "";
			$temp[$x]['date_expire_status'] = "";
		}
		else
		{
			$name = $db->fetchRow("SELECT * FROM voucher WHERE code_number='".$temp[$x]['voucher_number']."' LIMIT 1");
			$temp[$x]['date_expire'] =$name["date_expire"];
			$temp[$x]['voucher_comment'] = $name["comment"];
			$today = date("Y-m-d");
			if($temp[$x]['date_expire'] == "" || $temp[$x]['date_expire'] == "0000-00-00")
			{
				$temp[$x]['date_expire'] = "0000-00-00";
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>No Expiration Date Assigned</font></strong>";
			}
			elseif($today <= $temp[$x]['date_expire'])
			{
				$temp[$x]['date_expire'] = $name["date_expire"];
				$temp[$x]['date_expire_status'] = "<strong>Active</strong>";
			}
			else
			{
				$temp[$x]['date_expire'] = $name["date_expire"];
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>Expired</font></strong>";
			}
		}	
		
		$temp[$x]['date_created'] = $name["date_created"];
		$temp[$x]['admin_id'] = $name["admin_id"];
		$temp[$x]['bp_id'] = $name["bp_id"];
		$temp[$x]['admin_name'] = "System Generated";
		
		//start: get leads location
		if($temp[$x]['location_id'] <> "" && $temp[$x]['location_id'] <> 0)
		{
			$leads_location =$db->fetchRow("SELECT location FROM leads_location_lookup WHERE id='".$temp[$x]['location_id']."' LIMIT 1");
			$leads_location = $leads_location["location"];
			$temp[$x]['leads_location'] = $leads_location;
		}		
		//ended: get leads location
		
		if($temp[$x]['admin_id'] <> "" && $temp[$x]['admin_id'] <> 0)
		{
			$name = $db->fetchRow("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$temp[$x]['admin_id']."' LIMIT 1");
			$fname = $name["admin_fname"];
			$lname = $name["admin_lname"];
			$temp[$x]['admin_name'] = $fname." ".$lname;
		}
		if($temp[$x]['bp_id'] <> "" && $temp[$x]['bp_id'] <> 0)
		{
			$name = $db->fetchRow("SELECT agent_no,fname,lname FROM agent WHERE agent_no='".$temp[$x]['bp_id']."' LIMIT 1");
			$fname = $name["fname"];
			$lname = $name["lname"];
			$temp[$x]['admin_name'] = $fname." ".$lname;
		}
		
		//start: get booking source
		$temp[$x]['booking_source'] = "";
		$s = $db->fetchRow("SELECT admin_id, agent_id FROM request_for_interview_portal WHERE request_for_interview_id='".$temp[$x]['id']."' LIMIT 1");
		$source_agent_id = $s["agent_id"];
		$source_admin_id = $s["admin_id"];
		if($source_admin_id <> 0 && $source_admin_id <> "")
		{
			$name = $db->fetchRow("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='$source_admin_id' LIMIT 1");
			$temp[$x]['booking_source'] = $name["admin_fname"]." ".$name["admin_lname"];
		}
		elseif($source_agent_id <> 0 && $source_admin_id <> "")
		{
			$name = $db->fetchRow("SELECT fname, lname FROM agent WHERE agent_no='$source_agent_id' LIMIT 1");
			$temp[$x]['booking_source'] = $name["fname"]." ".$name["lname"];			
		}
		//ended: get booking source
		
		$name = $db->fetchRow("SELECT fname, lname FROM leads WHERE id='".$temp[$x]['leads_id']."' LIMIT 1");
		$fname = $name["fname"];
		$lname = $name["lname"];
		$temp[$x]['client_name'] = $fname." ".$lname;
		
		$name = $db->fetchRow("SELECT fname, lname FROM personal WHERE userid='".$temp[$x]['applicant_id']."' LIMIT 1");
		$fname =$name["fname"];
		$lname = $name["lname"];
		$temp[$x]['applicant_name'] = $fname." ".$lname;

		//start: get calendar facilitator and client confirmation
		$row_a = $db->fetchRow("SELECT user_id, client_confirmed, applicant_confirmed FROM tb_app_appointment WHERE request_for_interview_id='".$temp[$x]['id']."'");
		if ($row_a){
			$name = $db->fetchRow("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$row_a["user_id"]."' LIMIT 1");
			$fname = $name["admin_fname"];
			$lname =  $name["admin_lname"];
			$temp[$x]['facilitator'] = "&nbsp;-&nbsp;".$fname." ".$lname."<br />";
			$temp[$x]["client_confirmed"] = $row_a["client_confirmed"];
			$temp[$x]["applicant_confirmed"] = $row_a["applicant_confirmed"];
		}
		
		if(!isset($temp[$x]['facilitator']))
		{
			$temp[$x]['facilitator'] = "None";
		}
		//ended: get calendar facilitator
													
		$x++ ;
	}
	return $temp ;
}
//ended: search asl interview

//start: asl interview pages
function linkpage($service_type,$booking_type,$payment_status,$date_requested1,$date_requested2,$date_updated1, $date_updated2, $date_interview_sched1, $date_interview_sched2, $time_interview_sched1,$time_interview_sched2, $key,$status,$p,$size,$d) 
{
	if (!isset($date_requested1)){
		$date_requested1 = "Any";
	}
	if (!isset($date_requested2)){
		$date_requested2 = "Any";
	}
	if (!isset($date_updated1)){
		$date_updated1 = "Any";
	}
	if (!isset($date_updated2)){
		$date_updated2 = "Any";
	}
	$max = $d ;
	$p2 = $p * $size ;
	if (isset($d)) 
	{
		if ($p == 1) $p1 = 1 ; 
		else $p1 = $p2 - $size + 1 ;
		if ($p2 > $max) $p2 = $max ;
		
		if ($p > 1) $pv = '<a href="?service_type='.$service_type.'&booking_type='.$booking_type.'&payment_status='.$payment_status.'&date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&date_updated1='.$date_updated1.'&date_updated2='.$date_updated2.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p-1).'&date_interview_sched1='.$date_interview_sched1.'&date_interview_sched2='.$date_interview_sched2.'&time_interview_sched_1='.$time_interview_sched1.'&time_interview_sched_2='.$time_interview_sched2.'"><font color="#000000">Prev</font></a>' ; 
		if ($p2 != $max) 
		{ 
			if (round($max / $size) > $p-0.5) $n = '<a href="?service_type='.$service_type.'&booking_type='.$booking_type.'&payment_status='.$payment_status.'&date_requested2='.$date_requested2.'&date_requested1='.$date_requested1.'&date_updated1='.$date_updated1.'&date_updated2='.$date_updated2.'&status='.$status.'&key='.$key.'&max='.$max.'&p='.($p + 1).'&date_interview_sched1='.$date_interview_sched1.'&date_interview_sched2='.$date_interview_sched2.'&time_interview_sched_1='.$time_interview_sched1.'&time_interview_sched_2='.$time_interview_sched2.'"><font color="#000000">Next</font></a>' ;
		}
		return $p1.'-'.$p2.' of '.$max.'&nbsp;&nbsp;'.@$pv.'&nbsp;|&nbsp;'.@$n.'&nbsp&nbsp&nbsp&nbsp' ;
	}
}
//ended: asl interview pages
//ENDED: functions


//START: loader
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search($booking_type,$payment_status,$date_requested1,$date_requested2,$date_updated1, $date_updated2, $date_interview_sched1, $date_interview_sched2, $time_interview_sched1, $time_interview_sched2, $key,$status,$p,$maxp,$max) ;
$pages = linkpage($service_type,$booking_type,$payment_status,$date_requested1,$date_requested2,$date_updated1, $date_updated2, $date_interview_sched1, $date_interview_sched2, $time_interview_sched1, $time_interview_sched2, $key,$status,$p,$maxp,$found[0]['max']) ;
//ENDED: loader


//START: caledar date picker jscript
$search_date_requested1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_requested2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';

$search_date_updated1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_updated2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';

$search_date_sched1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_interview_sched1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_interview_sched1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_sched2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_interview_sched2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_interview_sched2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';

//ENDED: caledar date picker jscript


//START: load report listings
$x = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;
if ($found[0]['max'] <> 0) 
{
	$total = count($found);
	$counter=0;
	for ($x=0; $x < $total; $x++) 
	{
			$counter++;
			//check the session_id if existing in `request_for_interview_job_order`
			$request_for_interview_job_order_id ="";
			$job_position_id = "";
			$job_order_flag ="";
			$applicant_job_order_id ="";
			$sql = $db->select()
				->from('request_for_interview_job_order' , 'id')
				->where('lead_id =?' ,$found[$x]['leads_id'])
				->where('session_id =?' ,$found[$x]['session_id']);
			$request_for_interview_job_order_id = $db->fetchOne($sql);
			if($request_for_interview_job_order_id){
					//id, request_for_interview_job_order_id, no_of_applicant, proposed_start_date, duration_status, jr_cat_id, category_id, sub_category_id, date_created, form_filled_up, date_filled_up
					$sql= $db->select()
						->from('request_for_interview_job_order_position')
						->where('request_for_interview_job_order_id =?' , $request_for_interview_job_order_id);
					$job_positions = $db->fetchAll($sql);
					foreach($job_positions as $job_position){
						//id, request_for_interview_job_order_position_id, userid, work_status, working_timezone, start_work, finish_work, app_working_details_filled_up, app_working_details_date_filled_up
						$sql = $db->select()
							->from('request_for_interview_job_order_applicants' , 'id')
							->where('request_for_interview_job_order_position_id =?' , $job_position['id'])
							->where('userid =?' , $found[$x]['applicant_id']);
						$applicant_job_order_id = $db->fetchOne($sql);
						if($applicant_job_order_id){
							$jr_cat_id = $job_position['jr_cat_id'];
							$job_position_id = $job_position['id'];
							break;
						}	
					}
				
			}	
			
			if ($found[$x]["client_confirmed"]=="Y"){
				$client_asterisk = "*";
			}else{
				$client_asterisk = "";
			}
			
			if ($found[$x]["applicant_confirmed"]=="Y"){
				$applicant_asterisk = "*";
			}else{
				$applicant_asterisk = "";
			}
			
			
			
			$report_listings .= '	
						  <tr bgcolor="'.$bgcolor.'">
						  <td align="left" valign="top" width="2%"><font color=#CCCCCC><strong>#</strong>'.$counter.'</font></td>
							<td align="left" valign="top" style="border-right: #006699 2px solid;" width="10%">
								<table cellpadding="2" cellspacing="2" bgcolor=#ffffff width=100%>
									<tr>
										<td colspan="2">
											<a href="javascript: lead('.$found[$x]['leads_id'].'); ">'.$found[$x]['client_name'].'</a>'." $client_asterisk".'<br>
										</td>
									</tr>
									<tr>
										<td>';
                                        
											
											if($admin_id <> "")
											{
											
												$report_listings .= '
												<table>
													<tr>
														<!--<td><a href="?key='.$key.'&date_requested1='.$date_requested1.'&date_requested2='.$date_requested2.'&status='.$status.'&stat=NEW&id='.$found[$x]['id'].'"><img src=\'../images/back.png\' border=0 alt=\'Move to Active List\'></a></td>-->
														<td><a href="javascript: update_status(\'ARCHIVED\','.$found[$x]['id'].'); "><img src=\'../images/forward.png\' border=0 alt=\'Move to Archived List\'></a></td>
														<!--<td><a href="?key='.$key.'&date_requested1='.$date_requested1.'&date_requested2='.$date_requested2.'&status='.$status.'&stat=ON-HOLD&id='.$found[$x]['id'].'"><img src=\'../images/userlock16.png\' border=0 alt=\'Move to On Hold\'></a></td>-->
														<td><a href="javascript: update_status(\'HIRED\','.$found[$x]['id'].'); "><img src=\'../images/adduser16.png\' border=0 alt=\'Move to Hired\'></a></td>
														<td><a href="javascript: update_status(\'REJECTED\','.$found[$x]['id'].'); "><img src=\'../images/deleteuser16.png\' border=0 alt=\'Move to Rejected\'></a></td>
														
														<td><a href="javascript: update_status(\'YET TO CONFIRM\','.$found[$x]['id'].'); "><img src=\'../images/yet-to-confirm.gif\' border=0 alt=\'Move Yet to confirm\'></a></td>
														<td><a href="javascript: update_status(\'CONFIRMED\','.$found[$x]['id'].'); "><img src=\'../images/confirmed.gif\' border=0 alt=\'Move to Confirmed\'></a></td>
														<td><a href="javascript: update_status(\'DONE\','.$found[$x]['id'].'); "><img src=\'../images/scheduled.gif\' border=0 alt=\'Move to Done, waiting for approval\'></a></td>
													</tr>
													<tr>	
														<td><a href="javascript: update_status(\'ON TRIAL\','.$found[$x]['id'].'); "><img src=\'../images/user_go.png\' border=0 alt=\'On Trial\'></a></td>
														<td><a href="javascript: update_status(\'CHATNOW INTERVIEWED\','.$found[$x]['id'].'); "><img src=\'../images/documentsorcopy16.png\' border=0 alt=\'Contract Page Set\'></a></td>
														<td><a href="javascript: rescheduled('.$found[$x]['applicant_id'].','.$found[$x]['leads_id'].','.$found[$x]['id'].'); "><img src=\'../images/re-scheduled.gif\' border=0 alt=\'Re-Scheduled\'></a></td>
														<td><a href="javascript: update_status(\'CANCELLED\','.$found[$x]['id'].'); " class="cancelled" data-id="'.$found[$x]['id'].'"><img src=\'../images/edit.gif\' border=0 alt=\'Cancel\'></a></td>
														
														
														<td><a href="javascript: meeting_calendar('.$found[$x]['applicant_id'].','.$found[$x]['leads_id'].','.$found[$x]['id'].'); "><img width="20" src="../images/calendar_ico.png" border="0" alt="Setup Schedule"></a></td>
													</tr>
												</table>
												';

											}											
			$report_listings .= '
										</td>
									</tr>                                    
								</table>
																
							</td>
							<td align="left" valign="top">';
							
									if($applicant_job_order_id)
									{
										//$report_listings .= "<span style='float:right;'><a href=javascript:popup_win('../../asl/ShowJobSpecAppWorkingDetails.php?id=$job_position_id&jr_cat_id=$jr_cat_id&applicant_id=$applicant_job_order_id&view=True',820,600);><img src='../images/flag_red.gif' border='0'></a></span>";
									}
									if($admin_id <> "")
									{
										$report_listings .= '<a href="javascript: resume('.$found[$x]['applicant_id'].'); ">'.$found[$x]['applicant_name'].'</a>'." $applicant_asterisk";
									}
									else
									{
										$report_listings .= '<a href="javascript: resume2('.$found[$x]['applicant_id'].'); ">'.$found[$x]['applicant_name'].'</a>'." $applicant_asterisk";
									}									
								
                            $report_listings.="<br/><br/>".$found[$x]["job_sub_category"];
							$report_listings .= '
							</td>
							<td align="left" valign="top">'.$found[$x]['facilitator'].'</td>                            
							<td align="left" valign="top">
								'.$found[$x]['booking_type'].'<br />
								'.$found[$x]['date_interview'].'<br />
								'.$found[$x]['time'].'<br/><br/>
								<strong>'.date("Y-m-d", strtotime($found[$x]['manila_time']))."<br/>".date("h:i a", strtotime($found[$x]['manila_time'])).' <br/><i>Asia/Manila</i></strong>
							</td>
							<td align="left" valign="top">
								'.$found[$x]['alt_date_interview'].'<br />
								'.$found[$x]['alt_time'].'
							</td>							
							<td align="left" valign="top">';

															switch($found[$x]['time_zone'])
															{
																case "PST8PDT":
																	$default_timezone_display = "America/San Francisco";
																	break;
																case "NZ":
																	$default_timezone_display = "New Zealand/Wellington";
																	break;
																case "NZ-CHAT":
																	$default_timezone_display = "New Zealand/Chatham_Islands";
																	break;
																default:
																	$default_timezone_display = $found[$x]['time_zone'];
																	break;
															}
															$report_listings .= $default_timezone_display; 
															$report_listings .= "<br />".$found[$x]['leads_location']; 
								 
							if (trim($found[$x]["notes"]["notes"])==""){
								$buttonText = "Add Note";
							}else{
								$buttonText = "Edit Notes";
							}
							$dateAdded = $found[$x]['date_added']." ";
							if ($found[$x]["date_updated"]&&$found[$x]["date_updated"]!="1970-01-01"){
								$dateAdded.="/".date("Y-m-d", strtotime($found[$x]["date_updated"]));
							}
							$contract_sent = $found[$x]["notes"]["contract_sent"];
							if ($found[$x]["notes"]["start_date"]=="0000-00-00"){
								$found[$x]["notes"]["start_date"] = "";
							}
							if (!is_null($contract_sent)&&$contract_sent){
								$sent = "Yes";
								if ($found[$x]["notes"]["contract_sent_date"]==""){
									$sent.="";
								}else{
									$sent.=", ";
								}
							}else{
								$sent = "No";
							}
							
							
							$client_contract_sent = $found[$x]["notes"]["client_contract_sent"];
							if (!is_null($client_contract_sent)&&$client_contract_sent){
								$client_sent = "Yes";
								if ($found[$x]["notes"]["client_contract_sent_date"]==""){
									$client_sent.="";
								}else{
									$client_sent.=", ";
								}
							}else{
								$client_sent = "No";
							}
							
							
							
							if ($found[$x]["notes"]["currency"]!=""){
								$currencyType = $db->fetchOne($db->select()->from("currency_lookup", "code")->where("id = ?", $found[$x]["notes"]["currency"]));
							}else{
								$currencyType = "";
							}
							$leads = $db->fetchRow($db->select()->from("leads", array("apply_gst"))->where("id = ?", $found[$x]['leads_id']));
							$gst = $leads["apply_gst"];
							if ($gst=="yes"){
								$gst = "Yes";
							}else{
								$gst = "No";
							}
							$noteBox = "<form class='notebox-form'><input type='hidden' name='id' value='{$found[$x]["notes"]["id"]}'/><input type='hidden' name='request_for_interview_id' value='{$found[$x]["id"]}'/><ul class='notebox'>";
								$noteBox .="<li><strong>Service Type</strong> <span class='contract-label'>{$found[$x]["notes"]["contract_type"]}</span></li>";
								$noteBox .="<li><strong>Staff Rate</strong> <span class='staffrate-label'>{$found[$x]["notes"]["staff_rate"]}</span></li>";
								$noteBox .="<li><strong>Charge Out</strong> <span class='chargeout-label'>{$found[$x]["notes"]["charge_out"]}</span></li>";
								$noteBox .="<li><strong>Currency</strong> <span class='currency-label'>{$currencyType}</span></li>";
								$noteBox .="<li><strong>GST</strong> <span class='gst-label'>{$gst}</span></li>";
								
								$noteBox .="<li><strong>Start Date</strong> <span class='startdate-label'>{$found[$x]["notes"]["start_date"]}</span></li>";
								$noteBox .="<li><strong>Status</strong> <span class='status-label'>{$found[$x]["notes"]["status"]}</span></li>";
								$noteBox .="<li><strong>Client Schedule</strong> <span class='schedule-label'>{$found[$x]["notes"]["schedule"]}</span></li>";
								$noteBox .="<li><strong>Designation</strong> <span class='designation-label'>{$found[$x]["notes"]["designation"]}</span></li>";
								$noteBox .="<li><strong>Client<br/> Contract Sent</strong> <span class='client_contract_sent-label'>$client_sent {$found[$x]["notes"]["client_contract_sent_date"]}</span></li>";
								$noteBox .="<li><strong>Staff<br/> Contract Sent</strong> <span class='contract_sent-label'>$sent {$found[$x]["notes"]["contract_sent_date"]}</span></li>";
								
								//$noteBox .="<li><strong>Invoice</strong> <span class='invoice-label'>{$found[$x]["notes"]["invoice"]}</span></li>";		
								$noteBox .="<li><strong>Client<br/> Docs Received</strong> <span class='docs-received-label'>{$found[$x]["notes"]["docs_received"]}</span></li>";		
								$noteBox .="<li><strong>Staff<br/> Docs Received</strong> <span class='staff-docs-received-label'>{$found[$x]["notes"]["staff_docs_received"]}</span></li>";		
								
								//$noteBox .="<li><strong>Staff<br/> Docs Pending</strong> <span class='docs-pending-label'>{$found[$x]["notes"]["docs_pending"]}</span></li>";		
								$noteBox .="<input type='hidden' value='{$found[$x]['leads_id']}' name='leads_id'/>";					
							$noteBox .= "</ul></form>";
							
							$feedbacks = $db->fetchAll($db->select()->from(array("rfis"=>"request_for_interview_feedbacks"))->where("rfis.request_for_interview_id = ?", $found[$x]['id'])->order("date_created DESC"));
							
							$feedback = "<ul style='padding-left:10px;'>";
							foreach($feedbacks as $feedback_item){
								$item = $feedback_item["feedback"];
								$item = substr($item, 0,100)."...";
								$deleteLink = "&nbsp;&nbsp;<a href='/portal/recruiter/delete_interview_request_feedback.php?id={$feedback_item["id"]}' class='delete_interview_feedback' data-id='{$feedback_item["id"]}'>Delete</a>";
								$feedback .= "<li id='feedback_{$feedback_item["id"]}' style='overflow:hidden;max-height:6em;line-height:1.5em;margin-bottom:10px;max-width:200px;word-wrap:break-word'><a href='/portal/recruiter/view_interview_feedback.php?id={$feedback_item["id"]}' class='view_feedback' style='color:#333;text-decoration:none'>".$item.$deleteLink."</a></li>";
							}
							$feedback .= "</ul>";
							
							$feedback .= "<button class='button add-feedback' data-interview-id='{$found[$x]["id"]}'>Add Feedback</button>";
							
							$report_listings .= '
                            </td>
                            <td align="left" valign="top">';
							
							
													switch ($found[$x]['status']) 
													{
														case "ACTIVE":
															$stat = "New";
															break;
														case "ARCHIVED":
															$stat = "Archived";
															break;
														case "ON-HOLD":
															$stat = "On Hold";
															break;															
														case "HIRED":
															$stat = "Hired";
															break;															
														case "REJECTED":
															$stat = "Rejected";
															break;		
														case "CONFIRMED":
															$stat = "Confirmed/In Process";	
															break;		
														case "YET TO CONFIRM":
															$stat = "Client contacted, no confirmed date";
															break;		
														case "DONE":
															$stat = "Interviewed; waiting for feedback";
															break;
														case "RE-SCHEDULED":
															$stat = "Confirmed/Re-Booked";
															break;	
														case "CANCELLED":
															$stat = "Cancelled";
															break;	
														case "CHATNOW INTERVIEWED":
															$stat = "Contract Page Set";
															break;	
														case "ON TRIAL":
															$stat = "On Trial";
															break;																
														default: 
															$stat = $found[$x]['status'];
															break;																																														
													}
								$report_listings .= '<table>';
								$report_listings .= '<tr><td valign=top><strong>-</strong></td><td><div id="status_details_'.$found[$x]['id'].'">'.$stat.'</div></td></tr>';
								/*
								if(isset($found[$x]['payment_status']))
								{
									if ($found[$x]['payment_status']=="PAID"){
										$report_listings .= '<tr><td valign=top><strong>-</strong></td><td><div id="payment_details_'.$found[$x]['id'].'">Paid</div></td></tr>';
										
									}else{
										$report_listings .= '<tr><td valign=top><strong>-</strong></td><td><div id="payment_details_'.$found[$x]['id'].'">Not Paid Payment Pending</div></td></tr>';
										
									}
								}
								 * 
								 */
								if($found[$x]['booking_source'] == "")
								{
									//do nothing
								}
								else
								{
									$report_listings .= "<tr><td valign=top><strong>-</strong></td><td>".$found[$x]['booking_source']."</td></tr>";
								}								
								
								$report_listings .= "</table>
                            </td>
                            <td align=\"left\" valign=\"top\">".$found[$x]['service_type']."</td>
							<td align=\"left\" valign=\"top\">".$dateAdded."</td>
							<td align=\"left\" valign=\"top\">".$feedback."</td>
							<td align=\"left\" valign=\"top\"><div class='notes_wrapper'><div id='notes_{$found[$x]["id"]}' class='notes-container'>$noteBox</div></div><a href='#' class='view-more-minimize' data-state='more'>[View More]</a><button class='add-edit-notes button' data-mode='AddEdit' data-request-id='{$found[$x]["id"]}'>Edit Notes</button></td>
							
						  </tr>";
						  
						if($counter_checker == 1)
						{
							$bgcolor = "#F5F5F5";
							$counter_checker = 0;
						}
						else
						{
							$bgcolor = "#E4E4E4";
							$counter_checker = 1;
						}	

	}
}
//ENDED: load report listings

$service_types = array("ANY", "ASL", "CUSTOM");
$service_type_options = "";
foreach($service_types as $type){
	if ($type==$service_type){
		$service_type_options .= "<option value='$type' selected>$type</option>";
	}else{
		$service_type_options .= "<option value='$type'>$type</option>";		
	}
}

//load admins for filter
$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE recruitment_support='Y' AND status <> 'REMOVED' ORDER by admin_fname";
$admins = $db->fetchAll($select);

$optionAdmin = "<option value='ALL'>All</option>";
foreach ($admins as $admin){
	if (isset($_GET["admin"])){
		if ($_GET["admin"]==$admin["admin_id"]){
			$optionAdmin.="<option value='{$admin["admin_id"]}' selected>{$admin["admin_fname"]} {$admin["admin_lname"]}</option>";
		}else{
			$optionAdmin.="<option value='{$admin["admin_id"]}'>{$admin["admin_fname"]} {$admin["admin_lname"]}</option>";
		}
	}else{
		$optionAdmin.="<option value='{$admin["admin_id"]}'>{$admin["admin_fname"]} {$admin["admin_lname"]}</option>";			
	}

}

$optionHours = array();
for($i=0;$i<=23;$i++){
	if ($i<10){
		if ($i==0){
			$optionHours[] = array("val"=>"0".$i.":00", "label"=>"12:00 AM");	
			$optionHours[] = array("val"=>"0".$i.":30", "label"=>"12:30 AM");
		}else{
			$optionHours[] = array("val"=>"0".$i.":00", "label"=>"0".$i.":00 AM");	
			$optionHours[] = array("val"=>"0".$i.":30", "label"=>"0".$i.":30 AM");	
		}
		
	}else if ($i==11||$i==12){
		$optionHours[] = array("val"=>$i.":00", "label"=>$i.":00 PM");	
		$optionHours[] = array("val"=>$i.":30", "label"=>$i.":30 PM");
	}else{
		if ($i%12<10){
			$optionHours[] = array("val"=>$i.":00", "label"=>"0".($i%12).":00 PM");	
			$optionHours[] = array("val"=>$i.":30", "label"=>"0".($i%12).":30 PM");
		}else{
			$optionHours[] = array("val"=>$i.":00", "label"=>($i%12).":00 PM");	
			$optionHours[] = array("val"=>$i.":30", "label"=>($i%12).":30 PM");
		}
		

	}
	
}

//recruiters and hms filter
$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR')  
			AND status <> 'REMOVED'
			AND admin_id <> 161 and admin_id <> 226 and admin_id <> 225 and admin_id <> 175 and admin_id <> 67
			ORDER by admin_fname";
$recruiters = $db->fetchAll($select); 

$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
$hms = $db->fetchAll($select);


$smarty->assign("recruiters", $recruiters);
$smarty->assign("hms", $hms);
$smarty->assign("selectedHM", $selectedHm);
$smarty->assign("selectedRecruiter", $selectedRecruiter);



$smarty->assign("optionAdmin", $optionAdmin);
$smarty->assign('key', $key);
$smarty->assign("service_type_options", $service_type_options);
$smarty->assign('booking_type', $booking_type);
$smarty->assign('date_requested1', $date_requested1);
$smarty->assign('date_requested2', $date_requested2);
$smarty->assign('date_interview_sched1', $date_interview_sched1);
$smarty->assign('date_interview_sched2', $date_interview_sched2);
$smarty->assign('time_interview_sched1', $time_interview_sched1);
$smarty->assign('time_interview_sched2', $time_interview_sched2);


$smarty->assign('search_date_requested1', $search_date_requested1);
$smarty->assign('search_date_requested2', $search_date_requested2);
$smarty->assign('search_date_updated1', $search_date_updated1);
$smarty->assign('search_date_updated2', $search_date_updated2);
$smarty->assign('search_date_sched2', $search_date_sched2);
$smarty->assign('search_date_sched1', $search_date_sched1);



$smarty->assign("option_hours", $optionHours);

if (!$date_updated1){
	$date_updated1 = date("Y-m-d", strtotime("-1 MONTH", strtotime(date("Y-m-d"))));
}

if (!$date_updated2){
	$date_updated2 = date("Y-m-d");
}

$smarty->assign('date_updated1', $date_updated1);
$smarty->assign('date_updated2', $date_updated2);

$smarty->assign('payment_status', $payment_status);
$smarty->assign('status', $status);
$smarty->assign('position_advertised', $position_advertised);
$smarty->assign('staff_status', $staff_status);
$smarty->assign('country_option', $country_option);
$smarty->assign('registered_date_check', $registered_date_check);
$smarty->assign('registered_key_type', $registered_key_type);
$smarty->assign('search_recruiter_options', $search_recruiter_options);
$smarty->assign('searched_result_listings', $searched_result_listings);
$smarty->assign('pages', $pages);
$smarty->assign('report_listings', $report_listings);
$smarty->assign('service_type_title', $_SESSION['service_type_title']);
$smarty->assign('service_type', $service_type);
$smarty->display('request_for_interview.tpl');
?>