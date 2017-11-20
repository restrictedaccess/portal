<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
$userid = $_SESSION['userid'];

$query="SELECT * FROM personal p  WHERE p.userid=$userid";
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['fname']."  ".$row['lname'];
}
?>
<html>
<head>
<title>Sub-Contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<style type="text/css">
<!--
.style2 {color: #666666}
-->
</style>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<? echo $userid?>">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>

<ul class="glossymenu">
 <li ><a href="subconHome.php"><b>Home</b></a></li>
  <li ><a href="subcon_myresume.php"><b>MyResume</b></a></li>
  <li class="current"><a href="subcon_myapplications.php"><b>Applications</b></a></li>
   <li><a href="subcon_jobs.php"><b>Search Jobs</b></a></li>
</ul>


<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?> this is your Application Status</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><? include 'subcon_leftnav.php';?></td>
<td width="1081" valign="top">
<ul  style="border:#CCFFCC solid 3px; margin-top:10px;">
<li><strong>Unprocessed</strong> <span class="style2">= your resume has not yet been evaluated</span></li>
<li><strong>Pre-screeened</strong> <span class="style2">= your resume has been evaluated</span></li>
<li><strong>Shortlisted</strong> <span class="style2">= your resume has been re-evaluated and you will be contacted for an interview soon</span>;</li>
<li><strong>Kept for Reference</strong><span class="style2"> = we will be reconsidering you for future vacancies</span></li>
<li><strong>Rejected</strong><span class="style2"> = your application was unsuccessful</span></li>
</ul>
<!-- list here -->
<?
$counter = 0;
$query="SELECT a.status,DATE_FORMAT(a.date_apply,'%D %b %Y'),p.id,p.companyname,p.jobposition
FROM applicants a
JOIN posting p ON p.id = a.posting_id
WHERE a.userid= $userid
AND p.status ='ACTIVE';";
$result=mysql_query($query);

?>
<table width=100% cellspacing=1 cellpadding=4 align=center border=0 bgcolor="#666666" >
<tr><td height="36" colspan="5" valign="top">
<font color="#FFFFFF"><b>List of Jobs that you Applied and your current Application Status</b></font>
</td>
</tr>
<tr bgColor='#c0e0f5'>
<td width='4%' align=left>#</td>
<td width='28%' align=left><b><font size='1'>Job Position</font></b></td>
<td width='41%' align=left><b><font size='1'>Company Name</font></b></td>
<td width='13%' align=center><b><font size='1'>Status</font></b></td>
<td width='14%' align=left><b><font size='1'>Date</font></b></td>




</tr>
<?
	$bgcolor="#f5f5f5";
	while(list($status,$date,$id,$companyname,$position) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	

?>
		<tr bgcolor=<? echo $bgcolor;?>>
				
			  <td width='4%' align=left><font size='1'><? echo $counter;?>)</font></td>
		  <td width='28%' align=left><font size='1'> 
		  <a href="javascript:popup_win('./Ad.php?id=<? echo $id;?>',800,800);" class='t3'><?php echo stripslashes($position);?></a></font></td>
		  	  <td width='41%' align=left><font size='1'><? echo $companyname;?></font></td>
			  <td width='13%' align=center><font size='1'><? echo $status;?></font></td>
			   <td width='14%' align=left><font size='1'><? echo $date;?></font></td>
			  
		
			 
			 
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
	//javascript:popup_win(./viewTrack.php?id=$id,500,400);
?>	
</table>

<!-- list ends here -->
</td>
</tr>
</table>


<? include 'footer.php';?>
</body>
</html>
