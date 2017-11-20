<?
include 'config.php';
include 'conf.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];

if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$agent_code = $row['agent_code'];
	$length=strlen($agent_code);
}

if(isset($_POST['search']))
{

$query="";
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
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND fname like '$fname' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND fname like '$fname' ORDER BY fname ASC;";

}

if($lname!="")
{

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND lname like '$lname' ORDER BY fname ASC;";

//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND lname like '$lname' ORDER BY fname ASC;";


}

if($fname!="" && $lname!="" )
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND fname ='$fname' AND lname ='$lname' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND fname ='$fname' AND lname ='$lname' ORDER BY fname ASC;";

}


if($companyname!="")
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND company_name like '$companyname' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND company_name like '$companyname' ORDER BY fname ASC;";

}

if($promotional_code!="")
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND tracking_no LIKE '$promotional_code%' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND tracking_no LIKE '$promotional_code%' ORDER BY fname ASC;";

}

if($companyaddress!="")
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND company_address like '$companyaddress%' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND company_address like '$companyaddress%' ORDER BY fname ASC;";

}


if($email!="")
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND email = '$email' ORDER BY fname ASC;";

$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND email = '$email' ORDER BY fname ASC;";

}

if($mobile!="")
{
//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' AND mobile = '$mobile' ORDER BY fname ASC;";
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no AND mobile = '$mobile' ORDER BY fname ASC;";

}

}

if($query=="")
{

//$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
//FROM leads l
//WHERE status = 'New Leads' AND SUBSTRING(l.tracking_no,1,$length)='$agent_code' ORDER BY fname ASC;";
$query="SELECT id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
FROM leads l
WHERE status = 'New Leads' AND agent_id =$agent_no ORDER BY fname ASC;";

}


if(isset($_POST['transfer']))
{
	$applicants =$_REQUEST['applicants'];
	$agent_id=$_REQUEST['agent_id'];
	$users=explode(",",$applicants);
	for ($i=0; $i<count($users);$i++)
	{
		$query="UPDATE leads SET  agent_id =$agent_id,date_move='$ATZ',agent_from=$agent_no WHERE id = $users[$i];";
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		$queryUpdateHistory = "UPDATE history SET agent_no = $agent_id WHERE leads_id = $users[$i];";
		mysql_query($queryUpdateHistory)or trigger_error("Query: $queryUpdateHistory\n<br />MySQL Error: " . mysql_error());	
		//echo $query."<br>";
	}
		//echo "AGENT ID :".$agent_id."<br>".$leads;
		echo("<html><head><script>function update(){top.location='transferlead.php';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
}
?>

<html>
<head>
<title>Transfer New Leads</title>
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
<form name="form" method="post" action="transferlead.php" >
<input type="hidden" name="applicants" value="">

<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li><a href="#"><b>Advertisements</b></a></li>
  <li class="current"><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<!-- /CONTENT -->
<br>
<div id="searchControl" style="border:#666666 solid 1px; margin-left:20px; margin-right:20px;">

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
	<tr><td colspan="8"><a href="addnewlead.php" class="link12b">Add New Lead</a></td></tr>
  </table>

</div>
<?
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
?>
<table width=99% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>New Leads List</b><br>
<br></td></tr>

<tr><td><div class="animatedtabs" style="margin-bottom:1px; margin-top:5px; height:30px; border-bottom:none; float:left; width:500px;">
  <ul>
    <li ><a href="newleads.php" style="border-bottom:#CCCCCC solid 1px;"><span>New Leads List</span></a></li>
    <li ><a href="addnewlead.php" style="border-bottom:#CCCCCC solid 1px;"><span>Add New Lead</span></a></li>
	 <li class="selected"><a href="transferlead.php" style="border-bottom:#CCCCCC solid 1px;"><span>Business Partner Transfer Lead</span></a></li>
  </ul>
</div>
<div style="float:right; margin-top:5px; margin-bottom:1px; margin-right:50px; height:30px;">
<input type="submit" name="transfer" class="text" value="Begin Tranfer to" >&nbsp;:&nbsp;
<select name="agent_id" class="text">
<option value="2">chrisjchrisj@yahoo.com - Chris Jankulovski</option>
<option value="8">onlineremotestaff@gmail.com  - Barbara  Campbell</option>
</select>
</div>
</td>
</tr>

<tr><td valign="top" >
</td>
</tr>

<tr><td>
<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
<td width='8%' align=left><b><font size='1' color='#FFFFFF'>#</font></b></td>
<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Name</font></b></td>
<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Company Position</font></b></td>
<td width='9%' align=left><b><font size='1' color='#FFFFFF'>Date Registered</font></b></td>
<td width='9%' align=center><b><font size='1' color='#FFFFFF'>Promotional Code</font></b></td>
<td width='12%' align=left><b><font size='1' color='#FFFFFF'>RemoteStaff Needed</font></b></td>
<td width='11%' align=left><b><font size='1' color='#FFFFFF'>Company</font></b></td>
<td width='12%' align=left><b><font size='1' color='#FFFFFF'>Email</font></b></td>
<td width='9%' align=left><b><font size='1' color='#FFFFFF'>Rating</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$lname,$fname,$company_position,$company_name,$email,$company_turnover,$rate) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
		<tr bgcolor=<? echo $bgcolor;?>>
			  <td width='8%' align=left><font size='1'><? echo $counter.")";?>
	           <input type="radio" name="action" value="<? echo $id;?>" onclick ="go(<? echo $id;?>,'<? echo $fname." ".$lname;?>'); return false;">
			   <input type="checkbox" onClick="check_val()" name="users" value="<? echo $id;?>" >
			   
	      </font></td>
			    <td width='10%' align=left><font size='1'><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);>
			  <? echo $fname." ".$lname;?>			  </a>
			  </font></td>
			   <td width='10%' align=left><font size='1'><? echo $company_position;?></font></td>
			    <td width='9%' align=left><font size='1'><? echo $timestamp;?></font></td>
			  <td width='9%' align=center><font size='1'><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></font></td>
			 
			  <td width='12%' align=center><font size='1'><? echo $remote_staff_needed;?></font></td>
			 
			 
			  <td width='11%' align=left><font size='1'><? echo $company_name;?></font></td>
			  <td width='12%' align=left><font size='1'><? echo $email;?></font></td>
			  
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
				location.href = "apply_action.php?id="+id;
				//alert(id);
			//}
		
	}
	function check_val()
{
	var ins = document.getElementsByName('users')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
	if(ins[i].checked==true)
	vals[j]=ins[i].value;
	j++;
	}

document.form.applicants.value=(vals);
}
	
//-->
</script>

	

<? include 'footer.php';?>	
</form>
</body>
</html>
