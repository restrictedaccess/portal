<?php
include 'config.php';
include 'conf.php';

echo $_SESSION['userid'];
$userid = $_SESSION['userid'];

$postingid=$_REQUEST['job'];
$code=$_REQUEST['code'];

if($code==1)
{
	$mess="<img src='images/problem.gif' alt='Error'><br>";
	$mess.="YOUVE ALREADY APPLIED FOR THIS JOB";
}

if($code==2)
{
	$mess= "THANK YOU FOR APPLYING PLEASE WAIT FOR FURTHER NOTICE FROM US !";
}

if($code==3 || $userid=="")
{
	$mess="<div align='left'><img src='images/problem2.gif' alt='Error'></div>";
	$mess .= "<div align='left'><p><b>PLEASE LOGIN FIRST or REGISTER!</b></p>
	
	</div>";
}


$query ="SELECT * FROM posting WHERE id = $postingid;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);
	$companyname=$row['companyname'];
	$jobposition=$row['jobposition'];
}



?>

<html>
<head>
<title>Apply Online</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{
	if(document.form.userid.value=="")
	{
		alert("Please login First before you can Apply to our JobAdvertisement..");
		return false;
	}
	return true;
	
}
-->
</script>	
<style>
<!--
#dropin{
	position:absolute;
	margin-top:40px;
	margin-left:750px;
	background: #F7F9FD;
	border: 1px solid #CFE7F3;
	font-family:Verdana;
	font-size:12px;

}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="index.php"><b>Home</b></a></li>
  <li class="current"><a href="ads_list.php"><b>Advertisements</b></a></li>
</ul>

<div id="dropin">
<table width="210" border="0" cellspacing="1" cellpadding="0">
                        <tr> 
                          <td bgcolor="fafdee"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="3">
                              <tr> 
                                <td><img src="images/spacer.gif" width="1" height="10"></td>
                              </tr>
                              <tr> 
                                <td><img src="images/ad_philapplicants.gif" width="205" height="232" border="0" usemap="#MapMapMap"></td>
                              </tr>
                            </table>
                            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="3">
                              <tr> 
                                <td>&nbsp;</td>
                              </tr>
                              <tr> 
                                <td><div align="center"><a href="ads_list.php"><img src="images/side_openings.gif" width="146" height="37" border="0"></a></div></td>
                              </tr>
                              <tr> 
                                <td class="side"><img src="images/spacer.gif" width="1" height="10"></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>

</div>
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<br></td>
<td width=566 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<TR><TD>
<div style="background-color:#FFFFCC;; margin-top:10px; margin-bottom:10px; height:100px; padding:5 5 5 5px; border:#000000 solid 1px; ">
  <img src='images/problem2.gif' alt='Error'>
  <p><b>1) YOU ARE NO YET CURRENTLY LOGIN!</b></p>
  <p><b>2) NOT YET REGISTERED ? CLICK <a href="personal.php" class="link12b">HERE</a></b></p>
</div>
</TD></TR>
<tr><td>
<form name="form" action="applyphp2.php" method="post" onSubmit="return checkFields();" >
<input type="hidden" name="postingid" value="<? echo $postingid;?>" />
<input type="hidden" name="userid" value="<? echo $userid;?>" />
<table cellSpacing="0" cellPadding="0" width="100%" border="0" >

<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Apply Online</b></td></tr>
<tr>
<td>
<table cellspacing=2 cellpadding=2 border='0' width='100%' align=center>
  <tr><td colspan=2>&nbsp;</td></tr>
<tr><td align=right width='50%'><strong>Position Title</strong> :</td>
<td width="50%" class=title><? echo $jobposition;?></td>
</tr>
<tr><td align=right width='50%'><strong>Company Name</strong> :</td>
<td class=title><span class="style2"><? echo $companyname;?></span></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr></table></td>
</tr>
<tr bgcolor="#000000">
<td><img src="/imagenes/spcr.gif" width=1 height=2></td>
</tr>
<tr>
<td ></td>
</tr>

<tr>
<td align="center" >						
<input type="submit" name="ok" value="Apply Online"  />
<input type="button" name="view"  alt="Back to you JOB SEEKER'S HOME" value="<< Back to Home" onClick="self.location='ads_list.php'"/></td>
</tr>
</table>


<!-- --->
<br></form>

</td></tr></table></td></tr></table>
				</td></tr>
	  </table>
		</td></tr>
</table><br>
<br>
<br>
<br>

<? include 'footer.php';?>	
</body>
</html>
