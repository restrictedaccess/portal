<?
include 'conf.php';
include 'config.php';
include 'function.php';
include 'time.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$userid=$_REQUEST['userid'];
$leads_id=$_REQUEST['leads_id'];
$subcotractors_id=$_REQUEST['subcotractors_id'];
$mess=$_REQUEST['mess'];

$query="SELECT * FROM personal p  WHERE p.userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$image= $row['image'];
	$name =$row['fname']." ".$row['lname'];
	$skype=$row['skype_id'];
	$email =$row['email'];
	if($image=="")
		{
			$image="images/Client.png";
		}
}	


$query3="SELECT * FROM leads   WHERE id=$leads_id";
$result3=mysql_query($query3);
$ctr3=@mysql_num_rows($result3);
if ($ctr3 >0 )
{
	$row3 = mysql_fetch_array ($result3); 
	$clients_name =$row3['fname']." ".$row3['lname'];
}	


$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$admin_email = $row['admin_email'];
	
}

$sql2="SELECT * FROM agent WHERE email ='$admin_email';";
$result2=mysql_query($sql2);
$ctr3=@mysql_num_rows($result2);
if ($ctr3 >0 )
{
	$rowa = mysql_fetch_array ($result2); 
	$agent_no = $rowa['agent_no'];
	
}

$sql4 = "SELECT DISTINCT l.id, l.lname, l.fname FROM leads l WHERE status='Client' ORDER BY l.fname ASC;";

$result4=mysql_query($sql4);
while(list($lead_id, $client_lname, $client_fname) = mysql_fetch_array($result4))
{
	 $client_fullname =$client_fname." ".$client_lname;
	 if ($kliyente==$leads_id)
	 {
	 	$usernameOptions2 .="<option selected value= ".$lead_id.">".$client_fullname."</option>";
	 }
	 else
	 {
	 	$usernameOptions2 .="<option  value= ".$lead_id.">".$client_fullname."</option>";
	 }	
}

if(isset($_POST['update']))
{
	$userid=$_REQUEST['userid'];
	$leads_id=$_REQUEST['leads_id'];
	$subcotractors_id=$_REQUEST['subcotractors_id'];
	$kliyente=$_REQUEST['kliyente'];
	
	////Update First the subcontractor table
	$sqlUpdate="UPDATE subcontractors SET status = 'MOVE',move_date ='$ATZ' WHERE id = $subcotractors_id;";
	$res = mysql_query($sqlUpdate);
	
	if($res){
		/// if successful
		// insert new record
		$sqlInsert="INSERT INTO subcontractors SET leads_id = $kliyente, 
					agent_id = $agent_no, 
					userid = $userid ,
					posting_id = 0,
					starting_date ='$ATZ',
					status = 'ACTIVE';";
		mysql_query ($sqlInsert) or trigger_error("Query: $sql2\n<br />MySQL Error: " . mysql_error());
		$sqlInsert2="INSERT INTO applicants SET posting_id = 0, 
			userid = $userid, 
			status = 'Sub-Contracted', 
			date_apply = '$ATZ';";
		mysql_query ($sqlInsert2) or trigger_error("Query: $sql3\n<br />MySQL Error: " . mysql_error());
		//echo $sqlInsert."<br><br>".$sqlInsert2;
		//header("location:subconlist.php");
		echo("<html><head><script>function update(){top.location='update_subcon_client.php?userid=$userid&leads_id=$kliyente&subcotractors_id=$subcotractors_id&mess=1';}var refresh=setInterval('update()',1200);
	</script></head><body onload=refresh><body></html>");
	
	
	}
	
	
}

?>

<html>
<head>
<title>Recruitment Process Notes</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">

<link rel="stylesheet" href="css/light.css" type="text/css" />

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>
</head>

<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">
<form method="post" name="form" action="update_subcon_client.php">
<input type="hidden" name="leads_id" id="leads_id" value="<?=$leads_id;?>">
<input type="hidden" name="userid" id="userid" value="<?=$userid;?>">
<input type="hidden" name="subcotractors_id" id="subcotractors_id" value="<?=$subcotractors_id;?>">
<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;<font style='font: bold 10pt verdana;'>Update Sub-Contractor <?=$name;?> Client</font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td valign="top" bgcolor="#FFFFFF">
	<div class="album" style="width:600px;">
	<? if ($mess==1) {?>
		<div class="thumb"></div>
						<div class="albumdesc" id="albumdesc" >
					<h3>Successfully Updated</h3>
					<p>Sub-Contractor <?=$name;?> will be working to Client : <b><?=$clients_name;?></b></p>
			</div>
				<p style="clear: both; "></p>
				<? } else {?>
				<div class="thumb"><a href="#" title="View Online Resume: <? echo $name;?>" onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);"><img src="<? echo $image;?>" width="110" height="150" /></a></div>
						<div class="albumdesc" id="albumdesc" >
<h3><a href="#" title="View Online Resume : <? echo $fname." ".$lname;?>" onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);"><? echo $name;?></a></h3>

<?
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
$row2 = mysql_fetch_array ($result2); 
$latest_job_title=$row2['latest_job_title'];
?>
<h2 style="margin-top:5px; margin-bottom:5px;"><?=$latest_job_title?></h2>
 							<small>Skype ID: <? echo $skype;?><br>
							Email : <? echo $email;?></small><br>
							<p><small>Sub-Contracted to Client: <b><?=$clients_name;?></b></small></p>
							<p>Will now be Sub-Contracted to Client : 
							<select name="kliyente" id="kliyente" class="select" >
							<option value="0">-</option>
							<?=$usernameOptions2;?>
							</select>
							</p>
							<p align="center"><input type="submit" name="update" id="update" value="Update"></p>
							<p>&nbsp;</p>
				</div>
				<p style="clear: both; "></p>
				<? }?>
			</div>
		
	</td></tr>
	</table>
</form>
	</body>
	</html>

