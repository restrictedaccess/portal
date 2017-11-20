<?
include 'config.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
$mess="";
$mess=$_REQUEST['mess'];




?>

<html>
<head>
<title>Applicant List</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{
	if (confirm("Are you sure"))
	{
		return true;
	}
	else return false;		
	//alert (document.frmSkills.skill.value);
	
	//missinginfo = "";
	//if (missinginfo != "")
	//{
	//	missinginfo =" " + "You failed to correctly fill in the required information:\n" +
	//	missinginfo + "\n\n";
	//	alert(missinginfo);
	//	return false;
	//}
	//else return true;

	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li class="current"><a href="#"><b>Applications</b></a></li>
  <li><a href="#"><b>Advertisements</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li ><a href="client_listings.php"><b>Clients</b></a></li>
</ul>

<?
$counter = 0;
/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status
*/
$query="SELECT userid,DATE_FORMAT(datecreated,'%D %M %Y'),lname, fname,gender, nationality FROM personal";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
?>
<table width=97% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>Applicant List</b><br>
<br></td></tr>
<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1>
</td></tr>
<tr><td>
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='5%' align=left>#</td>
<td width='10%' align=left><b><font size='1'>Date Registered</font></b></td>
<td width='9%' align=center><b><font size='1'>Name</font></b></td>
<td width='15%' align=left><b><font size='1'>Gender</font></b></td>
<td width='15%' align=left><b><font size='1'>Nationality</font></b></td>

</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($userid,$datecreated,$lname, $fname,$gender, $nationality) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
		<tr bgcolor=<? echo $bgcolor;?>>
			  <td width='5%' align=left><font size='1'><? echo $counter.".";?> </td>
     		  <td width='12%' align=left><font size='1'>
			  <? echo $datecreated;?>
			 
			  </font></td>
			   <td width='11%' align=left><font size='1'>
			    <a href="resume2.php?userid=<? echo $userid;?>" target="_blank">
			  <? echo $fname." ".$lname;?>
			  </a>
			   </font></td>
			  <td width='11%' align=left><font size='1'><? echo $gender;?></font></td>
			  <td width='13%' align=left><font size='1'><? echo $nationality;?></font></td>
	    </tr>
			 <?
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	?>
</table>
	</td></tr>
	<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1></td></tr></table>
<script language=javascript>
<!--
	function go(id,name) 
	{
			//if (confirm("You selected " + name + " ?")) {
				location.href = "resume2.php?userid="+id;
				//alert(id);
			//}
		
	}
	
	
//-->
</script>

	
<?	
}else{ echo "<font class='text1'>No Records to be shown.</font>"; }
?>

	
	
</body>
</html>
