<?
include 'config.php';
include 'conf.php';
//$userid=$_SESSION['userid'];
$userid=@$_GET["userid"];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];

?>

<html>
<head>
<title>MyProfile &copy; RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<script src="js/insertskill.js"></script>
<script type="text/javascript">
<!--
function checkFields()
{
	
	
	missinginfo = "";
	if (document.frmSkills.skill.value == "")
	{
		missinginfo += "\n     -  Please enter your Skill";
	}
 	// experience
	if (document.frmSkills.experience.selectedIndex ==0)
	{
		missinginfo += "\n     -  Please enter Year(s) of Experience";
	}
	// proficiency
	if (document.frmSkills.proficiency.selectedIndex ==0)
	{
		missinginfo += "\n     -  Please enter Proficiency Level";
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

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="100%" bgcolor="#ffffff" align="center">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
</td></tr>
<tr>
<td width=100% valign=top align=right><img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="" action="admin_relevant_industry_experiencephp.php?userid=<?php echo $userid; ?>">
<input type="hidden" name="userid" value="<? echo $userid;?>">
<table width=100%% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Relevant&nbsp;Industry&nbsp;Experience&nbsp;</b></td></tr>
<td width="50%"><INPUT maxLength=50 size=30 style='width:100%' class="text" name="relevant_experience" value=""></td><td width="50%"><INPUT type="submit" value='Save and add more' name="Add" class="button" style="width:220px"></td></tr>
<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
</td></tr>
<tr>
<td align="center">
<!-- skills list -->
<br clear=all><br>

<table width=98% cellspacing=0 cellpadding=0 align=left>
	<tr><td><br><b>Relevant Industry Experience</b><br><br></td></tr>
	<tr><td bgcolor=#333366 height=1><img src='images/space.gif' height=1 width=1></td></tr>
	<tr><td><br />


<?php
						$queryAllLeads = "SELECT name
							FROM tb_relevant_industry_experience WHERE userid='$userid'
							ORDER BY name ASC;";
						$result = mysql_query($queryAllLeads);
						$counter = 1;
						while(list($name)=mysql_fetch_array($result))
						{
							echo $counter.") ".$name."<br />";
							$counter++;
						}
?>

	</td></tr>
</table>



<!-- --->
</td>
</tr>

</table></td></tr>
</table><br clear=all><br>
</form>
<script language=javascript>
<!--
	function go(id) 
	{
		
			if (confirm("Are you sure you want to delete this skill?")) {
				location.href = "admin_deleteskill2.php?id="+id+"&userid="+<? echo $userid;?>;
				//alert(id);
			}
	}
	
	function insertSkill()
	{
		var skill = document.frmSkills.skill.value;
		var yoe = document.frmSkills.experience.value;
		var pro= document.frmSkills.proficiency.value
		var u= document.frmSkills.userid.value
		insertSkills(skill,yoe,pro,u);
		//alert(skill+yoe+pro+u);
	}

//-->
</script>
</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
</body>
</html>
