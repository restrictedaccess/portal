<?
include '../config.php';
include '../conf.php';
include '../time.php';

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
//$notes = $_REQUEST['notes'];

/*
evaluation
id, userid, created_by, evaluation_date, work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, asking_salary, notes
*/
$query = "INSERT INTO evaluation SET 
			userid = $userid, 
			created_by = $admin_id, 
			evaluation_date = '$ATZ', 
			work_fulltime = '$work_fulltime', 
			fulltime_sched = '$fulltime_sched', 
			work_parttime = '$work_parttime', 
			parttime_sched = '$parttime_sched', 
			work_freelancer = '$work_freelancer', 
			expected_minimum_salary = '$expected_minimum_salary';";
$result = mysql_query($query);			
if(!$result){
	die("MySQL Error : <br>" .$query."<br>".mysql_error());
}

echo "<div style = 'padding:5px;text-align:center;font:12px Arial;'><b>Evaluation Saved!</b></div>";

$queryApplicant="SELECT * FROM personal p  WHERE p.userid=$userid";
$data=mysql_query($queryApplicant);
$row = mysql_fetch_array ($data); 
$name =$row['fname']."  ".$row['lname'];

$timeNum = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
$timeArray = array("-","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
	if($starting_hours == $timeNum[$i])
	{
		$start_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$start_work_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	if($ending_hours == $timeNum[$i])
	{
		$finish_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$finish_work_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
}


$daynameArray = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
for($i=0;$i<count($daynameArray);$i++)
{
	$daysOptions.="<option value= ".$daynameArray[$i].">".$daynameArray[$i]."</option>";
}



/*
SELECT * FROM evaluation e; 
id, userid, created_by, evaluation_date, work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary, notes
*/

$sql = "SELECT id,DATE_FORMAT(evaluation_date,'%D %b %Y'), work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary FROM evaluation WHERE userid = $userid;";
$result = mysql_query($sql);
list($evaluation_id,$evaluation_date, $work_fulltime, $fulltime_sched, $work_parttime, $parttime_sched, $work_freelancer, $expected_minimum_salary)=mysql_fetch_array($result);

if($evaluation_date!=""){
	$evaluation_date = "<p><label>Evaluation Date</label>".$evaluation_date."</p>";
}

if($work_fulltime == "yes"){
	$work_fulltime = 'checked="checked"';
	$show_full_time_div = "style='display:block;'";
}else{
	$show_full_time_div = "style='display:none;'";
}

if($work_parttime == "yes"){
	$work_parttime = 'checked="checked"';
	$show_part_time_div = "style='display:block;'";
}else{
	$show_part_time_div = "style='display:none;'";
}

if ($work_freelancer == "yes"){
	$work_freelancer =  'checked="checked"';
	$show_freelancer_div = "style='display:block;'";
}else{
	$show_freelancer_div = "style='display:none;'";
}



$shift_Array = array("Morning-Shift","Afternoon-Shift","Night-Shift","Anytime");
for($i=0;$i<count($shift_Array);$i++){
	if($fulltime_sched == $shift_Array[$i]){
		$fulltime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
	}else{
		$fulltime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' value=".$shift_Array[$i]." ></p>";
	}
	
	if($parttime_sched == $shift_Array[$i])
	{
		$parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
	}else
	{
		$parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' value=".$shift_Array[$i]." ></p>";
	}
	
}


?>


<div style="padding:5px; background:#CCCCCC; border:#CCCCCC outset 1px; font:bold 12px Arial; color:#993300;">Applicants Evaluation Form</div>
	<div style="padding:5px; border:#CCCCCC solid 1px;font:12px Arial; background:#FFFFFF;">
		<p><b style="color:#0000FF;"><? echo $name;?></b></p>
		<?=$evaluation_date;?>
		<p><label>Expected Minimum Salary</label><input type="text" class="select" id="expected_minimum_salary" value="<?=$expected_minimum_salary;?>" ></p>
		<p><label>Willing to Work Full-Time </label><input type="checkbox" name="full_time_status" value="Full-Time" <?=$work_fulltime;?> onClick="checkCheckBoxes('full_time_status' , 'full_time_div');"  > Yes </p>
		
		<div id="full_time_div" <?=$show_full_time_div;?>>
		<p style="color:#999999;"><i>The Applicant must work a minimum of 9 hours a day with 1 hour lunch break 5 days a week </i></p>
		<?=$fulltime_shifts;?>
			
		</div>
		
		
		
		
		
		
	  <p><label>Willing to Work Part-Time </label>
	    <input type="checkbox" name="part_time_status" value="Part-Time" <?=$work_parttime;?> onClick="checkCheckBoxes('part_time_status' , 'part_time_div');" > 
      Yes </p>
		<div id="part_time_div" <?=$show_part_time_div;?>>
		<p style="color:#999999;"><i>The Applicant must work a minimum of 4 hours a day 5 days a week </i></p>
		<?=$parttime_shifts;?>
		
		</div>
		
		<!-- Freelancer time schedule -->
		
		<p><label>Willing to Work as a Freelancer </label><input type="checkbox" name="freelancer_status" value="Part-Time" <?=$work_freelancer;?> onClick="checkCheckBoxes('freelancer_status' , 'freelancer_div');" > Yes </p>
		<div id="freelancer_div" <?=$show_freelancer_div;?>>
		<p>Working Time</p>
		<p style="color:#999999;"><i>The Applicant must indicate his time availability </i></p>
			
		<p>
		<b>Days</b>
		<select name="days_freelancer" id="days_freelancer"   class="select" style="width:100px;">
			<?=$daysOptions;?>
		  </select>
		
		<b>Start :</b>
		  <select name="start_freelancer" id="start_freelancer"  onChange="setWorkHourPartTime();" class="select" style="width:100px;">
			<?=$start_work_hours_Options;?>
		  </select>
		 <b>Finish :</b> <select name="out_freelancer" id="out_freelancer" class="select" onChange="setWorkHourPartTime();" style="width:100px;">
			  <?=$finish_work_hours_Options;?>
		</select>
		&nbsp;<input type='text' name='hour_freelancer' id='hour_freelancer' style='color:#666666;width:20px;' value='' class='text' readonly="true"  />
		&nbsp;Total Working Hours
		&nbsp;<input type="button" value="Add" onClick="addFreelancerTimeSchedule();">
		<div id="freelancer_schedule_list" style="width:500px;">
		<div style="border:#CCCCCC outset 1px; font: 12px Arial; background:#CCCCCC; padding-top:2px; padding-bottom:2px;">
			<div style="float:left; width:90px; display:block;font: 12px Arial;"><b>Day</b></div>
			<div style="float:left; width:200px; display:block;font: 12px Arial;"><b>Schedule</b></div>
			<div style="float:left; width:60px; display:block;font: 12px Arial;"><b>Hour</b></div>
			<div class="refresh_btn"><b>Refresh</b></div>
			<div style="clear:both;"></div>
		</div>
		<?
		$sql = "SELECT id, day_name, start_str, finsh_str, hour FROM evaluation_freelancer_time_schedule WHERE userid = $userid ORDER BY day_id ASC;";
		$result = mysql_query($sql);
		while(list($id, $days, $start_str, $finsh_str, $hour)=mysql_fetch_array($result))
		{
		?>
			<div style="border-bottom:#CCCCCC solid 1px;font: 12px Arial;">
			<div style="float:left; width:90px; display:block;font: 12px Arial;"><?=$days;?></div>
			<div style="float:left; width:200px; display:block;font: 12px Arial;"><?=$start_str;?> - <?=$finsh_str;?></div>
			<div style="float:left; width:60px; display:block;font: 12px Arial;"><?=$hour;?></div>
			<div onClick="deleteFreelancerTimeSchedule(<?=$id;?>);" style="float:left; width:20px; display:block;font: 12px Arial; color:#0000FF; cursor:pointer;">X</div>
			<div style="clear:both;"></div>
			</div>
		<?
		}
		?>
		</div>
		</div>
		
		<div style="background:#E9E9E9; padding:10px; font:12px Arial; border:#CCCCCC solid 1px;">
		<p><span style="float:left;"><b>Add Evaluation Comments</b></span>
		  <span style="float:left; margin-left:10px;">
		  <input type="text" name="notes" id="notes"  style="width:430px;" />
		  </span><span style="float:left; margin-left:10px;">
		<input type="button" value="Add Comment" onclick="addComment()" /></span>
		<br style="clear:both;">
		</p>
		
		<div id="evaluation_comments_list">
	<div style='border:#000000 outset 1px; font: 12px Arial; background:#CCCCCC '>
		<div style='float:left; width:30px; display:block;font: 12px Arial;'><strong>#</strong></div>
		<div style='float:left; width:450px; display:block;font: 12px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'><strong>Comments / Notes</strong></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><strong>Date</strong></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><strong>Comment By</strong></div>
		<div style='clear:both;'></div>
	</div>
<?
$sql = "SELECT id, comments, DATE_FORMAT(comment_date,'%D %b %y'),a.admin_fname  FROM evaluation_comments e LEFT OUTER JOIN admin a ON a.admin_id = e.comment_by WHERE userid = $userid;";


//echo $sql;
$result = mysql_query($sql);
$counter = 0;
while(list($id, $comments, $date , $admin_fname)=mysql_fetch_array($result))
{
	$counter++;
	$comments = str_replace("\n","<br>",$comments);
 ?>
 
 <div style='border:#CCCCCC  solid 1px; font: 12px Arial; background:#FFFFFF '>
		<div style='float:left; width:30px; display:block;font: 12px Arial;'><?=$counter?></div>
		<div style='float:left; width:450px; display:block;font: 11px Arial;text-align:center;border-left:#000000 solid 1px; border-right:#000000 solid 1px;'>
		<?=$comments;?>
		</div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center;'><?=$date;?></div>
		<div style='float:left; width:80px; display:block;font: 12px Arial;text-align:center; border-left:#000000 solid 1px;'><?=$admin_fname?></div>
		<div title="Delete this comment" onClick="deleteComment(<?=$id;?>);" style="float:left; width:20px; display:block;font: 12px Arial; color:#0000FF; cursor:pointer;">X</div>
		<div style='clear:both;'></div>
	</div>
 
 <?
}

?>
		
		</div>
		</div>
		
		<p>
		<? if($evaluation_id==""){
			echo '<input type="button" value="Save" onClick="saveEvaluation();">';
		}else{
			echo '<input type="button" value="Update" onClick="updateEvaluation('.$evaluation_id.');">';
		}
		?>
		&nbsp;<input type="button" value="Cancel" onclick="show_hide('ctrl')" /></p>