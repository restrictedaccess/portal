 <?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

$mess="";
$mess=$_REQUEST['mess'];
$id=$_REQUEST['id'];
$delete=$_REQUEST['delete'];

if($id=="")
{
	$button="<INPUT type='submit' value='Save' name='save'  id='save' class='button' style='width:120px'>";
}
if($id!="" && $delete=="")
{
	$button="<INPUT type='submit' value='Update' name='update'  id='update' class='button' style='width:120px'>";
	$sql ="SELECT * FROM tracking WHERE id = $id;";
	$result_sql=mysql_query($sql);
	
	$rows = mysql_fetch_array ($result_sql); 
	$code = $rows['tracking_no'];
	$desc = $rows['tracking_desc'];
}

if($delete=="TRUE")
{
	$sqlDeleteTrack="DELETE FROM tracking WHERE id = $id;";
	mysql_query($sqlDeleteTrack);
}
/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$agent_email = $row['email'];
	$length=strlen($agent_code);
	
}



?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
<script type="text/javascript">
<!--
function checkFields()
{
	var str=document.form.promotional_code.value;
	var code=document.form.agent_code.value;
	//alert(code.substr(0,3));
	missinginfo = "";
	if (str.substr(0,3)!=code)
	{
		missinginfo += "\n     -  Please check your Promotional Code. \n  -Your promotional code must start with :"+ code;
	}
	
	if (document.form.promotional_code.value=="")
	{
		missinginfo += "\n     -  Please enter Promotional Code";
	}
	if (document.form.tracking.value=="")
	{
		missinginfo += "\n     -  Please enter Promotional Code Description";
	}
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	
}
function go3(id) 
	{
			if (confirm("Delete this Promotional Code")) {
				location.href = "aff_delete_promocode.php?id="+id;
				//alert(id);
			}
		
	}
-->
</script>
	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="aff_create_promocodephp.php" onSubmit="return checkFields();">
<input type="hidden" name="agent_code" value="<? echo $agent_code;?>">
<input type="hidden" name="id" value="<? echo $id;?>">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top">
<? include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<table width="99%">
<tr>
<td width="230px" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">


<div class="box_blue" >Create Promotional Code</div>
<div class="box_blue_content" >
<?
if($mess==1)
{
	echo "<p align=center style='margin-top:2px;margin-bottom:2px; background : #FFFFCC'><b>New Promotional Code has been Created !</b></p>";
}
if($mess==2)
{
	echo "<p align=center style='margin-top:2px;margin-bottom:2px; background : #FFFFCC'><b>There was an Error ! Please try again..</b></p>";
}
if($mess==3)
{
	echo "<p align=center style='margin-top:2px;margin-bottom:2px; background : #FFFFCC'><b>Promotional Code has been Updated !</b></p>";
}
if($mess==4)
{
	echo "<p align=center style='margin-top:2px;margin-bottom:2px; background : #FFFFCC'><b>Promotional Code has been Deleted !</b></p>";
}

?>
<div id="form_info">
<p>Your promotional code is : <font color="#999999"><b><? echo $agent_code;?></b></font></p>
<p><font color="#999999">Your promotional code sample should be <b><? echo $agent_code;?>HELLO, <? echo $agent_code;?>TEST ,<? echo $agent_code;?>etc...</b></font></p>
<p><label>Promotional Code :</label><input type="text" name="promotional_code" class="text" value="<? echo $code;?>"></p>
<p><label>Code Description :</label><textarea name='tracking' cols=27 rows=5 wrap="physical" class="text" style="width:330px"><?
echo $desc;?></textarea></p>
<p><label>&nbsp;</label><?=$button;?></p>
</div>
<?
$counter = 0;
$query="SELECT id,tracking_no, DATE_FORMAT(tracking_created,'%D %b %Y'),tracking_desc FROM tracking WHERE tracking_createdby =$agent_no
  ORDER BY tracking_created DESC;";
//DATE_FORMAT(a.dateapplied,'%M %e %Y')
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	while(list($id,$tracking_no,$date,$details) = mysql_fetch_array($result))
	{
		$counter++;
		$details=str_replace("\n","<br>",$details);
?>
<span class="leads_wrapper">

<label class="leads_wrapper_label" style="width:80px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:50px;"><a href='javascript: show_hide("<? echo $id;?>");' >view</a></label>
<label class="leads_wrapper_label" style="width:350px; "><? echo $tracking_no;?></label>
<label class="leads_wrapper_label" style="width:90px;"><? echo $date;?></label>

</span>
<div id='<? echo $id;?>' style='display:none; margin-top:5px; margin-bottom:5px; padding:5px 5px 5px 5px;'>
<span style="float:right; margin-right:20px;"><a href='javascript: show_hide("<? echo $id;?>");'title="close"><b>[X]</b></a></span>
<span style="color:#999999;"><? echo $tracking_no;?></span><br>
<span ><a href="aff_create_promocode.php?id=<? echo $id;?>">Edit</a></span> | 
<span ><a href="#" onclick ='go3(<? echo $id;?>); return false;'>Delete</a></span>
<br style="clear:both">
<p># <?=$details;?></p>
</div>
<? 
	}
}
?>


</div>
</td>
</tr>
</table>


<!-- Contents Here -->
</td>
</tr>
<tr><td><? include 'footer.php';?></td></tr>
</table>
</form>	
</body>
</html>
