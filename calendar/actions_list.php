<?php
session_start();
require_once("../conf/connect.php") ;
include("style/button_style.php") ;
include("style/text_style.php") ;
$agent_no = $_SESSION['agent_no'] ;
?>

<html>
<head>
<title>Actions</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">

<script type="text/javascript">
	function view_actions(id) {
		previewPath = "action_details.php?id="+id;
		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	}
</script>

</head>
<body bgcolor="#ffffff">



											<table bgcolor=#666666 border=0 cellpadding=0 cellspacing=1 width="100%">
											<?php	
												$db=connsql();
												$c = mysql_query("SELECT * FROM tb_calendar_actions WHERE angent_id='$agent_no'");	
												while ($row = @mysql_fetch_assoc($c)) 
												{
													$id = $row["id"];
													
													$appointment_id = $row["appointment_id"];
													$ag = mysql_query("SELECT leads_id, subject FROM tb_appointment WHERE id='$appointment_id'");
													while ($row_a = @mysql_fetch_assoc($ag))
													{
														$subject = $row_a["subject"];
													}
													
													$angent_id = $row["angent_id"];
													$type = $row["type"];
													$status = $row["status"];
													$date = $row["date_added"];
											?>
														<tr>
															<td valign="top">
																<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
																	<tr>
																		<td onMouseOver="javascript:this.style.background='#F1F1F3'; " onMouseOut="javascript:this.style.background='#ffffff'; " onClick="javascript: view_actions(<?php echo @$row["appointment_id"]; ?>); " bgcolor=#FFFFFF valign="top" width="80%"><?php echo @$subject."&nbsp;(Type: ".$type.")"; ?></td>
																		<td bgcolor=#FFFFFF valign="top" width="20%" align="right"><?php echo @$date; ?></td>
																	</tr>
																</table>
															</td>
														</tr>
											<?php
												}	
											?>
											</table>	


</body>
</html>
