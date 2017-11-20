<?
include '../config.php';
include '../function.php';
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
	
	$status=$row['status'];
	$heading=$row['heading'];
	
	$heading =str_replace("\n","<br>",$heading);
	
}




?>



<html>
<head>
<title>Ads ©ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/style.css">
<meta HTTP-EQUIV='Content-Type' charset='utf-8'>
<script src='http://www.jobstreet.com.sg/utility/jsWin.js' language='javascript' type='text/javascript'></script>
<style type="text/css"> 
    .cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
    .cName label{ font-style:italic; font-size:8pt}
    .cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
    .jobRESH {color:#000000; size:2; font-weight:bold}
</style>
<style>
<!--
.ads{
	width:580px;
	
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
<body bgcolor='#FFFFFF' background="../images/sample4abg.jpg">
<div align='center'>
  <table width='650' border='1' cellpadding='0' cellspacing='0' bordercolor="a8a8a8" bgcolor='646464'>
<tr><td width="650">
<table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor="666666">
  <tr><td valign='top' align='center'><br>
  <table width="620" height="100" border="0" cellpadding="0" cellspacing="0" bordercolor="#F4F4F4" bgcolor="#FFFFFF">
 
  <tr>
    <td><table width="625" border="0" align="center" cellpadding="0" cellspacing="0">
      
        <tr><td ><img src="../images/remote_staff_logo.png" alt="think" width="416" height="108"></td>
      </tr>
    </table></td>
  </tr>
 
</table>
        </td>
</tr></table>
<table width="625" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="666666">
  <tr>
    <td><div align="left"><font class="cName"><? //echo $companyname ;?> </b></font><br></div></td>
  </tr>
</table>
<table width="620" height="244" border="0" align="center" cellpadding="10" cellspacing="2"bgcolor="#FFFFFF">
  <tr>
    <td>
<div class="ads">	
	<p align="right"><b><? echo format_date($date_created);?></b></p>
 
  <p align="justify" style="margin-left:30px;"><? echo $heading;?></p>
<h2 align="center"><? echo $jobposition;?></h2>

<p align="justify" style="margin-left:30px;"><b>Skill(s) / Requirements:</b></p>
<ul >
<?
// id, posting_id, responsibility
$sqlRequirement="SELECT requirement FROM posting_requirement WHERE posting_id =$id;";
$result3=mysql_query($sqlRequirement);
while(list($requirement)=mysql_fetch_array($result3))
{
	echo "<li>".$requirement."</li>";
}
?>
</ul>



<p style="margin-left:30px;"><b>Responsibility :</b></p>
<ul>
<?
// id, posting_id, responsibility
$sqlResponsibility="SELECT responsibility FROM posting_responsibility WHERE posting_id =$id;";
$result2=mysql_query($sqlResponsibility);
while(list($responsibility)=mysql_fetch_array($result2))
{
	echo "<li>".$responsibility."</li>";
}
?>
</ul>

	  
	  
</div>	  
	  
      <p align='center'><font size="2" face="verdana"><p><center><br>
	  
	  <form method=post action='#'>
        <input type=submit value='Click Here to Apply' disabled="disabled">&nbsp;</form></center></p><br>
        <br>
      <br>
      <p><br>
      </p>
      </font></p></td>
 
  </tr>
</table><p>&nbsp;</p></td>
</tr></table>
</div>
</html>