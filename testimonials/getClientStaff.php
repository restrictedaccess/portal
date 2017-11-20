<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id = $_REQUEST['leads_id'];
$query="SELECT fname,lname,company_name,logo_image FROM leads WHERE id=$leads_id;";
$data=mysql_query($query);
list($fname,$lname, $company_name , $logo_image) = mysql_fetch_array ($data); 
$client_name = $fname." ".substr($lname,0,1).".";
//echo $leads_id;

if($logo_image==""){
	$logo_image = "images/company_image.png";
}

$queryStaff="SELECT DISTINCT(u.userid), CONCAT(u.fname,' ',SUBSTRING(u.lname,1,1),'.'),u.image,c.latest_job_title
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		LEFT OUTER JOIN currentjob c ON c.userid = u.userid
		WHERE s.leads_id = $leads_id AND s.status='ACTIVE' ORDER BY u.fname ASC;";
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
while(list($userid, $staff_name, $image ,$latest_job_title )=mysql_fetch_array($result))
{
	
	//Check if this userid and leads_id already exist in the testimonial_display info
	$sqlDisplay = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $leads_id AND for_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon';";
	//echo $sqlDisplay;	
	$resulDisplay = mysql_query($sqlDisplay);
	if(!$resulDisplay) die ("Error in Script.\n".$sqlDisplay);	
	if(mysql_num_rows($resulDisplay) > 0){
		$row = mysql_fetch_array($resulDisplay);	
		$display_name = $row['display_name'];
		$display_desc = $row['display_desc'];
		$client_display_id = $row['id'];
	}else{
		$display_name = $client_name;
		$display_desc = $company_name;
		$client_display_id = 0;
	}
	
	//
	$sqlDisplay2 = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads';";
	//echo $sqlDisplay;	
	$resulDisplay2 = mysql_query($sqlDisplay2);
	if(!$resulDisplay2) die ("Error in Script.\n".$sqlDisplay2);	
	if(mysql_num_rows($resulDisplay2) > 0){
		$row2 = mysql_fetch_array($resulDisplay2);	
		$staff_display_name = $row2['display_name'];
		$staff_display_desc = $row2['display_desc'];
	}else{
		$staff_display_name = $staff_name;
		$staff_display_desc = $latest_job_title;
	}

	?>
		<div class="staff_box">
		<div style="padding:5px;">
			<div class="staff_image">
				<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>" height="105" width="90"  />
			</div>
			<div class="staff_info">
				<div class="staff_name"><?=$staff_display_name;?></div>
				<div class="staff_job_title"><?=$staff_display_desc;?></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div style="text-align:right; margin:0px;"><span style="background:#73BECE; padding:2px;width:120px; font:7.9pt Arial;">Staff Feedback</span></div>
		<div class="staff_testi" style="border-top:#73BECE solid 2px;">
		<?
			$queryStaffTestimonials = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony 
								  FROM testimonials 
								  WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads' 
								  AND testimony_status = 'posted'
								  ORDER BY date_created DESC;";
			$dataStaffTestimonials = mysql_query($queryStaffTestimonials);	
			if(!$dataStaffTestimonials) die ("Error in Script : <br>".$queryStaffTestimonials);
			while(list($staff_testimony_id, $staff_testimony_status, $staff_date_created, $staff_date_posted, $staff_testimonials)=mysql_fetch_array($dataStaffTestimonials))
			{
				?>
						<div id="staff_testimony_id_<?=$staff_testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
							<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
								<div style="float:left;">Status : <?=strtoupper($staff_testimony_status);?></div>
								<div style="float:right;">Date Created : <?=$staff_date_created;?></div>
								<div style="clear:both"></div>
							</div>
							<div style="padding:5px;"><?=str_replace("\n","<br>",$staff_testimonials);?></div>
						</div>
				<?
				}
			
			?>
		</div>
		<div style="text-align:right; margin-top:10px; border-bottom:#73BECE solid 2px;"><span style="background:#73BECE; padding:2px; width:120px; font:7.9pt Arial;">Client Feedback</span></div>
		
		<div style="padding:5px; ">
			<div class="staff_image">
				<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$logo_image";?>" height="105" width="90" style="cursor:pointer;" onclick="showImageUploadForm(<?=$userid;?>);"  />
				<div id="image_form_<?=$userid;?>" style="position:absolute;"></div>
			</div>
			<div class="staff_info">
				<div class="staff_name"><?=$display_name;?></div>
				<div class="staff_job_title"><?=$display_desc;?></div>
				<div style="margin-top:10px;"><a class="info_display_link"  href="javascript:editClientInfoDisplay(<?=$userid;?>,<?=$client_display_id;?>);">Edit Display Info</a></div>
				<div id="client_info_details_id_<?=$userid;?>"></div>
			</div>
			<div style="clear:both;"></div>
			<!--
			<div style="text-align:right;"><a href="javascript:showTestimonialForm(<? //=$userid;?>,0)" class='testi_link'/>Add</a></div>
			-->
			<div id='show_testimonial_form_for_<?=$userid;?>' style="display:none;"></div>		 
			<div class="staff_testi" style="border-top:#73BECE solid 2px;">
			<div id="client_testimonial_for_<?=$userid;?>">
			<?
			$queryTestimonials = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony , created_by_id, created_by_type 
								  FROM testimonials 
								  WHERE for_id = $leads_id AND for_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon' 
								  ORDER BY date_created DESC;";
			$data = mysql_query($queryTestimonials);	
			if(!$data) die ("Error in Script : <br>".$queryTestimonials);
			if(mysql_num_rows($data) > 0) {
				while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials,$created_by_id, $created_by_type)=mysql_fetch_array($data))
				{
					?>
						<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
							<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
								<div style="float:left;">Status : <?=strtoupper($testimony_status);?> Date Created : <?=$date_created;?></div>
								<div style="float:right;">
								<? if ($created_by_id == $leads_id and $created_by_type == "leads") {?>
								<a href="javascript:showTestimonialForm(<?=$userid;?>,0)" />
								<img src="./images/add.gif" border="0" />
								</a>
								<a href='javascript:showTestimonialForm(<?=$userid;?>,<?=$testimony_id;?>)' />
								<img src="./images/b_edit.png" border="0" />
								</a>
								<a href='javascript:deleteTestimonial(<?=$userid;?>,<?=$testimony_id;?>)' />
								<img src="./images/delete.png" border="0" />
								</a>
								<? } else { echo "&nbsp;";}?>
								</div>
								<div style="clear:both"></div>
							</div>
							<div style="padding:5px;"><?=str_replace("\n","<br>",$testimonials);?></div>
						</div>
					<?
				}
			}else {
			?>
			<!-- if the staff has no testimonial -->
				<div style='text-align:center; padding:35px;'>			
				Your Sub-Contractor and RemoteStaff are waiting on your feedback message<br />
						 <a href="javascript:showTestimonialForm(<?=$userid;?>,0)" />create</a>					 
				</div>		 
				
			<? } ?>
			</div>
		</div>
		
		</div>
	</div>
	<?
}

?>