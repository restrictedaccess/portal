<?php
include '../../config.php';
include '../../conf.php';
include '../../time.php';
include('../../conf/zend_smarty_conf.php');
include('../../lib/staff_history.php');
//staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', $status);

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
$admin_id = $_SESSION['admin_id'];
$userid =$_REQUEST['userid'];
$expected_minimum_salary = $_REQUEST['expected_minimum_salary'];
$work_fulltime = $_REQUEST['work_fulltime'];
$fulltime_sched = $_REQUEST['fulltime_sched'];
$work_parttime =  $_REQUEST['work_parttime'];
$parttime_sched=$_REQUEST['parttime_sched'];
$work_freelancer= $_REQUEST['work_freelancer'];
$experienced= $_REQUEST['experienced'];
$hot= $_REQUEST['hot'];


if($hot == "yes")
{
	$ctr=$db->fetchRow("SELECT id FROM hot_staff WHERE userid = '$userid'");
	if (!$ctr)
	{
		$db->insert("hot_staff", array("userid"=>$userid));
		
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'HOT', 'INSERT', '');
	}
}
else
{
	$ctr=$db->fetchRow("SELECT id FROM hot_staff WHERE userid = '$userid'");
	if ($ctr)
	{
		$db -> delete('hot_staff',$db->quoteInto("userid=?", $userid));	
		//$result = mysqli_query($link2,"DELETE FROM hot_staff WHERE userid='$userid'");
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'HOT', 'DELETE', '');
	}
}


if($experienced == "yes")
{
	$ctr=$db->fetchRow("SELECT id FROM experienced_staff WHERE userid = '$userid'");
	//$ctr=@mysqli_num_rows($res);
	if (!$ctr)
	{	
		$db->insert("experienced_staff", array("userid"=>$userid));	
		//mysqli_query($link2,"INSERT INTO experienced_staff (userid) VALUES ($userid)");
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'EXPERIENCED', 'INSERT', '');
	}
}
else
{
	$ctr=$db->fetchRow("SELECT id FROM experienced_staff WHERE userid = '$userid'");	
	//$res=mysqli_query($link2,"SELECT id FROM experienced_staff WHERE userid = '$userid'");
	//$ctr=@mysqli_num_rows($res);
	if ($ctr)
	{
		$db -> delete('experienced_staff',$db->quoteInto("userid=?", $userid));		
		//$result = mysqli_query($link2,"DELETE FROM experienced_staff WHERE userid='$userid'");
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'EXPERIENCED', 'DELETE', '');
	}	
}


$ctr=$db->fetchRow("SELECT id FROM evaluation WHERE userid = $userid;");
//$res=mysqli_query($link2,$sql);
//$ctr=@mysqli_num_rows($res);
if ($ctr)
{
	/*$db = "	UPDATE evaluation SET 
				work_fulltime = '$work_fulltime', 
				fulltime_sched = '$fulltime_sched', 
				work_parttime = '$work_parttime', 
				parttime_sched = '$parttime_sched', 
				work_freelancer = '$work_freelancer', 
				expected_minimum_salary = '$expected_minimum_salary'
				WHERE userid = $userid;"; */
	$db -> update("evaluation", 
					array("work_fulltime"=>$work_fulltime,
						"fulltime_sched"=>$fulltime_sched,
						"work_parttime"=>$work_parttime,
						"parttime_sched"=>$parttime_sched,
						"work_freelancer"=>$work_freelancer,
						"expected_minimum_salary"=>$expected_minimum_salary), 
						$db->quoteInto("userid =?", $userid));				
				
	//START: add history
	if($work_fulltime <> "")
	{
		$changes_made = "WORK FULLTIME/SCHEDULE(".$work_fulltime."/".$fulltime_sched.")<br />WORK PARTTIME/SCHEDULE(".$work_parttime."/".$parttime_sched.")<br />WORK FREELANCER(".$work_freelancer.")&nbsp;&nbsp;&nbsp;EXPECTED MINIMUM SALARY(".$expected_minimum_salary.")";
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'EVALUATION SECTION', 'UPDATE', $changes_made);				
	}
	//ENDED: add history	
	
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);		
	}else{
		file_get_contents("https://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
	}			
}
else
{
	/*$query = "INSERT INTO evaluation SET 
				userid = $userid, 
				created_by = $admin_id, 
				evaluation_date = '$ATZ', 
				work_fulltime = '$work_fulltime', 
				fulltime_sched = '$fulltime_sched', 
				work_parttime = '$work_parttime', 
				parttime_sched = '$parttime_sched', 
				work_freelancer = '$work_freelancer', 
				expected_minimum_salary = '$expected_minimum_salary';";	*/
				
	$db -> insert("evaluation", array("userid"=>$userid,
					"created_by"=>$admin_id,
					"evaluation_date"=>$ATZ,
					"work_fulltime"=>$work_fulltime,
					"fulltime_sched"=>$fulltime_sched,
					"work_parttime"=>$work_parttime,
					"parttime_sched"=>$parttime_sched,
					"work_freelancer"=>$work_freelancer,
					"expected_minimum_salary"=>$expected_minimum_salary));
					
	//START: add history
	if($work_fulltime <> "")
	{
		$changes_made = "WORK FULLTIME/SCHEDULE(".$work_fulltime."/".$fulltime_sched.")<br />WORK PARTTIME/SCHEDULE(".$work_parttime."/".$parttime_sched.")<br />WORK FREELANCER(".$work_freelancer.")&nbsp;&nbsp;&nbsp;EXPECTED MINIMUM SALARY(".$expected_minimum_salary.")";
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'EVALUATION SECTION', 'INSERT', $changes_made);				
	}
	
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);		
	}else{
		file_get_contents("https://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
	}
		
	//ENDED: add history
}		
include("showEvaluationForm.php");
?>