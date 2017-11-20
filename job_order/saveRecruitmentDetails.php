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


$recruitment_details_id = $_REQUEST['recruitment_details_id'];
$leads_id =  $_REQUEST['leads_id'];
$job_order_id =  $_REQUEST['job_order_id'];
$job_order_form_id =  $_REQUEST['job_order_form_id'];
$job_order_list_id =  $_REQUEST['job_order_list_id'];

$recruitment_start_date = $_REQUEST['recruitment_start_date'];
$budget = $_REQUEST['budget'];
$set_up_fee_payment = $_REQUEST['set_up_fee_payment'];
$jd_link = $_REQUEST['jd_link'];
$comments = filterfield($_REQUEST['comments']);


function getCreator($id,$type){
	if($type == 'agent')
	{
		$query = "SELECT fname,work_status,lname FROM agent a WHERE agent_no = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[1]." :".$row[0]." ".$row[2];
	}
	else if($type == 'admin')
	{
		$query = "SELECT admin_fname , admin_lname FROM admin a WHERE admin_id = $id;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0]." ".$row[1];
	}
	else{
		$name="";
	}
	return $name;
}

if($recruitment_details_id==0 or $recruitment_details_id=="0"){
	
	$query = "INSERT INTO recruitment_details SET 
				job_order_id = $job_order_id, 
				job_order_form_id = $job_order_form_id, 
				leads_id = $leads_id, 
				job_order_list_id = $job_order_list_id, 
				recruitment_start_date = '$recruitment_start_date', 
				set_up_fee_payment = '$set_up_fee_payment', 
				budget = '$budget', 
				jd_link = '$jd_link', 
				created_by_id = $admin_id, 
				created_by_type = 'admin' , 
				date_created = '$ATZ';";
	$result = mysql_query($query);
	if(!$result) die("Error in Script!");
	$recruitment_details_id = mysql_insert_id();
	
	if($comments!="" or $comments!=""){
		
		$query = "INSERT INTO recruitment_details_notes SET 
					recruitment_details_id = $recruitment_process_id, 
					added_by_id = $admin_id, 
					added_by_type = 'admin', 
					date_added = '$ATZ', 
					comments = '$comments';";
		mysql_query($query);
	}
	
	//echo "Details has been Saved!";
	//echo $recruitment_details_id;

}else{

	$query = "UPDATE recruitment_details SET 
				recruitment_start_date = '$recruitment_start_date', 
				set_up_fee_payment = '$set_up_fee_payment', 
				budget = '$budget', 
				jd_link = '$jd_link', 
				last_update_date = '$ATZ', 
				updated_by_id = $admin_id, 
				updated_by_type = 'admin'
				WHERE recruitment_details_id = $recruitment_details_id;";
	$result = mysql_query($query);
	//echo $query;
	if(!$result) die("Error in Script!");
	

	if($comments!="" or $comments!=""){
		$sql = "INSERT INTO recruitment_details_notes SET 
					recruitment_details_id = $recruitment_details_id, 
					added_by_id = $admin_id, 
					added_by_type = 'admin', 
					date_added = '$ATZ', 
					comments = '$comments';";
		mysql_query($sql);
	}
	//echo $sql;
	//echo $recruitment_details_id;
	//echo "Details has been Saved!";
}


$query = "SELECT recruitment_details_notes_id, added_by_id, added_by_type, DATE_FORMAT(date_added,'%a %b %e %Y %r'), comments FROM recruitment_details_notes r WHERE recruitment_details_id = $recruitment_details_id ORDER BY date_added DESC;";
$data = mysql_query($query);		
while(list($recruitment_details_notes_id, $added_by_id, $added_by_type, $date_added, $comments)=mysql_fetch_array($data))
{
	?>
	<div style="border-bottom:#CCCCCC solid 1px; padding:2px;">
		<div style="text-align:right; color:#666666;font:11px tahoma;"><?=$date_added;?></div>
		<div><?=$comments;?></div>
		<div style="color:#999999; font:11px tahoma;"><?=getCreator($added_by_id, $added_by_type);?></div>
	</div>	
	<?
}
?>