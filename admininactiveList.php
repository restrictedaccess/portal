<?
include 'config.php';
include 'conf.php';
include 'time.php';

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";

$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}
$query=="";
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyname=$_REQUEST['company_name'];
$promotional_code=$_REQUEST['promotional_code'];
$companyaddress=$_REQUEST['company_address'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];

$agent_fname=$_REQUEST['agent_fname'];
$agent_lname=$_REQUEST['agent_lname'];
$date_registered=$_REQUEST['date_registered'];
$month=$_REQUEST['month'];

$monthArray=array("","01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }


if($agent_fname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %M %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %M %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND a.fname ='$agent_fname' ORDER BY l.timestamp DESC;";

}
if($agent_lname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND a.lname = '$agent_lname' ORDER BY l.timestamp DESC;";

}


if($fname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.fname like '$fname' ORDER BY l.timestamp DESC;";

}

if($lname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.lname like '$lname' ORDER BY l.timestamp DESC;";

}

if($fname!="" && $lname!="" )
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.fname ='$fname' AND l.lname ='$lname' ORDER BY l.timestamp DESC;";
}


if($companyname!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.company_name like '$companyname' ORDER BY l.timestamp DESC;";

}

if($promotional_code!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.tracking_no LIKE '$promotional_code%' ORDER BY l.timestamp DESC;";

}

if($companyaddress!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.company_address like '$companyaddress%' ORDER BY l.timestamp DESC;";

}


if($email!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.email = '$email' ORDER BY l.timestamp DESC;";
}

if($mobile!="")
{
$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' AND l.mobile = '$mobile' ORDER BY l.timestamp DESC;";
}

if($date_registered!="")
{
	//echo $date_registered;
	$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
	l.remote_staff_needed,
	l.fname,l.lname,
	l.company_position,
	l.company_name,l.email,l.company_turnover ,l.rating,
	DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
	DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
	a.agent_no,a.fname,a.lname
	FROM leads l
	JOIN agent a ON a.agent_no = l.agent_id
	WHERE l.status = 'Inactive' AND DATE_FORMAT(l.timestamp,'%Y-%m-%d') = '$date_registered' ORDER BY l.timestamp DESC;";
}
//
if($month!="")
{
	//echo $date_registered;
	$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
	l.remote_staff_needed,
	l.fname,l.lname,
	l.company_position,
	l.company_name,l.email,l.company_turnover ,l.rating,
	DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
	DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
	a.agent_no,a.fname,a.lname
	FROM leads l
	JOIN agent a ON a.agent_no = l.agent_id
	WHERE l.status = 'Inactive' AND DATE_FORMAT(l.timestamp,'%m') = '$month' ORDER BY l.timestamp DESC;";
}


if($query=="")
{

$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'),
l.remote_staff_needed,
l.fname,l.lname,
l.company_position,
l.company_name,l.email,l.company_turnover ,l.rating,
DATE_FORMAT(l.inactive_since,'%D %b %Y'),l.personal_id,
DATE_FORMAT(l.date_move,'%D %b %Y'),l.agent_from,
a.agent_no,a.fname,a.lname
FROM leads l
JOIN agent a ON a.agent_no = l.agent_id
WHERE l.status = 'Inactive' ORDER BY l.timestamp DESC;";

}


?>

<html>
<head>
<title>Administrator Inactive</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

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
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<form name="form" method="post" action="adminnewleads.php" >
  <table width="98%" border="0" style="border:#666666 solid 1px; margin-left:10px; margin-right:1px;">
    <tr>
      <td height="21" colspan="8" valign="top"><b>Advanced Search</b></td>
    </tr>
    <tr>
      <td width="10%" align="right">First Name :</td>
      <td width="14%"><input type="text" name="fname" ></td>
      <td width="10%" align="right">Last Name :</td>
      <td width="14%"><input type="text" name="lname" ></td>
      <td width="12%" align="right">Company Name :</td>
      <td width="15%"><input type="text" name="company_name" ></td>
      <td width="10%" align="right">Promotional Code :</td>
      <td width="15%"><input type="text" name="promotional_code" ></td>
    </tr>
    <tr>
      <td height="38" align="right">State :</td>
      <td><input type="text" name="company_address" ></td>
      <td align="right">Email Add :</td>
      <td><input type="text" name="email" ></td>
      <td align="right">Mobile No. :</td>
      <td><input type="text" name="mobile" ></td>
	   <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
	<td height="38" colspan="" align="right"><b>Agent Firstname :</b></td>
      <td colspan=""><input type="text" name="agent_fname" ></td>
      <td align="left"  ><b>Agent Lastname :</b></td>
      <td colspan=""><input type="text" name="agent_lname" ></td>
	   <td align="right"  ><b>Date Registered :</b></td>
      <td colspan=""><input type="text" name="date_registered" value="<?=$date_registered;?>" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "date_registered",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
	   <td align="right"  ><b>Month of :</b></td>
      <td colspan=""><select name="month"  style="font-size: 12px;" class="text" onChange="javascript: document.form.submit();">
<? echo $monthoptions;?>
</select></td>
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
	  </script>	  </td>
    </tr>
	<tr><td colspan="8"><!--<a href="adminaddnewlead.php" class="link12b">Add New Lead</a>-->&nbsp;</td></tr>
  </table>


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

<tr><td>
<!--
<div class="animatedtabs" style="margin-bottom:1px; margin-top:5px; height:30px; border-bottom:none;">
  <ul>
    <li class="selected"><a href="#" style="border-bottom:#CCCCCC solid 1px;"><span>New Leads List</span></a></li>
    <li ><a href="addnewlead.php" style="border-bottom:#CCCCCC solid 1px;"><span>Add New Lead</span></a></li>
	 <li ><a href="transferlead.php" style="border-bottom:#CCCCCC solid 1px;"><span>Agent Transfer Lead</span></a></li>
  </ul>
</div>
-->&nbsp;
</td>
</tr>

<tr><td><table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
  <tr bgcolor='#666666'>
    <td width='2%' align=left><b><font size='1' color='#FFFFFF'>#</font></b></td>
	<td width='13%' align=left><b><font size='1' color='#FFFFFF'>Agent</font></b></td>
    <td width='13%' align=left><b><font size='1' color='#FFFFFF'>Name</font></b></td>
    <td width='11%' align=left><b><font size='1' color='#FFFFFF'>Company Position</font></b></td>
    <td width='9%' align=left><b><font size='1' color='#FFFFFF'>Date Registered</font></b></td>
    <td width='10%' align=LEFT><b><font size='1' color='#FFFFFF'>Promotional Code</font></b></td>
    <td width='12%' align=left><b><font size='1' color='#FFFFFF'>Company</font></b></td>
    <td width='12%' align=left><b><font size='1' color='#FFFFFF'>Email</font></b></td>
    <td width='7%' align=left><b><font size='1' color='#FFFFFF'>Rating</font></b></td>
    <td width='11%' align=left><b><font size='1' color='#FFFFFF'>Remarks</font></b></td>
  </tr>
  <?
	$bgcolor="#FFFFFF";
	//id,tracking_no,DATE_FORMAT(timestamp,'%D %M %Y'),remote_staff_needed,lname,fname,company_position,company_name,email,company_turnover ,rating
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$fname,$lname,$company_position,$company_name,$email,$company_turnover,$rate,$inactive_since,$personal_id,$date_move,$agent_from,$agent_no,$agent_fname,$agent_lname) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
  <tr bgcolor=<? echo $bgcolor;?>>
    <td width='2%' align=left><font size='1'><? echo $counter.")";?>
    </font> </td>
	 <td width='13%' align=left><font size='1'><? echo $agent_fname." ".$agent_lname;?></font></td>
    <td width='13%' align=left><font size='1'><a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);> <? echo $fname." ".$lname;?> </a> </font></td>
    <td width='11%' align=left><font size='1'><? echo $company_position;?></font></td>
    <td width='9%' align=left><font size='1'><? echo $timestamp;?></font></td>
    <td width='10%' align=LEFT><font size='1'><a href='#'onClick=javascript:popup_win('./viewTrack.php?id=<? echo $tracking_no;?>',500,400);><? echo $tracking_no;?></a></font></td>
<!--    <td width='12%' align=center><font size='1'><? echo $remote_staff_needed;?></font></td> -->
    <td width='12%' align=left><font size='1'><? echo $company_name;?></font></td>
    <td width='12%' align=left><font size='1'><? echo $email;?></font></td>
 <!--   <td width='10%' align=left><font size='1'><? //echo $company_turnover;?></font></td> -->
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
    <td width='7%' align=left><font size='1'><? echo $rate;?></font></td>
	  <td width='11%' align=left><font size='1'><? 
			   if($date_move!="")
			   {
			   		$sql="SELECT * FROM agent WHERE agent_no = $agent_from";
					$resulta=mysql_query($sql);
					$ctr=@mysql_num_rows($resulta);
					if ($ctr >0 )
					{
						$row = mysql_fetch_array ($resulta); 
						$name = $row['fname']." ".$row['lname'];
					}
			   		echo "This Lead came from AGENT : " .$name." ".$date_move."<br>";
			   }
			   
			   if($inactive_since!="")
			{	$personalid=substr($personal_id,0,1);
				if($personalid=="C")
				{
					//$remarks ="Move back to Contacted List from Client since ".$inactive_since;
					echo "Move back to Contacted List from Client since ".$inactive_since."<br>";
				}	
			}
			   //echo $remarks;
			   
			   ?></font></td>
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
</table></td>
</tr>
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
	
	
//-->
</script>

	

<? include 'footer.php';?>
</form>	
</body>
</html>
