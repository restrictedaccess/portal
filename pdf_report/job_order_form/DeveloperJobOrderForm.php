<?php
include '../../config.php';
include '../../conf.php';

$job_order_id = $_REQUEST['job_order_id'];
$job_order_form_id = 6;


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





$job_order_form_title = "Web Developer Job Order Form";
$job_order_form_desc = "In order for us to recruit accordingly and get the best staff suited to your business needs please rate the list of skills below as per your requirements. Please cross out the skills that won’t be needed and insert comments if and when needed.  ";


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
			<div style="float:left; width:200px; ">&nbsp;Web Systems</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_systems_add_form');" />
				
				</div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_systems_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_systems_skill" name="web_systems_skill" class="select"  />
			<select id="web_systems_skill_rating" name="web_systemss_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebSystemsSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_systems_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;HTML</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_html_skill_rating" name="web_dev_html_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;XHTML</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_xhtml_skill_rating" name="web_dev_xhtml_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;ASP.Net</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_aspnet_skill_rating" name="web_dev_aspnet_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Classic ASP </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_asp_skill_rating" name="web_dev_asp_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;VB .Net</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_vbnet_skill_rating" name="web_dev_vbnet_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;PHP</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_php_skill_rating" name="web_dev_php_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;JavaScript</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_javascript_skill_rating" name="web_dev_javascript_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Cascading Style Sheets (CCS)</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_css_skill_rating" name="web_dev_css_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;IIS /  Apache</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_iis_skill_rating" name="web_dev_iis_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Macromedia Flash</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_flash_skill_rating" name="web_dev_flash_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;XML</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_xml_skill_rating" name="web_dev_xml_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;AJAX</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_ajax_skill_rating" name="web_dev_ajax_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Macromedia Dreamweaver</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_dreamweaver_skill_rating" name="web_dev_dreamweaver_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Macromedia Fireworks </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_fireworks_skill_rating" name="web_dev_fireworks_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;ColdFusion</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_coldfusion_skill_rating" name="web_dev_coldfusion_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;ActionScript </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_actionscript_skill_rating" name="web_dev_actionscript_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_systems">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id  AND groupings = 'web_systems';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_systems',201,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			
			 ?>
		</div>
	</div>
	<div style="float:left; margin-left:5px;">
	<div>
	<div style="border:#999999 solid 1px; width:280px; float:left;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:180px; ">&nbsp;Databases</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_databases_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_databases_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_databases_skill" name="web_databases_skill" class="select"  />
			<select id="web_databases_skill_rating" name="web_databases_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebDatabasesSkill(181);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_databases_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;MS Access</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_access_skill_rating" name="web_dev_access_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;SQL Server </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_sqlserver_skill_rating" name="web_dev_sqlserver_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;MySQL</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_mysql_skill_rating" name="web_dev_mysql_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_databases">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_databases';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_databases',181,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
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
			<div style="float:left; width:200px; ">&nbsp;App Programming Languages</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_programming_languages_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_programming_languages_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_programming_languages_skill" name="web_programming_languages_skill" class="select"  />
			<select id="web_programming_languages_skill_rating" name="web_programming_languages_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebProgrammingLanguagesSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_programming_languages_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;Visual Basic</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_vb_skill_rating" name="web_dev_vb_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Visual C# .net</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_cnet_skill_rating" name="web_dev_cnet_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_programming_languages">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_programming_languages';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_programming_languages',201,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
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
			<div style="float:left; width:200px; ">&nbsp;Open Source Software</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_open_source_software_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_open_source_software_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_open_source_software_skill" name="web_open_source_software_skill" class="select"  />
			<select id="web_open_source_software_skill_rating" name="web_open_source_software_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebOpenSourceSoftwareSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_open_source_software_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:201px; ">&nbsp;Wordpress</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_wordpress_skill_rating" name="web_dev_wordpress_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;Mambo / Joomla </div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_mambojoomla_skill_rating" name="web_dev_mambojoomla_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:201px; ">&nbsp;PHPBB2 or PHPBB3</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_phpbb_skill_rating" name="" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_open_source_software">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_open_source_software';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_open_source_software',201,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
						</div>
						<div style="clear:both;"></div>
					</div>
			<?
				 }
			 }
			 ?>
		</div>
	</div>
	</div>
	<div style="clear:both;"></div>
	<div style="margin-top:20px;">
	
	
	<div style="border:#999999 solid 1px; width:280px; float:left;">
		<div style=" line-height:20px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>
			<div style="float:left; width:180px; ">&nbsp;Platforms/Environments</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_platforms_environments_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_platforms_environments_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_platforms_environments_skill" name="web_platforms_environments_skill" class="select"  />
			<select id="web_platforms_environments_skill_rating" name="web_platforms_environments_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebPlatformsEnvironmentsSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_platforms_environments_add_form');" />
		</div>
	<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:181px; ">&nbsp;Windows Vista/XP/2000/NT</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_windows_skill_rating" name="web_dev_windows_skill_rating" style="font:12px tahoma; width:40px;"  >
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
						<div style="float:left; width:181px; ">&nbsp;UNIX / Linux</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
						<div style="float:left"><select id="web_dev_unixlinux_skill_rating" name="web_dev_unixlinux_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_platforms_environments">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_platforms_environments';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_platforms_environments',201,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
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
			<div style="float:left; width:200px; ">&nbsp;PC & Desktop Products</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_pc_desktop_products_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_pc_desktop_products_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_pc_desktop_products_skill" name="web_pc_desktop_products_skill" class="select"  />
			<select id="web_pc_desktop_products_skill_rating" name="web_pc_desktop_products_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebPcDesktopProductsSkills(200);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_pc_desktop_products_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:200px; ">&nbsp;Microsoft Office Suite</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_msoffice_skill_rating" name="web_dev_msoffice_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_pc_desktop_products">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_pc_desktop_products';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_pc_desktop_products',181,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
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
			<div style="float:left; width:200px; ">&nbsp;Multimedia</div>
			<div style="float:left; width:94px; border-left:#999999 solid 1px; ">
				<div style="float:left;">&nbsp;Rating</div>
				<div style="float:right;"><input type="button" value="add" style="font:10px tahoma; width:30px;" onclick="show_hide('web_multimedia_add_form');" /></div>
				<div style="clear:both;"></div>	
			</div>
			<div style="clear:both;"></div>
			</b>
		</div>
		<div id="web_multimedia_add_form" style="border:#000000 solid 1px; padding:3px; display:none;">
			<input type="text" id="web_multimedia_skill" name="web_multimedia_skill" class="select"  />
			<select id="web_multimedia_skill_rating" name="web_multimedia_skill_rating" style="font:12px tahoma; width:40px;"  >
				<option value="">--</option>
				<option value="5">5</option>

				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1</option>
				<option value="0">0</option>
			</select><br />
			<input type="button" value="save" style="font:11px tahoma; width:40px;" onclick="saveWebMultimediaSkill(201);" />
			<input type="button" value="cancel" style="font:11px tahoma; width:40px;" onclick="hide('web_multimedia_add_form');" />
		</div>
		<? if($job_order_form_status!="finished") {?>
		<div>
		<div style=" line-height:20px;  border-bottom:#CCCCCC solid 1px;">
						<div style="float:left; width:200px; ">&nbsp;Adobe PhotoShop / Illustrator</div>
						<div style="float:left; width:94px; border-left:#999999 solid 1px; text-align:center;">
						<div style="float:left"><select id="web_dev_photoshop_skill_rating" name="web_dev_photoshop_skill_rating" style="font:12px tahoma; width:40px;"  >
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
		<div id="web_multimedia">
			<?
			$query = "SELECT job_order_details_id, job_requirement, rating FROM job_order_details j WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'web_multimedia';";
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
							<div style="float:right"><a href="javascript:deleteJobOrderDetails(<?=$job_order_details_id;?>,'web_multimedia',201,<?=$job_order_form_id;?>);">X</a>&nbsp;&nbsp;</div>
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
	</div>
	<!-- here -->
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