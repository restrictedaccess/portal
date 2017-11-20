<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';



date_default_timezone_set("Asia/Manila");

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_status=$_SESSION['status'];

$query="SELECT agent_no,fname,lname FROM agent WHERE status='ACTIVE' AND work_status = 'BP';";
$result=mysqli_query($link2, $query);
while(list($agent_no,$fname,$lname,$work_status)=mysqli_fetch_array($result))
{
	$agentOptions.="<option value='$agent_no'>$fname&nbsp;$lname&nbsp;</option>";
}


				
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add Business Partner In Transfer Leads</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="js/BusinessPartnerTransferLeads.js"></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form name="form" method="post">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Add Business Partner In Transfer Leads Function</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td>
<td colspan="2"></td></tr>
<tr><td width="17%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="83%" valign="top" align="left">
	<div style="padding:10px; font:12px Arial;">
	<div>
	<div style="float:left; display:block; width:120px;"><b>Business Partner :</b></div>
	<select name="agent_no" id="agent_no" class="select">
	<option value="">--</option>
	<?=$agentOptions;?>
	</select>
	&nbsp;<input type="button" id="add_bp" value="Add in the List" onClick="AddBP();">
	</div>
	<div style="clear:both;"></div>
	<div style="margin-top:10px; ">
	<div style="background:#EBEBEB; padding:2px; border:#EBEBEB outset 1px;"><b>Currently in the List</b></div>
	<div style="border:#cccccc solid 1px;">
		<div style="float:left; display:block; width:40px;padding-left:5px;"><b>#</b></div>
		<div style="float:left; display:block; width:400px; border-right:#cccccc solid 1px;border-left:#cccccc solid 1px; padding-left:5px;"><b>Name</b></div>
		<div style="float:left; display:block; width:100px;padding-left:5px;"><b>Promo Code</b></div>
		<div style="float:left; display:block; width:300px;border-left:#cccccc solid 1px;padding-left:5px;"><b>Email</b></div>
		<div style="clear:both;"></div>
	</div>
	<div id="bp_list" style="border:#EBEBEB solid 1px; padding-top:1px;">
	<?
	$query = "SELECT t.id, DATE_FORMAT(t.date_created, '%D %b %Y'),a.fname,a.lname,a.email,a.agent_code FROM agent_transfer_leads t LEFT JOIN agent a ON a.agent_no = t.agent_no;";
	//echo $query;
	$result = mysqli_query($link2, $query);
	$counter=0;
	while(list($id,$date,$fname,$lname,$email,$agent_code)=mysqli_fetch_array($result))
	{
	$counter++;
	?>
	<div style="border:#E9E9E9 solid 1px;">
		<div style="float:left; display:block; width:40px;padding-left:5px;"><?=$counter;?></div>
		<div style="float:left; display:block; width:400px; border-right:#cccccc solid 1px;border-left:#cccccc solid 1px; padding-left:5px;">
		<?=$fname." ".$lname;?></div>
		<div style="float:left; display:block; width:100px;padding-left:5px;"><?=$agent_code;?></div>
		<div style="float:left; display:block; width:300px;border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;padding-left:5px;"><?=$email;?></div>
		<div style="float:left; display:block; border-left:#cccccc solid 1px;padding-left:5px; cursor:pointer; color:#FF0000;" onClick="deleteBP(<?=$id;?>);">delete</div>
		<div style="clear:both;"></div>
	</div>
	<?	
	}
	
	?>
	</div>
	</div>
	</div>
	
	
</td>
</tr>
</table>
</td></tr>
</table>
<? include 'footer.php';?>
</form>
</body>
</html>
