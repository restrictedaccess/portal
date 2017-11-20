<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}



$leads_id =  $_REQUEST['leads_id'];
$job_order_id =  $_REQUEST['job_order_id'];
$job_order_form_id =  $_REQUEST['job_order_form_id'];
$job_order_list_id =  $_REQUEST['job_order_list_id'];

$userid = $_REQUEST['userid'];
$candidate_status = $_REQUEST['candidate_status'];

$expected_salary = filterfield($_REQUEST['expected_salary']);
$notes = filterfield($_REQUEST['notes']);


//echo $userid;

$query = "INSERT INTO recruitment_candidates SET 
						userid = $userid, 
						expected_salary = '$expected_salary', 
						candidate_status = '$candidate_status', 
						added_by_id = $admin_id, 
						added_by_type = 'admin', 
						date_added = '$ATZ', 
						leads_id = $leads_id, 
						job_order_id = $job_order_id, 
						job_order_form_id = $job_order_form_id, 
						job_order_list_id = $job_order_list_id ;";
						
$result = mysql_query($query);
$recruitment_candidates_id = mysql_insert_id();

if($recruitment_candidates_id!=NULL and $notes!="")
{
	$query = "INSERT INTO recruitment_candidates_notes SET  
				recruitment_candidates_id = $recruitment_candidates_id, 
				added_by_id = $admin_id, 
				added_by_type = 'admin', 
				date_added = '$ATZ', 
				notes = '$notes',
				userid = $userid;";
	$result =  mysql_query($query);	
			
}

?>