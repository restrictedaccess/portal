<?php
include '../config.php';
include '../conf.php';
include('../conf/zend_smarty_conf.php');

if (isset($_SESSION["logintype"])&&$_SESSION["logintype"]=="business_partner"){
	
}else{
	if($_SESSION['admin_id']==""){
		echo '
			<script language="javascript">
				alert("Session expired.");
				window.close();
			</script>
		';
	}	
}
											
//SESSION CHECKER

//ENDED	

?>
<html>
<head>
<title>Other Appointments</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/styles.css">
<script type="text/javascript">
	function view_schedule(id) {
		previewPath = "get_schedule_admin.php?id="+id;
		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>	
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
												<?php	

												//get admin timezone
													
													if (isset($_GET["admin_id"])){
														$settings = $db->fetchOne($db->select()->from("admin", array("view_admin_calendar"))->where("admin_id = ?", $_SESSION["admin_id"]));
														if ($settings=="Y"){
															$admin_id = $_GET["admin_id"];	
														}else{
															$admin_id = 0;
														}
													}else{
														$admin_id = $_SESSION['admin_id'];
													}
													$r = mysql_query("SELECT timezone_id FROM admin WHERE admin_id='{$admin_id}' LIMIT 1");
													$admin_timezone_id = mysql_result($r,0,"timezone_id");	
													
													$r = mysql_query("SELECT timezone FROM timezone_lookup WHERE id='$admin_timezone_id' LIMIT 1");
													$admin_timezone = mysql_result($r,0,"timezone");
													
													if($admin_timezone == "" || $admin_timezone == NULL) 
													{
														$admin_timezone = "Asia/Manila";
														$admin_timezone_display = "Asia/Manila";
													}	
	
													date_default_timezone_set($admin_timezone); //apply timezone
													
													switch($admin_timezone)
													{
														case "PST8PDT":
															$admin_timezone_display = "America/San Francisco";
															break;
														case "NZ":
															$admin_timezone_display = "New Zealand/Wellington";
															break;
														case "NZ-CHAT":
															$admin_timezone_display = "New Zealand/Chatham_Islands";
															break;
														default:
															$admin_timezone_display = $admin_timezone;
															break;															
													}
												//ended												
												
												
												//get the hour-minute-seconds-timetype-date
												//date_default_timezone_set($admin_timezone);
												//$time_offset ="0";   
												//$time_a = ($time_offset * 120);
												//$t = date("h:i:s",time() + $time_a);
											
												//convert to admin timezone
												//$phl_tz = new DateTimeZone($admin_timezone);
												//$date_time_asia_manila = new DateTime($t);
												//$date_time_asia_manila->setTimezone($phl_tz);
												//$h = $date_time_asia_manila->format('g');	
												//$m = $date_time_asia_manila->format('i');	
												//$type = $date_time_asia_manila->format('a');	
												//$admin_current_date = date("Y-m-d");
												//ended	
																
																			
												$return = "";
												$counter = 0;
												$agent_no = $_GET["agent_no"];
												
												if($_SESSION['interview_id'] <> "")
												{
													//$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='".$_SESSION['admin_id']."' AND request_for_interview_id='".$_SESSION['interview_id']."' AND (date_start = '$d' OR date_start > '$d') ORDER BY date_start";
													$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='".$admin_id."' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY date_start";
												}
												else
												{
													$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='".$admin_id."' ORDER BY date_start";
												}	

												$c = mysql_query($q);	
												while ($row = @mysql_fetch_assoc($c)) 
												{
													
													//CONVERSION
														$start_hour = $row["start_hour"]; 
														$start_minute = $row["start_minute"]; if($start_minute < 10) $start_minute = "0".$start_minute;
														$time_zone = $row["time_zone"];
														$end_hour = $row["end_hour"];
														$end_minute = $row["end_minute"]; if($end_minute == 0) { $end_minute = "00"; }
														$subject = $row["subject"];
														$description = $row["description"];
														$date_start = $row["date_start"];
														$initial_interview = $row["initial_interview"];
														$contract_signing = $row["contract_signing"];
														$new_hire_orientation = $row["new_hire_orientation"];
														$meeting = $row["meeting"];
														
														$timezone_display = $time_zone;
														
														switch($time_zone)
														{
															case "America/San Francisco":
																$time_zone = "PST8PDT";
																break;
															case ($time_zone == "New_Zealand/Auckland" || $time_zone == "New_Zealand/Wellington" || $time_zone == "New_Zealand/Napier" || $time_zone == "New_Zealand/Christchurch" || $time_zone == "New_Zealand/Hamilton" || $time_zone == "New_Zealand/Dunedin" || $time_zone == "New_Zealand/Invercargill"):
																$time_zone = "NZ";
																break;
															case "New_Zealand/Chatham_Islands":
																$time_zone = "NZ-CHAT";
																break;
														}
							
														$client_hour_display = $start_hour;
														if($client_hour_display > 12) $client_hour_display - 12;
														
														//generate ASL calendar schedule
														$client_schedule = $date_start." ".$start_hour.":".$start_minute.":00 ".$type;
														$ref_date = $date_start." ".$start_hour.":".$start_minute.":00";
														$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
														date_default_timezone_set($time_zone);
														$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
														//ended
														
														//convert to admin timezone
														$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
														$destination_date = clone $date;
														$destination_date->setTimezone($admin_timezone);
														$admin_schedule = $destination_date;
														//ended
													//ENDED													
													
													
													$s = mysql_query("SELECT status FROM tb_request_for_interview WHERE id='".$row['request_for_interview_id']."' LIMIT 1");
													$asl_status = mysql_result($s,0,"status");													
													if($asl_status == "")
													{
														$asl_status = "Not found";
													}											
													if($row["start_hour"] < 12)
													{
														$h = $row['start_hour'];														
														$temp = "AM";
													}
													else
													{
														$temp = "PM";
														$h = $row['start_hour'] - 12;
													}			
								?>
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; ">
                                                                    	<td valign="top" onClick="javascript: view_schedule(<?php echo $row["id"]; ?>); "><img src="iconss/timezone.png" width="20"></td>
																		<td valign="top" width="100%" onClick="javascript: view_schedule(<?php echo $row["id"]; ?>); ">
                                                                        
																			<?php 
																				switch ($asl_status) 
																				{
																					case "ACTIVE":
																						$asl_status = "<option value='NEW' selected>New</option>";
																						break;
																					case "ARCHIVED":
																						$asl_status = "<option value='ARCHIVED' selected>Archived</option>";
																						break;
																					case "ON-HOLD":
																						$asl_status = "<option value='ON-HOLD' selected>On Hold</option>";
																						break;															
																					case "HIRED":
																						$asl_status = "<option value='HIRED' selected>Hired</option>";
																						break;															
																					case "REJECTED":
																						$asl_status = "<option value='REJECTED' selected>Rejected</option>";
																						break;		
																					case "CONFIRMED":
																						$asl_status = "<option value='CONFIRMED' selected>Confirmed/In Process </option>";	
																						break;		
																					case "YET TO CONFIRM":
																						$asl_status = "<option value='YET TO CONFIRM' selected>Client contacted, no confirmed date </option>";
																						break;		
																					case "DONE":
																						$asl_status = "<option value='DONE' selected>Interviewed; waiting for feedback</option>";
																						break;
																					case "RE-SCHEDULED":
																						$asl_status = "<option value='RE-SCHEDULED' selected>Confirmed/Re-Booked</option>";
																						break;	
																					case "CANCELLED":
																						$asl_status = "<option value='CANCELLED' selected>Cancelled</option>";
																						break;	
																					default: 
																						$asl_status = $asl_status;
																						break;																																														
																				}	
																				if (strtoupper($asl_status)=="NOT FOUND"){
																					$asl_status = "";
																					if ($initial_interview=="Y"){
																						$asl_status = "INITIAL INTERVIEW";
																					}else if ($meeting=="Y"){
																						$asl_status = "MEETING";
																					}else if ($new_hire_orientation=="Y"){
																						$asl_status = "NEW HIRE ORIENTATION";
																					}else if ($contract_signing=="Y"){
																						$asl_status = "CONTRACT SIGNING";
																					}else{
																						$asl_status = "INITIAL INTERVIEW";
																					}
																					
																					
																				}
																				echo "<font size=1><strong>ADMIN SCHEDULE: </strong> ".$admin_schedule." ".$admin_timezone_display."</font><br />";
																				echo "<font size=1><strong>ASL STATUS/CLIENT SCHEDULE:</strong> ".strtoupper($asl_status)." / ".$client_schedule." ".$timezone_display."</font><br />";
																				echo "<font size=1>\"".strtoupper(@$row["subject"])."\"";
																				
																			?>
                                                                        </td>
                                                                        <td valign="top">
                                                                        	<?php 
																				$view_type = $_SESSION["view_type"];
																				if (isset($_SESSION["view_type"])){
																					$view_type = "other_admin";
																					$selected_admin = $_SESSION["selected_admin"];
																				}else{
																					$view_type = "view";
																					$selected_admin = "";
																				}
                                                                        	
                                                                        	?>
                                                                        
                                                                        
                                                                        	<a href="popup_calendar.php?yearID=<?php echo $row['start_year']; ?>&monthID=<?php echo $row['start_month']; ?>&dayID=<?php echo $row['start_day']; ?>&view_type=<?php echo $view_type?>&selected_admin=<?php echo $selected_admin?>" target="_parent">
                                                                            	<img src="../images/001_44.png" border="0">
                                                                            </a>
                                                                        </td>
																</table>
															</td>
														</tr>
								<?php
													$counter++;
												}	
								?>
										</table>	

</body>
</html>
