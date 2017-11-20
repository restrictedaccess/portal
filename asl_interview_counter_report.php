<?php
include('conf/zend_smarty_conf.php');
include 'config.php';
include 'conf.php';
//error_reporting(E_ALL);


//REDUCE THE SIZE OF COMMENTS
function truncate_comment($string) 
{
	return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[19].'...';
}
//ENDED


//FUNCTIONS
function search($userid) 
{
	$from = "FROM tb_request_for_interview r, leads l, voucher v ";
	$fields = "
	r.id,
	r.order_id,
	r.job_sub_category_applicants_id,
	r.leads_id,
	r.applicant_id,
	r.comment,
	r.date_interview,
	r.time,
	r.alt_time,
	r.alt_date_interview,
	r.time_zone,
	r.status,
	r.payment_status,
	r.date_added,
	l.fname,
	l.lname,
	r.voucher_number,
	r.session_id
	";
	
	$where = "WHERE (r.applicant_id='$userid') AND (r.leads_id=l.id) AND (r.voucher_number=v.code_number)";
	$query = "SELECT $fields $from $where";
	$result =  mysql_query($query);
	$x = 0 ;	
	while ($r = mysql_fetch_assoc($result)) 
	{
		$temp[$x]['id'] = $r['id'];
		$temp[$x]['order_id'] = $r['order_id'];
		$temp[$x]['job_sub_category_applicants_id'] = $r['job_sub_category_applicants_id'];
		$temp[$x]['leads_id'] = $r['leads_id'];
		$temp[$x]['applicant_id'] = $r['applicant_id'];
		$temp[$x]['comment'] = $r['comment'];
		$temp[$x]['date_interview'] = $r['date_interview'];
		$temp[$x]['time'] = $r['time'];
		$temp[$x]['alt_time'] = $r['alt_time'];
		$temp[$x]['alt_date_interview'] = $r['alt_date_interview'];
		$temp[$x]['time_zone'] = $r['time_zone'];
		$temp[$x]['status'] = $r['status'];
		$temp[$x]['payment_status'] = $r['payment_status'];
		$temp[$x]['date_added'] = $r['date_added'];
		$temp[$x]['fname'] = $r['fname'];
		$temp[$x]['lname'] = $r['lname'];
		$temp[$x]['voucher_number'] = $r['voucher_number'];
		$temp[$x]['session_id'] = $r['session_id'];
		$temp[$x]['admin_id'] = $r['admin_id'];
		$temp[$x]['agent_id'] = $r['agent_id'];

		if($temp[$x]['voucher_number'] == "" || $temp[$x]['voucher_number'] == NULL)
		{
			$temp[$x]['date_expire'] = "";
			$temp[$x]['date_expire_status'] = "";
		}
		else
		{
			$name = mysql_query("SELECT * FROM voucher WHERE code_number='".$temp[$x]['voucher_number']."' LIMIT 1");
			$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
			$temp[$x]['voucher_comment'] = mysql_result($name,0,"comment");
			$today = date("Y-m-d");
			if($temp[$x]['date_expire'] == "" || $temp[$x]['date_expire'] == "0000-00-00")
			{
				$temp[$x]['date_expire'] = "0000-00-00";
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>No Expiration Date Assigned</font></strong>";
			}
			elseif($today <= $temp[$x]['date_expire'])
			{
				$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
				$temp[$x]['date_expire_status'] = "<strong>Active</strong>";
			}
			else
			{
				$temp[$x]['date_expire'] = mysql_result($name,0,"date_expire");
				$temp[$x]['date_expire_status'] = "<strong><font color=#FF0000>Expired</font></strong>";
			}
		}	
		
		
		$temp[$x]['date_created'] = mysql_result($name,0,"date_created");
		$temp[$x]['admin_id'] = mysql_result($name,0,"admin_id");
		if($temp[$x]['admin_id'] == "" || $temp[$x]['admin_id'] == 0)
		{
			$temp[$x]['admin_name'] = "System Generated";
		}
		else
		{		
			$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$temp[$x]['admin_id']."' LIMIT 1");
			$fname = mysql_result($name,0,"admin_fname");
			$lname = mysql_result($name,0,"admin_lname");
			$temp[$x]['admin_name'] = $fname." ".$lname;
		}
		
		$name = mysql_query("SELECT fname, lname FROM leads WHERE id='".$temp[$x]['leads_id']."' LIMIT 1");
		$fname = mysql_result($name,0,"fname");
		$lname = mysql_result($name,0,"lname");
		$temp[$x]['client_name'] = $fname." ".$lname;
		
		$name = mysql_query("SELECT fname, lname FROM personal WHERE userid='".$temp[$x]['applicant_id']."' LIMIT 1");
		$fname = mysql_result($name,0,"fname");
		$lname = mysql_result($name,0,"lname");
		$temp[$x]['applicant_name'] = $fname." ".$lname;

		//get calendar facilitator
		$ag = mysql_query("SELECT user_id FROM tb_app_appointment WHERE request_for_interview_id='".$temp[$x]['id']."'");
		while ($row_a = @mysql_fetch_assoc($ag))
		{
			$name = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$row_a["user_id"]."' LIMIT 1");
			$fname = mysql_result($name,0,"admin_fname");
			$lname = mysql_result($name,0,"admin_lname");
			$temp[$x]['facilitator'] = "-&nbsp;".$fname." ".$lname."<br />";
		}
		if(!isset($temp[$x]['facilitator']))
		{
			$temp[$x]['facilitator'] = "None";
		}
		//ended
													
		$x++ ;
	}
	return $temp ;
}
//ENDED - FUNCTIONS


//GENERATE REPORT
$found = search($_REQUEST["userid"]) ;
//ENDED
?>




	

<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#999999">
	<tr>
		<td valign="top"  style="width:100%;">
			<table width="100%" border="0" bgcolor="#FFFFCC" cellpadding="4" cellspacing="1">
				<tr bgcolor="#FFFFFF">
					<td valign="top" colspan="10" style="padding:0px;">
						<table width="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr bgcolor="#FFFFCC">
								<td width="3%" align="left" valign="top"><strong>#</strong></td>
								<td width="11%" align="left" valign="top"><strong>Client</strong></td>
								<td width="14%" align="left" valign="top"><strong>Applicant</strong></td>
								<td width="6%" align="left" valign="top"><strong>Facilitator</strong></td>
								<td width="10%" align="left" valign="top"><font color="#000000"><strong>Schedule</strong></font></td>
								<td width="10%" align="left" valign="top"><font color="#000000"><strong>Alternative<br />Schedule</strong></font></td>
								<td width="9%" align="left" valign="top"><font color="#000000"><strong>Time&nbsp;Zone</strong></font></td>
								<td width="10%" align="left" valign="top"><font color="#000000"><strong>Date<br />Requested</strong></font></td>
								<td width="15%" align="left" valign="top"><font color="#000000"><strong>Voucher</strong></font></td>
								<td width="12%" align="left" valign="top"><font color="#000000"><strong>Recruitment Status / Payment</strong></font></td>
							</tr>	

<?php
	$total = count($found);
	$counter=0;
	for ($x=0; $x < $total; $x++) 
	{
			$counter++;
			//check the session_id if existing in `request_for_interview_job_order`
			$request_for_interview_job_order_id ="";
			$job_position_id = "";
			$job_order_flag ="";
			$applicant_job_order_id ="";
			$sql = $db->select()
				->from('request_for_interview_job_order' , 'id')
				->where('lead_id =?' ,$found[$x]['leads_id'])
				->where('session_id =?' ,$found[$x]['session_id']);
			$request_for_interview_job_order_id = $db->fetchOne($sql);
			if($request_for_interview_job_order_id){
					//id, request_for_interview_job_order_id, no_of_applicant, proposed_start_date, duration_status, jr_cat_id, category_id, sub_category_id, date_created, form_filled_up, date_filled_up
					$sql= $db->select()
						->from('request_for_interview_job_order_position')
						->where('request_for_interview_job_order_id =?' , $request_for_interview_job_order_id);
					$job_positions = $db->fetchAll($sql);
					foreach($job_positions as $job_position){
						//id, request_for_interview_job_order_position_id, userid, work_status, working_timezone, start_work, finish_work, app_working_details_filled_up, app_working_details_date_filled_up
						$sql = $db->select()
							->from('request_for_interview_job_order_applicants' , 'id')
							->where('request_for_interview_job_order_position_id =?' , $job_position['id'])
							->where('userid =?' , $found[$x]['applicant_id']);
						$applicant_job_order_id = $db->fetchOne($sql);
						if($applicant_job_order_id){
							$jr_cat_id = $job_position['jr_cat_id'];
							$job_position_id = $job_position['id'];
							break;
						}	
					}
				
			}	
			
?>


							<tr>
								<td align="left" valign="top" bgcolor="#FFFFFF" ><?php echo $found[0]['total_result'];?></td>
								<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
									<table cellpadding="2" cellspacing="2">
										<tr>
											<td colspan="2">
												<?php echo $found[$x]['client_name']; ?><br>
											</td>
										</tr>
									</table>
																
									</td>
									<td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
							
									<?php 
										if($applicant_job_order_id)
										{
											//remove job order flag as per maam rica
											//echo "<span style='float:right;'><a href=javascript:popup_win('../asl/ShowJobSpecAppWorkingDetails.php?id=$job_position_id&jr_cat_id=$jr_cat_id&applicant_id=$applicant_job_order_id&view=True',820,600);><img src='images/flag_red.gif' border='0'></a></span>";
										}
									?>
									<?php echo $found[$x]['applicant_name']; ?>
								
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['facilitator']; ?>
							</td>                            
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['date_interview']; ?><br />
								<?php echo $found[$x]['time']; ?>
							</td>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php echo $found[$x]['alt_date_interview']; ?><br />
								<?php echo $found[$x]['alt_time']; ?>
							</td>							
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<?php 
									switch($found[$x]['time_zone'])
									{
										case "PST8PDT":
											$default_timezone_display = "America/San Francisco";
											break;
										case "NZ":
											$default_timezone_display = "New Zealand/Wellington";
											break;
										case "NZ-CHAT":
											$default_timezone_display = "New Zealand/Chatham_Islands";
											break;
										default:
											$default_timezone_display = $found[$x]['time_zone'];
											break;
									}
									echo $default_timezone_display; 
								?>
                            </td>
							<td align="left" valign="top" bgcolor="#FFFFFF"><?php echo $found[$x]['date_added']; ?>	</td>
							<!--<td align="left" valign="top" bgcolor="#FFFFFF" onClick="showSubMenu('voucher_<?php echo $x; ?>'); " onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">-->
                            <td align="left" valign="top" bgcolor="#FFFFFF" onMouseOver="javascript:this.style.background='#F1F1F3';" onMouseOut="javascript:this.style.background='#ffffff'; ">
								<?php echo $found[$x]['voucher_number']; ?>
							</td>
                            <td align="left" valign="top" bgcolor="#FFFFFF">
							<?php 
								switch ($found[$x]['status']) 
								{
									case "ACTIVE":
										$stat = "NEW";
										break;
									case "ARCHIVED":
										$stat = "ARCHIVED";
										break;
									case "ON-HOLD":
										$stat = "ON-HOLD";
										break;															
									case "HIRED":
										$stat = "HIRED";
										break;															
									case "REJECTED":
										$stat = "REJECTED";
										break;		
									case "CONFIRMED":
										$stat = "CONFIRMED";	
										break;		
									case "YET TO CONFIRM":
										$stat = "YET TO CONFIRM";
										break;		
									case "DONE":
										$stat = "DONE";
										break;
									case "RE-SCHEDULED":
										$stat = "RE-SCHEDULED";
										break;	
									case "CANCELLED":
										$stat = "CANCELLED";
										break;	
									default: 
										$stat = $found[$x]['status'];
										break;																																														
								}
								echo "<table>";
								echo "<tr><td valign=top><strong>-</strong></td><td>".$stat."</td></tr>";
								if(isset($found[$x]['payment_status']))
								{
									echo "<tr><td valign=top><strong>-</strong></td><td>".$found[$x]['payment_status']."</td></tr>";
								}
								echo "</table>";
							?>
                            </td>
						  </tr>
<?php 
	}
?>

							<tr>
								<td width="3%" align="right" colspan="10" valign="top"><a href='javascript: asl_interview_counter_exit(); '>Close</a></td>
							</tr>
					</table>
				</td>
			</tr>
		</table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
