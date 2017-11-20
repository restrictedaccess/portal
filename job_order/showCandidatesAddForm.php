<?
include "../config.php";
include "../conf.php";


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	die("Session Expired. Please Logout then try to re-login again.");
}


$recruitment_candidates_id = $_REQUEST['recruitment_candidates_id'];
//recruitment_candidates_id, userid, expected_salary, candidate_status, added_by_id, added_by_type, date_added, leads_id, job_order_id, job_order_form_id, job_order_list_id, ratings
$query = "SELECT userid, expected_salary, candidate_status FROM recruitment_candidates r WHERE recruitment_candidates_id = $recruitment_candidates_id;";
$result = mysql_query($query);
list($candidate, $expected_salary, $candidate_status)=mysql_fetch_array($result);

//echo "Status : ".$candidate_status;




$query = "SELECT userid,CONCAT(fname,' ',lname),email FROM personal p ORDER BY fname ASC;";
$result = mysql_query($query);
while(list($userid,$name,$email)=mysql_fetch_array($result))
{
	if($candidate == $userid){
		$applicant_Options.="<option value=".$userid." selected>".$name." -- ".$email."</option>";
	}else{
		$applicant_Options.="<option value=".$userid.">".$name." -- ".$email."</option>";
	}
}

$statusArray=array("HIRED","REJECTED","ENDORSED","UNDECIDED");
for($i=0;$i<count($statusArray);$i++){
	if($candidate_status == $statusArray[$i]){
		$status_Options.="<option value=".$statusArray[$i]." selected>".$statusArray[$i]."</option>";
	}else{
		$status_Options.="<option value=".$statusArray[$i]." >".$statusArray[$i]."</option>";
	}
	
}

?>


<div style="background:#F4F4F4; padding:5px; ">

	<p><label>Name</label>
	<select name="userid" id="userid" style="font:12px Tahoma; width:350px;" >
	<option value="0">--Please Choose Applicant--</option>
	<?=$applicant_Options;?>
	</select></p>
	<p><label>Status</label><select name="candidate_status" id="candidate_status" class="select">
	<option value="">--</option>
	<?=$status_Options;?>
	</select></p>
	<p><label>Expected Salary</label><input class="select" type="text" name="expected_salary" id="expected_salary" value="<?=$expected_salary;?>"></p>
	<? if ($recruitment_candidates_id > 0) { ?>
	<p><input type="button" value="Update" class="bttn" onClick="javascript:updateCandidate(<?=$recruitment_candidates_id;?>);"><input type="button" value="Close" class="bttn" onClick="hide('candidates_add_form');"></p>
	<? } else {?>
	
	<p><label>Notes</label><textarea name="notes" id="notes" style="width:800px; height:50px;"></textarea></p>
	<p><input type="button" value="Add" class="bttn" onClick="javascript:addCandidate();"><input type="button" value="Close" class="bttn" onClick="hide('candidates_add_form');"></p>
	<? }?>
	
</div>