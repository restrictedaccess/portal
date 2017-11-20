<?
include 'config.php';
include 'function.php';
$id=$_REQUEST['id'];
/*
id, agent_id, lead_id, date_created, outsourcing_model, companyname, jobposition, jobvacancy_no, skill, responsibility, status

*/
$query ="SELECT * FROM posting WHERE id = $id;";
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
	$skill=$row['skill'];
	$responsibility=$row['responsibility'];
	$status=$row['status'];
	$heading=$row['heading'];
	
	$heading =str_replace("\n","<br>",$heading);
	//$skill=str_replace("\n","<br>",$skill);
	$responsibility=str_replace("\n","<br>",$responsibility);

	$pieces = explode("\n",$skill);
//echo count($pieces);
	for ($i=0;$i<(count($pieces)-1);$i++)
	{
		$str.="<li>".$pieces[$i]."</li>";
	}	
	
}




?>

<html>
<head>
<title>Ads &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<style>
<!--
.ads{
	width:500px;
	margin:0 0 0 100px;
		}
.ads h2{
	color:#990000;
	font-size: 2.5em;
	}	
.ads p{	
		margin-bottom: 10px;
		margin-top: 4px;
	}
.ads h3
{
	color:#003366;
	font-size: 1.5em;
	margin-left:30px;
}	
-->
</style>
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">


<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/banner/remoteStaff-logo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>Job Title :&nbsp;&nbsp;<? echo $jobposition;?></font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td><br>
<div class="ads">
<p align="right"><? echo format_date($date_created);?></p>
<h3><? echo $companyname ;?></h3>
<p align="justify" style="margin-left:30px;"><? echo $heading;?></p>
<h2 align="center"><? echo $jobposition;?></h2>

<p align="justify" style="margin-left:30px;"><b>Skill(s) / Requirements:</b><br>
 <ul >
 <? echo $str;?>
 </ul>
 </p>


<p style="margin-left:30px;"><b>Responsibility :</b><br>
<ul>
 <? echo $responsibility;?>
</ul> 
 </p>
</div>


		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>

