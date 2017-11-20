<script language=javascript src="js/addNote.js"></script>
<link rel="stylesheet" type="text/css" href="css/tabber.css" /> 

<div class="tabber">
<?php
$sql = "SELECT agent_id FROM leads l WHERE $lead_status $keyword_search $leads_location_search $ratings_search $month_search GROUP BY agent_id ORDER BY agent_id;";	//echo $sql;
	$resulta = mysql_query($sql);
	if(!$resulta) die($sql."<br>".mysql_error());
	while(list($agents_id , $agent_fname , $agent_lname , $work_status)=mysql_fetch_array($resulta))
	{
		$query2="SELECT DISTINCT(COUNT(id)) AS numrows FROM leads l WHERE $lead_status $keyword_search AND l.agent_id = ".$agents_id;
		//echo $query2 ;
		$result2 = mysql_query($query2);
		list($numrows)=mysql_fetch_array($result2);
		
		
		if($agent_fname == "") $agent_fname = "?" ;  
		if($agent_lname == "") $agent_fname = "?" ;
		
		if($work_status == "BP") $work_status = "Business Partner : ";
		if($work_status == "AFF") $work_status = "Affiliate : ";
		
		if($agents_id!=""){
	?>
	<div class="tabbertab">
		
		<div class="tab_content">
			<div>
			<div class="agent_name"><?php echo checkAgentIdForAdmin($agents_id);//$agent_fname." ".$agent_lname;?></div>
			<div class='pagination'><ul>
			<?
			//PAGING
		$result_page  = mysql_query($query2);
		$row     = mysql_fetch_array($result_page);
		$numrows = $row['numrows'];
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		// print the link to access each page
		if($folder == "Inactive") $folder = "all";
		$self = "./".basename($_SERVER['SCRIPT_FILENAME'])."?agent_id=".$agents_id."&lead_status=".$folder;
		$nav = '';
		for($page = 1; $page <= $maxPage; $page++)
		{
			if ($page == $pageNum)
			{
				if($agent_id == $agents_id) {
					$nav .= " <li><a class='currentpage' href=\"$self&page=$page\">$page</a></li> ";
				}else{
					$nav .= " <li><a class='' href=\"$self&page=$page\">$page</a></li> ";
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
				if($agent_id == $agents_id) {
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
		echo $prev . $next .$nav.  $last;
		echo "[".$numrows."&nbsp;rows results]";
			
			?>
			
			</ul></div>	
			<div style="clear:both;"></div>
			</div>
			<table cellpadding="2" cellspacing="0" width="100%" align="center" style="border:#000000 solid 1px;">
			<tr bgcolor="#0080C0" >
			<td width="3%" valign="top" class="list_hdr">#</td>
			<td width="4%" valign="top" class="list_hdr list_hdr_border" align="center">ID</td>
			<td width="1%" valign="top" class="list_hdr">&nbsp;</td>
			<td width="26%" valign="top" class="list_hdr">Name / Details</td>
			<td width="9%" valign="top" align="center" class="list_hdr list_hdr_border">Date Registered</td>
			<td width="58%" valign="top" class="list_hdr" >Notes / Steps Taken</td>
			</tr> 
			<?
			if($agent_id == $agents_id){
				$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
					l.fname,l.lname,company_position,company_name,l.email,company_address ,
					rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
					personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
					agent_from ,officenumber, mobile ,
					l.leads_country,leads_ip , officenumber,mobile , agent_id , business_partner_id , l.status
				
					FROM leads l
					WHERE $lead_status AND agent_id = ".$agents_id." 
					$keyword_search
					$event_date_search
					$ratings_search
					$month_search
					ORDER BY timestamp DESC LIMIT $offset2, $rowsPerPage;";
					$counter =$offset2 ;
					
			}
			else{
				$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %b %Y'),remote_staff_needed,
					l.fname,l.lname,company_position,company_name,l.email,company_address ,
					rating,DATE_FORMAT(inactive_since,'%D %b %Y'),
					personal_id,DATE_FORMAT(date_move,'%D %b %Y'),
					agent_from ,officenumber, mobile,
					l.leads_country,leads_ip,officenumber,mobile, agent_id , business_partner_id , l.status
				
					FROM leads l
					WHERE $lead_status  AND agent_id = ".$agents_id." 
					$keyword_search
					$event_date_search
					$ratings_search
					$month_search
					ORDER BY timestamp DESC LIMIT $offset, $rowsPerPage;";
					$counter =0 ;
			}
			//echo $query;
			$result = mysql_query($query);
			$count=@mysql_num_rows($result);
			
			while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$lead_fname ,$lead_lname,$company_position,$company_name,$email,$company_address,$rate,$inactive_since,$personal_id,$date_move,$agent_from,$officenumber, $mobile,$leads_country,$leads_ip , $officenumber , $mobile , $agent_affiliate_id , $business_partner_id , $status )=mysql_fetch_array($result))
			 {
					$lead_name = stripslashes($lead_fname)." ".stripslashes($lead_lname);	
					$counter++;
					$star="";
					/*
					$add_remark='<form name="add_remark_form" method="post" action="leads_add_remark.php">
				 <input type="hidden" name="leads_id" value='.$id.'>
				 <input type="hidden" name="created_by_id" value='.$_SESSION['admin_id'].'>
				 <input type="hidden" name="remark_created_by" value="BP">
				 <input type="hidden" name="url" value='.$_SERVER['PHP_SELF'].'>
				 <textarea style="width:100%;" rows="4" class="select" name="remarks"></textarea>
				 <input type="submit" name="save_remark" value="Save" class="add_note">
				 <input type="button" class="add_note" name="cancel_remark" value="Cancel" onClick="javascript: show_hide('."'$id'".');"></form>';	
				 */
				 $add_remark="<textarea style='width:100%;' rows='4' class='select' name='remarks' id='remarks_$id'></textarea>
<input type='button' name='save_remark' value='Save' class='add_note' onClick=javascript:saveNote2($id,$admin_id);>
<input type='button' class='add_note' name='cancel_remark' value='Cancel' onClick=javascript:toggle('note_form_$id');>";

				 for($x=1; $x<=$rate;$x++){
					$star.="<img src='images/star.png' align='top'>";
				 }
	
				if($officenumber != "") $officenumber = "Office no. : ". $officenumber;
				if($mobile != "") $mobile = "Mobile no. : ". $mobile;
				
				$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];
			
			
			?>
			<tr>
	<td width="3%" valign="top" class="list_content " ><?php echo $counter;?>)</td>
	<td width="4%" valign="top" class="list_content list_border" align="center" style="color:#999999;" ><?php echo $id ."<br><br>".$status;?></td>
	<td width="1%" valign="top" class="list_content">
	<?php showToolTip($id);?>
	<input type="radio" name="action" value="<? echo $id;?>" onClick ="javascript:location.href='leads_information.php?id=<?php echo $id;?>&lead_status=<?php echo $status;?>'"><br />
	<a href="AddUpdateLeads.php?leads_id=<? echo $id;?>&lead_status=<?php echo $status;?>&url=<?php echo $url;?>"><img src="images/b_edit.png" border="0"></a><br />
	<?php if (in_array($status, array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive' , 'Interview Bookings' , 'custom recruitment')) == true) { ?>
	<input type="checkbox" onClick="check_val()" name="users" value="<? echo $id;?>"  title="Transfer <? echo $fname." ".$lname;?>" ><br />
	<?php } ?>
	<?php if (in_array($status, array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'Inactive')) == true) { ?>
	<a href="<?=basename($_SERVER['SCRIPT_FILENAME']);?>?delete=TRUE&leads_id=<?=$id;?>"><img src="images/delete.png" border="0" ></a><br />
	<?php } ?>
	
	
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
				$delete_link = "<a href=".$_SERVER['PHP_SELF']."?remark_id=$remark_id"." title='Delete'>delete</a>";
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
	<!--
	onclick="javascript: popup_win('./viewStepsTakenFull.php?id=<?php //echo $id;?>',500,400);"
	-->
	<div id="steps_list_section_id_<?php echo $id;?>" title="click to full view" class="steps_list_section">
	<?php 
		getClientStaff($id);
		showAgentFrom($date_move,$agent_from);
		getStepsTaken($id);
		
		checkAgentIdForAdmin
	?>
	</div>
	
</tr>
<? } ?>
			</table>
					
		</div>
	</div>	
	<?php	
	  }
	}
?>	
</div>
