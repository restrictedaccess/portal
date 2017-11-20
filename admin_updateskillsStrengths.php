<?
include 'config.php';
include 'conf.php';
//$userid=$_SESSION['userid'];
$userid=@$_GET["userid"];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];


if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}


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
<form method="POST" name="frmSkills" action="admin_updateskillsStrengthsphp.php?userid=<?php echo $userid; ?>" onSubmit="return checkFields();">
<input type="hidden" name="userid" value="<? echo $userid;?>">
<table width=100%% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Add a Skill (OPTIONAL)</b></td></tr>
<tr><td colspan=2 >Enter your top skills (e.g. Project Management, Cost Accounting, C++, Oracle8), years of experience and proficiency. Maximum 10 skills allowed. <a href=javascript:popup_win('skillsHelp.php',540,380);>what should I enter?</a></td></tr><tr><td align=right width=30% class=error >Skill :</td>
<td><INPUT maxLength=50 size=30 style='width:220px' class="text" name="skill" value=""></td></tr>
<tr><td align=right width=30% class=error >Years of Experience :</td>
<td>
<select name="experience" style="width:120px;font:8pt, Verdana" >
<option value="-">-</option>
<option value=0.5>Less than 6 months</option>
<option value=0.75>Over 6 months</option>
<option value=1>1 Year</option>
<?php 
	for($i=2;$i<=10;$i++){
		?>
		<option value="<?php echo $i?>"><?php echo $i?> years</option>
		<?php 
	}
?>
<option value="11">More than 10 years</option>
</select>
</td></tr>
<tr><td align=right width=30% class=error >Proficiency :</td>
<td>
<select name="proficiency" style="width:120px;font:8pt, Verdana" >
<option value="-">-</option>
<option value=3 >Advanced</option>
<option value=2 >Intermediate</option>
<option value=1 >Beginner</option>
</select>
</td></tr>
<tr><td><img src='images/space.gif' width=1 height=36></td></tr>
<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value='Save and add more' name="Add" class="button" style="width:220px">&nbsp;&nbsp;
</td></tr>
<tr>
<td align="center">
<!-- skills list -->
<br clear=all><br>

<?
$counter = 0;
$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);

if (@mysql_num_rows($result) >0 )
{
 echo "<table width=98% cellspacing=0 cellpadding=0 align=center>
<tr><td><br><b>Skills Added to Your Resume</b><br><br></td></tr>
<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1>
</td></tr>
<tr><td>


<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='6%' align=center>#</td>
<td width='33%' align=left><b><font size='1'>Skill</font></b></td>
<td width='26%' align=center><b><font size='1'>Experience</font></b></td>
<td width='35%' align=center><b><font size='1'>Level</font></b></td>
<td width='26%' align=center><b><font size='1'>Action</font></b></td>
</tr>";


	$bgcolor="#f5f5f5";
	while(list($id, $skill, $experience, $proficiency) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		
		if($proficiency==1){
			$proficiency="Beginner";
		}
		if($proficiency==2){
			$proficiency="Intermediate";
		}
		if($proficiency==3){
			$proficiency="Advanced";
		}
		
		if ($experience==0.5){
			$experience = "Less than 6 months";
		}else if ($experience==0.75){
			$experience = "Over 6 months";
		}else if ($experience>10){
			$experience = "More than 10 years";
		}else{
			$experience = $experience."yr.";	
		}
		
		
		echo "<tr bgcolor=$bgcolor>
			  <td width='6%' align=center><font size='1'>".$counter.".</font></td>
			  <td width='33%' align=left><font size='1'>".$skill."</font></td>
			  <td width='26%' align=center><font size='1'>".$experience."</font></td>
			  <td width='35%' align=center><font size='1'>".$proficiency."</font></td>
			  <td width='26%' align=center><font size='1'><a href='#' onclick ='go($id); return false;'>delete</a></font></td>
			 </tr>";
			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
	}	
	
echo "</table>
	</td></tr>
	<tr><td bgcolor=#333366 height=1>
	<img src='images/space.gif' height=1 width=1></td></tr></table>";
	
	
}
?>

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
