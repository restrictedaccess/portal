<?
include './conf/zend_smarty_conf_root.php';
include 'config.php';
include 'time.php';
$agent_no = $_SESSION['agent_no'];
//echo $agent_no;
$mess="";
$mess=$_REQUEST['mess'];
$id ="";
$id=$_REQUEST['id'];
$mode = $_REQUEST['mode'];

$folder =$_REQUEST['folder'];
if($folder=="")
{
	$folder='NEW';
}

/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code
*/

$sql ="SELECT * FROM agent WHERE agent_no = $agent_no;";
$res=mysql_query($sql);
$ctr2=@mysql_num_rows($res);
if ($ctr2 >0 )
{
	$row = mysql_fetch_array ($res); 
	$agent_code = $row['agent_code'];
	$lname = $row['lname'];
	$fname = $row['fname'];
	//$desc= str_replace("\n","<br>",$desc);
	
}

$query ="SELECT * FROM tracking WHERE id = $id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$code = $row['tracking_no'];
	$desc = $row['tracking_desc'];
	//$desc= str_replace("\n","<br>",$desc);
	
}


//insert the business partner default promo codes  , outboundcall , inboundcall
$promocodes_Array =  array($agent_code , $agent_code.'OUTBOUNDCALL' , $agent_code.'INBOUNDCALL');
for($i=0;$i<count($promocodes_Array);$i++){
	$sql = "SELECT * FROM tracking t WHERE tracking_no = '".$promocodes_Array[$i]."' AND tracking_createdby = $agent_no;";
	$result =  $db->fetchAll($sql);
	if(count($result) == 0){
		$data = array(
			'tracking_no' => $promocodes_Array[$i], 
			'tracking_desc' => $promocodes_Array[$i], 
			'tracking_created' => $ATZ, 
			'tracking_createdby' => $agent_no, 
			'status' => 'NEW'
				);
		$db->insert('tracking', $data);	
	}
}

?>
<html>
<head>
<title>Promotional Code</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
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
	//if (confirm("Are you sure you Want to add"))
	//{
	//	return true;
	//}
	//else return false;		
	
	
}
-->
</script>	
<style type="text/css">
<!--
	div.scroll {
		height: 200px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
-->
</style>		
	
	
</head>
<script language=javascript src="js/functions.js"></script>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="100%" bgcolor="#ffffff" align="center">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess=="1") {echo "<center><b><font color='#FF0000' size='1'>There's an error in adding new Track . Please try again</font></b></center>"; }?>
<? if ($mess=="2") {echo "<center><b><font color='#0000FF' size='1'>New Track added successfuly. </font></b></center>"; }?>
<? if ($mess=="3") {echo "<center><b><font color='#0000FF' size='1'>Track Deleted. </font></b></center>"; }?>
<? if ($mess=="4") {echo "<center><b><font color='#0000FF' size='1'>Track Updated. </font></b></center>"; }?>
</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="addtrackingphp.php"  onsubmit="return checkFields();">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="id" value="<? echo $id;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="agent_code" value="<? echo $agent_code;?>">

<table width=66% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td bgcolor=#DEE5EB colspan=3><b>Add Promotional Codes</b></td>
</tr>
<tr><td colspan=3 >Welcome <? echo $fname." ".$lname;?>.  &nbsp;&nbsp;Your promotional code is : <font color="#999999"><b><? echo $agent_code;?></b></font></td></tr>
<tr><td colspan=3 ><font color="#999999">your promotional code sample <b><? echo $agent_code;?>HELLO, <? echo $agent_code;?>TEST ,<? echo $agent_code;?>etc...</b></font></td></tr>

<tr><td align=right width=26% >Promotional Code :</td>
<td width="55%" valign="top" colspan="2"><input type="text" name="promotional_code" value="<? echo $code;?>"></td></tr>


<tr><td align=right width=26% valign=top >Description :</td>
<td colspan="2" ><textarea name='tracking' cols=27 rows=5 wrap="physical" class="text" style="width:330px"><?
echo $desc;?></textarea></td></tr>
<tr><td align=right colspan="3" ></td>
</tr>

<tr><td colspan=3>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value="Save" name="Add" class="button" style="width:120px">
&nbsp;&nbsp;
<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">
</td></tr></table>
</td></tr>
</table>
<!-- skills list -->
<br clear=all><br>
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td valign="top"><br><b><a href="addtracking.php?folder=NEW" class="link10">Promotional Codes List</a></b><br><br></td><td align="right" valign="top"><br><b><a href="addtracking.php?folder=ARCHIVE" class="link10">Archive List</a></b><br><br></td></tr>
<tr><td bgcolor=#333366 height=1 colspan="2">
<img src='images/space.gif' height=1 width=1>
</td></tr>
<?
$counter = 0;
/*
$query="SELECT id,tracking_no, DATE_FORMAT(tracking_created,'%D %b %Y'), tracking_createdby,tracking_desc,points 
FROM tracking 
WHERE tracking_createdby =$agent_no
AND status ='$folder' ORDER BY tracking_created DESC;";
*/
$query="SELECT DISTINCT(t.id),t.tracking_no, DATE_FORMAT(t.tracking_created,'%D %b %Y'), t.tracking_createdby,t.tracking_desc,t.points , SUM(p.hits)
FROM tracking t
LEFT OUTER JOIN promocodes_hits p ON p.tracking_id = t.id
WHERE t.tracking_createdby = $agent_no
AND t.status ='$folder'
GROUP BY t.id;";

//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
?>

<tr><td colspan="2" valign="top">
<div class='scroll'>

<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB style="font:12px Arial;">
<tr >
<td width='3%' align=left>#</td>
<td width='19%' align=left><b><font size='1'>Promo Code</font></b></td>
<td width='4%' align=center><b><font size='1'>Registered</font></b></td>
<td width='4%' align=center><b><font size='1'>Clicks</font></b></td>
<td width='10%' align=left><b><font size='1'>Date Created</font></b></td>
<td width='35%' align=left><b><font size='1'>Details</font></b></td>
<td width='13%' align=left><b><font size='1'>Action</font></b></td>
</tr>
<?
	$bgcolor="#f5f5f5";
	while(list($id,$tracking_no,$date,$creator,$details,$points,$clicks) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		if($points==NULL){ $points=0; }
		if ($clicks ==NULL){ $clicks="0"; };
		if ($tracking_no =="")$tracking_no="&nbsp;";
		
?>
		<tr bgcolor=<? echo $bgcolor;?>>
			  <td width='3%' align=left><font size='1'><? echo $counter;?></font></td>
			  <td width='19%' align=left><font size='1'>
			  <a href='#'onClick=javascript:popup_win('./viewTrack2.php?id=<? echo $id;?>',500,400); title="<? echo $details;?>"><? echo $tracking_no;?></a> </td>
			  <td width='4%' align=center><font size='1'><? echo $points;?></font></td>
			  <td width='4%' align=center><font size='1'><? echo $clicks;?></font></td>
			  <td width='10%' align=left><font size='1'><? echo $date;?></font></td>
			  <td width='35%' align=left><font size='1'><? echo $details;?></font></td>
			  <? if ($folder=="ARCHIVE") {
			  ?>
			  <td width='13%' align=left><font size='1'><a href='#' onclick ='go3(<? echo $id;?>); return false;'>Delete</a> | 
			  <a href='#' onclick ='go4(<? echo $id;?>); return false;'>Back</a> 
			  </font></td>
			  <?
			  }
			  else{
			  ?>
			  <td width='16%' align=left><font size='1'><a href='#' onclick ='go(<? echo $id;?>); return false;'>Move to Archive</a> | 
			  <a href='#' onclick ='go2(<? echo $id;?>); return false;'>Edit</a>
			  </font></td>
			  <? }?>
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
</div>
	</td></tr>
	<tr><td bgcolor=#333366 height=1 colspan="2">
	<img src='images/space.gif' height=1 width=1></td></tr></table>
	
	
<?	
}
?>



<!-- --->
<br></form>
<script language=javascript>
<!--
	function go(id) 
	{
			if (confirm("Move to Archive")) {
				location.href = "deletetrack.php?id="+id;
				//alert(id);
			}
		
	}
	function go2(id) 
	{
		location.href = "addtracking.php?mode=update&id="+id;
	}
	function go3(id) 
	{
			if (confirm("Delete this Promotional Code")) {
				location.href = "deletetrack2.php?id="+id;
				//alert(id);
			}
		
	}
	function go4(id) 
	{
		location.href = "deletetrack3.php?id="+id;
	}
	
//-->
</script>
</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
<? include 'footer.php';?>		
	
</body>
</html>
