<script language=javascript src="js/addNote.js"></script>
<link rel="stylesheet" type="text/css" href="css/tabber.css" />
<div style="font-family:Arial, Helvetica, sans-serif; font-size:12px;  margin:8px;"> 
<?php
include 'function.php';

//get all agents BP and AFF
if(basename($_SERVER['SCRIPT_FILENAME']) == "keep_in_touch_leads.php" ){
	//show all agents leads
	$sql = "SELECT agent_id FROM leads l WHERE $lead_status2 $keyword_search $leads_location_search $ratings_search $month_search  GROUP BY agent_id ORDER BY agent_id;";
	
	
}else{
	$sql = "SELECT agent_id FROM leads l WHERE l.business_partner_id = $agent_no $lead_status $keyword_search $leads_location_search $ratings_search $month_search GROUP BY agent_id ORDER BY agent_id;";
}

//echo $lead_status."<br>";
//echo $sql;
$agents = $db->fetchAll($sql);

foreach($agents as $agent){
	if($agent['agent_id'] != ""){
		echo "<div class='agent_name'>".checkAgentIdForAdmin($agent['agent_id'])."</div>";
		echo "<div style='background:#f7f7f7;'>";
		$query = "SELECT * FROM leads l WHERE agent_id = ".$agent['agent_id']." $lead_status $keyword_search $leads_location_search $ratings_search $month_search";
		//echo $query;
		//exit;
		$result = $db->fetchAll($query);
		$numrows = count($result);
		
		//PAGINATION
		echo "<div class='pagination'><ul>";
			// how many pages we have when using paging?
			$maxPage = ceil($numrows/$rowsPerPage);
			// print the link to access each page
			if($folder == "Inactive") $folder = "all";
			$self = "./".basename($_SERVER['SCRIPT_FILENAME'])."?agent_id=".$agent['agent_id']."&lead_status=".$folder;
			$nav = '';
			for($page = 1; $page <= $maxPage; $page++)
			{
				if ($page == $pageNum)
				{
					if($agent_id == $agent['agent_id']) {
						$nav .= " <li><a class='currentpage' href=\"$self&page=$page\">$page</a></li> ";
					}else{
						$nav .= " <li><a class='currentpage' href=\"$self&page=$page\">$page</a></li> ";
					}
				}
				else
				{
					$nav .= " <li><a href=\"$self&page=$page\">$page</a></li> ";
				}
			}
			// creating previous and next link
			// plus the link to go straight to
			// the first and last page
			if ($pageNum > 1)
			{
				$page = $pageNum - 1;
				if($agent_id == $agent['agent_id']) {
					$prev = " <li><a class='prevnext' href=\"$self&page=$page\">Prev</a></li> ";
					$first = "<li><a href=\"$self&page=1\">[First Page]</a></li>";
				}else{
					$prev  = '&nbsp;'; // we're on page one, don't print previous link
					$first = '&nbsp;'; // nor the first page link
				}
			}
			else
			{
				$prev  = '&nbsp;'; // we're on page one, don't print previous link
				$first = '&nbsp;'; // nor the first page link
			}
			
			if ($pageNum < $maxPage)
			{
				$page = $pageNum + 1;
				$next = " <li><a class='prevnext' href=\"$self&page=$page\">Next</a></li>";
				$last = " <li><a href=\"$self&page=$maxPage\">Last Page</a></li> ";
			}
			else
			{
				$next = '&nbsp;'; // we're on the last page, don't print next link
				$last = '&nbsp;'; // nor the last page link
			}
		echo $prev . $next . $nav. $last;
		//echo $prev . $next . $last;
		echo "[".$numrows."&nbsp;rows results]";
		echo "</ul></div><div style='clear:both;'></div>";
		//END PAGINATION
		
		
		if($agent_id == $agent['agent_id']){
			$query = "SELECT * FROM leads l WHERE agent_id = ".$agent['agent_id']." $lead_status $keyword_search $leads_location_search $ratings_search $month_search ORDER BY timestamp DESC LIMIT $offset2, $rowsPerPage";
			$counter =$offset2 ;
		}else{
			$query = "SELECT * FROM leads l WHERE agent_id = ".$agent['agent_id']." $lead_status $keyword_search $leads_location_search $ratings_search $month_search ORDER BY timestamp DESC LIMIT $offset, $rowsPerPage";
			$counter =0 ;
		}
		//echo $query;
		$leads = $db->fetchAll($query);
		?>
		<table cellpadding='2' cellspacing='0' width='100%' align='center' style='border:#000000 solid 1px;'>
			<tr bgcolor='#0080C0' >
			<td width='3%' valign='top' class='list_hdr'>#</td>
			<td width='4%' valign='top' class='list_hdr list_hdr_border' align='center'>ID</td>
			<td width='1%' valign='top' class='list_hdr'></td>
			<td width='26%' valign='top' class='list_hdr'>Name / Details</td>
			<td width='9%' valign='top' align='center' class='list_hdr list_hdr_border'>Date Registered</td>
			<td width='58%' valign='top' class='list_hdr' >Notes / Steps Taken</td>
			</tr>
		<?php	
		
		
		foreach($leads as $lead){
				$id = $lead['id'];
				$tracking_no= $lead['tracking_no'];
				$timestamp= format_date($lead['timestamp']);
				
						
				$remote_staff_needed= $lead['remote_staff_needed'];
				$lead_name= $lead['fname']." ".$lead['lname'];
				$company_position= $lead['company_position'];
				$company_name= $lead['company_name'];
				$email= $lead['email'];
				$company_address= $lead['company_address'];
				$rate= $lead['rating'];
				$inactive_since= $lead['inactive_since'];
				
				$date_move= $lead['date_move'];
				$agent_from= $lead['agent_from'];
				$officenumber= $lead['id']; 
				$mobile= $lead['id'];
				$leads_country= $lead['id'];
				$leads_ip = $lead['id']; 
				$officenumber = $lead['officenumber']; 
				$mobile = $lead['mobile'];
				$agent_affiliate_id = $lead['agent_id']; 
				$business_partner_id= $lead['business_partner_id']; 
				$status = $lead['status'];
				
				$counter++;
				$star="";
				$add_remark="<textarea style='width:100%;' rows='4' class='select' name='remarks' id='remarks_$id'></textarea>
<input type='button' name='save_remark' value='Save' class='add_note' onClick=javascript:saveNote($id,$agent_no);>
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick=javascript:toggle('note_form_$id');>";
				 
				 for($x=1; $x<=$rate;$x++){
					$star.="<img src='images/star.png' align='top'>";
				 }
	
				if($officenumber != "") $officenumber = "Office no. : ". $officenumber;
				if($mobile != "") $mobile = "Mobile no. : ". $mobile;
				//if($agent_no == $business_partner_id) {
		?>		
					<tr>
	<td width="3%" valign="top" class="list_content " ><?php echo $counter;?>)</td>
	<td width="4%" valign="top" class="list_content list_border" align="center" style="color:#999999;" ><?php echo $id."<br><br>".$status;?></td>
	<td width="1%" valign="top" class="list_content" >
	<input type="radio" name="action" value="<? echo $id;?>" onClick ="javascript:location.href='leads_information.php?id=<?php echo $id;?>&lead_status=<?php echo $status;?>'"><br />
	<? if (in_array($status, array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'Interview Bookings' , 'custom recruitment')) == true) { ?>
			<input type="checkbox" onClick="check_val()" name="users" value="<? echo $id;?>"  title="Transfer <? echo $lead_name;?>" >
	<? } ?>
	</td>
	<td width="26%" valign="top" class="list_content ">
	<a href="javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);"><b><?php echo strtoupper($lead_name);?></b></a>&nbsp;<?php echo $star;?>
	<div style="color:#999999;">
	<div><? echo $email ? $email : '&nbsp;';?></div>
	<div><? echo $officenumber;?></div>
	<div><? echo $mobile;?></div>
	<div><? echo $company_name;?></div>
	<small><?=$leads_country." ".$leads_ip;?></small>
	<div><a class="link10" href="javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);"><? echo $tracking_no;?></a></div>
	</div>
	<div><?php checkLeadsOwner(getBPId($agent_affiliate_id), $business_partner_id);?></div>
	</td>
	<td width="9%" valign="top" align="center" class="list_content list_border" ><?php echo $timestamp ? $timestamp : '&nbsp;';?></td>
	<td width="58%" valign="top" class="list_content" >
	<div>
	<div id="note_book_<?php echo $id;?>" style="float:left;" ><?php showViewButton($id);?>
	<div id="leads<?=$id;?>" class="notes_list">
	<div style="border-bottom:#333333 solid 1px; padding-bottom:5px;">
	<div style="float:left;"><b>Remarks/Notes</b></div>
	<div style="float:right;"><b><a href="javascript:show_hide('leads<?=$id;?>')">[x]</a></b></div>
	<div style="clear:both;"></div>
	</div>
	<?
		  $sqlGetAllRemarks="SELECT id, remark_creted_by,remarks ,DATE_FORMAT(remark_created_on,'%D %b %Y %h:%i %p') FROM leads_remarks WHERE leads_id = $id ORDER BY id DESC;";
		  $get_all_result=mysql_query($sqlGetAllRemarks);
		  while(list($remark_id,$remark_creted_by,$remarks,$remarks_date)=mysql_fetch_array($get_all_result))
		  {
		
			$str1 = "ADMIN";
			$str2 = $remark_creted_by;
			if (preg_match("/\bADMIN\b/i", $str2)) {
				$delete_link ="&nbsp;";
			} else {
				$delete_link ="&nbsp;";
				//$delete_link = "<a href=".$_SERVER['PHP_SELF']."?remark_id=$remark_id"." title='Delete'>delete</a>";
			}	
		
			echo "<div style='margin-top:2px;margin-bottom:2px; border-bottom:#999999 dashed 1px;padding-bottom:5px; padding-top:5px;'>
					<div>
					<div style='float:left;'>- ".$remark_creted_by."</div>
					<div style='float:right;'>".$delete_link."</div>
					<div style='clear:both;'></div>
					</div>
					<div>&quot;".$remarks."&quot;</div>
					<div><i>".$remarks_date."</i></div>
				  </div>";
		  }
		
	  ?>
	</div>
	</div>
	<div style="float:right"><input type="button"  value="add note" style="font:10px tahoma; width:60px;"   onClick='javascript: show_hide("note_form_<? echo $id;?>");'></div>
	<div style="clear:both;"></div>
	</div>
	



	<div id="note_form_<?php echo $id;?>" class="add_notes_form"><span>Add remarks (<?php echo $lead_name;?>)</span><? echo $add_remark;  ?></div>
	
	
	<!--
	onclick="javascript: popup_win('./viewStepsTakenFull.php?id=<?php //echo $id;?>',500,400);"
	-->
	<div id="steps_list_section_id_<?php echo $id;?>" title="click to full view" class="steps_list_section">
	<?php 
		getClientStaff($id);
		showAgentFrom($date_move,$agent_from);
		getStepsTaken($id);
	?>
	</div>
	
</tr>

		<?php		
		}
		?>
		</table>
		<?php

		
	echo "</div>";	
	//endif	
	}
//end foreach	
}



?>	  
</div>	  