<?php
header("location:http://www.remotestaff.com.ph/jobopenings.php?jr_cat_id=1&category_id=4");
exit;

include 'config.php';
include 'conf.php';
$userid = $_SESSION['userid'];
?>

<html>
<head>
<title>Jobs @Think Innovations</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/ads.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{
	if (confirm("Are you sure"))
	{
		return true;
	}
	else return false;		
	//alert (document.frmSkills.skill.value);
	
	//missinginfo = "";
	//if (missinginfo != "")
	//{
	//	missinginfo =" " + "You failed to correctly fill in the required information:\n" +
	//	missinginfo + "\n\n";
	//	alert(missinginfo);
	//	return false;
	//}
	//else return true;

	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="index.php"><b>Home</b></a></li>
  <li class="current"><a href="ads_list.php"><b>Advertisements</b></a></li>
</ul>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td >
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0" background="images/bgbody.gif">
    <tr> 
      <td class="bodytop"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td valign="bottom"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr> 
                  <td background="images/line_top.gif" bgcolor="#FFFFFF"><div align="right"><img src="images/line_dsyn.gif" width="61" height="10"></div></td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="top"> 
            <td>
<table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;</td></tr><tr><td class="title"><div align="center">Available Jobs</div></td></tr>
<tr><td>&nbsp;</td></tr></table>
<!-- Ads Starts Here -->


<table width="100%" border="0" cellspacing="0" cellpadding="0"   style="border:#c79311 solid 1px;">
<?
//id , jobposition,  skill, responsibility
$sql="SELECT id , jobposition, heading FROM posting p WHERE status ='ACTIVE' AND show_status = 'YES';";
//echo $sql; 
$result=mysql_query($sql);
while(list($id , $jobposition, $heading)=mysql_fetch_array($result))
{
	$heading=str_replace("\n","<br>",$heading);
?>
<tr bgcolor="#c79311" class="text01" height="40"> 
<td class="title1" style="padding-left:10px">
<div align="left" class="title2"> 
<strong ><?=$jobposition;?></strong></div>
</td>
<td align="center"><a href="apply.php?job=<?=$id?>">Apply</a></td>
</tr>
<tr><td class="text01" colspan="2">
<ul ><i>
<?=$heading;?>
</i>
</ul>
</td></tr>
<?
// Check if the Ads has Responsibilities
$sqlCheckResponsibility="SELECT * FROM posting_responsibility WHERE posting_id =$id;";
$resultCheck=mysql_query($sqlCheckResponsibility);
$check=@mysql_num_rows($resultCheck);
if($check>0) {
?>
<tr> 
<td class="text03" colspan="2" style="padding-top:10px; margin-left:10px;" height="30" bgcolor="#FFFFFF"><p style="margin-left:10px;">Responsibilities:</p></td>
</tr>
<tr> 
<td  class="text01" colspan="2"  bgcolor="#FFFFFF">
<ul class="sample">
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
</td>
</tr>
<? }

// Check if the Ads has Requirements
$sqlCheckRequirement="SELECT * FROM posting_requirement WHERE posting_id =$id;";
$resultCheck2=mysql_query($sqlCheckRequirement);
$check2=@mysql_num_rows($resultCheck2);
if($check2>0) {

?>
<tr> 
<td class="text03" colspan="2" height="30" bgcolor="#FFFFFF"><p style="margin-left:10px;">Requirements:</p></td>
</tr>
<tr> 
<td  class="text01" colspan="2"  bgcolor="#FFFFFF">
<ul class="sample">
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
</td>
</tr>
<? }
}
?>




</table>
<!-- Ads Ends Here -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td background="images/line_bottom.gif" bgcolor="#FFFFFF"><div align="left"><img src="images/line_dsyn1.gif" width="61" height="15"></div></td></tr>
</table>
			  </td>
            <td width="220"><div align="right">
                <table width="210" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td valign="top" bgcolor="d8e899"><table width="210" border="0" cellspacing="1" cellpadding="0">
                        <tr> 
                          <td bgcolor="fafdee"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="3">
                              <tr> 
                                <td><img src="images/spacer.gif" width="1" height="10"></td>
                              </tr>
                              <tr> 
                                <td><img src="images/ad_philapplicants.gif" width="205" height="232" border="0" usemap="#MapMapMap">
                                  <map name="MapMapMap">
                                    <area shape="rect" coords="7,187,131,215" href="personal.php">
                                  </map></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                </div></td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>

</td></tr>
<tr><td bgcolor=#333366 height=1></td></tr>
</td></tr></table>
<? include 'footer.php';?>
</body>
</html>
