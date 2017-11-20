<?php
include '../../config.php';
include '../../conf.php';

$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = 1;


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



$job_order_form_title = "Accounts Bookkeeper Job Order Form";
$job_order_form_desc = "In order for us to recruit accordingly and get the best staff suited to your business needs please rate the list of skills below as per your requirements. Please cross out the skills that won’t be needed and insert comments if and when needed. <br />Below are the Technical Key Competencies for an Accounts/Administration/Bookkeeper/ Finance Staff. ";

//SELECT * FROM job_order_list j;
// job_order_list_id, job_order_id, job_order_form_id, no_of_staff, staff_start_date, duties_responsibilities, others, additional_essentials

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
  <div>
	<div style="border:#999999 solid 1px; width:300px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:200px; ">&nbsp;General</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('general_add_form');" />
				</div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="general_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="general_skill" name="general_skill" class="select"  />
			<select id="general_skill_rating" name="general_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveGeneralSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('general_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;MS Office Skills</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="ms_office_skill_rating" name="ms_office_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Computer Skills</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="computer_skill_rating" name="computer_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
		  </div>	
		
		</div>
		<? } ?>
		<div id="general">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'general';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'general',201,1);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			 ?>
		</div>
	</div>
	
	<div style="border:#999999 solid 1px; width:280px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:180px; ">&nbsp;Accounts/Clerk</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('accounts_clerk_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="accounts_clerk_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="accounts_clerk_skill" name="accounts_clerk_skill" class="select"  />
			<select id="accounts_clerk_skill_rating" name="accounts_clerk_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveAccountsClerk(181);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('accounts_clerk_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;Invoicing</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="invoicing_skill_rating" name="invoicing_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;Purchasing</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="purchasing_skill_rating" name="purchasing_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;Payroll</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="payroll_skill_rating" name="payroll_skill_rating" style="font:12px tahoma; width:40px;"  >
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
					
		
		</div>
		<? } ?>
		<div id="accounts_clerk">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'accounts_clerk';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'accounts_clerk',181,1);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			 ?>
		</div>
	
	</div>
	
	<div style="border:#999999 solid 1px; width:300px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:200px; ">&nbsp;Accounts Receivable</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('accounts_receivable_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="accounts_receivable_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="accounts_receivable_skill" name="accounts_receivable_skill" class="select"  />
			<select id="accounts_receivable_skill_rating" name="accounts_receivable_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveAccountsReceivableSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('accounts_receivable_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;Debtor Account Reconciliation</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="acct_recon_skill_rating" name="acct_recon_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Debtor Analysis</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="debtor_skill_rating" name="debtor_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>
		
		</div>
		<? } ?>
		<div id="accounts_receivable">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'accounts_receivable';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'accounts_receivable',201,1);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			
			 ?>
		</div>
	</div>
	<div style="border:#999999 solid 1px; width:300px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:200px; ">&nbsp;Accounts Payable</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('accounts_payable_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="accounts_payable_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="accounts_payable_skill" name="accounts_payable_skill" class="select"  />
			<select id="accounts_payable_skill_rating" name="accounts_payable_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveAccountsPayableSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('accounts_payable_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;Creditor Account Reconciliation</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="creditor_acct_recon_skill_rating" name="creditor_acct_recon_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Creditor Analysis</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="creditor_analysis_skill_rating" name="creditor_analysis_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>
		
		</div>
		<? } ?>
		<div id="accounts_payable">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'accounts_payable';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'accounts_payable',201,1);">X</a>&nbsp;&nbsp;</div>
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
	
	
	<div style="border:#999999 solid 1px; width:300px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:200px; ">&nbsp;Bookkeeper</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('bookkeeper_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="bookkeeper_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="bookkeeper_skill" name="bookkeeper_skill" class="select"  />
			<select id="bookkeeper_skill_rating" name="bookkeeper_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveBookkeeperSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('bookkeeper_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;General Ledger</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="general_ledger_skill_rating" name="general_ledger_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Knowledge of Aus GST</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="knows_gst_skill_rating" name="knows_gst_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;BAS Reporting</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="bas_reporting_skill_rating" name="bas_reporting_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Cash Flow  Analysis</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="cash_flow_analysis_skill_rating" name="cash_flow_analysis_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		
		</div>
		<? } ?>
		<div id="bookkeeper">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'bookkeeper';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'bookkeeper',201,1);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }			
			 ?>
		</div>
	</div>
	<div style="border:#999999 solid 1px; width:280px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:180px; ">&nbsp;Accounting Package</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('accounting_package_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="accounting_package_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="accounting_package_skill" name="accounting_package_skill" class="select"  />
			<select id="accounting_package_skill_rating" name="accounting_package_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveAccountingPackage(181);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('accounting_package_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;MYOB</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="myob_skill_rating" name="myob_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;SAP</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="sap_skill_rating" name="sap_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;Quickbooks</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="quickbooks_skill_rating" name="quickbooks_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>
		
		</div>
		<? } ?>
		<div id="accounting_package">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'accounting_package';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'accounting_package',181,1);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }			
			 ?>
		</div>
	
	</div>
	<div style="border:#999999 solid 1px; width:300px; float:left; margin-left:5px;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:200px; ">&nbsp;Payroll</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('payroll_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="payroll_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="payroll_skill" name="payroll_skill" class="select"  />
			<select id="payroll_skill_rate" name="payroll_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="savePayrollSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('payroll_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;PAYG</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="payg_skill_rating" name="payg_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Superannuation</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="superannuation_skill_rating" name="superannuation_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Payroll Tax</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="payroll_tax_skill_rating" name="payroll_tax_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">&nbsp;</div>
						<div style="clear:both;"></div>
					</div>
		
		</div>
		<? } ?>
		<div id="payroll">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = 1 AND groupings = 'payroll';";
			$result = mysql_query($query);
			if(!$result) die("Error In Script . : $query ");
			$num_rows = mysql_num_rows($result);
			if($num_rows > 0) {
				while(list($job_order_details_id, $job_requirement, $rating)=mysql_fetch_array($result))
				{
				?>
					<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;<?=$job_requirement;?></div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
							<div style="float:left">&nbsp;&nbsp;<?=$rating;?></div>
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'payroll',201,1);">X</a>&nbsp;&nbsp;</div>
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
	
	<input id="btn" type="button" value="Submit Changes" onclick="saveJobOrderForm(1);" />
	<input id="btnc" type="button" value="Cancel" onclick="hideJobForms();" />
</div>