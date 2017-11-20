<?
include '../../config.php';
include '../../conf.php';

$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = 12;


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






$job_order_form_title = "Others Job Order Form";
$job_order_form_desc = "&nbsp;";



//job_order_list_id, job_order_id, job_order_form_id, no_of_staff, staff_start_date, duties_responsibilities, others, additional_essentials, job_order_form_status, primary_role, secondary_role, term_of_employment, preffered_work_schedule, notes
$sql = "SELECT no_of_staff, staff_start_date, duties_responsibilities, others, additional_essentials,primary_role, secondary_role,term_of_employment,notes,level_status FROM job_order_list j WHERE job_order_id = $job_order_id AND  job_order_form_id = $job_order_form_id;";
$data =mysql_query($sql);
if(!$data) die("Error In Script . : $sql ");
list($no_of_staff, $staff_start_date, $duties_responsibilities, $others, $additional_essentials ,$primary_role, $secondary_role,$term_of_employment,$notes,$level_status) = mysql_fetch_array($data);


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
	<div style="text-align:center; padding:5px;"><?=$job_order_form_desc;?></div>
</div>
<div style="border-top:#666666 solid 1px; padding-top:5px;" >
<div>
 <div style="float:left; margin-bottom:10px; padding:5px;">
 	<div>Job Title &amp; no. of Staff</div>
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
			
	<div style="margin-top:20px;">
	<b>1.	Position Objectives:</b>
	<div style="margin-top:10px;">	
		  <div style="float:left; margin-left:5px; width:201px">Role primary objective : </div>
				
				<textarea id="primary_role" name="primary_role" class="select" rows="3" style="width:950px;" ><?=$primary_role;?></textarea>
		 
		   <div style="clear:both;"></div>
		</div>
		<div style="margin-top:10px;">	
		  <div style="float:left; margin-left:5px; width:201px">Role secondary objective :  </div>
				
				<textarea id="secondary_role" name="secondary_role" class="select" rows="3" style="width:950px;" ><?=$secondary_role;?></textarea>
		 
		   <div style="clear:both;"></div>
		</div>
	</div>		
			
			
			
			
			
			
			
			
			
			
<div style="margin-top:20px;">
		<div>	
		  <div style="float:left; margin-left:5px; width:201px"><b>2 .Duties and Responsibilities : </b></div>
				
				<textarea id="duties_responsibilities" name="duties_responsibilities" class="select" rows="3" style="width:950px;" ><?=$duties_responsibilities;?></textarea>
		 
		   <div style="clear:both;"></div>
		</div> 
		<div style="margin-top:10px;">
			 <div style="float:left; margin-left:5px; width:201px"><b>3. Other desirable/preferred skills, personal attributes and knowledge </b></div>
		 
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