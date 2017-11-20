<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$userid= $_REQUEST['id'];
$section = $_REQUEST['section'];


if($_SESSION['admin_id']=="")
{
	die("Admin Session ID already Expire! Please Re-Login !");
}
if($userid == ""){
	die("USERID is Missing.");
}

if($section == ""){
	die("Section is Missing.");
}


$queryStaff="SELECT CONCAT(u.fname,' ',SUBSTRING(u.lname,1,1),'.'),u.image,c.latest_job_title
		FROM personal u
		LEFT OUTER JOIN currentjob c ON c.userid = u.userid
		WHERE u.userid = $userid;";
//echo $queryStaff;		
$result=mysql_query($queryStaff);
if(!$result) die ("Error in Script.<br>".$queryStaff);
list($staff_name, $image ,$latest_job_title )=mysql_fetch_array($result);

$sqlClient="SELECT l.id, l.fname, l.lname, l.company_name,l.logo_image
			FROM subcontractors as s
			LEFT JOIN leads as l on s.leads_id = l.id
			WHERE userid= $userid  
			-- AND s.status = 'ACTIVE' 
			ORDER BY l.fname;";

//echo $sqlClient;
$resulta=mysql_query($sqlClient);
echo "<div>";
while(list($leads_id,$lead_fname,$lead_lname,$lead_company,$leads_image)=mysql_fetch_array($resulta))
{
	//Check if this userid and leads_id already exist in the testimonial_display info
	$sqlDisplay = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads';";
	//echo $sqlDisplay;	
	$resulDisplay = mysql_query($sqlDisplay);
	if(!$resulDisplay) die ("Error in Script.\n".$sqlDisplay);	
	if(mysql_num_rows($resulDisplay) > 0){
		$row = mysql_fetch_array($resulDisplay);	
		$display_name = $row['display_name'];
		$display_desc = $row['display_desc'];
		$staff_display_id = $row['id'];
	}else{
		$display_name = $staff_name;
		$display_desc = $latest_job_title;
		$staff_display_id = 0;
	}
	
	//
	$sqlDisplay2 = "SELECT * FROM testimonials_display_info 
		WHERE for_id = $leads_id AND for_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon';";
	//echo $sqlDisplay;	
	$resulDisplay2 = mysql_query($sqlDisplay2);
	if(!$resulDisplay2) die ("Error in Script.\n".$sqlDisplay2);	
	if(mysql_num_rows($resulDisplay2) > 0){
		$row = mysql_fetch_array($resulDisplay2);	
		$client_name = $row['display_name'];
		$client_company = $row['display_desc'];
		$client_display_id = $row['id'];
	}else{
		$client_name = $lead_fname." ".substr($lead_lname,0,1).".";;
		$client_company = $lead_company;
		$client_display_id = 0;
	}
	
	
	?>
	<div class="staff_box" >
		<div style="padding:5px;">
				<div class="staff_image">
					<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>" height="105" width="90"  />
				</div>
				<div class="staff_info">
					<div class="staff_name"><?=$display_name;?></div>
					<div class="staff_job_title"><?=$display_desc;?></div>
					<div style="margin-top:10px;"><a class="info_display_link"  href="javascript:editStaffInfoDisplay(<?=$leads_id;?>,<?=$userid;?>,<?=$staff_display_id;?>);">Edit Display Info</a></div>
				<div id="staff_info_details_id_<?=$leads_id;?>"></div>
				</div>
				<div style="clear:both;"></div>
		</div>
		<div style="text-align:right; margin:0px;"><span style="background:#73BECE; padding:2px;width:80px; font:7.9pt Arial;">Staff Feedback</span></div>
		<div id='show_testimonial_form_for_<?=$leads_id;?>' style="display:none;"></div>	
		<div id="staff_testimonial_for_<?=$leads_id;?>" class="staff_testi" style="border-top:#73BECE solid 2px;">
		<?
		//Staff Testimonial Section Starts here
		$queryTestimonials = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony , DATE_FORMAT(date_updated,'%D %b %y')
								  FROM testimonials 
								  WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads' 
								  ORDER BY date_created DESC;";
			$data = mysql_query($queryTestimonials);	
			if(!$data) die ("Error in Script : <br>".$queryTestimonials);
			if(mysql_num_rows($data) > 0) {
				while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials,$date_updated)=mysql_fetch_array($data))
				{
					if($testimony_status=="posted"){ 
						$date = "Posted : ".$date_posted ;
						$date .= " | Created : ".$date_created;
					}else if($testimony_status=="updated"){
						$date = "Updated : ".$date_updated ;
						$date .= " | Created : ".$date_created;
					}else{
						$date = "Created : ".$date_created;
					}
	
					?>
						<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
							<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
								<div style="float:left;"><b style="color:#FF0000">Status</b> : <b><?=strtoupper($testimony_status);?></b> <br><?=$date;?>  </div>
								<div style="float:right;">
								<a href="javascript:showAdminTestimonialForm(<?=$userid;?>,'subcon',<?=$leads_id;?>,'leads',0)" title="Add Testimonial" />
								Add
								</a>
								|
								<a href="javascript:showAdminTestimonialForm(<?=$userid;?>,'subcon',<?=$leads_id;?>,'leads',<?=$testimony_id;?>)" title="Edit Testimonial" />
								Edit
								</a>
								|
							<a href="javascript:deleteAdminTestimonial(<?=$userid;?>,'subcon',<?=$leads_id;?>,'leads',<?=$testimony_id;?>)" title="Delete Permanently this Testimonial" />
								Del
								</a>
								|
								<a href="javascript:approvedAdminTestimonial(<?=$userid;?>,'subcon',<?=$leads_id;?>,'leads',<?=$testimony_id;?>)" title="Approved / Cancel Testimonials" />
								Conf
								</a>
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
					 <a href="javascript:showAdminTestimonialForm(<?=$userid;?>,'subcon',<?=$leads_id;?>,'leads',0);" />Create</a>					 
				</div>		 
				
			<? }
		//Ends Here
		?>
		
		
		
		</div>	
		<div style="text-align:right; margin-top:10px; border-bottom:#73BECE solid 2px;">
		<span style="background:#73BECE; padding:2px; width:80px; font:7.9pt Arial;">Client Feedback</span>
		</div>
		
		<div style="padding:5px;">
				<div class="staff_image">
					<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$leads_image";?>" height="105" width="90"  />
				</div>
				<div class="staff_info">
					<div class="staff_name"><? //echo $leads_id;?> <?=$client_name;?></div>
					<div class="staff_job_title"><?=$client_company;?></div>
					<div style="margin-top:10px;"><a class="info_display_link"  href="javascript:editClientInfoDisplay(<?=$leads_id;?>,<?=$userid;?>,<?=$client_display_id;?>);">Edit Display Info</a></div>
				   <div id="client_info_details_id_<?=$userid;?>"></div>
				</div>
				<div style="clear:both;"></div>
		</div>
		<div id='show_testi_form_for_<?=$leads_id;?>' style="display:none;"></div>
		<div id="client_testimonial_<?=$leads_id;?>" class="staff_testi" style="border-top:#73BECE solid 2px;">
		<?
		//Client Testimonial Section Starts here
		$queryTestimonials2 = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony , DATE_FORMAT(date_updated,'%D %b %y')
								  FROM testimonials 
								  WHERE for_id = $leads_id AND for_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon' 
								  ORDER BY date_created DESC;";
			$data2 = mysql_query($queryTestimonials2);	
			//echo $queryTestimonials2;
			if(!$data2) die ("Error in Script : <br>".$queryTestimonials2);
			if(mysql_num_rows($data2) > 0) {
				while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials,$date_updated)=mysql_fetch_array($data2))
				{
					if($testimony_status=="posted"){ 
						$date = "Posted : ".$date_posted ;
						$date .= " | Created : ".$date_created;
					}else if($testimony_status=="updated"){
						$date = "Updated : ".$date_updated ;
						$date .= " | Created : ".$date_created;
					}else{
						$date = "Created : ".$date_created;
					}
					?>
						<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
							<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
								<div style="float:left;"><b style="color:#FF0000">Status</b> : <b><?=strtoupper($testimony_status);?></b> <br><?=$date;?>  </div>
								<div style="float:right;">
								<a href="javascript:showAdminTestimonialForm(<?=$leads_id;?>,'leads',<?=$userid;?>,'subcon',0)" title="Add Testimonial" />
								Add
								</a>
								|
								<a href="javascript:showAdminTestimonialForm(<?=$leads_id;?>,'leads',<?=$userid;?>,'subcon',<?=$testimony_id;?>)"  title="Edit Testimonial"/>
								Edit
								</a>
								|
								<a href="javascript:deleteAdminTestimonial(<?=$leads_id;?>,'leads',<?=$userid;?>,'subcon',<?=$testimony_id;?>)" title="Delete Permanently this Testimonial" />
								Del
								</a>
								|
								<a href="javascript:approvedAdminTestimonial(<?=$leads_id;?>,'leads',<?=$userid;?>,'subcon',<?=$testimony_id;?>)" title="Approved / Cancel Testimonials" />
								Conf
								</a>
								</div>
								<div style="clear:both"></div>
							</div>
							<div style="padding:5px;"><?=str_replace("\n","<br>",$testimonials);?></div>
						</div>
					<?
				}
			}else {
			?>
			<!-- if the client has no testimonial -->
				<div style='text-align:center; padding:35px;'>			
					 <a href="javascript:showAdminTestimonialForm(<?=$leads_id;?>,'leads',<?=$userid;?>,'subcon',0);" />Create</a>					 
				</div>		 
				
			<? }
		//Ends Here
		?>
		
			
		</div>
	</div>
	<?
}
echo "<div style='clear:both;'></div>";
echo "</div>";
?>

