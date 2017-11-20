<?php

//START: generate output box from selected order


		//start: setup timezone selection
		$tz_dropdown = "";	
		switch(LOCATION_ID)
		{
			case 1:
				$tz_dropdown = '<OPTION VALUE="Australia/Sydney" selected>Australia/Sydney</OPTION>';
				$selected_timezone = "Australia/Sydney";
				break;
			case 2:
				$tz_dropdown = '<OPTION VALUE="Europe/London" selected>Europe/London</OPTION>';
				$selected_timezone = "Europe/London";
				break;
			case 3:
				$tz_dropdown = '<OPTION VALUE="America/New_York" selected>America/New_York</OPTION>';
				$selected_timezone = "America/New_York";
				break;
			case 4:
				$tz_dropdown = '<OPTION VALUE="Asia/Manila" selected>Asia/Manila</OPTION>';
				$selected_timezone = "Asia/Manila";
				break;
			default:
				$tz_dropdown = '<OPTION VALUE="Australia/Sydney" selected>Australia/Sydney</OPTION>';
				$selected_timezone = "Australia/Sydney";
				break;	
		}
		if($selected_timezone != "Australia/Sydney")
		{
			$tz_dropdown = $tz_dropdown.'<OPTION VALUE="Australia/Sydney">Australia/Sydney</OPTION>';
		}
		$tz_dropdown = $tz_dropdown.'	
		<OPTION VALUE="Australia/Queensland">Australia/Queensland</OPTION>
		<OPTION VALUE="Australia/Perth">Australia/Perth</OPTION>
		<OPTION VALUE="Australia/Adelaide">Australia/Adelaide</OPTION>
		<OPTION VALUE="Australia/Melbourne">Australia/Melbourne</OPTION>
		<OPTION VALUE="Australia/Darwin">Australia/Darwin</OPTION>
		';
		if($selected_timezone != "America/New_York")
		{
			$tz_dropdown = $tz_dropdown.'<OPTION VALUE="America/New_York">America/New_York</OPTION>';
		}
		$tz_dropdown = $tz_dropdown.'	
		<OPTION VALUE="America/San Francisco">America/San Francisco</OPTION>
		';
		$tz_dropdown = $tz_dropdown.'
		<OPTION VALUE="Asia/Manila">Asia/Manila</OPTION>	
		';		
		if($selected_timezone != "Europe/London")
		{
			$tz_dropdown = $tz_dropdown.'<OPTION VALUE="Europe/London">Europe/London</OPTION>';
		}
		$tz_dropdown = $tz_dropdown.'
			<OPTION VALUE="New_Zealand/Chatham_Islands">New Zealand/Chatham_Islands</OPTION>  
			<OPTION VALUE="New_Zealand/Wellington">New Zealand/Wellington</OPTION>
			<OPTION VALUE="New_Zealand/Auckland">New Zealand/Auckland</OPTION>
			<OPTION VALUE="New_Zealand/Napier">New Zealand/Napier</OPTION>
			<OPTION VALUE="New_Zealand/Christchurch">New Zealand/Christchurch</OPTION>
			<OPTION VALUE="New_Zealand/Hamilton">New Zealand/Hamilton</OPTION>
			<OPTION VALUE="New_Zealand/Dunedin">New Zealand/Dunedin</OPTION>
			<OPTION VALUE="New_Zealand/Invercargill">New Zealand/Invercargill</OPTION>			
		';
		//ended: setup timezone selection
		
		
		
		$return_output = "";
		$a = explode(",",$_SESSION["request_selected"]) ;
		for($i=0; $i < $_SESSION["request_counter"]; $i++)
		{
									//start: validate array
									if(@$a[$i] <> "" && @$a[$i] <> NULL)
									{
											$ar_id = $a[$i];
											$skill_selected = "";
											$userid = "";
											$name = "";
											
											//start: generate applicant user id
											$sql = $db->select()
												->from('job_sub_category_applicants')
												->where('id =?' , $ar_id);
											$job_sub_category_applicants = $db->fetchRow($sql);
											$userid = $job_sub_category_applicants['userid'];	
											//ended: generate applicant user id
												
											//start: generate staff name
											if($userid == "")
											{
												$name = $userid;
											}
											else
											{
												$fname_md5 = new AvailableStaffCheckSum($userid, $db, 'personal', 'fname');
												if ($fname_md5->Valid()) 
												{
													$sql = $db->select()
														->from('personal')
														->where('userid =?' , $userid);
													$personal = $db->fetchRow($sql);
													$name = $personal['fname'];
												}
												else
												{
													$name = $userid;
												}
											}	
											//ended: generate staff name			
												
											//start: setup output result	
											$return_output = $return_output.'
													<tr>
														<td valign="top" width="10%">
														<input type="hidden" name="order_id'.$i.'" value="'.$ar_id.'">
														<input id="userid'.$i.'" name="userid'.$i.'" type="checkbox" value="'.$userid.'" onChange="check_order(\'userid'.$i.'\'); " style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" checked>
														</td>
														<td valign="top" width="10%">
															<table cellpadding="3" cellspacing="3">
																<tr>
																	<td><a href="javascript: resume(\''.$userid.'\'); ">'.$name.'</a></td>
																</tr>
																<tr>
																	<td>
																		<SELECT id="tz_id'.$i.'" name="tz'.$i.'" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
																		'.$tz_dropdown.'
																		</SELECT>
																	</td>	
																</tr>	
															</table>	
														</td>
														<td valign="top" width="0%" align="left">
														
														
														
														
																	<table>
																		<tr>
																			<td>	
																				<img align="absmiddle" src="images/date-picker.gif" id="bd'.$i.'" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" />
																			</td>													
																			<td>
																				<input readonly="true" type="text" NAME="interview_date'.$i.'" ID="interview_date'.$i.'" size="15" class="text" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" onchange="javascript: validate_schedule('.$i.',1);">
																				<script type="text/javascript">
																					Calendar.setup({
																							inputField	: "interview_date'.$i.'",
																							ifFormat	: "%Y-%m-%d",
																							button		: "bd'.$i.'",
																							align		: "Tl",
																							showsTime	: false, 
																							singleClick	: true
																					});
																				</script>														
																			</td>
																		</tr>		
																		<tr>
																			<td>										
																				<IMG SRC="images/time-picker.gif" BORDER="0" ALT="Select Interview Time" title="Select Interview Time" ONCLICK="selectTime(this,interview_time'.$i.')" style="cursor: pointer; ">
																			</td>													
																			<td>
																				<input readonly="true" type="text" NAME="interview_time'.$i.'" ID="interview_time'.$i.'" size="15" class="text" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
																			</td>
																		</tr>
																	</table>
																	
																	
																	
														</td>
														<td valign="top" width="0%">
														
														
														
																	<table>
																		<tr>
																			<td>	
																				<img align="absmiddle" src="images/date-picker.gif" id="alt_bd'.$i.'" style="cursor: pointer; " title="Select a Date" alt="Select a Date" onMouseOver="this.style.background=\'red\'" onMouseOut="this.style.background=\'\'" />
																			</td>													
																			<td>
																				<input readonly="true" type="text" NAME="alt_interview_date'.$i.'" ID="alt_interview_date'.$i.'" size="15" class="text" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" onchange="javascript: validate_schedule('.$i.',2);">
																				<script type="text/javascript">
																					Calendar.setup({
																							inputField	: "alt_interview_date'.$i.'",
																							ifFormat	: "%Y-%m-%d",
																							button		: "alt_bd'.$i.'",
																							align		: "Tl",
																							showsTime	: false, 
																							singleClick	: true
																					});
																				</script>														
																			</td>
																		</tr>		
																		<tr>
																			<td>										
																				<IMG SRC="images/time-picker.gif" BORDER="0" ALT="Select Interview Time" title="Select Interview Time" ONCLICK="selectTime(this,alt_interview_time'.$i.')" style="cursor: pointer; ">
																			</td>													
																			<td>
																				<input readonly="true" type="text" NAME="alt_interview_time'.$i.'" ID="alt_interview_time'.$i.'" size="15" class="text" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
																			</td>
																		</tr>
																	</table>
																	
																	
													
														</td>
														<input type="hidden" name="comment'.$i.'" id="comment'.$i.'" cols="30" rows="3" border="textarea" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
													</tr>
													<input type="hidden" id="validator'.$i.'" value=1><input type=hidden id=validator_temp'.$ar_id.'>
											';									
											//ended: setup output result
									}
									//ended: validate array
									
		}
		
		
//ENDED: generate output box from selected order

?>