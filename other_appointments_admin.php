<html>
<head>
<title>Other Appointments</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<script type="text/javascript">
	function view_schedule(id) {
		previewPath = "get_schedule_admin.php?id="+id;
		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>	
</head>
<body bgcolor="#CCCCCC">

											<table bgcolor="#666666" border=0 cellpadding=1 cellspacing=0 width="100%">
												<?php	
												include 'config.php';
												include 'conf.php';
												
												//SESSION CHECKER
												if($_SESSION['admin_id']=="")
												{
													echo '
													<script language="javascript">
														alert("Session expired.");
														window.close();
													</script>
													';
													exit;
												}
												//ENDED												
												
												//get the hour-minute-seconds-timetype-date
												date_default_timezone_set('Asia/Manila');
												$time_offset ="0";   
												$time_a = ($time_offset * 120);
												$t = date("h:i:s",time() + $time_a);
											
												//convert to manila time
												$phl_tz = new DateTimeZone('Asia/Manila');
												$date_time_asia_manila = new DateTime($t);
												$date_time_asia_manila->setTimezone($phl_tz);
												$h = $date_time_asia_manila->format('g');	
												$m = $date_time_asia_manila->format('i');	
												$type = $date_time_asia_manila->format('a');	
												$d = date("Y-m-d");
												//ended	
																	
																			
												$return = "";			
												$counter = 0;	
												$agent_no = $_GET["agent_no"];

												if($_SESSION['interview_id'] <> "")
												{
													$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='$agent_no' AND date_start > '$d' AND request_for_interview_id='".$_SESSION['interview_id']."' ORDER BY date_start";
												}
												else
												{
													$q = "SELECT * FROM tb_app_appointment WHERE status='active' AND user_id='$agent_no' AND date_start > '$d' ORDER BY date_start";
												}	
												$c = mysql_query($q);	
												while ($row = @mysql_fetch_assoc($c)) 
												{
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
																	switch($row['start_hour'])
																	{
																		case 13:
																			$h = 1;
																			break;
																		case 14:
																			$h = 2;
																			break;
																		case 15:
																			$h = 3;
																			break;
																		case 16:
																			$h = 4;
																			break;
																		case 17:
																			$h = 5;
																			break;
																		case 18:
																			$h = 6;
																			break;
																		case 19:
																			$h = 7;
																			break;
																		case 20:
																			$h = 8;
																			break;
																		case 21:
																			$h = 9;
																			break;
																		case 22:
																			$h = 10;
																			break;
																		case 23:
																			$h = 11;
																			break;
																		case 24:
																			$h = 12;
																			break;
																		default:
																			$h = $row['start_hour'];
																			break;	
																	}								
													}			
								
													//if($row["start_hour"] == 12)
													//{
														//$temp = "AM";
													//}							
								?>
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; " onClick="javascript: view_schedule(<?php echo $row["id"]; ?>); " bgcolor=#FFFFFF valign="top" width="90%">
																			<?php 
																				echo strtoupper(@$row["subject"]); 
																				echo "<br /><font size=1>Calendar Status: (".strtoupper($row["status"]).")</font>";
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
																				echo "<br /><font size=1>ASL Status: (".strtoupper($asl_status).")</font>";
																			?>
                                                                        </td>
																		<td bgcolor=#FFFFFF valign="top" align="right"><?php echo "<b>".$row['start_day']."-".$row['start_month']."-".$row['start_year']."</b>&nbsp;"; echo "<i>".$h; ?>:<?php if($row["start_minute"] == 0) echo "00".$temp."<i>"; else echo $row["start_minute"].$temp."<i>"; ?></td>									
                                                                        <td valign="top"><a href="application_calendar/popup_calendar.php?yearID=<?php echo $row['start_year']; ?>&monthID=<?php echo $row['start_month']; ?>&dayID=<?php echo $row['start_day']; ?>" target="_parent"><img src="images/001_44.png" border="0"></a></td>
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
