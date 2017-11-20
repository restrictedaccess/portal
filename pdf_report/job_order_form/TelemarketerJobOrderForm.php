<?
include '../../config.php';
include '../../conf.php';

$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = 10;


//Check if the job_order_id existing in the  job_order_list then save if not do nothing...
// job_order_list_id, job_order_id, job_order_form_id, no_of_staff, staff_start_date, duties_responsibilities, others, additional_essentials, job_order_form_status
$sqlCheck = "SELECT * FROM job_order_list j WHERE job_order_id = $job_order_id AND  job_order_form_id = $job_order_form_id;";
$data = mysql_query($sqlCheck);
$ctr=@mysql_num_rows($data);
if ($ctr == 0 )
{
	$sqlJobOrderDetails = "INSERT INTO job_order_list SET job_order_id = $job_order_id, job_order_form_id =".$job_order_form_id;
	mysql_query($sqlJobOrderDetails);
}else{
	$row = mysql_fetch_array($data);
	$job_order_form_status = $row['job_order_form_status'];
}





$job_order_form_title = "Telemarketer Job Order Form";
$job_order_form_desc = "The main responsibility of a Telemarketer is to create and foster goodwill among the clients. A Telemarketer shall make outbound calls to and receive inbound calls (whichever the client assigns), prepare daily report on calls results. It is also the duty of the telemarketer to qualify prospect and build relationships with clients through prompt, courteous, and professional service. A Telemarketer also handles and responds to incoming sales inquiries that are generated but not limited to advertising, direct mail, or referrals. The candidate for this position is a college graduate of any Business/Marketing or any related course, with minimum of 2 years  related work experience; must be fluent in English; has a sound knowledge of MS Applications. ";


$sql = "SELECT no_of_staff, staff_start_date, duties_responsibilities, others, additional_essentials,term_of_employment,notes,level_status FROM job_order_list j WHERE job_order_id = $job_order_id AND  job_order_form_id = $job_order_form_id;";
$data =mysql_query($sql);
if(!$data) die("Error In Script . : $sql ");
list($no_of_staff, $staff_start_date, $duties_responsibilities, $others, $additional_essentials,$term_of_employment,$notes,$level_status) = mysql_fetch_array($data);


$work_status = array("Part-Time","Full-Time");
for($i=0;$i<count($work_status);$i++){
	if ($term_of_employment==$work_status[$i])
	 {
	 	$work_statusOptions .="<option selected value= ".$work_status[$i].">".$work_status[$i]."</option>";
	 }
	 else
	 {
	 	$work_statusOptions .="<option value= ".$work_status[$i].">".$work_status[$i]."</option>";
	 }
}


//GEt Campaign Type

$query = "SELECT job_requirement  FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = 'campaign_type';";
$result = mysql_query($query);
list($campaign_type)=mysql_fetch_array($result);

$campaign_type_Array=array("Business to Business","Business to Consumer","Both");  
for ($i = 0; $i < count($campaign_type_Array); $i++) {
      if($campaign_type == $campaign_type_Array[$i])
      {
	 $campaign_type_options .= "<option selected value=\"$campaign_type_Array[$i]\">$campaign_type_Array[$i]</option>\n";
      }
      else
      {
	 $campaign_type_options .= "<option value=\"$campaign_type_Array[$i]\">$campaign_type_Array[$i]</option>\n";
      }
   }	

$level_Array = array('Entry-Level','Midrange-level','Advanced-Level');
for($i=0;$i<count($level_Array);$i++){
	if ($level_status==$level_Array[$i])
	 {
	 	$level_Options .="<option selected value= ".$level_Array[$i].">".$level_Array[$i]."</option>";
	 }
	 else
	 {
	 	$level_Options .="<option value= ".$level_Array[$i].">".$level_Array[$i]."</option>";
	 }
}

?>
<input type="hidden" id="job_order_form_status" value="<?=$job_order_form_status;?>" />
<div style="">
	<div style="text-align:center; background:#CCCCCC; padding:5px; border:#CCCCCC outset 1px; font:bold 18px Arial;"><?=$job_order_form_title;?></div>	
	<div style="text-align:justify; padding:5px;"><?=$job_order_form_desc;?></div>
</div>
<div style="border-top:#666666 solid 1px; padding-top:5px;" >
<div>
 <div style="float:left; margin-bottom:10px; padding:5px;">
 	<div>No of Staff</div>
	<input type="text" class="select" id="no_of_staff" value="<?=$no_of_staff;?>" />
 </div>
 <div style="float:left; margin-bottom:10px; padding:5px; margin-left:10px;">
 	<div>Expected Staff Start date</div>
	<input type="text" class="select" name="staff_start_date" id="staff_start_date" value="<?=$staff_start_date;?>"  >
 </div>
 <div style="float:left; margin-bottom:10px; padding:5px; margin-left:10px;">
 	<div>Duration of Contract</div>
	<select id="term_of_employment" class="select">
				<option value="-">Please Select</option>
				<?=$work_statusOptions;?>
				</select>
 </div>
 <div style="float:left; margin-bottom:10px; padding:5px; margin-left:10px;">
 	<div>Level Status</div>
	<select id="level_status" name="level_status" class="select">
				<option value="-">Please Select</option>
				<?=$level_Options;?>
				</select>
 </div>
 <div style="clear:both;"></div>
</div> 
<div>
	<div style="border:#999999 solid 1px; width:600px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:500px; ">&nbsp;Requirements: </div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('telemarketer_add_form');" />
				
				</div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="telemarketer_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="telemarketer_skill" name="telemarketer_skill" class="select" style="width:450px;" />
			<select id="telemarketer_skill_rating" name="telemarketer_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select>
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveTelemarketerSkills(501);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('telemarketer_add_form');" />
		</div>
		<div id="telemarketer">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = 'telemarketer';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:501px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'telemarketer',501,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }else{
			 	echo '<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:501px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:501px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:501px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>';			 	
			 }	 
			
			 ?>
		</div>
	</div>
	<div style="border:#999999 solid 1px; width:550px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:494px; ">&nbsp;Time Schedule: </div>
			<div style="float:left; width:50px; border-left:#999999 solid 1px; ">
				
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('time_sched_add_form');" />
				
				</div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="time_sched_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="time_sched_skill" name="time_sched_skill" class="select" style="width:450px;"  />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveTelemarketerTimeSched(495);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('time_sched_add_form');" />
		</div>
		<div id="time_sched">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = 'time_sched';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:495px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:50px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<? //=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'time_sched',495,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }else{
			 	echo '<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:495px; ">&nbsp;</div>
						<div style="float:left; width:50px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:495px; ">&nbsp;</div>
						<div style="float:left; width:50px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:495px; ">&nbsp;</div>
						<div style="float:left; width:50px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>';			 	
			 }	 
			
			 ?>
		</div>
	</div>
	<div style="clear:both;"></div>
  </div>
	
	<div style="margin-top:20px;">
	<div >
		<div style="float:left; margin-left:5px; width:201px;">Type of Campaign : </div>
		<div style="float:left; "><select id="campaign_type" class="select">
								<option value="">Please Select</option>
								<?
									echo $campaign_type_options;
								?>
								</select>

		</div>
		<div style="clear:both;"></div>
	</div>
		<div  style="margin-top:10px;">	
		  <div style="float:left; margin-left:5px; width:201px">Duties and Responsibilities: </div>
				
				<textarea id="duties_responsibilities" name="duties_responsibilities" class="select" rows="3" style="width:950px;" ><?=$duties_responsibilities;?></textarea>
		 
		   <div style="clear:both;"></div>
		</div> 
		<div style="margin-top:10px;">
			 <div style="float:left; margin-left:5px; width:201px">Other desirable/preferred skills, personal attributes and knowledge </div>
		 
				<textarea id="others" name="others" class="select" rows="3" style="width:950px;" ><?=$others;?></textarea>
		 
			<div style="clear:both;"></div>
		</div>
		<div style="margin-top:10px;">	
		  <div style="float:left; margin-left:5px; width:201px">Additional Essential qualifications, knowledge and skills required </div>
				
				<textarea id="additional_essentials" name="additional_essentials" class="select" rows="3" style="width:950px;" ><?=$additional_essentials;?></textarea>
		  
		   <div style="clear:both;"></div>
		</div> 
	  <div style="clear:both;"></div>
	  <div style="margin-top:20px;">	
		  <div style="float:left; margin-left:5px; width:201px; color:#990000;"><b>Comments / Special Instructions : </b></div>
				
				<textarea id="notes" name="notes" class="select" rows="3" style="width:950px;" ><?=$notes;?></textarea>
		 
		   <div style="clear:both;"></div>
		</div>
  </div>
	
	<input id="btn" type="button" value="Submit Changes" onclick="saveJobOrderForm(<?=$job_order_form_id;?>);" />
	<input id="btnc" type="button" value="Cancel" onclick="hideJobForms();" />
</div>