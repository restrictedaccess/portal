<?
include '../../config.php';
include '../../conf.php';

$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = 5;


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





$job_order_form_title = "Web Designer Job Order Form";
$job_order_form_desc = "The main responsibility is to conceptualize, design and develop professional layout and interface designs of websites, create “branding” materials to establish company identity and maintain websites on a daily basis. The Web Designer shall provide templates to ensure that materials have consistent format appearance. <br />
In order for us to recruit accordingly and get the best staff suited to your business needs please rate the list of skills below as per your requirements. Please cross out the skills that won’t be needed and insert comments if and when needed.   ";


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
			<div style="padding:5px;">Key Competencies for Web Designer:</div>
<div>

	<div style="border:#999999 solid 1px; width:900px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:800px; ">&nbsp;Web/Open Systems </div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_open_systems_add_form');" />
				</div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_open_systems_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_open_systems_skill" name="web_open_systems_skill" class="select" style="width:750px;"  />
			<select id="web_open_systems_skill_rating" name="web_open_systems_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select>
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebOpenSystemsSkills(801);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_open_systems_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;HTML</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="html_skill_rating" name="html_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div><div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;XHTML</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="xhtml_skill_rating" name="xhtml_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;Cascading Style Sheets (CCS)</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="css_skill_rating" name="css_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;Macromedia Flash</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="macromedia_skill_rating" name="macromedia_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;Wordpress</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="wordpress_skill_rating" name="wordpress_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;Mambo / Joomla </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="mambo_skill_rating" name="mambo_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select></div>
							<div style="float:right">&nbsp;</div>
						<div style="clear:both;"></div>
						</div>
						<div style="clear:both;"></div>
					</div>
				<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>	
		
		</div>
		<? } ?>
		<div id="web_open_systems">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = 'web_open_systems';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:801px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_open_systems',801,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			 ?>
		</div>
	</div>
	
	<div style="clear:both;"></div>
  </div>
	
	<div style="margin-top:20px;">
		<div>	
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