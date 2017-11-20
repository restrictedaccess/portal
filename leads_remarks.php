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
<body>
											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td bgcolor=#FFFFFF valign="top" width="90%"><strong>REMARKS</strong></td>
																	</tr>		
																	<?php	
																		require_once("conf/connect.php");
																		$db=connsql();
																		$id = @$_GET["id"];
																		$c = mysql_query("SELECT * FROM leads_remarks WHERE leads_id='$id'");	
																		while ($row = @mysql_fetch_assoc($c))
																		{
																			
																	?>																															
																	<tr>
																		<td>
																			<table bgcolor="#F7F7F7" cellpadding="2" cellspacing="2">
																				<tr>
																					<td bgcolor=#F7F7F7 valign="top" width="90%"><strong><?php echo $row["remark_creted_by"]; ?></strong></td><td align="right"><i><?php echo $row["remark_created_on"]; ?></i></td>																			
																				</tr>
																				<tr>
																					<td colspan="2"><?php echo $row["remarks"]; ?></td>
																				</tr>																				
																			</table>
																		</td>
																	</tr>
																
																	<?php
																		}	
																		
																		
																			if(@isset($_POST["submit_notes"]))
																			{
																				$date_posted = date("Y-m-d");
																				$sender = "Unknown";
																				$c = mysql_query("SELECT fname, lname FROM leads WHERE id='$id'");	
																				while ($r = @mysql_fetch_assoc($c))
																				{
																					$sender = $r["fname"]." ".$r["lname"];
																				}
																				
																				$notes_id = $_GET["id"];
																				$notes = $_POST["notes"];
																				mysql_query("INSERT INTO leads_remarks(leads_id, remark_creted_by, created_by_id, remarks, remark_created_on) VALUES('$id', '$sender', '$id', '$notes', '$date_posted')");												
																			}																		
																		
																		diesql($db)
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