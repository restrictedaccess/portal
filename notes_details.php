<?php
session_start();
?>
<html>
<head>
<title>Notes Details</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<script type="text/javascript">
	function view_notes(id) {
		previewPath = "notes_details.php?id="+id;
		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>	
</head>

											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
											<?php	
												require_once("conf/connect.php");
												$db=connsql();
												
												if(@$_GET["action"] == "archive")
												{
													$id = @$_GET["id"];
													mysql_query("UDPATE tb_calendar_notes SET status='1' WHERE id='$id'");	
											?>
													<script language="javascript">
														alert("The issue has been sucessuflly moved to archive.");
														window.close();
													</script>
											<?php
												}
												
												if(@isset($_POST["submit_notes"]))
												{
													$date_posted = date("Ymd");
													
													
													
													$sender = "Unknown";
													if(@isset($_SESSION['agent_no']))
													{
														$ag = $_SESSION['agent_no'];
														$c = mysql_query("SELECT fname, lname FROM agent WHERE agent_no='$ag'");	
														while ($r = @mysql_fetch_assoc($c))
														{
															$sender = $r["fname"]." ".$r["lname"];
														}
													}
													elseif(@isset($_SESSION['admin_id']))
													{	
														$ad = $_SESSION['admin_id'];
														$c = mysql_query("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='$ad'");	
														while ($r = @mysql_fetch_assoc($c))
														{
															$sender = $r["admin_fname"]." ".$r["admin_lname"];
														}
													}	
													
													
													
													$notes_id = $_GET["id"];
													$notes = $_POST["notes"];
													mysql_query("INSERT INTO tb_remarks(sender, notes_id, notes, date_added) VALUES('$sender', '$notes_id', '$notes', '$date_posted')");												
												}
												
												$id = $_GET["id"];
												$c = mysql_query("SELECT * FROM tb_calendar_notes WHERE id='$id'");	
												while ($row = @mysql_fetch_assoc($c))
												{
													$a = $row["user_id"];
											?>
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>ISSUES/PROBLEMS</strong></td>
																	</tr>																
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>Date Added: </strong><?php echo $row["date_posted"]; ?></td>
																	</tr>																
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>Name: </strong><?php echo $a; ?></td>
																	</tr>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>Category: </strong><?php echo @$row["category"]; ?></td>
																	</tr>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>Notes: </strong><?php echo @$row["notes"]; ?></td>
																	</tr>		
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><input type="button" onClick="javascript: window.location='?action=archive&id=<?php echo @$_GET["id"]; ?>'; " value="Move this issue to Archive"></td>
																	</tr>																																																			
																</table>
															</td>
														</tr>
											<?php
												}	
											?>
											</table>	
											
											<br />

											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>REMARKS</strong></td>
																	</tr>		
																	<?php	
																		$c = mysql_query("SELECT * FROM tb_remarks WHERE notes_id='$id'");	
																		while ($row = @mysql_fetch_assoc($c))
																		{
																	?>																															
																	<tr>
																		<td>
																			<table bgcolor="#F7F7F7" cellpadding="2" cellspacing="2">
																				<tr>
																					<td bgcolor=#F7F7F7 valign="top" width="90%"><strong><?php echo $row["sender"]; ?></strong></td><td align="right"><i><?php echo $row["date_added"]; ?></i></td>																			
																				</tr>
																				<tr>
																					<td colspan="2"><?php echo $row["notes"]; ?></td>
																				</tr>																				
																			</table>
																		</td>
																	</tr>
																
																	<?php
																		}	
																	?>																	
																</table>
															</td>
														</tr>

											</table>
											
											<br />

											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
														<tr>
															<td valign="top">
																<table width="100%" cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>CREATE REMARKS</strong></td>
																	</tr>		
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%">
																			<form method="POST" name="form" action="?id=<?php echo $id; ?>">
																			<textarea name="notes" style='height:80px;  width:450px; color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'></textarea><br />
																			<input type="submit" name="submit_notes" value="Submit" style='color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;'>
																			</form>
																		</td>																			
																	</tr>
																</table>
															</td>
														</tr>
											</table>											

</body>
</html>											