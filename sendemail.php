<?
include 'config.php';
include 'function.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
//echo $agent_no;
$id=$_REQUEST['id'];
/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
*/
$query ="SELECT * FROM leads WHERE id = $id;";
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
<title>Send Email</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript">
<!--
function checkFields()
{
	//if (confirm("Are you sure"))
	//{
	//	return true;
	//}
	//else return false;		
	//alert (document.frmSkills.skill.value);
	
	missinginfo = "";
	if(document.form.txt.value=="")
	{
		missinginfo += "\n     -  There is no message to be send .";
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
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<ul>
<a href="apply_action.php?id=<? echo $id;?>"> << Back </a>
</ul>
<br></td>
<td width=566 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="sendemailphp.php"  onsubmit="return checkFields();">
<input type="hidden" name="id" value="<? echo $id;?>">
<input type="hidden" name="email" value="<? echo $email;?>">
<input type="hidden" name="fullname" value="<? echo $fname." ".$lname;?>">


<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Send Email to :&nbsp;&nbsp;<i><? echo $fname." ".$lname."     (".$email.")";?></i></b></td></tr>
<tr><td colspan=2 >

<textarea name="txt" cols="48" rows="10" wrap="physical" class="text"  style="width:100%"></textarea>

</td></tr>
<tr><td align=right width=30% >&nbsp;</td><td>&nbsp;</td></tr>

<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value="Send Message" name="send" class="button" style="width:120px">
</td></tr></table>
</td></tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br></form>

</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
	<!-- /CONTENT -->
	<br>
	
	
</body>
</html>
