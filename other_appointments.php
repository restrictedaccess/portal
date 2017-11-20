<html>
<head>
<title>Other Appointments</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<script type="text/javascript">
	function view_schedule(id) {
		previewPath = "get_schedule.php?id="+id;
		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>	
</head>
<body bgcolor="#CCCCCC">

											<table bgcolor="#666666" border=0 cellpadding=1 cellspacing=0 width="100%">
												<?php	
												putenv("TZ=Australia/Sydney");
												require_once("conf/connect.php");
												$time_offset ="0"; // Change this to your time zone
												$time_a = ($time_offset * 120);
												$h = date("h",time() + $time_a);
												$m = date("i",time() + $time_a);
												$d = date("Y-m-d" ,time());
												$type = date("a",time() + $time_a);	
																			
												$db=connsql();
												$return = "";			
												$counter = 0;	
												$agent_no = $_GET["agent_no"];
												$c = mysql_query("SELECT * FROM tb_appointment WHERE user_id='$agent_no' AND date_start > '$d' ORDER BY date_start");	
												while ($row = @mysql_fetch_assoc($c)) 
												{
													$h = $row['start_hour'] ;
													if($row["start_hour"] < 13)
													{
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
																	}								
													}			
								
													if($row["start_hour"] == 12 && $row["start_minute"] < 30)
													{
														$temp = "AM";
													}							
								?>
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; " onClick="javascript: view_schedule(<?php echo $row["id"]; ?>); " bgcolor=#FFFFFF valign="top" width="90%"><?php echo $row["subject"]; ?></td>
																		<td bgcolor=#FFFFFF valign="top" align="right"><?php echo "<b>".$row['start_day']."-".$row['start_month']."-".$row['start_year']."</b>&nbsp;"; echo "<i>".$h; ?>:<?php echo $row["start_minute"]."&nbsp;".$temp."<i>"; ?></td>									
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
