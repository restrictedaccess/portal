<?
include 'config.php';
include 'conf.php';
if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
$userid = $_SESSION['userid'];
$apply=$_REQUEST['apply'];
$job=$_REQUEST['job'];

$code=$_REQUEST['code'];

$emailaddr = $_SESSION['emailaddr'];

if($code==1)
{
	$mess="<img src='images/problem.gif' alt='Error'><br>";
	$mess.="YOUVE ALREADY APPLIED FOR THIS JOB";
}

if($code==2)
{
	$mess= "THANK YOU FOR APPLYING PLEASE WAIT FOR FURTHER NOTICE FROM US !";
}


if($job!="")
{
	$query ="SELECT * FROM posting WHERE id = $job;";
	$result=mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		//$row = mysql_fetch_array ($result, MYSQL_NUM); 
		$row = mysql_fetch_array($result);
		$date_created = $row['date_created'];
		$outsourcing_model=$row['outsourcing_model'];
		$companyname=$row['companyname'];
		$jobposition=$row['jobposition'];
		$jobvacancy_no=$row['jobvacancy_no'];
		$status=$row['status'];
		$heading=$row['heading'];
		$heading =str_replace("\n","<br>",$heading);
		$apply="SHOW";
	}
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title>Jobs @Think Innovations</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script language=javascript src="js/functions.js"></script>


	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

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
 <li ><a href="applicantHome.php"><b>Home</b></a></li>
  <li ><a href="myresume.php"><b>MyResume</b></a></li>
  <li><a href="myapplications.php"><b>Applications</b></a></li>
  <li class="current"><a href="jobs.php"><b>Search Jobs</b></a></li>
  <?php $hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 17 ); ?>
    <li><a href="javascript:popup_win8('rschat.php?portal=1&email=<?php echo $emailaddr ?>&hash=<?php echo $hash_code ?>',800,600);" title="Open remostaff chat"><b>RSChat</b></a></li>
  <li><a href="applicant_test.php"><b>Take a Test</b></a></li>
</ul>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td width="829">

<?
$counter = 0;
$query="SELECT id,DATE_FORMAT(date_created,'%D %M %Y'),outsourcing_model, companyname, jobposition FROM posting WHERE status='ACTIVE';";
$result=mysql_query($query);

?>

<tr><td valign="top"><b>Job Advertisement List</b></td></tr>
<tr><td valign="top">
<table width=100% cellspacing=1 cellpadding=4 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='3%' align=left>#</td>
<td width='34%' align=left><b><font size='1'>Job Position</font></b></td>
<td width='26%' align=left><b><font size='1'>Company Name</font></b></td>
<td width='19%' align=left><b><font size='1'>Outsourcing Model</font></b></td>
<td width='18%' align=left><b><font size='1'>Date</font></b></td>




</tr>
<?
	$bgcolor="#f5f5f5";
	while(list($id,$date,$model,$companyname,$position) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	

?>
		<tr bgcolor=<? echo $bgcolor;?>>
				
			  <td width='3%' align=left><font size='1'><? echo $counter;?>)</font></td>
		  <td width='34%' align=left><font size='1'> <a href="Ad.php?id=<?php echo $id;?>"  target="_blank"><?php echo $position;?></a></font></td>
		  	  <td width='26%' align=left><font size='1'><? echo $companyname;?></font></td>
			  <td width='19%' align=left><font size='1'><? echo $model;?></font></td>
			   <td width='18%' align=left><font size='1'><? echo $date;?></font></td>
			  
		
			 
			 
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
</td></tr>
</td></tr></table>
<? include 'footer.php';?>
</body>
</html>
