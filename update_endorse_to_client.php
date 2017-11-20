<?
include 'config.php';
include 'conf.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}

$id = @$_GET["id"];

$query = "SELECT *
FROM tb_endorsement_history
WHERE id='$id'";
$query = mysql_query($query);
$date_time = mysql_result($query,0,"final_Interview");
$status = mysql_result($query,0,"status");
$comment = mysql_result($query,0,"comment");
$position = mysql_result($query,0,"position");
$userid = mysql_result($query,0,"userid");

$p_query = "SELECT email FROM personal WHERE userid='$userid'";
$p_query = mysql_query($p_query);
$p_email = mysql_result($p_query,0,"email");


if(@isset($_POST["save"]))
{
		$final_Interview = $_POST["date_time"];
		$comment = $_POST["comment"];
		$status = $_POST["status"];
		mysql_query("UPDATE tb_endorsement_history SET final_Interview='$final_Interview', comment='$comment', status='$status' WHERE id='$id'");
			
		if($status == "Rejected")
		{	
			//RESPONDER -----------------------------------------------------------------------------------------		
			$from_email="ricag@remotestaff.com.au";
			$subject ="Welcome to RemoteStaff";
			
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	
			
			//SIGNATURE
			$admin_id = $_SESSION['admin_id'];
			$admin_status=$_SESSION['status'];
			$site = $_SERVER['HTTP_HOST'];
			
			$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
			$resultAgentCheck=mysql_query($sql);
			$result = mysql_fetch_array ($resultAgentCheck); 		
			
			$name = $result['admin_fname']." ".$result['admin_lname'];
			$admin_email=$result['admin_email'];
			$signature_company = $result['signature_company'];
			$signature_notes = $result['signature_notes'];
			$signature_contact_nos = $result['signature_contact_nos'];
			$signature_websites = $result['signature_websites'];
			
			if($signature_notes!=""){
				$signature_notes = "<p><i>$signature_notes</i></p>";
			}else{
				$signature_notes = "";
			}
			if($signature_company!=""){
				$signature_company="<br>$signature_company";
			}else{
				$signature_company="<br>RemoteStaff";
			}
			if($signature_contact_nos!=""){
				$signature_contact_nos = "<br>$signature_contact_nos";
			}else{
				$signature_contact_nos = "";
			}
			if($signature_websites!=""){
				$signature_websites = "<br>Websites : $signature_websites";
			}else{
				$signature_websites = "";
			}
			 
			$signature_template = $signature_notes;
			$signature_template .="<a href='http://$site/$agent_code'>
						<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
			$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
			//END SIGNATURE
			
			
			$date=date('l jS \of F Y h:i:s A');
			

			if (@isset($position))
			{
				if($position == 0)
				{
					$p = "<p>Thank you for your interest and application with RemoteStaff.</p>";
				}
				else
				{
					$p = "<p>Thank you for your interest and application with RemoteStaff as a ".$position.".";
				}	
			}	
			else
			{
				$p = "<p>Thank you for your interest and application with RemoteStaff.</p>";
			}		
			
			$body = "
			<html>
			<head>
			<title>Application Status</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
			</head>
			
			<body>
			".$p."
			<p>Unfortunately other applicants are considered to have more relevant skills and experience to meet the requirements of our current client. As such, we are unable to continue with your application at this time. </p>
			<p>However as your application was of a high standard we would like to keep your details on file should a more suitable opportunity arise. Should such an opportunity become available you will be notified by email. </p>
			<p>To view current open positions please <a href='http://www.remotestaff.com.au/jobopenings.php'>click HERE</a>.</p>
			<p>If you do not wish for us to send you updates please respond with &quot;NO THANKS&quot; on your subject line. </p>
			<p>We hope that you find the opportunity that you are looking for.&nbsp; </p>
			<p>".$signature_template."</p>
			</body>
			</html>
			";
			mail($p_email, $subject, $body, $header);		
			//RESPONDER -------------------------------------------------------------------------
		}	

?>
		<script language="javascript">
			alert("Your changes has been saved.");
			window.close();
		</script>
<?php
}
?>
<html>
<head>
<title>Endorsement History</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">



<form name="form" method="post" action="?id=<?php echo @$_GET["id"]; ?>">
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="32" colspan="2" valign="middle">
			<table width="100%">
				<tr>
					<td colspan="3" height="24"><strong>Update</strong></td>
				</tr>
				<tr>
					<td width="11%" height="28">Status</td>
					<td width="1%">:</td>
					<td width="88%">
						<select name="status" class="select">
                                    						<?php
																	switch ($status) 
																	{
																		case "On Hold":
																			echo "<option value=\"$status\" selected>On Hold</option>";
																			break;																	
																		case "Hired":
																			echo "<option value=\"$status\" selected>Hired</option>";
																			break;
																		case "Rejected":
																			echo "<option value=\"$status\" selected>Rejected</option>";
																			break;
																		default:
																			echo "<option value='' selected>Any</option>";
																			break;
																	}
															?>
                                    <option value="On Hold">On Hold</option>
                                    <option value="Hired">Hired</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="">Any</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="11%" height="28" valign="top">Final&nbsp;Interview(Date/Time)</td>
					<td width="1%" valign="top">:</td>
					<td width="88%">
                      <input type="text" id="subject_id" name="date_time" class="text" style="width:40%" value="<?php echo $date_time; ?>">
                      <em>Yr-Mon-Day</em> <em>Hr-Min-Sec</em><br />
				</tr>						
				<tr>
					<td colspan="3">
						<div id="client_details" >&nbsp;</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
					Comment
					</td>
				</tr>					
				<tr>
					<td colspan="3">
					<textarea name="comment" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><?php echo $comment; ?></textarea>
					</td>
				</tr>				
				<tr>
					<td>
					<INPUT type="submit" value="Save" name="save" class="button" style="width:120px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top"></td>
	</tr>
</table>
</form>




</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
 
</body>
</html>



