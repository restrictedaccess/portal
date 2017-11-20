<?php
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



$userid = @$_GET["userid"];
if(@isset($_POST["endorse"]))
{
$client_name = @$_POST["client_name"];
$position = @$_POST["position"];
$status = "Active";
$date_endoesed = date("Y-m-d");

mysql_query("INSERT INTO tb_shortlist_history (userid, position, status, date_listed) VALUES('$userid', '$position', '$status', '$date_endoesed')");

mysql_query("UPDATE applicants SET status='Shortlisted' WHERE userid='$userid' LIMIT 1");
$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$userid' LIMIT 1");
$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
?>
<script language="javascript">
	alert("<?php echo $name; ?> has been successfully added to shortlist.");
	window.close();
</script>
<?php
}
?>

<html>
<head><title>Move Applicant</title>

<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="category/category.css">

<style type="text/css">
<!--
.style2 {color: #666666}
#dhtmltooltip{
position: absolute;
font-family:Verdana;
font-size:11px;
left: -300px;
width: 110px;
height:150px;
border: 5px solid #6BB4C2;
background: #F7F9FD;
padding: 2px;

visibility: hidden;
z-index: 100;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}
#searchbox
{
 padding-left:30px; padding-bottom:5px; padding-top:5px; margin-left:10px;
 border: 8px solid #E7F0F5;
 
}

#searchbox p
{
	margin-top:5px; margin-bottom:5px;
}


.pagination{
padding: 2px;
margin-top:10px; 
text-align:center;

}

.pagination ul{
margin: 0;
padding: 0;
text-align: center; /*Set to "right" to right align pagination interface*/
font-family: tahoma; font-size: 11px;
}

.pagination li{
list-style-type: none;
display: inline;
padding-bottom: 1px;
}

.pagination a, .pagination a:visited{
padding: 0 5px;
border: 1px solid #9aafe5;
text-decoration: none; 
color: #2e6ab1;
}

.pagination a:hover, .pagination a:active{
border: 1px solid #2b66a5;
color: #000;
background-color: #FFFF80;
}

.pagination a.currentpage{
background-color: #2e6ab1;
color: #FFF !important;
border-color: #2b66a5;
font-weight: bold;
cursor: default;
}

.pagination a.disablelink, .pagination a.disablelink:hover{
background-color: white;
cursor: default;
color: #929292;
border-color: #929292;
font-weight: normal !important;
}

.pagination a.prevnext{
font-weight: bold;
}

#tabledesign{
border:#666666 solid 1px;
}
#tabledesign tr:hover{
background-color:#FFFFCC;
}
-->
</style>
</head>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<form method="post" action="?userid=<?php echo @$userid; ?>">













<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">



<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
				<b>Shortlist</b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td valign="top" colspan="2">


					<table cellpadding="3" cellspacing="3" width="100%">
						<tr>
							<td align="left">
								<strong>Select Position: </strong>
							</td>
						</tr>
						<tr>
							<td>
								<?php		

								$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y'),p.outsourcing_model, p.companyname, p.jobposition,p.status,l.fname,l.lname,p.lead_id
								FROM posting p JOIN leads l ON l.id = p.lead_id WHERE p.status='ACTIVE' ORDER BY p.date_created DESC;";
								$result=mysql_query($query);
								$ctr=@mysql_num_rows($result);
								
								
								$output="
								<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
								<tr bgcolor='#666666'>
								<td width='5%' align=LEFT><b><font size='1' color='#FFFFFF'>#</font></b></td>
								<td width='17%' align=left><b><font size='1' color='#FFFFFF'>Job Position</font></b></td>
								<td width='21%' align=left><b><font size='1' color='#FFFFFF'>Company Name</font></b></td>
								<td width='12%' align=left><b><font size='1' color='#FFFFFF'>Client</font></b></td>
								<td width='12%' align=left><b><font size='1' color='#FFFFFF'>Date</font></b></td>
								<td width='14%' align=left><b><font size='1' color='#FFFFFF'>Outsourcing Model</font></b></td>
								<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Status</font></b></td>
								</tr>";
								if ($ctr >0 )
								{
									$bgcolor="#f5f5f5";
									while(list($id,$date,$model,$companyname,$position,$status,$fname,$lname,$lead_id) = mysql_fetch_array($result))
									{
										$counter=@$counter+1;
									
								
									$output.="
										<tr bgcolor=$bgcolor>
												
											  <td width='5%' align=left><font size='1'>$counter) <input type='radio' name='position' value='$id'  onClick='fillAds(this.value)' /> </font></td>
											   <td width='17%' align=left><font size='1'>
											  <a href='ads.php?id=$id' target='_blank' >$position</a></font></td>
												  <td width='21%' align=left><font size='1'>$companyname</font></td>
											  <td width='12%' align=left><b><font size='1'>
											  <a href='#'onClick=javascript:popup_win('./viewLead.php?id=$lead_id',600,600);>$fname &nbsp; $lname</a></font></b></td>
											   <td width='12%' align=left><font size='1'>$date</font></td>
											  <td width='14%' align=left><font size='1'>$model</font></td>
												  <td width='10%' align=left><font size='1'>$status</font></td></tr>";
										 
											  if($bgcolor=="#f5f5f5")
											  {
												$bgcolor="#FFFFFF";
											  }
											  else
											  {
												$bgcolor="#f5f5f5";
											  }
									}	
									//javascript:popup_win(./viewTrack.php?id=$id,500,400);
								
								
								}
								else
								{
									$output.="<tr><td colspan=7 height=100>This client has no Active or Current Job Advertisement. Create a Job Advertisement for this Client? Click <a href='admin_addadvertisement.php?client_id=$id' class='link10'>here</a> </td></tr>";
								}
								$output.="</table>";
								echo $output;		
								?>
		
		
									
							</td>
						</tr>
						<tr>
							<td><input type="submit" value="Move to Shortlist Now" name="endorse"></td>
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
</td></tr>
</table>

</form>					
</body>
</html>



