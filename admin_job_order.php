<?
include 'config.php';
include 'conf.php';
include 'time.php';


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
if($_SESSION['admin_id']==NULL)
{
	header("location:index.php");
}


$leads_id = $_REQUEST['leads_id'];


$sql ="SELECT * FROM admin WHERE admin_id = $admin_id;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$admin_name = "Welcome Admin :".$row['admin_fname']." ".$row['admin_lname'];
}


$queryAllLeads = "SELECT id, lname, fname , company_name,agent_id FROM leads l
					WHERE l.status != 'Inactive' ORDER BY l.fname ASC;";

//echo $queryAllLeads;
$result = mysql_query($queryAllLeads);
while(list($id, $lname, $fname , $company_name)=mysql_fetch_array($result))
{
	$company_name ?  "( ".$company_name." )" : '&nbsp;';
	if($leads_id == $id ) {
		$leads_Options.="<option value=".$id." selected>".$fname." ".$lname."</option>";
	}else{
		$leads_Options.="<option value=".$id.">".$fname." ".$lname."</option>";
	}	
}



?>   
<html>
<head>
<title>Admin Request/Job Form</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="job_order/job_order.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="job_order/admin_job_order.js"></script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
<form name="form">
<input type="hidden" name="MouseX" id="MouseX" value="">
<input type="hidden" name="MouseY" id="MouseY" value="">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<div style="padding-right:20px; FONT: bold 7.5pt verdana; COLOR: #676767; margin:5px;"><?=$admin_name;?></div>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right:#006699 2px solid; width: 170px; vertical-align:top; '>
<? include 'adminleftnav.php';?>
</td>
<td width=100% valign='top'>
<div style="font:bold 15px Arial; padding:5px;">Job Order / Request</div>
<div style="padding:5px; font:12px Arial;">
<div style="padding:5px;"><b>Search</b></div>
<div><input type="text" name="keyword" id="keyword" class="select" value="<?=$keyword;?>" style=" width:285px;" onKeyUp="searchLeadsWithJobOrderRequest();"  >
<input type="button" value="search" style="font:11px Tahoma;" onClick="searchLeadsWithJobOrderRequest();">
Select from the List
	<select id="leads_id" name="leads_id" class="select"  onChange="showLeadsWithJobOrderRequest(this.value)">
	<option value="0">--Choose Lead--</option>
	<?=$leads_Options;?>
	</select>
</div>
</div>
<table width="100%" border="1" >
<tr>
<td width="27%" valign="top">
<div style="padding:3px; background:#CCCCCC; border:#CCCCCC outset 1px;font:12px Arial;">
	<div style="float:left;"><b>Leads</b></div>
	<div style="float:right;"><input type="button" value="refresh" style="font:11px Tahoma;" onClick="showLeadsWithJobOrderRequest(0);"></div>
	<div style=" clear:both;"></div>
</div>
<div id="leads_list" style="border:#CCCCCC solid 1px; font:11px Tahoma;">&nbsp;</div>
</td>
<td width="73%" valign="top">
<div id="right_panel" style="padding:5px; font:12px Arial;"></div>

</td>
</tr>
</table>
</td>
</tr>
</table>
<? include 'footer.php';?>	
<script type="text/javascript">
<!--
showLeadsWithJobOrderRequest(0);
-->
</script>	
</form>	
</body>
</html>
