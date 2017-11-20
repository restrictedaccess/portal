<?
include 'config.php';
include 'function.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
$hid =$_REQUEST['hid'];
$mode =$_REQUEST['mode'];
$hmode =$_REQUEST['hmode'];

if($hmode!="" && $hmode=='delete')
{
	$query="DELETE FROM history WHERE id=$hid;";
	mysql_query($query);
	
}

$sql ="SELECT * FROM history WHERE id = $hid;";
$res=mysql_query($sql);
$ctr=@mysql_num_rows($res);
if ($ctr >0)
{
	$row = mysql_fetch_array($res);
	$desc=$row['history'];;
	
	
}
//echo $agent_no;
$leads_id=$_REQUEST['id'];
/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
*/
$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);

	
	
}
?>

<html>
<head>
<title>Job Advertisement Process</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<script type="text/javascript">
<!--
function checkFields()
{
	missinginfo = "";
	if(document.form.txt.value=="")
	{
		missinginfo += "\n     -  There is no history or details to be save \t \n Please enter details.";
	}
	if (document.form.mode.value =="")
	{
		if (document.form.fill.value=="" )
		{
			missinginfo += "\n     -  Please choose actions.";
		}
	}	
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;

	
}
-->
</script>	
<style type="text/css">
<!--
	div.scroll {
		height: 100px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
	}
	.spanner
	{
		float: right;
		text-align: right;
		padding:5px 0 5px 10px;
	
	
	}
	.spannel
	{
		float: left;
		text-align:left;
		padding:5px 0 5px 10px;
		border:#f2cb40 solid 1px;
		
	}	
	#l {
	float: left;
	width: 390px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r{
	float: right;
	width: 100px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
-->
</style>	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->

<? include 'header.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="1043">
<tr><td width="1043" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=1042 cellpadding=0 cellspacing=0 border=0 align=center>
  <tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=578 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=800 cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="apply_actionphp2.php"  onsubmit="return checkFields();">
<input type="hidden" name="id" value="<? echo $leads_id;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="fill" value="">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="hid" value="<? echo $hid;?>">
<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">

<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><b>Job Advertisement Process </b></td>
</tr>
<tr><td height="237" colspan=2 valign="top" >
<div id="leads">
<p>Job Advertisement for : &nbsp;<b><? echo $fname." ".$lname;?></b></p>
<p align="right"><a href="updateinquiry.php?leads_id=<? echo $leads_id;?>">Edit</a> &nbsp;&nbsp;</p>

<p><label>Date Registered	:</label><? echo format_date($timestamp);?></p>
<p><label>Job Position	:</label><? echo $company_position;?></p>
<p><label>Company name	:</label><? echo $company_name;?></p>
<p><label>Company Address	:</label><? echo $company_address;?></p>
<p><label>Email	:</label><? echo $email;?></p>
<p><label>Website	:</label><? echo $website;?></p>
<p><label>Company No.	:</label><? echo $officenumber;?></p>
<p><label>Moblie No.	:</label><? echo $mobile;?></p>





</div>

</td></tr>


<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><strong>Outsourcing Model</strong></td>
</tr>
<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
  <tr>
  <td width="22%">
  <input type="radio" name="outsourcing_model" value="Home Office" > Home Office
  </td>
  <td width="21%">
  <input type="radio" name="outsourcing_model" value="Office Location" > Office Location
  </td>
  <td width="21%">
  <input type="radio" name="outsourcing_model" value="Project Base"  > Project Base
  </td>
  </tr>
  </table>
  
</td></tr>
<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><strong>Confined Client Needs / Job Titles</strong></td>
</tr>

<tr><td colspan="2" valign="top">
<table width=100% border=0 cellspacing=1 cellpadding=2>
  <tr>
  <td width="20%" align="right">Job Position :&nbsp;</td>
  <td width="48%" ><input type="text" name="jobposition" value="" size="50"> </td>
 <td width="31%">No. 
   <input type="text" name="jobvacancy_no" value="" size="3"></td>
 <td width="1%"></td>
  </tr>

<tr>
<td valign="top" align="right" >Skill(s) / Requirements :&nbsp;</td>
<td ><textarea name="skill" cols="40" rows="5" wrap="physical" class="text"  style="width:90%"><? echo $desc;?></textarea></td>
</tr> 

<tr>
<td valign="top" align="right">Responsibilities :&nbsp;</td>
<td><textarea name="responsibility" cols="40" rows="5" wrap="physical" class="text"  style="width:90%"><? echo $desc;?></textarea></td>
</tr> 
</table>
</td>
</tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br></form>

</td></tr></table></td>
<td width="291" valign="top">&nbsp;</td>
</tr></table>
				</td></tr>
	  </table>
		</td>
		
		
  </tr>
</table>
	<!-- /CONTENT -->
	<br>
	
	
</body>
</html>
