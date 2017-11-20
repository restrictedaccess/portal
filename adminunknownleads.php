<?
include 'config.php';
include 'conf.php';
include 'time.php';

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

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

//// TRANSFER LEADS
if(isset($_POST['transfer']))
{
	$applicants =$_REQUEST['leads_list'];
	$agent_id=$_REQUEST['agent_id'];
	//echo $applicants;
	///////
	$query="SELECT * FROM agent WHERE agent_no =$agent_id;";
	$result=mysql_query($query);
	$ctr=@mysql_num_rows($result);
		if ($ctr >0 )
		{
			$row = mysql_fetch_array ($result); 
			$agent_code=$row['agent_code'];
		}	
	///////
	
	
	$users=explode(",",$applicants);
	for ($i=0; $i<count($users);$i++)
	{
		$sql="UPDATE leads SET  agent_id =$agent_id,date_move='$ATZ',tracking_no = '$agent_code',status = 'New Leads' WHERE id = $users[$i];";
		mysql_query($sql)or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
		//echo $sql."<br>";
	}
	//echo count($users);
		
		echo("<html><head><script>function update(){top.location='adminunknownleads.php';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
	
}
///// DELETE LEADS
if(isset($_POST['delete']))
{
	$applicants =$_REQUEST['leads_list'];
	$users=explode(",",$applicants);
	for ($i=0; $i<count($users);$i++)
	{
		$sql="DELETE FROM leads WHERE id = $users[$i];";
		mysql_query($sql)or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
	}
	
}


if($query=="")
{

$query="SELECT l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'), l.remote_staff_needed, l.fname,l.lname, l.company_position, l.company_name,
l.email,l.company_turnover ,l.personal_id
FROM leads l 

WHERE l.tracking_no =''

OR l.agent_id=0

ORDER BY l.timestamp DESC;";

}

///
$sqlBBTransferLeads = "SELECT t.agent_no,CONCAT(a.fname,' ',a.lname) FROM agent_transfer_leads t LEFT JOIN agent a ON a.agent_no = t.agent_no;";
$data = mysql_query($sqlBBTransferLeads);

while(list($bp_no,$agent_name)=mysql_fetch_array($data))
{
	$BPOptions.="<option value='$bp_no'>$agent_name</option>";
}


?>


<html>
<head>
<title>Administrator Unknown Leads</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkAll(field)
{
userval2 =new Array();
if (field==null)
{
	alert("There is no Selection to be Processed!");
	return false;
}
else
{
	if((field.length)!=undefined)
	{
		for (i = 0; i < field.length; i++)
		{
	   		field[i].checked = true ;
			userval2.push(field[i].value);	
		}
		document.getElementById("leads_list").value=(userval2);
	}
	else
	{
		document.getElementById("leads_list").value = document.getElementById("list").value;
		document.getElementById("list").checked = true ;
	}
}
}

-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<form name="form" method="post" action="adminunknownleads.php" >
<?
//echo $query;
$counter = 0;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
?>
<table width=99% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>Unknown Leads </b><br>
<br></td></tr>
<tr><td height="47">&nbsp;<input type="submit" name="delete" value="Delete Permanently"> &nbsp;<input type="submit" name="transfer" value="Move"> Move Selected Leads to <select name="agent_id" class="select">
<?=$BPOptions;?>
</select>  </td></tr>
<tr><td><table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
  <tr bgcolor='#666666'>
    <td width='5%' align=left><b><font size='1' color='#FFFFFF'>#</font></b></td>
	 <td width='2%' align=left><b><font size='1' color='#FFFFFF'><img src="images/action_check.gif" alt="Select All" 
	 onClick="checkAll(document.form.list)" style="cursor: pointer; "></font></b></td>
    <td width='14%' align=left><b><font size='1' color='#FFFFFF'>Name</font></b></td>
	 <td width='14%' align=left><b><font size='1' color='#FFFFFF'>Company</font></b></td>
    <td width='12%' align=left><b><font size='1' color='#FFFFFF'>Company Position</font></b></td>
	<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Company Turnover</font></b></td>
    <td width='9%' align=left><b><font size='1' color='#FFFFFF'>Date Registered</font></b></td>
    <td width='11%' align=LEFT><b><font size='1' color='#FFFFFF'>Promotional Code</font></b></td>
     <td width='11%' align=left><b><font size='1' color='#FFFFFF'>Email</font></b></td>
	  <td width='12%' align=left><b><font size='1' color='#FFFFFF'>Remote Staff Needed</font></b></td>
  </tr>
  <?
	$bgcolor="#FFFFFF";
	//l.id,l.tracking_no,DATE_FORMAT(l.timestamp,'%D %b %Y'), l.remote_staff_needed, l.fname,l.lname, l.company_position, l.company_name,l.email,l.company_turnover ,l.personal_id
	while(list($id,$tracking_no,$timestamp,$remote_staff_needed,$fname,$lname,$company_position,$company_name,$email,$company_turnover ,$personal_id) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
?>
 <tr bgcolor=<?=$bgcolor;?>>
    <td width='5%' align=left><?=$counter;?> )</td>
	 <td width='2%' align=left><input name="list" type="checkbox" onClick="check_val(<? echo $id;?>);" value="<?=$id;?>" ></td>
   <td width='14%' align=left><font size='1'>
	<a href='#'onClick=javascript:popup_win('./viewLead.php?id=<? echo $id;?>',600,600);> <? echo $fname." ".$lname;?> </a> </font>	</td>
	   <td width='14%' align=left><b><font size='1' ><?=$company_name;?></font></b></td>
   <td width='12%' align=left><font size='1'><? echo $company_position;?></font></td>
   <td width='10%' align=left><b><font size='1' ><?=$company_turnover?></font></b></td>
   <td width='9%' align=left><font size='1'><? echo $timestamp;?></font></td>
    <td width='11%' align=LEFT><b><font size='1' ><?=$tracking_no;?></font></b></td>
 
    <td width='11%' align=left><b><font size='1'><?=$email;?></font></b></td>
	 <td width='12%' align=left><b><font size='1' ><?=$remote_staff_needed;?></font></b></td>
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
<input type='hidden' id='leads_list' name="leads_list" >
<script type="text/javascript">
<!--
function check_val()
{

userval =new Array();
var userlen = document.form.list.length;
if((userlen)!=undefined)
{
	for(i=0; i<userlen; i++)
	{
		if(document.form.list[i].checked==true)
		{	
			userval.push(document.form.list[i].value);
		}
	}
	document.getElementById("leads_list").value=(userval);
}
else
	{
		document.getElementById("leads_list").value = document.getElementById("list").value;
		document.getElementById("list").checked = true ;
	}
}

-->
</script>

	

<? include 'footer.php';?>
</form>	
</body>
</html>
