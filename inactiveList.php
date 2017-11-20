<?
include 'config.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];

$query=="";

$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyname=$_REQUEST['company_name'];
$promotional_code=$_REQUEST['promotional_code'];
$companyaddress=$_REQUEST['company_address'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];


/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, rating
*/
if($fname!="")
{

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND fname like '$fname' ORDER BY timestamp DESC;";

}

if($lname!="")
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND lname like '$lname' ORDER BY timestamp DESC;";

}

if($fname!="" && $lname!="" )
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND fname='$fname' AND lname ='$lname' ORDER BY timestamp DESC;";
}


if($companyname!="")
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND company_name like '$companyname' ORDER BY timestamp DESC;";

}

if($promotional_code!="")
{

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND tracking_no LIKE '$promotional_code' ORDER BY timestamp DESC;";

}

if($companyaddress!="")
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND company_address like '%$companyaddress%' ORDER BY timestamp DESC;";
}


if($email!="")
{

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND email = '$email' ORDER BY timestamp DESC;";

}

if($mobile!="")
{
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating
FROM leads l 
WHERE agent_id =$agent_no and status ='Inactive' AND mobile = '$mobile' ORDER BY timestamp DESC;";
}



if($query=="")
{ //id, tracking_no, agent_id, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating, personal_id, date_move, agent_from, authenticate, opt
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),DATE_FORMAT(l.inactive_since,'%D %M %Y'),lname, fname, company_position,company_name,email, company_turnover ,rating

FROM leads l 

WHERE agent_id =$agent_no and status ='Inactive'

 ORDER BY timestamp DESC;;";
}

/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_home, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program, contacted_since, client_since, inactive_since, rating
*/
?>

<html>
<head>
<title>Inactive List</title>
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
<? include 'BP_header.php';?>
<!-- /CONTENT -->
<br>
<div id="searchControl" style="border:#666666 solid 1px; margin-left:20px; margin-right:20px;">
<form name="form" method="post" action="inactiveList.php" >
  <table width="80%" border="0">
    <tr>
      <td height="21" colspan="8" valign="top"><b>Advanced Search</b></td>
    </tr>
    <tr>
      <td align="right">First Name :</td>
      <td><input type="text" name="fname" ></td>
      <td align="right">Last Name :</td>
      <td><input type="text" name="lname" ></td>
      <td align="right">Company Name :</td>
      <td><input type="text" name="company_name" ></td>
      <td align="right">Promotional Code :</td>
      <td><input type="text" name="promotional_code" ></td>
    </tr>
    <tr>
      <td height="38" align="right">State :</td>
      <td><input type="text" name="company_address" ></td>
      <td align="right">Email Add :</td>
      <td><input type="text" name="email" ></td>
      <td align="right">Mobile No. :</td>
      <td><input type="text" name="mobile" ></td>
    </tr>
    <tr>
      <td colspan="8" align="center"><input type="submit" name="search" value="Search" onClick="show();">
	  <div align="center"  id="searching"></div>
	  <script type="text/javascript">
	  <!--
	  function show()
	  {
	  	newitem1="<img src=\"images/loading.gif\" alt=\"loading\">Searching.......";
		document.getElementById("searching").innerHTML=newitem1;
	  }
	  -->
	  </script>
	  </td>
    </tr>
  </table>
</form>
</div>
<?
$counter = 0;
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
?>
<table width=97% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>No Longer a Prospect List</b><br>
<br>
Click the button to move them back on the active list.<br>
<br>

</td></tr>
<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1>
</td></tr>
<tr><td>
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='4%' align=left>#</td>
<td width='9%' align=center><b><font size='1'>Promotional Code</font></b></td>
<td width='9%' align=left><b><font size='1'>Date Registered</font></b></td>
<td width='12%' align=left><b><font size='1'>Not a Prospect Since</font></b></td>
<td width='14%' align=left><b><font size='1'>Name</font></b></td>
<td width='10%' align=left><b><font size='1'>Company Position</font></b></td>
<td width='11%' align=left><b><font size='1'>Company</font></b></td>
<td width='12%' align=left><b><font size='1'>Email</font></b></td>
<td width='10%' align=left><b><font size='1'>Company Turnover</font></b></td>
<td width='9%' align=left><b><font size='1'>Rating</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($id,$tracking_no,$timestamp,$date,$lname,$fname,$company_position,$company_name,$email,$company_turnover,$rate) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
		<tr bgcolor=<? echo $bgcolor;?>>
			  <td width='4%' align=left><font size='1'><? echo $counter.")";?>
	      <input type="radio" name="action" value="<? echo $id;?>" onclick ="go(<? echo $id;?>,'<? echo $fname." ".$lname;?>'); return false;"></font></td>
			  <td width='9%' align=center><font size='1'><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></font></td>
			  <td width='9%' align=left><font size='1'>
			  <? echo $timestamp;?></font></td>
			  <td width='12%' align=left><font size='1'><? echo $date;?></font></td>
			  <td width='14%' align=left><font size='1'>
			  <a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);>
			  <? echo $fname." ".$lname;?>			  </a>
			  </font></td>
			  <td width='10%' align=left><font size='1'><? echo $company_position;?></font></td>
			  <td width='11%' align=left><font size='1'><? echo $company_name;?></font></td>
			  <td width='12%' align=left><font size='1'><? echo $email;?></font></td>
			   <td width='10%' align=left><font size='1'><? echo $company_turnover;?></font></td>
			  <?
			  if($rate=="1")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
			  
			  
			  ?>
			  <td width='9%' align=left><font size='1'><? echo $rate;?></font></td>
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
				location.href = "moveBack.php?id="+id;
				//alert(id);
			//}
		
	}
	
	
//-->
</script>

	

	
</body>
</html>
